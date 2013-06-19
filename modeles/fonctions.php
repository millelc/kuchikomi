<?php




function listeAbo($id_abonne)
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();			// On récupère une instance de connexion.
	$req = $bdd->prepare('SELECT id_commerce, logo FROM commerce WHERE id_commerce IN (SELECT id_commerce FROM abonnement WHERE id_abonne = ?)');//On récupère la liste des id_commerce dont on
	$req->execute(array($id_abonne));														// est abonné.
	$listeAbonnements=[];
	$listeNbreKkValides=[];
	$now = date("Y-m-d");
	while ($donnees = $req->fetch())
		{
		$listeAbonnements[$donnees['id_commerce']] = $donnees['logo'];
		}
	foreach($listeAbonnements as $cle => $valeur)
		{
		$bdd = Outils_Bd::getInstance()->getConnexion();			// On récupère une instance de connexion.
		$req = $bdd->prepare("SELECT count(id_kuchikomi) FROM kuchikomi WHERE id_commerce = ? AND date_fin > ?");
		$req->execute(array($cle, $now));
		$donnees2 = $req->fetch();
		//var_dump($donnees2);
		$listeNbreKkValides[$cle] = $donnees2[0];
		}
	return array($listeAbonnements, $listeNbreKkValides);
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
		$req = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_commerce = ? ORDER BY date_fin DESC LIMIT 0,10');	// On récupère les aperçus 
		$req->execute(array($idcommerce));									// de chaque kuchikomi
		return $req;
		}
	
	}
	
	
	
function recuperationDonneesKk($idkk)
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();		// On récupère une instance du singleton de connexion.
	$req = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_kuchikomi = ?');		// On récupère les données nécessaires à 
	$req->execute(array($idkk));						// l'affichage du kuchikomi.
	$donnees = $req->fetch();
	return array($donnees['texte'], $donnees['id_commerce'], $donnees['mentions'], $donnees['date_debut'], $donnees['date_fin'], $donnees['photo']);
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
				move_uploaded_file($_FILES['photokk']['tmp_name'], 'uploads/' . $nom_image);
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
	
	
	$req2 = $bdd->prepare('SELECT id_kuchikomi FROM kuchikomi WHERE id_commerce = ?');	// On commence par récupérer les id des kuchikomi du commerce.
	$req2->execute(array($_SESSION['id_commerce']));
	$compteur=[];
	while ($donnees2 = $req2->fetch())
		{
		//var_dump($donnees2);
		$req3 = $bdd->prepare('SELECT COUNT(id_abonne) FROM jaime WHERE id_kuchikomi= ? ');	// Pour chaque kuchikomi de ce commerce, on en compte le nombre dejaime.
		$req3->execute(array($donnees2['id_kuchikomi']));
		$donnees3 = $req3->fetch();
		//var_dump($donnees3);
		$compteur[$donnees2['id_kuchikomi']] = $donnees3[0];
		}
		if (empty($compteur))
			{
			$compteur=array(0,0);
			}
		/*echo '<pre>';
		print_r($compteur);
		echo '</pre>';
		*/
		/**********************************************************************
		************** Fin de la préparation des données des kuchikomi /////////
		*//////////////////////////////////////////////////////////////////////
		
		/************** Sélection meilleur kuchikomi */////////////////////////
		
		$clef_meilleur_kuchikomi = array_search(max($compteur), $compteur);			// L'identifiant du meilleur kuchikomi.
		
		$req4 = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_kuchikomi = ?');	// Récupération des donnes de ce meilleur kuchikomi
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
		$date_meilleur_kuchikomi = $donnees_meilleur_kk[0];
		$nb_de_jaime_du_meilleur_kuchikomi = max($compteur);
		
		
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
				
		
	return array ($nb_abonnes, $nb_de_kuchikomi, $clef_meilleur_kuchikomi, $date_meilleur_kuchikomi, $nb_de_jaime_du_meilleur_kuchikomi, $abonnes_des_30_derniers_jours, $nombre_abonnes_de_plus_de_30_jours, $augmentation_sur_le_mois, $nbre_total_de_jaime, $donnees_meilleur_kk) ;
	}





