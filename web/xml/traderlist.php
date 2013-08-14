<?php
if (isset($_GET['aid']))
{
    header ("Content-Type:text/xml");
    echo '<?xml version="1.0" encoding="UTF-8"?><liste>';

    include_once('../../classes/Connexion.class.php');
    $bdd = Outils_Bd::getInstance()->getConnexion();

    $req = $bdd->prepare('SELECT * FROM commerce WHERE id_commerce IN (SELECT id_commerce FROM abonnement WHERE id_abonne IN (SELECT id_abonne FROM abonne WHERE pseudo = ?))');
    $req->execute(array($_GET['aid']));
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
}
?>
