<?php  
namespace obdo\KuchiKomiRESTBundle\Tests\Controller;


//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use obdo\ServicesBundle\Services;
use obdo\KuchiKomiREStBundle\Tests\Controller\CityKomiWebTestCase;


class AuthenticateControllerTest extends CityKomiWebTestCase
{       
    public $KK_id;  
    public $KK_id_invalid_1;
    public $randomId;
    public $KK_idKuchi;
    public $kuchi_id;
    public $password;
    public $prekey;
    public $postkey;  
    

   


    protected function setUp() {
        parent::setUp();
        parent::$AES->setKey(parent::$container->getParameter('aes_key'));
        parent::$AES->setBlockSize(parent::$container->getParameter('aes_key_size'));
        parent::$AES->setIV(parent::$container->getParameter('aes_IV')); 
    }
    
           
 

    
    function __construct() 
    {
        parent::__construct();
        $this->prekey = "%%OB-DO-2-0-0%%";
        $this->postkey = "%%OB-DO-2-0-0%%";
        $this->randomId ="ac81d6f9cb600d38"; 
        $this->kuchi_id ="2";
        $this->password ="david";  

    }
       
    /**
     * Test positif de PostAuthenticateAction 
     * @Post /rest/authenticate
     * 5 assertions:
     * statut code 200
     * regexp json
     * verif du random_Id
     * verif du changement de token
     */
        
    public function test_P_PostAuthenticateAction_1()            
    {
         
        $KK_id =$this->prekey.$this->randomId.$this->postkey; 
        parent::$AES->setData($KK_id); 
        
        $komi = parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $crawler = $this->client->request(
        		'POST', 
        		'/rest/authenticate',
        		array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
        		);
        
        $this->assertEquals( 200, $this->client->getResponse()->getStatusCode()); 
        $this->assertRegExp('/random_id/', $this->client->getResponse()->getContent());
        $this->assertRegExp('/token/', $this->client->getResponse()->getContent());
        
        $ar = preg_split('["]', $this->client->getResponse()->getContent());                      
        $this->assertEquals($this->randomId,$ar[5]);        
        $this->assertNotEquals($komi->getToken(), $ar[9]);        
        
        parent::$em->close();// on ferme l'entity manager pour obtenir une nouvelle connexion à la base.
        
        $komi = parent::$repositoryKomi->findOneByRandomId($this->randomId);
        
        $this->assertEquals($komi->getToken(), $ar[9]);
        
    }
    

    
    /**
     * Test négatif  de PostAuthenticateAction
     * 1 assertion
     * vérifie le code erreur pour une route érronée 
     */
    public function test_N_PostAuthenticateAction_1()
    {
  
        $KK_id =$this->prekey.$this->randomId.$this->postkey;
        parent::$AES->setData($KK_id);

        
    	$crawler = $this->client->request(
    			'POST',
    			'/rest/authenticate/N',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('CONTENT_TYPE' => 'application/x-www-form-urlencoded')
    	);
           
    	$this->assertEquals( 404, $this->client->getResponse()->getStatusCode());                   
    
    }
    
    /**
     * Test négatif de PostAuthenticateAction
     * reponse pour komi unknown
     */
    
    public function test_N_PostAuthenticateAction_2()
    {    	
        
        $KK_id_invalid_1 =$this->prekey."mauvais random Id".$this->postkey;
        parent::$AES->setData($KK_id_invalid_1);
    
    	$crawler = $this->client->request(
    			'POST',
    			'/rest/authenticate',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);
       
        $this->assertEquals( 501, $this->client->getResponse()->getStatusCode());
        
    }
    
     /**
     * Test négatif de PostAuthenticateAction
     * 
     * reponse pour preKey invalide
     */    
    public function test_N_PostAuthenticateAction_3()
    {     
        
        $KK_invalid_pre_key = "%%OB-DO-2-0-0".$this->randomId.$this->postkey;
        parent::$AES->setData($KK_invalid_pre_key);
            	$crawler = $this->client->request(
    			'POST',
    			'/rest/authenticate',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);
            
        $this->assertEquals( 501, $this->client->getResponse()->getStatusCode());
    
    }
    
