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
                
                $photoName = md5(uniqid(rand(), true)) . '.jpeg';
                $photoPath = $this->get('kernel')->getRootDir() . $this->container->getParameter('path_kuchikomi_photo');
                $kuchikomi->setPhotoLink( $photoPath . "/" . $photoName );
                
                $photoByteStream = base64_decode( $kuchikomiArray['kuchikomi']['photo'] );
                $fp = fopen($kuchikomi->getPhotoLink(), 'wb');
                fwrite($fp, $photoByteStream);
                fclose($fp);
                
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
    	
    	foreach ($kuchi->subscriptions as $subscription)
    	{
    		if( $subscription->getActive() )
    		{
    			$komi = $subscription->getKomi();
    			
    			$Notifier->sendMessage( $komi->getGcmRegId(), $komi->getOsType(), $kuchikomi->getTitle(), array("type" => "2"));
    			
    		}
    	}
    }

}
