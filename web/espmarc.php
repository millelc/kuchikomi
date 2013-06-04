<?php
session_start();

include_once('../modeles/Gerant.class.php');
include_once('../modeles/GestionGerant.class.php');
include_once('../modeles/Kuchikomi.class.php');
include_once('../modeles/GestionKuchikomi.class.php');

/*
####################################### Fragment HTML (en-tête) #####################################
*/



echo '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../style/proto.css" />
        <title>KuchiKomi</title>
    </head>
 
    <body>
    <header>
      <p><a href="espmarc.php">KuchiKomi</a></p>
    </header>
    <body>';



/*
#####################################################################################################
*/


if (isset($_SESSION['commerçant']) AND $_SESSION['commerçant']==1)			// On est connecté.
	{
	echo '<a href="espmarc.php?appel=deco">Déconnexion</a>';
	
	if (isset($_GET['appel']))
		{
		switch ($_GET['appel'])		
			{
			case 'deco':						// Dans le cas où la déconnexion aurait été choisie
				echo '<br />';
				session_destroy();
				header('Location: espmarc.php');
				break;
			case 'stats':						// Dans le cas où le commerçant voudrait lire ses statistiques
				echo '<br />';
				echo '<br /><a href="espmarc.php?appel=interface">Poster</a>';
				echo '<p>Page de statistiques.</p>';
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
				
				echo 'Vous avez ' . $nb_abonnes . ' abonnés.<br />';
				$req2 = $bdd->prepare('SELECT id_kuchikomi FROM kuchikomi WHERE id_commerce = ?');	// On commence par récupérer les id du kuchikomi du commerce.
				$req2->execute(array($_SESSION['id_commerce']));
				$compteur=array();
				while ($donnees2 = $req2->fetch())
					{
					//var_dump($donnees2);
					$req3 = $bdd->prepare('SELECT COUNT(id_abonne) FROM jaime WHERE id_kuchikomi= ? ');
					$req3->execute(array($donnees2['id_kuchikomi']));
					$donnees3 = $req3->fetch();
					//var_dump($donnees3);
					$compteur[$donnees2['id_kuchikomi']] = $donnees3[0];
					}
				
				echo '<pre>';
				print_r($compteur);
				echo '</pre>';
				
				/**********************************************************************
				************** Fin de la préparation des données des kuchikomi /////////
				*//////////////////////////////////////////////////////////////////////
				
				
				/************** Sélection meilleur kuchikomi */////////////////////////
				
				$clef_meilleur_kuchikomi = array_search(max($compteur), $compteur);			// L'identifiant du meilleur kuchikomi.
				
				$req4 = $bdd->prepare('SELECT date_debut FROM kuchikomi WHERE id_kuchikomi = ?');	// Récupération de la date de début du meilleur kuchikomi.
				$req4->execute(array($clef_meilleur_kuchikomi));
				$donnees4 = $req4->fetch();
				//var_dump($donnees4);
								
				echo '<p>Vous avez écrit ' . sizeof($compteur) . ' kuchikomi.</p>';
				echo '<p>Votre kuchikomi le plus aimé est le n° ' . $clef_meilleur_kuchikomi . ' datant du ' . $donnees4[0] . ' qui l\'a été ' . max($compteur) . ' fois.</p>';
				break;
				
				
			case 'interface':					// Le cas de base normalement, il s'agit de l'interface d'ajout.
				if (isset($_POST['texte']))
					{
					if (isset($_FILES['photokk']) AND $_FILES['photokk']['error'] == 0)
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
				else
					{
					echo '<br /><a href="espmarc.php?appel=stats">Vos statistiques</a><br />
						<form action="espmarc.php?appel=interface" method="post" enctype="multipart/form-data">
						<textarea name="texte" id="texte" rows="5" >Tapez votre alerte shopping ici.</textarea><br />
						<label for="photokk">Ajouter une photo :</label><br />
						<input type="file" name="photokk" id="photokk" /><br />
						<label for="date_debut">Date de début :</label><br />
						<input type="date" name="date_debut" id="date_debut" /><br />
						<label for="date_fin">Date de fin : :</label><br />
						<input type="date" name="date_fin" id="date_fin" /><br />
						<textarea name ="mentions" id="mentions" rows="5">Conditions particulières, mentions légales, etc...</textarea><br />
						<input type="submit" value="Envoyer" /><br />
					
						';
					}
				break;
			default:
				header('Location: espmarc.php?appel=interface');
				break;
			}
		}
	
	
	
	
	
	
	
	else									// En manipulant l'url, on peut arriver sur la page sans variables, auquel cas, on doit être ramené
		{								// sur l'interface
		header('Location: espmarc.php?appel=interface');
		}
	
	
	}

	
	
	
	
	
	
	
	
	
	
	
else									// On n'est pas connecté
	{
	if (isset($_POST['connexionmarchande']))					// Non connecté et formulaire rempli. Vérification de l'identité.
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
	else
		{
		echo 'Espace réservé aux commerçants. Voici le formulaire de connexion : ';
		echo 	'<form method="post" action="espmarc.php?appel=interface">
			<p>
			<label for="pseudo">Votre pseudo :</label><br />
			<input type="text" name="pseudo" id="pseudo" /><br />
			<label for="pwd">Votre mot de passe :</label><br />
			<input type="password" name="pwd" id="pwd" /><br />
			<input type="submit" value="Connexion commerçants" name="connexionmarchande" />
			</p>
			</form>';
		}

	}

?>