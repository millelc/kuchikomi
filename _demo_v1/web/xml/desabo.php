<?php
if (isset($_GET['id']) AND isset($_GET['aid']))
{
    // 1° On récupère l'identifiant de la personne.
    // 2° On vérifie que le j'aime n'existe pas déjà.
    // 3° Si elle est inexistante, on l'ajoute à la bdd
    include_once('../../classes/Connexion.class.php');
    $bdd = Outils_Bd::getInstance()->getConnexion();
    $req = $bdd->prepare('SELECT id_abonne FROM abonne WHERE pseudo = ?');
    $req->execute(array($_GET['aid']));
    $idabo = $req->fetch()['id_abonne'];

    $q = $bdd->prepare('DELETE FROM abonnement WHERE id_abonne = ? AND id_commerce=?');
    $q->execute(array($idabo, $_GET['id']));
}
?>
