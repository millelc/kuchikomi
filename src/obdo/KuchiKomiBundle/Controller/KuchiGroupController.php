<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;
use obdo\KuchiKomiRESTBundle\Form\KuchiGroupType;
use obdo\KuchiKomiRESTBundle\Form\KuchiGroupUpdateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KuchiGroupController extends Controller {

    public function indexAction($page, $sort) {
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup')->getGroups(25, $page, $sort);

        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupindex.html.twig', array(
                    'groups' => $groups,
                    'page' => $page,
                    'nombrePage' => ceil(count($groups) / 25),
                    'sort' => $sort
        ));
    }

    public function viewAction($id) {
        $kuchiGroup = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiGroup')
                ->find($id);

        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupview.html.twig', array(
                    'KuchiGroup' => $kuchiGroup,
        ));
    }

    public function addAction() {
        $Logger = $this->container->get('obdo_services.Logger');

        $kuchiGroup = new KuchiGroup();

        $form = $this->createForm(new KuchiGroupType, $kuchiGroup);

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($kuchiGroup);
                $em->flush();

                // Création du répertoire pour stocker les images des KuchiKomis
                $folder = $this->container->getParameter('path_kuchigroup_photo') . $kuchiGroup->getId();
                if (!is_dir($folder)) {
                    mkdir($folder);
                }
                $logo = $this->container->get('obdo_services.Picture_uploader')->upload($kuchiGroup->getLogoimg(), $folder);
                $kuchiGroup->setLogo($logo);
                $em->persist($kuchiGroup);
                $em->flush();

                $Logger->Info("[KuchiGroup] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $kuchiGroup->getName() . " added");

                return $this->redirect($this->generateUrl('obdo_kuchi_komi_kuchi_group_view', array(
                                    'id' => $kuchiGroup->getId()
                )));
            }
        }

        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupadd.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function updateAction($id) {
        $Logger = $this->container->get('obdo_services.Logger');

        $kuchiGroup = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiGroup')
                ->find($id);

        //on sauvegarde avant modif
        $kuchiGroupname = $kuchiGroup->getName();
        $kuchiGroupNbmax = $kuchiGroup->getNbMaxKuchi();
        $kuchiGroupImage = $kuchiGroup->getLogo();

        $form = $this->createForm(new KuchiGroupUpdateType, $kuchiGroup);
        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $afaire = 0;
                
                if ($kuchiGroup->getName() != null) {
                    if ($kuchiGroup->getName() != $kuchiGroupname) {
                        $afaire = 1;
                    }
                } else
                    $kuchiGroup->setName($kuchiGroupname);
                
                if ($kuchiGroup->getNbMaxKuchi() >0 && $kuchiGroup->getNbMaxKuchi() != null){
                    if ($kuchiGroup->getNbMaxKuchi() != $kuchiGroupNbmax){
                        $afaire = 1;
                    }
                } else
                    $kuchiGroup->setNbMaxKuchi($kuchiGroupNbmax);
                
                //logo si pas vide c'est qu'on uploade un nouveau fichier
                
                if ($kuchiGroup->getLogoimg() != null) {
                    // on efface l'ancien fichier avant l'upload
                    if ($kuchiGroupImage != null){
                          unlink($kuchiGroupImage);
                    }                  
                    $folder = $this->container->getParameter('path_kuchigroup_photo') . $kuchiGroup->getId();
                    $logo = $this->container->get('obdo_services.Picture_uploader')->upload($kuchiGroup->getLogoimg(), $folder);
                    $kuchiGroup->setLogo($logo);
                    $afaire = 1;
                }
                if ($afaire == 1) {
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    $Logger->Info("[KuchiGroup] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $kuchiGroup->getName() . " updated");
                    return $this->render('obdoKuchiKomiBundle:Default:kuchigroupview.html.twig', array(
                                'KuchiGroup' => $kuchiGroup,
                    ));
                }
            }
        }
        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupupdate.html.twig', array(
                    'form' => $form->createView(),
                    'kuchiGroup' => $kuchiGroup,
        ));
    }

}
