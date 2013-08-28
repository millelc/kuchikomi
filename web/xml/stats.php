<?php
session_start();

if (isset($_GET['id']))
{
    $_SESSION['id_commerce'] = $_GET['id'];

    include_once('../../modele/fonctionsMarc.php');
    include_once('../../classes/Connexion.class.php');
    $bdd = Outils_Bd::getInstance()->getConnexion();

    $data = calculStatistiques();
    // $data est donc un array de ce type:
    /* array ( $nb_abonnes,
               $nb_de_kuchikomi,
               $clef_meilleur_kuchikomi,
               $date_meilleur_kuchikomi,
               $nb_de_jaime_du_meilleur_kuchikomi,
               $abonnes_des_30_derniers_jours,
               $nombre_abonnes_de_plus_de_30_jours,
               $augmentation_sur_le_mois,
               $nbre_total_de_jaime,
               $donnees_meilleur_kk)
    */
    //var_dump($data);

    $name = array ( nb_abonnes, nb_de_kuchikomi, clef_meilleur_kuchikomi, date_meilleur_kuchikomi, nb_de_jaime_du_meilleur_kuchikomi, abonnes_des_30_derniers_jours, nombre_abonnes_de_plus_de_30_jours, augmentation_sur_le_mois, nbre_total_de_jaime, donnees_meilleur_kk);
    $i=0;

    header ("Content-Type:text/xml");
    echo '<?xml version="1.0" encoding="UTF-8"?><stats>';
    foreach($data as $donnee)
    {
        if ($name[$i]=='donnees_meilleur_kk')
        {
            echo '<detail_kuchikomi>';
            $compteur=0;

            foreach($donnee as $key => $value)
            {
                if ($compteur % 2==0)
                {
                    echo '<' . $key . '>' . $value . '</' . $key . '>';
                }
                $compteur = $compteur +1;
            }

            echo "<nb_jaime>";
    //        var_dump($donnee);

            $req4 = $bdd->prepare("SELECT count(id_kuchikomi) FROM jaime WHERE id_kuchikomi = ?");
            $req4->execute(array($donnee["id_kuchikomi"]));
            $data4 = $req4->fetch();
            echo $data4["count(id_kuchikomi)"];
            echo "</nb_jaime>";

            echo '</detail_kuchikomi>';
        }
        else
        {
            echo '<' . $name[$i] . '>' . $donnee . '</' . $name[$i] . '>';
        }
        $i = $i + 1;
    }
    echo '</stats>';
}
?>