function sAbonner ()
	{
	echo 'test';
	$nouvel_abo= new Abonnement(array('id_commerce' => $_GET['id'], 'id_abonne' => $_SESSION['id'] ));	// On créé un nouvel abonnement
	$connexion = Outils_Bd::getInstance()->getConnexion();						// Puis on instancie une connexion
	$inscription= new GestionAbonnement($connexion);						// Dont on se servira pour l'objet inscription
	$inscription->commerceExistant($nouvel_abo);						// On vérifie que le commerce existe
				
	if ($inscription->commerceExistant($nouvel_abo)==True)				// Le commerce existe bel et bien.
		{
		if ($inscription->dejaAbonne($nouvel_abo)==True)			// NB : Si dejaAbonne renvoie True, c'est qu'on est pas abonné.
			{
			$inscription->ajout($nouvel_abo);				// Si pas encore abonné, on le devient.
			}
		}
	}


function seDesabonner ()
	{
	$abo_a_suppr= new Abonnement(array('id_commerce' => $_GET['id'], 'id_abonne' => $_SESSION['id'] )); //On créé un nouvel abonnement
	$connexion = Outils_Bd::getInstance()->getConnexion();					// On appelle l'instance de connexion
	$desinscription= new GestionAbonnement($connexion);				// On créé un objet gérant les abonnements
	if ($desinscription->dejaAbonne($abo_a_suppr)==True)				// True signifie que l'abonnement n'existe pas.
		{
		echo 'Cet abonnement n\'existe pas.';					// Ceci pour empêcher un désabonnement n'existant pas
		}
	else
		{
		$desinscription->suppr($abo_a_suppr);					// L'abonnement existe, on peut alors le supprimer.
		}
	header('Location: index.php?appel=liste&id=none');
	}

function desinscription ()
	{
	$desinscription = new GestionAbonne(Outils_Bd::getInstance()->getConnexion());		// Création de l'objet.
	$desinscription->desinscription($_SESSION['id']);					// Désactivation de l'utilisateur.
	$desabonnements = new GestionAbonnement(Outils_Bd::getInstance()->getConnexion());	// Création de l'objet.
	$desabonnements ->supprtotale($_SESSION['id']);						// Suppression de tous les abonnements.
	session_destroy();
	header('Location: index.php?appel=liste&id=none');
	}


function aimer ()
	{
	$nouveau_jaime= new Jaime (array('id_abonne' => $_SESSION['id'], 'id_kuchikomi' => $_GET['id'] ));	// Création d'un objet « Jaime ».
	$jaime_ajout = new GestionJaime (Outils_Bd::getInstance()->getConnexion());	// On ajoute le jaime à la table si il est nouveau.
	$jaime_ajout->ajout($nouveau_jaime);
	}

function connexion ()
	{
	echo "<br />Vous avez choisi de vous connecter.";
	$nouveau_connecte= new Abonne(array('pseudo' => $_POST['id']));	//On créé un abonné.
	$connexion = Outils_Bd::getInstance()->getConnexion();					// On prépare l'accès à la bdd.
	$connecte= new GestionAbonne($connexion);							// On appelle le gestionnaire des abonnés
	if ($connecte->dejaInscrit($nouveau_connecte)==0 OR $connecte->dejaInscrit($nouveau_connecte)==2)		// Le pseudo est-il le bon ?
		{
		// Le pseudo n'existe pas. On renvoie.
		header('Location: index.php?appel=liste&id=none');
		}
	else
		{
		$req = $connexion->prepare('SELECT * FROM abonne WHERE id_abonne = ?');
		$req->execute(array($connecte->dejaInscrit($nouveau_connecte)));
		$donnees = $req->fetch();
		$_SESSION['connexion']=1;
		$_SESSION['pseudo']=$donnees['pseudo'];
		$_SESSION['id']= $donnees['id_abonne'];
		$_SESSION['adresse_ip']= $donnees['adresse_ip'];
		header('Location: index.php?appel=liste&id=none');
		
		}
			
	}
	
	
