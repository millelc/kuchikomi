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
        protected $message;
	
	public function __construct($kernel, EntityManager $em)
	{
		$this->container = $kernel->getContainer();
                $this->em = $em;               
	}

	
    public function sendMessage( $deviceId, $osType, $msg, $data ,$isSilent)
    {
        // Post message
        if( $osType == 0 )
        {
            $this->message = new AndroidMessage();
            $this->message->setGCM(true);
            $this->message->setMessage( $msg );
            $this->message->setData( $data );
            $this->message->setDeviceIdentifier( $deviceId );            
            $this->container->get('rms_push_notifications')->send($this->message);
        } 
        else if( $osType == 1 )
        {
            $this->message = new iOSMessage();
            
            // Manage silent push if data=3 dans le cas d'un delete
            if( !$isSilent )
            {
                $this->message->setMessage( $msg );
            }
            $this->message->setDeviceIdentifier( $deviceId );            
            $this->container->get('rms_push_notifications')->send($this->message);            
        }  
    }
    

    public function getMessage() {
        return $this->message;
    }

        
        
    /**
     * Set a new notification to all Komi suscribers
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi
     * @return Kuchi
     */
    public function sendKuchiKomiNotification(\obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchi, \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi, $type)
    {	
    	$repositoryKuchiAccount = $this->em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        
        // Manage iOS silent push if data=3 dans le cas d'un delete
        $isSilent = false;
        if( $type == "3")
        {
            $isSilent = true;
        }
        
    	$subscriptions = $kuchi->getSubscriptions();
    	foreach ($subscriptions as $subscription)
    	{
            if( $subscription->getActive() )
            {
                $komi = $subscription->getKomi();
                $this->sendMessage( $komi->getGcmRegId(), $komi->getOsType(), $kuchikomi->getTitle(), array("type" => $type), $isSilent);
            }
    	}
        
        $kuchiAccounts = $repositoryKuchiAccount->getKuchiAccountForKuchi($kuchi);
        foreach ($kuchiAccounts as $kuchiAccount)
    	{
            $komi = $kuchiAccount->getKomi();
            $this->sendMessage( $komi->getGcmRegId(), $komi->getOsType(), $kuchikomi->getTitle(), array("type" => "4"), true);
    	}
    }
}
