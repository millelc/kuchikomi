<?php
// Cette vue affiche comment
// contacter un magasin.

include_once('fragments/entete.php');

echo '<a class="btn btn-medium btn-info"  style="margin-right: 50px;" href="index.php?appel=liste&amp;id=none"><i class="icon-white icon-chevron-left"></i>Retour à la liste</a>';


echo '<p><br /><br /><br />Nom :  ' . $infoscontacts['nom'] . '</p>';
echo '<p>Gérant :  ' . $infoscontacts['gerant'] . '</p>';
echo '<p>Horaires :  ' . $infoscontacts['horaires'] . '</p>';
echo '<p>Téléphone :  ' . $infoscontacts['num_tel'] . '</p>';
echo '<p>E-mail :  ' . $infoscontacts['email'] . '</p>';

include_once('fragments/pied.php');
?>