

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="user-scalable=no, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, width=device-width">
        <link href="../style/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../style/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <link href="../style/css/correction.css" rel="stylesheet" type="text/css">
        <title>Kuchikomi</title>
    </head>
 
    <body>
    
    <header class="page-header">
      <h1><a href="index.php">KuchiKomi</a></h1>
    </header>





<?php


echo '<br /><a style="margin-top: 15px;" class="btn btn-medium btn-info" href="index.php?appel=liste&amp;id=none"><i class="icon-white icon-chevron-left"></i> Retour à la liste</a><br />';

//var_dump($kuchikomi);

echo '<p><br /><br />' . $kuchikomi . '<br /><br /><br /><br /></p>';

echo '<a class="btn btn-medium btn-success"  style="margin-right: 50px;" href="index.php?appel=jaime&amp;id=' . $_GET['id'] . '"><i class="icon-white icon-thumbs-up"></i>J\'aime !</a>';
echo '<a class="btn btn-medium btn-success" href="">Faites passer !<i class="icon-white icon-hand-right"></i></a>';

if ($bandeau=='None')
	{
	echo '<footer style="background-color: black; color: white; margin-top:25px;">Bandeau d\'information dynamique';
	}
else
	{
	echo '<footer><p><img src="../style/NearforgeLogo1eCom-ePub.png" alt="Nearforge" title="Nearforge" /></p>';
	}
?>


    </footer>



</body>


</html>


