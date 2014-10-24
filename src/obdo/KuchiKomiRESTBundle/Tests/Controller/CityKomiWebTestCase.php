<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\KuchiKomiRESTBundle\Tests\Controller;

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
    public static $repositoryKuchiKomi;
    public static $repositoryKuchiGroup;        
    public static $repositorySubscription; 
    protected $client;    
    public static $password;
    
    

        
    protected function setUp() {
        parent::setUp();
        $this->client =  static::createClient();        
        $kernel = static::createKernel(); 
        $kernel->boot();

        //get the DI container
        self::$container = $kernel->getContainer();

        //now we can instantiate our service (if you want a fresh one for
        //each test method, do this in setUp() instead
        self::$AES = self::$container->get('obdo_services.AES');
        self::$em= self::$container->get('doctrine.orm.entity_manager');        
        self::$IdCheck = self::$container->get('obdoKuchiKomiRestBundle.idCheck');
        self::$password= self::$container->get('obdo_services.Password');
        self::$repositoryKomi = self::$em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        self::$repositoryKuchi = self::$em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        self::$repositoryKuchiKomi= self::$em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        self::$repositoryKuchiAccount = self::$em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        self::$repositoryKuchiGroup = self::$em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup');
        self::$repositorySubscription = self::$em->getRepository('obdoKuchiKomiRESTBundle:Subscription');
        self::$AES->setKey(self::$container->getParameter('aes_key'));
        self::$AES->setBlockSize(self::$container->getParameter('aes_key_size'));
        self::$AES->setIV(self::$container->getParameter('aes_IV'));   
        
    }
    
        /**
     * 
     * @param repository $repository
     * @return komi, le dernier actif 
     * charge les komi par ordre décroissant d'id     
     */
    
    protected function getLastKomiActive($repository){
        $komis= $repository
       ->findBy(array(), array('id' => 'desc'));
        $x=0;
        while($komis[$x]->getActive()==FALSE){
            $x=$x+1;
        }
        return $komis[$x];
    }
    
        /**
     * 
     * @param repository $repository
     * @return komi, le dernier actif 
     * charge les komi par ordre décroissant d'id     
     */
    
    protected function getLastKomiInactive($repository){
        $komis= $repository
       ->findBy(array(), array('id' => 'desc'));
        $x=0;
        while($komis[$x]->getActive()==TRUE){
            $x=$x+1;
        }
        return $komis[$x];        
    }
    
    protected function checkKomiToken($oldToken, $komiRandomId)            
    {
        self::$em->close();
        $komi = self::$repositoryKomi->findOneByRandomId($komiRandomId);
        $this->assertNotEquals($komi->getToken(), $oldToken);
    }


}
