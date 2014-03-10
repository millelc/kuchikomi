<?php

namespace obdo\KuchiKomiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('obdoKuchiKomiBundle:Dashboard:index.html.twig');
    }
    
    public function nbGroupAction()
    {
        $nbGroup = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup')->getNbGroup();
        return $this->render('obdoKuchiKomiBundle:Dashboard:nbgroup.html.twig', array('nbGroup'=>$nbGroup));
    }

    public function nbKuchiAction()
    {
        $nbKuchi = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Kuchi')->getNbKuchi();
        return $this->render('obdoKuchiKomiBundle:Dashboard:nbkuchi.html.twig', array('nbKuchi'=>$nbKuchi));
    }

    public function nbKomiAction()
    {
        $nbKomi = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Komi')->getNbKomi();
        return $this->render('obdoKuchiKomiBundle:Dashboard:nbkomi.html.twig', array('nbKomi'=>$nbKomi));
    }

    public function nbSubscriptionAction()
    {
        $nbSubscription = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Subscription')->getNbSubscription();
        return $this->render('obdoKuchiKomiBundle:Dashboard:nbsubscription.html.twig', array('nbSubscription'=>$nbSubscription));
    }

}
