<?php
// Cette page est la page d'accueuil des abonnés.
// Elle affiche les vues correspondantes
// aux options recues en GET.

session_start();

include_once('../modeles/Abonne.class.php');
include_once('../modeles/Abonnement.class.php');
include_once('../modeles/Commerce.class.php');
include_once('../modeles/Jaime.class.php');
include_once('../modeles/GestionAbonne.class.php');
include_once('../modeles/GestionAbonnement.class.php');
include_once('../modeles/GestionCommerce.class.php');
include_once('../modeles/GestionJaime.class.php');
// Contient toutes les fonctions de PHP.
include_once('../modeles/fonctions.php');

/*
####################################### Pseudo-code #################################################

Variables reçues
	Connecté
		Redirection vers page appropriée
	
	Déconnecté
		Formulaire rempli et choix connexion
		
		Formulaire rempli et choix inscription
		
		Affichage du formulaire
	

Variables non reçues
	Affichage d'un lien pontant vers une émulation de scan.

#####################################################################################################
*/

$bandeau='Nearforge';

//Les variables ont été reçues
if (isset($_GET['appel']) AND isset($_GET['id']))
	{
	//Les variables ont été reçues et on est connecté.
	if (isset($_SESSION['connexion']) AND $_SESSION['connexion']==1)
		{
		switch ($_GET['appel'])
			{
			// Dans le cas où la déconnexion aurait été choisie
			case 'deco':
				session_destroy();
				header('Location: index.php?appel=liste&id=none');
				break;
			// Dans le cas où on souhaiterait afficher un kuchikomi.
			case 'kk':
				$kuchikomi=recuperationDonneesKk($_GET['id']);
				include_once('vue_affichageKk.php');
				break;
			// Dans le cas où on souhaiterait s'abonner à un commerce.
			case 'abo':
				sAbonner();
				header('Location: index.php?appel=liste&id=none');
				break;
			// Dans le cas où on souhaiterait se désabonner d'un commerce
			case 'desabo':
				seDesabonner();
				break;
			// Dans le cas où on souhaiterait consulter la page de contact d'un commerce.				
			case 'contact':
				$infoscontacts= recupInfosCommercant($_GET['id']);
				include_once('vue_contacts.php');
				break;
			// Dans le cas où on souhaiterait consulter comment aller à un commerce.
			case 'yaller':
				$infoscarto= recupInfosCart($_GET['id']);
				include_once('vue_carto.php');
				break;
			case 'desinscr':
				desinscription();
				break;
			case 'jaime':
				aimer ();
				header('Location: index.php?appel=kk&id=' . $_GET['id'] . '');
				break;
			// Dans le cas où on souhaiterait une liste de ses abonnements ie :  id = none
			case 'liste':
				if ($_GET['id']=='none')
					{
					// Cette fonction renvoie un array associatif (id_commerce=>nom_du_commerce)
					$listeAbonnements=listeAbo($_SESSION['id'])[0];
					$nbreKkValides=listeAbo($_SESSION['id'])[1];
					$derniersKKConfondus=listeDesDerniersKkConfondus($_SESSION['id']);
					// Cet array ne concerne que des commerces où l'utilisateur est abonné.
					include_once('vue_listeabonnements.php');		
					}
				else
				// ou une liste des kuchikomi d'un commerce en particulier      ie :  id = int
					{
					$listeKuchikomi=listekk($_GET['id']);
					$_SESSION['commerce_consulte']=$_GET['id'];
					include_once('vue_listekk.php');
					}
				break;
				
			default:header('Location: index.php?appel=liste&id=none');
				break;
			}
		}
			
	// On n'est pas connecté :
	else
		{
		// On a reçu un scan de la part d'un non-connecté.
		// Il faut voir si il est inscrit.
			// Si oui, il est connecté et abonné.
			// Si non, il est en plus inscrit.
		if ($_GET['appel']=='scan')
			{
			if (isset($_POST['inscription']))
			//Variables reçues, non connecté mais formulaire d'inscription rempli.
				{
				//inscription ();
				}
			else if (isset($_POST['id']))
				{
				$id_ab=$_POST['id'];
				scan($id_ab, $_SERVER['REMOTE_ADDR']);
				}
			else if (isset($_POST['trader']))
				{
				$id_telephone_commercant=$_POST['trader'];
				scancom($id_telephone_commercant, $_SERVER['REMOTE_ADDR']);
				}
			}
			
		else if ($_GET['appel']=='list')
			{
			/*  On arrive ici par l'application. On compare si l'adresse ip est bien présente et on connecte l'utilisateur. Sinon, on ne fait rien */
			connexionscan($_SERVER['REMOTE_ADDR']);
			}
				
		else if (isset($_POST['connexion']))
		//Variables reçues, non connecté mais formulaire de connexion rempli.
			{
			connexion ();
			}
			
			
		else if (isset($_POST['inscription']))
		//Variables reçues, non connecté mais formulaire d'inscription rempli.
			{
			inscription ();
			}
		
			
		else
		//Variables reçues, non connecté mais formulaire non rempli 
			{
			include_once('vue_connexion.php');
			}
		}
	}
	
