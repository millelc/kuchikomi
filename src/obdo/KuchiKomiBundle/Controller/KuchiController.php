<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;
use obdo\KuchiKomiRESTBundle\Form\KuchiType;
use obdo\KuchiKomiRESTBundle\Form\KuchiUpdateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use obdo\KuchiKomiUserBundle\Controller\AclController;
// pour la gestion des acls
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class KuchiController extends Controller {

    public function indexAction($page, $sort) {
        // on retrouve le role du user pour la requete d'affichage
        $currentroles = $this->getUser()->getRoles();
        $currentrole = $currentroles[0];
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        $kuchis = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi')
                ->getKuchiListByUserId(25, $page, $sort, $userid, $currentrole);

        return $this->render('obdoKuchiKomiBundle:Default:kuchiindex.html.twig', array(
                    'kuchis' => $kuchis,
                    'page' => $page,
                    'nombrePage' => ceil(count($kuchis) / 25),
                    'sort' => $sort
        ));
    }

    public function addAction($groupId) {
        $Logger = $this->container->get('obdo_services.Logger');
        $Password = $this->container->get('obdo_services.Password');

        $kuchi = new Kuchi();
        $kuchiGroup = $this->getDoctrine()->getManager()->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup')->find($groupId);
        $kuchi->setKuchiGroup($kuchiGroup);
        // combien de kuchis autorisés
        $maxkuchi = $kuchiGroup->getNbMaxKuchi();
        // combien de kuchis actifs pour ce groupe
        $countkuchi = $this->getDoctrine()->getManager()->getRepository('obdoKuchiKomiRESTBundle:Kuchi')->getNbKuchiGroup($groupId);
        if ($countkuchi >= $maxkuchi) {
            return $this->render('obdoKuchiKomiBundle:Default:kuchigroupview.html.twig', array(
                    'KuchiGroup' => $kuchiGroup,
                    'message' => 'Le kuchigroup a '.$countkuchi.' kuchis ajout impossible.',
        )); 
        } else {


            $form = $this->createForm(new KuchiType, $kuchi);

            // On récupère la requête
            $request = $this->get('request');

            if ($request->getMethod() == 'POST') {
                $form->bind($request);

                if ($form->isValid()) {
                    // En attendant de passer les champs à Null Allowed
                    if ($kuchi->getAddress()->getAddress2() == null)
                        $kuchi->getAddress()->setAddress2('.');
                    if ($kuchi->getAddress()->getAddress3() == null)
                        $kuchi->getAddress()->setAddress3('.');
                    if ($kuchi->getMailAddress() == null)
                        $kuchi->setMailAddress('@');
                    if ($kuchi->getWebSite() == null)
                        $kuchi->setWebSite('http:');
                    // ajout du lien user kuchi
                    $kuchi->addUser($this->getUser());
                    // ajout du lien super_admin kuchigroup, pour l'instant avec id = 1
                    $admin = $this->getDoctrine()
                            ->getRepository('obdo\KuchiKomiUserBundle\Entity\User')
                            ->find(1);
                    $kuchi->addUser($admin);

                    // Update password
                    $passwordToHash = $kuchi->getPassword();
                    $kuchi->setPassword($Password->generateHash($passwordToHash));
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($kuchi);
                    $em->flush();

                    // Création du répertoire pour stocker les images des KuchiKomis
                    $folder = $this->container->getParameter('path_kuchikomi_photo') . $kuchi->getId();
                    if (!is_dir($folder)) {
                        mkdir($folder);
                    }
                    $kuchi->setPhotoKuchiKomiLink($folder . "/");

                    // Création du répertoire pour stocker le logo et l'image d'un kuchi
                    $folder = $this->container->getParameter('path_kuchi_photo') . $kuchi->getId();
                    if (!is_dir($folder)) {
                        mkdir($folder);
                    }
                    $logo = $this->container->get('obdo_services.Picture_uploader')->upload($kuchi->getLogoimg(), $folder,'');
                    $kuchi->setLogoLink($logo);

                    $photo = $this->container->get('obdo_services.Picture_uploader')->upload($kuchi->getPhotoimg(), $folder,'');
                    $kuchi->setPhotoLink($photo);


                    //$em->persist($kuchi);
                    $em->flush();
                    
                    // retrouve l'identifiant de sécurité de l'utilisateur actuellement connecté
                    $securityContext = $this->get('security.context');
                    $user = $securityContext->getToken()->getUser();
                    // donne accès au propriétaire 
                    AclController::addAcl($kuchi, $user, $this);
                    // et à l'admin
                    AclController::addAcl($kuchi, $admin, $this);

                    $Logger->Info("[Kuchi] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $kuchi->getName() . " added");

                    return $this->redirect($this->generateUrl('obdo_kuchi_komi_kuchi_view', array(
                                        'id' => $kuchi->getId()
                    )));
                }
            }
            return $this->render('obdoKuchiKomiBundle:Default:kuchiadd.html.twig', array(
                        'form' => $form->createView(),
                        'action' => 'Ajouter',
            ));
        }
    }

    public function viewAction($id) {
        $kuchi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Kuchi')
                ->find($id);
        
        //controle droit visu
        $securityContext = $this->get('security.context');

        // check for view access
        if (false === $securityContext->isGranted('VIEW', $kuchi))
        {
            throw new AccessDeniedException();
        }

        return $this->render('obdoKuchiKomiBundle:Default:kuchiview.html.twig', array(
                    'Kuchi' => $kuchi,
        ));
    }

    public function updateAction($id) {
        $Logger = $this->container->get('obdo_services.Logger');
        $Password = $this->container->get('obdo_services.Password');

        $kuchi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Kuchi')
                ->find($id);
        
         $securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('EDIT', $kuchi))
        {
            throw new AccessDeniedException();
        }
        
        if ($kuchi != null) {
            //save avant
            $kuchiname = $kuchi->getName();
            $kuchipass = $kuchi->getPassword();
            $kuchiadress = $kuchi->getAddress();
            $kuchiadd1 = $kuchiadress->getAddress1();
            $kuchiadd2 = $kuchiadress->getAddress2();
            $kuchiadd3 = $kuchiadress->getAddress3();
            $kuchicp = $kuchiadress->getPostalCode();
            $kuchicity = $kuchiadress->getCity();
            $kuchilogo = $kuchi->getLogoLink();
            $kuchiphoto = $kuchi->getPhotoLink();

            $form = $this->createForm(new KuchiUpdateType, $kuchi);
            // On récupère la requête
            $request = $this->get('request');

            if ($request->getMethod() == 'POST') {
                $form->bind($request);

                if ($form->isValid()) {
                    $afaire = 0;

                    if ($kuchi->getName() != null) {
                        if ($kuchi->getName() != $kuchiname) {
                            $afaire = 1;
                        }
                    } else
                        $kuchi->setName($kuchiname);

                    if ($kuchi->getPassword() != null) { // champ mot de passe pas vide
                        
                        $passwordHash = $Password->generateHash($kuchi->getPassword());                            
                        $kuchi->setPassword($passwordHash);
                        $afaire = 1;
                         
                    } else
                        $kuchi->setPassword($kuchipass);

                    $kuchinewadress = $kuchi->getAddress();
                    if ($kuchinewadress != null) {
                        $kuchinewadd1 = $kuchiadress->getAddress1();
                        $kuchinewadd2 = $kuchiadress->getAddress2();
                        $kuchinewadd3 = $kuchiadress->getAddress3();
                        $kuchinewcp = $kuchiadress->getPostalCode();
                        $kuchinewcity = $kuchiadress->getCity();
                        if ($kuchinewadd1 != $kuchiadd1 || $kuchinewadd2 != $kuchiadd2 || $kuchinewadd3 != $kuchiadd3 || $kuchinewcp != $kuchicp || $kuchinewcity != $kuchicity) {
                            $afaire = 1;
                        }
                    } else
                        $kuchi->setAddress($kuchiadress);

                    $folder = $this->container->getParameter('path_kuchi_photo') . $kuchi->getId();
                    if ($kuchi->getLogoimg() != null) {
                        // on efface l'ancien fichier avant l'upload
                        if ($kuchilogo != null) {
                            unlink($kuchilogo);
                        }
                        $logo = $this->container->get('obdo_services.Picture_uploader')->upload($kuchi->getLogoimg(), $folder,'');
                        $kuchi->setLogoLink($logo);
                        $afaire = 1;
                    }
                    if ($kuchi->getPhotoimg() != null) {
                        // on efface l'ancien fichier avant l'upload
                        if ($kuchiphoto != null) {
                            unlink($kuchiphoto);
                        }
                        $photo = $this->container->get('obdo_services.Picture_uploader')->upload($kuchi->getPhotoimg(), $folder,'');
                        $kuchi->setPhotoLink($photo);
                        $afaire = 1;
                    }

                    if ($afaire == 1) {
                        $em = $this->getDoctrine()->getManager();
                        $em->flush();
                        $Logger->Info("[KuchiGroup] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $kuchi->getName() . " updated");
                        return $this->render('obdoKuchiKomiBundle:Default:kuchiview.html.twig', array(
                                    'Kuchi' => $kuchi,
                        ));
                    }
                }
            }
            return $this->render('obdoKuchiKomiBundle:Default:kuchiadd.html.twig', array(
                        'form' => $form->createView(),
                        'kuchi' => $kuchi,
                        'action' => 'Modifier',
            ));
        } else
            return $this->render('obdoKuchiKomiBundle:Default:kuchiview.html.twig', array(
                        'Kuchi' => $kuchi,
            ));
    }

}
