<?php

include_once('../../includes/configuration.php');
include_once('../../modeles/Connexion.class.php');


$bdd = Outils_Bd::getInstance()->getConnexion();


echo '<?xml version="1.0" encoding="UTF-8"?><liste>';




// Il faut récupérer les kuchikomi des commerces où est abonné celui dont j'obtiens l'adresse ip.


$req = $bdd->prepare('SELECT * FROM commerce WHERE id_commerce IN (SELECT id_commerce FROM abonnement WHERE id_abonne IN (SELECT id_abonne FROM abonne WHERE adresse_ip = ?))');
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
 
