<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use RMS\PushNotificationsBundle\Message\AndroidMessage;

class KuchiController extends Controller
{

    /**
     * @Put("/rest/kuchi/{id}/{hash}")
     * @return array
     * @View()
     */
    public function putKuchiAction($id, $hash)
    {
        $response = new Response();
        
        $Logger = $this->container->get('obdo_services.Logger');
        $Password = $this->container->get('obdo_services.Password');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        
        $kuchi = $repositoryKuchi->findOneById($id);
        
        if( !$kuchi )
        {
            // Kuchi unknown !
            $response->setStatusCode(501);
            $Logger->Info("[PUT rest/kuchi/{id}/{hash}] 501 - Kuchi id=".$id." unkonwn");
        }
        else
        {
            if( $hash == sha1("PUT /rest/kuchi" . $kuchi->getToken() ) )
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
        
                    $em->flush();
                    $response->setStatusCode(200);
                    $Logger->Info("[PUT rest/kuchi/{id}/{hash}] 200 - Kuchi id=".$kuchi->getId()." updated");
                }
                else
                {
                    // kuchi inactive
                    $response->setStatusCode(502);
                    $Logger->Info("[PUT rest/kuchi/{id}/{hash}] 502 - Kuchi id=".$kuchi->getId()." inactive");
                }
                
            }
            else
            {
                // hash invalid
                $response->setStatusCode(500);
                $Logger->Error("[PUT rest/kuchi/{id}/{hash}] 500 - Invalid Kuchi id");
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
