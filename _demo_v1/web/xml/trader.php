<?php

if (isset($_GET['id']) AND !isset($_GET['modif']))
{
echo '<?xml version="1.0" encoding="UTF-8"?><liste>';

include_once('../../classes/Connexion.class.php');

$bdd = Outils_Bd::getInstance()->getConnexion();



// Il faut récupérer les données d'un commerce.

$req = $bdd->prepare('SELECT * FROM commerce WHERE id_commerce = ?');
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

else// if (isset($_GET['modif']) AND isset ($_GET['id']))
{
    include_once('../../classes/Connexion.class.php');
    $bdd = Outils_Bd::getInstance()->getConnexion();

    $nom = $_POST['nom'];
    $gerant = $_POST['gerant'];
    $horaires = $_POST['horaires'];
    $num_tel = $_POST['num_tel'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $ligne_bus = $_POST['ligne_bus'];
    $arret = $_POST['arret'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Il reste à récupérer les deux images envoyées en même temps que le POST.

    include_once('../../modele/fonctionsAdmin.php');

$data = $_POST['logo'];
$bdd = Outils_Bd::getInstance()->getConnexion();
$q = $bdd->prepare('INSERT INTO testimage (base, encode, decode) VALUES (?, ?, ?)');
$q->execute(array($data, $_POST['logo'], $data));

/*
$data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
       . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
       . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
       . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';
*/

$data = base64_decode($data);


$monfichier = fopen('../images/image.png', 'cb');
fputs($monfichier, $data);
fclose($monfichier);

}
?>
