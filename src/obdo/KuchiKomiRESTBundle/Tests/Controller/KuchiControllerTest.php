<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\KuchiKomiRESTBundle\Tests\Controller;

use obdo\KuchiKomiRESTBundle\Tests\Controller\CityKomiWebTestCase;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
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
        $kuchi = parent::$repositoryKuchi->findOneById('1');
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
        $this->checkKuchiAccountToken($kuchiAccount->getToken(), $komi, $kuchi);
        $kuchi2 = parent::$repositoryKuchi->findOneById("1");        
        $this->assertNotEquals($kuchi->getPassword(), $kuchi2->getPassword());
        $this->assertEquals($kuchi->getId(), $kuchi2->getId());
        ;        
        
    }
    
    /**
     * test négatif PutKuchiAction kuchi invalide
     */
    public function test_N_PutKuchiAction_1(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
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
        
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('11');

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
        $kuchi = parent::$repositoryKuchi->findOneById('11');        
        $crawler=$this->client->request(
                'PUT',
                '/rest/kuchi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('PUT /rest/kuchi'.'2695b883943700bb58d2995835'),
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
        $kuchi = parent::$repositoryKuchi->findOneById('12');
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
        $this->checkKuchiAccountToken($kuchiAccount->getToken(), $komi, $kuchi);
        $this->assertEquals($kuchiAccount->getTimestampLastSynchroSaved(),$kuchiAccount->getTimestampLastSynchro());
        
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
                'POST',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('POST /rest/kuchi/sync'.'2695b883943700bb58d2995835'),
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
    
    /**
     * test négatif PostKuchiSyncAction méthode non autorisé (manque sync à la route)
     */
    public function test_N_PostKuchiSyncAction_6(){
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'POST',
                '/rest/kuchi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("POST /rest/kuchi/sync" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test positif GetKuchiSyncAction
     */
    public function test_P_GetKuchiSyncAction_1(){
        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
        $kuchi = parent::$repositoryKuchi->findOneById('1');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));   
                $kk2 = new KuchiKomi();
		$kk2->setKuchi($kuchi);
		$kk2->setTitle(uniqid('TITR'));
		$kk2->setDetails(uniqid('DET'));
		$kk2->setTimestampEnd($kk2->getTimestampEnd()->add(new \DateInterval('P5Y')));		
		parent::$em->persist($kk2);
                parent::$em->flush();
                       
        $crawler= $this->client->request(
                'GET',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("GET /rest/kuchi/sync" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
               
        $this->assertRegExp('/ADDED_KUCHIKOMIS/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/UPDATED_KUCHIKOMIS/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/DELETED_KUCHIKOMIS/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/STATS/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/NB_SUB/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/NB_SUB_1MONTH/',  $this->client->getResponse()->getContent());       
        

        //$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        parent::$em->close();
        $kuchi2=parent::$repositoryKuchi->findOneById('1');
        $kuchiAccount2 = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));
        $this->assertNotEquals($kuchiAccount2->getTimestampLastSynchroSaved(),$kuchiAccount->getTimestampLastSynchroSaved());        
        $this->assertNotEquals($kuchiAccount2->getToken(), $kuchiAccount->getToken());
        $kuchikomis = parent::$repositoryKuchiKomi->findBy(array('kuchi'=>$kuchi2));
        $index=count($kuchikomis)-1;
        $this->assertRegExp('/'.$kuchikomis[$index]->getTitle().'/', $this->client->getResponse()->getContent());
    }
    
    /**
     * test négatif GetKuchiSyncAction kuchi inactif
     */
    public function test_N_GetKuchiSyncAction_1(){
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('12'); 
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));
        $crawler= $this->client->request(
                'GET',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("GET /rest/kuchi/sync" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        
        $this->assertEquals(508, $this->client->getResponse()->getStatusCode());

    }
    
    /**
     * test négatif pour un mauvais komi
     */
    public function test_N_GetKuchiSyncAction_2(){
        $komi = "mauvais_komi";
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        //$kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        //$kuchikomis = parent::$repositoryKuchiKomi->findBy(array('kuchi'=>$kuchi));
        $crawler= $this->client->request(
                'GET',
                '/rest/kuchi/sync/'.$komi.'/'.$kuchi->getId().'/'.sha1("GET /rest/kuchi/sync" . '2695b883943700bb58d2995835'),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif pour un mauvais kuchi
     */
    public function test_N_GetKuchiSyncAction_3(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId('cb612345ac81d6f8');
        $kuchi ="mauvais_kuchi" ;
        $crawler= $this->client->request(
                'GET',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi.'/'.sha1("GET /rest/kuchi/sync" . '2695b883943700bb58d2995835'),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(502, $this->client->getResponse()->getStatusCode());
    }    
    
    /**
     * test négatif pour un mauvais kuchiaccount
     */
    public function test_N_GetKuchiSyncAction_4(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId('cb612345ac81d6f8');
        $kuchi =parent::$repositoryKuchi->findOneById('4');;              

        $crawler= $this->client->request(
                'GET',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("GET /rest/kuchi/sync" . '2695b883943700bb58d2995835'),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(504, $this->client->getResponse()->getStatusCode());
    } 
    
    /**
     * test négatif pour un mauvais hash
     */
    public function test_N_GetKuchiSyncAction_5(){
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));
        
        $crawler= $this->client->request(
                'GET',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("GET /MAUVAIS-HASH" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode());
    }
    
    
    public function test_N_GetKuchiSyncAction_6(){
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));
        
        $crawler= $this->client->request(
                'GET',
                '/rest/kuchi/MAUVAISE_ROUTE/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("GET /rest/kuchi/sync" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
    
    
    /**
     * test positif DeleteKuchiSyncAction
     */
    public function test_P_DeleteKuchiSyncAction_1(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
        $kuchi = parent::$repositoryKuchi->findOneById('1');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));        
        $kuchiAccount->setTimestampLastSynchro(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        sleep(3);
        $kuchiAccount->setCurrentTimestampLastSynchroSaved();
        
        $crawler= $this->client->request(
                'DELETE',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("DELETE /rest/kuchi/sync" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        parent::$em->close();
        $kuchiAccount2 = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi)); 
        $dateZero = new \DateTime('2014-01-01 00:00:00.000000',new \DateTimeZone('Europe/Paris'));
        $this->assertEquals($kuchiAccount2->getTimestampLastSynchro(), $dateZero);
        $this->assertEquals($kuchiAccount2->getTimestampLastSynchroSaved(),$dateZero);
    }
    
    
        /**
     * test négatif DeleteKuchiSyncAction mauvais komi
     */
    public function test_N_DeleteKuchiSyncAction_1() {
        $komi = "mauvais komi";
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        //$kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'DELETE',
                '/rest/kuchi/sync/'.$komi.'/'.$kuchi->getId().'/'.sha1("DELETE /rest/kuchi/sync" . '488332f9ed7d3ef735607d32b7'),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
    }
    
/**
 * test négatif DeleteKuchiSyncAction mauvais kuchi
 */
    public function test_N_DeleteKuchiSyncAction_2(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = 'mauvais_kuchi';
        //$kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'DELETE',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi.'/'.sha1("DELETE /rest/kuchi/sync" . '488332f9ed7d3ef735607d32b7'),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(502, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif DeleteKuchiSyncAction kuchiAccount invalid 
     */
    public function test_N_DeleteKuchiSyncAction_3(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
        $kuchi = parent::$repositoryKuchi->findOneById('3');
        $crawler=$this->client->request(
                'DELETE',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('DELETE /rest/kuchi/sync'.'2695b883943700bb58d2995835'),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(504, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test négatif DeleteKuchiSyncAction hash invalid 
     */
    public function test_N_DeleteKuchiSyncAction_4(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'DELETE',
                '/rest/kuchi/sync/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("mauvais_hash" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif DeleteKuchiSyncAction mauvaise route
     */
    public function test_N_DeleteKuchiSyncAction_5(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("cb612345ac81d6f8");
        $kuchi = parent::$repositoryKuchi->findOneById('12');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));      
        $crawler= $this->client->request(
                'DELETE',
                '/rest/kuchi/NOROUTE/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("DELETE /rest/kuchi/sync" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif PostKuchiSyncAction méthode non autorisé (manque sync à la route)
     */
    public function test_N_DeleteKuchiSyncAction_6(){
        
        $komi = parent::$repositoryKomi->findOneByRandomId("ac81d6f9cb600d38");
        $kuchi = parent::$repositoryKuchi->findOneById('1');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi'=>$komi,'kuchi'=>$kuchi));        
       
        $crawler= $this->client->request(
                'DELETE',
                '/rest/kuchi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1("DELETE /rest/kuchi/sync" . $kuchiAccount->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());
    }
    
}
