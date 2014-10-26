<?php  
namespace obdo\KuchiKomiRESTBundle\Tests\Controller;


//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use obdo\ServicesBundle\Services;
use obdo\KuchiKomiRESTBundle\Tests\Controller\CityKomiWebTestCase;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;
use obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup;


class SubscriptionGroupControllerTest extends CityKomiWebTestCase
{       

    
    protected function setUp() {
        parent::setUp();
    }
    
    function __construct() 
    {
        parent::__construct(); 
    }
       
    /**
     * Test positif de PostSubscriptionsAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS/Windows
     * pas de kuchi associé au groupe
     */
        
    public function test_P_PostSubscriptionGroupAction_1()            
    {
        $kuchiGroup = parent::$repositoryKuchiGroup->findOneByName("P_PostSubscriptionGroupAction_1");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_1_Android_1");
        $this->template_test_P_PostSubscriptionGroupAction_1($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_1_Android_2");
        $this->template_test_P_PostSubscriptionGroupAction_1($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_1_Android_3");
        $this->template_test_P_PostSubscriptionGroupAction_1($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_1_Android_4");
        $this->template_test_P_PostSubscriptionGroupAction_1($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_1_iOS_1");
        $this->template_test_P_PostSubscriptionGroupAction_1($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_1_iOS_2");
        $this->template_test_P_PostSubscriptionGroupAction_1($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_1_iOS_3");
        $this->template_test_P_PostSubscriptionGroupAction_1($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_1_iOS_4");
        $this->template_test_P_PostSubscriptionGroupAction_1($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);
    }
    
    private function template_test_P_PostSubscriptionGroupAction_1($kuchiGroup, $komi, $type, $typeResult)
    {
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.$kuchiGroup->getId().'/'.$komi->getRandomId().'/'. $type .'/'.sha1('POST /rest/subscriptions'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        $newSubscriptionGroup = parent::$repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $kuchiGroup));
        $this->checkSubscriptionGroup($newSubscriptionGroup, true, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    /**
     * Test positif de PostSubscriptionsAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS/Windows
     * 2 kuchis associé au groupe
     */
        
    public function test_P_PostSubscriptionGroupAction_2()            
    {
        $kuchiGroup = parent::$repositoryKuchiGroup->findOneByName("P_PostSubscriptionGroupAction_2");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_2_Android_1");
        $this->template_test_P_PostSubscriptionGroupAction_2($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_2_Android_2");
        $this->template_test_P_PostSubscriptionGroupAction_2($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_2_Android_3");
        $this->template_test_P_PostSubscriptionGroupAction_2($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_2_Android_4");
        $this->template_test_P_PostSubscriptionGroupAction_2($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_2_iOS_1");
        $this->template_test_P_PostSubscriptionGroupAction_2($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_2_iOS_2");
        $this->template_test_P_PostSubscriptionGroupAction_2($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_2_iOS_3");
        $this->template_test_P_PostSubscriptionGroupAction_2($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_2_iOS_4");
        $this->template_test_P_PostSubscriptionGroupAction_2($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);
    }
    
    private function template_test_P_PostSubscriptionGroupAction_2($kuchiGroup, $komi, $type, $typeResult)
    {
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.$kuchiGroup->getId().'/'.$komi->getRandomId().'/'. $type .'/'.sha1('POST /rest/subscriptions'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        $newSubscriptionGroup = parent::$repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $kuchiGroup));
        $this->checkSubscriptionGroup($newSubscriptionGroup, true, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    /**
     * Test positif de PostSubscriptionsAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS/Windows
     * 2 kuchis associé au groupe
     * subscription group already exist and active
     */
        
    public function test_P_PostSubscriptionGroupAction_3()            
    {
        $kuchiGroup = parent::$repositoryKuchiGroup->findOneByName("P_PostSubscriptionGroupAction_3");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_3_Android_1");
        $this->template_test_P_PostSubscriptionGroupAction_3($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_3_Android_2");
        $this->template_test_P_PostSubscriptionGroupAction_3($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_3_Android_3");
        $this->template_test_P_PostSubscriptionGroupAction_3($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_3_Android_4");
        $this->template_test_P_PostSubscriptionGroupAction_3($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_3_iOS_1");
        $this->template_test_P_PostSubscriptionGroupAction_3($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_3_iOS_2");
        $this->template_test_P_PostSubscriptionGroupAction_3($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_3_iOS_3");
        $this->template_test_P_PostSubscriptionGroupAction_3($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_3_iOS_4");
        $this->template_test_P_PostSubscriptionGroupAction_3($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);
    }
    
    private function template_test_P_PostSubscriptionGroupAction_3($kuchiGroup, $komi, $type, $typeResult)
    {
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.$kuchiGroup->getId().'/'.$komi->getRandomId().'/'. $type .'/'.sha1('POST /rest/subscriptions'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        $newSubscriptionGroup = parent::$repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $kuchiGroup));
        $this->checkSubscriptionGroup($newSubscriptionGroup, true, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    /**
     * Test positif de PostSubscriptionsAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS/Windows
     * 2 kuchis associé au groupe
     * subscription group already exist but inactive
     */
        
    public function test_P_PostSubscriptionGroupAction_4()            
    {
        $kuchiGroup = parent::$repositoryKuchiGroup->findOneByName("P_PostSubscriptionGroupAction_4");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_4_Android_1");
        $this->template_test_P_PostSubscriptionGroupAction_4($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_4_Android_2");
        $this->template_test_P_PostSubscriptionGroupAction_4($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_4_Android_3");
        $this->template_test_P_PostSubscriptionGroupAction_4($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_4_Android_4");
        $this->template_test_P_PostSubscriptionGroupAction_4($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_4_iOS_1");
        $this->template_test_P_PostSubscriptionGroupAction_4($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_4_iOS_2");
        $this->template_test_P_PostSubscriptionGroupAction_4($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_4_iOS_3");
        $this->template_test_P_PostSubscriptionGroupAction_4($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_4_iOS_4");
        $this->template_test_P_PostSubscriptionGroupAction_4($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);
    }
    
    private function template_test_P_PostSubscriptionGroupAction_4($kuchiGroup, $komi, $type, $typeResult)
    {
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.$kuchiGroup->getId().'/'.$komi->getRandomId().'/'. $type .'/'.sha1('POST /rest/subscriptions'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        $newSubscriptionGroup = parent::$repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $kuchiGroup));
        $this->checkSubscriptionGroup($newSubscriptionGroup, true, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    /**
     * Test positif de PostSubscriptionsAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS/Windows
     * 2 kuchis associé au groupe
     * subscription to a kuchi already exist and active
     */
        
    public function test_P_PostSubscriptionGroupAction_5()            
    {
        $kuchiGroup = parent::$repositoryKuchiGroup->findOneByName("P_PostSubscriptionGroupAction_5");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_5_Android_1");
        $this->template_test_P_PostSubscriptionGroupAction_5($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_5_Android_2");
        $this->template_test_P_PostSubscriptionGroupAction_5($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_5_Android_3");
        $this->template_test_P_PostSubscriptionGroupAction_5($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_5_Android_4");
        $this->template_test_P_PostSubscriptionGroupAction_5($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_5_iOS_1");
        $this->template_test_P_PostSubscriptionGroupAction_5($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_5_iOS_2");
        $this->template_test_P_PostSubscriptionGroupAction_5($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_5_iOS_3");
        $this->template_test_P_PostSubscriptionGroupAction_5($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_5_iOS_4");
        $this->template_test_P_PostSubscriptionGroupAction_5($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);
    }
    
    private function template_test_P_PostSubscriptionGroupAction_5($kuchiGroup, $komi, $type, $typeResult)
    {
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.$kuchiGroup->getId().'/'.$komi->getRandomId().'/'. $type .'/'.sha1('POST /rest/subscriptions'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        $newSubscriptionGroup = parent::$repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $kuchiGroup));
        $this->checkSubscriptionGroup($newSubscriptionGroup, true, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    /**
     * Test positif de PostSubscriptionsAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS/Windows
     * 2 kuchis associé au groupe
     * subscription to a kuchi already exist but inactive
     */
        
    public function test_P_PostSubscriptionGroupAction_6()            
    {
        $kuchiGroup = parent::$repositoryKuchiGroup->findOneByName("P_PostSubscriptionGroupAction_6");
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_6_Android_1");
        $this->template_test_P_PostSubscriptionGroupAction_6($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_6_Android_2");
        $this->template_test_P_PostSubscriptionGroupAction_6($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_6_Android_3");
        $this->template_test_P_PostSubscriptionGroupAction_6($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_6_Android_4");
        $this->template_test_P_PostSubscriptionGroupAction_6($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);

        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_6_iOS_1");
        $this->template_test_P_PostSubscriptionGroupAction_6($kuchiGroup, $komi, Subscription::TYPE_NFC, Subscription::TYPE_NFC);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_6_iOS_2");
        $this->template_test_P_PostSubscriptionGroupAction_6($kuchiGroup, $komi, Subscription::TYPE_QRCode, Subscription::TYPE_QRCode);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_6_iOS_3");
        $this->template_test_P_PostSubscriptionGroupAction_6($kuchiGroup, $komi, Subscription::TYPE_WEB, Subscription::TYPE_WEB);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("P_PostSubscriptionGroupAction_6_iOS_4");
        $this->template_test_P_PostSubscriptionGroupAction_6($kuchiGroup, $komi, 1234567, Subscription::TYPE_WEB);
    }
    
    private function template_test_P_PostSubscriptionGroupAction_6($kuchiGroup, $komi, $type, $typeResult)
    {
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.$kuchiGroup->getId().'/'.$komi->getRandomId().'/'. $type .'/'.sha1('POST /rest/subscriptions'.$komi->getToken()),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
        $newSubscriptionGroup = parent::$repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $kuchiGroup));
        $this->checkSubscriptionGroup($newSubscriptionGroup, true, $typeResult);
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    /**
     * Test négatif de PostSubscriptionGroupAction avec Komi inconnu.
     */
        
    public function test_N_PostSubscriptionGroupAction_1()            
    {
        $this->template_test_N_PostSubscriptionGroupAction_1(SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_1(SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_1(SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_1(123456);
    }
    
    private function template_test_N_PostSubscriptionGroupAction_1($type)            
    {
        $kuchiGroup = parent::$repositoryKuchiGroup->findOneByName("N_PostSubscriptionGroupAction_1");
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.$kuchiGroup->getId().'/'.'0'.'/'.$type.'/'.'token',
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(501,$this->client->getResponse()->getStatusCode());   
    }
    
    /**
     * Test négatif de PostSubscriptionGroupAction avec kuchigroup inconnu.
     */
        
    public function test_N_PostSubscriptionGroupAction_2()            
    {
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_2_Android");
        
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, 123456);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_2_IOS");
        
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, 123456);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionAction_2_WINDOWS");
        
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_2($komi, 123456);
    }
    
    private function template_test_N_PostSubscriptionGroupAction_2($komi, $type)            
    {
        $oldToken = $komi->getToken();
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.'0'.'/'.$komi->getRandomId().'/'.$type.'/'.$komi->getToken(),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(506,$this->client->getResponse()->getStatusCode());
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }

    
    /**
     * Test négatif de PostSubscriptionGroupAction avec komi inactif.
     */
        
    public function test_N_PostSubscriptionGroupAction_3()            
    {
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_3_Android");
        
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, 123456);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_3_IOS");
        
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, 123456);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_3_WINDOWS");
        
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_3($komi, 123456);
    }
    
    private function template_test_N_PostSubscriptionGroupAction_3($komi, $type)            
    {
        $oldToken = $komi->getToken();
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.'0'.'/'.$komi->getRandomId().'/'.$type.'/'.$komi->getToken(),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(512,$this->client->getResponse()->getStatusCode());  
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }
    
    /**
     * Test négatif de PostSubscriptionGroupAction avec kuchigroup inactif.
     */
        
    public function test_N_PostSubscriptionGroupAction_4()            
    {
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_4_Android");
        
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, 123456);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_4_IOS");
        
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, 123456);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_4_WINDOWS");
        
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_4($komi, 123456);
    }
    
    private function template_test_N_PostSubscriptionGroupAction_4($komi, $type)            
    {
        $oldToken = $komi->getToken();
        $kuchiGroup = parent::$repositoryKuchiGroup->findOneByName("N_PostSubscriptionGroupAction_4");
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.$kuchiGroup->getId().'/'.$komi->getRandomId().'/'.$type.'/'.$komi->getToken(),
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(508,$this->client->getResponse()->getStatusCode());
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }
    
    /**
     * Test négatif de PostSubscriptionGroupAction avec token invalid.
     */
        
    public function test_N_PostSubscriptionGroupAction_5()            
    {
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_5_Android");
        
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_5_IOS");
        
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, 4);
        
        $komi = parent::$repositoryKomi->findOneByRandomId("N_PostSubscriptionGroupAction_5_WINDOWS");
        
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, SubscriptionGroup::TYPE_QRCode);   
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, SubscriptionGroup::TYPE_NFC);
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, SubscriptionGroup::TYPE_WEB);
        $this->template_test_N_PostSubscriptionGroupAction_5($komi, 4);
    }
    
    private function template_test_N_PostSubscriptionGroupAction_5($komi, $type)            
    {
        $kuchiGroup = parent::$repositoryKuchiGroup->findOneByName("N_PostSubscriptionGroupAction_5");
        $oldToken = $komi->getToken();
        
        $crawler=$this->client->request(
                'POST',
                '/rest/subscriptions/'.$kuchiGroup->getId().'/'.$komi->getRandomId().'/'.$type.'/'.'bad_token',
                array(),
                array(),
                array()
                );
        
        $this->assertEquals(510,$this->client->getResponse()->getStatusCode()); 
        $this->checkKomiToken($oldToken, $komi->getRandomId());
    }
    
//    /**
//     * Test positif de DeleteSubscriptionAction de type NFC/QRCode/WEB/Inconnu avec Komi Android/IOS
//     */
//        
//    public function test_P_DeleteSubscriptionAction_1()            
//    {
//        $kuchi = parent::$repositoryKuchi->findOneByName("P_DeleteSubscriptionAction_1");
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_Android_1");
//        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_NFC);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_Android_2");
//        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_QRCode);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_Android_3");
//        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_WEB);
//
//        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_iOS_1");
//        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_NFC);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_iOS_2");
//        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_QRCode);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("P_DeleteSubscriptionAction_1_iOS_3");
//        $this->template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, Subscription::TYPE_WEB);
//        
//    }
//    
//    private function template_test_P_DeleteSubscriptionAction_1($kuchi, $komi, $typeResult)
//    {                
//        $oldToken = $komi->getToken();
//        
//        $crawler=$this->client->request(
//                'DELETE',
//                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId() .'/'.sha1('DELETE /rest/subscription'.$komi->getToken()),
//                array(),
//                array(),
//                array()
//                );
//        
//        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());   
//        $deletedSubscription = parent::$repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
//        $this->checkSubscription($deletedSubscription, false, $typeResult, true);
//        $this->checkKomiToken($oldToken, $komi->getRandomId());
//    }
//
//     /**
//     * Test négatif de DeleteSubscriptionAction avec Komi inconnu.
//     */
//    public function test_N_DeleteSubscriptionAction_1()            
//    {
//        $kuchi = parent::$repositoryKuchi->findOneByName("N_DeleteSubscriptionAction_1");
//        
//        $crawler=$this->client->request(
//                'DELETE',
//                '/rest/subscription/'.$kuchi->getId().'/'.'0'.'/'.'token',
//                array(),
//                array(),
//                array()
//                );
//        
//        $this->assertEquals(501,$this->client->getResponse()->getStatusCode());
//    }
//
//    /**
//     * Test négatif de DeleteSubscriptionAction avec kuchi inconnu.
//     */
//        
//    public function test_N_DeleteSubscriptionAction_2()            
//    {
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_2_Android");
//        $this->template_test_N_DeleteSubscriptionAction_2($komi);   
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_2_IOS");
//        $this->template_test_N_DeleteSubscriptionAction_2($komi);   
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_2_WINDOWS");
//        $this->template_test_N_DeleteSubscriptionAction_2($komi);
//    }
//    
//    private function template_test_N_DeleteSubscriptionAction_2($komi)            
//    {
//        $oldToken = $komi->getToken();
//        $crawler=$this->client->request(
//                'DELETE',
//                '/rest/subscription/'.'0'.'/'.$komi->getRandomId().'/'.$komi->getToken(),
//                array(),
//                array(),
//                array()
//                );
//        
//        $this->assertEquals(502,$this->client->getResponse()->getStatusCode());
//        $this->checkKomiToken($oldToken, $komi->getRandomId());
//    }
//
//        /**
//     * Test négatif de DeleteSubscriptionAction de type NFC/QRCode/WEB avec hash invalide
//     */
//        
//    public function test_N_DeleteSubscriptionAction_3()            
//    {
//        $kuchi = parent::$repositoryKuchi->findOneByName("N_DeleteSubscriptionAction_3");
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_Android_1");
//        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_Android_2");
//        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_Android_3");
//        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
//
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_iOS_1");
//        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_iOS_2");
//        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_3_iOS_3");
//        $this->template_test_N_DeleteSubscriptionAction_3($kuchi, $komi);
//        
//    }
//    
//    private function template_test_N_DeleteSubscriptionAction_3($kuchi, $komi)
//    {                
//        $oldToken = $komi->getToken();
//        
//        $crawler=$this->client->request(
//                'DELETE',
//                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId() .'/'.'badToken',
//                array(),
//                array(),
//                array()
//                );
//        
//        $this->assertEquals(510,$this->client->getResponse()->getStatusCode());   
//        $this->checkKomiToken($oldToken, $komi->getRandomId());
//    }
//
//    /**
//     * Test négatif de DeleteSubscriptionAction de type NFC/QRCode/WEB avec Komi Android/IOS
//     * Subscription already de-activated
//     */
//        
//    public function test_N_DeleteSubscriptionAction_4()            
//    {
//        $kuchi = parent::$repositoryKuchi->findOneByName("N_DeleteSubscriptionAction_4");
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_Android_1");
//        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_NFC);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_Android_2");
//        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_QRCode);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_Android_3");
//        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_WEB);
//
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_iOS_1");
//        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_NFC);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_iOS_2");
//        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_QRCode);
//        
//        $komi = parent::$repositoryKomi->findOneByRandomId("N_DeleteSubscriptionAction_4_iOS_3");
//        $this->template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, Subscription::TYPE_WEB);
//        
//    }
//    
//    private function template_test_N_DeleteSubscriptionAction_4($kuchi, $komi, $typeResult)
//    {                
//        $oldToken = $komi->getToken();
//        
//        $crawler=$this->client->request(
//                'DELETE',
//                '/rest/subscription/'.$kuchi->getId().'/'.$komi->getRandomId() .'/'.sha1('DELETE /rest/subscription'.$komi->getToken()),
//                array(),
//                array(),
//                array()
//                );
//        
//        $this->assertEquals(508,$this->client->getResponse()->getStatusCode());   
//        $deletedSubscription = parent::$repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
//        $this->checkSubscription($deletedSubscription, false, $typeResult);
//        $this->checkKomiToken($oldToken, $komi->getRandomId());
//    }

    private function checkSubscriptionGroup($subscriptionGroup, $active, $type, $checkSuppression=false)
    {
        $this->assertNotNull($subscriptionGroup);
        $this->assertEquals($subscriptionGroup->getActive(), $active);
        $this->assertEquals($subscriptionGroup->getType(), $type);
        if( $checkSuppression )
        {
            $this->assertNotEquals($subscriptionGroup->getTimestampCreation(), $subscriptionGroup->getTimestampSuppression());
        }
        $kuchiGroup = $subscriptionGroup->getKuchiGroup();
        $kuchis = $kuchiGroup->getKuchis();
        foreach($kuchis as $kuchi)
        {
            $subscription = parent::$repositorySubscription->findOneBy(array('komi' => $subscriptionGroup->getKomi(), 'kuchi' => $kuchi));
            $this->assertNotNull($subscription);
            $this->assertEquals($subscription->getActive(), $active);
            $this->assertEquals($subscription->getType(), $type);
            if( $checkSuppression )
            {
                $this->assertNotEquals($subscription->getTimestampCreation(), $subscription->getTimestampSuppression());
            }
        }
    }
    

}
