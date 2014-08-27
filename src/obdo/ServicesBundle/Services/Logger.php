<?php

namespace obdo\ServicesBundle\Services;

use Doctrine\ORM\EntityManager;
use obdo\KuchiKomiRESTBundle\Entity\Log;

class Logger
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
