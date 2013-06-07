 
<?php

session_start();

include_once('../modeles/Abonne.class.php');
include_once('../modeles/Abonnement.class.php');
include_once('../modeles/Commerce.class.php');
include_once('../modeles/Jaime.class.php');
include_once('../modeles/GestionAbonne.class.php');
include_once('../modeles/GestionAbonnement.class.php');
include_once('../modeles/GestionCommerce.class.php');
include_once('../modeles/GestionJaime.class.php');


include_once('../modeles/fonctions.php');		// Contient toutes les fonctions de PHP.

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

if (isset($_GET['appel']) AND isset($_GET['id']))				//Les variables ont été reçues
	{
	if (isset($_SESSION['connexion']) AND $_SESSION['connexion']==1)	//Les variables ont été reçues et on est connecté.
		{
		switch ($_GET['appel'])
		
			{
			case 'deco':						// Dans le cas où la déconnexion aurait été choisie
				echo '<br />';
				session_destroy();
				header('Location: index.php?appel=liste&id=none');
				break;
			case 'kk':						// Dans le cas où on souhaiterait afficher un kuchikomi.
				$kuchikomi=recuperationDonneesKk($_GET['id']);
				include_once('vue_affichageKk.php');
				break;
				
				
				
			case 'abo':						// Dans le cas où on souhaiterait s'abonner à un commerce.
				sAbonner();
				header('Location: index.php?appel=liste&id=none');
				break;
				
			case 'desabo':						// Dans le cas où on souhaiterait se désabonner d'un commerce
				seDesabonner();
				break;
			
			
			case 'contact':						// Dans le cas où on souhaiterait consulter la page de contact d'un commerce.
				
				$infoscontacts= recupInfosCommercant($_GET['id']);
				//var_dump($infoscontacts);
				include_once('vue_contacts.php');
				break;
				
			case 'yaller':						// Dans le cas où on souhaiterait consulter comment aller à un commerce.
				$infoscarto= recupInfosCart($_GET['id']);
				include_once('vue_carto.php');
				break;
				
				
			case 'scan':						// Dans le cas où on aurait simplement scanné un QRcode/champNFC
				header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
				break;
				
			case 'desinscr':
				desinscription();
				break;
			
			case 'jaime':
				aimer ();
				header('Location: index.php?appel=kk&id=' . $_GET['id'] . '');
				break;
			
			
			
				
			case 'liste':						// Dans le cas où on souhaiterait une liste de ses abonnements ie :  id = none
				if ($_GET['id']=='none')
					{
					$listeAbonnements=listeAbo($_SESSION['id']);	// Cette fonction renvoie un array associatif (id_commerce=>nom_du_commerce)
					include_once('vue_listeabonnements.php');		// Cet array ne concerne que des commerces où l'utilisateur est abonné.
					}
				else						// ou une liste des kuchikomi d'un commerce en particulier      ie :  id = int
					{
					$listeKuchikomi=listekk($_GET['id']);
					//var_dump($listeKuchikomi);
					include_once('vue_listekk.php');
					}
				break;
				
			default:							// Dans les cas non pris en compte ou lors d'une modif d'url.
				/*echo "<p>Vous êtes connecté et vous avez envoyé un appel.</p>";
				echo 'Vous voulez ';
				echo $_GET['appel'];
				echo '<br /> L\'identifiant est ';
				echo $_GET['id'];
				echo '<br />Vous êtes ';
				echo $_SESSION['pseudo'];
				echo '<br /><a href="index.php?appel=deco&id=none">Déconnexion</a>';*/
				header('Location: index.php?appel=liste&id=none'); /********************************* À supprimer en cas de tuile !!!!!!!!!!!!!!*/
				break;
				
			}
		}
			
	
	else									//Les variables ont été reçues et on n'est pas connecté.
		{
		
		if (isset($_POST['connexion']))					//Variables reçues, non connecté mais formulaire de connexion rempli.
			{
			connexion ();
			}
			
			
		else if (isset($_POST['inscription']))				//Variables reçues, non connecté mais formulaire d'inscription rempli.
			{
			inscription ();
			}
		
			
		else								//Variables reçues, non connecté mais formulaire non rempli 
			{
			include_once('vue_connexion.php');
			}
		}
	}
	
else
	{
	echo "<p>Cette page n'a pas vocation a être vue. Seule une modification d'adresse peut y amener.<p>
	      <p>Une redirection vers un formulaire de connexion pointant vers la liste des abonnements sera implémentée</p>
	      <p><a href=\"index.php?appel=scan&id=1\">Émulation d'un scan du commerce 1</a></p>
	      <p><a href=\"index.php?appel=scan&id=2\">Émulation d'un scan du commerce 2</a></p>
	      <p><a href=\"index.php?appel=scan&id=3\">Émulation d'un scan du commerce 3</a></p>
	      <p><a href=\"index.php?appel=scan&id=4\">Émulation d'un scan du commerce 4</a></p>
	      <p><a href=\"index.php?appel=scan&id=5\">Émulation d'un scan du commerce 5</a></p>
	      <fieldset>
	      <p><a href=\"index.php?appel=liste&id=none\">Un utilisateur inscrit et connecté qui lance son application atterrira directement sur la liste de ses abonnements.</a></p>
	      </fieldset>
	      <fieldset>
	      <p>Les liens ci-dessous ne seront pas affichés, ils ne servent que pour la maquette et les tests. Commerçants et admins auront une adresse directe à contacter.</p>
	      <p><a href=\"espmarc.php\">Espace marchand</a></p>
	      <p><a href=\"../org/admin.php\">Espace admin</a></p>
	      </fieldset>
	      ";
	      
	echo '<br /><a href="index.php?appel=deco&id=none">Déconnexion</a>';
	}














?>