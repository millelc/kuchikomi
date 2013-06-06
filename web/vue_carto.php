<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="user-scalable=no, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, width=device-width">
        <link href="../style/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../style/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <title>Kuchikomi</title>
    </head>
 
    <body>
    
    <header class="page-header">
      <h1><a href="index.php">KuchiKomi</a></h1>
    </header>





<?php

/*
echo '<a class="btn btn-medium btn-info"  style="margin-right: 50px;" href="index.php?appel=liste&amp;id=none"><i class="icon-white icon-chevron-left"></i>Retour à la liste</a>';
echo '<a class="btn btn-medium btn-success" href="index.php?appel=contact&amp;id=' . $_GET['id'] . '"><i class="icon-white icon-envelope"></i> Contacter</a>';
*/




echo '<a class="btn btn-medium btn-info"  style="margin-right: 30px;" href="index.php?appel=liste&amp;id=none"><i class="icon-white icon-chevron-left"></i>Retour à la liste</a>';
echo '<a class="btn btn-medium btn-success" href="index.php?appel=contact&amp;id=' . $_GET['id'] . '">Contacter<i class="icon-white icon-road"></i></a>';





//var_dump($infoscarto);


echo '<p><br /><br /><br />Adresse :  ' . $infoscarto['adresse'] . '</p>';
echo '<p>Ligne de bus :  ' . $infoscarto['bus'] . '</p>';
echo '<p>Arrêt :  ' . $infoscarto['arret'] . '</p>';



if ($bandeau=='None')
	{
	echo '<footer style="background-color: black; color: white; margin-top:25px;">Bandeau d\'information dynamique';
	}
else
	{
	echo '<footer >';
	}
?>


    </footer>



</body>


</html>


