<?php
namespace obdo\ServicesBundle\Services\Event;
 
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use obdo\ServicesBundle\Services\Event\LogEvent;
use obdo\ServicesBundle\Services\Event\NotificationEvent;

use obdo\KuchiKomiRESTBundle\Entity\Log;
 
class CitykomiAsynchronousEventDispatcher extends AsynchronousEventDispatcher
{
	 
    /**
    * Store an asynchronous event to send kuchikomi notification
    *
    * @param Kuchi $kuchi
    * @param KuchiKomi $kuchikomi
    * @param string $type
    *
    * @return void
    */
    public function sendKuchikomiNotificationAsyncEvent($kuchi, $kuchikomi, $type)
    {
        $event = new NotificationEvent($kuchi, $kuchikomi, $type);

        $this->asyncEvents[] = array(
                    'name' => 'obdo.notify.kuchikomi',
                    'event' => $event,
            );
    }

    
    /**
    * Store an asynchronous event to log a information message.
    *
    * @param string $message
    *
    * @return void
    */
    public function addLogInfoAsyncEvent($message)
    {
        $event = new LogEvent(Log::LEVEL_INFO, $message);

        $this->asyncEvents[] = array(
                    'name' => 'obdo.log.add',
                    'event' => $event,
            );
    }
	 
    /**
    * Store an asynchronous event to log a warning message.
    *
    * @param string $message
    *
    * @return void
    */
    public function addLogWarningAsyncEvent($message)
    {
        $event = new LogEvent(Log::LEVEL_WARNING, $message);

        $this->asyncEvents[] = array(
                    'name' => 'obdo.log.add',
                    'event' => $event,
            );
    }
    
    /**
    * Store an asynchronous event to log an error message.
    *
    * @param string $message
    *
    * @return void
    */
    public function addLogErrorAsyncEvent($message)
    {
        $event = new LogEvent(Log::LEVEL_ERROR, $message);

        $this->asyncEvents[] = array(
                    'name' => 'obdo.log.add',
                    'event' => $event,
            );
    }
}