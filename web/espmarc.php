<?php
session_start();

include_once('../modeles/Gerant.class.php');
include_once('../modeles/GestionGerant.class.php');
include_once('../modeles/Kuchikomi.class.php');
include_once('../modeles/GestionKuchikomi.class.php');
include_once('../modeles/fonctions.php');



$bandeau='Nearforge';


if (isset($_SESSION['commerçant']) AND $_SESSION['commerçant']==1)			// On est connecté.
	{
	
	
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
				//var_dump($donnees4);
								
				echo '<p>Vous avez écrit ' . sizeof($compteur) . ' kuchikomi.</p>';
				echo '<p>Votre kuchikomi le plus aimé est le n° ' . $clef_meilleur_kuchikomi . ' datant du ' . $donnees4[0] . ' qui l\'a été ' . max($compteur) . ' fois.</p>';
				/**********************************************************************/
				
				/***********************************************************************
				******************** Progression des abonnements ***********************
				***********************************************************************/
				
				$req5 = $bdd->prepare('SELECT COUNT(id_abonne) FROM abonnement WHERE id_commerce = ? AND TO_DAYS(NOW()) - TO_DAYS(date) <= 30;');	//Le nombre d'abonnés ces 30 derniers jours.
				$req5->execute(array($_SESSION['id_commerce']));
				$donnees5 = $req5->fetch();
				$nb_abonnes_30_jours = $donnees5[0];
				$nombre_abonnes_de_plus_de_30_jours=$nb_abonnes-$nb_abonnes_30_jours;
				$augmentation_sur_le_mois=($nb_abonnes_30_jours/$nombre_abonnes_de_plus_de_30_jours)*100;
				echo '<p>Ces 30 derniers jours, ' . $donnees5[0] . ' personnes se sont abonnées. Vous en aviez ' . $nombre_abonnes_de_plus_de_30_jours . ' auparavant.</p>';
				//var_dump($donnees5);
				echo '<p>Votre nombre d\'abonnés a augmenté de '. $augmentation_sur_le_mois . '% durant les 30 derniers jours.</p>';
				/***********************************************************************/
				
				
				/************************************************************************
				/********************* Nombre total de j'aime **************************/
				/***********************************************************************/
				
				// La requête SQL ci-dessous compte tous les kuchikomi aimés. Utilisation d'une sous-requête.
				$req7 = $bdd->prepare('SELECT COUNT(*) FROM jaime WHERE id_kuchikomi IN (SELECT id_kuchikomi FROM kuchikomi WHERE id_commerce = ?) ');
				$req7->execute(array($_SESSION['id_commerce']));
				$donnees7 = $req7->fetch();
				echo 'Vos kuchikomi ont été aimé ' . $donnees7[0] . ' fois.';
				
				break;
				
				
			case 'interface':					// Le cas de base normalement, il s'agit de l'interface d'ajout.
				if (isset($_POST['texte']))
					{
					$ajout=ajoutkk();
					}
				else
					{
					include_once('vue_interface.php');
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
			$essaiConnexion=tentativeConnexion();				// Cette fonction vérifie si on les identifiants sont corrects. 
			}								// Auquel cas, les variables de session sont modifiées/créees et on est redirigé vers la page actuelle.
	else
		{
		include_once('vue_connexionmarchand.php');
		}

	}

?>