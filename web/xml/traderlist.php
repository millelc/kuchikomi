<?php

// Pour avoir la liste des abonnements d'une personne
// OU pour avoir la liste des kuchikomi d'un commerçant.

if (isset($_GET['aid']))
{
    // On veut les abonnements d'un utilisateur.
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


else
// On veut les kuchikomi d'un commerce.
{
    include_once('../../classes/Connexion.class.php');
    $bdd = Outils_Bd::getInstance()->getConnexion();

    $req = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_commerce = ? ORDER BY id_kuchikomi DESC');
    $req->execute(array($_GET['id']));

    header ("Content-Type:text/xml");
            echo '<?xml version="1.0" encoding="UTF-8"?><liste>';
            while($donnees = $req->fetch())
            {
                echo '<kuchikomi>';
                $compteur=0;
                foreach($donnees as $key => $value)
                {
                    if ($compteur % 2==0)
                    {
                        echo '<' . $key . '>' . $value . '</' . $key . '>';
                        if ($key=='photo')
                        {
                            $req3= $bdd->prepare('SELECT logo FROM commerce WHERE id_commerce = ?');
                            $req3->execute(array($donnees["id_commerce"]));
                            $data3 = $req3->fetch()['logo'];
                            echo "<photo_trader>" . $data3 . "</photo_trader>";
                        }
                    }
                    $compteur=$compteur+1;
                }
                echo '</kuchikomi>';
            }
            echo '</liste>';

}

?>
