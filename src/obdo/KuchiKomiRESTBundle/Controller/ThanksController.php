<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\Thanks;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;


class ThanksController extends Controller
{
    /**
     * @Post("/rest/thanks/{komiId}/{kuchiKomiId}/{hash}")
     * @return array
     * @View()
     */
    public function postThanksAction($komiId, $kuchiKomiId, $hash)
    {
        $response = new Response();
        
        $Logger = $this->container->get('obdo_services.Logger');
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        $repositoryThanks = $em->getRepository('obdoKuchiKomiRESTBundle:Thanks');
        $repositoryKuchiKomi = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi');
        
        $komi = $repositoryKomi->findOneByRandomId($komiId);
        
        if( !$komi )
        {
            // Komi unknown !
            $response->setStatusCode(501);
            $Logger->Error("[POST rest/thanks/] 501 - Komi id=".$komiId." unknown");
        }
        else
        {
            if( $hash == sha1("POST /rest/thanks" . $komi->getToken() ) )
            {
            	$kuchikomi = $repositoryKuchiKomi->findOneById($kuchiKomiId);
            	
                if( !$kuchikomi )
                {
                    // kuchikomi unknown !
                    $response->setStatusCode(503);
                    $Logger->Error("[POST rest/thanks/] 503 - KuchiKomi id=".$kuchiKomiId." unknown");
                }
                else
                {
                    $thanks = $repositoryThanks->findOneBy(array('komiRandomId' => $komi->getRandomId(), 'kuchikomi' => $kuchikomi));

                    if( !$thanks )
                    {
                        $thanks = new Thanks();
                        $thanks->setKomiRandomId($komi->getRandomId() );
                        $thanks->setKuchiKomi($kuchikomi);

                        $kuchikomi->setTimestampLastUpdate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

                        $em->persist($kuchikomi);
                        $em->persist($thanks);
                        $em->flush(); 



                        $response->setStatusCode(200);
                        //$Logger->Info("[POST rest/thanks/] 200 - new Thanks (".$komi->getRandomId()."-".$kuchikomi->getId().") added");
                    }
                    else 
                    {
                        $response->setStatusCode(511);
                        $Logger->Warning("[POST rest/thanks/] 511 - Thanks (".$komi->getRandomId()."-".$kuchikomi->getId().") already done");
                    }
                }
                
            }
            else
            {
                // hash invalid
                $response->setStatusCode(510);
                $Logger->Error("[POST rest/thanks/] 510 - Komi id=". $komi->getRandomId() . " - osType=" . $komi->getOsType() . " - hash=" . $hash . " invalid");
            }
            
            // disable current token
            $komi->generateToken();
            $em->flush();
        }

        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }
    
}
