 
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



$bandeau='None';

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
				$nouvel_abo= new Abonnement(array('id_commerce' => $_GET['id'], 'id_abonne' => $_SESSION['id'] ));	// On créé un nouvel abonnement
				$connexion = Outils_Bd::getInstance()->getConnexion();						// Puis on instancie une connexion
				$inscription= new GestionAbonnement($connexion);						// Dont on se servira pour l'objet inscription
				$inscription->commerceExistant($nouvel_abo);						// On vérifie que le commerce existe
				
				if ($inscription->commerceExistant($nouvel_abo)==True)				// Le commerce existe bel et bien.
					if ($inscription->dejaAbonne($nouvel_abo)==True)			// NB : Si dejaAbonne renvoie True, c'est qu'on est pas abonné.
						{
						$inscription->ajout($nouvel_abo);				// Si pas encore abonné, on le devient.
						echo '<p>Vous êtes désormais abonné à ce commerce.</p>';
						}
					else									// L'abonnement existe déjà.
						{
						echo '<p>Vous êtes déjà abonné à ce commerce.</p>';
						}
				else
					{
					echo 'Ce commerce n\'existe pas';
					}
				header('Location: index.php?appel=liste&id=none');
				break;
				
			case 'desabo':						// Dans le cas où on souhaiterait se désabonner d'un commerce
				$abo_a_suppr= new Abonnement(array('id_commerce' => $_GET['id'], 'id_abonne' => $_SESSION['id'] )); //On créé un nouvel abonnement
				$connexion = Outils_Bd::getInstance()->getConnexion();					// On appelle l'instance de connexion
				$desinscription= new GestionAbonnement($connexion);				// On créé un objet gérant les abonnements
				if ($desinscription->dejaAbonne($abo_a_suppr)==True)				// True signifie que l'abonnement n'existe pas.
					{
					echo 'Cet abonnement n\'existe pas.';					// Ceci pour empêcher un désabonnement n'existant pas
					header('Location: index.php?appel=liste&id=none');
					}
				else
					{
					$desinscription->suppr($abo_a_suppr);					// L'abonnement existe, on peut alors le supprimer.
					header('Location: index.php?appel=liste&id=none');
					}
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
				echo 'Vous voulez vous désinscrire.';
				$desinscription = new GestionAbonne(Outils_Bd::getInstance()->getConnexion());		// Création de l'objet.
				$desinscription->desinscription($_SESSION['id']);					// Désactivation de l'utilisateur.
				$desabonnements = new GestionAbonnement(Outils_Bd::getInstance()->getConnexion());	// Création de l'objet.
				$desabonnements ->supprtotale($_SESSION['id']);						// Suppression de tous les abonnements.
				session_destroy();
				header('Location: index.php?appel=liste&id=none');
				break;
			
			case 'jaime':
				echo '<p>Vous avez aimé ce kuchikomi ';
				echo $_GET['id'];
				echo '<br />Et vous êtes ';
				echo $_SESSION['id'];
				echo '</p>';
				$nouveau_jaime= new Jaime (array('id_abonne' => $_SESSION['id'], 'id_kuchikomi' => $_GET['id'] ));	// Création d'un objet « Jaime ».
				echo '<p>Ce kuchikomi a pour identifiants ';
				echo $nouveau_jaime->id_abonne();
				echo $nouveau_jaime->id_kuchikomi();
				echo '</p>';
				$jaime_ajout = new GestionJaime (Outils_Bd::getInstance()->getConnexion());	// On ajoute le jaime à la table si il est nouveau.
				$jaime_ajout->ajout($nouveau_jaime);
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
				
			default:							// Dans les cas non pris en compte.
				echo "<p>Vous êtes connecté et vous avez envoyé un appel.</p>";
				echo 'Vous voulez ';
				echo $_GET['appel'];
				echo '<br /> L\'identifiant est ';
				echo $_GET['id'];
				echo '<br />Vous êtes ';
				echo $_SESSION['pseudo'];
				echo '<br /><a href="index.php?appel=deco&id=none">Déconnexion</a>';
				header('Location: index.php?appel=liste&id=none'); /********************************* À supprimer en cas de tuile !!!!!!!!!!!!!!*/
				break;
				
			}
		}
			
	
	else									//Les variables ont été reçues et on n'est pas connecté.
		{
		
		if (isset($_POST['connexion']))					//Variables reçues, non connecté mais formulaire de connexion rempli.
			{
			echo "<br />Vous avez choisi de vous connecter.";
			$nouveau_connecte= new Abonne(array('pseudo' => $_POST['pseudo'], 'mdp' => $_POST['pwd'] ));	//On créé un abonné.
			$connexion = Outils_Bd::getInstance()->getConnexion();					// On prépare l'accès à la bdd.
			$connecte= new GestionAbonne($connexion);							// On appelle le gestionnaire des abonnés
			if ($connecte->dejaInscrit($nouveau_connecte)==0)		// Le pseudo est-il le bon ?
				{
				echo 'Pseudo ou mot de passe incorrect';						// Le pseudo n'est pas correct
				header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
				}
			else
				{
				$_SESSION['id']= $connecte->dejaInscrit($nouveau_connecte);		// L'id de la session est égal à celui de l'abonné dans la base.
				$_SESSION['pseudo']= $_POST['pseudo'];
				$_SESSION['connexion']=1;
				header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
				}
			
			}
			
			
		else if (isset($_POST['inscription']))				//Variables reçues, non connecté mais formulaire d'inscription rempli.
			{
			$nouvel_inscrit= new Abonne(array('pseudo' => $_POST['pseudo'], 'mdp' => $_POST['pwd'] ));	// On créé un nouvel abonné avec ce pseudo et ce mdp.
			$connexion = Outils_Bd::getInstance()->getConnexion();					// On appelle une instance de la connexion
			$inscription= new GestionAbonne($connexion);						// On prépare le gestionnaire d'abonnés
			if ($inscription->dejaInscrit($nouvel_inscrit)==0)		// On vérifie que ce pseudo n'est pas déjà utilisé. Si il l'est déjà, rien ne se passe.
				{
				$_SESSION['id']= $inscription->ajout($nouvel_inscrit);		// Le pseudo est libre, le gestionnaire l'ajoute à la table.
				$_SESSION['connexion']=1;
				$_SESSION['pseudo']= $_POST['pseudo'];
				}
			
			
			header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
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