     /**
     * Test négatif de PostAuthenticateAction
     * 
     * reponse pour postKey invalide
     */    
    
    public function test_N_PostAuthenticateAction_4()
    {        
        
        $KK_invalid_post_key = $this->prekey.$this->randomId."%%OB-DO-2-0-0";
        parent::$AES->setData($KK_invalid_post_key);
            	$crawler = $this->client->request(
    			'POST',
    			'/rest/authenticate',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);
            
        $this->assertEquals( 501, $this->client->getResponse()->getStatusCode());
    
    }
    
    
    /**
     * Test positif de PostAuthenticateKuchiAction
     * 3 assertions : 
     * Statut code : 200
     * nouveau token reponse et token base différents
     * ancien token et token base égaux
     */
    public function test_P_PostAuthenticateKuchiAction_1()
    {  
        
                  
        $kuchi = parent::$repositoryKuchi->findOneById($this->kuchi_id);
        $komi = parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));                
        
        $KK_idKuchi = $this->prekey.$this->randomId."%%ID_KUCHI%%".$this->kuchi_id."%%ID_PWD%%".$this->password.$this->postkey;
        
        parent::$AES->setData($KK_idKuchi); 
        
            	$crawler = $this->client->request(
    			'POST',
    			'/rest/authenticatekuchi',
    			array('KK_id'=>parent::$AES->encrypt()),
                        array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);                
                                             
           $this->assertEquals( 200, $this->client->getResponse()->getStatusCode());
           $this->assertJsonStringNotEqualsJsonString('{"kuchiAccount":{"token":"'.$kuchiAccount->getToken().'"}}',$this->client->getResponse()->getContent());                            
           
           parent::$em->close();
           $kuchiAccount = parent::$repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
           $this->assertJsonStringEqualsJsonString('{"kuchiAccount":{"token":"'.$kuchiAccount->getToken().'"}}',$this->client->getResponse()->getContent());
        
    }
    
    /**
     * Test négatif de PostAuthenticateKuchiAction pour une route inéxacte
     */    
    public function test_N_PostAuthenticateKuchiAction_1()
    {    	        
 
        $KK_idKuchi = $this->prekey.$this->randomId."%%ID_KUCHI%%".$this->kuchi_id."%%ID_PWD%%".$this->password.$this->postkey;
        
        parent::$AES->setData($KK_idKuchi);

    
    	$crawler = $this->client->request(
    			'POST',
    			'/rest/authenticatekuchi/N',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('CONTENT_TYPE' => 'application/x-www-form-urlencoded')
    	);
           
    	$this->assertEquals( 404, $this->client->getResponse()->getStatusCode());                   
    
    }
    
    /**
     * Test négatif de PostAuthenticateKuchiAction pour un mauvais randomIdKomi
     */    
    public function test_N_PostAuthenticateKuchiAction_2()
    {
   
        $KK_idKuchiKomiInvalid = $this->prekey."mauvais randomId"."%%ID_KUCHI%%".$this->kuchi_id."%%ID_PWD%%".$this->password.$this->postkey;
        parent::$AES->setData($KK_idKuchiKomiInvalid);
    
    	$crawler = $this->client->request(
    			'POST',
    			'/rest/authenticatekuchi',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);
    
    	$this->assertEquals( 501, $this->client->getResponse()->getStatusCode()); 
    }
        
    
    /**
     * Test négatif de PostAuthenticateKuchiAction pour un mauvais kuchi 
     */
    public function test_N_PostAuthenticateKuchiAction_3()
    {
                
            
        $KK_idKuchiInvalid = $this->prekey.$this->randomId."%%ID_KUCHI%%"."mauvaisKuchi"."%%ID_PWD%%".$this->password.$this->postkey;
        parent::$AES->setData($KK_idKuchiInvalid);
        
            
            $crawler = $this->client->request(
    			'POST',
    			'/rest/authenticatekuchi',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);
        $this->assertEquals( 502, $this->client->getResponse()->getStatusCode());  
        
    }
        
    /**
     * Test négatif de PostAuthenticateKuchiAction pour un mauvais password
     */        
    public function test_N_PostAuthenticateKuchiAction_4()
    {       

        $KK_idPasswordInvalid = $this->prekey.$this->randomId."%%ID_KUCHI%%".$this->kuchi_id."%%ID_PWD%%"."mauvais password".$this->postkey;
        parent::$AES->setData($KK_idPasswordInvalid) ;
            $crawler = $this->client->request(
                        'POST',
                        '/rest/authenticatekuchi',
                        array('KK_id'=>parent::$AES->encrypt()),
                        array(),
                        array('HTTP_ACCEPT' => 'application/json')
        );
        $this->assertEquals( 503, $this->client->getResponse()->getStatusCode());  

    }

    /**
     * Test négatif de PostAuthenticateKuchiAction pour une clé d'authentification Komi au lieu de Kuchi 
     */
    public function test_N_PostAuthenticateKuchiAction_5()
    {        

        parent::$AES->setData($this->prekey.$this->randomId.$this->postkey);

            $crawler = $this->client->request(
                        'POST',
                        '/rest/authenticatekuchi',
                        array('KK_id'=>parent::$AES->encrypt()),
                        array(),
                        array('HTTP_ACCEPT' => 'application/json')
        );

        $this->assertEquals( 502, $this->client->getResponse()->getStatusCode());        

    }   
        
     /**
      * Test négatif de PostAuthenticateKuchiAction pour une mauvaise preKey
      */   
    public function test_N_PostAuthenticateKuchiAction_6()
    {    
        
        $KK_idKuchiInvalid = "mauvaispreKey".$this->randomId."%%ID_KUCHI%%".$this->kuchi_id."%%ID_PWD%%".$this->password.$this->postkey;
        parent::$AES->setData($KK_idKuchiInvalid);
        
            
            $crawler = $this->client->request(
    			'POST',
    			'/rest/authenticatekuchi',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);
        $this->assertEquals( 502, $this->client->getResponse()->getStatusCode());                   
    
    }
    
    /**
    * Test négatif de PostAuthenticateKuchiAction pour une mauvaise postKey
    */   
    public function test_N_PostAuthenticateKuchiAction_7()
    {    	        
 
        $KK_idKuchiInvalid = $this->prekey.$this->randomId."%%ID_KUCHI%%".$this->kuchi_id."%%ID_PWD%%".$this->password."mauvaise postKey";
        parent::$AES->setData($KK_idKuchiInvalid);
        
            
            $crawler = $this->client->request(
    			'POST',
    			'/rest/authenticatekuchi',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);
        $this->assertEquals( 502, $this->client->getResponse()->getStatusCode());                   
    
    }
    
    /**
     * Test négatif de PostAuthenticateKuchiAction pour une mauvaise Clé (%%ID_KUCHI%% absent)
     */       
    public function test_N_PostAuthenticateKuchiAction_8()
    {    	
        
        
        $KK_idKuchiBadKey = $this->prekey.$this->randomId."%%mauvais ID_KUCHI%%".$this->kuchi_id."%%ID_PWD%%".$this->password.$this->postkey;
        
        parent::$AES->setData($KK_idKuchiBadKey);

    
    	$crawler = $this->client->request(
    			'POST',
    			'/rest/authenticatekuchi',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);
           
    	$this->assertEquals( 502, $this->client->getResponse()->getStatusCode());                   
    
    } 
    
   /**
    * Test négatif de PostAuthenticateKuchiAction pour une mauvaise Clé (%%ID_PWD%% absent)
    */    
    public function test_N_PostAuthenticateKuchiAction_9()
    {
        
 
        $KK_idKuchiBadKey = $this->prekey.$this->randomId."%%ID_KUCHI%%".$this->kuchi_id."%%mauvais ID_PWD%%".$this->password.$this->postkey;
        
        parent::$AES->setData($KK_idKuchiBadKey);

    
    	$crawler = $this->client->request(
    			'POST',
    			'/rest/authenticatekuchi',
    			array('KK_id'=>parent::$AES->encrypt()),
    			array(),
    			array('HTTP_ACCEPT' => 'application/json')
    	);
           
    	$this->assertEquals( 502, $this->client->getResponse()->getStatusCode());                   
    
    }
    
    
}
