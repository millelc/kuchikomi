<?php
// Cette vue affiche les statistiques de façon textuelle.
// Obsolète ?

include_once('../includes/entete_marc.php');
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

include_once('../includes/pied.php');
?>