<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\KuchiKomiREStBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use obdo\ServicesBundle\Services;

/**
 * Description of ControllersTests
 *
 * @author emilie
 */
abstract class CityKomiWebTestCase extends WebTestCase 

{
    
    public static $AES;
    public static $container;
    public static $em;
    public static $repositoryKomi;
    public static $repositoryKuchi;
    public static $repositoryKuchiAccount;
    public static $IdCheck;
    protected $client;
    //public static $password;
    //put your code here
    

        
    public static function setUpBeforeClass() 
    {
        parent::setUpBeforeClass();
        //start the symfony kernel
        $kernel = static::createKernel(); 
        $kernel->boot();

        //get the DI container
        self::$container = $kernel->getContainer();

        //now we can instantiate our service (if you want a fresh one for
        //each test method, do this in setUp() instead
        self::$AES = self::$container->get('obdo_services.AES');
        self::$em= self::$container->get('doctrine.orm.entity_manager');        
        self::$IdCheck = self::$container->get('obdoKuchiKomiRestBundle.idCheck');
        //self::$password= self::$container->get('obdo_services.Password');
        self::$repositoryKomi = self::$em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        self::$repositoryKuchi = self::$em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        self::$repositoryKuchiAccount = self::$em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
                    
    }

   
//    public function setUp() {
//        parent::setUp();
//        self::$client2=  static::createClient();
//    }
    protected function setUp() {
        parent::setUp();
        $this->client =  static::createClient();
    }


}
