<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;
use obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup;
use obdo\KuchiKomiRESTBundle\Entity\Thanks;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Get;


class KomiController extends Controller
{
    /**
     * @Post("/rest/komi")
     * @return array
     * @View()
     */
    public function postKomiAction()
    {
        $response = new Response();
                
        $AES = $this->container->get('obdo_services.AES');
        $Logger = $this->container->get('obdo_services.Logger');
        $idCheck = $this->container->get('obdoKuchiKomiRestBundle.idCheck');
        $Notifier = $this->container->get('obdo_services.Notifier');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        $repositoryKuchiGroup = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup');
        
        $AES->setKey( $this->container->getParameter('aes_key') );
        $AES->setBlockSize( $this->container->getParameter('aes_key_size') );
        $AES->setData($this->getRequest()->get('KK_id'));
        
        $clearId = $AES->decrypt();
                    
        if( $idCheck->isPostKomiValid( $clearId) )
        {
            $randomId = $idCheck->getPostKomiRandomId($clearId);
            
            $komi = $repositoryKomi->findOneByRandomId($randomId);
            
            if( !$komi )
            {
                $komi = $repositoryKomi->findOneByGcmRegId($this->getRequest()->get('KK_regId'));
                if ( !$komi )
                {
                    // new Komi
                    $komi = new Komi();
                    $komi->setRandomId($randomId);
                    $komi->setOsType($idCheck->getPostKomiMobileOsId($clearId));
                    $komi->setApplicationVersion( $idCheck->getVersion($clearId) );
                    $komi->setGcmRegId($this->getRequest()->get('KK_regId'));
                    $em->persist($komi);
                    $em->flush();
                
                    // Create by default the subscriptionto the CityKomi group and all of these kuchis
                    $kuchiGroupCityKomi = $repositoryKuchiGroup->findOneById($this->container->getParameter('CityKomiGroupId'));
                    $subscriptionGroup = new SubscriptionGroup();
                    $subscriptionGroup->setKomi($komi);
                    $subscriptionGroup->setKuchiGroup($kuchiGroupCityKomi);
                    $subscriptionGroup->setType(0);
                    $em->persist($subscriptionGroup);

                    foreach($kuchiGroupCityKomi->getKuchis() as $kuchi)
                    {
                            $subscription = new Subscription();
                            $subscription->setKomi($komi);
                            $subscription->setKuchi($kuchi);
                            $subscription->setType(0);

                            $em->persist($subscription);
                    }
                }
                // le komi existait déja avec un autre randomid, on le repasse à actif et on change son randomid
                else{
                    $komi->setRandomId($randomId);
                    $komi->setActive(true);
                }
                // flush des subscription ou du update
                    $em->flush();
                    $response->setStatusCode(200);

                    $Logger->Info("[POST rest/komi] 200 - Komi id=".$komi->getRandomId()." registered");

                    // Post message
                    $Notifier->sendMessage( $komi->getGcmRegId(), $komi->getOsType(), 'Bienvenue !', array("type" => "2"));               
            }
            else
            {
                // Komi already exist !
                $response->setStatusCode(511);
                $Logger->Error("[POST rest/komi] 511 - Komi id=".$komi->getRandomId()." already registered");
            }
        }
        else
        {
            $response->setStatusCode(501);
            $Logger->Error("[POST rest/komi] 501 - Invalid Komi id");
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }
    
     /**
     * @Delete("/rest/komi/{id}/{hash}")
     * @return array
     * @View()
     */
    public function deleteKomiAction($id, $hash)
    {
        $response = new Response();
        
        $Logger = $this->container->get('obdo_services.Logger');
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        
        $komi = $repositoryKomi->findOneByRandomId($id);
        
        if( !$komi )
        {
            // Komi unknown !
            $response->setStatusCode(501);
        }
        else
        {
            if( $hash == sha1("DELETE /rest/komi" . $komi->getToken() ) )
            {
                if( $komi->getActive() )
                {
                    $komi->setTimestampSuppression( new \DateTime('now', new \DateTimeZone('Europe/Paris')) );
                    $komi->resetTimestampLastSynchro();
                    $komi->setActive(false);
        
                    $em->flush();
                    $response->setStatusCode(200);
                    $Logger->Info("[DELETE rest/komi/{id}/{hash}] 200 - Komi id=".$komi->getRandomId()." unregistered");
                }
                else
                {
                    // komi already inactive
                    $response->setStatusCode(508);
                    $Logger->Info("[DELETE rest/komi/{id}/{hash}] 508 - Komi id=".$komi->getRandomId()." already inactive");
                }
                
            }
            else
            {
                // hash invalid
                $response->setStatusCode(510);
                $Logger->Error("[DELETE rest/komi/{id}/{hash}] 510 - Invalid Komi id");
            }
            
            // disable current token
            $komi->generateToken();
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }

    /**
     * @Put("/rest/komi/{id}/{hash}")
     * @return array
     * @View()
     */
    public function putKomiAction($id, $hash)
    {
        $response = new Response();
        
        $Logger = $this->container->get('obdo_services.Logger');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        
        $komi = $repositoryKomi->findOneByRandomId($id);
        
        if( !$komi )
        {
            // Komi unknown !
            $response->setStatusCode(501);
            $Logger->Info("[PUT rest/komi/{id}/{hash}] 501 - Komi id=".$id." unkonwn");
        }
        else
        {
            if( $hash == sha1("PUT /rest/komi" . $komi->getToken() ) )
            {
                if( !$komi->getActive() )
                {
                    $komi->setOsType($this->getRequest()->get('os_id'));
                    $komi->setApplicationVersion($this->getRequest()->get('version'));
                    $komi->setGcmRegId($this->getRequest()->get('reg_id'));
                    $komi->setActive(true);
        
                    $em->flush();
                    $response->setStatusCode(200);
                    $Logger->Info("[PUT rest/komi/{id}/{hash}] 200 - Komi id=".$komi->getRandomId()." updated - " .$komi->getApplicationVersion());
                }
                else
                {
                    // komi already active
                    $response->setStatusCode(507);
                    $Logger->Info("[PUT rest/komi/{id}/{hash}] 507 - Komi id=".$komi->getRandomId()." already active");
                }
                
            }
            else
            {
                // hash invalid
                $response->setStatusCode(510);
                $Logger->Error("[PUT rest/komi/{id}/{hash}] 510 - Invalid Komi id");
            }
            
            // disable current token
            $komi->generateToken();
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }

    /**
     * @Get("/rest/komi/sync/{id}/{hash}")
     * @return array
     * @View(serializerGroups={"Synchro"})
     */
    public function getKomiSyncAction($id, $hash)
    {
    	$response = new Response();
    
    	$Logger = $this->container->get('obdo_services.Logger');
    
    	$idCheck = $this->container->get('obdoKuchiKomiRestBundle.idCheck');
    
    	$em = $this->getDoctrine()->getManager();
    
    	$repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
    	$repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
    	$repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
    	$repositoryKuchiGroup = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup');
    
    	$komi = $repositoryKomi->findOneByRandomId($id);
    
    	if( !$komi )
    	{
    		// Komi unknown !
    		$response->setStatusCode(501);
    		$Logger->Info("[GET rest/komi/sync/{id}/{hash}] 501 - Komi id=".$id." unkonwn");
    	}
    	else
    	{
    		if( $hash == sha1("GET /rest/komi/sync" . $komi->getToken() ) )
    		{
    			if( $komi->getActive() )
    			{
    				$addedKuchis = $repositoryKuchi->getAddedKuchis( $komi );
    				$updatedKuchis = $repositoryKuchi->getUpdatedKuchis( $komi );
    				$deletedKuchis = $repositoryKuchi->getDeletedKuchis( $komi );
    				
    				$addedKuchiGroup = $repositoryKuchiGroup->getAddedGroups( $komi );
    				$updatedKuchiGroup = $repositoryKuchiGroup->getUpdatedGroups( $komi );
    				$deletedKuchiGroup = $repositoryKuchiGroup->getDeletedGroups( $komi );
    				
    				$this->checkSubscriptionGroup($komi, $addedKuchiGroup);
    				$this->checkSubscriptionGroup($komi, $updatedKuchiGroup);
    				$this->checkSubscriptionGroup($komi, $deletedKuchiGroup);
    				
    				$addedKuchiKomis = $repositoryKuchiKomi->getAddedKuchiKomis( $komi );
    				$updatedKuchiKomis = $repositoryKuchiKomi->getUpdatedKuchiKomis( $komi );
    				$deletedKuchiKomis = $repositoryKuchiKomi->getDeletedKuchiKomis( $komi );
    				
    				$this->checkKuchiKomiThanks($komi, $addedKuchiKomis);
    				$this->checkKuchiKomiThanks($komi, $updatedKuchiKomis);
    				$this->checkKuchiKomiThanks($komi, $deletedKuchiKomis);
    				
    				$komi->setCurrentTimestampLastSynchro();
    				$em->flush();
    				$Logger->Info("[GET rest/komi/sync/{id}/{hash}] 200 - Komi id=".$komi->getRandomId()." synchronized");
    				
    				return array('ADDED_KUCHIS_GROUP' => $addedKuchiGroup,
    							 'UPDATED_KUCHIS_GROUP' => $updatedKuchiGroup,
    							 'DELETED_KUCHIS_GROUP' => $deletedKuchiGroup,
    							 'ADDED_KUCHIS' => $addedKuchis,
    				             'UPDATED_KUCHIS' => $updatedKuchis,
    							 'DELETED_KUCHIS' => $deletedKuchis,
    							 'ADDED_KUCHIKOMIS' => $addedKuchiKomis,
    							 'UPDATED_KUCHIKOMIS' => $updatedKuchiKomis,
    							 'DELETED_KUCHIKOMIS' => $deletedKuchiKomis);
    			}
    			else
    			{
    				// komi inactive
    				$response->setStatusCode(508);
    				$Logger->Info("[GET rest/komi/sync/{id}/{hash}] 508 - Komi id=".$komi->getRandomId()." inactive");
    			}
    		}
    		else
    		{
    			// hash invalid
    			$response->setStatusCode(510);
    			$Logger->Error("[GET rest/komi/sync/{id}/{hash}] 510 - Invalid hash");
    		}
    
    		// disable current token
    		$komi->generateToken();
    	}
    
    	$response->headers->set('Content-Type', 'text/html');
    	// affiche les entêtes HTTP suivies du contenu
    	$response->send();
    
    	return $response;
    }
    
    private function checkSubscriptionGroup($komi, $kuchiGroupList)
    {
    	$repositorySubscriptionGroup = $this->getDoctrine()->getManager()->getRepository('obdoKuchiKomiRESTBundle:SubscriptionGroup');
    	
    	foreach($kuchiGroupList as $KuchiGroup)
    	{
    		$subscriptionGroup = $repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $KuchiGroup));
    		if( !$subscriptionGroup )
    		{
    			$KuchiGroup->setSubscribed(false);
    		}
    		else
    		{
    			if( $subscriptionGroup->getActive() )
    			{
    				$KuchiGroup->setSubscribed(true);
    			}
    			else 
    			{
    				$KuchiGroup->setSubscribed(false);
    			}
    		}
    	}
    }
    
    private function checkKuchiKomiThanks($komi, $KuchiKomiList)
    {
    	$repositoryThanks = $this->getDoctrine()->getManager()->getRepository('obdoKuchiKomiRESTBundle:Thanks');
    	 
    	foreach($KuchiKomiList as $KuchiKomi)
    	{
    		$Thanks = $repositoryThanks->findOneBy(array('komi' => $komi, 'kuchikomi' => $KuchiKomi));
    		if( !$Thanks )
    		{
    			$KuchiKomi->setIsThanks(false);
    		}
    		else
    		{
    			$KuchiKomi->setIsThanks(true);
    		}
    	}
    }
}
