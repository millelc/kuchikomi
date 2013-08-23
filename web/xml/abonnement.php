<?php
if (isset($_GET['id']) AND isset($_GET['aid']) )
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
        // On vérifie ensuite si le commerce existe
        // Ensuite si l'abonnement existe déjà.
        // Si oui, on ne fait rien, si non, on l'ajoute en bdd.

        $req3 = $bdd->prepare('SELECT id_commerce FROM commerce WHERE id_commerce = ?');
        $req3->execute(array($_GET['id']));
        $data3 = $req3->fetch();

        if ($data3['id_commerce']!='')
        {
            $req2 = $bdd->prepare('SELECT id_abonne FROM abonnement WHERE id_abonne = ? AND id_commerce = ?');
            $req2->execute(array($id_user, $_GET['id']));
            $data2 = $req2->fetch();
            if ($data2['id_abonne']=='')
            {
            //Pas d'abonnement identique, on peut donc lancer l'abonnement.
                $q = $bdd->prepare('INSERT INTO abonnement (id_abonne, id_commerce, date) VALUES(?, ?, NOW())');
                $q->execute(array($id_user, $_GET['id']));
            }
        }
    }
}
?>
