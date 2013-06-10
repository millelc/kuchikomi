<?php
include_once('../includes/entete.php');
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

include_once('../includes/pied.php');
?>