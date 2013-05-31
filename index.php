<?php

session_start();

include_once('modeles/Abonne.class.php');
include_once('modeles/Abonnement.class.php');
include_once('modeles/GestionAbonne.class.php');
include_once('modeles/GestionAbonnement.class.php');


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
        <link rel="stylesheet" href="style/proto.css" />
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
			{
			case 'deco':
				echo '<br />';
				session_destroy();
				echo 'Cette page devra renvoyer immédiatement vers la page listant les kuchikomi. Comme on ne sera plus connecté, ce sera le formulaire de connexion qui appraîtra en premier lieu.';
				break;
			case 'kk':
				$bdd = Outils_Bd::getInstance()->getConnexion();
				$req = $bdd->prepare('SELECT texte FROM kuchikomi WHERE id_kuchikomi = ?');
				$req->execute(array($_GET['id']));
				while ($donnees = $req->fetch())
					{
					echo $donnees['texte'];
					}
				break;
				
			case 'abo':
				$nouvel_abo= new Abonnement(array('id_commerce' => $_GET['id'], 'id_abonne' => $_SESSION['id'] ));
				$connexion = Outils_Bd::getInstance()->getConnexion();
				$inscription= new GestionAbonnement($connexion);
				$inscription->commerceExistant($nouvel_abo);
				if ($inscription->commerceExistant($nouvel_abo)==True)				// Le commerce existe bel et bien.
					if ($inscription->dejaAbonne($nouvel_abo)==True)			// Si on peut s'abonner car l'abonnement n'existe pas déjà.
						{
						$inscription->ajout($nouvel_abo);
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
				
			case 'desabo':
				echo '<br />';
				echo 'Désabonnement à faire : ';
				echo $_GET['id'];
				echo $_SESSION['id'];
				$abo_a_suppr= new Abonnement(array('id_commerce' => $_GET['id'], 'id_abonne' => $_SESSION['id'] ));
				$connexion = Outils_Bd::getInstance()->getConnexion();
				$desinscription= new GestionAbonnement($connexion);
				$desinscription->suppr($abo_a_suppr);
				break;
				
				
			case 'scan':
				header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
				break;
			
				
			case 'liste':
				if ($_GET['id']=='none')
					{
					echo '<fieldset>';
					echo '<br />Votre identifiant : ';
					echo $_SESSION['id'];
					echo '</fieldset>';
					echo '<br />Voici la liste de vos abonnements :<br /> ';
					$bdd = Outils_Bd::getInstance()->getConnexion();
					$req = $bdd->prepare('SELECT id_commerce FROM abonnement WHERE id_abonne = ?');
					$req->execute(array($_SESSION['id']));
					while ($donnees = $req->fetch())
						{
						$req2 = $bdd->prepare('SELECT id_commerce, nom FROM commerce WHERE id_commerce = ?');
						$req2->execute(array($donnees['id_commerce']));
						while ($donnees = $req2->fetch())
							{
							echo '<a href="index.php?appel=liste&id=';
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
					$idcom = $_GET['id'] + 0;
					if ($idcom==0)
						{
						echo 'La variable reçue n\'est pas du type adéquat.';
						}
					else
						{
						echo '<a href="index.php?appel=desabo&id=';
						echo $_GET['id'];
						echo '">Se désabonner</a>';
						echo '<p>Voici la liste des kuchikomi de ce commerce :</p>';
						$bdd = Outils_Bd::getInstance()->getConnexion();
						$req = $bdd->prepare('SELECT id_kuchikomi, texte_alerte FROM kuchikomi WHERE id_commerce = ?');
						$req->execute(array($idcom));
						while ($donnees = $req->fetch())
							{
							echo '<br />';
							echo '<a href="index.php?appel=kk&id=';
							echo $donnees['id_kuchikomi'];
							echo '">';
							echo $donnees['texte_alerte'];
							echo '</a>';
							}
						}
					}
				break;
				
			default:
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
			$nouveau_connecte= new Abonne(array('pseudo' => $_POST['pseudo'], 'mdp' => $_POST['pwd'] ));
			$connexion = Outils_Bd::getInstance()->getConnexion();
			$connecte= new GestionAbonne($connexion);
			if ($connecte->dejaInscrit($nouveau_connecte)==0)		// Le pseudo est-il le bon ?
				{
				echo 'Pseudo ou mot de passe incorrect';
				}
			else
				{
				$_SESSION['id']= $connecte->dejaInscrit($nouveau_connecte);
				$_SESSION['pseudo']= $_POST['pseudo'];
				$_SESSION['connexion']=1;
				header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
				}
			
			}
			
			
		else if (isset($_POST['inscription']))				//Variables reçues, non connecté mais formulaire d'inscription rempli.
			{
			echo "<br />Vous avez choisi de vous inscrire.";
			$nouvel_inscrit= new Abonne(array('pseudo' => $_POST['pseudo'], 'mdp' => $_POST['pwd'] ));
			$connexion = Outils_Bd::getInstance()->getConnexion();
			$inscription= new GestionAbonne($connexion);
			if ($inscription->dejaInscrit($nouvel_inscrit)==0)		// On vérifie que ce pseudo n'est pas déjà utilisé.
				{
				$_SESSION['id']= $inscription->ajout($nouvel_inscrit);
				$_SESSION['connexion']=1;
				$_SESSION['pseudo']= $_POST['pseudo'];
				}
			
			
			header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
			}
		
			
		else								//Variables reçues, non connecté mais formulaire non rempli 
			{
			echo "<p>Ordre bien reçu mais vous n'êtes pas connecté.</p>";
			include_once('includes/formulaire_auth.php');
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
	      <p>Les liens ci-dessous ne seront pas affichés, ils ne servent que pour la maquette et les tests. Commerçants et admins auront une adresse directe à contacter.</p>
	      <p><a href=\"org/espmarc.php\">Espace marchand</a></p>
	      <p><a href=\"org/admin.php\">Espace admin</a></p>
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