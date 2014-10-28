<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\KuchiKomiRESTBundle\Tests\Controller;

use obdo\KuchiKomiRESTBundle\Tests\Controller\CityKomiWebTestCase;
use obdo\KuchiKomiRESTBundle\Tests\Blar_DateTime;
use obdo\ServicesBundle\Services\AclManager;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
/**
 * Description of KuchiKomiControllerTest
 *
 * @author emilie
 */
class KuchiKomiControllerTest extends CityKomiWebTestCase {
   
public $kuchiKomiTitle ;
    
    protected function setUp() {
        parent::setUp();
    }

    
    function __construct() {
        parent::__construct();       
        $this->kuchiKomiTitle = uniqid('TIT');
		
    }

    
    public function test_P_PostKuchiKomiAction_1(){
        $komi = parent::$repositoryKomi->findOneByRandomId('P_PostKuchiKomiAction_1');
        $kuchi = parent::$repositoryKuchi->findOneByName('P_PostKuchiKomiAction_1');        
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));   
        $dateBegin = new \DateTime() ;        
        $dateEnd = new \DateTime();
        
        $crawler = $this->client->request(                
                    'POST',
                    '/rest/kuchikomi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('POST /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json'),                
                json_encode(array ( "kuchikomi" => array ("title"=> $this->kuchiKomiTitle,"timestampBegin"=> $dateBegin->getTimestamp(),
                    "timestampEnd"=> $dateEnd->getTimestamp(),"details"=>uniqid('DET'),"photo"=> '', "random_id"=> uniqid('KK'))))
                );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());        
        $this->checkKuchiAccountToken($kuchiAccount->getToken(),$komi,$kuchi);   
        $notifier = $this->client->getContainer()->get('obdo_services.Notifier');     
        if($kuchi->getSubscriptions()->first()->getKomi()->getOsType()==='0'){                    
              foreach ($notifier->getMessage()->getMessageBody() as $value){
                  foreach ($value as $message)
                    {
                        if(is_string($message)){
                            $this->assertEquals($this->kuchiKomiTitle, $message) ;                                          
                        }

                    }        
              }
        }
        else
            {
             $this->assertEquals($this->kuchiKomiTitle,$notifier->getMessage()->getMessage());
            }   
              
    }
     /**
      * test négatif de PostKuchiKomiAction pour un kuchiAccount unknown (ce komi et ce kuchi n'ont pas de kuchiaccount)
      */
    public function test_N_PostKuchiKomiAction_1(){
        $komi = parent::$repositoryKomi->findOneByRandomId('cb600d38ac81d6f9');
        $kuchi = parent::$repositoryKuchi->findOneById('2');   
        $kuchi2 = parent::$repositoryKuchi->findOneById('12');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi2));   
        $dateBegin = new \DateTime() ;        
        $dateEnd = new \DateTime();
        
        $crawler = $this->client->request(                
                    'POST',
                    '/rest/kuchikomi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('POST /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json'),                
                json_encode(array ( "kuchikomi" => array ("title"=> $this->kuchiKomiTitle,"timestampBegin"=> $dateBegin->getTimestamp(),
                    "timestampEnd"=> $dateEnd->getTimestamp(),"details"=>uniqid('DET'),"photo"=> '', "random_id"=> uniqid('KK'))))
                );
        $this->assertEquals(504, $this->client->getResponse()->getStatusCode());    
    }
    
    /**
     * test négatif de PostKuchiKomiAction pour un mauvais kuchi
     */
    public function test_N_PostKuchiKomiAction_2(){
        $komi = parent::$repositoryKomi->findOneByRandomId('cb600d38ac81d6f9');
        $kuchi = parent::$repositoryKuchi->findOneById('12'); 
        $kuchi2 = 'mauvais_kuchi';
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));   
        $dateBegin = new \DateTime() ;        
        $dateEnd = new \DateTime();
        
        $crawler = $this->client->request(                
                    'POST',
                    '/rest/kuchikomi/'.$komi->getRandomId().'/'.$kuchi2.'/'.sha1('POST /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json'),                
                json_encode(array ( "kuchikomi" => array ("title"=> $this->kuchiKomiTitle,"timestampBegin"=> $dateBegin->getTimestamp(),
                    "timestampEnd"=> $dateEnd->getTimestamp(),"details"=>uniqid('DET'),"photo"=> '', "random_id"=> uniqid('KK'))))
                );
        $this->assertEquals(502, $this->client->getResponse()->getStatusCode());
    }
    
    /**
    *test négatif de PostKuchiKomiAction pour un mauvais komi
    */
    public function test_N_PostKuchiKomiAction_3(){
            
        $komi = parent::$repositoryKomi->findOneByRandomId('cb600d38ac81d6f9');
        $komi2= "mauvais_komi";
        $kuchi = parent::$repositoryKuchi->findOneById('12');        
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));   
        $dateBegin = new \DateTime() ;        
        $dateEnd = new \DateTime();
        
        $crawler = $this->client->request(                
                    'POST',
                    '/rest/kuchikomi/'.$komi2.'/'.$kuchi->getId().'/'.sha1('POST /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json'),                
                json_encode(array ( "kuchikomi" => array ("title"=> $this->kuchiKomiTitle,"timestampBegin"=> $dateBegin->getTimestamp(),
                    "timestampEnd"=> $dateEnd->getTimestamp(),"details"=>uniqid('DET'),"photo"=> '', "random_id"=> uniqid('KK'))))
                );
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());  
        
    }
    
    /**
     * test négatif de PostKuchiKomiAction pour un mauvais hash
     */
    public function test_N_PostKuchiKomiAction_4(){   
        
        $komi = parent::$repositoryKomi->findOneByRandomId('cb600d38ac81d6f9');
        $kuchi = parent::$repositoryKuchi->findOneById('12');        
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));   
        $dateBegin = new \DateTime() ;        
        $dateEnd = new \DateTime();
        
        $crawler = $this->client->request(                
                    'POST',
                    '/rest/kuchikomi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('POST /rest/hash_mauvais'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json'),                
                json_encode(array ( "kuchikomi" => array ("title"=> $this->kuchiKomiTitle,"timestampBegin"=> $dateBegin->getTimestamp(),
                    "timestampEnd"=> $dateEnd->getTimestamp(),"details"=>uniqid('DET'),"photo"=> '', "random_id"=> uniqid('KK'))))
                );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode()); 
    }
    
    /**
     * test négatif de PostKuchiKomiAction pour une mauvaise route
     */
    public function test_N_PostKuchiKomiAction_5(){   
        
        $komi = parent::$repositoryKomi->findOneByRandomId('cb600d38ac81d6f9');
        $kuchi = parent::$repositoryKuchi->findOneById('12');        
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));   
        $dateBegin = new \DateTime() ;        
        $dateEnd = new \DateTime();
        
        $crawler = $this->client->request(                
                    'POST',
                    '/rest/mauvaise_route/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.sha1('POST /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json'),                
                json_encode(array ( "kuchikomi" => array ("title"=> $this->kuchiKomiTitle,"timestampBegin"=> $dateBegin->getTimestamp(),
                    "timestampEnd"=> $dateEnd->getTimestamp(),"details"=>uniqid('DET'),"photo"=> '', "random_id"=> uniqid('KK'))))
                );
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode()); 
    }
    

    /**
     * test positif DeleteKuchiKomiAction
     * code 200, date de suppression => aujourd'hui
     * kuchikomi désactivé
     */
    public function test_P_DeleteKuchiKomiAction_1(){
        $komi = parent::$repositoryKomi->findOneByRandomId('P_DeleteKuchiKomiAction_1');
        $kuchi = parent::$repositoryKuchi->findOneByName('P_DeleteKuchiKomiAction_1');        
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));  
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle("Le KuchiKomi qu'on supprime");
        $date = new \DateTime('now', new \DateTimeZone('Europe/Paris')) ;                
        
        $crawler = $this->client->request(                
                    'DELETE',
                    '/rest/kuchikomi/'.$komi->getRandomId().'/'.$kuchi->getId().'/'.$kuchikomi->getId().'/'.sha1('DELETE /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json')
                );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        parent::$em->close();
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle("Le KuchiKomi qu'on supprime");
        $this->assertEquals($date->format('Y-m-d'), $kuchikomi->getTimestampSuppression()->format('Y-m-d'));
        $this->assertEquals(FALSE, $kuchikomi->getActive());
        $this->checkKuchiAccountToken($kuchiAccount->getToken(), $komi, $kuchi);
