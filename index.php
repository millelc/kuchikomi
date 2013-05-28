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
	echo "<p>J'ai reçu cet appel : </p>";
	echo $_GET['appel'];
	echo "<p>J'ai reçu cet identifiant : </p>";
	echo $_GET['id'];
	if (isset($_SESSION['connexion']) AND $_SESSION['connexion']==1)	//Les variables ont été reçues et on est connecté.
		{
		if ($_GET['appel']=='deco')
			{
			echo '<br />';
			session_destroy();
			echo 'Cette page devra renvoyer immédiatement vers la page listant les kuchikomi. Comme on ne sera plus connecté, ce sera le formulaire de connexion qui appraîtra en premier lieu.';
			}
		else if ($_GET['appel']=='abo')
			{
			echo '<br />Vous souhaitez vous abonner au magasin n° ';
			echo $_GET['id'];
			echo '<br />Votre identifiant est : ';
			echo $_SESSION['id'];
			echo '<br />';
			$nouvel_abo= new Abonnement(array('id_commerce' => $_GET['id'], 'id_abonne' => $_SESSION['id'] ));
			$connexion = Outils_Bd::getInstance()->getConnexion();
			$inscription= new GestionAbonnement($connexion);
			$inscription->ajout($nouvel_abo);
			header('Location: index.php?appel=liste&id=none');
			}
			
		else if ($_GET['appel']=='liste')
			{
			echo '<br />Votre identifiant : ';
			echo $_SESSION['id'];
			echo '<br />Voici la liste de vos abonnements :<br /> ';
			
			$bdd = Outils_Bd::getInstance()->getConnexion();
			$req = $bdd->prepare('SELECT id_commerce FROM abonnement WHERE id_abonne = ?');
			$req->execute(array($_SESSION['id']));
			
			while ($donnees = $req->fetch())
				{
				echo $donnees['id_commerce'];
				echo ' ';
				$req2 = $bdd->prepare('SELECT nom FROM commerce WHERE id_commerce = ?');
				$req2->execute(array($donnees['id_commerce']));
				while ($donnees = $req2->fetch())
					{
					echo $donnees['nom'];
					echo '   <br />';
					}
				}
			
			
			}
			
			
			
			
			
		else
			{
			echo "<p>Vous êtes connecté et vous avez envoyé un appel.</p>";
			echo 'Vous voulez ';
			echo $_GET['appel'];
			echo '<br /> L\'identifiant est ';
			echo $_GET['id'];
			
			echo '<br />Vous êtes ';
			echo $_SESSION['pseudo'];
			echo '<br /><a href="index.php?appel=deco&id=none">Déconnexion</a>';
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
			if ($connecte->dejaInscrit($nouveau_connecte)==0)
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
			$_SESSION['id']= $inscription->ajout($nouvel_inscrit);
			
			$_SESSION['connexion']=1;
			$_SESSION['pseudo']= $_POST['pseudo'];
			
			header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
			//echo $nouvel_inscrit->pseudo();
			//echo $nouvel_inscrit->mdp();
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
	      <p>Une redirection vers un formulaire de connexion ramenant vers la liste des abonnements sera implémentée</p>
	      <p><a href=\"index.php?appel=scan&id=1\">Émulation d'un scan du commerce 1</a></p>
	      <p><a href=\"index.php?appel=scan&id=2\">Émulation d'un scan du commerce 2</a></p>
	      <p><a href=\"index.php?appel=scan&id=3\">Émulation d'un scan du commerce 3</a></p>
	      <p><a href=\"index.php?appel=scan&id=4\">Émulation d'un scan du commerce 4</a></p>
	      <p><a href=\"index.php?appel=scan&id=5\">Émulation d'un scan du commerce 5</a></p>
	      <p><a href=\"org/admin.php\">Espace admin</a></p>";
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






/*


if (isset($_SESSION['connexion']) AND $_SESSION['connexion']==1)			//Si on est connecté
	{
	echo "<p>Bienvenue</p>";
	echo '<a href="index.php?appel=deco&id=none">Déconnexion</a> <br />';
	switch ($_GET['appel'])
		{
		case 'deco':
			$_SESSION['connexion']=0;
			session_destroy();
			header('Location: index.php?appel=liste&id=none');
			break;
		
		case 'liste':
			echo "Voici la liste de vos abonnements.";
			break;
		}
	}

else
	{
	if (isset($_GET['appel']) AND isset($_GET['id']))			//Si j'ai reçu des GET, je les transmets au formulaire.
		{
		echo 'test';
		include_once('includes/formulaire_auth.php');
		}
		
	else 			//Si je n'ai pas de GET, je dois être renvoyé au formulaire de connexion qui me renverra vers la liste des abo (utilisateur), vers l'interfaccom (commerçant)
				//ou vers l'interface admin (admin)
		{		
		echo "<p>Pas assez de variables</p>";
		}
	
	}

	


*/
?>