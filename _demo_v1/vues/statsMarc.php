<?php
include_once('fragments/enteteMarc.php');

echo recuplogo($_SESSION['id_commerce']);
echo '<p><br /><a class="btn btn-medium btn-info margin:auto;" href="espmarc.php?appel=interface">Poster</a> <a class="btn btn-medium btn-info margin:auto;" style="margin-left:100px;" href="espmarc.php?appel=liste">Liste de vos kuchikomi</a></p>';

$statistiques = calculStatistiques();

echo '
	<table style="width:50%; text-align:left;">
	<caption>Vos abonnés</caption>
	<tr><th>Nombre d\'abonnés</th><th style="text-align:right;">' . $statistiques[0] . '</th></tr>
	<tr><th>Nouveaux abonnés ces 30 derniers jours</th><th style="text-align:right;">' . $statistiques[5] . '</th></tr>
	<tr><th>Nombre d\'abonnés avant cette date</th><th style="text-align:right;">' . $statistiques[6] . '</th></tr>
	<tr><th>Augmentation</th><th style="text-align:right;">'. $statistiques[7] . '%</th></tr>
	</table>
	
	
	<table style="width:50%; text-align:left;">
	<caption>Vos kuchikomi</caption>
	<tr><th>Nombre de kuchikomi</th><th style="text-align:right;">' . $statistiques[1] . '</th></tr>
	<tr><th>Nombre total de « J\'aime ! »</th><th style="text-align:right;">' . $statistiques[8] . '</th></tr>
	</table>
	
	<h5>Votre kuchikomi le plus apprécié :</h5>
	';
echo '<p>« ' . $statistiques[9]['texte'] . ' »<br /><img src="images/' . $statistiques[9]['photo'] . '" style="width: 50%; margin:25px;" /></p><p>Valable entre ' . $statistiques[9]['date_debut'] . ' et ' . $statistiques[9]['date_fin'] . '. Il a été aimé ' . $statistiques[4] . ' fois en tout.</p>';
echo '<p><br /><a class="btn btn-medium btn-info margin:auto;" href="espmarc.php?appel=deco">Déconnexion</a>';

include_once('fragments/pied.php'); 


?>