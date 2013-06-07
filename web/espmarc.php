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
				$statistiques = calculStatistiques();
				include_once('vue_statistiques.php');
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