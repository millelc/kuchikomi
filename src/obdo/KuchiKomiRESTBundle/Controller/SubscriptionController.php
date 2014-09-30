<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\Komi;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;

class SubscriptionController extends Controller
{
    /**
     * @Post("/rest/subscription/{id_kuchi}/{id_komi}/{type}/{hash}")
     * @return array
     * @View()
     */
    public function postSubscriptionAction($id_kuchi, $id_komi, $type, $hash)
    {
        $response = new Response();
                
        $Logger = $this->container->get('obdo_services.Logger');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositorySubscription = $em->getRepository('obdoKuchiKomiRESTBundle:Subscription');
                    
        
        $komi = $repositoryKomi->findOneByRandomId($id_komi);
        
        if( !$komi )
        {
            // Komi unknown !
            $response->setStatusCode(501);
            $Logger->Error("[POST rest/subscription] 501 - Invalid Komi id");
        }
        else
        {
            if( $komi->getActive() )
            {
            
                $kuchi = $repositoryKuchi->findOneById($id_kuchi);
                if( !$kuchi )
                {
                    // kuchi unknown !
                    $response->setStatusCode(502);
                    $Logger->Error("[POST rest/subscription] 502 - Invalid Kuchi id");
                }
                else
                {
                    if( $kuchi->getActive() )
                    {
                        if( $hash == sha1("POST /rest/subscription" . $komi->getToken() ) )
                        {
                            $subscription = $repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
                            if( !$subscription )
                            {
                                $subscription = new Subscription();
                                $subscription->setKomi($komi);
                                $subscription->setKuchi($kuchi);
                                $subscription->setType($type);

                                $em->persist($subscription);
                                $em->flush();
                                $response->setStatusCode(200);
                                //$Logger->Info("[POST rest/subscription] 200 - New subscription (". $komi->getRandomId() ."-". $kuchi->getName().") added");
                            }
                            else
                            {
                                if( !$subscription->getActive() )
                                {
                                    $subscription->setActive(true);
                                    $subscription->setType($type);
                                    $em->flush();
                                    $response->setStatusCode(200);
                                    //$Logger->Info("[POST rest/subscription] 200 - Subscription (". $komi->getRandomId() ."-". $kuchi->getName().") re-activated");
                                }
                                else
                                {
                                    // subscription already exist and active
                                    $response->setStatusCode(511);
                                    $Logger->Warning("[POST rest/subscription] 511 - Subscription (". $komi->getRandomId() ."-". $kuchi->getName().") already exist");
                                }
                            }
                        }
                        else
                        {
                            // hash invalid
                            $response->setStatusCode(510);
                            $Logger->Error("[POST rest/subscription] 510 - Komi id=". $komi->getRandomId() . " - osType=" . $komi->getOsType() . " - hash=" . $hash . " invalid");
                        }            		
                    }
                    else 
                    {
                        // Kuchi inactif
                        $response->setStatusCode(508);
                        $Logger->Warning("[POST rest/subscription] 508 - Kuchi id " . $kuchi->getId() . " inactif");
                    }
                }
            }
            else
            {
                // Komi inactif
                $response->setStatusCode(512);
                $Logger->Warning("[POST rest/subscription] 512 - Komi id " . $komi->getId() . " inactif");
            }
            
            // disable current token
            $komi->generateToken();
            $em->flush();
        }

        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }

    /**
     * @Delete("/rest/subscription/{id_kuchi}/{id_komi}/{hash}")
     * @return array
     * @View()
     */
    public function deleteSubscriptionAction($id_kuchi, $id_komi, $hash)
    {
        $response = new Response();
                
        $Logger = $this->container->get('obdo_services.Logger');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositorySubscription = $em->getRepository('obdoKuchiKomiRESTBundle:Subscription');
        
                    
        
        $komi = $repositoryKomi->findOneByRandomId($id_komi);
        
        if( !$komi )
        {
            // Komi unknown !
            $response->setStatusCode(501);
            $Logger->Error("[DELETE rest/subscription] 501 - Invalid Komi id");
        }
        else
        {
            $kuchi = $repositoryKuchi->findOneById($id_kuchi);
            if( !$kuchi )
            {
                // Kuchi unknown !
                $response->setStatusCode(502);
                $Logger->Error("[DELETE rest/subscription] 502 - Invalid Kuchi id");
            }
            else
            {
                if( $hash == sha1("DELETE /rest/subscription" . $komi->getToken() ) )
                {
                    $subscription = $repositorySubscription->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
                    if( !$subscription )
                    {
                        // subscription unkown
                        $response->setStatusCode(500);
                        $Logger->Error("[DELETE rest/subscription] 500 - Subscription (". $komi->getRandomId() ."-". $kuchi->getName().") unknown");
                    }
                    else
                    {
                        if( !$subscription->getActive() )
                        {
                            // subscription already de-activated
                            $response->setStatusCode(508);
                            $Logger->Warning("[DELETE rest/subscription] 508 - Subscription (". $komi->getRandomId() ."-". $kuchi->getName().") already de-activated");
                        }
                        else
                        {
                            $subscription->setCurrentTimestampSuppression();
                            $subscription->setActive(false);
                            
                            $em->flush();
                            $response->setStatusCode(200);
                            //$Logger->Info("[DELETE rest/subscription] 200 - Subscription (". $komi->getRandomId() ."-". $kuchi->getName().") de-activated");                            
                        }
                    }
                }
                else
                {
                    // hash invalid
                    $response->setStatusCode(510);
                    $Logger->Error("[DELETE rest/subscription] 510 - Komi id=". $komi->getRandomId() . " - osType=" . $komi->getOsType() . " - hash=" . $hash . " invalid");
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
