<?php

namespace obdo\pChartBundle\Services;

use obdo\pChartBundle\pData;
use obdo\pChartBundle\pImage;
use obdo\pChartBundle\pPie;

class GraphCreator
{
    const BORDER = 40;
    const X_SIZE = 700;
    const Y_SIZE = 400;
    /*
     * Création d'un graphique type camembert
     */
    public function piegraph($dataset,$absissa) 
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
        $myPicture = new pImage(GraphCreator::X_SIZE, GraphCreator::Y_SIZE, $MyData,TRUE); // TRUE = backgroud transparent

        /* Create a solid background */
        $Settings = array("R" => 66, "G" => 139, "B" => 202, "Dash" => 1, "DashR" => 66, "DashG" => 139, "DashB" => 202);
        $myPicture->drawFilledRectangle(0, 0, GraphCreator::X_SIZE, GraphCreator::Y_SIZE, $Settings);

        /* Set the default font properties */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 16, "R" => 80, "G" => 80, "B" => 80));

        /* Create the pPie object */
        $PieChart = new pPie($myPicture, $MyData);

        /* Draw a splitted pie chart */
        $PieChart->draw2DRing(GraphCreator::X_SIZE/2, GraphCreator::Y_SIZE/2, array("WriteValues" => PIE_VALUE_PERCENTAGE, "DataGapAngle" => 10, 
            "DataGapRadius" => 6, "Border" => TRUE, "BorderR" => 255, "BorderG" => 255, "BorderB" => 255,
            "Precision" => 2, "ValuePosition" => PIE_VALUE_OUTSIDE));

        /* Write the legend box */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 16));
        $PieChart->drawPieLegend(10, 13, array("Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL
            , "FontR" => 255, "FontG" => 255, "FontB" => 255));
        
        $myPicture->setShadow(FALSE);
    
        return $myPicture;
    }

    /**
     * chartgraph creation de l'image (png) contenant le graphique
     * @param array $dataset Série de données à afficher
     * @param array $xdesc Série de données servant de repere sur axe x
     * 
     * @return png Graph en histogramme
     */
    public function chartgraph($dataset, $xdesc) 
    {
        $MyData = new pData();
        $MyData = $dataset;
        $MyData->setAxisColor(0,array("R" => 255, "G" => 255, "B" => 255));
        $MyData->setSerieDescription($xdesc, $xdesc);
        $MyData->setAbscissa($xdesc);

        $MyData->loadPalette(__DIR__ . "/../Resources/palettes/blind.color", TRUE);
        /* Create the pChart object */
        $myPicture = new pImage(GraphCreator::X_SIZE, GraphCreator::Y_SIZE, $MyData,TRUE); // TRUE = backgroud transparent

        /* Turn on antialiasing */
        $myPicture->Antialias = FALSE;

        /* Create a solid background */
        $Settings = array("R" => 66, "G" => 139, "B" => 202, "Dash" => 1, "DashR" => 66, "DashG" => 139, "DashB" => 202);
        $myPicture->drawFilledRectangle(0, 0, GraphCreator::X_SIZE, GraphCreator::Y_SIZE, $Settings);

        
        /* Draw the scale */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 16
            ,"R" => 255, "G" => 255, "B" => 255));
        //$myPicture->setGraphArea(50, 60, 670, 190);
        $myPicture->setGraphArea(GraphCreator::BORDER,GraphCreator::BORDER,
                GraphCreator::X_SIZE - GraphCreator::BORDER, GraphCreator::Y_SIZE - GraphCreator::BORDER);
        $myPicture->drawScale(array("Mode" => SCALE_MODE_START0, "CycleBackground" => TRUE,"AxisR"=>255,"AxisG"=>255,"AxisB"=>255
                                ,"TickR"=>255,"TickG"=>255,"TickB"=>255));

        
        /* Draw the bar chart chart */
        $myPicture->setFontProperties(array("FontName" => __DIR__ . "/../Resources/fonts/calibri.ttf", "FontSize" => 16));
        $MyData->setSerieDrawable("nbre", TRUE);
        $MyData->setSerieDrawable("Mo", TRUE);

        $myPicture->drawBarChart();

        /* Turn on antialiasing */
        $myPicture->Antialias = TRUE;

        $myPicture->setShadow(FALSE);

        /* Make sure all series are drawable before writing the scale */
        $MyData->drawAll();

        return $myPicture;
    }

}
