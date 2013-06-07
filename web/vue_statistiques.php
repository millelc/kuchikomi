

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
      <h1><a href="espmarc.php">KuchiKomi</a></h1>
    </header>





<?php


/*

L'array $statistiques est de ce type (
0 $nb_abonnes,
1 $nb_de_kuchikomi,
2 $clef_meilleur_kuchikomi,
3 $date_meilleur_kuchikomi,
4 $nb_de_jaime_du_meilleur_kuchikomi,
5 $abonnes_des_30_derniers_jours,
6 $nombre_abonnes_de_plus_de_30_jours,
7 $augmentation_sur_le_mois,
8 $nbre_total_de_jaime)


*/



echo '<p><br /><a class="btn btn-medium btn-info margin:auto;" href="espmarc.php?appel=interface">Poster</a></p>';

echo '<p>Page de statistiques.</p>';

echo '<br />Vous avez ' . $statistiques[0] . ' abonnés.';
echo '<p>Vous avez écrit ' . $statistiques[1] . ' kuchikomi.</p>';
echo '<p>Votre kuchikomi le plus aimé est le n° ' . $statistiques[2] . ' datant du ' . $statistiques[3] . ' qui l\'a été ' . $statistiques[4] . ' fois.</p>';
echo '<p>Ces 30 derniers jours, ' . $statistiques[5] . ' personnes se sont abonnées. Vous en aviez ' . $statistiques[6] . ' auparavant.</p>';
echo '<p>Votre nombre d\'abonnés a augmenté de '. $statistiques[7] . '% durant les 30 derniers jours.</p>';
echo 'Vos kuchikomi ont été aimé ' . $statistiques[8] . ' fois.';



echo '<p><a class="btn btn-medium btn-warning" style="margin-top:15px;" href="espmarc.php?appel=deco&amp;id=none">Déconnexion</a></p>';



if ($bandeau=='None')
	{
	echo '<footer style="background-color: black; color: white;">Pas de bandeau choisi';
	}
else
	{
	echo '<footer><p><img src="../style/NearforgeLogo1eCom-ePub.png" alt="Nearforge" title="Nearforge" /></p>';
	}
	

?>



    </footer>



</body>


</html>


