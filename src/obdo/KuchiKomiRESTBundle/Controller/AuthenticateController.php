<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Util\SecureRandom;
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
                $Logger->Info("[POST rest/authenticate] 501 - Komi id=".$randomId." unkonwn");
            }
            else
            {
                $generator = new SecureRandom();
                
                // Token génération
                $token = bin2hex($generator->nextBytes( $this->container->getParameter('token_size') ));
                $komi->setToken( $token );
                
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
    
}