function inscription ()
	{
	$nouvel_inscrit= new Abonne(array('pseudo' => $_POST['id']));	// On créé un nouvel abonné avec ce pseudo et ce mdp.
	$inscription= new GestionAbonne(Outils_Bd::getInstance()->getConnexion());						// On prépare le gestionnaire d'abonnés
	if ($inscription->dejaInscrit($nouvel_inscrit)==0 OR $inscription->dejaInscrit($nouvel_inscrit)==2 )// On vérifie que ce pseudo n'est pas déjà utilisé. Si il l'est déjà, rien ne se passe.
		{
		$_SESSION['id']= $inscription->ajout($nouvel_inscrit);		// Le pseudo est libre, le gestionnaire l'ajoute à la table.
		$_SESSION['connexion']=1;
		$_SESSION['pseudo']= $_POST['id'];
		}
	header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
	}
	
	
	
################################# Interface admin ##########################################################


function ajouterCommerce()
	{
	if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)	// Si on reçoit un fichier, il faut s'en occuper.
		{
		// Testons si le fichier n'est pas trop gros
		if ($_FILES['photo']['size'] <= 1000000)
			{
			// Testons si l'extension est autorisée
			$infosfichier = pathinfo($_FILES['photo']['name']);
			//var_dump($infosfichier);
			$extension_recue = $infosfichier['extension'];
			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
			if (in_array($extension_recue, $extensions_autorisees))
				{
				// On peut valider le fichier et le stocker définitivement
				$nom_photo = md5(uniqid(rand(), true)) . '.' . $infosfichier['extension'];
				move_uploaded_file($_FILES['photo']['tmp_name'], 'images_com/' . $nom_photo);
				}
			}
		}
	else
		{
		$nom_photo = "image_defaut.png";
		}
	
	
	if (isset($_FILES['logo']) AND $_FILES['logo']['error'] == 0)	// Si on reçoit un fichier, il faut s'en occuper.
		{
		// Testons si le fichier n'est pas trop gros
		if ($_FILES['logo']['size'] <= 1000000)
			{
			// Testons si l'extension est autorisée
			$infosfichier = pathinfo($_FILES['logo']['name']);
			//var_dump($infosfichier);
			$extension_recue = $infosfichier['extension'];
			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
			if (in_array($extension_recue, $extensions_autorisees))
				{
				// On peut valider le fichier et le stocker définitivement
				$nom_logo = md5(uniqid(rand(), true)) . '.' . $infosfichier['extension'];
				move_uploaded_file($_FILES['logo']['tmp_name'], 'images_com/' . $nom_logo);
				}
			}
		}
	else
		{
		$nom_logo = "logo_defaut.png";
		}
	$donnees=[];
	$donnees['nom']= $_POST['nom_com'];
	$donnees['gerant']= $_POST['nom_gerant'];
	$donnees['logo']= $nom_logo;
	$donnees['image']= $nom_photo;
	$donnees['horaires']= $_POST['horaires'];
	$donnees['num_tel']= $_POST['num_tel'];
	$donnees['email']= $_POST['email'];
	$donnees['adresse']= $_POST['adresse'];
	$donnees['ligne_bus']= $_POST['ligne_bus'];
	$donnees['arret']= $_POST['arret'];
	//var_dump($donnees);
	
	// Le plus dur est fait, les deux images, si elles existent, ont été envoyées, stockées et leurs noms normalisés.
	// À présent, on se retrouve avec un tableau de données contenant des données suffisantes pour créer des objets Commerce et Gérant et les ajouter à la bdd.
	
	// Création du commerce
	$nouveau_commerce= new Commerce ($donnees);
	$ajout_commerce= new GestionCommerce(Outils_Bd::getInstance()->getConnexion());
	$id_du_dernier_commerce_ajoute = $ajout_commerce -> ajout($nouveau_commerce);
	
	// Et création de son gérant
	
	$donnees2=[];
	$donnees2['pseudo']= $_POST['nom_gerant'];
	$donnees2['mdp']= $_POST['mdp'];
	$donnees2['idcom']= $id_du_dernier_commerce_ajoute;
	
	$nouveau_gerant= new Gerant ($donnees2);
	$ajout_gerant= new GestionGerant(Outils_Bd::getInstance()->getConnexion());
	$ajout_gerant -> ajout($nouveau_gerant);
	
	
	header('Location: admin.php');
	}
	
	
	