//        $kuchikomi->setActive(true);
//        parent::$em->persist($kuchikomi);
//        parent::$em->flush();
        
    }   
    
    /**
     * test négatif DeleteKuchiKomiAction pour un mauvais komi
     */
    public function test_N_DeleteKuchiKomiAction_1(){
        $komi = parent::$repositoryKomi->findOneByRandomId('P_DeleteKuchiKomiAction_1');
        $kuchi = parent::$repositoryKuchi->findOneByName('P_DeleteKuchiKomiAction_1');        
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
        $komi2= "mauvais_komi";
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle("Le KuchiKomi qu'on supprime");
        $crawler = $this->client->request(                
                    'DELETE',
                    '/rest/kuchikomi/'.$komi2.'/'.$kuchi->getId().'/'.$kuchikomi->getId().'/'.sha1('DELETE /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json')
                );
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif DeleteKuchiKomiAction pour un mauvais kuchi
     */
    public function test_N_DeleteKuchiKomiAction_2(){
        $komi = parent::$repositoryKomi->findOneByRandomId('P_DeleteKuchiKomiAction_1');
        $kuchi = parent::$repositoryKuchi->findOneByName('P_DeleteKuchiKomiAction_1');        
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
        $kuchi2= "mauvais_kuchi";
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle("Le KuchiKomi qu'on supprime");
        $crawler = $this->client->request(                
                    'DELETE',
                    '/rest/kuchikomi/'.$komi->getrandomId().'/'.$kuchi2.'/'.$kuchikomi->getId().'/'.sha1('DELETE /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json')
                );
        $this->assertEquals(502, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif DeleteKuchiKomiAction pour un mauvais kuchiaccount
     */
    public function test_N_DeleteKuchiKomiAction_3(){
        $komi = parent::$repositoryKomi->findOneByRandomId('P_DeleteKuchiKomiAction_1');
        $kuchi = parent::$repositoryKuchi->findOneByName('P_DeleteKuchiKomiAction_1');  
        $kuchi2 = parent::$repositoryKuchi->findOneById('2');
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));        
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle("Le KuchiKomi qu'on supprime");
        $crawler = $this->client->request(                
                    'DELETE',
                    '/rest/kuchikomi/'.$komi->getrandomId().'/'.$kuchi2->getId().'/'.$kuchikomi->getId().'/'.sha1('DELETE /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json')
                );
        $this->assertEquals(504, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif DeleteKuchiKomiAction pour une mauvais route
     */
    public function test_N_DeleteKuchiKomiAction_4(){
        $komi = parent::$repositoryKomi->findOneByRandomId('P_DeleteKuchiKomiAction_1');
        $kuchi = parent::$repositoryKuchi->findOneByName('P_DeleteKuchiKomiAction_1');          
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));        
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle("Le KuchiKomi qu'on supprime");
        $crawler = $this->client->request(                
                    'DELETE',
                    '/rest/erreurRoute/'.$komi->getrandomId().'/'.$kuchi->getId().'/'.$kuchikomi->getId().'/'.sha1('DELETE /rest/kuchikomi'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json')
                );
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif DeleteKuchiKomiAction pour un mauvais hash
     */
    public function test_N_DeleteKuchiKomiAction_5(){
        $komi = parent::$repositoryKomi->findOneByRandomId('P_DeleteKuchiKomiAction_1');
        $kuchi = parent::$repositoryKuchi->findOneByName('P_DeleteKuchiKomiAction_1');          
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));        
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle("Le KuchiKomi qu'on supprime");
        $crawler = $this->client->request(                
                    'DELETE',
                    '/rest/kuchikomi/'.$komi->getrandomId().'/'.$kuchi->getId().'/'.$kuchikomi->getId().'/'.sha1('DELETE /rest/Mauvais_Hash'.$kuchiAccount->getToken()),               
                array(),
                array(),
                array('Content-Type' => 'application/json')
                );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode());
    }
    
    
}
