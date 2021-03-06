<?php
include_once('../classes/Connexion.class.php');

function recupInfoCom($pseudo)
{
$bdd = Outils_Bd::getInstance()->getConnexion();
$_SESSION['nom_gerant'] = $pseudo;
$req = $bdd->prepare('SELECT id_gerant, id_commerce FROM gerant WHERE pseudo = ?');
$req->execute(array($pseudo));
$donnees=$req->fetch();
$_SESSION['id_gerant'] = $donnees['id_gerant'];
$_SESSION['id_commerce'] = $donnees['id_commerce'];
}


function calculStatistiques ()
	{
	// On récupère une instance de connexion.
	$bdd = Outils_Bd::getInstance()->getConnexion();
	// On souhaite récupérer le nombre d'abonnés du commerce en variable.
	$req = $bdd->prepare('SELECT COUNT(id_abonne) FROM abonnement WHERE id_commerce = ?');
	$req->execute(array($_SESSION['id_commerce']));
	$donnees = $req->fetch();
	$nb_abonnes = $donnees[0];

	/**************************************************************************************

	Les opérations ci-dessous permettent de préparer les données pour de futurs calculs
	de statistiques sur les kuchikomi en fonction de l'identifiant du commerçant.
	Pour afficher le tableau, décommentez print_r du compteur et les balises l'entourant.
	Il s'agit d'un array associatif avec l'identifiant du kuchikomi en clef et le nombre de jaime en valeurs.
	
	*//////////////////////////////////////////////////////////////////////////////////////
	
	// On commence par récupérer les id des kuchikomi du commerce.
	$req2 = $bdd->prepare('SELECT id_kuchikomi FROM kuchikomi WHERE id_commerce = ?');
	$req2->execute(array($_SESSION['id_commerce']));
	$compteur=[];
	while ($donnees2 = $req2->fetch())
		{
		// Pour chaque kuchikomi de ce commerce, on en compte le nombre dejaime.
		$req3 = $bdd->prepare('SELECT COUNT(id_abonne) FROM jaime WHERE id_kuchikomi= ? ');
		$req3->execute(array($donnees2['id_kuchikomi']));
		$donnees3 = $req3->fetch();
		$compteur[$donnees2['id_kuchikomi']] = $donnees3[0];
		}
		if (empty($compteur))
			{
			$compteur=array(0,0);
			}
		/**********************************************************************
		************** Fin de la préparation des données des kuchikomi /////////
		*//////////////////////////////////////////////////////////////////////
		
		
		/************** Sélection meilleur kuchikomi */////////////////////////
		
		// L'identifiant du meilleur kuchikomi.
		$clef_meilleur_kuchikomi = array_search(max($compteur), $compteur);
		
		// Récupération des donnes de ce meilleur kuchikomi
		$req4 = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_kuchikomi = ?');
		$req4->execute(array($clef_meilleur_kuchikomi));
		$donnees_meilleur_kk = $req4->fetch();
		if ($compteur==array(0,0))
			{
			$nb_de_kuchikomi = 0;
			}
		else
			{
			$nb_de_kuchikomi = sizeof($compteur);
			}
                $date_meilleur_kuchikomi = $donnees_meilleur_kk['heure_publication'];
		$nb_de_jaime_du_meilleur_kuchikomi = max($compteur);
		
		
		/**********************************************************************/
		
		/***********************************************************************
		******************** Progression des abonnements ***********************
		***********************************************************************/
		
		//Le nombre d'abonnés ces 30 derniers jours.
		$req5 = $bdd->prepare('SELECT COUNT(id_abonne) FROM abonnement
		WHERE id_commerce = ? AND TO_DAYS(NOW()) - TO_DAYS(date) <= 30;');
		$req5->execute(array($_SESSION['id_commerce']));
		$donnees5 = $req5->fetch();
		$nb_abonnes_30_jours = $donnees5[0];
		$nombre_abonnes_de_plus_de_30_jours=$nb_abonnes-$nb_abonnes_30_jours;
		if ($nombre_abonnes_de_plus_de_30_jours==0)
			{
			$augmentation_sur_le_mois=0;
			}
		else
			{
			$augmentation_sur_le_mois=($nb_abonnes_30_jours/$nombre_abonnes_de_plus_de_30_jours)*100;
			}
		$abonnes_des_30_derniers_jours = $donnees5[0];
		//var_dump($donnees5);
		/***********************************************************************/
		
		/************************************************************************
		/********************* Nombre total de j'aime **************************/
		/***********************************************************************/
		
		// La requête SQL ci-dessous compte tous les kuchikomi aimés.
		//Utilisation d'une sous-requête.
		$req7 = $bdd->prepare('SELECT COUNT(*) FROM jaime WHERE id_kuchikomi IN
		(SELECT id_kuchikomi FROM kuchikomi WHERE id_commerce = ?) ');
		$req7->execute(array($_SESSION['id_commerce']));
		$donnees7 = $req7->fetch();
		$nbre_total_de_jaime = $donnees7[0];
				
		
	return array ($nb_abonnes, $nb_de_kuchikomi, $clef_meilleur_kuchikomi,
	$date_meilleur_kuchikomi, $nb_de_jaime_du_meilleur_kuchikomi, $abonnes_des_30_derniers_jours,
	$nombre_abonnes_de_plus_de_30_jours, $augmentation_sur_le_mois, $nbre_total_de_jaime,
	$donnees_meilleur_kk) ;
	}

function listeKuchikomi($idcom)
{
// On récupère une instance de connexion.
$bdd = Outils_Bd::getInstance()->getConnexion();
// À présent, on veut afficher la liste des kuchikomi.
$req2 = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_commerce=?');
$req2->execute(array($idcom));
return $req2;
}


function ajoutkk()
{
include_once('../classes/Kuchikomi.class.php');
include_once('../classes/GestionKuchikomi.class.php');
if (isset($_FILES['photokk']) AND $_FILES['photokk']['error'] == 0)
// Si on reçoit un fichier, il faut s'en occuper.
	{
	// Testons si le fichier n'est pas trop gros
	if ($_FILES['photokk']['size'] <= 2000000)
		{
		// Testons si l'extension est autorisée
		$infosfichier = pathinfo($_FILES['photokk']['name']);
		//var_dump($infosfichier);
		$extension_recue = $infosfichier['extension'];
		$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
		if (in_array($extension_recue, $extensions_autorisees))
			{
			// On peut valider le fichier et le stocker définitivement
			$nom_image = md5(uniqid(rand(), true)) . '.' . $infosfichier['extension'];
			move_uploaded_file($_FILES['photokk']['tmp_name'], '../web/images/' . $nom_image);
			}
		else
			{
			$nom_image = 'logo_defaut.png';
			}
		}
	else
		{
		$nom_image = 'logo_defaut.png';
		}
	}
else
	{
	$nom_image = 'logo_defaut.png';
	}
// Création d'un onjet Kuchokomi.
$nouveau_kuchikomi = new Kuchikomi(array('id_commerce' => $_SESSION['id_commerce'],
'mentions' => $_POST['mentions'], 'texte' => $_POST['texte'], 'image' => $nom_image,
'date_debut' => $_POST['date_debut'], 'date_fin' => $_POST['date_fin'], 'date_publication' => $_POST['date_publi'] ));
// Instanciation du gestionnaire.
$ecriture_kk = new GestionKuchikomi(Outils_Bd::getInstance()->getConnexion());
$ecriture_kk->ajout($nouveau_kuchikomi);
header('Location: espmarc.php?appel=interface');
}


?>
