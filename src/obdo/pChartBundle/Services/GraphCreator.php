<?php

namespace obdo\pChartBundle\Services;

use obdo\pChartBundle\pData;
use obdo\pChartBundle\pImage;
use obdo\pChartBundle\pPie;

class GraphCreator
{
    /*
     * Création d'un graphique type camembert
     */
    public function piegraph($dataset,$titre,$absissa) 
    {
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

}
