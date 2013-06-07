<?php




function listeAbo($id_abonne)
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();			// On récupère une instance de connexion.
	$req = $bdd->prepare('SELECT id_commerce, nom FROM commerce WHERE id_commerce IN (SELECT id_commerce FROM abonnement WHERE id_abonne = ?)');//On récupère la liste des id_commerce dont on
	$req->execute(array($id_abonne));														// est abonné.
	$listeAbonnements=[];
	while ($donnees = $req->fetch())
		{
		$listeAbonnements[$donnees['id_commerce']] = $donnees['nom'];
		}
	return $listeAbonnements;
	}
	
	
	
	

function listekk($idcommerce)
	{
	$idcommerce = $idcommerce + 0;		// Pour convertir le string en int.
	if ($idcommerce==0)
		{
		return 'None';			// En cas de manipulation de l'url, ce qui n'est pas un entier sera ainsi désactivé.
		}
	else
		{
		$bdd = Outils_Bd::getInstance()->getConnexion();				// On récupère l'instance de connexion.
		$req = $bdd->prepare('SELECT id_kuchikomi, texte FROM kuchikomi WHERE id_commerce = ?');	// On récupère les aperçus 
		$req->execute(array($idcommerce));									// de chaque kuchikomi
		$listeKuchikomi=[];
		while ($donnees = $req->fetch())
			{
			$listeKuchikomi[$donnees['id_kuchikomi']] = $donnees['texte'];
			}
		return $listeKuchikomi;
		
		}
	
	}
	
	
	
function recuperationDonneesKk($idkk)
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();		// On récupère une instance du singleton de connexion.
	$req = $bdd->prepare('SELECT texte FROM kuchikomi WHERE id_kuchikomi = ?');		// On récupère les données nécessaires à 
	$req->execute(array($idkk));						// l'affichage du kuchilomi.
	$donnees = $req->fetch();
	return $donnees['texte'];
	}


function recupInfosCommercant($idcom)
	{
	$commercant_req=new GestionCommerce(Outils_Bd::getInstance()->getConnexion());	// On récupère l'instance de connexion
	$commercant=new commerce (($commercant_req->quereur($_GET['id'])));		// On créé un commerce que l'on hydrate avec les infos récupérées avec la méthode quéreur.
	$infosCommercant=[];
	
	$infosCommercant['nom'] = $commercant->nom();
	$infosCommercant['gerant'] = $commercant->gerant();
	$infosCommercant['horaires'] = $commercant->horaires();
	$infosCommercant['num_tel'] = $commercant->num_tel();
	$infosCommercant['email'] = $commercant->email();
	return $infosCommercant;
	}

function recupInfosCart($idcom)
	{
	$commercant_req=new GestionCommerce(Outils_Bd::getInstance()->getConnexion());		// On créé une instance de connexion avec la bdd.
	$commercant=new commerce (($commercant_req->quereur($_GET['id'])));				// Puis on créé un commerce qu'on hydrate grâce à la méthode quéreur.
	$infosCarto=[];
	$infosCarto['adresse'] = $commercant->adresse();
	$infosCarto['bus'] = $commercant->ligne_bus();
	$infosCarto['arret'] = $commercant->arret();
	return $infosCarto;
	}


function tentativeConnexion()
	{
	$nouveau_gerant= new Gerant(array('pseudo' => $_POST['pseudo'], 'mdp' => $_POST['pwd'] ));	//On créé un gérant.
	$connecte= new GestionGerant(Outils_Bd::getInstance()->getConnexion());				// On appelle le gestionnaire des gérants.
	$id_du_gerant=$connecte->existe($nouveau_gerant);
	if ($id_du_gerant==0)					// Échec de la vérification d'identité.
		{
		header('Location: espmarc.php');
		}
	else
		{
		$_SESSION['id']= $id_du_gerant;		// L'id de la session est égal à celui du gérant dans la base.
		$_SESSION['id_commerce']= $connecte->quelCommerce($id_du_gerant);
		$_SESSION['pseudo']= $_POST['pseudo'];
		$_SESSION['commerçant']=1;
		header('Location: espmarc.php');
		}
	}
			


