<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RMS\PushNotificationsBundle\Message\AndroidMessage;

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
}
