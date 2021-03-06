<?php
// Cette vue est réservée aux commerçants.
// Elle affiche la liste de tous les kuchikomi
// que le commerçant aura écrits

include_once('fragments/entete.php');

echo '<br /><a style="margin-top: 15px;" class="btn btn-medium btn-info" href="espmarc.php"><i class="icon-white icon-chevron-left"></i> Menu</a><br />';
echo '<p><br />Voici la liste de vos kuchikomi :</p>';
$now = date("Y-m-d");
while ($donnees = $listekk->fetch())
	{
	echo '<section style="border: 1px grey double; padding:10px; margin:10px;">';
	if ($now>$donnees[6])
		{
		echo '<p>Cette offre n\'est plus disponible.</p>';
		}
	else
		{
		echo '<p>Cette offre est valable du ' . date("d-m-Y", strtotime($donnees['date_debut'])) . ' au ' . date("d-m-Y", strtotime($donnees['date_fin'])) . '</p>';
		}
	echo $donnees['texte'] . '<br />';
	echo '<img src="images/' . $donnees['photo'] . '" style="width: 50%; margin:25px;" />';
	echo '<br />' . $donnees['mentions'];
	echo '</section>';
	}

include_once('fragments/pied.php');
?>