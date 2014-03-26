<?php

namespace obdo\ServicesBundle\Services;

use RMS\PushNotificationsBundle\Message\AndroidMessage;

class Notifier
{   
	private $container;
	
	public function __construct($kernel)
	{
		$this->container = $kernel->getContainer();
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
    }
}
