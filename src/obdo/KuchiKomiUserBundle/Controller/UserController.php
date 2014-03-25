<?php

namespace obdo\KuchiKomiUserBundle\Controller;

use obdo\KuchiKomiUserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
	
    public function indexAction($page, $sort)
    {
        $em = $this->getDoctrine()->getManager();
        
        $users = $em->getRepository('obdoKuchiKomiUserBundle:User')->getUsers(25, $page, $sort);
        
        return $this->render('obdoKuchiKomiUserBundle:Default:userindex.html.twig', array(
                                                                                        'users'   => $users,
                                                                                        'page'   => $page,
                                                                                        'nombrePage' => ceil(count($users)/25),
                                                                                        'sort'   => $sort
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
    

}
