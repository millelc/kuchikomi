

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
echo '<a class="btn btn-medium btn-success"  style="margin-right: 50px;" href="index.php?appel=contact&amp;id=' . $_GET['id'] . '"><i class="icon-white icon-envelope"></i> Contacter</a>';
echo '<a class="btn btn-medium btn-success" href="index.php?appel=yaller&amp;id=' . $_GET['id'] . '">Y aller ! <i class="icon-white icon-road"></i></a>';
echo '<br /><a style="margin-top: 15px;" class="btn btn-medium btn-info" href="index.php?appel=liste&amp;id=none"><i class="icon-white icon-chevron-left"></i> Vos abonnements</a><br />';
echo '<p><br />Voici la liste des kuchikomi de ce commerce :</p>';
foreach($listeKuchikomi as $cle => $valeur)
	{
	echo '<a href="index.php?appel=kk&amp;id=' . $cle . '">' . $valeur . '</a><br />';
	}
	
echo '<br /><br />';


echo '<a class="btn btn-medium btn-info" style="margin-right: 15px;" href="index.php?&amp;appel=desabo&amp;id=' . $_GET['id'] . '">Se désabonner</a>';
echo '<a class="btn btn-medium btn-danger" href="index.php?&amp;appel=deco&amp;id=none">Déconnexion</a>';
	
	
echo '<br /><br />  <a href="index.php?appel=desinscr&amp;id=none">Désinscription</a>';

?>



    
    <?php
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


