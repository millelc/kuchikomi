<?php
session_start();

include_once('../modele/fonctions.php');

if (isset($_GET['appel']) AND isset($_GET['id']))
{
  if(!isset($_COOKIE['pseudo']))
    // Il n'y a donc pas de cookies, c'est un nouvel inscrit.
    {
    $pseudo = inscription();
    setcookie('pseudo', $pseudo, time() + 5*365*24*3600, null, null, false, true);
    header('Location: index.php?appel=' . $_GET['appel'] . '&id=' . $_GET['id'] . '');
    // Les deux booléens ci-dessus sont pour améliorer la sécurité.
    // Le premier interdit l'usage de cookies lors des connexions non SSL si true (ici false donc accepte sans ssl)
    // Le second interdit l'usage de cookies pour des requêtes non HTTP.
    }

  else
    {
    $_SESSION['pseudo']= $_COOKIE['pseudo'];
    $_SESSION['id_abonne']= recupId($_SESSION['pseudo']);

    switch ($_GET['appel'])
        {
        // Dans le cas où la déconnexion aurait été choisie
        case 'abo':
            sAbonner($_SESSION['id_abonne'], $_GET['id']);
            header('Location: index.php?appel=liste&id=none');
            break;
        case 'liste' :
            if ($_GET['id']=='none')
              {
              // Cette position est la page d'accueil listant les abonnements.
              $donnees = listeAbo($_SESSION['id_abonne']);
              $listeAbo = $donnees[0];
              $listeKkActifs = $donnees[1];
              $derniersKKConfondus = listeDesDerniersKkConfondus($_SESSION['id_abonne']);
              include_once('../vues/listeabo.php');
              }
            else
              {
              // Ici, on souhaite afficher les kuchikomi spécifiques d'un commerce.
              $listeKuchikomi=listekk($_GET['id']);
              $_SESSION['commerce_consulte']=$_GET['id'];
              include_once('../vues/listemag.php');
              }
            break;
        case 'kk':
            $kuchikomi=recuperationDonneesKk($_GET['id']);
            include_once('../vues/affichagekk.php');
            break;
        case 'contact':
            $infoscontacts = recupInfosCommercant($_GET['id']);
            include_once('../vues/contacts.php');
            break;
        case 'desabo':
            seDesabonner();
            break;
        case 'jaime':
            aimer ();
            break;
        default :
            header('Location: index.php?appel=liste&id=none');
            break;
        }
    }
}

else
{
header('Location: index.php?appel=liste&id=none');
}
?>
 
