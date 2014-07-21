<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiAccount;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Delete;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use RMS\PushNotificationsBundle\Message\AndroidMessage;

class KuchiController extends Controller
{

    /**
     * @Put("/rest/kuchi/{komiId}/{id}/{hash}")
     * @return array
     * @View()
     */
    public function putKuchiAction($komiId, $id, $hash)
    {
        $response = new Response();
        
        $Logger = $this->container->get('obdo_services.Logger');
        $Password = $this->container->get('obdo_services.Password');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        
        $kuchi = $repositoryKuchi->findOneById($id);
        
        if( !$kuchi )
        {
            // Kuchi unknown !
            $response->setStatusCode(502);
            $Logger->Error("[PUT rest/kuchi/{komi}/{id}/{hash}] 502 - Kuchi id=".$id." unkonwn");
        }
        else
        {
            $komi = $repositoryKomi->findOneByRandomId($komiId);
            
            if( !$komi )
            {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[PUT rest/kuchi/{komi}/{id}/{hash}] 501 - Komi id=".$komiId." unkonwn");
            }
            else
            {
                $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
	                    
                if (!$kuchiAccount)
                {
                    // kuchi account unknown !
                    $response->setStatusCode(504);
                    $Logger->Error("[PUT rest/kuchi/{komi}/{id}/{hash}] 504 - Kuchi admin account (" . $komi->getRandomId() . "," . $kuchi->getId() . ") unknown");
                }
                else
                {
                    if( $hash == sha1("PUT /rest/kuchi" . $kuchiAccount->getToken() ) )
                    {
                        if( $kuchi->getActive() )
                        {
                            $json = $this->getRequest()->getContent();
                            $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('kuchi' => new JsonEncoder()));
                            $kuchiArray = $serializer->decode($json, 'json');

                            $kuchi->setName($kuchiArray['kuchi']['name']);
                            $kuchi->setPassword($Password->generateHash( $kuchiArray['kuchi']['password'] ));
                            $kuchi->getAddress()->setAddress1( $kuchiArray['kuchi']['address1'] );
                            $kuchi->getAddress()->setAddress2( $kuchiArray['kuchi']['address2'] );
                            $kuchi->getAddress()->setAddress3( $kuchiArray['kuchi']['address3'] );
                            $kuchi->getAddress()->setPostalCode( $kuchiArray['kuchi']['postal_code'] );
                            $kuchi->getAddress()->setCity( $kuchiArray['kuchi']['city'] );

                            $response->setStatusCode(200);
                            $Logger->Info("[PUT rest/kuchi/{komi}/{id}/{hash}] 200 - Kuchi id=".$kuchi->getId()." updated");
                        }
                        else
                        {
                            // kuchi inactive
                            $response->setStatusCode(508);
                            $Logger->Warning("[PUT rest/kuchi/{komi}/{id}/{hash}] 508 - Kuchi id=".$kuchi->getId()." inactive");
                        }
                    }
                    else
                    {
                        // hash invalid
                        $response->setStatusCode(510);
                        $Logger->Error("[PUT rest/kuchi/{komi}/{id}/{hash}] 510 - hash Invalid");
                    }

                    // disable current token
                    $kuchiAccount->generateToken();
                    $em->flush();
                }
            }
        }

        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }

    /**
     * @Delete("/rest/kuchi/sync/{komiId}/{id}/{hash}")
     * @return array
     * @View()
     */
    public function deleteKuchiSyncAction($komiId, $id, $hash)
    {
        $response = new Response();
        
        $Logger = $this->container->get('obdo_services.Logger');
        $Password = $this->container->get('obdo_services.Password');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        
        $kuchi = $repositoryKuchi->findOneById($id);
        
        if( !$kuchi )
        {
            // Kuchi unknown !
            $response->setStatusCode(502);
            $Logger->Error("[DELETE rest/kuchi/sync/{komi}/{id}/{hash}] 502 - Kuchi id=".$id." unkonwn");
        }
        else
        {
            $komi = $repositoryKomi->findOneByRandomId($komiId);
            
            if( !$komi )
            {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[DELETE rest/kuchi/sync/{komi}/{id}/{hash}] 501 - Komi id=".$komiId." unkonwn");
            }
            else
            {
                $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
	                    
                if (!$kuchiAccount)
                {
                    // kuchi account unknown !
                    $response->setStatusCode(504);
                    $Logger->Error("[DELETE rest/kuchi/sync/{komi}/{id}/{hash}] 504 - Kuchi admin account (" . $komi->getRandomId() . "," . $kuchi->getId() . ") unknown");
                }
                else
                {
                    if( $hash == sha1("DELETE /rest/kuchi/sync" . $kuchiAccount->getToken() ) )
                    {
                        if( $kuchi->getActive() )
                        {
                            $kuchiAccount->resetTimestampLastSynchro();

                            $response->setStatusCode(200);
                            $Logger->Info("[DELETE rest/kuchi/sync/{komi}/{id}/{hash}] 200 - Kuchi id=".$kuchi->getId()." last synchro reseted");
                        }
                        else
                        {
                            // kuchi inactive
                            $response->setStatusCode(508);
                            $Logger->Warning("[DELETE rest/kuchi/sync/{komi}/{id}/{hash}] 508 - Kuchi id=".$kuchi->getId()." inactive");
                        }
                    }
                    else
                    {
                        // hash invalid
                        $response->setStatusCode(510);
                        $Logger->Error("[DELETE rest/kuchi/sync/{komi}/{id}/{hash}] 510 - Invalid hash");
                    }

                    // disable current token
                    $kuchiAccount->generateToken();
                    $em->flush();
                }
            }
        }

        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }
    
    /**
     * @Get("/rest/kuchi/sync/{komiId}/{id}/{hash}")
     * @return array
     * @View(serializerGroups={"Synchro"})
     */
    public function getKuchiSyncAction($komiId, $id, $hash)
    {
    	$response = new Response();
    
    	$Logger = $this->container->get('obdo_services.Logger');
    
    	$idCheck = $this->container->get('obdoKuchiKomiRestBundle.idCheck');
    
    	$em = $this->getDoctrine()->getManager();
    
    	$repositorySubscription = $em->getRepository('obdoKuchiKomiRESTBundle:Subscription');
    	$repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
    	$repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
    
    	$kuchi = $repositoryKuchi->findOneById($id);
    
    	if( !$kuchi )
    	{
            // Kuchi unknown !
            $response->setStatusCode(502);
            $Logger->Error("[GET rest/kuchi/sync/{komi}/{id}/{hash}] 502 - Kuchi id=".$id." unkonwn");
    	}
    	else
    	{
            $komi = $repositoryKomi->findOneByRandomId($komiId);
            
            if( !$komi )
            {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[GET rest/kuchi/sync/{komi}/{id}/{hash}] 501 - Komi id=".$komiId." unkonwn");
            }
            else
            {
                $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
	                    
                if (!$kuchiAccount)
                {
                    // kuchi account unknown !
                    $response->setStatusCode(504);
                    $Logger->Error("[GET rest/kuchi/sync/{komi}/{id}/{hash}] 504 - Kuchi admin account (" . $komi->getRandomId() . "," . $kuchi->getId() . ") unknown");
                }
                else
                {
                    if( $hash == sha1("GET /rest/kuchi/sync" . $kuchiAccount->getToken() ) )
                    {
                        if( $kuchi->getActive() )
                        {

                            $addedKuchiKomis = $repositoryKuchiKomi->getAddedKuchiKomisForKuchi( $kuchiAccount );
                            $updatedKuchiKomis = $repositoryKuchiKomi->getUpdatedKuchiKomisForKuchi( $kuchiAccount );
                            $deletedKuchiKomis = $repositoryKuchiKomi->getDeletedKuchiKomisForKuchi( $kuchiAccount );

                            $kuchiAccount->setCurrentTimestampLastSynchroSaved();
                            $kuchiAccount->generateToken();
                            $em->flush();
                            $Logger->Info("[GET rest/kuchi/sync/{id}/{hash}] 200 - Kuchi id=".$kuchi->getId()." synchronized");

                            return array('STATS' => array(
                                                            'NB_SUB' => $kuchi->getNbSubscriptions(),
                                                            'NB_SUB_1MONTH' => $repositorySubscription->getNbSubscriptions($kuchi, 1)
                                                         ),
                                                 'ADDED_KUCHIKOMIS' => $addedKuchiKomis,
                                                 'UPDATED_KUCHIKOMIS' => $updatedKuchiKomis,
                                                 'DELETED_KUCHIKOMIS' => $deletedKuchiKomis);
                        }
                        else
                        {
                            // kuchi inactive
                            $response->setStatusCode(508);
                            $Logger->Warning("[GET rest/kuchi/sync/{komi}/{id}/{hash}] 508 - Kuchi id=".$kuchi->getId()." inactive");
                        }
                    }
                    else
                    {
                        // hash invalid
                        $response->setStatusCode(510);
                        $Logger->Error("[GET rest/kuchi/sync/{komi}/{id}/{hash}] 510 - Invalid hash");
                    }

                    // disable current token
                    $kuchiAccount->generateToken();
                    $em->flush();
                }
            }
    	}
    
    	$response->headers->set('Content-Type', 'text/html');
    
    	return $response;
    }
 
    /**
     * @Post("/rest/kuchi/sync/{komiId}/{id}/{hash}")
     * @return array
     * @View()
     */
    public function postKuchiSyncAction($komiId, $id, $hash)
    {
    	$response = new Response();
    
    	$Logger = $this->container->get('obdo_services.Logger');
    
    	$em = $this->getDoctrine()->getManager();
    
    	$repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
    	$repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
    
    	$kuchi = $repositoryKuchi->findOneById($id);
    
    	if( !$kuchi )
    	{
            // Kuchi unknown !
            $response->setStatusCode(502);
            $Logger->Error("[POST rest/kuchi/sync/{komi}/{id}/{hash}] 502 - Kuchi id=".$id." unkonwn");
    	}
    	else
    	{
            $komi = $repositoryKomi->findOneByRandomId($komiId);
            
            if( !$komi )
            {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[POST rest/kuchi/sync/{komi}/{id}/{hash}] 501 - Komi id=".$komiId." unkonwn");
            }
            else
            {
                $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
	                    
                if (!$kuchiAccount)
                {
                    // kuchi account unknown !
                    $response->setStatusCode(504);
                    $Logger->Error("[POST rest/kuchi/sync/{komi}/{id}/{hash}] 504 - Kuchi admin account (" . $komi->getRandomId() . "," . $kuchi->getId() . ") unknown");
                }
                else
                {
                    if( $hash == sha1("POST /rest/kuchi/sync" . $kuchiAccount->getToken() ) )
                    {
                        
                        $kuchiAccount->validateLastSynchro();
                        $em->flush();
                        $response->setStatusCode(200);
                        $Logger->Info("[POST rest/kuchi/sync/{id}/{hash}] 200 - Kuchi id=".$kuchi->getId()." synchronization ACK");
                    }
                    else
                    {
                        // hash invalid
                        $response->setStatusCode(510);
                        $Logger->Error("[POST rest/kuchi/sync/{komi}/{id}/{hash}] 510 - Invalid hash");
                    }

                    // disable current token
                    $kuchiAccount->generateToken();
                    $em->flush();
                }
            }
    	}
    
    	$response->headers->set('Content-Type', 'text/html');
    
    	return $response;
    }

}
