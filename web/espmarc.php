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
			case 'liste':						// Dans le cas où le commerçant voudrait voir la liste des kuchikomi qu'il aura écrit.
				$listekk=listeKuchikomi($_SESSION['id_commerce']);
				include_once('vue_liste.php');
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
				header('Location: espmarc.php');
				break;
			}
		}
	else									// En manipulant l'url, on peut arriver sur la page sans variables, auquel cas, on doit être ramené
		{								// sur l'interface
		include_once('vue_menumarc.php');
		}
	}

else if (isset($_POST['connexionmarchande']))					// Non connecté et formulaire rempli. Vérification de l'identité.
	{
	$essaiConnexion=tentativeConnexion();				// Cette fonction vérifie si on les identifiants sont corrects. 
	}								// Auquel cas, les variables de session sont modifiées/créees et on est redirigé vers la page actuelle.
	
else if (isset($_GET['connexionmarc']))					// Après l'envoi d'un POST par un commerçant, l'url de la webview doit contenir cette variable en GET.
		{
		$connexionTag=connexionTag($_SERVER['REMOTE_ADDR']);				
		}	
		
else if (isset($_GET['id']))					// Après l'envoi d'un POST par un commerçant, l'url de la webview doit contenir cette variable en GET.
		{
		echo 'plop';
		$bdd=Outils_Bd::getInstance()->getConnexion();
		$req = $bdd->prepare('SELECT * FROM commerce WHERE id_commerce = ?');
		$req->execute(array($_GET['id']));
		$donnees = $req->fetch();
		var_dump($donnees);
		$_SESSION['commerçant']=1;
		$_SESSION['id_commerce']= $donnees['id_commerce'];
		$_SESSION['pseudo']=$donnees['gerant'];
		header('Location: espmarc.php');
		}	
		
else
	{
	include_once('vue_connexionmarchand.php');
	}

	
	
include_once('../includes/pied.php');

?>