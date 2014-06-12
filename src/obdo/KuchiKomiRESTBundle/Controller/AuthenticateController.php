<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiAccount;
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
     * @View(serializerGroups={"Authenticate"})
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
        $AES->setIV( $this->container->getParameter('aes_IV') );
        
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
                $Logger->Error("[POST rest/authenticate] 501 - Komi id=".$randomId." unknown");
            }
            else
            {   
            	// Token génération
                $komi->generateToken();
                
                $em->persist($komi);
                $em->flush();
                
                $response->headers->set('Content-Type', 'application/json');
                return array('komi' => $komi);               
            }
        }
        else
        {
        	$response->setStatusCode(501);
            $Logger->Error("[POST rest/authenticate] 501 - Invalid Komi id");                
        }

        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
        /**
     * @Post("/rest/authenticatekuchi")
     * @return array
     * @View(serializerGroups={"Authenticate"})
     */
    public function postAuthenticateKuchiAction()
    {
        
        $response = new Response();
                
        $AES = $this->container->get('obdo_services.AES');
        $Logger = $this->container->get('obdo_services.Logger');
        $idCheck = $this->container->get('obdoKuchiKomiRestBundle.idCheck');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        $repositoryKuchi = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi');
        $repositoryKuchiAccount = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiAccount');
        
        $AES->setKey( $this->container->getParameter('aes_key') );
        $AES->setBlockSize( $this->container->getParameter('aes_key_size') );
        $AES->setData($this->getRequest()->get('KK_id'));
        $AES->setIV( $this->container->getParameter('aes_IV') );
        
        $clearId = $AES->decrypt();
        
        if( $idCheck->isPostAuthenticateKuchiValid( $clearId) )
        {
            $randomId = $idCheck->getPostAuthenticateKuchiRandomId($clearId);
            $kuchiId = $idCheck->getPostAuthenticateKuchiId($clearId);
            
            $kuchi = $repositoryKuchi->findOneById($kuchiId);
            
            if( !$kuchi )
            {
                // Kuchi unknown !
                $response->setStatusCode(502);
                $Logger->Error("[POST rest/authenticatekuchi] 502 - Kuchi id=".$kuchiId." unknown");
            }
            else
            {   
                $komi = $repositoryKomi->findOneByRandomId($randomId);
                
                if( !$komi )
                {
                    // Komi unknown !
                    $response->setStatusCode(501);
                    $Logger->Error("[POST rest/authenticatekuchi] 501 - Komi id=".$randomId." unknown");
                }
                else
                {
                    $password = $idCheck->getPostAuthenticateKuchiPassword($clearId);

                    // Check Password
                    $passwordHash = hash("sha256", $this->container->getParameter('sha256_salt2').hash("sha256", hash("sha256", $password) . $this->container->getParameter('sha256_salt1')));
                    if( $passwordHash == $kuchi->getPassword() )
                    {
                        // Generate a kuchi account if not exist
                        $kuchiAccount = $repositoryKuchiAccount->findOneBy(array('komi' => $komi, 'kuchi' => $kuchi));
	                    
                        if (!$kuchiAccount)
                        {
                            $kuchiAccount = new KuchiAccount();
                            $kuchiAccount->setKomi($komi);
                            $kuchiAccount->setKuchi($kuchi);
                        }
                        // Token génération
                        $kuchiAccount->generateToken();

                        $em->persist($kuchiAccount);
                        $em->flush();

                        return array('kuchiAccount' => $kuchiAccount);
                    }
                    else
                    {
                        // password not match !
                        $response->setStatusCode(503);
                        $Logger->Error("[POST rest/authenticatekuchi] 503 - Kuchi id=".$kuchiId." - password not match");
                    }
                }                
            }
        }
        else
        {
            $response->setStatusCode(502);
            $Logger->Error("[POST rest/authenticatekuchi] 502 - Invalid Kuchi id");                
        }

        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    } 
}
