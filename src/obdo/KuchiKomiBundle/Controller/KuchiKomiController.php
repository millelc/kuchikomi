<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent;
use obdo\KuchiKomiRESTBundle\Form\KuchiKomiType;
use obdo\KuchiKomiRESTBundle\Form\KuchiKomiRecurrentType;
use obdo\KuchiKomiRESTBundle\Form\KuchiKomiUpdateType;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use obdo\ServicesBundle\Services\imageLib;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\HttpFoundation\Response;

class KuchiKomiController extends Controller {

    public function viewAction($id)             
    {
        $kuchikomi = $this->getDoctrine()
                          ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiKomi')
                          ->find($id);
        
        if( !$kuchikomi )
        {
            $Logger = $this->container->get('obdo_services.Logger');
            $Logger->Error("[WEB-VIEW kuchikomi] KuchiKomi id=" . $id . " unknown...");
            return $this->redirect($this->generateUrl('obdo_kuchi_komi_homepage'));
        }
        else 
        {
            //Check access control
            $securityContext = $this->get('security.context');
            if (false == $securityContext->isGranted('VIEW', $kuchikomi))
            {
                throw new AccessDeniedException();
            }

    return $this->render('obdoKuchiKomiBundle:Default:kuchikomiview.html.twig', array('kuchikomi' => $kuchikomi));
            }
        }
    
//    public function changeFormAction(\Symfony\Component\HttpFoundation\Request $request) {
//        $data = $request->request->all();
//        return $this->render('obdoKuchiKomiBundle:Default:kuchikomiaddrecurrence.html.twig');
//    }

