<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Form\KuchiKomiType;
use obdo\KuchiKomiRESTBundle\Form\KuchiKomiUpdateType;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use obdo\ServicesBundle\Services\imageLib;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    public function addAction($id) 
    {
        $Logger = $this->container->get('obdo_services.Logger');
        $AclManager = $this->container->get('obdo_services.AclManager');
        $Dispatcher = $this->container->get('citykomi.async_events.dispatcher');
                
        $error = FALSE;
        
        //on recupere le kuchi pour lequel on va créer un kuchikomi
        $kuchi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Kuchi')
                ->find($id);
        
        //Check access control
        $securityContext = $this->get('security.context');
        if (false == $securityContext->isGranted('EDIT', $kuchi))
        {
            throw new AccessDeniedException();
        }

        
        // on cree l'entite vide
        $kuchikomi = new KuchiKomi();
        $form = $this->createForm(new KuchiKomiType, $kuchikomi);

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                
                $error = $this->processKuchikomi($kuchi, $kuchikomi);
                
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
                    $Dispatcher->sendKuchikomiNotificationAsyncEvent($kuchi, $kuchikomi, "2");
                    
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

        $kuchikomi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiKomi')
                ->find($id);
        
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
                    $error = $this->processKuchikomi($kuchi, $kuchikomi, $kuchikomiPhoto);
                    
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
        } 
        else
        {
            return $this->render('obdoKuchiKomiBundle:Dashboard:index');
        }
    }

    private function processKuchikomi($kuchi, $kuchikomi, $oldKuchikomiPhoto = null)
    {
        $error = FALSE;
        
        // et on prepare le chemin du repertoire pour l'image
        $photodir = $kuchi->getPhotoKuchiKomiLink();

        if ($kuchikomi->getDetails() == null)
        {
            $kuchikomi->setDetails("");
        }

        // on verifie que la date de début est inférieure ou  égale à la date de fin
        if ($kuchikomi->getTimestampEndMs() < $kuchikomi->getTimestampBeginMs())
        {
            $error = TRUE;
            $this->get('session')->getFlashBag()->add('danger', 'La date de fin doit être supérieure à la date de début ...');

        }
        // on verifie si il y a une photo alors detail obligatoire
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
            $kuchikomi->setKuchi($kuchi);
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
}