function ajoutkk()
	{
	if (isset($_FILES['photokk']) AND $_FILES['photokk']['error'] == 0)	// Si on reçoit un fichier, il faut s'en occuper.
		{
		// Testons si le fichier n'est pas trop gros
		if ($_FILES['photokk']['size'] <= 1000000)
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
				move_uploaded_file($_FILES['photokk']['tmp_name'], 'uploads/' . $nom_image);
				}
			}
		}
	$nouveau_kuchikomi = new Kuchikomi(array('id_commerce' => $_SESSION['id_commerce'], 'mentions' => $_POST['mentions'], 'texte' => $_POST['texte'], 'image' => $nom_image, 'date_debut' => $_POST['date_debut'], 'date_fin' => $_POST['date_fin'] ));	// Création d'un onjet Kuchokomi.
	$ecriture_kk = new GestionKuchikomi(Outils_Bd::getInstance()->getConnexion());			// Instanciation du gestionnaire.
	$ecriture_kk->ajout($nouveau_kuchikomi);
	header('Location: espmarc.php?appel=interface');
	}


function calculStatistiques ()
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();			// On récupère une instance de connexion.
	$req = $bdd->prepare('SELECT COUNT(id_abonne) FROM abonnement WHERE id_commerce = ?');	// On souhaite récupérer le nombre d'abonnés du commerce en variable.
	$req->execute(array($_SESSION['id_commerce']));
	$donnees = $req->fetch();
	//var_dump($donnees);
	$nb_abonnes = $donnees[0];
	/**************************************************************************************
	
	Les opérations ci-dessous permettent de préparer les données pour de futurs calculs
	de statistiques sur les kuchikomi en fonction de l'identifiant du commerçant.
	Pour afficher le tableau, décommentez print_r du compteur et les balises l'entourant.
	Il s'agit d'un array associatif avec l'identifiant du kuchikomi en clef et le nombre de jaime en valeurs.
	
	*//////////////////////////////////////////////////////////////////////////////////////
	
	
	$req2 = $bdd->prepare('SELECT id_kuchikomi FROM kuchikomi WHERE id_commerce = ?');	// On commence par récupérer les id du kuchikomi du commerce.
	$req2->execute(array($_SESSION['id_commerce']));
	$compteur=[];
	while ($donnees2 = $req2->fetch())
		{
		//var_dump($donnees2);
		$req3 = $bdd->prepare('SELECT COUNT(id_abonne) FROM jaime WHERE id_kuchikomi= ? ');
		$req3->execute(array($donnees2['id_kuchikomi']));
		$donnees3 = $req3->fetch();
		//var_dump($donnees3);
		$compteur[$donnees2['id_kuchikomi']] = $donnees3[0];
		}
		/*
		echo '<pre>';
		print_r($compteur);
		echo '</pre>';
		*/
		/**********************************************************************
		************** Fin de la préparation des données des kuchikomi /////////
		*//////////////////////////////////////////////////////////////////////
		
		/************** Sélection meilleur kuchikomi */////////////////////////
		
		$clef_meilleur_kuchikomi = array_search(max($compteur), $compteur);			// L'identifiant du meilleur kuchikomi.
		
		$req4 = $bdd->prepare('SELECT date_debut FROM kuchikomi WHERE id_kuchikomi = ?');	// Récupération de la date de début du meilleur kuchikomi.
		$req4->execute(array($clef_meilleur_kuchikomi));
		$donnees4 = $req4->fetch();
		$nb_de_kuchikomi = sizeof($compteur);
		$date_meilleur_kuchikomi = $donnees4[0];
		$nb_de_jaime_du_meilleur_kuchikomi = max($compteur);
		//var_dump($donnees4);
		
		/**********************************************************************/
		
		/***********************************************************************
		******************** Progression des abonnements ***********************
		***********************************************************************/
		
		$req5 = $bdd->prepare('SELECT COUNT(id_abonne) FROM abonnement WHERE id_commerce = ? AND TO_DAYS(NOW()) - TO_DAYS(date) <= 30;');	//Le nombre d'abonnés ces 30 derniers jours.
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
		
		// La requête SQL ci-dessous compte tous les kuchikomi aimés. Utilisation d'une sous-requête.
		$req7 = $bdd->prepare('SELECT COUNT(*) FROM jaime WHERE id_kuchikomi IN (SELECT id_kuchikomi FROM kuchikomi WHERE id_commerce = ?) ');
		$req7->execute(array($_SESSION['id_commerce']));
		$donnees7 = $req7->fetch();
		$nbre_total_de_jaime = $donnees7[0];
				
		
	return array ($nb_abonnes, $nb_de_kuchikomi, $clef_meilleur_kuchikomi, $date_meilleur_kuchikomi, $nb_de_jaime_du_meilleur_kuchikomi, $abonnes_des_30_derniers_jours, $nombre_abonnes_de_plus_de_30_jours, $augmentation_sur_le_mois, $nbre_total_de_jaime) ;
	}

















?>