<?php
// Le système de notifications fonctionne comme suit :
// - toutes les 3 secondes, un service sur le téléphone appelle cette page
// - en fonction de l'adresse ip du téléphone, on identifie l'abonné
// - on récupère le dernier kuchikomi écrit par les commerçants où l'utilisateur est abonné.
// - on renvoie en xml les données de ce kuchikomi

echo '<?xml version="1.0" encoding="UTF-8"?><liste>';

include_once('../../classes/Connexion.class.php');

$bdd = Outils_Bd::getInstance()->getConnexion();



// Il faut récupérer les données des commerces où est abonné celui dont on obtient l'adresse ip.

$req = $bdd->prepare('SELECT * FROM commerce WHERE id_commerce IN
(SELECT id_commerce FROM abonnement WHERE id_abonne IN
(SELECT id_abonne FROM abonne WHERE adresse_ip = ?))');
$req->execute(array($_SERVER['REMOTE_ADDR']));
while($donnees = $req->fetch())
	{
	echo '<commerces>';
	$compteur=0;
	foreach($donnees as $key => $value)
		{
		if ($compteur % 2==0)
			{
			echo '<' . $key . '>' . $value . '</' . $key . '>';
			}
		$compteur=$compteur+1;
		}
	echo '</commerces>';
	}
echo '</liste>';
header ("Content-Type:text/xml"); 
?>