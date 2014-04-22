<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\Komi;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;
use obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;

class SubscriptionGroupController extends Controller
{
    /**
     * @Post("/rest/subscriptions/{id_group}/{id_komi}/{type}/{hash}")
     * @return array
     * @View()
     */
    public function postSubscriptionsAction($id_group, $id_komi, $type, $hash)
    {
        $response = new Response();
                
        $Logger = $this->container->get('obdo_services.Logger');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        $repositoryKuchiGroup = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup');
        $repositorySubscription = $em->getRepository('obdoKuchiKomiRESTBundle:Subscription');
        $repositorySubscriptionGroup = $em->getRepository('obdoKuchiKomiRESTBundle:SubscriptionGroup');
        
                    
        
        $komi = $repositoryKomi->findOneByRandomId($id_komi);
        
        if( !$komi )
        {
            // Komi unknown !
            $response->setStatusCode(501);
            $Logger->Error("[POST rest/subscriptions] 501 - Invalid Komi id");
        }
        else
        {
            $kuchiGroup = $repositoryKuchiGroup->findOneById($id_group);
            if( !$kuchiGroup )
            {
                // kuchi group unknown !
                $response->setStatusCode(502);
                $Logger->Error("[POST rest/subscriptions] 502 - Invalid Kuchi group id");
            }
            else
            {
            	if( $kuchiGroup->getActive() )
            	{
	            	if( $hash == sha1("POST /rest/subscriptions" . $komi->getToken() ) )
	                {
	                    $subscriptionGroup = $repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $kuchiGroup));
	                    if( !$subscriptionGroup )
	                    {
	                        $subscriptionGroup = new SubscriptionGroup();
	                        $subscriptionGroup->setKomi($komi);
	                        $subscriptionGroup->setKuchiGroup($kuchiGroup);
	                        $subscriptionGroup->setType($type);
	                        
	                        $kuchis = $kuchiGroup->getKuchis();
	                        foreach($kuchis as $kuchi)
	                        {
	                        	$subscription = $repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
	                        	
	                        	if( !$subscription )
	                        	{
	                        		$subscription = new Subscription();
	                        		$subscription->setKomi($komi);
	                        		$subscription->setKuchi($kuchi);
	                        		$subscription->setType($type);
	                        		 
	                        		$em->persist($subscription);
	                        	}
	                        	else 
	                        	{
	                        		$subscription->setActive(true);
	                        		$subscription->setType($type);
	                        	}
	                        	$em->persist($subscription);
	                        }
	                        
	                        $em->persist($subscriptionGroup);
	                        $em->flush();
	                        $response->setStatusCode(200);
	                        $Logger->Info("[POST rest/subscriptions] 200 - New subscriptionGroup (". $komi->getRandomId() ."-". $kuchiGroup->getName().") added");
	                    }
	                    else
	                    {
	                        if( !$subscriptionGroup->getActive() )
	                        {
	                        	// re-activate the subscription to the group
	                            $subscriptionGroup->setActive(true);
	                            $subscriptionGroup->setType($type);
	                            
	                            // re-activate the subscription to all existing kuchis from the group
	                            $kuchis = $kuchiGroup->getKuchis();
	                            foreach($kuchis as $kuchi)
	                            {
	                            	$subscription = $repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
	                            	if( $subscription )
	                            	{
	                  					$subscription->setActive(true);
	                            		$em->persist($subscription);
	                            	}
	                            }
	                            
	                            $em->flush();
	                            $response->setStatusCode(200);
	                            $Logger->Info("[POST rest/subscriptions] 200 - SubscriptionGroup (". $komi->getRandomId() ."-". $kuchiGroup->getName().") re-activated");
	                        }
	                        else
	                        {
	                            // subscription group already exist and active
	                            $response->setStatusCode(503);
	                            $Logger->Warning("[POST rest/subscriptions] 503 - SubscriptionGroup (". $komi->getRandomId() ."-". $kuchiGroup->getName().") already exist");
	                        }
	                    }
	                }
	                else
	                {
	                    // hash invalid
	                    $response->setStatusCode(600);
	                    $Logger->Error("[POST rest/subscriptions] 600 - hash invalide");
	                }
            	}
	            else
	            {
	            	// Kuchi group inactif
	            	$response->setStatusCode(504);
	            	$Logger->Error("[POST rest/subscription] 504 - KuchiGroup id " . $kuchiGroup->getId() . " inactif");
	            }	 
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
     * @Delete("/rest/subscriptions/{id_group}/{id_komi}/{opt}/{hash}")
     * @return array
     * @View()
     */
    public function deleteSubscriptionsAction($id_group, $id_komi, $opt, $hash)
    {
        $response = new Response();
                
        $Logger = $this->container->get('obdo_services.Logger');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        $repositoryKuchiGroup = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup');
        $repositorySubscription = $em->getRepository('obdoKuchiKomiRESTBundle:Subscription');
        $repositorySubscriptionGroup = $em->getRepository('obdoKuchiKomiRESTBundle:SubscriptionGroup');
        
                    
        
        $komi = $repositoryKomi->findOneByRandomId($id_komi);
        
        if( !$komi )
        {
            // Komi unknown !
            $response->setStatusCode(501);
            $Logger->Error("[DELETE rest/subscriptions] 501 - Invalid Komi id");
        }
        else
        {
            $kuchiGroup = $repositoryKuchiGroup->findOneById($id_group);
            if( !$kuchiGroup )
            {
                // Kuchi group unknown !
                $response->setStatusCode(502);
                $Logger->Error("[DELETE rest/subscriptions] 502 - Invalid Kuchi group id");
            }
            else
            {
                if( $hash == sha1("DELETE /rest/subscriptions" . $komi->getToken() ) )
                {
                    $subscriptionGroup = $repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $kuchiGroup));
                    if( !$subscriptionGroup )
                    {
                        // subscription group unkown
                        $Logger->Warning("[DELETE rest/subscriptions] 503 - Subscription group(". $komi->getRandomId() ."-". $kuchiGroup->getName().") unknown");
                    }
                    else
                    {
                    	if( !$subscriptionGroup->getActive() )
                    	{
                    		// subscription group already de-activated
                    		$Logger->Warning("[DELETE rest/subscriptions] 504 - Subscription group (". $komi->getRandomId() ."-". $kuchiGroup->getName().") already de-activated");
                    	}
                    	else
                    	{
                    		$subscriptionGroup->setCurrentTimestampSuppression();
                    		$subscriptionGroup->setActive(false);
                    		$Logger->Info("[DELETE rest/subscriptions] 200 - Subscription group(". $komi->getRandomId() ."-". $kuchiGroup->getName().") de-activated");
                    	}
                    }
                    
                    switch ($opt)
                    {
                    	case 1:
            	            // unsuscribe all kumi from the groupe
                            $kuchis = $kuchiGroup->getKuchis();
                            foreach($kuchis as $kuchi)
                            {
                	            $subscription = $repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
                                if( $subscription )
                                {
                                	$subscription->setCurrentTimestampSuppression();
                                    $subscription->setActive(false);
                                    $em->persist($subscription);
                                }
                            }
                        break;
                    }
                            
                    $em->flush();
                    $response->setStatusCode(200);
                    $Logger->Info("[DELETE rest/subscriptions] 200 - Subscription group(". $komi->getRandomId() ."-". $kuchiGroup->getName().") de-activated");      
                }
                else
                {
                    // hash invalid
                    $response->setStatusCode(600);
                    $Logger->Error("[DELETE rest/subscriptions] 600 - hash invalide");
                }
            }
            
            // disable current token
            $komi->generateToken();
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }
}
