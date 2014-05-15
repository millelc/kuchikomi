<?php

namespace obdo\KuchiKomiUserBundle\Controller;

use obdo\KuchiKomiUserBundle\Entity\User;
use obdo\KuchiKomiUserBundle\Form\UserType;
use obdo\KuchiKomiUserBundle\Form\UserKuchiType;
use obdo\KuchiKomiUserBundle\Form\UserKuchiGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    public function ajoutAction() {
        $user = new User();

        $form = $this->createForm(new UserType($this->getRoles()), $user);

        // On récupère la requête
        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {
                $username = $user->getUsername();
                $userpwd = $user->getPassword();
                $userrole = $user->getRoles();
                $usermail = $user->getEmail();
                $url = $this->generateUrl('obdo_kuchi_komi_user_add_suite', 
                        array('username' => $username,
                            'usermail' => $usermail, 
                            'userpwd' => $userpwd,
                            'userrole' => serialize($userrole)));
                return $this->redirect($url);
            }
        }
        return $this->render('obdoKuchiKomiUserBundle:Default:useradd.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    public function ajoutsuiteAction($username, $usermail, $userpwd, $userrole) {
        $Logger = $this->container->get('obdo_services.Logger');

        $userk = new User();
        $userk->setUsername($username);
        $userk->setPassword($userpwd);
        $userk->setEmail($usermail);
        
        $currentroles = unserialize($userrole);
        $currentrole = $currentroles[0];
        
        $formk = $this->createForm(new UserKuchiType($this->getRoles(), $userk));
        $formkg = $this->createForm(new UserKuchiGroupType($this->getRoles(), $userk));
        $formerr = $formkg;
        
        $requestk = $this->get('request');
        
        if ($requestk->getMethod() == 'POST') {
            if ($currentrole == 'ROLE_KUCHI') {
                $formk->bind($requestk);
                $formerr = $formk;
            }else
            {
                $formkg->bind($requestk);
                $formerr = $formkg;
            }
            
            if ($formk->isValid() || $formkg->isValid()) {
                $userk->setPlainPassword($userpwd);
                $userk->setEnabled(true);
                $userk->setRoles($currentroles);

                if($formkg['kuchigroups']->getData() != null){
                  foreach($formkg['kuchigroups']->getData() as $kg){
                    $userk->addKuchiGroup($kg);
                  }  
                }
                
                if($formk['kuchis']->getData() != null){
                  foreach($formk['kuchis']->getData() as $k){
                    $userk->addKuchi($k);
                  }  
                }
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($userk);
                $em->flush();

                $Logger->Info("[KuchiUser] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $userk->getUsername() . " added");

                return $this->redirect($this->generateUrl('obdo_kuchi_komi_user', array(
                                    'page' => 1,
                                    'sort' => 'name_up',
                )));
            }else
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

//     public function viewAction($id)
//     {
//     	$em = $this->getDoctrine()->getManager();
//     	$user = $em->getRepository('obdoKuchiKomiUserBundle:User')->findOneById($id);
//     	return $this->render('obdoKuchiKomiUserBundle:Default:userview.html.twig', array(
//     																					'user'   => $user
//     																					));
//     }
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

        return $roles;
    }

}
