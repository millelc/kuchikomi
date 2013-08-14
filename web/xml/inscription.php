<?php
if (isset($_GET['aid']))
{
    include_once('../../classes/Connexion.class.php');
    $bdd = Outils_Bd::getInstance()->getConnexion();

    $req = $bdd->prepare('SELECT pseudo FROM abonne WHERE pseudo = ?');
    $req->execute(array($_GET['aid']));
    $data = $req->fetch();
    if ($data['pseudo']=='')
    {
        //Pas d'abonnés à ce nom, on peut inscrire.
        $q = $bdd->prepare('INSERT INTO abonne (pseudo, adresse_ip) VALUES(?, ?)');
        $q->execute(array($_GET['aid'], $_SERVER['REMOTE_ADDR']));
    }
}
?>
