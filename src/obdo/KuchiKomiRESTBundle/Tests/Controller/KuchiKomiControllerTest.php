<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\KuchiKomiRESTBundle\Tests\Controller;

use obdo\KuchiKomiRESTBundle\Tests\Controller\CityKomiWebTestCase;
use obdo\KuchiKomiRESTBundle\Tests\Blar_DateTime;
/**
 * Description of KuchiKomiControllerTest
 *
 * @author emilie
 */
class KuchiKomiControllerTest extends CityKomiWebTestCase {
   

    
    protected function setUp() {
        parent::setUp();
    }

    
    function __construct() {
        parent::__construct();       
		
    }

    
    public function test_P_PostKuchiKomiAction_1(){
        $komi = parent::$repositoryKomi->findOneByRandomId('ac81d6f9cb600d38');
        $kuchi = parent::$repositoryKuchi->findOneById('2');        
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));   
        $dateBegin = new \DateTime() ;        
        $dateEnd = new \DateTime();
        
        $crawler = $this->client->request(                
                    'POST',
                    '/rest/kuchikomi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('POST /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json'),                
                json_encode(array ( "kuchikomi" => array ("title"=> uniqid('TIT'),"timestampBegin"=> $dateBegin->getTimestamp(),
                    "timestampEnd"=> $dateEnd->getTimestamp(),"details"=>uniqid('DET'),"photo"=> '', "random_id"=> uniqid('KK'))))
                );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());        
        $this->checkKuchiAccountToken($kuchiAccount->getToken(),$komi,$kuchi);
        
    }
    

    
    
}
