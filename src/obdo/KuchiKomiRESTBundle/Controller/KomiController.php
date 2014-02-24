<?php

namespace obdo\KuchiKomiRESTBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Komi;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;

class KomiController extends Controller
{
    /**
     * @Post("/komi/{id}")
     * @return array
     * @View()
     */
    public function postKomiAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        
        $AES = $this->container->get('obdo_services.AES');
        $AES->setKey('5CCA8DAB847F457C918D439459D3730B');
        $AES->setBlockSize(128);
        $AES->setData($id);
        $clearId = $AES->decrypt();
                    
            
        // new Komi
        $komi = new Komi();
        $komi->setRandomId($clearId);

        $em->persist($komi);
        $em->flush();
            
        $response = new Response();

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/html');

        // affiche les entêtes HTTP suivies du contenu
        $response->send();
        
        return $response;
    }
}
