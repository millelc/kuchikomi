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
    
    public function notificationAction( $id, $page, $sort )
    {
    	$em = $this->getDoctrine()->getManager();
    	$repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
    	$komi = $repositoryKomi->findOneById($id);
    	// Post message
    	if( $komi->getOsType() == 0 )
    	{
    		$date = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    		$dateString = $date->format('Y-m-d H:i:s');
    		
    		$message = new AndroidMessage();
    		$message->setGCM(true);
    		$message->setMessage('Nouveau KuchiKomi (' . $dateString . ')');
    		$message->setData(array("type" => "1"));
    		$message->setDeviceIdentifier($komi->getGcmRegId());
    	}
    	
    	$this->container->get('rms_push_notifications')->send($message);
    	
    	$komis = $repositoryKomi->getKomis(25, $page, $sort);
    	
    	return $this->render('obdoKuchiKomiBundle:Default:komiindex.html.twig', array(
    			'komis'   => $komis,
    			'page'   => $page,
    			'nombrePage' => ceil(count($komis)/25),
    			'sort'   => $sort
    	));
    }
}
