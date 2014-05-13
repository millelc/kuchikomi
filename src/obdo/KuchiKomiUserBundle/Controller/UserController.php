<?php

namespace obdo\KuchiKomiUserBundle\Controller;

use obdo\KuchiKomiUserBundle\Entity\User;
use obdo\KuchiKomiUserBundle\Form\UserType;
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
        $Logger = $this->container->get('obdo_services.Logger');

        $userManager = $this->container->get('fos_user.user_manager');
        $user = new User();
        $form  = $this->createForm(new UserType($this->getRoles()), $user);
        // On récupère la requête
        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST') {
            
            $form->bind($request);

            if ($form->isValid()) {
                $userFoss = $userManager->createUser();
                $userFoss->setUsername($user->getUsername());
                $userFoss->setEmail($user->getEmail());
                $userFoss->setPlainPassword($user->getPassword());
                $userFoss->setEnabled(true);
                $userFoss->setRoles($user->getRoles());
                $userManager->updateUser($userFoss, true);

                $Logger->Info("[KuchiUser] [user : " . $this->get('security.context')->getToken()->getUser()->getUserName() . "] " . $userFoss->getUsername() . " added");

                return $this->redirect($this->generateUrl('obdo_kuchi_komi_user', array(
                                    'page' => 1,
                                    'sort' => 'name_up',
                )));
            }
        }
        return $this->render('obdoKuchiKomiUserBundle:Default:useradd.html.twig', array(
                    'form' => $form->createView(),
        ));
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
        $tabrole = array($currentrole=>$tabroles[$currentrole]);
        
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
