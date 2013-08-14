<?php

// D'abord, on récupère en POST les adresses ip et les identifiant
// et on renvoie un xml la liste des commerçants où cette personne est abonnée.
// device_ip et android_id

if (isset($_GET['id']))
{

echo '<?xml version="1.0" encoding="UTF-8"?><liste>';

include_once('../../classes/Connexion.class.php');

$bdd = Outils_Bd::getInstance()->getConnexion();



// Il faut récupérer les données des commerces où est abonné celui dont on obtient l'adresse ip.

$req = $bdd->prepare('SELECT * FROM commerce WHERE id_commerce IN
(SELECT id_commerce FROM abonnement WHERE id_abonne IN
(SELECT id_abonne FROM abonne WHERE id_abonne = ?))');
$req->execute(array($_GET['id']));
while($donnees = $req->fetch())
	{
	echo '<commerces>';
	$compteur=0;
	foreach($donnees as $key => $value)
	{
	    if ($compteur % 2==0)
	    {
	        if ($key == 'donnees_google_map')
	        {
	            echo '<latitude>' . $value . '</latitude>';
	        }

	        else if ($key == 'donnees_GPS')
	        {
	            echo '<longitude>' . $value . '</longitude>';
	        }

	        else
	        {
	            echo '<' . $key . '>' . $value . '</' . $key . '>';
	        }
	    }
	    $compteur=$compteur+1;
	}
	echo '</commerces>';
	}
echo '</liste>';
header ("Content-Type:text/xml");
}
?>