    public function addAction($id) 
    {
        $Logger = $this->container->get('obdo_services.Logger');
        $AclManager = $this->container->get('obdo_services.AclManager');

        $kuchi = null;
        $Dispatcher = $this->container->get('citykomi.async_events.dispatcher');
                
        $error = FALSE;
        $securityContext = $this->get('security.context');
            
        // id = 0 pour un nouveau kuchikomi sans kuchi renseigné au préalable
        if($id!='0'){
            
            $kuchi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Kuchi')
                ->find($id);
        
        //Check access control
                     
            if (false == $securityContext->isGranted('EDIT', $kuchi))
                 {
                 throw new AccessDeniedException();
                 }
        }
        $iduser = $securityContext->getToken()->getUser()->getId();        
        $kuchikomi = new KuchiKomi();
        
        if($id==='0'){            
            $form = $this->createForm(new KuchiKomiType($iduser), $kuchikomi);
            } 
        else{
            $option = array('kuchi'=>'Oui'); 
            $kuchikomi->setKuchi($kuchi);
            $form = $this->createForm(new KuchiKomiType($iduser), $kuchikomi, $option);
                }
        // On récupère la requête
        $request = $this->get('request');
        

                if ($request->getMethod() == 'POST') {
                $form->bind($request);
                // récupérer le kuchikomi hydraté !

                    if ($form->isValid()) 
                        {                                      
                        $error = $this->processKuchikomi($kuchikomi);
                
                        if (!$error) 
                        {
                            // Add Acl for the object (SUPER_ADMIN + GROUP_ADMIN + CURRENT USER)
                             foreach($kuchikomi->getKuchi()->getUsers() as $user)
                             {
                                $AclManager->addAcl($kuchikomi, $user);
                            }
                            foreach($kuchikomi->getKuchi()->getKuchiGroup()->getUsers() as $user)
                            {
                                $AclManager->addAcl($kuchikomi, $user);
                            }

                        // on logge l'ajout
                        $Logger->Info("[KuchiKomi] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $kuchikomi->getTitle() . " added");

                   // et on notifie
                        $Dispatcher->sendKuchikomiNotificationAsyncEvent($kuchikomi->getKuchi(), $kuchikomi, "2");
                    
                    return $this->render('obdoKuchiKomiBundle:Default:kuchikomiview.html.twig', array(
                                'kuchikomi' => $kuchikomi,
                    ));

                    }   
                }
            }
        return $this->render('obdoKuchiKomiBundle:Default:kuchikomiadd.html.twig', array('form' => $form->createView(),'Kuchi' => $kuchi));
        
    } 
    
    
    public function deleteAction($id) 
    {
        
        $Logger = $this->container->get('obdo_services.Logger');
        $Dispatcher = $this->container->get('citykomi.async_events.dispatcher');
        
        $kuchikomi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiKomi')
                ->find($id);
        
        if( !$kuchikomi )
        {
            $Logger->Error("[WEB-DELETE kuchikomi] KuchiKomi id=" . $id . " unknown...");
            return $this->redirect($this->generateUrl('obdo_kuchi_komi_homepage'));
        }
        else 
        {
            //Check access control
            $securityContext = $this->get('security.context');
            if (false == $securityContext->isGranted('DELETE', $kuchikomi))
            {
                throw new AccessDeniedException();
            }

            $kuchikomi->setTimestampSuppression(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $kuchikomi->setActive(false);

            $this->getDoctrine()->getManager()->flush();
            
            $kuchi = $kuchikomi->getKuchi();
            $Dispatcher->sendKuchikomiNotificationAsyncEvent($kuchi, $kuchikomi, "3");
            $this->get('session')->getFlashBag()->add('error', 'Le kuchikomi a été supprimé !');
            return $this->render('obdoKuchiKomiBundle:Default:kuchikomiview.html.twig', array(
                                'kuchikomi' => $kuchikomi,
            ));
        }
    }

    public function updateAction($id) 
    {
        $Logger = $this->container->get('obdo_services.Logger');
        $Password = $this->container->get('obdo_services.Password');
        $Dispatcher = $this->container->get('citykomi.async_events.dispatcher');
        $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $kuchikomi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiKomi')
                ->find($id);
        
        if($kuchikomi->getActive()){    
        
            if ($kuchikomi != null) 
            {
                $securityContext = $this->get('security.context');
                $kuchi = $kuchikomi->getKuchi();

                $kuchikomiPhoto = $kuchikomi->getPhotoLink();

                // check for edit access
                if (false === $securityContext->isGranted('EDIT', $kuchikomi))
                {
                    throw new AccessDeniedException();
                }


                $form = $this->createForm(new KuchiKomiUpdateType, $kuchikomi);

                // On récupère la requête
                $request = $this->get('request');

                if ($request->getMethod() == 'POST') 
                {
                    $form->bind($request);

                    if ($form->isValid()) 
                    {
                        $error = $this->processKuchikomi($kuchikomi, $kuchikomiPhoto);

                        if (!$error) 
                        {
                            // on logge l'update
                            $Logger->Info("[KuchiKomi] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $kuchikomi->getTitle() . " updated");

                            // et on notifie
                            $Dispatcher->sendKuchikomiNotificationAsyncEvent($kuchi, $kuchikomi, "2");

                            $this->get('session')->getFlashBag()->add('success', 'Le kuchikomi a été mis à jour avec succès !');

                            return $this->render('obdoKuchiKomiBundle:Default:kuchikomiview.html.twig', array(
                                                'kuchikomi' => $kuchikomi,
                            ));                    
                        }

                    }
                }
                
            return $this->render('obdoKuchiKomiBundle:Default:kuchikomiupdate.html.twig', array(
                        'form' => $form->createView(),
                        'Kuchi' => $kuchikomi->getKuchi(),
                        'kuchikomi' => $kuchikomi
            ));

            } else
            {
                $this->get('session')->getFlashBag()->add('error',"Ce kuchikomi n'existe pas !");
                return $this->render('obdoKuchiKomiBundle:Dashboard:index');

            }
            
        } else {
        $this->get('session')->getFlashBag()->add('error',"Ce kuchikomi a été supprimé !");
        return $this->render('obdoKuchiKomiBundle:Default:kuchikomiview.html.twig', array(
                                            'kuchikomi' => $kuchikomi));
        }
    }

    
    /**
     * 
     * @param KuchiKomi ou KuchiKomiRecurrent $kuchikomi
     * @param type $oldKuchikomiPhoto
     * @return boolean
     */
    private function processKuchikomi($kuchikomi, $oldKuchikomiPhoto = null)
    {
        $error = FALSE;
        
        // et on prepare le chemin du repertoire pour l'image
        if($kuchikomi instanceof KuchiKomiRecurrent){
            $photodir= $this->container->getParameter('path_kuchikomirecurrent_photo').$kuchikomi->getKuchi()->getId().'/';    
            
            if($kuchikomi->getRecurrence()=='unique'){
                $kuchikomi->setEndRecurrence($kuchikomi->getEndFirstTime());
            }
        } else {
            $photodir = $kuchikomi->getKuchi()->getPhotoKuchiKomiLink();
        }
        
        if ($kuchikomi->getDetails() == null)
        {
            $kuchikomi->setDetails("");
        }

        if ($kuchikomi->getPhotoimg() != null) 
        {
            if ($kuchikomi->getDetails() == null || $kuchikomi->getDetails() == '') 
            {
                $error = TRUE;
                $this->get('session')->getFlashBag()->add('danger', 'Pour charger une photo, un message doit être rédigé ...');
            }        
        }

        if (!$error) 
        {

            $kuchikomi->setActive(true);
            
            
            if($kuchikomi->getDeletePhoto())
            {
                $this->deletePhoto($kuchikomi, $oldKuchikomiPhoto);
            }
            else 
            {
                // on traite l'upload de la nouvelle photo
                if ($kuchikomi->getPhotoimg() != null) 
                {
                    $this->deletePhoto($kuchikomi, $oldKuchikomiPhoto);
                    
                    $photoname = $this->container->get('obdo_services.Name_photo')->newName();
                    
                    $photo = $this->container->get('obdo_services.Picture_uploader')
                            ->upload($kuchikomi->getPhotoimg(), $photodir, $photoname);

                    $kuchikomi->setPhotoLink($photo);
                    $newimage = new imageLib($photo);
                    $newimage->resizeImage(640,640,'crop');
                    $newimage->saveImage($photo,"30");
                }                
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($kuchikomi);
            $em->flush();
        }
        
        return $error;
    }        
    
    private function deletePhoto($kuchikomi, $oldKuchikomiPhoto)
    {
        // on efface l'ancien fichier avant l'upload
        if ($oldKuchikomiPhoto != null) 
        {
            try
            { 
                $kuchikomi->resetPhotoLink();
                unlink($oldKuchikomiPhoto);
            }
            catch (\Exception $e)
            {
              //juste au cas ou le fichier n'existe pas  
            }
        }
    }
    
        public function viewrecurrentAction($id) 
    {
        $kuchikomirecurrent = $this->getDoctrine()
                          ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent')
                          ->find($id);
        
        if( !$kuchikomirecurrent )
        {
            $Logger = $this->container->get('obdo_services.Logger');
            $Logger->Error("[WEB-VIEW kuchikomi] KuchiKomi id=" . $id . " unknown...");
            return $this->redirect($this->generateUrl('obdo_kuchi_komi_homepage'));
        }
        else 
        {
            //Check access control
            $securityContext = $this->get('security.context');
            if (false == $securityContext->isGranted('VIEW', $kuchikomirecurrent))
            {
                throw new AccessDeniedException();
            }

            return $this->render('obdoKuchiKomiBundle:Default:kuchikomirecurrentview.html.twig', array('kuchikomirecurrent' => $kuchikomirecurrent));
        }        
    }
    
        public function addrecurrentAction (){
            
            
        $Logger = $this->container->get('obdo_services.Logger');        
        $AclManager = $this->container->get('obdo_services.AclManager');
        $iduser = $this->get('security.context')->getToken()->getUser()->getId();                     
        
        // on cree l'entite vide
        $kuchikomiRecurr = new KuchiKomiRecurrent();
        $form = $this->createForm(new KuchiKomiRecurrentType($iduser), $kuchikomiRecurr);
        
        
         $request=  $this->get('request');
         
         if($request->getMethod()=='POST'){
             $form->bind($request);
             
             if($form->isValid()){
                 $error = $this->processKuchikomi($kuchikomiRecurr);
                 if(!$error)
                        {                     
                        foreach($kuchikomiRecurr->getKuchi()->getUsers() as $user)
                        {                        
                           $AclManager->addAcl($kuchikomiRecurr, $user);
                        }
                        foreach($kuchikomiRecurr->getKuchi()->getKuchiGroup()->getUsers() as $user)
                        {
                            $AclManager->addAcl($kuchikomiRecurr, $user);
                        }                    
                        return $this->render('obdoKuchiKomiBundle:Default:kuchikomirecurrentview.html.twig', array('kuchikomirecurrent' => $kuchikomiRecurr));
                        }                      
                }
         }
                  
            
        return $this->render('obdoKuchiKomiBundle:Default:kuchikomiaddrecurrence.html.twig', array('form' => $form->createView()));

    }
    
        public function updaterecurrentAction ($id){
            
            
        $Logger = $this->container->get('obdo_services.Logger');        
        $AclManager = $this->container->get('obdo_services.AclManager');
        $iduser = $this->get('security.context')->getToken()->getUser()->getId();  
        $kuchikomiRecurr = $this->getDoctrine()->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent')->find($id);
        
        // on cree l'entite vide
        $form = $this->createForm(new KuchiKomiRecurrentType($iduser), $kuchikomiRecurr,array('idkuchi'=>$kuchikomiRecurr->getKuchi()));
        
        $securityContext = $this->get('security.context');
        if (false == $securityContext->isGranted('EDIT', $kuchikomiRecurr->getKuchi()))
            {
            throw new AccessDeniedException();
            }
            
         $request=  $this->get('request');
         
         if($request->getMethod()=='POST'){
             $form->bind($request);
             
             if($form->isValid()){
                 $error = $this->processKuchikomi($kuchikomiRecurr,$kuchikomiRecurr->getPhotoLink());                 
                    if (!$error) 
                    {
                        $kuchikomiRecurr->setDateTimeLastUpdate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
                        $this->getDoctrine()->getManager()->flush();
                        
                        $Logger->Info("[KuchiKomiRecurrent] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $kuchikomiRecurr->getTitle() . " updated");
                                                
                        $this->get('session')->getFlashBag()->add('success', 'Le kuchikomi récurrent a été mis à jour avec succès !');
                        
                        return $this->render('obdoKuchiKomiBundle:Default:kuchikomirecurrentview.html.twig', array(
                                            'kuchikomirecurrent' => $kuchikomiRecurr,
                        ));
                    }                      
                }
         }
         
         
            
        return $this->render('obdoKuchiKomiBundle:Default:kuchikomiaddrecurrence.html.twig', array('form' => $form->createView(), 'kuchikomirecurrent'=>$kuchikomiRecurr));

    }
    
        public function deleterecurrentAction($id) 
    {
        $Logger = $this->container->get('obdo_services.Logger');
        $Dispatcher = $this->container->get('citykomi.async_events.dispatcher');
        
        $kuchikomirRecurr = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent')
                ->find($id);
        
        if( !$kuchikomirRecurr )
        {
            $Logger->Error("[WEB-DELETE kuchikomirecurrent] KuchiKomiRecurrent id=" . $id . " unknown...");
            return $this->redirect($this->generateUrl('obdo_kuchi_komi_homepage'));
        }
        else 
        {
            //Check access control
            $securityContext = $this->get('security.context');
            if (false == $securityContext->isGranted('DELETE', $kuchikomirRecurr))
            {
                throw new AccessDeniedException();
            }

            $kuchikomirRecurr->setDateTimeSuppression(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $kuchikomirRecurr->setActive(false);

            $this->getDoctrine()->getManager()->flush();                                    
            
            $this->get('session')->getFlashbag()->add("Le Kuchikomi recurrent n°".$kuchikomirRecurr->getId()." a bien été supprimé");
            
            return $this->render('obdoKuchiKomiBundle:Default:kuchikomirecurrentview.html.twig', array('kuchikomirecurrent' => $kuchikomirecurrent));

        }
    }
    
    

}
    

