<?php
include_once('../includes/entete.php');
echo '<br />Voici la liste de vos abonnements :<br /> ';
$bdd = Outils_Bd::getInstance()->getConnexion();
var_dump($bdd);

foreach($listeAbonnements as $cle => $valeur)
	{
	echo '<table style="float:left;"><a href="index.php?appel=liste&amp;id=' . $cle . '"><img src="../org/images_com/' . $valeur . '" alt="Logo commerce" title="Logo commerce" style="width: 75px; margin-left: 20px; margin-top:10px; border: 1px black outset;" /></a>' .$nbreKkValides[$cle] . '';
	
	}
echo '</table>';
echo '<br /><a class="btn btn-medium btn-info" href="index.php?appel=deco&amp;id=none" style="margin-top:35px; clear:both;">Déconnexion</a>';
echo '<br /><br />  <a href="index.php?appel=desinscr&amp;id=none">Désinscription</a>';



$now = date("Y-m-d");


while ($donnees = $derniersKKConfondus->fetch())
	{
	echo '<section style="border: 1px grey double; padding:10px; margin:10px;">';
	if ($now<$donnees[7])
		{
		echo '<p>Cette offre est valable du ' . date("d-m-Y", strtotime($donnees['date_debut'])) . ' au ' . date("d-m-Y", strtotime($donnees['date_fin'])) . '</p>';
		//$logo = '<img src="uploads/captvalide.png" alt="Logo commerce" title="Logo commerce" style="width: 75px; margin-left: 20px; margin-top:10px; border: 1px black outset;" />';
		}
	
	recuplogo($donnees['id_commerce']);  // Je triche : la vue n'est pas censée dialoguer avec le modèle.
	
	
	//echo $logo;
	
	
	echo '<a href="index.php?appel=kk&amp;id=' . $donnees['id_kuchikomi'] .    '" style="text-decoration: none;" >';
	
	echo '<br />   ' . $donnees['texte'] . '<br />';
	echo '<img src="uploads/' . $donnees['photo'] . '" style="width: 50%; margin:25px;" />';
	
	echo '<table><tr><td><a class="btn btn-medium btn-success" href="index.php?appel=jaime&amp;id=' . $donnees['id_kuchikomi'] . '"><i class="icon-white icon-thumbs-up"></i>J\'aime !</a></td>';
	echo '<td><a class="btn btn-medium btn-success" href="" >Faites passer !<i class="icon-white icon-hand-right"></i></a></td></tr></table>';
	echo '<br />' . $donnees['mentions'];
	echo '</a></section>';
	}





















include_once('../includes/pied.php');
?>