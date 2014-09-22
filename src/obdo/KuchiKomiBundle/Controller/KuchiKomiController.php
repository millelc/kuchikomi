<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Form\KuchiKomiType;
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

        // et on prepare le chemin du repertoire pour l'image
        $photodir = $kuchi->getPhotoKuchiKomiLink();

        // on cree l'entite vide
        $kuchikomi = new KuchiKomi();
        $form = $this->createForm(new KuchiKomiType, $kuchikomi);

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                
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

                    // on traite l'upload de l'image
                    if ($kuchikomi->getPhotoimg() != null) 
                    {
                        $photoname = $this->container->get('obdo_services.Name_photo')->newName();
                        $photo = $this->container->get('obdo_services.Picture_uploader')
                                ->upload($kuchikomi->getPhotoimg(), $photodir, $photoname);

                        $kuchikomi->setPhotoLink($photo);
                        $newimage = new imageLib($photo);
                        $newimage->resizeImage(640,640,'crop');
                        $newimage->saveImage($photo,"30");
                    }

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($kuchikomi);
                    $em->flush();
                    
                    // Add Acl for the object (SUPER_ADMIN + GROUP_ADMIN + CURRENT USER)
                    $securityContext = $this->get('security.context');
                    $userAdmin = $this->getDoctrine()->getRepository('obdo\KuchiKomiUserBundle\Entity\User')->find(1);
                    $userCurrent = $securityContext->getToken()->getUser();
                    $AclManager->addAcl($kuchikomi, $userAdmin);
                    $AclManager->addAcl($kuchikomi, $userCurrent);
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
                    $this->container->get('obdo_services.Notifier')->sendKuchiKomiNotification($kuchi, $kuchikomi, "2");

                    return $this->redirect($this->generateUrl('obdo_kuchi_komi_kuchi_view', array('id' => $kuchi->getId())));
                }
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:kuchikomiadd.html.twig', array('form' => $form->createView(),'Kuchi' => $kuchi));
    }
    
    public function deleteAction($id) 
    {
        $Logger = $this->container->get('obdo_services.Logger');
        
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
            
            $kuchi = $this->getDoctrine()
                          ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Kuchi')
                          ->find($kuchikomi->getKuchiId());
            $this->container->get('obdo_services.Notifier')
                            ->sendKuchiKomiNotification($kuchi, $kuchikomi, "3");
            
            return $this->redirect($this->generateUrl('obdo_kuchi_komi_kuchi_view', array(
                    'id' => $kuchi->getId()
            )));
        }
    }


}
