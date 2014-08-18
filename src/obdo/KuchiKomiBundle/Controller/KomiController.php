<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RMS\PushNotificationsBundle\Message\AndroidMessage;

// pour la gestion des acls
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class KomiController extends Controller
{
	
    public function indexAction($page, $sort)
    {
        $em = $this->getDoctrine()->getManager();
        
        $komis = $em->getRepository('obdoKuchiKomiRESTBundle:Komi')->getKomis(25, $page, $sort);
        
        return $this->render('obdoKuchiKomiBundle:Default:komiindex.html.twig', array(
                                                                                        'komis'   => $komis,
                                                                                        'page'   => $page,
                                                                                        'nombrePage' => ceil(count($komis)/25),
                                                                                        'sort'   => $sort
                                                                                        ));
    }
    
    public function viewAction($id) 
    {
        $komi = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Komi')
                ->find($id);
        
        //controle droit visu
        //$securityContext = $this->get('security.context');

        // check for view access
        //if (false === $securityContext->isGranted('VIEW', $komi))
        //{
        //    throw new AccessDeniedException();
        //}

        return $this->render('obdoKuchiKomiBundle:Default:komiview.html.twig', array(
                    'Komi' => $komi
        ));
    }

}
