<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\Log;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogController extends Controller
{
    public function logAction($page, $sort)
    {
        $em = $this->getDoctrine()->getManager();
        if( $page == 0 )
        {
            $logs = $em->getRepository('obdoKuchiKomiRESTBundle:Log')->findAll();
        
            for($i = 0; $i < count($logs); ++$i)
            {
                $em->remove( $logs[$i] );
            }
        
            $em->flush();
        
            $logs = array();
        }
        else
        {
            $logs = $em->getRepository('obdoKuchiKomiRESTBundle:Log')->getLogs(25, $page, $sort);
        }
        
        return $this->render('obdoKuchiKomiBundle:Default:log.html.twig', array(
                                                                                'logs'   => $logs,
                                                                                'page'   => $page,
                                                                                'nombrePage' => ceil(count($logs)/25),
                                                                                'sort'   => $sort
                                                                                ));
    }
    
}
