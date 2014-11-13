<?php

namespace obdo\ServicesBundle\Services\Event;
 
use Symfony\Component\EventDispatcher\Event;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;

class NotificationEvent extends Event
{
    public $kuchi;
    public $kuchikomi;
    public $type;
    
    public function __construct(Kuchi $kuchi, KuchiKomi $kuchikomi, $type)
    {
        $this->kuchi = $kuchi;
        $this->kuchikomi = $kuchikomi;
        $this->type = $type;
    }
}