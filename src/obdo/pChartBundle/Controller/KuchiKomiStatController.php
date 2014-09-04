<?php

namespace obdo\pChartBundle\Controller;

use obdo\pChartBundle\pData;
use obdo\pChartBundle\pDraw;
use obdo\pChartBundle\pPie;
use obdo\pChartBundle\pImage;
use obdo\KuchiKomiRESTBundle\Entity\SqlStat;
use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/*
 *
 */

class KuchiKomiStatController extends Controller {

    var $an;
    var $mois;

    /*
     * Definition de la route en fonction du param d'entrée
     */
    public function choixAction($nom) {
        //determination de la route
        $route = '';
        switch ($nom) {
            case 'kuchi' :
                $route = 'obdo_pChart_kuchi';
                break;
            case 'komi' :
                $route = 'obdo_pChart_komi';
                break;
            case 'subscription' :
                $route = 'obdo_pChart_subscription';
                break;
            case 'kuchikomi' :
                $route = 'obdo_pChart_kuchikomi';
                break;
            case 'thanks' :
                $route = 'obdo_pChart_thanks';
                break;
            case 'image' :
                $route = 'obdo_pChart_image';
                break;
            case 'detail' :
                $route = 'obdo_pChart_detail';
                break;
        }
        return $this->render('obdoKuchiKomiBundle:Dashboard:graph.html.twig', array('laroute' => $route));
    }