function modifierCommerce()
	{
	if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)	// Si on reçoit un fichier, il faut s'en occuper.
		{
		// Testons si le fichier n'est pas trop gros
		if ($_FILES['photo']['size'] <= 1000000)
			{
			// Testons si l'extension est autorisée
			$infosfichier = pathinfo($_FILES['photo']['name']);
			//var_dump($infosfichier);
			$extension_recue = $infosfichier['extension'];
			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
			if (in_array($extension_recue, $extensions_autorisees))
				{
				// On peut valider le fichier et le stocker définitivement
				$nom_photo = md5(uniqid(rand(), true)) . '.' . $infosfichier['extension'];
				move_uploaded_file($_FILES['photo']['tmp_name'], 'images_com/' . $nom_photo);
				}
			}
		}
	else
		{
		$nom_photo = $_GET['p'];
		}
	
	
	if (isset($_FILES['logo']) AND $_FILES['logo']['error'] == 0)	// Si on reçoit un fichier, il faut s'en occuper.
		{
		// Testons si le fichier n'est pas trop gros
		if ($_FILES['logo']['size'] <= 1000000)
			{
			// Testons si l'extension est autorisée
			$infosfichier = pathinfo($_FILES['logo']['name']);
			//var_dump($infosfichier);
			$extension_recue = $infosfichier['extension'];
			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
			if (in_array($extension_recue, $extensions_autorisees))
				{
				// On peut valider le fichier et le stocker définitivement
				$nom_logo = md5(uniqid(rand(), true)) . '.' . $infosfichier['extension'];
				move_uploaded_file($_FILES['logo']['tmp_name'], 'images_com/' . $nom_logo);
				}
			}
		}
	else
		{
		$nom_logo = $_GET['l'];
		}
	/*
	echo $nom_logo;
	echo '<br />';
	echo $nom_photo;
	echo '<br />';
	*/
	$donnees=[];
	$donnees['id_commerce']= $_POST['idcom'];
	$donnees['nom']= $_POST['nom_com'];
	$donnees['gerant']= $_POST['nom_gerant'];
	$donnees['logo']= $nom_logo;
	$donnees['image']= $nom_photo;
	$donnees['horaires']= $_POST['horaires'];
	$donnees['num_tel']= $_POST['num_tel'];
	$donnees['email']= $_POST['email'];
	$donnees['adresse']= $_POST['adresse'];
	$donnees['ligne_bus']= $_POST['ligne_bus'];
	$donnees['arret']= $_POST['arret'];
	//var_dump($donnees);
	
	// Le plus dur est fait, les deux images, si elles existent, ont été envoyées, stockées et leurs noms normalisés.
	// À présent, on se retrouve avec un tableau de données contenant des données suffisantes pour créer des objets Commerce et Gérant et les ajouter à la bdd.
	
	// Création du commerce
	$nouveau_commerce= new Commerce ($donnees);
	$modif_commerce= new GestionCommerce(Outils_Bd::getInstance()->getConnexion());
	//var_dump($nouveau_commerce);
	$id_du_dernier_commerce_modifie = $modif_commerce -> modif($nouveau_commerce);
	
	// Et création de son gérant
	
	$donnees2=[];
	$donnees2['pseudo']= $_POST['nom_gerant'];
	$donnees2['mdp']= $_POST['mdp'];
	$donnees2['idcom']= $_POST['idcom'];
	
	$nouveau_gerant= new Gerant ($donnees2);
	var_dump($donnees2);
	echo '<br />';
	//var_dump($nouveau_gerant);
	
	// Que l'on modifie également.
	$modif_gerant= new GestionGerant(Outils_Bd::getInstance()->getConnexion());
	$modif_gerant -> modif($nouveau_gerant);
	
	header('Location: admin.php');
	}
	
	
function supprimerCommerce($idcom)
	{
	$bdd=Outils_Bd::getInstance()->getConnexion();
	// On supprime le gérant ainsi que le commerce correspondants
	
	$req = $bdd->prepare('DELETE FROM gerant WHERE id_commerce= ?');
	$req->execute(array($idcom));
	
	$req2 = $bdd->prepare('DELETE FROM commerce WHERE id_commerce= ?');
	$req2->execute(array($idcom));
	
	header('Location: admin.php');
	}
	
