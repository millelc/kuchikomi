<?php

namespace obdo\ServicesBundle\Services\Event;
 
use Symfony\Component\EventDispatcher\Event;
 
class LogEvent extends Event
{
    public $level;
    public $message;
    
    public function __construct($level, $message)
    {
        $this->level = $level;
        $this->message = $message;
    }
}