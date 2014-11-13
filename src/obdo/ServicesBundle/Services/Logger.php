<?php

namespace obdo\ServicesBundle\Services;

use Doctrine\ORM\EntityManager;
use obdo\KuchiKomiRESTBundle\Entity\Log;
use obdo\ServicesBundle\Services\Event\LogEvent;

class Logger
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onAddLog(LogEvent $event)
    {
        switch ($event->level)
        {
            case Log::LEVEL_INFO:
                $this->Info($event->message);
                break;
            case Log::LEVEL_WARNING:
                $this->Warning($event->message);
                break; 
            case Log::LEVEL_ERROR:
                $this->Error($event->message);
                break;            
        }
    }
    
    public function Info( $message )
    {
        $this->flushLog(Log::LEVEL_INFO, $message);
    }

    public function Warning( $message )
    {
        $this->flushLog(Log::LEVEL_WARNING, $message);
    }
    
    public function Error( $message )
    {
        $this->flushLog(Log::LEVEL_ERROR, $message);
    }
    
    private function flushLog( $level, $message )
    {
        $newLog = new Log();
        $newLog->setLevel($level);
        $newLog->setMessage($message);
        
        $this->em->persist($newLog);
        $this->em->flush();
    }
}
