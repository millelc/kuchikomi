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
	

?>