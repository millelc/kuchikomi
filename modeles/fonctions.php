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
























?>