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


















?>