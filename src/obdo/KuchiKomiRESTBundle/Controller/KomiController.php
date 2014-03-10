<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;

class KomiController extends Controller
{
    /**
     * @Post("/rest/komi")
     * @return array
     * @View()
     */
    public function postKomiAction()
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
                    
        if( $idCheck->isPostKomiValid( $clearId) )
        {
            $randomId = $idCheck->getPostKomiRandomId($clearId);
            
            $komi = $repositoryKomi->findOneByRandomId($randomId);
            
            if( !$komi )
            {
                // new Komi
                $komi = new Komi();
                $komi->setRandomId($randomId);
                $komi->setOsType($idCheck->getPostKomiMobileOsId($clearId));
        
                $em->persist($komi);
                $em->flush();
                $response->setStatusCode(200);
                
                $Logger->Info("[POST rest/komi] 200 - Komi id=".$komi->getRandomId()." registered");
            }
            else
            {
                // Komi already exist !
                $response->setStatusCode(501);
                $Logger->Error("[POST rest/komi] 501 - Komi id=".$komi->getRandomId()." already registered");
            }
        }
        else
        {
            $response->setStatusCode(500);
            $Logger->Error("[POST rest/komi] 500 - Invalid Komi id");
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }
    
     /**
     * @Delete("/rest/komi/{id}/{hash}")
     * @return array
     * @View()
     */
    public function deleteKomiAction($id, $hash)
    {
        $response = new Response();
        
        $Logger = $this->container->get('obdo_services.Logger');
                
        $idCheck = $this->container->get('obdoKuchiKomiRestBundle.idCheck');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        
        $komi = $repositoryKomi->findOneByRandomId($id);
        
        if( !$komi )
        {
            // Komi unknown !
            $response->setStatusCode(501);
        }
        else
        {
            if( $hash == sha1("DELETE /rest/komi" . $komi->getToken() ) )
            {
                if( $komi->getActive() )
                {
                    $komi->setTimestampSuppression(new \DateTime());
                    $komi->setActive(false);
        
                    $em->flush();
                    $response->setStatusCode(200);
                    $Logger->Info("[DELETE rest/komi/{id}/{hash}] 200 - Komi id=".$komi->getRandomId()." unregistered");
                }
                else
                {
                    // komi already inactive
                    $response->setStatusCode(502);
                    $Logger->Info("[DELETE rest/komi/{id}/{hash}] 502 - Komi id=".$komi->getRandomId()." already inactive");
                }
                
            }
            else
            {
                // hash invalid
                $response->setStatusCode(500);
                $Logger->Error("[DELETE rest/komi/{id}/{hash}] 500 - Invalid Komi id");
            }
            
            // disable current token
            $komi->generateToken();
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }

         /**
     * @Put("/rest/komi/{id}/{hash}")
     * @return array
     * @View()
     */
    public function putKomiAction($id, $hash)
    {
        $response = new Response();
        
        $Logger = $this->container->get('obdo_services.Logger');
                
        $idCheck = $this->container->get('obdoKuchiKomiRestBundle.idCheck');
        
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        
        $komi = $repositoryKomi->findOneByRandomId($id);
        
        if( !$komi )
        {
            // Komi unknown !
            $response->setStatusCode(501);
            $Logger->Info("[PUT rest/komi/{id}/{hash}] 501 - Komi id=".$id." unkonwn");
        }
        else
        {
            if( $hash == sha1("PUT /rest/komi" . $komi->getToken() ) )
            {
                if( !$komi->getActive() )
                {
                    $komi->setOsType($this->getRequest()->get('os_id'));
                    $komi->setToken("");
                    $komi->setActive(true);
        
                    $em->flush();
                    $response->setStatusCode(200);
                    $Logger->Info("[PUT rest/komi/{id}/{hash}] 200 - Komi id=".$komi->getRandomId()." updated");
                }
                else
                {
                    // komi already active
                    $response->setStatusCode(502);
                    $Logger->Info("[PUT rest/komi/{id}/{hash}] 501 - Komi id=".$komi->getRandomId()." already active");
                }
                
            }
            else
            {
                // hash invalid
                $response->setStatusCode(500);
                $Logger->Error("[PUT rest/komi/{id}/{hash}] 500 - Invalid Komi id");
            }
            
            // disable current token
            $komi->generateToken();
        }

        $response->headers->set('Content-Type', 'text/html');
        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }

}
