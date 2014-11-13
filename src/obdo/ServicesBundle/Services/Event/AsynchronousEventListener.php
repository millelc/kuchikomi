<?php
namespace obdo\ServicesBundle\Services\Event;

use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class AsynchronousEventListener
{
	protected $dispatcher;
	 
	public function __construct(CitykomiAsynchronousEventDispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}
	 
	public function onKernelTerminate(PostResponseEvent $event)
	{
		$this->dispatcher->dispatchAsync();
	}
}