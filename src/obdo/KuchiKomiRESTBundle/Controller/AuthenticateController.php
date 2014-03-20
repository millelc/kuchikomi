<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;

class AuthenticateController extends Controller
{
    /**
     * @Post("/rest/authenticate")
     * @return array
     * @View()
     */
    public function postAuthenticateAction()
    {
        $response = new Response();
                
        $AES = $this->container->get('obdo_services.AES');
        $Logger = $this->container->get('obdo_services.Logger');
        $idCheck = $this->container->get('obdoKuchiKomiRestBundle.idCheck');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        
        
        $AES->setKey( $this->container->getParameter('aes_key') );
        $AES->setBlockSize( $this->container->getParameter('aes_key_size') );
        $AES->setData($this->getRequest()->get('KK_id'));
        
        $clearId = $AES->decrypt();
        
        if( $idCheck->isPostAuthenticateValid( $clearId) )
        {
            $randomId = $idCheck->getPostAuthenticateRandomId($clearId);
            
            $komi = $repositoryKomi->findOneByRandomId($randomId);
            
            if( !$komi )
            {
                // Komi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[POST rest/authenticate] 501 - Komi id=".$randomId." unkonwn");
            }
            else
            {   
                // Token génération
                $komi->generateToken();
                
                $em->persist($komi);
                $em->flush();
                
                return array('komi' => $komi);
                
            }
        }
        else
        {
            $response->setStatusCode(500);
            $Logger->Error("[POST rest/authenticate] 500 - Invalid Komi id");                
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }
    
        /**
     * @Post("/rest/authenticatekuchi")
     * @return array
     * @View()
     */
    public function postAuthenticateKuchiAction()
    {
        $response = new Response();
                
        $AES = $this->container->get('obdo_services.AES');
        $Logger = $this->container->get('obdo_services.Logger');
        $idCheck = $this->container->get('obdoKuchiKomiRestBundle.idCheck');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        
        
        $AES->setKey( $this->container->getParameter('aes_key') );
        $AES->setBlockSize( $this->container->getParameter('aes_key_size') );
        $AES->setData($this->getRequest()->get('KK_id'));
        
        $clearId = $AES->decrypt();
        
        if( $idCheck->isPostAuthenticateKuchiValid( $clearId) )
        {
            $kuchiId = $idCheck->getPostAuthenticateKuchiId($clearId);
            
            $kuchi = $repositoryKuchi->findOneById($kuchiId);
            
            if( !$kuchi )
            {
                // Kuchi unknown !
                $response->setStatusCode(501);
                $Logger->Error("[POST rest/authenticatekuchi] 501 - Kuchi id=".$kuchiId." unkonwn");
            }
            else
            {   
            	$password = $idCheck->getPostAuthenticateKuchiPassword($clearId);
            	
                // Check Password
            	$passwordHash = hash("sha256", $this->container->getParameter('sha256_salt2').hash("sha256", hash("sha256", $password) . $this->container->getParameter('sha256_salt1')));
                if( $passwordHash == $kuchi->getPassword() )
                {
                	// Token génération
                	$kuchi->generateToken();
                	 
                	$em->persist($kuchi);
                	$em->flush();
                	 
                	return array('kuchi' => $kuchi);
                }
                else
                {
                	// password not match !
                	$response->setStatusCode(502);
                	$Logger->Error("[POST rest/authenticatekuchi] 502 - Kuchi id=".$kuchiId." - password not match");
                }
                             
            }
        }
        else
        {
            $response->setStatusCode(500);
            $Logger->Error("[POST rest/authenticatekuchi] 500 - Invalid Kuchi id");                
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }
    
}
