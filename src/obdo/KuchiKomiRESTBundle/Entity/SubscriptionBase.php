<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

abstract class SubscriptionBase
{        
    const TYPE_NFC = 0;
    const TYPE_QRCode = 1;
    const TYPE_WEB = 2;
    
    protected function getRegisteredType($type)
    {
        $result = self::TYPE_WEB;
        
        if( $type == self::TYPE_NFC )
        {
            $result = self::TYPE_NFC;
        }
        elseif( $type == self::TYPE_QRCode ) 
        {
            $result = self::TYPE_QRCode;
        }
        
        return $result;
    }
}
