<?php
if (isset ($_GET['list']) AND isset ($_GET['aid']))
{
    include_once('../../classes/Connexion.class.php');
    $bdd = Outils_Bd::getInstance()->getConnexion();

    // Il est d'abord nécessaire de récupérer l'id (équivalent id_abonne)
    // de la personne dont on reçoit l'aid (équivalent pseudo)
    $req= $bdd->prepare('SELECT id_abonne FROM abonne WHERE pseudo = ?');

    $req->execute(array($_GET['aid']));
    $data = $req->fetch();

    // On vérifie que cet utilisateur existe bien.
    if ($data['id_abonne']!='')
    {
        $id_user = $data['id_abonne'];
        // Soit on désire la liste des 10
        // derniers kuchikomis écrits.
        if ($_GET['list']=='full')
        {
            $req = $bdd->prepare('SELECT * FROM kuchikomi WHERE heure_publication<NOW() AND id_commerce IN (SELECT id_commerce FROM abonnement WHERE id_abonne = ?) ORDER BY heure_ecriture DESC LIMIT 0,10');
            $req->execute(array($id_user));
            // Écriture du xml.
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
                echo "<nb_jaime>";
                $req4 = $bdd->prepare("SELECT count(id_kuchikomi) FROM jaime WHERE id_kuchikomi = ?");
                $req4->execute(array($donnees["id_kuchikomi"]));
                $data4 = $req4->fetch();
//                var_dump($data4);
                echo $data4["count(id_kuchikomi)"];
                echo "</nb_jaime>";
                echo '</kuchikomi>';
            }
            echo '</liste>';
        }
        // Soit on désire une liste de kuchikomi
        // d'un commerce bien particulier.
        else
        {
            $req = $bdd->prepare('SELECT * FROM kuchikomi WHERE heure_publication<NOW() AND id_commerce = ? ORDER BY heure_publication DESC');
            $req->execute(array($_GET['list']));
            // Écriture du xml.
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
                echo "<nb_jaime>";
                $req4 = $bdd->prepare("SELECT count(id_kuchikomi) FROM jaime WHERE id_kuchikomi = ?");
                $req4->execute(array($donnees["id_commerce"]));
                $data4 = $req4->fetch();
//                var_dump($data4);
                echo $data4["count(id_kuchikomi)"];
                echo "</nb_jaime>";
                echo '</kuchikomi>';
            }
            echo '</liste>';
        }
    }
}
?>
