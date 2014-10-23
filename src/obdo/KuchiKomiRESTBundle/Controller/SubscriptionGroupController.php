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
            if( $komi->getActive() )
            {
                $kuchiGroup = $repositoryKuchiGroup->findOneById($id_group);
                if( !$kuchiGroup )
                {
                    // kuchi group unknown !
                    $response->setStatusCode(506);
                    $Logger->Error("[POST rest/subscriptions] 506 - Invalid Kuchi group id");
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
                            }
                            $subscriptionGroup->setActive(true);
                            
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
                            //$Logger->Info("[POST rest/subscriptions] 200 - New subscriptionGroup (". $komi->getRandomId() ."-". $kuchiGroup->getName().") added");
                        }
                        else
                        {
                            // hash invalid
                            $response->setStatusCode(510);
                            $Logger->Error("[POST rest/subscriptions] 510 - Komi id=". $komi->getRandomId() . " - osType=" . $komi->getOsType() . " - hash=" . $hash . " invalid");
                        }
                    }
                    else
                    {
                        // Kuchi group inactif
                        $response->setStatusCode(508);
                        $Logger->Warning("[POST rest/subscriptions] 508 - KuchiGroup id " . $kuchiGroup->getId() . " inactif");
                    }	 
                }
            }
            else
            {
               // Komi inactif
                $response->setStatusCode(512);
                $Logger->Warning("[POST rest/subscriptions] 512 - Komi id " . $komi->getId() . " inactif");                
            }
            
            // disable current token
            $komi->generateToken();
            $em->flush();
        }

        $response->headers->set('Content-Type', 'text/html');
        
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
                $response->setStatusCode(506);
                $Logger->Error("[DELETE rest/subscriptions] 506 - Invalid Kuchi group id");
            }
            else
            {
                if( $hash == sha1("DELETE /rest/subscriptions" . $komi->getToken() ) )
                {
                    $subscriptionGroup = $repositorySubscriptionGroup->findOneBy(array('komi' => $komi, 'kuchiGroup' => $kuchiGroup));
                    if( !$subscriptionGroup )
                    {
                        // subscription group unkown
                    	$response->setStatusCode(505);
                        $Logger->Warning("[DELETE rest/subscriptions] 505 - Subscription group(". $komi->getRandomId() ."-". $kuchiGroup->getName().") unknown");
                    }
                    else
                    {
                    	if( !$subscriptionGroup->getActive() )
                    	{
                            // subscription group already de-activated
                            $response->setStatusCode(508);
                            $Logger->Warning("[DELETE rest/subscriptions] 508 - Subscription group (". $komi->getRandomId() ."-". $kuchiGroup->getName().") already de-activated");
                    	}
                    	else
                    	{
                            $subscriptionGroup->setCurrentTimestampSuppression();
                            $subscriptionGroup->setActive(false);
                            $response->setStatusCode(200);
                            //$Logger->Info("[DELETE rest/subscriptions] 200 - Subscription group(". $komi->getRandomId() ."-". $kuchiGroup->getName().") de-activated");
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
                }
                else
                {
                    // hash invalid
                    $response->setStatusCode(510);
                    $Logger->Error("[DELETE rest/subscriptions] 510 - hash invalide");
                }
            }
            
            // disable current token
            $komi->generateToken();
            $em->flush();
        }

        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }
}
