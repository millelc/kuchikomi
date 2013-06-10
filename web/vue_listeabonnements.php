<?php
include_once('../includes/entete.php');
echo '<br />Voici la liste de vos abonnements :<br /> ';
//var_dump($listeAbonnements);
foreach($listeAbonnements as $cle => $valeur)
	{
	echo '<a href="index.php?appel=liste&amp;id=' . $cle . '">' . $valeur . '</a><br />';
	}
echo '<br /><a class="btn btn-medium btn-info" href="index.php?appel=deco&amp;id=none">Déconnexion</a>';
echo '<br /><br />  <a href="index.php?appel=desinscr&amp;id=none">Désinscription</a>';


include_once('../includes/pied.php');
?>