<?php


function recupererStats()
{
// On récupère une instance de connexion.
$bdd = Outils_Bd::getInstance()->getConnexion();
// On souhaite récupérer le nombre de commerçants.
$req = $bdd->prepare('SELECT COUNT(*) FROM commerce');
$req->execute(array());
$donnees = $req->fetch();
echo '<p>Il y a ' . $donnees[0] . ' commerçants inscrits.</p>';

// On souhaite récupérer le nombre de commerçants.
$req2 = $bdd->prepare('SELECT COUNT(*) FROM abonne');	
$req2->execute(array());
$donnees2 = $req2->fetch();
echo '<p>Il y a ' . $donnees2[0] . ' utilisateurs inscrits.</p>';

// On souhaite récupérer le nombre de commerçants.
$req3 = $bdd->prepare('SELECT COUNT(*) FROM abonnement');
$req3->execute(array());
$donnees3 = $req3->fetch();
echo '<p>Il y a ' . $donnees3[0] . ' abonnements.</p>';

// On souhaite récupérer le nombre de commerçants.
$req4 = $bdd->prepare('SELECT COUNT(*) FROM jaime');
$req4->execute(array());
$donnees4 = $req4->fetch();
echo '<p>Il y a ' . $donnees4[0] . ' « J\'aime ! ».</p>';
	
// On souhaite récupérer le nombre de commerçants.
$req5 = $bdd->prepare('SELECT COUNT(*) FROM kuchikomi');
$req5->execute(array());
$donnees5 = $req5->fetch();
echo '<p>Il y a ' . $donnees5[0] . ' kuchikomi écrits..</p>';
}
	

function recupBandeau()
{
$ofic = fopen('../bandeau', 'r');
// On lit la première ligne.
$nom_image = fgets($ofic);
fclose($ofic);
return $nom_image;
}


function ajouterCommerce()
	{
	// Si on reçoit un fichier, il faut s'en occuper.
	if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)
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
				move_uploaded_file($_FILES['photo']['tmp_name'], '../web/images/' . $nom_photo);
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
				move_uploaded_file($_FILES['logo']['tmp_name'], '../web/images/' . $nom_logo);
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
				move_uploaded_file($_FILES['photo']['tmp_name'], '../web/images/' . $nom_photo);
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
				move_uploaded_file($_FILES['logo']['tmp_name'], '../web/images/' . $nom_logo);
				}
			}
		}
	else
		{
		$nom_logo = $_GET['l'];
		}
		
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
	
	// Le plus dur est fait, les deux images, si elles existent, ont été envoyées,
	// stockées et leurs noms normalisés.
	// À présent, on se retrouve avec un tableau de données contenant des données
	// suffisantes pour créer des objets Commerce et Gérant et les ajouter à la bdd.
	
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
	// Si on reçoit un fichier, il faut s'en occuper.
	if (isset($_FILES['bandeau']) AND $_FILES['bandeau']['error'] == 0)
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
				move_uploaded_file($_FILES['bandeau']['tmp_name'], '../web/images/' . $nom_bandeau);
				}
			}
		}
	$ofic = fopen('../bandeau', 'r+');
	// On remet le curseur au début du fichier.
	fseek($ofic, 0);
	// On écrit le nom de la nouvelle image.
	fputs($ofic, $nom_bandeau);
	fclose($ofic);
	}





?>