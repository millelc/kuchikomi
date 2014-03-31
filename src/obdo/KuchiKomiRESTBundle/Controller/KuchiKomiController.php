<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;

class KuchiKomiController extends Controller
{
    /**
     * @Post("/rest/kuchikomi/{id_kuchi}/{hash}")
     * @return array
     * @View()
     */
    public function postKuchiKomiAction($id_kuchi, $hash)
    {
        $response = new Response();
                
        $Logger = $this->container->get('obdo_services.Logger');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
                    
        
        $kuchi = $repositoryKuchi->findOneById($id_kuchi);
        if( !$kuchi )
        {
            // kuchi unknown !
            $response->setStatusCode(501);
            $Logger->Error("[POST rest/kuchikomi] 501 - Invalid Kuchi id");
        }
        else
        {
            if( $hash == sha1("POST /rest/kuchikomi" . $kuchi->getToken() ) )
            {
                $json = $this->getRequest()->getContent();
                $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('kuchikomi' => new JsonEncoder()));
                $kuchikomiArray = $serializer->decode($json, 'json');
                $kuchikomi = new KuchiKomi();
                
                $timestampBegin = new \DateTime();
                $timestampBegin->setTimestamp($kuchikomiArray['kuchikomi']['timestampBegin']);
                $timestampEnd = new \DateTime();
                $timestampEnd->setTimestamp($kuchikomiArray['kuchikomi']['timestampEnd']);
        
                $kuchikomi->setKuchi($kuchi);
                $kuchikomi->setTitle($kuchikomiArray['kuchikomi']['title']);
                $kuchikomi->setDetails($kuchikomiArray['kuchikomi']['details']);
                $kuchikomi->setTimestampBegin($timestampBegin);
                $kuchikomi->setTimestampEnd($timestampEnd);
                
                if( $kuchikomiArray['kuchikomi']['photo'] != "" )
                {
                	$photoName = md5(uniqid(rand(), true)) . '.jpg';
                	$kuchikomi->setPhotoLink( $kuchi->getPhotoKuchiKomiLink() . $photoName );
                
                	$photoByteStream = base64_decode( $kuchikomiArray['kuchikomi']['photo'] );
                	$fp = fopen($kuchikomi->getPhotoLink(), 'wb');
                	fwrite($fp, $photoByteStream);
                	fclose($fp);
                }
                
                
                $em->persist($kuchikomi);
                $em->flush();
                
                $this->sendKuchiKomiNotification($kuchi, $kuchikomi);
                
                $response->setStatusCode(200);
                $Logger->Info("[POST rest/kuchikomi] 200 - kuchikomi");
            }
            else
            {
                // hash invalid
                $response->setStatusCode(500);
                $Logger->Error("[POST rest/kuchikomi] 500 - hash invalide");
            }

            // disable current token
            $kuchi->generateToken();
        
        }
            

        $response->headers->set('Content-Type', 'text/html');
        $response->setContent("");
        $response->send();
        
        return $response;
    }
    
    /**
     * Set a new notification to all Komi suscribers
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi
     * @return Kuchi
     */
    private function sendKuchiKomiNotification(\obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchi, \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi)
    {	
    	$Notifier = $this->container->get('obdo_services.Notifier');
    	
    	$subscriptions = $kuchi->getSubscriptions();
    	foreach ($subscriptions as $subscription)
    	{
    		if( $subscription->getActive() )
    		{
    			$komi = $subscription->getKomi();
    			
    			$Notifier->sendMessage( $komi->getGcmRegId(), $komi->getOsType(), $kuchikomi->getTitle(), array("type" => "2"));
    			
    		}
    	}
    }
    
    /**
     * @Delete("/rest/kuchikomi/{id_kuchi}/{id_kuchikomi}/{hash}")
     * @return array
     * @View()
     */
    public function deleteKuchiKomiAction($id_kuchi, $id_kuchikomi, $hash)
    {
    	$response = new Response();
    
    	$Logger = $this->container->get('obdo_services.Logger');
    	$em = $this->getDoctrine()->getManager();
    
    	$repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
    	$repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
    
    	$kuchi = $repositoryKuchi->findOneById($id_kuchi);
    
    	if( !$kuchi )
    	{
    		// kuchi unknown !
    		$Logger->Info("[DELETE rest/kuchikomi/{id_kuchi}/{id_kuchikomi}/{hash}] 501 - Kuchi id=".$id_kuchi." unknown...");
    		$response->setStatusCode(501);
    	}
    	else
    	{
    		if( true ) //$hash == sha1("DELETE /rest/kuchikomi" . $kuchi->getToken() ) )
    		{
    			$kuchikomi = $repositoryKuchiKomi->findOneById($id_kuchikomi);
    			
    			if( !$kuchikomi )
    			{
    				// kuchikomi unknown
    				$response->setStatusCode(502);
    				$Logger->Info("[DELETE rest/kuchikomi/{id_kuchi}/{id_kuchikomi}/{hash}] 502 - KuchiKomi id=".$id_kuchikomi." unknown...");
    			}
    			else 
    			{
    				$kuchikomi->setTimestampSuppression( new \DateTime('now', new \DateTimeZone('Europe/Paris')) );
    				$kuchikomi->setActive(false);
    
    				$em->flush();
    				$response->setStatusCode(200);
    				$Logger->Info("[DELETE rest/kuchikomi/{id_kuchi}/{id_kuchikomi}/{hash}] 200 - KuchiKomi id=".$kuchikomi->getId()." deleted");
    			}
    		}
    		else
    		{
    			// hash invalid
    			$response->setStatusCode(500);
    			$Logger->Error("[DELETE rest/kuchikomi/{id_kuchi}/{id_kuchikomi}/{hash}] 500 - Invalid hash");
    		}
    
    		// disable current token
    		$kuchi->generateToken();
    	}
    
    	$response->headers->set('Content-Type', 'text/html');
    	// affiche les entêtes HTTP suivies du contenu
    	$response->send();
    
    	return $response;
    }
    

}
