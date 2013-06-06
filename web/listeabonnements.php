

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="../style/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../style/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <title>Kuchikomi</title>
    </head>
 
    <body>
    
    <header class="page-header">
      <h1><a href="index.php">KuchiKomi</a></h1>
    </header>





<?php
echo '<br />Voici la liste de vos abonnements :<br /> ';
//var_dump($listeAbonnements);
foreach($listeAbonnements as $cle => $valeur)
	{
	echo '<a href="index.php?appel=liste&amp;id=' . $cle . '">' . $valeur . '</a><br />';
	}
echo '<br /><a class="btn btn-medium btn-info" href="index.php?appel=deco&amp;id=none">Déconnexion</a>';
echo '<br /><br />  <a href="index.php?appel=desinscr&amp;id=none">Désinscription</a>';
if ($bandeau=='None')
	{
	echo '<footer style="background-color: black; color: white;">Pas de bandeau choisi';
	}
else
	{
	echo '<footer >';
	}

?>



    </footer>



</body>


</html>


