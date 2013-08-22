<?php
include_once('../../classes/Connexion.class.php');

$bdd = Outils_Bd::getInstance()->getConnexion();



if (isset($_GET['action']))
{
    if ($_GET['action']=='create')
    {
        // On a donc décidé de créer un kuchikomi
        // On doit recevoir les données suivantes :
        // id_commerce, heure_publication, mentions, texte, date_debut, date_fin
        // Ainsi qu'une image nommée photo.

        // Il est nécessaire de vérifier certaines choses avant d'ajouter un kuchikomi.
        // Les dates sont-elles bien formatées ?
        // La date de fin est-elle bien postérieure à la date de début ?
        // La date de publication est-elle  bien antérieure à la date de fin ?
        // La date de publication est-elle bien antérieure à la date de début ?
        //
/*
        if ($_POST[heure_publication]<$_POST['date_debut'] AND $_POST['date_debut']<$_POST['date_fin']) // On vérifie que les dates ne soient pas absurdes. Si tel est le cas, on ne fait rien.
        {
*/
            $q = $bdd->prepare('INSERT INTO kuchikomi (id_commerce, mentions, texte, date_debut, date_fin, heure_publication, photo) VALUES(?, ?, ?, ?, ?, ?, ?)');
            $q->execute(array($_POST['id_commerce'], $_POST['mentions'], $_POST['texte'], $_POST['date_debut'], $_POST['date_fin'], $_POST['heure_publication'], $_POST['photo'] ));
/*
        }
*/
/*
            $data = $_POST['logo'];

$monfichier = fopen('../images/compteur.txt', 'r+');
fputs($monfichier, $data);
fclose($monfichier);


           // $data = base64_decode($byte_array);
            $im = imagecreatefromstring($data);
            imagejpeg($im);
*/

/*
$data1 = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
       . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
       . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
       . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';

$data2 = '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';


            $data = base64_decode($data);


            $im = imagecreatefromstring($data);


            if ($im !== false)
            {
                header('Content-Type: image/png');
                imagepng($im);
                imagedestroy($im);
            }
            else
            {
                echo 'An error occurred.';
            }

        }
*/
/*
        if ($_POST[heure_publication]<$_POST['date_debut'] AND $_POST['date_debut']<$_POST['date_fin'])
        {
            $q = $this->_bdd->prepare('INSERT INTO kuchikomi (id_commerce, mentions, texte, date_debut, date_fin, heure_publication) VALUES(?, ?, ?, ?, ?, ?)');
            $q->execute(array($_POST['id_commerce']$_POST['mentions']$_POST['texte']$_POST['date_debut']$_POST['date_fin']$_POST['heure_publication'] ));
        }
*/
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
