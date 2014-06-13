<?php

namespace obdo\KuchiKomiUserBundle\Controller;

use obdo\KuchiKomiUserBundle\Entity\User;
use obdo\KuchiKomiUserBundle\Form\UserType;
use obdo\KuchiKomiUserBundle\Form\UserKuchiType;
use obdo\KuchiKomiUserBundle\Form\UserKuchiGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// pour la gestion des acls
use obdo\KuchiKomiUserBundle\Controller\AclController;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;



class UserController extends Controller {

    public function indexAction($page, $sort) {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('obdoKuchiKomiUserBundle:User')->getUsers(25, $page, $sort);
        return $this->render('obdoKuchiKomiUserBundle:Default:userindex.html.twig', array(
                    'users' => $users,
                    'page' => $page,
                    'nombrePage' => ceil(count($users) / 25),
                    'sort' => $sort
        ));
    }

    public function ajoutAction($clientid) {
        $user = new User();
      
        $form = $this->createForm(new UserType($this->getRoles()), $user);
        
         //si création d'un user depuis écran détail client
        $cliid = 0;
        if ($clientid != 'new'){
            $cliid = $clientid;
        }

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $username = $user->getUsername();
                $userpwd = $user->getPassword();
                $userrole = $user->getRoles();
                $usermail = $user->getEmail();
                
                $userclient = $user->getClient()->getId();
                $url = $this->generateUrl('obdo_kuchi_komi_user_add_suite', array('username' => $username,
                    'usermail' => $usermail,
                    'userclient' => $userclient,
                    'userpwd' => $userpwd,
                    'userrole' => serialize($userrole)));
                return $this->redirect($url);
            }
        }
        return $this->render('obdoKuchiKomiUserBundle:Default:useradd.html.twig', array(
                    'cliid' => $cliid,
                    'form' => $form->createView(),
        ));
    }

    public function ajoutsuiteAction($username, $usermail, $userclient, $userpwd, $userrole) {
        $Logger = $this->container->get('obdo_services.Logger');

        $userk = new User();
        $userk->setUsername($username);
        $userk->setPassword($userpwd);
        $userk->setEmail($usermail);
        if ($userclient != null)
            $userk->setClient($userclient);

        $currentroles = unserialize($userrole);
        $currentrole = $currentroles[0];

        $formk = null;
        $formkg = null;
        
        $objets = array();

        if ($currentrole == 'ROLE_KUCHI') {
            $formk = $this->createForm(new UserKuchiType($this->getRoles(), $this->getUser()->getId(), $userk));
            $formerr = $formk;
        } else {
            $formkg = $this->createForm(new UserKuchiGroupType($this->getRoles(), $this->getUser()->getId(), $userk));
            $formerr = $formkg;
        }


        $requestk = $this->get('request');

        if ($requestk->getMethod() == 'POST') {
            if ($currentrole == 'ROLE_KUCHI') {
                $formk->bind($requestk);
                $formerr = $formk;
            } else {
                $formkg->bind($requestk);
                $formerr = $formkg;
            }

            if (($formk != null && $formk->isValid()) || ($formkg != null && $formkg->isValid())) {
                $userk->setPlainPassword($userpwd);
                $userk->setEnabled(true);
                $userk->setRoles($currentroles);


                if ($currentrole == 'ROLE_KUCHI') {
                    if ($formk['kuchis']->getData() != null) {
                        foreach ($formk['kuchis']->getData() as $k) {
                            $userk->addKuchi($k);
                            $objets[] = $k;
                        }
                    }
                } else {
                    if ($formkg['kuchigroups']->getData() != null) {
                        foreach ($formkg['kuchigroups']->getData() as $kg) {
                            $userk->addKuchiGroup($kg);
                            $objets[] = $kg;
                        }
                    }
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($userk);
                $em->flush();
                
                // ajout acl nouvel utilisateur apres flush sinon user pas connu
               
                foreach($objets as $objet){
                   AclController::addAcl($objet, $userk, $this); 
                   // si je suis pas kuchi, il faut ajouter l'acl des kuchis 
                   // du groupe à l'utilisateur
                   if ($currentrole != 'ROLE_KUCHI'){
                       $kuchis = $objet->getKuchis();
                       foreach($kuchis as $kuchi){
                           AclController::addAcl($kuchi, $userk, $this); 
                       }
                   }
                }
                                
                $Logger->Info("[KuchiUser] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $userk->getUsername() . " added");

                return $this->redirect($this->generateUrl('obdo_kuchi_komi_user', array(
                                    'page' => 1,
                                    'sort' => 'name_up',
                )));
            } else
                echo $formerr;
        }
        if ($currentrole == 'ROLE_KUCHI') {

            return $this->render('obdoKuchiKomiUserBundle:Default:userkuchiadd.html.twig', array(
                        'form' => $formk->createView(),
                        'nomuser' => $userk->getUsername(),
            ));
        } else {

            return $this->render('obdoKuchiKomiUserBundle:Default:userkuchigroupadd.html.twig', array(
                        'form' => $formkg->createView(),
                        'nomuser' => $userk->getUsername(),
            ));
        }
    }

    public function viewAction($id) {
        $user = $this->getDoctrine()
                ->getRepository('obdoKuchiKomiUserBundle:User')
                ->find($id);
        
        // on récupére la liste des kuchigroup que l'utilisateur à le droit de traiter
               
        $provider = $this->container->get('security.acl.provider');
        $repo = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup');
        $kgs = $repo->findAll();
        $kuchigroup = AclController::lstObj($user, $kgs, $provider);
        
        // on récupére la liste des kuchi que l'utilisateur à le droit de traiter
        $repo = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $ks = $repo->findAll();
        $kuchi = AclController::lstObj($user, $ks, $provider);

        return $this->render('obdoKuchiKomiUserBundle:Default:userview.html.twig', array(
                    'user' => $user,
                    'kgroups' => $kuchigroup,
                    'kuchis' => $kuchi,
        ));
    }

    public function addaclkuchigroupAction($userid){
        $Logger = $this->container->get('obdo_services.Logger');
        
        $user = $this->getDoctrine()
                ->getRepository('obdoKuchiKomiUserBundle:User')
                ->find($userid);
        
        $formkg = $this->createForm(new UserKuchiGroupType($this->getRoles(), $this->getUser()->getId(), $user));
       
        $requestk = $this->get('request');

        if ($requestk->getMethod() == 'POST') {
            $formkg->bind($requestk);
            if ($formkg->isValid()){
                if ($formkg['kuchigroups']->getData() != null) {
                    
                    foreach ($formkg['kuchigroups']->getData() as $kg) {
                        try{
                            $user->addKuchiGroup($kg);
                        }
                        catch(\Exception $e) {
                        }
                        AclController::addAcl($kg, $user, $this); 
                        $kuchis = $kg->getKuchis();
                        foreach($kuchis as $kuchi){
                            AclController::addAcl($kuchi, $user, $this); 
                        }
                    }
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    $Logger->Info("[KuchiUser] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $user->getUsername() . " acl kuchigroup update");
                }
                
                return $this->redirect($this->generateUrl('obdo_kuchi_komi_user', array(
                                    'page' => 1,
                                    'sort' => 'name_up',
                )));
            }
        }
        return $this->render('obdoKuchiKomiUserBundle:Default:userkuchigroupupdate.html.twig', array(
                        'form' => $formkg->createView(),
                        'user' => $user,
            ));
    }

    public function addaclkuchiAction($userid){
        $Logger = $this->container->get('obdo_services.Logger');
        
        $user = $this->getDoctrine()
                ->getRepository('obdoKuchiKomiUserBundle:User')
                ->find($userid);
        
        $formk = $this->createForm(new UserKuchiType($this->getRoles(), $this->getUser()->getId(), $user));
    
        $requestk = $this->get('request');

        if ($requestk->getMethod() == 'POST') {
            $formk->bind($requestk);
            if ($formk->isValid()){
                if ($formk['kuchis']->getData() != null) {
                    foreach ($formk['kuchis']->getData() as $k) {
                        try{
                            $user->addKuchi($k);
                        }
                        catch(\Exception $e) {
                        }
                        AclController::addAcl($k, $user, $this);
                    }
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    $Logger->Info("[KuchiUser] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $user->getUsername() . " acl kuchi update");
                }
                return $this->redirect($this->generateUrl('obdo_kuchi_komi_user', array(
                                    'page' => 1,
                                    'sort' => 'name_up',
                )));
            }
        }
        return $this->render('obdoKuchiKomiUserBundle:Default:userkuchiupdate.html.twig', array(
                        'form' => $formk->createView(),
                        'user' => $user,
            ));
    }
    protected function getRoles() {
        $roles = array();
        // pour n'afficher que les roles auquels le user à droit 
        // on évite ainsi qu'un admin puisse créer un super_admin.
        $tabrole = array();
        $currentroles = $this->getUser()->getRoles();
        $currentrole = $currentroles[0];
        $tabroles = $this->container->getParameter('security.role_hierarchy.roles');
        $tabrole = array($currentrole => $tabroles[$currentrole]);

        foreach ($tabrole as $name => $rolesHierarchy) {
            $roles[$name] = $name;

            foreach ($rolesHierarchy as $role) {
                if (!isset($roles[$role])) {
                    $roles[$role] = $role;
                }
            }
        }
        // ajout pour avoir les roles admin en + si super admin
        if ($currentrole = 'ROLE_SUPER_ADMIN') {
            $currentrole = 'ROLE_ADMIN';
            $tabrole = array($currentrole => $tabroles[$currentrole]);
            foreach ($tabrole as $name => $rolesHierarchy) {
                $roles[$name] = $name;

                foreach ($rolesHierarchy as $role) {
                    if (!isset($roles[$role])) {
                        $roles[$role] = $role;
                    }
                }
            }
        }
        return $roles;
    }

}