function modifierBandeau()
	{
	if (isset($_FILES['bandeau']) AND $_FILES['bandeau']['error'] == 0)	// Si on reçoit un fichier, il faut s'en occuper.
		{
		// Testons si le fichier n'est pas trop gros
		if ($_FILES['bandeau']['size'] <= 1000000)
			{
			// Testons si l'extension est autorisée
			$infosfichier = pathinfo($_FILES['bandeau']['name']);
			//var_dump($infosfichier);
			$extension_recue = $infosfichier['extension'];
			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
			if (in_array($extension_recue, $extensions_autorisees))
				{
				// On peut valider le fichier et le stocker définitivement
				$nom_bandeau = md5(uniqid(rand(), true)) . '.' . $infosfichier['extension'];
				move_uploaded_file($_FILES['bandeau']['tmp_name'], '../web/uploads/' . $nom_bandeau);
				}
			}
		}
	$ofic = fopen('../includes/bandeau', 'r+');
	fseek($ofic, 0); // On remet le curseur au début du fichier
	fputs($ofic, $nom_bandeau); // On écrit le nom de la nouvelle image
	fclose($ofic);
	echo '<p>L\'image de bandeau est désormais ' . $nom_bandeau . '.</p>';
	}

	
function recupBandeau()
	{
	$ofic = fopen('../includes/bandeau', 'r');
	$nom_image = fgets($ofic); // On lit la première ligne.
	fclose($ofic);
	return $nom_image;
	}
	
function recupererStats()
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();			// On récupère une instance de connexion.
	$req = $bdd->prepare('SELECT COUNT(*) FROM commerce');	// On souhaite récupérer le nombre de commerçants.
	$req->execute(array());
	$donnees = $req->fetch();
	echo '<p>Il y a ' . $donnees[0] . ' commerçants inscrits.</p>';
	
	$req2 = $bdd->prepare('SELECT COUNT(*) FROM abonne');	// On souhaite récupérer le nombre de commerçants.
	$req2->execute(array());
	$donnees2 = $req2->fetch();
	echo '<p>Il y a ' . $donnees2[0] . ' utilisateurs inscrits.</p>';
	
	$req3 = $bdd->prepare('SELECT COUNT(*) FROM abonnement');	// On souhaite récupérer le nombre de commerçants.
	$req3->execute(array());
	$donnees3 = $req3->fetch();
	echo '<p>Il y a ' . $donnees3[0] . ' abonnements.</p>';
	
	$req4 = $bdd->prepare('SELECT COUNT(*) FROM jaime');	// On souhaite récupérer le nombre de commerçants.
	$req4->execute(array());
	$donnees4 = $req4->fetch();
	echo '<p>Il y a ' . $donnees4[0] . ' « J\'aime ! ».</p>';
		
	$req5 = $bdd->prepare('SELECT COUNT(*) FROM kuchikomi');	// On souhaite récupérer le nombre de commerçants.
	$req5->execute(array());
	$donnees5 = $req5->fetch();
	echo '<p>Il y a ' . $donnees5[0] . ' kuchikomi écrits..</p>';
	}
	
	
function listeKuchikomi($idcom)
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();			// On récupère une instance de connexion.
	
	
	$req2 = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_commerce=?');	// À présent, on veut afficher la liste des kuchikomi.
	$req2->execute(array($idcom));
	return $req2;
	}

function listeDesDerniersKkConfondus($idabo)		//Cette fonction renvoie les 10 derniers kuchikomi d'un abonné (tous ses abonnements confondus)
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();			// On récupère une instance de connexion.
	$req = $bdd->prepare('SELECT * FROM kuchikomi WHERE id_commerce IN (SELECT id_commerce FROM abonnement WHERE id_abonne = ?) ORDER BY date_fin DESC LIMIT 0,10');
	$req->execute(array($idabo));
	return $req;
	}
	

