<?php  
namespace obdo\KuchiKomiRESTBundle\Tests\Controller;


//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use obdo\ServicesBundle\Services;
use obdo\KuchiKomiRESTBundle\Tests\Controller\CityKomiWebTestCase;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;


class SubscriptionControllerTest extends CityKomiWebTestCase
{       

    
    protected function setUp() {
        parent::setUp();
    }
    
    function __construct() 
    {
        parent::__construct(); 
    }
       
    /**
     * Test positif de PostSubscriptionAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS
     */
        
    public function test_P_PostSubscriptionAction_1()            
    {
        $kuchi = parent::$repositoryKuchi->findOneByName("P_PostSubscriptionAction_1");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_1_Android_1");
        $this->template_test_P_PostSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_1_Android_2");
        $this->template_test_P_PostSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_1_Android_3");
        $this->template_test_P_PostSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_1_Android_4");
        $this->template_test_P_PostSubscriptionAction_1($kuchi, $komi, 1234567, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_1_iOS_1");
        $this->template_test_P_PostSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_1_iOS_2");
        $this->template_test_P_PostSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_1_iOS_3");
        $this->template_test_P_PostSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_1_iOS_4");
        $this->template_test_P_PostSubscriptionAction_1($kuchi, $komi, 1234567, Subscription::TYPE_WEB);
    }
    
    private function template_test_P_PostSubscriptionAction_1($kuchi, $komi, $type, $typeResult)
    {
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId().'/'. $type .'/'.sha1('POST /rest/subscription'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        $newSubscription = parent::$repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
        $this->checkSubscription($newSubscription, true, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    /**
     * Test positif de PostSubscriptionAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS
     * Subscription already exist, but inactive
     */
        
    public function test_P_PostSubscriptionAction_2()            
    {
        $kuchi = parent::$repositoryKuchi->findOneByName("P_PostSubscriptionAction_2");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_2_Android_1");
        $this->template_test_P_PostSubscriptionAction_2($kuchi, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_2_Android_2");
        $this->template_test_P_PostSubscriptionAction_2($kuchi, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_2_Android_3");
        $this->template_test_P_PostSubscriptionAction_2($kuchi, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_2_Android_4");
        $this->template_test_P_PostSubscriptionAction_2($kuchi, $komi, 1234567, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_2_iOS_1");
        $this->template_test_P_PostSubscriptionAction_2($kuchi, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_2_iOS_2");
        $this->template_test_P_PostSubscriptionAction_2($kuchi, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_2_iOS_3");
        $this->template_test_P_PostSubscriptionAction_2($kuchi, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionAction_2_iOS_4");
        $this->template_test_P_PostSubscriptionAction_2($kuchi, $komi, 1234567, Subscription::TYPE_WEB);
    }
    
    private function template_test_P_PostSubscriptionAction_2($kuchi, $komi, $type, $typeResult)
    {
        $oldToken = $komi->getToken();
        $crawler=$this->client->request(
                'POST',
                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId().'/'. $type .'/'.sha1('POST /rest/subscription'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        $newSubscription = parent::$repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
        $this->checkSubscription($newSubscription, true, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    
    /**
     * Test négatif de PostSubscriptionAction avec Komi inconnu.
     */
        
    public function test_N_PostSubscriptionAction_1()            
    {
        $this->template_test_N_PostSubscriptionAction_1(Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_1(Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_1(Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_1(4);
    }
    
    private function template_test_N_PostSubscriptionAction_1($type)            
    {
        $kuchi = parent::$repositoryKuchi->findOneByName("N_PostSubscriptionAction_1");
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscription/'.$kuchi->getId().'/'.'0'.'/'.$type.'/'.'token',
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(501,$this->client->getResponse()->getStatusCode());   
    }
    
    /**
     * Test négatif de PostSubscriptionAction avec kuchi inconnu.
     */
        
    public function test_N_PostSubscriptionAction_2()            
    {
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_2_Android");
        
        $this->template_test_N_PostSubscriptionAction_2($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_2($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_2($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_2($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_2_IOS");
        
        $this->template_test_N_PostSubscriptionAction_2($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_2($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_2($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_2($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_2_WINDOWS");
        
        $this->template_test_N_PostSubscriptionAction_2($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_2($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_2($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_2($komi, 4);
    }
    
    private function template_test_N_PostSubscriptionAction_2($komi, $type)            
    {
        $oldToken = $komi->getToken();
        $crawler=$this->client->request(
                'POST',
                '/rest/subscription/'.'0'.'/'.$komi->getRandomId().'/'.$type.'/'.$komi->getToken(),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(502,$this->client->getResponse()->getStatusCode());
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    
    /**
     * Test négatif de PostSubscriptionAction avec komi inactif.
     */
        
    public function test_N_PostSubscriptionAction_3()            
    {
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_3_Android");
        
        $this->template_test_N_PostSubscriptionAction_3($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_3($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_3($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_3($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_3_IOS");
        
        $this->template_test_N_PostSubscriptionAction_3($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_3($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_3($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_3($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_3_WINDOWS");
        
        $this->template_test_N_PostSubscriptionAction_3($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_3($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_3($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_3($komi, 4);
    }
    
    private function template_test_N_PostSubscriptionAction_3($komi, $type)            
    {
        $oldToken = $komi->getToken();
        $crawler=$this->client->request(
                'POST',
                '/rest/subscription/'.'0'.'/'.$komi->getRandomId().'/'.$type.'/'.$komi->getToken(),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(512,$this->client->getResponse()->getStatusCode());  
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }
    
    /**
     * Test négatif de PostSubscriptionAction avec kuchi inactif.
     */
        
    public function test_N_PostSubscriptionAction_4()            
    {
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_4_Android");
        
        $this->template_test_N_PostSubscriptionAction_4($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_4($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_4($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_4($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_4_IOS");
        
        $this->template_test_N_PostSubscriptionAction_4($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_4($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_4($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_4($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_4_WINDOWS");
        
        $this->template_test_N_PostSubscriptionAction_4($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_4($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_4($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_4($komi, 4);
    }
    
    private function template_test_N_PostSubscriptionAction_4($komi, $type)            
    {
        $oldToken = $komi->getToken();
        $kuchi = parent::$repositoryKuchi->findOneByName("N_PostSubscriptionAction_4");
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId().'/'.$type.'/'.$komi->getToken(),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(508,$this->client->getResponse()->getStatusCode());
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }
    
    /**
     * Test négatif de PostSubscriptionAction avec token invalid.
     */
        
    public function test_N_PostSubscriptionAction_5()            
    {
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_5_Android");
        
        $this->template_test_N_PostSubscriptionAction_5($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_5($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_5($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_5($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_5_IOS");
        
        $this->template_test_N_PostSubscriptionAction_5($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_5($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_5($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_5($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_5_WINDOWS");
        
        $this->template_test_N_PostSubscriptionAction_5($komi, Subscription::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionAction_5($komi, Subscription::TYPE_NFC);
        $this->template_test_N_PostSubscriptionAction_5($komi, Subscription::TYPE_WEB);
        $this->template_test_N_PostSubscriptionAction_5($komi, 4);
    }
    
    private function template_test_N_PostSubscriptionAction_5($komi, $type)            
    {
        $kuchi = parent::$repositoryKuchi->findOneByName("N_PostSubscriptionAction_5");
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId().'/'.$type.'/'.'bad_token',
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(510,$this->client->getResponse()->getStatusCode()); 
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }
    
    /**
     * Test positif de PostSubscriptionAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS
     * Subscription already exist, but inactive
     */
        
    public function test_N_PostSubscriptionAction_6()            
    {
        $kuchi = parent::$repositoryKuchi->findOneByName("N_PostSubscriptionAction_6");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_6_Android_1");
        $this->template_test_N_PostSubscriptionAction_6($kuchi, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_6_Android_2");
        $this->template_test_N_PostSubscriptionAction_6($kuchi, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_6_Android_3");
        $this->template_test_N_PostSubscriptionAction_6($kuchi, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_6_Android_4");
        $this->template_test_N_PostSubscriptionAction_6($kuchi, $komi, 1234567, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_6_iOS_1");
        $this->template_test_N_PostSubscriptionAction_6($kuchi, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_6_iOS_2");
        $this->template_test_N_PostSubscriptionAction_6($kuchi, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_6_iOS_3");
        $this->template_test_N_PostSubscriptionAction_6($kuchi, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_6_iOS_4");
        $this->template_test_N_PostSubscriptionAction_6($kuchi, $komi, 1234567, Subscription::TYPE_WEB);
    }
    
    private function template_test_N_PostSubscriptionAction_6($kuchi, $komi, $type, $typeResult)
    {
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId().'/'. $type .'/'.sha1('POST /rest/subscription'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(511,$this->client->getResponse()->getStatusCode());   
        $existingSubscription = parent::$repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
        $this->checkSubscription($existingSubscription, true, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    
    /**
     * Test positif de DeleteSubscriptionAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS
     */
        
    public function test_P_DeleteSubscriptionAction_1()            
    {
        $kuchi = parent::$repositoryKuchi->findOneByName("P_DeleteSubscriptionAction_1");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_Android_1");
        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_Android_2");
        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_Android_3");
        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_iOS_1");
        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_iOS_2");
        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_iOS_3");
        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_WEB);
        
    }
    
    private function template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, $typeResult)
    {                
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'DELETE',
                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId() .'/'.sha1('DELETE /rest/subscription'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        $deletedSubscription = parent::$repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
        $this->checkSubscription($deletedSubscription, false, $typeResult, true);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

     /**
     * Test négatif de DeleteSubscriptionAction avec Komi inconnu.
     */
    public function test_N_DeleteSubscriptionAction_1()            
    {
        $kuchi = parent::$repositoryKuchi->findOneByName("N_DeleteSubscriptionAction_1");
        
        $crawler=$this->client->request(
                'DELETE',
                '/rest/subscription/'.$kuchi->getId().'/'.'0'.'/'.'token',
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(501,$this->client->getResponse()->getStatusCode());
    }

    /**
     * Test négatif de DeleteSubscriptionAction avec kuchi inconnu.
     */
        
    public function test_N_DeleteSubscriptionAction_2()            
    {
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_2_Android");
        $this->template_test_N_DeleteSubscriptionAction_2($komi);   
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_2_IOS");
        $this->template_test_N_DeleteSubscriptionAction_2($komi);   
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_2_WINDOWS");
        $this->template_test_N_DeleteSubscriptionAction_2($komi);
    }
    
    private function template_test_N_DeleteSubscriptionAction_2($komi)            
    {
        $oldToken = $komi->getToken();
        $crawler=$this->client->request(
                'DELETE',
                '/rest/subscription/'.'0'.'/'.$komi->getRandomId().'/'.$komi->getToken(),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(502,$this->client->getResponse()->getStatusCode());
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

        /**
     * Test négatif de DeleteSubscriptionAction de type NFC/QRCode/WEB avec hash invalide
     */
        
    public function test_N_DeleteSubscriptionAction_3()            
    {
        $kuchi = parent::$repositoryKuchi->findOneByName("N_DeleteSubscriptionAction_3");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_Android_1");
        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_Android_2");
        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_Android_3");
        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);

        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_iOS_1");
        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_iOS_2");
        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_iOS_3");
        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
        
    }
    
    private function template_test_N_DeleteSubscriptionAction_3($kuchi, $komi)
    {                
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'DELETE',
                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId() .'/'.'badToken',
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(510,$this->client->getResponse()->getStatusCode());   
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    /**
     * Test négatif de DeleteSubscriptionAction de type NFC/QRCode/WEB avec Komi Android/IOS
     * Subscription already de-activated
     */
        
    public function test_N_DeleteSubscriptionAction_4()            
    {
        $kuchi = parent::$repositoryKuchi->findOneByName("N_DeleteSubscriptionAction_4");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_Android_1");
        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_Android_2");
        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_Android_3");
        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_iOS_1");
        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_iOS_2");
        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_iOS_3");
        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_WEB);
        
    }
    
    private function template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, $typeResult)
    {                
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'DELETE',
                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId() .'/'.sha1('DELETE /rest/subscription'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(508,$this->client->getResponse()->getStatusCode());   
        $deletedSubscription = parent::$repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
        $this->checkSubscription($deletedSubscription, false, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    private function checkSubscription($subscription, $active, $type, $checkSuppression=false)
    {
        $this->assertNotNull($subscription);
        $this->assertEquals($subscription->getActive(), $active);
        $this->assertEquals($subscription->getType(), $type);
        if( $checkSuppression )
        {
            $this->assertNotEquals($subscription->getTimestampCreation(), $subscription->getTimestampSuppression());
        }
    }
    

}
