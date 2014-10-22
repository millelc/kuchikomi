<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\KuchiKomiRESTBundle\Tests\Controller;

use obdo\KuchiKomiRESTBundle\Tests\Controller\CityKomiWebTestCase;
//use Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase;
//use Symfony\Component\Serializer\Serializer;
//use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
//use Symfony\Component\Serializer\Encoder\JsonEncoder;
/**
 * Description of KuchiControllerTest
 *
 * @author emilie
 */
class KuchiControllerTest extends CityKomiWebTestCase {
    
    //public $komi;
   // public $kuchi;
    //public $address;
    public $passwordKuchi;

    public $address1;
    public $postalCode;       
    public $city;
    
 
    protected function setUp() {
        parent::setUp();
    }
    
    
    function __construct() {
        parent::__construct();
        $this->name = ('David');
        $this->passwordKuchi =  uniqid('mdp');   
        $this->address1= str_shuffle("rue de la place du rond point");
        $this->postalCode= str_shuffle("26574");
        $this->city=  str_shuffle("villeincroyable");            
    }
    
    /**
     * test positif PutKuchiAction
     * code 200
     * kuchi changé en base
     * kuchi id identique
     * token modifié
     */
    public function test_P_PutKuchiAction_1(){
            
        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
        $kuchi = parent::$repositoryKuchi->findOneById('2');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));
        $crawler=$this->client->request(
                'PUT',
                '/rest/kuchi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('PUT /rest/kuchi'.$kuchiAccount->getToken()),
                array(),
                array(),
                array('Content-Type' => 'application/json'),
               json_encode(array ( "kuchi"=> array ( "name" => $this->name, "password" => $this->passwordKuchi, "address1"=>$this->address1
                        , "address2" =>'' , "address3"=>'' , "postal_code" =>
                        $this->postalCode , "city" => $this->city )))
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        parent::$em->close();
        $kuchi2 = parent::$repositoryKuchi->findOneById("2");
        $kuchiAccount2 = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi2));
        $this->assertNotEquals($kuchi->getPassword(), $kuchi2->getPassword());
        $this->assertEquals($kuchi->getId(), $kuchi2->getId());
        $this->assertNotEquals($kuchiAccount->getToken(), $kuchiAccount2->getToken());        
        
    }
    
    /**
     * test négatif PutKuchiAction kuchi invalide
     */
    public function test_N_PutKuchiAction_1(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
        $kuchi = "pasKuchi";
        $crawler=$this->client->request(
                'PUT',
                '/rest/kuchi/'.$komi->getRandomId().'/'.$kuchi.'/'.sha1('PUT /rest/kuchi2695b883943700bb58d2995835'),
                array(),
                array(),
                array('Content-Type' => 'application/json'),
               json_encode(array ( "kuchi"=> array ( "name" => $this->name, "password" => $this->passwordKuchi, "address1"=>$this->address1
                        , "address2" =>'' , "address3"=>'' , "postal_code" =>
                        $this->postalCode , "city" => $this->city )))
                );
                $this->assertEquals(502,$this->client->getResponse()->getStatusCode());   
    }
    
    /**
     * test négatif PutKuchiAction komi invalide
     */
    public function test_N_PutKuchiAction_2(){
        
        $kuchi = parent::$repositoryKuchi->findOneById('2');
        
        $crawler=$this->client->request(
                'PUT',
                '/rest/kuchi/'."mauvais_komi".'/'.$kuchi->getId().'/'.sha1('PUT /rest/kuchi2695b883943700bb58d2995835'),
                array(),
                array(),
                array('Content-Type' => 'application/json'),
               json_encode(array ( "kuchi"=> array ( "name" => $this->name, "password" => $this->passwordKuchi, "address1"=>$this->address1
                        , "address2" =>'' , "address3"=>'' , "postal_code" =>
                        $this->postalCode , "city" => $this->city )))
                );
        $this->assertEquals(501,$this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif PutKuchiAction hash invalid
     */
    public function test_N_PutKuchiAction_3() {
        
        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
        $kuchi = parent::$repositoryKuchi->findOneById('2');

        $crawler=$this->client->request(
                'PUT',
                '/rest/kuchi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('PUT /rest/kuchi'."mauvais_hash"),
                array(),
                array(),
                array('Content-Type' => 'application/json'),
               json_encode(array ( "kuchi"=> array ( "name" => $this->name, "password" => $this->passwordKuchi, "address1"=>$this->address1
                        , "address2" =>'' , "address3"=>'' , "postal_code" =>
                        $this->postalCode , "city" => $this->city )))
                );
        $this->assertEquals(510,$this->client->getResponse()->getStatusCode());
    }      
    
    /**
     * test négatif PutKuchiAction kuchiAccount invalid 
     */
        public function test_N_PutKuchiAction_4(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
        $kuchi = parent::$repositoryKuchi->findOneById('3');
        $crawler=$this->client->request(
                'PUT',
                '/rest/kuchi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('PUT /rest/kuchi2695b883943700bb58d2995835'),
                array(),
                array(),
                array('Content-Type' => 'application/json'),
               json_encode(array ( "kuchi"=> array ( "name" => $this->name, "password" => $this->passwordKuchi, "address1"=>$this->address1
                        , "address2" =>'' , "address3"=>'' , "postal_code" =>
                        $this->postalCode , "city" => $this->city )))
                );
                $this->assertEquals(504,$this->client->getResponse()->getStatusCode());   
    }
    
    /**
     * test négatif PutKuchiAction kuchi inactif
     */
    public function test_N_PutKuchiAction_5() {
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('13');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));
        $crawler=$this->client->request(
                'PUT',
                '/rest/kuchi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('PUT /rest/kuchi'.$kuchiAccount->getToken()),
                array(),
                array(),
                array('Content-Type' => 'application/json'),
               json_encode(array ( "kuchi"=> array ( "name" => $this->name, "password" => $this->passwordKuchi, "address1"=>$this->address1
                        , "address2" =>'' , "address3"=>'' , "postal_code" =>
                        $this->postalCode , "city" => $this->city )))
                );
        
        $this->assertEquals(508,$this->client->getResponse()->getStatusCode());
    }
    

     /**
     * test positif PostKuchiSyncAction
     * statusCode 200
     * TimestampLastSynchroSaved et TimestampLastSynchro du kuchiAccount identiques
     * token mis à jour
     */
    public function test_P_PostKuchiSyncAction_1(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'POST',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("POST /rest/kuchi/sync" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $tokenA = $kuchiAccount->getToken();
        parent::$em->close();
        $kuchiAccount=parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi, 'kuchi'=>$kuchi));
        $this->assertEquals($kuchiAccount->getTimestampLastSynchroSaved(),$kuchiAccount->getTimestampLastSynchro());
        $this->assertNotEquals($tokenA, $kuchiAccount->getToken());
    }
    
    /**
     * test négatif PostKuchiSyncAction mauvais komi
     */
    public function test_N_PostKuchiSyncAction_1() {
        $komi = "mauvais komi";
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        //$kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'POST',
                '/rest/kuchi/sync/'.$komi.'/'.$kuchi->getId().'/'.sha1("POST /rest/kuchi/sync" . '488332f9ed7d3ef735607d32b7'),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
    }
    
