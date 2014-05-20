<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;
use obdo\KuchiKomiRESTBundle\Form\KuchiGroupType;
use obdo\KuchiKomiRESTBundle\Form\KuchiGroupUpdateType;
use obdo\KuchiKomiUserBundle\Controller\AclController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// pour la gestion des acls
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class KuchiGroupController extends Controller {
    /*
     * indexAction
     * point entrée gestion kuchigroup
     */

    public function indexAction($page, $sort) {
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup')
        ->getGroupListByUserId(25, $page, $sort, $this->getUser()->getId());

        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupindex.html.twig', array(
                    'groups' => $groups,
                    'page' => $page,
                    'nombrePage' => ceil(count($groups) / 25),
                    'sort' => $sort
        ));
    }

    /*
     * viewAction
     * affichage detail kuchigroup
     */

    public function viewAction($id) {
        $kuchiGroup = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiGroup')
                ->find($id);
        
        //controle droit visu
        $securityContext = $this->get('security.context');

        // check for view access
        if (false === $securityContext->isGranted('VIEW', $kuchiGroup))
        {
            throw new AccessDeniedException();
        }
        
        $hidden = $this->btnafficheAddKomi($kuchiGroup, $id);
        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupview.html.twig', array(
                    'KuchiGroup' => $kuchiGroup,
                    'Btncache' => $hidden,
        ));
    }

    /*
     * addAction
     * ajout d'un kuchigroup
     */

    public function addAction() {
        $Logger = $this->container->get('obdo_services.Logger');

        $kuchiGroup = new KuchiGroup();

        $form = $this->createForm(new KuchiGroupType, $kuchiGroup);

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // ajout du lien user kuchigroup
                $kuchiGroup->addUser($this->getUser());
                // ajout du lien super_admin kuchigroup, pour l'instant avec id = 1
                $admin = $this->getDoctrine()
                        ->getRepository('obdo\KuchiKomiUserBundle\Entity\User')
                        ->find(1);
                $kuchiGroup->addUser($admin);

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

                $em->flush();

                // retrouve l'identifiant de sécurité de l'utilisateur actuellement connecté
                $securityContext = $this->get('security.context');
                $user = $securityContext->getToken()->getUser();
                // donne accès au propriétaire 
                AclController::addAcl($kuchiGroup, $user, $this);
                // et à l'admin
                AclController::addAcl($kuchiGroup, $admin, $this);
                
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

    /*
     * updateAction
     * mise à jour d'un kuchigroup
     */

    public function updateAction($id) {
        $Logger = $this->container->get('obdo_services.Logger');

        $kuchiGroup = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiGroup')
                ->find($id);
        
        $securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('EDIT', $kuchiGroup))
        {
            throw new AccessDeniedException();
        }
        
        if ($kuchiGroup != null) {
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

                    if ($kuchiGroup->getNbMaxKuchi() > 0 && $kuchiGroup->getNbMaxKuchi() != null) {
                        if ($kuchiGroup->getNbMaxKuchi() != $kuchiGroupNbmax) {
                            $afaire = 1;
                        }
                    } else
                        $kuchiGroup->setNbMaxKuchi($kuchiGroupNbmax);

                    //logo si pas vide c'est qu'on uploade un nouveau fichier

                    if ($kuchiGroup->getLogoimg() != null) {
                        // on efface l'ancien fichier avant l'upload
                        if ($kuchiGroupImage != null) {
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
                        $hidden = $this->btnafficheAddKomi($kuchiGroup, $id);
                        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupview.html.twig', array(
                                    'KuchiGroup' => $kuchiGroup,
                                    'Btncache' => $hidden,
                        ));
                    }
                }
            }

            return $this->render('obdoKuchiKomiBundle:Default:kuchigroupupdate.html.twig', array(
                        'form' => $form->createView(),
                        'kuchiGroup' => $kuchiGroup,
            ));
        } else {
            $this->indexAction(1, 'active_up');
        }
    }

    /*
     * activAction
     * (re)activation/desactivation d'un kuchigroup plus cascade jusqu'au komi
     */

    public function activAction($id) {
        $cpt = 0;
        $akomi = array();

        $em = $this->getDoctrine()->getManager();

        $Logger = $this->container->get('obdo_services.Logger');

        $kuchiGroup = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiGroup')
                ->find($id);
        
        $securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('EDIT', $kuchiGroup))
        {
            throw new AccessDeniedException();
        }

        $newactive = !$kuchiGroup->getActive();
        // maj de KuchiGroup
        $kuchiGroup->setActive($newactive);
        // maj groupe(s) subscription
        $scgroup = $kuchiGroup->getSubscriptions();
        foreach ($scgroup as $scg) {
            $scg->setActive($newactive);
            //on memorise le komi si pas déjà fait
            if (!in_array($scg->getKomi(), $akomi, true)) {
                $akomi[$cpt] = $scg->getKomi();
                $cpt += 1;
            }
        }
        // maj des kuchi
        $kuchi = $kuchiGroup->getKuchis();
        foreach ($kuchi as $kc) {
            $kc->setActive($newactive);
            // maj des subscriptions
            $subscription = $kc->getSubscriptions();
            foreach ($subscription as $sc) {
                $sc->setActive($newactive);
                //on memorise le komi si pas déjà fait
                if (!in_array($sc->getKomi(), $akomi, true)) {
                    $akomi[$cpt] = $sc->getKomi();
                    $cpt += 1;
                }
            }
            // maj des kuchikomis
            $kuchikomis = $kc->getKuchikomis();
            foreach ($kuchikomis as $kuchikomi) {
                $kuchikomi->setActive($newactive);
            }
        }

        // il faut mettre à jour les tables avant de traiter les komis
        $em->flush();

        //2 cas si on (re)active, il faut (re)activer le komi, si on désactive, il faut verifier avant 
        // de désactiver le komi qu'il n'est pas abonné a un kushi actif.
