<?php
include_once('../includes/entete_marc.php');


echo 'Bienvenue,  ' . $_SESSION['pseudo'] . '. Votre identifiant est le ' . $_SESSION['id_commerce'] . '.</p>';

echo '<p><br /><a class="btn btn-medium btn-info margin:auto;" href="espmarc.php?appel=interface">Poster</a> <a class="btn btn-medium btn-info margin:auto;" style="margin-left:100px;" href="espmarc.php?appel=liste">Liste de vos kuchikomi</a></p>';


$statistiques = calculStatistiques();

echo '<br />Vous avez ' . $statistiques[0] . ' abonnés.';
echo '<p>Vous avez écrit ' . $statistiques[1] . ' kuchikomi.</p>';
echo '<p>Votre kuchikomi le plus aimé est le n° ' . $statistiques[2] . ' datant du ' . $statistiques[3] . ' qui l\'a été ' . $statistiques[4] . ' fois.</p>';
echo '<p>Ces 30 derniers jours, ' . $statistiques[5] . ' personnes se sont abonnées. Vous en aviez ' . $statistiques[6] . ' auparavant.</p>';
echo '<p>Votre nombre d\'abonnés a augmenté de '. $statistiques[7] . '% durant les 30 derniers jours.</p>';
echo 'Vos kuchikomi ont été aimé ' . $statistiques[8] . ' fois.';



echo '<p><br /><a class="btn btn-medium btn-info margin:auto;" href="espmarc.php?appel=deco">Déconnexion</a>';





include_once('../includes/pied.php');
?>