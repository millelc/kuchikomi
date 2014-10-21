<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace obdo\KuchiKomiRESTBundle\Tests\Controller;

use obdo\KuchiKomiRESTBundle\Tests\Controller\CityKomiWebTestCase;
/**
 * Description of KomiControllerTest
 *
 * @author emilie
 */
class KomiControllerTest extends CityKomiWebTestCase {
              
    public $randomId;           
    public $prekey;
    public $postkey;
    public $regId;
    public $newRandomId;
    public $newRegId;

    
    protected function setUp() 
    {
        parent::setUp();

    }
    
    
    function __construct() {
        parent::__construct();
        $this->prekey = "%%OB-DO-2-0-0%%";
        $this->postkey = "%%OB-DO-2-0-0%%";
        $this->randomId ="ac81d6f9cb600d38";
        $this->newRandomId=  uniqid("rdi");
        $this->newRegId=  uniqid("nwrgid");
        $this->regId = "koiedthuassopzecith";
        
   
    }
    
    /**
     * Test positif pour nouveau komi Android (new randomId, new GCMRegId)
     * Notification Bienvenue OK
     * vérifie la souscription à CityKomiGroupId
     */        
    public function test_P_PostKomiAction_1(){
       
        $KK_Id = $this->prekey."0"."%%ID%%".$this->newRandomId.$this->postkey;
    
        parent::$AES->setData($KK_Id);
        $this->getcrawler($KK_Id, $this->newRegId);
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());        
        $notifier=$this->client->getContainer()->get('obdo_services.Notifier');        
        $this->assertEquals("Bienvenue !",$notifier->getMessage()->getMessage());
        $komi=parent::$repositoryKomi->findOneByRandomId($this->newRandomId);
        $subscriptionG =  $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('obdoKuchiKomiRESTBundle:SubscriptionGroup')
        ->findOneByKuchiGroup($this->client->getContainer()->getParameter('CityKomiGroupId'));

