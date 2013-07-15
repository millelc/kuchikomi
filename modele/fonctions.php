<?php
function inscription()
{
include_once('../classes/Abonne.class.php');
include_once('../classes/GestionAbonne.class.php');
$pseudo = creerPseudo();
$adresse_ip = $_SERVER['REMOTE_ADDR'];
$nouvel_inscrit= new Abonne(array('pseudo' => $pseudo, 'adresse_ip' => $adresse_ip));
$inscription= new GestionAbonne(Outils_Bd::getInstance()->getConnexion());
$inscription->ajout($nouvel_inscrit);
return $pseudo;
}

function creerPseudo()
{
// L'identifiant doit être d'une taille aléatoire, soit entre 15 et 25 caractères.
// Et il ne doit contenir que les 62 caractères suivants :
$carac = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$pseudo = '';
//Une fois la taille tirée au sort, on pioche pour chaque lettre une lettre au hasard
// de la liste $carac pour former le mot final.
for ($nombre_de_carac = rand(15,25); $nombre_de_carac != 0; $nombre_de_carac--)
  {
  $pseudo = $pseudo . $carac[rand(0,61)];
  }
return $pseudo;
}

function recupId($pseudo)
{
include_once('../classes/Abonne.class.php');
include_once('../classes/GestionAbonne.class.php');
$abonne = new Abonne(array('pseudo' => $pseudo));
$gestionabo = new GestionAbonne(Outils_Bd::getInstance()->getConnexion());
$id_abo = $gestionabo->recupIdentifiant($abonne);
return $id_abo;
}


function sAbonner ($id_abo, $id_com)
{
include_once('../classes/Abonnement.class.php');
include_once('../classes/GestionAbonnement.class.php');
$abo = new Abonnement(array('id_abonne' => $id_abo, 'id_commerce' => $id_com));
$gestAbo = new GestionAbonnement(Outils_Bd::getInstance()->getConnexion());
$gestAbo->ajout($abo);
}

function listeAbo($id_abo)
{
include_once('../classes/GestionAbonnement.class.php');
// On récupère une instance de connexion.
$bdd = Outils_Bd::getInstance()->getConnexion();
//On récupère la liste des id_commerce dont on est abonné.
$req = $bdd->prepare('SELECT id_commerce, logo FROM commerce 
WHERE id_commerce IN (SELECT id_commerce FROM abonnement WHERE id_abonne = ?)');
$req->execute(array($id_abo));
$listeAbonnements=[];
$listeNbreKkValides=[];
$now = date("Y-m-d");
while ($donnees = $req->fetch())
  {
  $listeAbonnements[$donnees['id_commerce']] = $donnees['logo'];
  }
foreach($listeAbonnements as $cle => $valeur)
  {
  // On récupère une instance de connexion.
  $bdd = Outils_Bd::getInstance()->getConnexion();			
  $req = $bdd->prepare("SELECT count(id_kuchikomi) FROM kuchikomi
  WHERE id_commerce = ? AND date_fin > ?");
  $req->execute(array($cle, $now));
  $donnees2 = $req->fetch();
  $listeNbreKkValides[$cle] = $donnees2[0];
  }
return array($listeAbonnements, $listeNbreKkValides);
}


function listeDesDerniersKkConfondus($idabo)
{
//Cette fonction renvoie les 10 derniers kuchikomi d'un abonné (tous ses abonnements confondus)
$bdd = Outils_Bd::getInstance()->getConnexion();
$req = $bdd->prepare('SELECT * FROM kuchikomi WHERE heure_publication<NOW() AND id_commerce IN
(SELECT id_commerce FROM abonnement WHERE id_abonne = ?) ORDER BY heure_ecriture DESC LIMIT 0,10');
$req->execute(array($idabo));
return $req;
}
	
function recuplogo($idcom)
{
$bdd = Outils_Bd::getInstance()->getConnexion();
$req = $bdd->prepare('SELECT logo FROM commerce WHERE id_commerce = ?');
$req->execute(array($idcom));
$donnees = $req->fetch();
echo '<img src="images/' . $donnees['logo'] . '"alt="Logo commerce" title="Logo commerce"
style="width: 75px; margin-left: 20px; margin-top:10px; border: 1px black outset;" />';
}


function listekk($idcommerce)
{
// Pour convertir le string en int.
$idcommerce = $idcommerce + 0;
if ($idcommerce==0)
{
// En cas de manipulation de l'url,
// ce qui n'est pas un entier sera ainsi désactivé.
  return 'None';
}
else
{
  // On récupère l'instance de connexion.
  $bdd = Outils_Bd::getInstance()->getConnexion();				
  // On récupère les aperçus 
  $req = $bdd->prepare('SELECT * FROM kuchikomi 
  WHERE id_commerce = ? ORDER BY date_fin DESC LIMIT 0,10');
  // de chaque kuchikomi
  $req->execute(array($idcommerce));
  return $req;
  }
}
	
function recuperationDonneesKk($idkk)
{
// On récupère une instance du singleton de connexion.
$bdd = Outils_Bd::getInstance()->getConnexion();
// On récupère les données nécessaires à l'affichage du kuchikomi.
$req = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_kuchikomi = ?'); 
$req->execute(array($idkk));
$donnees = $req->fetch();
return array($donnees['texte'], $donnees['id_commerce'],
$donnees['mentions'], $donnees['date_debut'], $donnees['date_fin'], $donnees['photo']);
}


function recupInfosCommercant($idcom)
{
include_once('../classes/Commerce.class.php');
include_once('../classes/GestionCommerce.class.php');
// On récupère l'instance de connexion
$commercant_req=new GestionCommerce(Outils_Bd::getInstance()->getConnexion());
// On créé un commerce que l'on hydrate avec les infos récupérées avec la méthode quéreur.
$commercant=new commerce (($commercant_req->quereur($_GET['id'])));
$infosCommercant=[];
$infosCommercant['nom'] = $commercant->nom();
$infosCommercant['gerant'] = $commercant->gerant();
$infosCommercant['horaires'] = $commercant->horaires();
$infosCommercant['num_tel'] = $commercant->num_tel();
$infosCommercant['email'] = $commercant->email();
return $infosCommercant;
}


function seDesabonner ()
{
include_once('../classes/Abonnement.class.php');
include_once('../classes/GestionAbonnement.class.php');
//On créé un nouvel abonnement
$abo_a_suppr= new Abonnement(array('id_commerce' => $_GET['id'], 'id_abonne' => $_SESSION['id_abonne'] ));
// On créé un objet gérant les abonnements
$desinscription= new GestionAbonnement(Outils_Bd::getInstance()->getConnexion());
// True signifie que l'abonnement n'existe pas.
if ($desinscription->dejaAbonne($abo_a_suppr)!=True)
  {
  // L'abonnement existe, on peut alors le supprimer.
  $desinscription->suppr($abo_a_suppr);
  }
header('Location: index.php?appel=liste&id=none');
}

function aimer ()
{
include_once('../classes/Jaime.class.php');
include_once('../classes/GestionJaime.class.php');
// Création d'un objet « Jaime ».
$nouveau_jaime= new Jaime (array('id_abonne' => $_SESSION['id_abonne'], 'id_kuchikomi' => $_GET['id'] ));
// On ajoute le jaime à la table si il est nouveau.
$jaime_ajout = new GestionJaime (Outils_Bd::getInstance()->getConnexion());
$jaime_ajout->ajout($nouveau_jaime);
}


function recupBandeau()
{
$ofic = fopen('../bandeau', 'r');
// On lit la première ligne.
$nom_image = fgets($ofic);
fclose($ofic);
return $nom_image;
}










?>