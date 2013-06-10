<?php
include_once('../includes/entete.php');
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

include_once('../includes/pied.php');
?>