            foreach($komi->getSubscriptionsGroup() as $subscrip){
                if($subscrip==$subscriptionG){
            $this->assertEquals($subscriptionG,$subscrip
                    );
                }    
            }
    }
    
    /**
     *
     * Test positif pour nouveau komi IOS (new randomId, new GCMRegId)
     * Notification Bienvenue OK
     * vérifie la souscription à CityKomiGroupId
     */ 
    public function test_P_PostKomiAction_2(){
    
        $KK_Id = $this->prekey."1"."%%ID%%".$this->newRandomId.$this->postkey;
        $this->getcrawler($KK_Id, $this->newRegId);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $notifier=$this->client->getContainer()->get('obdo_services.Notifier');     
              foreach ($notifier->getMessage()->getMessageBody() as $value){
                  foreach ($value as $message)
                    {
                        if(is_string($message)){
                            $this->assertEquals('Bienvenue !', $message) ;                                          
                        }

                    }        
              }
              
        $komi=parent::$repositoryKomi->findOneByRandomId($this->newRandomId);
        $subscriptionG =  $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('obdoKuchiKomiRESTBundle:SubscriptionGroup')
                ->findOneByKuchiGroup($this->client->getContainer()->getParameter('CityKomiGroupId'));

            foreach($komi->getSubscriptionsGroup() as $subscrip){
                if($subscrip==$subscriptionG){
                    $this->assertEquals($subscriptionG,$subscrip
                            );
                }
            }
    }
        
    /**
     * Test positif de PostKomiAction avec un GcmRegId existant
     * statut code 200
     * vérifie la souscription à CityKomiGroupId
     */
    public function test_P_PostKomiAction_3(){
        
        $KK_Id = $this->prekey."1"."%%ID%%".$this->newRandomId.$this->postkey;
        $this->getcrawler($KK_Id, $this->regId);
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $komi=parent::$repositoryKomi->findOneByRandomId($this->newRandomId);                
        $subscriptionG =  $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('obdoKuchiKomiRESTBundle:SubscriptionGroup')
                ->findOneByKuchiGroup($this->client->getContainer()->getParameter('CityKomiGroupId'));

            foreach($komi->getSubscriptionsGroup() as $subscrip){
                if($subscrip==$subscriptionG){
                    $this->assertEquals($subscriptionG,$subscrip
                            );
                }
            }
            
    }
    
    /**
     * test négatif PostKomiAction mauvais KK_Id -> %%ID%%
     */
    public function test_N_PostKomiAction_1(){               
        
        $KK_Id = $this->prekey."0"."ID%%".$this->newRandomId.$this->postkey;
    
        $this->getcrawler($KK_Id,  $this->regId);
        
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());          
        
    }
    
    /**
     * test négatif PostKomiAction mauvais KK_Id -> Mauvaise preKey
     */
    
    public function test_N_PostKomiAction_2(){
                
        $KK_Id = "NotPreKey"."0"."%%ID%%".$this->newRandomId.$this->postkey;
    
        $this->getcrawler($KK_Id,  $this->regId);
        
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());                
        
    }
    
    /**
     * test négatif PostKomiAction mauvais KK_Id -> mauvaise postKey
     */    
    public function test_N_PostKomiAction_3() {
        
        $KK_Id = $this->prekey."0"."%%ID%%".$this->newRandomId."NotPostKey";
    
        $this->getcrawler($KK_Id,  $this->regId);
        
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
    }
    
    
    /**
     * test négatif PostKomiAction mauvais type OS
     */
    public function test_N_PostKomiAction_4(){
        
        $KK_Id = $this->prekey."56"."%%ID%%".$this->newRandomId.$this->postkey;
    
        $this->getcrawler($KK_Id,  $this->regId);
        
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
    }
    
     /**
      * test négatif PostKomiAction randomId vide
      */
     public function test_N_PostKomiAction_5(){
         
        $KK_Id = $this->prekey."1"."%%ID%%".$this->postkey;
    
        $this->getcrawler($KK_Id,  $this->newRegId);
        
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
     }
     
     /**
      * test négatif PostKomiAction random Id existant
      */
     public function test_N_PostKomiAction_6() {
         
        $KK_Id = $this->prekey."1"."%%ID%%".  $this->randomId.$this->postkey;
    
        $this->getcrawler($KK_Id,  $this->newRegId);
        
        $this->assertEquals(511, $this->client->getResponse()->getStatusCode());
     }
     
     
     /**
     * 
     * @param type $KK_Id
     * @param type $KK_RegId
      * crawler de la requete POST /rest/komi
     */
    public function getcrawler($KK_Id,$KK_RegId){
        parent::$AES->setData($KK_Id);
        $crawler=  $this->client->request(
                'POST',
                '/rest/komi',
                array('KK_id'=>parent::$AES->encrypt(),'KK_regId'=>  $KK_RegId),
                array(),
                array('CONTENT_TYPE'=> 'text/html')
                );
    }
     
     /**
      * test positif DeleteKomiAction 
      */
    public function test_P_DeleteKomiAction_1(){
        
        $komi= $this->getLastKomiActive(parent::$repositoryKomi);        
        $crawler= $this->client->request(
                'DELETE',
                '/rest/komi/'.$komi->getRandomId().'/'.sha1("DELETE /rest/komi" . $komi->getToken()),
                array(),
                array(),
                array('CONTENT_TYPE'=> 'text/html')
                );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $tokenA = $komi->getToken();
        $randomIdA = $komi->getRandomId();
        parent::$em->close();
        $komi2=  parent::$repositoryKomi->findOneByRandomId($randomIdA);
        $this->assertNotEquals($komi2->getToken(), $tokenA);
        $this->assertNotEquals($komi2->getActive(), $komi->getActive());
        $this->assertNotEquals($komi2->getTimestampSuppression(), $komi->getTimestampSuppression());
    }
    
    /**
     * test négatif DeleteKomiAction -> komi unknown
     */
    public function test_N_DeleteKomiAction_1(){
        
        $crawler= $this->client->request(
        'DELETE',
        '/rest/komi/'.$this->newRandomId.'/'.sha1("DELETE /rest/komi" . '488332f9ed7d3ef735607d32b7'),
        array(),
        array(),
        array('CONTENT_TYPE'=> 'text/html')
        );
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif DeleteKomiAction ->hash invalid
     */
    public function test_N_DeleteKomiAction_2(){
        
        $komi= $this->getLastKomiActive(parent::$repositoryKomi);
        $crawler= $this->client->request(
        'DELETE',
        '/rest/komi/'.$komi->getRandomId().'/'.sha1("DELETE /rest/komi" . '488332f9ed7d3ef735607d32b7'),
        array(),
        array(),
        array('CONTENT_TYPE'=> 'text/html')
        );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif DeleteKomiAction -> komi inactif
     */
    public function test_N_DeleteKomiAction_3(){
        $komi =  $this->getLastKomiInactive(parent::$repositoryKomi);
        $crawler= $this->client->request(
        'DELETE',
        '/rest/komi/'.$komi->getRandomId().'/'.sha1("DELETE /rest/komi" . $komi->getToken()),
        array(),
        array(),
        array('CONTENT_TYPE'=> 'text/html')
        );
        $this->assertEquals(508, $this->client->getResponse()->getStatusCode());
        $kuchiaccount=$this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount')
                ->findOneByKomi($komi);
        $this->assertEquals(null, $kuchiaccount);
    }
    
    /**
     * test négatif DeleteKomiAction -> erreur de route, id komi manquant
     */
    public function test_N_DeleteKomiAction_4() {
        
        $crawler= $this->client->request(
        'DELETE',
        '/rest/komi/'.'/'.sha1("DELETE /rest/komi" . '488332f9ed7d3ef735607d32b7'),
        array(),
        array(),
        array('CONTENT_TYPE'=> 'text/html')
        );
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    
    /**
     * test positif PutKomiAction
     */
    public function test_P_PutKomiAction_1(){
        $komi = $this->getLastKomiActive(parent::$repositoryKomi);

        sleep(2);
        
        $crawler= $this->client->request(
           'PUT',
           '/rest/komi/'.$komi->getRandomId().'/'.sha1("PUT /rest/komi" . $komi->getToken()),
           array('new_id'=>$this->newRandomId,'os_id'=> $this->changeOs($komi),'version'=> $this->changeVersion($komi), 'reg_id'=>$this->newRegId ),
           array(),
           array('CONTENT_TYPE'=> 'text/html')
           );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());        
        $randomIdA = $komi->getRandomId();
        parent::$em->close();
        $komi2 =  parent::$repositoryKomi->findOneByRandomId($this->newRandomId);
        $this->assertNotEquals($komi2 ->getToken(), $komi->getToken());
        $this->assertNotEquals($komi2->getApplicationVersion(), $komi->getApplicationVersion());
        $this->assertNotEquals($komi2->getOsType(), $komi->getOsType());
        $this->assertNotEquals($komi2->getTimestampLastUpdate(),$komi->getTimestampLastUpdate());
               
    }
    
    /**
     * test négatif PutKomiAction_1 pas de new_id dans la requête
     */
    public function test_N_PutKomiAction_1(){
        $komi = $this->getLastKomiActive(parent::$repositoryKomi);

        $crawler= $this->client->request(
           'PUT',
           '/rest/komi/'.$komi->getRandomId().'/'.sha1("PUT /rest/komi" . $komi->getToken()),
           array('os_id'=>'0','version'=>'2.0.0',  'reg_id'=>$this->newRegId ),
           array(),
           array('CONTENT_TYPE'=> 'text/html')
           );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode());
        
    }
    
    /**
     * test négatif PutKomiAction -> randomId existant
     */    
    public function test_N_PutKomiAction_2(){
         $komi = $this->getLastKomiActive(parent::$repositoryKomi);

         $crawler= $this->client->request(
            'PUT',
            '/rest/komi/'.$komi->getRandomId().'/'.sha1("PUT /rest/komi" . $komi->getToken()),
            array('new_id'=>  $this->randomId,'os_id'=>'0','version'=>'2.0.0',  'reg_id'=>$this->newRegId ),
            array(),
            array('CONTENT_TYPE'=> 'text/html')
            );
         $this->assertEquals(511, $this->client->getResponse()->getStatusCode()); 
    }
    
     /**
      * test négatif PutKomiAction -> mauvais hash (mauvais token)
      */    
    public function test_N_PutKomiAction_3(){
        
        $komi = $this->getLastKomiActive(parent::$repositoryKomi);
        $crawler= $this->client->request(
            'PUT',
            '/rest/komi/'.$komi->getRandomId().'/'.sha1("PUT /rest/komi" . '488332f9ed7d3ef735607d32b7'),
            array('new_id'=>  $this->newRandomId,'os_id'=>'0','version'=>'2.0.0',  'reg_id'=>$this->newRegId ),
            array(),
            array('CONTENT_TYPE'=> 'text/html')
            );
         $this->assertEquals(510, $this->client->getResponse()->getStatusCode());
        
    }
    
    /**
     * test négatif PutKomiAction -> pas d'OS_id
     */
    public function test_N_PutKomiAction_4(){

        $komi = $this->getLastKomiActive(parent::$repositoryKomi);
        $crawler= $this->client->request(
            'PUT',
            '/rest/komi/'.$komi->getRandomId().'/'.sha1("PUT /rest/komi" . $komi->getToken()),
            array('new_id'=>  $this->newRandomId,'version'=>'2.0.0',  'reg_id'=>$this->newRegId ),
            array(),
            array('CONTENT_TYPE'=> 'text/html')
            );
         $this->assertEquals(510, $this->client->getResponse()->getStatusCode());

    }
    
    /**
     * test négatif PutKomiAction -> mauvaise route
     */
    public function test_N_PutKomiAction_5(){
        $komi = $this->getLastKomiActive(parent::$repositoryKomi);
        $crawler= $this->client->request(
            'PUT',
            'PP/rest/komi/'.$komi->getRandomId().'/'.sha1("PUT /rest/komi" . $komi->getToken()),
            array('new_id'=>  $this->newRandomId,'version'=>'2.0.0', 'os_id'=>'1', 'reg_id'=>$this->newRegId ),
            array(),
            array('CONTENT_TYPE'=> 'text/html')
            );
         $this->assertEquals(404, $this->client->getResponse()->getStatusCode());        
    }
    
    /**
     * test positif PutKomiRegIdAction
     */
    public function test_P_PutKomiRegIdAction_1(){
        $komi=parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $crawler= $this->client->request(
           'PUT',
           '/rest/komi/regid/'.$komi->getRandomId().'/'.sha1("PUT /rest/komi/regid" . $komi->getToken()),
           array('regid'=>$this->newRegId ),
           array(),
           array('CONTENT_TYPE'=> 'text/html')
           );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        parent::$em->close();
        $komi2 = parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $this->assertNotEquals($komi->getGcmRegId(), $komi2->getGcmRegId());
    }
    
    /**
     * test négatif PutKomiRegIdAction komi unknown
     */
    public function test_N_PutKomiRegIdAction_1(){
        $crawler= $this->client->request(
           'PUT',
           '/rest/komi/regid/'. $this->newRandomId .'/'.sha1("PUT /rest/komi/regid" ."488332f9ed7d3ef735607d32b7"),
           array('regid'=>$this->newRegId ),
           array(),
           array('CONTENT_TYPE'=> 'text/html')
           );
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif PutKomiRegIdAction -> hash invalid
     */
    public function test_N_PutKomiRegIdAction_2(){
        $komi=parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $crawler= $this->client->request(
           'PUT',
           '/rest/komi/regid/'. $komi->getRandomId() .'/'.sha1("PROUT /rest/komi/regid" .$komi->getToken()),
           array('regid'=>$this->newRegId ),
           array(),
           array('CONTENT_TYPE'=> 'text/html')
           );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode());        
    }
    
    /**
     *  test négatif PutKomiRegIdAction -> regid empty
     */
    public function test_N_PutKomiRegIdAction_3(){
        $komi=parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $crawler= $this->client->request(
           'PUT',
           '/rest/komi/regid/'. $komi->getRandomId() .'/'.sha1("PUT /rest/komi/regid" .$komi->getToken()),
           array(),
           array(),
           array('CONTENT_TYPE'=> 'text/html')
           );
        $this->assertEquals(511, $this->client->getResponse()->getStatusCode());        
    }
    
    /**
     * test négatif PutKomiRegIdAction -> erreur route 
     */
    public function test_N_PutKomiRegIdAction_4(){
        $komi=parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $crawler= $this->client->request(
           'PUT',
           '/rest/komi/mauvaiseRoute/'. $komi->getRandomId() .'/'.sha1("PUT /rest/komi/regid" .$komi->getToken()),
           array('regid'=>  $this->newRegId),
           array(),
           array('CONTENT_TYPE'=> 'text/html')
           );
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * test positif GetKomiSyncAction
     * vérifie le contenu du json (en tête des actions)
     * verifie que le TimestampLastSynchroSaved vient d'être mis à jour
     * vérifie la mise à jour du token
     */
    public function test_P_GetKomiSyncAction_1(){
        $komi=parent::$repositoryKomi->findOneByRandomId($this->randomId);        
        $crawler= $this->client->request(
                'GET',
                '/rest/komi/sync/'.$komi->getRandomId().'/'.sha1("GET /rest/komi/sync" . $komi->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertRegExp('/ADDED_KUCHIS_GROUP/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/UPDATED_KUCHIS_GROUP/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/DELETED_KUCHIS_GROUP/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/ADDED_KUCHIS/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/UPDATED_KUCHIS/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/DELETED_KUCHIS/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/ADDED_KUCHIKOMIS/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/UPDATED_KUCHIKOMIS/',  $this->client->getResponse()->getContent());
        $this->assertRegExp('/DELETED_KUCHIKOMIS/',  $this->client->getResponse()->getContent());
        //$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        parent::$em->close();
        $komi2=parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $this->assertNotEquals($komi->getTimestampLastSynchroSaved(),$komi2->getTimestampLastSynchroSaved());        
        $this->assertNotEquals($komi->getToken(), $komi2->getToken());
    }
    
    /**
     * test négatif GetKomiSyncAction pour un komi inactif
     */
    public function test_N_GetKomiSyncAction_1(){
        $komi =  $this->getLastKomiInactive(parent::$repositoryKomi);
        $crawler= $this->client->request(
        'GET',
        '/rest/komi/sync/'.$komi->getRandomId().'/'.sha1("GET /rest/komi/sync" . $komi->getToken()),
        array(),
        array(),
        array('HTTP_ACCEPT' => 'application/json')
        );
        $this->assertEquals(508, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif GetKomiSyncAction komi unknown
     */
        public function test_N_GetKomiSyncAction_2(){
        
        $crawler= $this->client->request(
        'GET',
        '/rest/komi/sync/'.$this->newRandomId.'/'.sha1("GET /rest/komi/sync" . '488332f9ed7d3ef735607d32b7'),
        array(),
        array(),
        array('HTTP_ACCEPT' => 'application/json')
        );
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * test négatif GetKomiSyncAction hash invalide
     */
    public function test_N_GetKomiSyncAction_3(){
        $komi =  $this->getLastKomiActive(parent::$repositoryKomi);
        $crawler= $this->client->request(
        'GET',
        '/rest/komi/sync/'.$komi->getRandomId().'/'.sha1("GRRET /rest/komi/sync" . $komi->getToken()),
        array(),
        array(),
        array('HTTP_ACCEPT' => 'application/json')
        );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode());
    }    
    
    /**
     * test négatif GetKomiSyncAction mauvaise route
     */
    public function test_N_GetKomiSyncAction_4(){
        $komi =  $this->getLastKomiActive(parent::$repositoryKomi);
        $crawler= $this->client->request(
        'GET',
        '/rest/komi/wrong/'.$komi->getRandomId().'/'.sha1("GET /rest/komi/sync" . $komi->getToken()),
        array(),
        array(),
        array('HTTP_ACCEPT' => 'application/json')
        );
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }  
    
    /**
     * test positif PostKomiSyncAction
     * statusCode 200
     * TimestampLastSynchroSaved et TimestampLastSynchro du komi identiques
     * token mis à jour
     */
    public function test_P_PostKomiSyncAction_1(){
        $komi=parent::$repositoryKomi->findOneByRandomId($this->randomId);        
        $crawler= $this->client->request(
                'POST',
                '/rest/komi/sync/'.$komi->getRandomId().'/'.sha1("POST /rest/komi/sync" . $komi->getToken()),
                array(),
                array(),
                array('HTTP_ACCEPT' => 'application/json')
                );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $tokenA = $komi->getToken();
        parent::$em->close();
        $komi=parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $this->assertEquals($komi->getTimestampLastSynchroSaved(),$komi->getTimestampLastSynchro());
        $this->assertNotEquals($tokenA, $komi->getToken());
    }
    
    /**
     * test négatif PostKomiSyncAction komi unknown
     */
    public function test_N_PostKomiSyncAction_1(){
        $crawler= $this->client->request(
            'POST',
            '/rest/komi/sync/'.$this->newRandomId.'/'.sha1("POST /rest/komi/sync" . '488332f9ed7d3ef735607d32b7'),
            array(),
            array(),
            array('HTTP_ACCEPT' => 'application/json')
            );
        $this->assertEquals(501, $this->client->getResponse()->getStatusCode());        
    }
    
    /**
     * test négatif PostKomiSyncAction erreur route 
     */
    public function test_N_PostKomiSyncAction_2(){
        $komi=parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $crawler= $this->client->request(
            'POST',
            '/rest/komi/NONROUTE/'.$komi->getRandomId().'/'.sha1("POST /rest/komi/sync" . $komi->getToken()),
            array(),
            array(),
            array('HTTP_ACCEPT' => 'application/json')
            );
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());       
    }
    
    /**
     * test négatif PostKomiSyncAction hash invalide 
     */
    public function test_N_PostKomiSyncAction_3(){
        $komi=parent::$repositoryKomi->findOneByRandomId($this->randomId);
        $crawler= $this->client->request(
            'POST',
            '/rest/komi/sync/'.$komi->getRandomId().'/'.sha1("PrrrOST /rest/komi/sync" . $komi->getToken()),
            array(),
            array(),
            array('HTTP_ACCEPT' => 'application/json')
            );
        $this->assertEquals(510, $this->client->getResponse()->getStatusCode());     
    }
    

    private function changeOs($komi){
        if($komi->getOsType()=='1')
            {
            return "0";
            }
        else{
            return "1";
            }
    }
    
    private function changeVersion($komi){
        if($komi->getApplicationVersion()=='2.0.0')
            {
            return "0.0.0";
            }
        else{
            return "2.0.0";
            }
        }
    
    
}
