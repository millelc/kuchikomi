<?php

namespace obdo\ServicesBundle\Services;

class Password
{   
	private $container;
	
	public function __construct($kernel)
	{
		$this->container = $kernel->getContainer();
	}
	
    public function generateHash( $clearPassword )
    {
        return hash("sha256", $this->container->getParameter('sha256_salt2').hash("sha256", hash("sha256", $clearPassword) . $this->container->getParameter('sha256_salt1')));
    }
}
