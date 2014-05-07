<?php

namespace obdo\pChartBundle\Controller;

use obdo\pChartBundle\pData;
use obdo\pChartBundle\pDraw;
use obdo\pChartBundle\pPie;
use obdo\pChartBundle\pImage;
use obdo\KuchiKomiRESTBundle\Entity\SqlStat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/*
 *
 */

class KuchiKomiStatController extends Controller {

    var $an;
    var $mois;

    public function choixAction($nom) {
        //determination de la route
        $route = '';
        switch ($nom){
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
        }
        //$this->kuchistatAction();
        return $this->render('obdoKuchiKomiBundle:Dashboard:graph.html.twig', array('laroute' => $route));
    }

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

        $nbKuchimois = SqlStat::getNbKuchiMois($this->mois, $this->an, $this);

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
            

            $chart = $this->chartgraph($dataset, $titre, $titre1,$ylegende,$xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/Silkscreen.ttf";
            $string = 'Vide';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    public function komistatAction() {
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
            

            $chart = $this->chartgraph($dataset, $titre, $titre1,$ylegende,$xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/Silkscreen.ttf";
            $string = 'Vide';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    public function subscriptionstatAction(){
        $table = 'Subscription';
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        $titre = 'Nbre Subscription/jour mois ' . $this->mois;
        $titre1 = date('j M Y');
        $ylegende = 'Nbre Subscription';
        $xdesc = 'jour'; // idem cle du dataset 
         
        $nbSubsmois = SqlStat::getNbSubscriptionMois($this->mois, $this->an, $this);

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
            

            $chart = $this->chartgraph($dataset, $titre, $titre1,$ylegende,$xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/Silkscreen.ttf";
            $string = 'Vide';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    public function kuchikomistatAction(){
        $table = 'KuchiKomi';
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        $titre = 'Nbre Kuchikomi/jour mois ' . $this->mois;
        $titre1 = date('j M Y');
        $ylegende = 'Nbre Kuchikomi';
        $xdesc = 'jour'; // idem cle du dataset 
         
        $nbKuchikomimois = SqlStat::getNbKuchikomiMois($this->mois, $this->an, $this);

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
            

            $chart = $this->chartgraph($dataset, $titre, $titre1,$ylegende,$xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/Silkscreen.ttf";
            $string = 'Vide';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
    public function thanksstatAction(){
        $table = 'Thanks';
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        //definir mois et annee du jour en cours
        $this->aujourdhui();
        $titre = 'Nbre Thanks/jour mois ' . $this->mois;
        $titre1 = date('j M Y');
        $ylegende = 'Nbre Thanks';
        $xdesc = 'jour'; // idem cle du dataset 
         
        $nbThanksmois = SqlStat::getNbThanksMois($this->mois, $this->an, $this);

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
            

            $chart = $this->chartgraph($dataset, $titre, $titre1,$ylegende,$xdesc);

            ob_start();
            $chart->autoOutput();
            $response->setContent(ob_get_clean());
        } else {
            // Render a default error image.
            $image = imagecreate(675, 75);
            $dark_grey = imagecolorallocate($image, 102, 102, 102);
            $white = imagecolorallocate($image, 255, 255, 255);
            $font_path = __DIR__ . "/../Resources/fonts/Silkscreen.ttf";
            $string = 'Vide';
            imagettftext($image, 50, 0, 10, 60, $white, $font_path, $string);

            ob_start();
            imagepng($image);
            $response->setContent(ob_get_clean());

            //Clear up memory 
            imagedestroy($image);
        }
        return $response;
    }
    
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

//        public function getNbKuchiMois($mois,$an)
//    {
//        $requete = 'select day( date( k.timestampCreation )) as jour , count( k.timestampCreation ) as nbre ';
//        $requete = $requete . 'from Kuchi k where month( date( k.timestampCreation )) = :mois AND year( date( k.timestampCreation )) = :an';
//        $requete = $requete . ' group by day( date( k.timestampCreation ))';
//
//        $em = $this->getDoctrine()->getManager();
//        $db = $em->getConnection();
//        $query = $db->prepare($requete);
//        $query->execute(array('mois' => intval($mois), 'an' => intval($an)));
//        return $query->fetchAll();
//    }

    /*
     * chartgraph creation de l'image (png) contenant le graphique
     * $dataset = les données à afficher
     * $titre = titre du graphique
     * $titre1 = titre de la fenetre
     * $ylegende = Legende axe y 
     * $xdesc = data servant de repere sur axe x
     */
    protected function chartgraph($dataset, $titre, $titre1,$ylegende,$xdesc) {
        $MyData = new pData();
        $MyData = $dataset;
        $MyData->setAxisName(0, $ylegende);
        $MyData->setSerieDescription($xdesc,$xdesc);
        $MyData->setAbscissa($xdesc);

        //$MyData->setAbscissa("Labels");
        /* Create the pChart object */
        $myPicture = new pImage(700, 230, $MyData);

        /* Turn on antialiasing */
        $myPicture->Antialias = FALSE;

        /* Create a solid background */
        $Settings = array("R" => 66, "G" => 139, "B" => 202, "Dash" => 1, "DashR" => 66, "DashG" => 139, "DashB" => 202);
        $myPicture->drawFilledRectangle(0, 0, 700, 230, $Settings);

        /* Do a gradient overlay */
        $Settings = array("StartR" => 66, "StartG" => 139, "StartB" => 202, "EndR" => 255, "EndG" => 255, "EndB" => 255, "Alpha" => 50);
        $myPicture->drawGradientArea(0, 0, 700, 230, DIRECTION_VERTICAL, $Settings);
        $myPicture->drawGradientArea(0, 0, 700, 20, DIRECTION_VERTICAL, array("StartR" => 66, "StartG" => 139, "StartB" => 202, "EndR" => 66, "EndG" => 139, "EndB" => 202, "Alpha" => 100));

        /* Add a border to the picture */
        $myPicture->drawRectangle(0, 0, 699, 229, array("R" => 66, "G" => 139, "B" => 202));

        /* Write the picture title */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 8));
        $myPicture->drawText(10, 13, $titre1, array("R" => 255, "G" => 255, "B" => 255));

        /* Draw the scale */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/verdana.ttf", "FontSize" => 6));
        $myPicture->setGraphArea(50, 60, 670, 190);
        $myPicture->drawFilledRectangle(50, 60, 670, 190, array("R" => 255, "G" => 255, "B" => 255, "Surrounding" => -200, "Alpha" => 10));
        $myPicture->drawScale(array("CycleBackground" => TRUE));

        /* Graph title */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 11));
        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10));
        $myPicture->drawText(50, 52, $titre, array("FontSize" => 20, "Align" => TEXT_ALIGN_BOTTOMLEFT));

        /* Draw the bar chart chart */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/verdana.ttf", "FontSize" => 6));
        $MyData->setSerieDrawable("nbre", TRUE);
       
        $myPicture->drawBarChart();

        /* Turn on antialiasing */
        $myPicture->Antialias = TRUE;

        /* Draw the line and plot chart */
//    $MyData->setSerieDrawable("Last year",TRUE);
//    $MyData->setSerieDrawable("This year",FALSE);
//    $myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
//    $myPicture->drawSplineChart();
//
        $myPicture->setShadow(FALSE);
        //$myPicture->drawPlotChart(array("PlotSize"=>3,"PlotBorder"=>TRUE,"BorderSize"=>3,"BorderAlpha"=>20));

        /* Make sure all series are drawable before writing the scale */
        $MyData->drawAll();

        /* Write the legend */
        $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10));
        $myPicture->drawLegend(580, 35, array("Style" => LEGEND_ROUND, "Alpha" => 20, "Mode" => LEGEND_HORIZONTAL));

        return $myPicture;
    }

}
