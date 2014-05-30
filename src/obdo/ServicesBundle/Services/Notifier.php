<?php

namespace obdo\ServicesBundle\Services;

use RMS\PushNotificationsBundle\Message\AndroidMessage;
use RMS\PushNotificationsBundle\Message\iOSMessage;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;

use Doctrine\ORM\EntityManager;

class Notifier
{   
	private $container;
        protected $em;
	
	public function __construct($kernel, EntityManager $em)
	{
		$this->container = $kernel->getContainer();
                $this->em = $em;
	}

	
    public function sendMessage( $deviceId, $osType, $msg, $data )
    {
        // Post message
        if( $osType == 0 )
        {
            $message = new AndroidMessage();
            $message->setGCM(true);
            $message->setMessage( $msg );
            $message->setData( $data );
            $message->setDeviceIdentifier( $deviceId );
            $this->container->get('rms_push_notifications')->send($message);
        } 
        else if( $osType == 1 )
        {
            $message = new iOSMessage();
            $message->setMessage( $msg );
            $message->setDeviceIdentifier( $deviceId );
            $this->container->get('rms_push_notifications')->send($message);
        }  
    }
    
    /**
     * Set a new notification to all Komi suscribers
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi
     * @return Kuchi
     */
    public function sendKuchiKomiNotification(\obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchi, \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi, $type)
    {	
        //$em = $this->container->getDoctrine()->getManager();
        //$Notifier = $this->container->get('obdo_services.Notifier');
    	$repositoryKuchiAccount = $this->em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        
        
    	$subscriptions = $kuchi->getSubscriptions();
    	foreach ($subscriptions as $subscription)
    	{
            if( $subscription->getActive() )
            {
                $komi = $subscription->getKomi();
                $this->sendMessage( $komi->getGcmRegId(), $komi->getOsType(), $kuchikomi->getTitle(), array("type" => $type));
            }
    	}
        
        $kuchiAccounts = $repositoryKuchiAccount->getKuchiAccountForKuchi($kuchi);
        foreach ($kuchiAccounts as $kuchiAccount)
    	{
            $komi = $kuchiAccount->getKomi();
            $this->sendMessage( $komi->getGcmRegId(), $komi->getOsType(), $kuchikomi->getTitle(), array("type" => "4"));
    	}
    }
}
