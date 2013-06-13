<?php
include_once('../includes/entete.php');
echo '<br />Voici la liste de vos abonnements :<br /> ';
//var_dump($listeAbonnements);
foreach($listeAbonnements as $cle => $valeur)
	{
	echo '<a href="index.php?appel=liste&amp;id=' . $cle . '"><img src="../org/images_com/' . $valeur . '" alt="Logo commerce" title="Logo commerce" style="width: 75px; margin-left: 20px; margin-top:10px; border: 1px black outset;" /></a>';
	echo '';
	}
echo '<br /><a class="btn btn-medium btn-info" href="index.php?appel=deco&amp;id=none" style="margin-top:35px;">Déconnexion</a>';
echo '<br /><br />  <a href="index.php?appel=desinscr&amp;id=none">Désinscription</a>';


include_once('../includes/pied.php');
?>