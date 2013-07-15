<?php
session_start();
include_once('../modele/fonctionsMarc.php');
include_once('../modele/fonctions.php');


$choix_dispo = array("stats", "kk", "kkdifféré", "liste");

if (isset($_POST['connexion']) AND $_POST['connexion']=='Me connecter')
{
  $pseudo= $_POST['pseudo'];
  recupInfoCom($pseudo);
}
if (isset($_GET['appel']))
	{
	switch ($_GET['appel'])		
		{
		// Dans le cas où le commerçant voudrait voir la liste des kuchikomi qu'il aura écrit.
		case 'liste':
			$listekk=listeKuchikomi($_SESSION['id_commerce']);
			include_once('../vues/listekkMarc.php');
			break;
		// Le cas de base normalement, il s'agit de l'interface d'ajout.
		case 'interface':
			if (isset($_POST['texte']))
				{
				$ajout=ajoutkk();
				}
			else
				{
				include_once('../vues/interfaceMarc.php');
				}
			break;
		default:
			header('Location: espmarc.php');
			break;
		}
	}
else
// En manipulant l'url, on peut arriver sur la page sans variables, auquel cas,
// on doit être ramené sur l'interface
	{
	include_once('../vues/statsMarc.php');
	}


?>