//pas pour l'instant        
//        $traitekomi = 0;
//        foreach ($akomi as $komi) {
//            if (!$newactive) {
//                // on verifie si le komi est abonné a des subscriptions actives
//                $traitekomi = $em->getRepository('obdoKuchiKomiRESTBundle:Subscription')->getNbSubKomiActive($komi);
//
//                if ($traitekomi == 0) {
//                    // si le komi n'a pas de subscriptions actives, on verifie les groupes de subscriptions
//                    $traitekomi = $em->getRepository('obdoKuchiKomiRESTBundle:SubscriptionGroup')->getNbSubGrpKomiActive($komi);
//                }
//            }
//
//            if ($traitekomi == 0) {
//                $komi->setActive($newactive);
//                $em->flush(); // màj dans la foulée
//            }
//        }
        $Logger->Info("[KuchiGroup] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $kuchiGroup->getName() . " (d)actived");
        $hidden = $this->btnafficheAddKomi($kuchiGroup, $id);
        return $this->render('obdoKuchiKomiBundle:Default:kuchigroupview.html.twig', array(
                    'KuchiGroup' => $kuchiGroup,
                    'Btncache' => $hidden,
        ));
    }

    /*
     * deleteAction
     * delete d'un kuchigroup plus cascade jusqu'au thanks
     */

    public function deleteAction($id) {
        $cpt = 0;
        $cptr = 1;
        $akomi = array(); //pour memoriser les komis
        $repertoire = array(); // pour memoriser les repertoires à effacer

        $em = $this->getDoctrine()->getManager();

        $Logger = $this->container->get('obdo_services.Logger');

        $kuchiGroup = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiGroup')
                ->find($id);
        $securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('DELETE', $kuchiGroup))
        {
            throw new AccessDeniedException();
        }
        //on controle que le kuchigroup est desactivé, pas de delete sinon
        $kgactive = $kuchiGroup->getActive();
        if (!$kgactive) {
            //on indique à doctrine que l'on veut effacer le groupe
            $em->remove($kuchiGroup);
            $repertoire[0] = $this->container->getParameter('path_kuchigroup_photo') . $kuchiGroup->getId();
            // traitement groupe(s) subscription
            $scgroup = $kuchiGroup->getSubscriptions();
            foreach ($scgroup as $scg) {
                //on indique à doctrine que l'on veut effacer le groupe
                $em->remove($scg);
                //on memorise le komi si pas déjà fait
                if (!in_array($scg->getKomi(), $akomi, true)) {
                    $akomi[$cpt] = $scg->getKomi();
                    $cpt += 1;
                }
            }
            // traitement des kuchi
            $kuchi = $kuchiGroup->getKuchis();
            foreach ($kuchi as $kc) {
                //on indique à doctrine que l'on veut effacer le 'kuchi'
                $em->remove($kc);
                // on memorise le repertoire des images du kuchi
                $repertoire[$cptr] = $this->container->getParameter('path_kuchi_photo') . $kc->getId();
                $cptr += 1;
                // traitement des subscriptions
                $subscription = $kc->getSubscriptions();
                foreach ($subscription as $sc) {
                    //on indique à doctrine que l'on veut effacer la 'subscription'
                    $em->remove($sc);
                    //on memorise le komi si pas déjà fait
                    if (!in_array($sc->getKomi(), $akomi, true)) {
                        $akomi[$cpt] = $sc->getKomi();
                        $cpt += 1;
                    }
                }
                // traitement des kuchikomis
                $kuchikomis = $kc->getKuchikomis();
                foreach ($kuchikomis as $kuchikomi) {
                    //on indique à doctrine que l'on veut effacer le 'kuchikomi'
                    $em->remove($kuchikomi);
                    // on memorise le repertoire des images du kuchikomi
                    $repertoire[$cptr] = $this->container->getParameter('path_kuchikomi_photo') . $kuchikomi->getId();
                    $cptr += 1;
                    //et ontraite les thanks
                    $this->effaceThanks($kuchikomi);
                }
            }
            // il faut mettre à jour les tables avant de traiter les komis
            // echo 'flush';
            $em->flush();
            //et on traite les komis
            // pas pour l'instant
//                foreach ($akomi as $komi) {
//                    if(self::okeffaceKomi($komi)){
//                        $em->remove($komi);
//                        $em->flush();
//                    }
//                       
//                }
            //Et on efface les repertoires
            foreach ($repertoire as $dir) {
                $this->container->get('obdo_services.Remove_dir')->rrmdir($dir);
            }

            // preparation du message de confirmation  
            $this->get('session')->getFlashBag()->add(
                    'notice', 'Le goupe de kuchi ' . $kuchiGroup->getName() . ' a été supprimé.'
            );
            //on affiche la liste des groupes   
            return $this->redirect($this->generateUrl('obdo_kuchi_komi_kuchi_group', array(
                                'page' => 1,
                                'sort' => 'active_up',
            )));
        } else {
            $hidden = $this->btnafficheAddKomi($kuchiGroup, $id);
            return $this->render('obdoKuchiKomiBundle:Default:kuchigroupview.html.twig', array(
                        'KuchiGroup' => $kuchiGroup,
                        'message' => 'Le kuchigroup est actif suppression impossible.',
                        'Btncache' => $hidden,
            ));
        }
    }

    public function effaceThanks($kuchikomi) {
        $emthanks = $this->getDoctrine()
                ->getManager();
//        $repothanks = $emthanks->getRepository('obdoKuchiKomiRESTBundle:Thanks');
//        $thanks = $repothanks->getThanksbyKuchiKomiId($id);
        $thanks = $kuchikomi->getThanks();
        foreach ($thanks as $thk) {
            //on indique à doctrine que l'on veut effacer le 'thanks'
            $emthanks->remove($thk);
        }
    }

    public function okeffaceKomi($komi) {
        $em = $this->getDoctrine()
                ->getManager();
        $ok = false;
        $nb = 0;
        //reste t'il des subscriptionsgroup
        $scgkomi = $em->getRepository('obdoKuchiKomiRESTBundle:SubscriptionGroup')->findByKomi($komi);
        $nb = count($scgkomi);
        if ($nb == 0) {
            //reste t'il des subscriptions
            $sckomi = $em->getRepository('obdoKuchiKomiRESTBundle:Subscription')->findByKomi($komi);
            $nb = count($sckomi);
        }
        if ($nb == 0) // le kommi n'a plus de subscription on peut l'effacer.
            $ok = true;
        return $ok;
    }

    public function btnafficheAddKomi($kuchiGroup, $id) {
        $hidden = false;
        // combien de kuchis autorisés
        $maxkuchi = $kuchiGroup->getNbMaxKuchi();
        // combien de kuchis actifs pour ce groupe
        $countkuchi = $this->getDoctrine()->getManager()->getRepository('obdoKuchiKomiRESTBundle:Kuchi')->getNbKuchiGroup($id);
        if ($countkuchi >= $maxkuchi)
            $hidden = true;
        return $hidden;
    }

}
