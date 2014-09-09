<?php

namespace obdo\KuchiKomiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use obdo\KuchiKomiRESTBundle\Entity\SqlStat;

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

    /*
     * Calcule la taille utilisée par les images
     */
    public function tailledirImageAction()
    {           
        // filesize fonctionne mal si taille > 2 Go,  retourne des octets
        $taillekuchikomi = $this->folderSize( $this->container->getParameter('path_kuchikomi_photo'));
        $taillekuchi = $this->folderSize( $this->container->getParameter('path_kuchi_photo'));
        $taillekuchigroup = $this->folderSize($this->container->getParameter('path_kuchigroup_photo'));
        
        //recup max et seuil alerte en Mo
        $maxsize = $this->container->getParameter('max_photo_dir');
        $alertsize = $this->container->getParameter('alert_photo_dir');
        
        // conversion taille en Mo
        $taillekuchikomi = round($taillekuchikomi/(1024*1024),3);
        $taillekuchi = round($taillekuchi/(1024*1024),3);
        $taillekuchigroup = round($taillekuchigroup/(1024*1024),3);
        $tailletotal = $taillekuchikomi + $taillekuchi + $taillekuchigroup;
        
        return $this->render('obdoKuchiKomiBundle:Dashboard:tailleimage.html.twig', 
                array('kuchikomi'=>$taillekuchikomi,
                      'kuchi' => $taillekuchi,
                      'kuchigroup' => $taillekuchigroup,
                      'total' => $tailletotal,
                      'max' => $maxsize,
                      'alert' => $alertsize
                    ));
    }
    
    /*
     * tailleDetailKuchiKomi()
     * Calcul taille moyenne du champ Detail de KuchiKomi
     */
    public function tailleDetailKuchiKomiAction(){
        
       //recupére le dernier kuchikomi ayant le champ Detail max
        $maxdetails = SqlStat::getMaxDetailKuchiKomi($this);
        
        foreach ($maxdetails as $maxdetail){
            $taillemax = $maxdetail['taillemax'];
            $name = $maxdetail['name'];
            $quand = $maxdetail['timestampCreation'];
        }
        $nbrmax = count($maxdetails);
        
       //recupére la taille moyenne
        $avgdetails = SqlStat::getAvgDetailKuchiKomi($this);
        foreach ($avgdetails as $avgdetail){
            $moyenne = round($avgdetail['moyenne']);
        }
        
        
        return $this->render('obdoKuchiKomiBundle:Dashboard:tailledetail.html.twig', 
                array('taillemax'=>$taillemax,
                      'name' => $name,
                      'quand' => $quand,
                      'nbrmax' => $nbrmax,
                      'moyenne' => $moyenne
                    ));
    }
    
    public function folderSize($dir_name){
        $dir_size =0;
           if (is_dir($dir_name)) 
           {
                if ($dh = opendir($dir_name)) 
                {
                    while (($file = readdir($dh)) !== false) {
                        if($file != '.' && $file != '..'){
                            if(is_file($dir_name.'/'.$file)){
                                $dir_size += filesize($dir_name.'/'.$file);
                            }
                             /* check for any new directory inside this directory */
                            if(is_dir($dir_name.'/'.$file)){
                                $dir_size +=  $this->folderSize($dir_name.'/'.$file);
                            }
                        }
                    }
                    closedir($dh);
                }
            }
        
        return $dir_size;
    }
}
