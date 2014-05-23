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
        $nbGroup = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup')
                ->getNbGroupByUserId($this->getUser()->getId());

        return $this->render('obdoKuchiKomiBundle:Dashboard:nbgroup.html.twig', array('nbGroup'=>$nbGroup));
    }

    public function nbKuchiAction()
    {
        $nbKuchi = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Kuchi')
                ->getNbKuchiByUserId($this->getUser()->getId());
        return $this->render('obdoKuchiKomiBundle:Dashboard:nbkuchi.html.twig', array('nbKuchi'=>$nbKuchi));
    }

    public function nbKomiAction()
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        $role = $roles[0];
        
        if ($role == 'ROLE_SUPER_ADMIN'){
           $nbKomi = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Komi')->getNbKomi();
            return $this->render('obdoKuchiKomiBundle:Dashboard:nbkomi.html.twig', 
                    array('nbKomi'=>$nbKomi,
                          'role' => '1')); 
        }else{
            $nbPotentiels = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup')
                    ->getListByUserId($user->getId());
            $nbAbo = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Subscription')
                ->getNbSubActivebyId($user->getId());
            $nbPotentiel = 0;
            foreach($nbPotentiels as $nb){
                $nbPotentiel = $nbPotentiel + $nb->getNbAboPotentiel();
            }
            //print_r($nbPotentiels);
            $pourcent = 0;
            if ($nbPotentiel > 0){
                $pourcent = ($nbAbo/$nbPotentiel)*100;
            }
            
            return $this->render('obdoKuchiKomiBundle:Dashboard:nbkomi.html.twig', 
                    array('nbKomi'=> number_format($pourcent, 2),
                    'role' => '0'));
        }
        $nbKomi = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Komi')->getNbKomi();
        return $this->render('obdoKuchiKomiBundle:Dashboard:nbkomi.html.twig', array('nbKomi'=>$nbKomi));
    }

    public function nbKuchiKomiAction()
    {
        $nbKuchiKomi = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi')
                ->getNbKuchiKomiByUserId($this->getUser()->getId());
        return $this->render('obdoKuchiKomiBundle:Dashboard:nbkuchikomi.html.twig', array('nbKuchiKomi'=>$nbKuchiKomi));
    }

    public function nbSubscriptionAction()
    {
        $nbSubscription = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Subscription')
                ->getNbSubActivebyId($this->getUser()->getId());
        return $this->render('obdoKuchiKomiBundle:Dashboard:nbsubscription.html.twig', array('nbSubscription'=>$nbSubscription));
    }
    
    public function nbThanksAction()
    {
        $nbThanks = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Thanks')
                ->getNbThanksByUserId($this->getUser()->getId());
        return $this->render('obdoKuchiKomiBundle:Dashboard:nbthanks.html.twig', array('nbThanks'=>$nbThanks));
    }

}