    /*
     * Calcul et affichage stat mois en cours
     * pour les Kuchis
     */
    public function kuchistatAction() {
        $table = 'Kuchi';
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        $titre = 'Nbre Kuchi/jour mois ' . $this->mois;
        $titre1 = date('j M Y');
        $ylegende = 'Nbre Kuchis';
        $xdesc = 'jour'; // idem cle du dataset

        $nbKuchimois = SqlStat::getNbKuchiMois($this->mois, $this->an, $this, $this->getUser()->getId());

        if (count($nbKuchimois) > 0) {
            //constitution du dataset
            $dataset = new pData();
            $ajour = array();
            $anbre = array();
            foreach ($nbKuchimois as $nk) {
                $ajour[] = $nk['jour'];
                $anbre[] = $nk['nbre'];
            }
            $dataset->addPoints($ajour, 'jour');
            $dataset->addPoints($anbre, 'nombre'); // C'est cet intitulé qui fait office de légende


            $chart = $this->chartgraph($dataset, $titre, $titre1, $ylegende, $xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = '0 kuchi';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }

    /*
     * Calcul et affichage stat mois en cours
     * pour les Komis
     */
    public function komistatAction() {
        $user = $this->getUser();
        $roles = $user->getRoles();
        $role = $roles[0];
        
        
        if ($role != 'ROLE_SUPER_ADMIN') {
            $response = $this->potentielstatAction($user);
            return $response;
        } else {
            $table = 'Komi';
            $response = new Response();
            $response->headers->set('Content-Type', 'image/png');
            //definir mois et annee du jour en cours
            $this->aujourdhui();
            $titre = 'Nbre Komi/jour mois ' . $this->mois;
            $titre1 = date('j M Y');
            $ylegende = 'Nbre Komis';
            $xdesc = 'jour'; // idem cle du dataset 

            $nbKomimois = SqlStat::getNbKomiMois($this->mois, $this->an, $this);

            if (count($nbKomimois) > 0) {
                //constitution du dataset
                $dataset = new pData();
                $ajour = array();
                $anbre = array();
                foreach ($nbKomimois as $nk) {
                    $ajour[] = $nk['jour'];
                    $anbre[] = $nk['nbre'];
                }
                $dataset->addPoints($ajour, 'jour');
                $dataset->addPoints($anbre, 'nombre'); // C'est cet intitulé qui fait office de légende


                $chart = $this->chartgraph($dataset, $titre, $titre1, $ylegende, $xdesc);

                ob_start();
                $chart->autoOutput();
                $response->setContent(ob_get_clean());
            } else {
                // Render a default error image.
                $image = imagecreate(675, 75);
                $dark_grey = imagecolorallocate($image, 102, 102, 102);
                $white = imagecolorallocate($image, 255, 255, 255);
                $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
                $string = '0 Komi';
                imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

                ob_start();
                imagepng($image);
                $response->setContent(ob_get_clean());

                //Clear up memory 
                imagedestroy($image);
            }
            return $response;
        }
       
    }

    /*
     * Calcul et affichage stat mois en cours
     * pour les subscriptions
     */
    public function subscriptionstatAction() {
        $table = 'Subscription';
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        $titre = 'Nbre Subscription/jour mois ' . $this->mois;
        $titre1 = date('j M Y');
        $ylegende = 'Nbre Subscription';
        $xdesc = 'jour'; // idem cle du dataset 

        $nbSubsmois = SqlStat::getNbSubscriptionMois($this->mois, $this->an, $this, $this->getUser()->getId());

        if (count($nbSubsmois) > 0) {
            //constitution du dataset
            $dataset = new pData();
            $ajour = array();
            $anbre = array();
            foreach ($nbSubsmois as $nk) {
                $ajour[] = $nk['jour'];
                $anbre[] = $nk['nbre'];
            }
            $dataset->addPoints($ajour, 'jour');
            $dataset->addPoints($anbre, 'nombre'); // C'est cet intitulé qui fait office de légende


            $chart = $this->chartgraph($dataset, $titre, $titre1, $ylegende, $xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = '0 subscriptions';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }

    /*
     * Calcul et affichage stat mois en cours
     * pour les Kuchikomis
     */
    public function kuchikomistatAction() {
        $table = 'KuchiKomi';
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        $titre = 'Nbre Kuchikomi/jour mois ' . $this->mois;
        $titre1 = date('j M Y');
        $ylegende = 'Nbre Kuchikomi';
        $xdesc = 'jour'; // idem cle du dataset 

        $nbKuchikomimois = SqlStat::getNbKuchikomiMois($this->mois, $this->an, $this, $this->getUser()->getId());

        if (count($nbKuchikomimois) > 0) {
            //constitution du dataset
            $dataset = new pData();
            $ajour = array();
            $anbre = array();
            foreach ($nbKuchikomimois as $nk) {
                $ajour[] = $nk['jour'];
                $anbre[] = $nk['nbre'];
            }
            $dataset->addPoints($ajour, 'jour');
            $dataset->addPoints($anbre, 'nombre'); // C'est cet intitulé qui fait office de légende


            $chart = $this->chartgraph($dataset, $titre, $titre1, $ylegende, $xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = '0 kuchikomi';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }

    /*
     * Calcul et affichage stat mois en cours
     * pour les Thanks
     */
    public function thanksstatAction() {
        $table = 'Thanks';
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        $titre = 'Nbre Thanks/jour mois ' . $this->mois;
        $titre1 = date('j M Y');
        $ylegende = 'Nbre Thanks';
        $xdesc = 'jour'; // idem cle du dataset 

        $nbThanksmois = SqlStat::getNbThanksMois($this->mois, $this->an, $this, $this->getUser()->getId());

        if (count($nbThanksmois) > 0) {
            //constitution du dataset
            $dataset = new pData();
            $ajour = array();
            $anbre = array();
            foreach ($nbThanksmois as $nk) {
                $ajour[] = $nk['jour'];
                $anbre[] = $nk['nbre'];
            }
            $dataset->addPoints($ajour, 'jour');
            $dataset->addPoints($anbre, 'nombre'); // C'est cet intitulé qui fait office de légende


            $chart = $this->chartgraph($dataset, $titre, $titre1, $ylegende, $xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = '0 merci';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }

    /*
     * Calcul et affichage stat 
     * potentiel/réalisé
     */
    public function potentielstatAction($user) {
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');

        $nbPotentiels = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:KuchiGroup')
                ->getListByUserId($user->getId());
        $nbAbo = $this->getDoctrine()->getRepository('obdoKuchiKomiRESTBundle:Subscription')
                ->getNbSubActivebyId($user->getId());
        
        $nbPotentiel = 0;
        foreach ($nbPotentiels as $nb) {
            $nbPotentiel = $nbPotentiel + $nb->getNbAboPotentiel();
        }
        //print_r($nbPotentiels);
        $pourcent = 0;
        if ($nbPotentiel > 0) {
            $pourcent = ($nbAbo / $nbPotentiel) * 100;
        }
        if ($pourcent > 0) {
            $dataset[0] = $pourcent;
            $dataset[1] = 100 - $pourcent;
            $absissa[0] = 'Abonné';
            $absissa[1] = 'Potentiel';
          
            $chart = $this->piegraph($dataset,'',$absissa);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = 'Potentiel non renseigné';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    /*
     * Graphique taille des images/client
     */
    public function imagestatAction(){
        
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        
        $titre = 'Taille totale photo /client ';
        $titre1 = 'au '.date('j M Y');
        $ylegende = 'Mo';
        $xdesc = 'client'; // idem cle du dataset 

        $sizetot = 0;
        $size = 0;
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('obdoKuchiKomiRESTBundle:Clients')->findAll();
            //constitution du dataset
            $dataset = new pData();
            $aclient = array();
            $asize = array();
        
        foreach ($clients as $client){
            $size = 0;
            $abonnements = $em->getRepository('obdoKuchiKomiRESTBundle:Abonnements')->findByClient($client->getId());
            foreach ($abonnements as $abonnement){
                $kuchis = $em->getRepository('obdoKuchiKomiRESTBundle:Kuchi')->findByAbonnement($abonnement->getId());
                foreach ($kuchis as $kuchi){
                    $kuchikomis = $em->getRepository('obdoKuchiKomiRESTBundle:KuchiKomi')->findByKuchi($kuchi);
                    foreach ($kuchikomis as $kuchikomi){
                        if ($kuchikomi->getPhotoLink() != null)
                            $size += filesize($kuchikomi->getPhotoLink());
                    }
                    if ($kuchi->getLogoLink() != null)
                        $size += filesize($kuchi->getLogoLink());
                    if ($kuchi->getPhotoLink() != null)
                        $size += filesize($kuchi->getPhotoLink());
                }
            }
            $sizetot += $size;
            if ($size > 0){
                $aclient[] = $client->getRaissoc();
                $asize[] = round($size/(1024*1024),3);
            }
        }    

            $dataset->addPoints($aclient, 'client');
            $dataset->addPoints($asize, 'Mo'); // C'est cet intitulé qui fait office de légende
        if ($sizetot > 0) {
            $chart = $this->chartgraph($dataset, $titre, $titre1, $ylegende, $xdesc);
            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = '0 photo';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    /*
     * Graphique creation KuchiKomi et Komi de la veille ou de la semaine
     * param en entrée = jour ou semaine
     * Graphique affiché sur page index du role super_admin
     */
    public function creationstatAction($mode){
       
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
      
        $ylegende = 'Nbre création';
        
        $deltadeb = 0;
        $deltafin = 0;
        $datedeb = new \DateTime(); // \ pour sortir du namespace et avoir les classes PHP
        $datefin = new \DateTime();
        
        $dataval ='';
        $datamin =0;
        $datamax =0;
        
        if ($mode == 'jour'){
            $nbkuchikomis = SqlStat::getNbKuchikomiHeure($this);
            $nbkomis = SqlStat::getNbKomiHeure($this);
            $titre = 'KuchiKomi et Komi/heure';
            $titre1 = date('j m Y', time() - 3600 * 24);
            $dataval ='heure';
            $datamin=0;
            $datamax =24;
        } else{
            if ($mode == 'semaine'){
                $datedeb->modify('monday this week');
                $datefin->modify('sunday this week');
                $titre = 'KuchiKomi et Komi/semaine';
            } else {
                $datedeb->modify('first day of this month');
                $datefin->modify('last day of this month');
                $titre = 'KuchiKomi et Komi mois '.date('m',$datedeb->getTimestamp());
            }

            $nbkuchikomis = SqlStat::getNbKuchikomiDate
                    (date('Y-m-d',$datedeb->getTimestamp()),date('Y-m-d',$datefin->getTimestamp()),$this);
            $nbkomis = SqlStat::getNbKomiDate
                    (date('Y-m-d',$datedeb->getTimestamp()),date('Y-m-d',$datefin->getTimestamp()),$this);
            
            $titre1 = 'du '.date('Y-m-d',$datedeb->getTimestamp())
                    .' au '.date('Y-m-d',$datefin->getTimestamp());
            $dataval ='jour';
            $datamin=$datedeb;
            $datamax =$datefin->modify('+1 day');
        }

        if (count($nbkuchikomis) > 0 || count($nbkomis) > 0) {
            //constitution du dataset
            $dataset = new pData();
            $akuchikomi = array();
            $akomi = array();
            $alabel = array();
            // création du tableau contenant les heures/ou les jours et des tableaux de données
            $j = 0;
            $i = $datamin;
            $x = 0;
            while($i < $datamax) {
                if ($dataval == 'heure'){
                    $alabel[] = $i;
                    $x = $i;
                }else{
                    $alabel[] = date('d',$i->getTimestamp());
                    $x = date('Y-m-d',$i->getTimestamp());
                }
                $ok = false;
                foreach ($nbkuchikomis as $nbkuchikomi){
                    $key = array_search($x, $nbkuchikomi);
                    // array_search cherche dans toute la table, donc, si $nbkuchikomi['nbre']  = $x
                    // alors $key n'est pas false.....
                    if ($key && $nbkuchikomi[$dataval] == $x){
                        $ok = true;
                        break;
                    }
                }
                if ($ok){
                   $akuchikomi[$j] = $nbkuchikomi['nbre']; 
                }else{
                    $akuchikomi[$j] = VOID;
                }
                $ok = false;
                foreach ($nbkomis as $nbkomi){
                    $key = array_search($x, $nbkomi);
                    if ($key && $nbkomi[$dataval] == $x){
                        $ok = true;
                        break;
                    }
                }    
                if ($ok){
                   $akomi[$j] = $nbkomi['nbre']; 
                }else{
                    $akomi[$j] = VOID;
                }
               
                $j++;  
                if ($dataval == 'heure'){
                    $i++;
                }else{
                    $i->modify('+1 day');
                }                    
            }
                      
            $dataset->addPoints($alabel, $dataval);
            $dataset->addPoints($akuchikomi, 'kuchikomi'); 
            $dataset->addPoints($akomi, 'komi'); 

            $chart = $this->combograph($dataset, $titre, $titre1, $ylegende, $dataval, 'kuchikomi', 'komi');

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = 'Rien hier';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    /*
     * Nbre caractères message mois
     */
    public function detailstatAction() {
        $table = 'KuchiKomi';
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        $titre = 'Nbre caractères message mois ' . $this->mois;
        $titre1 = date('j M Y');
        $ylegende = 'Nbre caractères';
        $xdesc = 'jour'; // idem cle du dataset

        $nbcarKuchiKomimois = SqlStat::getNbDetailMois($this->mois, $this->an, $this);

        if (count($nbcarKuchiKomimois) > 0) {
            //constitution du dataset
            $dataset = new pData();
            $ajour = array();
            $anbre = array();
            foreach ($nbcarKuchiKomimois as $nk) {
                $ajour[] = $nk['jour'];
                $anbre[] = $nk['nbre'];
            }
            $dataset->addPoints($ajour, 'jour');
            $dataset->addPoints($anbre, 'nombre'); // C'est cet intitulé qui fait office de légende


            $chart = $this->chartgraph($dataset, $titre, $titre1, $ylegende, $xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = '0 kuchikomi';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    /*
     * Calcul et affichage stat 1 an, nbre de kuchikomi par mois
     * pour le client en entrée
     */
    public function clientkuchikomistatAction($clientid) {
        $table = 'KuchiKomi';
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        $gt = ($this->an *100) + $this->mois;
        $lt = (($this->an -1)*100) + $this->mois;
        
        $client = $this->getDoctrine()
                ->getRepository('obdo\KuchiKomiRESTBundle\Entity\Clients')
                ->find($clientid);
        
        $titre = 'de '.$lt.' à '.$gt;
        $titre1 = $client->getRaissoc();
        $ylegende = 'Nbre kuchikomis';
        
        
        //recup le nbre de kuchikomis par mois
        $nbcarKuchiKomimois = SqlStat::getNbKuchiKomisAnClient($gt,$lt,$clientid, $this);
        
        if (count($nbcarKuchiKomimois) > 0){
            //constitution du dataset
            $dataset = new pData();
            $akuchikomi = array();
            $akomi = array();
            $amoisan = array();
            
            for($i = 0; $i < 13; $i++) {
                //extraction an et mois à partir de $i
                $anmois = $lt + $i;
                $an = (round($anmois/100));
                $mois = $anmois - ($an * 100);
                if ($mois > 12){
                    $an +=1;
                    $mois -=12;
                    $anmois = ($an * 100) + $mois;
                }
                $amoisan[] = $mois ;
                $ok = false;
                foreach ($nbcarKuchiKomimois as $nbkuchikomi){
                    $key = array_search($anmois, $nbkuchikomi);
                    // array_search cherche dans toute la table, donc, si $nbkuchikomi['nbre']  = $anmois
                    // alors $key n'est pas false.....
                    if ($key && $nbkuchikomi['anmois'] == $anmois){
                        $ok = true;
                        break;
                    }
                }
                if ($ok){
                   $akuchikomi[] = $nbkuchikomi['nbre']; 
                }else{
                    $akuchikomi[] = VOID;
                }
            }

            $dataset->addPoints($amoisan, 'anmois');
            $dataset->addPoints($akuchikomi, 'kuchikomi'); 

            $chart = $this->combograph($dataset, $titre, $titre1, $ylegende, 'anmois', 'kuchikomi', '');

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = '0 kuchikomi';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    /*
     * Nbre appels et temps passé en fonction de mode (an ou mois)
     */
    public function appeldatestatAction($mode, $clientid){
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
      
        $ylegende = 'Appels';
       
        $datedeb = new \DateTime(); // \ pour sortir du namespace et avoir les classes PHP
        $datefin = new \DateTime();
        
        $dataval ='';
        $datamin =0;
        $datamax =0;
        
        $titre1 = 'en minutes';
        
        if ($mode == 'an'){
            $titre = "Appels de l'année";         
            $dataval ='mois';
            $datedeb->modify('first day of January this year');
            $datefin->modify('last day of December this year');
            $datamin=1;
            $datamax =12;
            if ($clientid == 'nul'){
            $appels = SqlStat::getAppelsDateAn
                    (date('Y-m-d',$datedeb->getTimestamp()),date('Y-m-d',$datefin->getTimestamp()), $this);
            }else{
              $appels = SqlStat::getAppelsDateAnClient
                    ($clientid,date('Y-m-d',$datedeb->getTimestamp()),date('Y-m-d',$datefin->getTimestamp()), $this);  
            }
        } else{
            if ($mode == 'mois'){
                $titre = "Appels du mois"; 
                $dataval ='jour';
                $datedeb->modify('first day of this month');
                $datefin->modify('last day of this month');
                $titre = 'Appels du mois';
                $datamin=1;
                $datamax =31;
                if ($clientid == 'nul'){
                    $appels = SqlStat::getAppelsDateMois
                        (date('Y-m-d',$datedeb->getTimestamp()),date('Y-m-d',$datefin->getTimestamp()), $this);
                }else{
                    $appels = SqlStat::getAppelsDateMoisClient
                        ($clientid,date('Y-m-d',$datedeb->getTimestamp()),date('Y-m-d',$datefin->getTimestamp()), $this);
                }
            }
        }
        
        if(count($appels > 0)){
            //constitution du dataset
            $dataset = new pData();
            $anombre = array();
            $atemps = array();
            $alabel = array();
            // création du tableau contenant les mois/ou les jours et des tableaux de données
            $j = 0;
            $i = $datedeb;
            $x = 0;
            $fin = $datefin->modify('+1 day');
            while($i < $fin) {
                if ($mode == 'mois'){
                    $alabel[$j] = date('d',$i->getTimestamp());
                }else{
                    if ($mode == 'an'){
                        $alabel[$j] = date('m',$i->getTimestamp());
                    }
                }
                $x = $alabel[$j];
                $ok = false;

                $cpt = 0;
                for ($cpt = 0; $cpt < count($appels); $cpt++){
                    if($mode == 'an'){
                        $search = $appels[$cpt]['jour'];
                    }else{
                        $search = date('d',strtotime($appels[$cpt]['jour']));
                    }
                    if ($search == $x){
                        $ok = true;
                        break;
                    }
                }

                if ($ok){
                   $anombre[$j] = $appels[$cpt]['nbre']; 
                   $atemps[$j] = $appels[$cpt]['ttemps'];
                }else{
                    $anombre[$j] = VOID;
                    $atemps[$j] = VOID;
                }
               
                $j++;  
                if ($mode == 'an'){
                    $i->modify('+1 month');
                }else{
                    $i->modify('+1 day');
                }                    
            }                    
            $dataset->addPoints($alabel, $dataval);
            $dataset->addPoints($anombre, 'nombre'); 
            $dataset->addPoints($atemps, 'temps'); 

            $chart = $this->combograph($dataset, $titre, $titre1, $ylegende, $dataval, 'temps', 'nombre');

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = 'Rien à afficher';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    /*
     * Camembert appels et temps passé en fonction de mode (an ou mois)
     */
    public function appeltypestatAction($mode, $clientid){
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
      
        $ylegende = 'Appels';
       
        $datedeb = new \DateTime(); // \ pour sortir du namespace et avoir les classes PHP
        $datefin = new \DateTime();
        
        $dataval ='';
        $datamin =0;
        $datamax =0;
        
        $titre1 = 'en minutes';
        
        if ($mode == 'an'){
            $titre = "%type appel année";         
            $dataval ='mois';
            $datedeb->modify('first day of January this year');
            $datefin->modify('last day of December this year');
            $datamin=1;
            $datamax =12;
        } else{
            if ($mode == 'mois'){
                $titre = "%type appel mois"; 
                $dataval ='jour';
                $datedeb->modify('first day of this month');
                $datefin->modify('last day of this month');
                $datamin=1;
                $datamax =31;
            }
        }
        if ($clientid == 'nul'){
            $appels = SqlStat::getAppelsTypeDate
                        (date('Y-m-d',$datedeb->getTimestamp()),date('Y-m-d',$datefin->getTimestamp()), $this);
        }else{
            $appels = SqlStat::getAppelsTypeDateClient
                        ($clientid,date('Y-m-d',$datedeb->getTimestamp()),date('Y-m-d',$datefin->getTimestamp()), $this);
        }

        if (count($appels) > 0){      
            
            $anombre = array();
            $atemps = array();
            $alabel = array();
            // création du tableau contenant les mois/ou les jours et des tableaux de données
            foreach ($appels as $appel){
                   $anombre[] = $appel['nbre']; 
                   $atemps[] = $appel['ttemps'];
                   $alabel[] = $appel['typeappel'];         
            } 

            $chart = $this->piegraph($anombre,$titre,$alabel);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/calibri.ttf";
            $string = 'Rien à afficher';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    /*
     * Calcul du mois et de l'année à afficher
     * en fonction de la date du jour
     */
    protected function aujourdhui() {
        $lemois = date('m');
        $annee = date('Y');
        // si le 01 on passe le mois au mois precedent
        if (date('j') == '01') {
            // si 1er janvier on passe a decembre de l'an dernier
            if ($lemois == '01')
                $annee = date('Y', strtotime('-1 year'));

            $lemois = date('m', strtotime('-1 month'));
        }
        $this->an = $annee;
        $this->mois = $lemois;
    }

    /*
     * chartgraph creation de l'image (png) contenant le graphique
     * $dataset = les données à afficher
     * $titre = titre du graphique
     * $titre1 = titre de la fenetre
     * $ylegende = Legende axe y 
     * $xdesc = data servant de repere sur axe x
     */

    protected function chartgraph($dataset, $titre, $titre1, $ylegende, $xdesc) {
        $MyData = new pData();
        $MyData = $dataset;
        $MyData->setAxisName(0, $ylegende);
         $MyData->setAxisColor(0,array("R" => 255, "G" => 255, "B" => 255));
        $MyData->setSerieDescription($xdesc, $xdesc);
        $MyData->setAbscissa($xdesc);

        $MyData->loadPalette(__DIR__ . "/../Resources/palettes/blind.color", TRUE);
        /* Create the pChart object */
        $myPicture = new pImage(700, 230, $MyData,TRUE); // TRUE = backgroud transparent

        /* Turn on antialiasing */
        $myPicture->Antialias = FALSE;

        /* Create a solid background */
        $Settings = array("R" => 66, "G" => 139, "B" => 202, "Dash" => 1, "DashR" => 66, "DashG" => 139, "DashB" => 202);
        $myPicture->drawFilledRectangle(0, 0, 700, 230, $Settings);

        /* Write the picture title */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 8));
        $myPicture->drawText(1, 10, $titre1, array("R" => 255, "G" => 255, "B" => 255));

        /* Draw the scale */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/verdana.ttf", "FontSize" => 6
            ,"R" => 255, "G" => 255, "B" => 255));
        //$myPicture->setGraphArea(50, 60, 670, 190);
        $myPicture->setGraphArea(40,20,650,190);
        $myPicture->drawFilledRectangle(40,20,650,190, array("R" => 255, "G" => 255, "B" => 255, "Surrounding" => -200, "Alpha" => 10));
        $myPicture->drawScale(array("CycleBackground" => TRUE,"AxisR"=>255,"AxisG"=>255,"AxisB"=>255
                                ,"TickR"=>255,"TickG"=>255,"TickB"=>255));

        /* Graph title */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 11));
        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 255, "G" => 255, "B" => 255, "Alpha" => 10));
        //$myPicture->drawText(50, 52, $titre, array("FontSize" => 20, "Align" => TEXT_ALIGN_BOTTOMLEFT,"R" => 255, "G" => 255, "B" => 255));
        $y = 650 -(strlen($titre)*5);
        $myPicture->drawText($y,225,$titre,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE,"R" => 255, "G" => 255, "B" => 255));
    
        /* Draw the bar chart chart */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/verdana.ttf", "FontSize" => 6));
        $MyData->setSerieDrawable("nbre", TRUE);
        $MyData->setSerieDrawable("Mo", TRUE);

        $myPicture->drawBarChart();

        /* Turn on antialiasing */
        $myPicture->Antialias = TRUE;

        $myPicture->setShadow(FALSE);

        /* Make sure all series are drawable before writing the scale */
        $MyData->drawAll();

        /* Write the legend */
        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10));
        //$myPicture->drawLegend(580, 35, array("Style" => LEGEND_ROUND, "Alpha" => 20, "Mode" => LEGEND_HORIZONTAL));
        $myPicture->drawLegend(40,200,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
        return $myPicture;
    }

    /*
     * Création d'un graphique type camembert
     */
    protected function piegraph($dataset,$titre,$absissa) {
        /* Create and populate the pData object */
        $MyData = new pData();
        $MyData->addPoints($dataset, "ScoreA");
        $MyData->setAxisColor(0,array("R" => 255, "G" => 255, "B" => 255));

        /* Define the absissa serie */
        $MyData->addPoints($absissa, "Labels");
        $MyData->setAbscissa("Labels");
        /* Will replace the whole color scheme by the "light" palette */
        $MyData->loadPalette(__DIR__ . "/../Resources/palettes/blind.color", TRUE);
        /* Create the pChart object */
        $myPicture = new pImage(700, 230, $MyData,TRUE); // TRUE = backgroud transparent

/* Create a solid background */
        $Settings = array("R" => 66, "G" => 139, "B" => 202, "Dash" => 1, "DashR" => 66, "DashG" => 139, "DashB" => 202);
        $myPicture->drawFilledRectangle(0, 0, 700, 230, $Settings);

        /* Write the picture title */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 8));
        //$myPicture->drawText(10, 13, $titre, array("R" => 255, "G" => 255, "B" => 255));
        $y = 650 -(strlen($titre)*5);
        $myPicture->drawText($y,225,$titre,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE,"R" => 255, "G" => 255, "B" => 255));
        /* Set the default font properties */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/Forgotte.ttf", "FontSize" => 10, "R" => 80, "G" => 80, "B" => 80));

        /* Create the pPie object */
        $PieChart = new pPie($myPicture, $MyData);

        /* Draw a splitted pie chart */
        $PieChart->draw2DRing(340, 125, array("WriteValues" => PIE_VALUE_PERCENTAGE, "DataGapAngle" => 10, 
            "DataGapRadius" => 6, "Border" => TRUE, "BorderR" => 255, "BorderG" => 255, "BorderB" => 255,
            "Precision" => 2, "ValuePosition" => PIE_VALUE_OUTSIDE));

        /* Write the legend box */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 8));
        $PieChart->drawPieLegend(10, 13, array("Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL
            , "FontR" => 255, "FontG" => 255, "FontB" => 255));
        
        $myPicture->setShadow(FALSE);
    
        return $myPicture;
    }
    
    /*
     * Création graphique avec 2 séries de données
     * $area = 1ere série de points avec surface
     * $ticks = 2eme série de points
     */
    protected function combograph($dataset, $titre, $titre1, $ylegende, $xdesc,$area, $ticks)
  {
    $MyData = new pData();
    $MyData = $dataset;
    $MyData->setAxisName(0, $ylegende);
    $MyData->setSerieDescription($xdesc, $xdesc);
    $MyData->setAbscissa($xdesc);
    $MyData->setSerieTicks($ticks,4);
    $MyData->setAxisColor(0,array("R" => 255, "G" => 255, "B" => 255));
    /* Create the pChart object */
    $myPicture = new pImage(700,230,$MyData);

    /* Turn of Antialiasing */
    $myPicture->Antialias = FALSE;

    /* Draw the background */ 
    $Settings = array("R" => 66, "G" => 139, "B" => 202, "Dash" => 1, "DashR" => 66, "DashG" => 139, "DashB" => 202);
    $myPicture->drawFilledRectangle(0, 0, 700, 230, $Settings);

    /* Write the chart title */ 
    $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 11,"R" => 255, "G" => 255, "B" => 255));
    $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10));
   // $myPicture->setFontProperties(array("FontName"=>__DIR__ . "/../Resources/fonts/Forgotte.ttf","FontSize"=>11));
    $y = 650 -(strlen($titre)*5);
    $myPicture->drawText($y,225,$titre,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE,"R" => 255, "G" => 255, "B" => 255));
    
    /* Write the picture title */
    $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 8));
    $myPicture->drawText(650, 10, $titre1, array("R" => 255, "G" => 255, "B" => 255));

    /* Set the default font */
    $myPicture->setFontProperties(array("FontName"=>__DIR__ . "/../Resources/fonts/calibri.ttf","FontSize"=>6));

    /* Define the chart area */
    $myPicture->setGraphArea(40,10,650,180);

    /* Draw the scale */
    $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>255,
        "GridG"=>255,"GridB"=>255,"DrawSubTicks"=>FALSE,"CycleBackground"=>FALSE,
        "AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"TickR"=>255,"TickG"=>255,"TickB"=>255);
    $myPicture->drawScale($scaleSettings);

    /* Write the chart legend */
    $myPicture->drawLegend(40,200,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

    /* Turn on Antialiasing */
    $myPicture->Antialias = TRUE;

    /* Draw the area chart */
    $MyData->setSerieDrawable($area,TRUE);
    $MyData->setSerieDrawable($ticks,FALSE);
    $myPicture->drawAreaChart();

    /* Draw a line and a plot chart on top */
    $MyData->setSerieDrawable($ticks,TRUE);
    $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
    $myPicture->drawLineChart();
    $myPicture->drawPlotChart(array("PlotBorder"=>TRUE,"PlotSize"=>3,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));

    return $myPicture;
  }
}
