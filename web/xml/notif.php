<?php
// Le système de notifications fonctionne comme suit :
// - toutes les 3 secondes, un service sur le téléphone appelle cette page
// - en fonction de l'adresse ip du téléphone, on identifie l'abonné
// - on récupère le dernier kuchikomi écrit par les commerçants où l'utilisateur est abonné.
// - on renvoie en xml les données de ce kuchikomi
header ("Content-Type:text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?><liste>';

include_once('../../classes/Connexion.class.php');

$bdd = Outils_Bd::getInstance()->getConnexion();


if (isset($_GET['aid']))
{
// Il faut récupérer le dernier kuchikomi des commerces où est abonné celui dont j'obtiens l'adresse ip.

$req = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_commerce IN
(SELECT id_commerce FROM abonnement WHERE id_abonne IN
(SELECT id_abonne FROM abonne WHERE pseudo = ?))
ORDER BY heure_ecriture DESC LIMIT 0,1');

$req->execute(array($_GET['aid']));
while($donnees = $req->fetch())
	{
	echo '<kuchikomi>';
	$compteur=0;
	foreach($donnees as $key => $value)
		{
		if ($compteur % 2==0)
			{
			echo '<' . $key . '>' . $value . '</' . $key . '>';
			}
		$compteur=$compteur+1;
		}
        echo "<nb_jaime>";
        $req4 = $bdd->prepare("SELECT count(id_kuchikomi) FROM jaime WHERE id_kuchikomi = ?");
        $req4->execute(array($donnees["id_kuchikomi"]));
        $data4 = $req4->fetch();
        echo $data4["count(id_kuchikomi)"];
        echo "</nb_jaime>";
	echo '</kuchikomi>';
	}
echo '</liste>';
}
?>
