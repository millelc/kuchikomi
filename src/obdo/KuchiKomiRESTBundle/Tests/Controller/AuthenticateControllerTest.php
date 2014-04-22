<?php

namespace obdo\KuchiKomiRESTBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticateControllerTest extends WebTestCase
{
	
    public function test_P_PostAuthenticateAction_1()
    {
        $client = static::createClient();

        
        $crawler = $client->request(
        		'POST', 
        		'/rest/authenticate',
        		array('KK_id'=>'v9zHcjqoP4uI3K6iqFoz7d8nfB0y9eD8gnnsHDtiq1XdV+naK3zltm7MOH3OaFh4'),
    			array(),
    			array('CONTENT_TYPE' => 'application/x-www-form-urlencoded')
        		);
        
        $this->assertEquals( 200, $client->getResponse()->getStatusCode());
        $this->assertRegExp('/random_id/', $client->getResponse()->getContent());
        $this->assertRegExp('/token/', $client->getResponse()->getContent());
        
    }
    
    public function test_N_PostAuthenticateAction_1()
    {
    	$client = static::createClient();
    
    
    	$crawler = $client->request(
    			'POST',
    			'/rest/authenticate/N',
    			array('KK_id'=>'v9zHcjqoP4uI3K6iqFoz7d8nfB0y9eD8gnnsHDtiq1XdV+naK3zltm7MOH3OaFh4'),
    			array(),
    			array('CONTENT_TYPE' => 'application/x-www-form-urlencoded')
    	);
    
    	$this->assertEquals( 404, $client->getResponse()->getStatusCode());
    
    }
    
    public function test_N_PostAuthenticateAction_2()
    {
    	$client = static::createClient();
    
    
    	$crawler = $client->request(
    			'POST',
    			'/rest/authenticate',
    			array('KK_id'=>'v9zHcjqoP4uI3K6iqFoz7d8nfB0y9eD8gnnsdfsdfsHDtiq1XdV+naK3zltm7MOH3OaFh45'),
    			array(),
    			array('CONTENT_TYPE' => 'application/x-www-form-urlencoded')
    	);
    
    	$this->assertEquals( 600, $client->getResponse()->getStatusCode());
    
    }
}
