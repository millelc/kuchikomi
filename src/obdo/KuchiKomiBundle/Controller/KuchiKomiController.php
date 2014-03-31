<?php

namespace obdo\KuchiKomiBundle\Controller;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KuchiKomiController extends Controller
{

	public function viewAction($id)
    {
        $kuchikomi = $this->getDoctrine()
                           ->getRepository('obdo\KuchiKomiRESTBundle\Entity\KuchiKomi')
                           ->find($id);
                
        return $this->render('obdoKuchiKomiBundle:Default:kuchikomiview.html.twig', array(
                                                                                        'kuchikomi' => $kuchikomi,
                                                                                        ));        
    }
    
    
}
