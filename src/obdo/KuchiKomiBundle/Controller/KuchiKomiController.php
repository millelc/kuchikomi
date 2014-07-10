<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Form\KuchiKomiType;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use obdo\ServicesBundle\Services\imageLib;

class KuchiKomiController extends Controller {

    public function viewAction($id) {
        $kuchikomi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiKomi')
                ->find($id);

        return $this->render('obdoKuchiKomiBundle:Default:kuchikomiview.html.twig', array(
                    'kuchikomi' => $kuchikomi,
        ));
    }

    public function addAction($id) {
        $Logger = $this->container->get('obdo_services.Logger');
        $msg = '';
        $msgd = '';
        //on recupere le kuchi pour lequel on va créer un kuchikomi
        $kuchi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Kuchi')
                ->find($id);
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
                // on verifie que la date de début est inférieure ou  égale à la date de fin
                if ($kuchikomi->getTimestampEndMs() < $kuchikomi->getTimestampBeginMs()){
                    $msgd = 'La fin ne peut avoir lieu avant le commencement';
                }
                // on verifie si il y a une photo alors detail obligatoire
                if ($kuchikomi->getPhotoimg() != null and $msgd == '') {
                    if ($kuchikomi->getDetails() == null || $kuchikomi->getDetails() == '') {
                        $msg = 'Pour charger une illustration, il faut rédiger un message';
                    }
                }
                
                if ($msg == '' and $msgd == '') {
                    $kuchikomi->setKuchi($kuchi);
                    $kuchikomi->setActive(true);

                    // on traite l'upload de l'image
                    if ($kuchikomi->getPhotoimg() != null) {
                        $photoname = $this->container->get('obdo_services.Name_photo')->newName();
                        $photo = $this->container->get('obdo_services.Picture_uploader')
                                ->upload($kuchikomi->getPhotoimg(), $photodir, $photoname);

                        $kuchikomi->setPhotoLink($photo);
                        
                        list($width, $height, $type, $attr) = getimagesize($photo);
                        if ($width > 640 || $height > 640){
                            $newimage = new imageLib($photo);
                            $newimage->resizeImage(640,640,'crop');
                            $newimage -> saveImage($photo,"50");
                        }
                    }

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($kuchikomi);
                    $em->flush();

                    // on logge l'ajout
                    $Logger->Info("[Kuchi] [user : " . $this->get('security.context')
                                    ->getToken()->getUser()->getUserName() . "] " . $kuchikomi->getTitle() . " added");

                    // et on notifie
                    $this->container->get('obdo_services.Notifier')
                            ->sendKuchiKomiNotification($kuchi, $kuchikomi, "2");

                    return $this->redirect($this->generateUrl('obdo_kuchi_komi_kuchi_view', array(
                                        'id' => $kuchi->getId()
                    )));
                }
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:kuchikomiadd.html.twig', array(
                    'form' => $form->createView(),
                    'Kuchi' => $kuchi,
                    'ErrMsg' => $msg,
                    'ErrMsgd' => $msgd,
        ));
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