else
	{
	echo "
	      <p><a href=\"index.php?appel=abo&id=1\">Émulation d'un scan du commerce 1</a></p>
	      <p><a href=\"index.php?appel=abo&id=2\">Émulation d'un scan du commerce 2</a></p>
	      <p><a href=\"index.php?appel=abo&id=3\">Émulation d'un scan du commerce 3</a></p>
	      <p><a href=\"index.php?appel=abo&id=4\">Émulation d'un scan du commerce 4</a></p>
	      <p><a href=\"index.php?appel=abo&id=5\">Émulation d'un scan du commerce 5</a></p>
	      <p><a href=\"index.php?appel=abo&id=6\">Émulation d'un scan du commerce 6</a></p>
	      <p><a href=\"index.php?appel=abo&id=7\">Émulation d'un scan du commerce 7</a></p>
	      <p><a href=\"index.php?appel=abo&id=8\">Émulation d'un scan du commerce 8</a></p>
	      <p><a href=\"index.php?appel=abo&id=9\">Émulation d'un scan du commerce 9</a></p>
	      <p><a href=\"index.php?appel=abo&id=10\">Émulation d'un scan du commerce 10</a></p>
	      <p><a href=\"index.php?appel=abo&id=11\">Émulation d'un scan du commerce 11</a></p>
	      <fieldset>
	      <p><a href=\"index.php?appel=liste&id=none\">Un utilisateur inscrit et connecté qui lance son application atterrira directement sur la liste de ses abonnements.</a></p>
	      </fieldset>";
	      
	echo "
	      <fieldset>
	      <p>Les liens ci-dessous ne seront pas affiches, ils ne servent que pour la maquette et les tests. Commercants et admins auront une adresse directe à contacter.</p>
	      <p><a href=\"espmarc.php\">Espace marchand</a></p>
	      <p><a href=\"../org/admin.php\">Espace admin</a></p>
	      </fieldset>
	      <fieldset>
	      <p>Scan du tag du magasin 1 (AUTOMATIQUE)</p>
	      <form method=\"post\" action=\"index.php?appel=scan&id=1\">
	      <p><label for=\"id\">Votre pseudo :</label><br /><input type=\"text\" name=\"id\" id=\"id\" required value=\"abcdef\" /><br />
	      <input type=\"submit\" value=\"Connexion\" name=\"connexion\" class=\"btn btn-primary btn-small\" />
	      </form>
	      </fieldset>
	      <fieldset>
	      <p>Scan du tag du magasin 2 (AUTOMATIQUE)</p>
	      <form method=\"post\" action=\"index.php?appel=scan&id=2\">
	      <p><label for=\"id\">Votre pseudo :</label><br /><input type=\"text\" name=\"id\" id=\"id\" required value=\"abcdef\" /><br />
	      <input type=\"submit\" value=\"Connexion\" name=\"connexion\" class=\"btn btn-primary btn-small\" />
	      </form>
	      <fieldset>
	      <p>Scan du tag du magasin 3 (AUTOMATIQUE)</p>
	      <form method=\"post\" action=\"index.php?appel=scan&id=3\">
	      <p><label for=\"id\">Votre pseudo :</label><br /><input type=\"text\" name=\"id\" id=\"id\" required value=\"abcdef\" /><br />
	      <input type=\"submit\" value=\"Connexion\" name=\"connexion\" class=\"btn btn-primary btn-small\" />
	      </form>
	      </fieldset>
	      </fieldset>
	      ";
	      
	echo '<br /><a href="index.php?appel=deco&id=none">Déconnexion</a>';
	}
?>