/**
 * test négatif PostKuchiSyncAction mauvais kuchi
 */
    public function test_N_PostKuchiSyncAction_2(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = 'mauvais_kuchi';
        //$kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'POST',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi.'/'.sha1("POST /rest/kuchi/sync" . '488332f9ed7d3ef735607d32b7'),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(502, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif PostKuchiSyncAction kuchiAccount invalid 
     */
    public function test_N_PostKuchiSyncAction_3(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
        $kuchi = parent::$repositoryKuchi->findOneById('3');
        $crawler=$this->client->request(
                'PUT',
                '/rest/kuchi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('POST /rest/kuchi/sync'.'2695b883943700bb58d2995835'),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(504, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test négatif PostKuchiSyncAction hash invalid 
     */
    public function test_N_PostKuchiSyncAction_4(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'POST',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("mauvais_hash" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif PostKuchiSyncAction mauvaise route
     */
    public function test_N_PostKuchiSyncAction_5(){
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'POST',
                '/rest/kuchi/NOROUTE/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("POST /rest/kuchi/sync" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
    
    
//    public function test_P_GetKuchiSyncAction_1(){
//        
//    }
//    /**
//     * test positif DeleteKuchiSyncAction
//     */
//    public function test_P_DeleteKuchiSyncAction_1(){
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
//        $kuchi = parent::$repositoryKuchi->findOneById('2');
//        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$this->komi,'kuchi'=>$this->kuchi));        
//    }
    
    

    
}
