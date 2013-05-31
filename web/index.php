 
<?php

session_start();

include_once('../modeles/Abonne.class.php');
include_once('../modeles/Abonnement.class.php');
include_once('../modeles/Commerce.class.php');
include_once('../modeles/GestionAbonne.class.php');
include_once('../modeles/GestionAbonnement.class.php');
include_once('../modeles/GestionCommerce.class.php');


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
      <p><a href="index.php">KuchiKomi</a></p>
    </header>
    <body>';



/*
#####################################################################################################
*/



// Ajout des tests d'acceptance dans les stories.


if (isset($_GET['appel']) AND isset($_GET['id']))				//Les variables ont été reçues
	{
	echo '<fieldset> <p>Variables de test :</p>';
	echo "<p>-J'ai reçu cet appel : </p>";
	echo $_GET['appel'];
	echo "<p>-J'ai reçu cet identifiant : </p>";
	echo $_GET['id'];
	echo '</fieldset>';
	echo '<br />';
	if (isset($_SESSION['connexion']) AND $_SESSION['connexion']==1)	//Les variables ont été reçues et on est connecté.
		{
		switch ($_GET['appel'])
			/*
			Expliciter les case
			*/
		
			{
			case 'deco':						// Dans le cas où la déconnexion aurait été choisie
				echo '<br />';
				session_destroy();
				echo 'Cette page devra renvoyer immédiatement vers la page listant les kuchikomi. Comme on ne sera plus connecté, ce sera le formulaire de connexion qui appraîtra en premier lieu.';
				break;
			case 'kk':						// Dans le cas où on souhaiterait afficher un kuchikomi.
				echo '<a href="index.php?appel=liste&id=';
				echo $_GET['id'];
				echo '">Retour à la liste</a><br />';
				$bdd = Outils_Bd::getInstance()->getConnexion();		// On récupère une instance du singleton de connexion.
				$req = $bdd->prepare('SELECT texte FROM kuchikomi WHERE id_kuchikomi = ?');		// On récupère les données nécessaires à 
				$req->execute(array($_GET['id']));						// l'affichage du kuchilomi.
				while ($donnees = $req->fetch())
					{
					echo $donnees['texte'];
					}
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
					}
				else
					{
					$desinscription->suppr($abo_a_suppr);					// L'abonnement existe, on peut alors le supprimer.
					}
				break;
			
			
			case 'contact':						// Dans le cas où on souhaiterait consulter la page de contact d'un commerce.
				echo '<fieldset>';
				echo '<br />';
				echo 'Vous voulez voir comment contacter le commerce : ';
				echo $_GET['id'];
				echo '<br />Et vous êtes : ';
				echo $_SESSION['id'];
				echo '<br />';
				echo '</fieldset>';
				echo '<a href="index.php?appel=yaller&id=';
				echo $_GET['id'];
				echo '">Y aller !</a><br />';
				echo '<a href="index.php?appel=liste&id=';
				echo $_GET['id'];
				echo '">Retour à la liste</a><br />';
				$commercant_req=new GestionCommerce(Outils_Bd::getInstance()->getConnexion());		// On récupère l'instance de connexion
				$commercant=new commerce (($commercant_req->quereur($_GET['id'])));				// On créé un commerce que l'on hydrate avec les
															// infos récupérées avec la méthode quéreur.
				echo '<p>Nom du comerce : ';
				echo $commercant->nom();
				echo '</p><p>Gérant : ';
				echo $commercant->gerant();
				echo '</p><p><u>Horaires d\'ouverture :</u> ';
				echo $commercant->horaires();
				echo '</p><p>Tel : ';
				echo $commercant->num_tel();
				echo '</p><p>Email : ';
				echo $commercant->email();
				echo '</p>';
				break;
				
			case 'yaller':						// Dans le cas où on souhaiterait consulter comment aller à un commerce.
				echo '<fieldset>';
				echo '<br />';
				echo 'Vous voulez voir comment vous rendre à ce commerce : ';
				echo $_GET['id'];
				echo '<br />Et vous êtes : ';
				echo $_SESSION['id'];
				echo '<br />';
				echo '</fieldset>';
				echo '<a href="index.php?appel=contact&id=';
				echo $_GET['id'];
				echo '">Y aller !</a><br />';
				echo '<a href="index.php?appel=liste&id=';
				echo $_GET['id'];
				echo '">Retour à la liste</a><br />';
				$commercant_req=new GestionCommerce(Outils_Bd::getInstance()->getConnexion());		// On créé une instance de connexion avec la bdd.
				$commercant=new commerce (($commercant_req->quereur($_GET['id'])));				// Puis on créé un commerce qu'on hydrate grâce
				echo '<p>Adresse : ';									// à la méthode quéreur.
				echo $commercant->adresse();
				echo '</p><p>Bus : ligne ';
				echo $commercant->ligne_bus();
				echo '</p><p>Arrêt : ';
				echo $commercant->arret();
				echo '</p>';
				break;
				
				
			case 'scan':						// Dans le cas où on aurait simplement scanné un QRcode/champNFC
				header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
				break;
			
				
			case 'liste':						// Dans le cas où on souhaiterait une liste de ses abonnements ie :  id = none
				if ($_GET['id']=='none')				// ou une liste des kuchikomi d'un commerce n particulier      ie :  id = int
					{
					echo '<fieldset>';
					echo '<br />Votre identifiant : ';
					echo $_SESSION['id'];
					echo '</fieldset>';
					echo '<br />Voici la liste de vos abonnements :<br /> ';
					$bdd = Outils_Bd::getInstance()->getConnexion();			// On récupère une instance de connexion.
					$req = $bdd->prepare('SELECT id_commerce FROM abonnement WHERE id_abonne = ?');	//On récupère la liste des id_commerce dont on
					$req->execute(array($_SESSION['id']));						// est abonné.
					while ($donnees = $req->fetch())
						{
						$req2 = $bdd->prepare('SELECT id_commerce, nom FROM commerce WHERE id_commerce = ?');	// Pour chaque id_commerce,
						$req2->execute(array($donnees['id_commerce']));						// on va chercher les noms
						while ($donnees = $req2->fetch())								// correspondants
							{										// et en faire une liste
							echo '<a href="index.php?appel=liste&id=';						// de leurs noms
							echo $donnees['id_commerce'];
							echo '">';
							echo $donnees['nom'];
							echo '</a>';
							echo '     ';
							}
						}
					echo '<br /><a href="index.php?appel=deco&id=none">Déconnexion</a>';
					}
				else
					{
					echo '<br />';
					$idcom = $_GET['id'] + 0;		// Pour convertir le string en int.
					if ($idcom==0)
						{
						echo 'La variable reçue n\'est pas du type adéquat.';
						}
					else
						{
						echo '<a href="index.php?appel=contact&id=';
						echo $_GET['id'];
						echo '">Contacter le commerçant.</a><br />';
						echo '<a href="index.php?appel=yaller&id=';
						echo $_GET['id'];
						echo '">Y aller !</a><br />';
						echo '<a href="index.php?appel=desabo&id=';
						echo $_GET['id'];
						echo '">Se désabonner</a>';
						echo '<p>Voici la liste des kuchikomi de ce commerce :</p>';
						$bdd = Outils_Bd::getInstance()->getConnexion();				// On récupère l'instance de connexion.
						$req = $bdd->prepare('SELECT id_kuchikomi, texte_alerte FROM kuchikomi WHERE id_commerce = ?');	// On récupère les aperçus 
						$req->execute(array($idcom));									// de chaque kuchikomi
						while ($donnees = $req->fetch())
							{
							echo '<br />';
							echo '<a href="index.php?appel=kk&id=';							// et on les affiche.
							echo $donnees['id_kuchikomi'];
							echo '">';
							echo $donnees['texte_alerte'];
							echo '</a>';
							}
						}
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
			echo "<p>Ordre bien reçu mais vous n'êtes pas connecté.</p>";
			include_once('../includes/formulaire_auth.php');
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











/*
####################################### Fragment HTML (pied) ##########################################
*/



echo '</body>
	<footer>
	</footer>
	</html>';



/*
#####################################################################################################
*/





?>