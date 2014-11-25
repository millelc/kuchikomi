<?php

namespace obdo\pChartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/*
 *
 */

class KomiStatController extends Controller 
{
    
    public function varDumpToString ($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

    /*
     * Calcul et affichage stat mois en cours
     * pour les Kuchis
     */
    public function distributionOsAction() 
    {
        $graphCreator = $this->container->get('pChartBundle_services.graphCreator');
                                               
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        
        $em = $this->getDoctrine()->getManager();
        $repositoryKomi = $em->getRepository('obdoKuchiKomiRESTBundle:Komi');
        
        $dataSet = $repositoryKomi->getOsDistribution();

        $i = 0;
        foreach($dataSet as $dataOs)
        {
            switch ($dataOs["osType"])
            {
                case "0":
                    $absissa[$i] = "Android";
                    break;
                case "1":
                    $absissa[$i] = "iOS";
                    break;
                case "2":
                    $absissa[$i] = "Windows";
                    break;
                default:
                    $absissa[$i] = "Inconnu";
            }
            $dataset[$i] = $dataOs["NB"];
            $i = $i + 1;
        }
        
        $chart = $graphCreator->piegraph($dataset,$absissa);

        ob_start();
        $chart->autoOutput();
        //return ob_get_clean();
        $response->setContent(ob_get_clean());
            
        return $response;
    }

}
