<?php
include_once('../../classes/Connexion.class.php');
$bdd = Outils_Bd::getInstance()->getConnexion();

/*
function autoRotateImage($image)
{
    $orientation = $image->getImageOrientation();
    switch($orientation)
    {
        case imagick::ORIENTATION_BOTTOMRIGHT:
            $image->rotateimage("#000", 180); // pivotete 180 degrés
            break;
        case imagick::ORIENTATION_RIGHTTOP:
            $image->rotateimage("#000", 90); // pivote 90 degrés CW
        break;

        case imagick::ORIENTATION_LEFTBOTTOM:
            $image->rotateimage("#000", -90); // pivote 90 degrés CCW
        break;
    }
    // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
    $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
}
*/
if (isset($_GET['action']))
{
    if ($_GET['action']=='create')
    {
        // On a donc décidé de créer un kuchikomi
        // On doit recevoir les données suivantes :
        // id_commerce, heure_publication, mentions, texte, date_debut, date_fin
        // photo.

        // Il est nécessaire de vérifier certaines choses avant d'ajouter un kuchikomi.
        // 1° Toutes les données ont-elles été bien reçues ? Sont-elles valides ?
        // 2° Les dates sont-elles bien formatées ?
        // 3° La date de fin est-elle bien postérieure à la date de début ?
        // 4° La date de publication est-elle  bien antérieure à la date de fin ?
        // 5° La date de publication est-elle bien antérieure à la date de début ?

        // 1° Bonne réception des données ?

        if (isset($_POST['id_commerce']) AND isset($_POST['heure_publication']) AND isset($_POST['mentions']) AND isset($_POST['texte']) AND isset($_POST['date_debut']) AND isset($_POST['date_fin']) AND isset($_POST['photo']) AND isset ($_POST['photo_orientation']))
        {
        // 1°b Sont-elles valides ?
            $req = $bdd->prepare('SELECT id_commerce FROM commerce WHERE id_commerce = ?');
            $req->execute(array($_POST['id_commerce']));
            if ($req->fetch()==True)
            {
        // 2° Formatage des dates ? À faire !
//            if (1==1)
  //          {
        // 3° Date de fin postérieure à date_début ?
        // 4° Date_publication antérieure à date_fin ?
        // 5° Date_publication antérieure à date_début ?
                if ($_POST['date_fin'] >= $_POST['date_debut'] AND $_POST['heure_publication'] <= $_POST['date_debut'])
                {
                // Si on arrive ici, c'est que toutes les données sont valides.
                // 1 ° On commence par s'occuper de l'image, on la récupère, on tire un nom au hasard,
                //     on décode l'image et on écrit le résultat dans une image au nom tiré au sort avant.
                // 2° Formatqge de la date
                // 3° On ajoute toutes ces données dans la table kuchikomi.

                    // 1° Traitement de l'image.
                    $nom_image = md5(uniqid(rand(), true)) . '.jpeg';  // L'image sera toujours un jpeg.
                    $chemin_image = '../images/' . $nom_image;
                    $image_decodee = base64_decode($_POST['photo']);
                    $fp = fopen($chemin_image, 'wb');
                    fwrite($fp, $image_decodee);
                    fclose($fp);

                    $orien = $_POST['photo_orientation'];
                    $imagick = new Imagick();
                    $imagick->readImage($chemin_image);
                    $imagick->rotateImage(new ImagickPixel(), $orien);
                    $imagick->writeImage();


                    // 3° Ajout du kuchikomi dans la BDD.
                    $q = $bdd->prepare('INSERT INTO kuchikomi (id_commerce, mentions, texte, heure_publication, photo, date_debut, date_fin) VALUES(?, ?, ?, ?, ?, ?, ?)');
                    $q->execute(array($_POST['id_commerce'], $_POST['mentions'], $_POST['texte'], $_POST['heure_publication'], $nom_image, $_POST['date_debut'], $_POST['date_fin'] ));
                }
            }

        }
    }
    else if ($_GET['action']=='read')
    {

    }
    else if ($_GET['action']=='update')
    {

    }
    else if ($_GET['action']=='delete')
    {
    // On a simplement besoin d'un id.
    // Aucune vérifiacation d'autorisation n'est effectuée.
        $q = $bdd->prepare('DELETE FROM kuchikomi WHERE id_kuchikomi = ?');
        $q->execute(array($_GET['id']));
    }
}
?>