function recuplogo($idcom)
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();			// On récupère une instance de connexion.
	$req = $bdd->prepare('SELECT logo FROM commerce WHERE id_commerce = ?');
	$req->execute(array($idcom));
	$donnees = $req->fetch();
	echo '<img src="../org/images_com/' . $donnees['logo'] . '" alt="Logo commerce" title="Logo commerce" style="width: 75px; margin-left: 20px; margin-top:10px; border: 1px black outset;" />';
	}
	
function scan($id_ab, $adresse_ip)
	{
	// Un tag NFC a été lu, il faut :
	// 1° Vérifier si l'utilisateur existe.
	// 2° Si l'utilisateur n'existe pas, on le créé et on l'abonne (si il ne l'est pas déjà).
	// 3° Si l'utilisateur existe, on l'abonne (si il ne l'est pas déjà).
	
	/*     /!\/!\/!\/!\/!\ L'utilisation d'objets semble ralentir TRÈS FORTEMENT l'application côté smartphone lors du POST à part... /!\/!\/!\/!\/!\/!\   */
	
	$bdd = Outils_Bd::getInstance()->getConnexion();
	//////////////////   1°  /////////////////////////////
	$req = $bdd->prepare('SELECT * FROM abonne WHERE pseudo = ?');
	$req->execute(array($id_ab));
	$donnees = $req->fetch();
	if ($donnees['id_abonne']=='')				// Cet abonné n'existe  pas.
		{
	//////////////////   2° //////////////////////////////
		/*   Création de l'utilisateur     */
		$req2 = $bdd->prepare('INSERT INTO abonne (pseudo, adresse_ip) VALUES(?, ?)');
		$req2->execute(array($id_ab, $adresse_ip));
		$id_abonne = $bdd->lastInsertId();
		/* Abonnement de cet utilisateur si il ne l'est pas déjà    */
		abonnementApresScan($id_abonne, $_GET['id']);
		}
	else
		{
	//////////////////   3°   ////////////////////////////
		$id_abonne = $donnees['id_abonne'];
		// Comme l'utilisateur existe, on met à jour sobn adresse ip car elle aura sans doute changé d'ici là.
		$req3 = $bdd->prepare('UPDATE abonne SET adresse_ip = ? WHERE pseudo = ?');
		$req3->execute(array($donnees['adresse_ip'], $donnees['pseudo']));
		/* Abonnement de cet utilisateur si il ne l'est pas déjà.   */
		abonnementApresScan($id_abonne, $_GET['id']);
		}
	}
	
	
	
	
function abonnementApresScan($id_abonne, $id_commerce)
	{
	$bdd = Outils_Bd::getInstance()->getConnexion();
	$req2 = $bdd->prepare('SELECT * FROM abonnement WHERE id_abonne = ? AND id_commerce = ?');
	$req2->execute(array($id_abonne, $id_commerce));
	$donnees2 = $req2->fetch();
	if ($donnees2['id_abonne']=='')
		{
		$nouvel_abo= new Abonnement(array('id_commerce' => $_GET['id'], 'id_abonne' => $id_abonne));
		$inscription= new GestionAbonnement($bdd);
		$inscription->ajout($nouvel_abo);
		}
	}
	

	
	
function connexionscan($adresse_ip)
	{
	// 1° On vérifie si l'adresse_ip reçue est bien présente dans la base de données.
	// 2° Si tel est le cas, on en récupère les données
	// 3° Ces données seront retransmises en session
	// 4° Et on en profite pour considérer l'utilisateur comme connecté.
	
	$bdd = Outils_Bd::getInstance()->getConnexion();
	
	//////////////////   1°  /////////////////////////////
	
	$req = $bdd->prepare('SELECT * FROM abonne WHERE adresse_ip = ?');
	$req->execute(array($adresse_ip));
	$donnees = $req->fetch();
	if ($donnees['id_abonne']=='')
		{
		return 0;
		}
	else
		{
		$_SESSION['connexion']=1;
		$_SESSION['pseudo']=$donnees['pseudo'];
		$_SESSION['id']= $donnees['id_abonne'];
		$_SESSION['adresse_ip']= $donnees['adresse_ip'];
		header('Location: index.php?appel=liste&id=none');
		}
	}
	
?>