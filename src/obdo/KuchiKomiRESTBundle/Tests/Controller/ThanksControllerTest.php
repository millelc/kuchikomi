<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\KuchiKomiRESTBundle\Tests\Controller;
use obdo\KuchiKomiRESTBundle\Entity\Komi;

/**
 * Description of ThanksControllerTest
 *
 * @author emilie
 */
class ThanksControllerTest extends CityKomiWebTestCase {
    
    public $randomId;
    public $kuchiKomiTitle;
    
    
    
    protected function setUp() {
        parent::setUp();
    }
    
    
    function __construct($randomId_komi, $kuchiName) {
        parent::__construct();
        $this->randomId = uniqid(Komi_ThksTest);
        $this->kuchiKomiTitle = "Thanks";
    }
    
    
    public function test_P_PostThanksAction_1(){
        $kuchikomi= parent::$repositoryKuchiKomi->findOneByTitle($this->kuchiKomiTitle);
        $komi=  $this->createKomi($this->randomId, '1', '2.0.0', 'okuebfjaokidlmoejan');
        parent::$em->persist($komi);
        parent::$em->flush();
        parent::$em->close();
        $komi = parent::$repositoryKomi->findOneByRandomId($this->randomId);        
        if($kuchikomi->getNbThanks()==null)
            {
            $nbThanks=0;
            }
        else
            {
            $nbThanks = $kuchikomi->getNbThanks();
            }
            
        $crawler = $this->client->request(
                'POST',
                '/rest/thanks/'.$komi->getRandomId().'/'.$kuchikomi->getId().'/'.sha1('POST /rest/thanks'. $komi->getToken()),
                array(),
                array(),
                array('Content-Type', 'text/html')
                );
        $this->assertEquals(200,  $this->client->getResponse()->getStatusCode());
        $this->checkKomiToken($komi->getToken(), $komi->getRandomId());
        $kuchikomi= parent::$repositoryKuchiKomi->findOneByTitle($this->kuchiKomiTitle);
        $nbThanks2 = $kuchikomi->getNbThanks();
        $this->assertNotEquals($nbThanks2, $nbThanks);
    }
    
    /**
     * kuchikomi unknown
     */
    public function test_N_PostThanksAction_1(){
        $komi=  $this->getLastKomiActive(parent::$repositoryKomi);
        $kuchikomi= 'mauvais_kuchikomi';
        $crawler = $this->client->request(
                'POST',
                '/rest/thanks/'.$komi->getRandomId().'/'.$kuchikomi.'/'.sha1('POST /rest/thanks'. $komi->getToken()),
                array(),
                array(),
                array('Content-Type', 'text/html')
                );
        $this->assertEquals(503,  $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * Thanks already done
     */
    public function test_N_PostThanksAction_2(){
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle('Thanks');
        $komi = parent::$repositoryKomi->findOneByRandomId('N_PostThanksAction_2_komi');
                $crawler = $this->client->request(
                'POST',
                '/rest/thanks/'.$komi->getRandomId().'/'.$kuchikomi->getId().'/'.sha1('POST /rest/thanks'. $komi->getToken()),
                array(),
                array(),
                array('Content-Type', 'text/html')
                );
        $this->assertEquals(511,  $this->client->getResponse()->getStatusCode());
    }
    
    /**
     *  komi unknown
     */
    public function test_N_PostThanksAction_3(){
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle($this->kuchiKomiTitle);
        $komi2 = $this->getLastKomiActive(parent::$repositoryKomi);
        $komi = 'Mauvais_komi';
                $crawler = $this->client->request(
                'POST',
                '/rest/thanks/'.$komi.'/'.$kuchikomi->getId().'/'.sha1('POST /rest/thanks'. $komi2->getToken()),
                array(),
                array(),
                array('Content-Type', 'text/html')
                );
        $this->assertEquals(501,  $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * mauvaise route
     */
    public function test_N_PostThanksAction_4(){
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle($this->kuchiKomiTitle);
        $komi = $this->getLastKomiActive(parent::$repositoryKomi);
        
                $crawler = $this->client->request(
                'POST',
                '/rest/Mauvaise_Route/'.$komi->getRandomId().'/'.$kuchikomi->getId().'/'.sha1('POST /rest/thanks'. $komi->getToken()),
                array(),
                array(),
                array('Content-Type', 'text/html')
                );
        $this->assertEquals(404,  $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * mauvais hash
     */
    public function test_N_PostThanksAction_5(){
        $kuchikomi = parent::$repositoryKuchiKomi->findOneByTitle($this->kuchiKomiTitle);
        $komi = $this->getLastKomiActive(parent::$repositoryKomi);
        
                $crawler = $this->client->request(
                'POST',
                '/rest/thanks/'.$komi->getRandomId().'/'.$kuchikomi->getId().'/'.sha1('POST /mauvais_hash'. $komi->getToken()),
                array(),
                array(),
                array('Content-Type', 'text/html')
                );
        $this->assertEquals(510,  $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * 
     * @param type $randomId
     * @param type $osType
     * @param type $applicationVersion
     * @param type $gcmRegId
     * @param type $active
     * @return \obdo\KuchiKomiRESTBundle\Entity\Komi
     */    
    private function createKomi($randomId, $osType, $applicationVersion, $gcmRegId, $active=true)
        {
            $komi_test= new Komi();
            $komi_test->setRandomId($randomId);
            $komi_test->setOsType($osType);
            $komi_test->setApplicationVersion($applicationVersion);
            $komi_test->setGcmRegId($gcmRegId);
            $komi_test->setActive($active);                       
            return $komi_test;	
            
        }
    
}
