<?php

session_start();

include_once('modeles/Abonne.class.php');
include_once('modeles/GestionAbonne.class.php');


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
      <p><a href="index.php?appel=scan&id=1">KuchiKomi</a></p>
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
		echo "<p>Vous êtes connecté et vous avez envoyé un appel.</p>";
		}
	
	else									//Les variables ont été reçues et on n'est pas connecté.
		{
		
		if (isset($_POST['connexion']))					//Variables reçues, non connecté mais formulaire de connexion rempli.
			{
			echo "<br />Vous avez choisi de vous connecter.";
			$nouveau_connecte= new Abonne(array('pseudo' => $_POST['pseudo'], 'mdp' => $_POST['pwd'] ));
			}
			
			
		else if (isset($_POST['inscription']))				//Variables reçues, non connecté mais formulaire d'inscription rempli.
			{
			echo "<br />Vous avez choisi de vous inscrire.";
			$nouvel_inscrit= new Abonne(array('pseudo' => $_POST['pseudo'], 'mdp' => $_POST['pwd'] ));
			$connexion = Outils_Bd::getInstance()->getConnexion();
			$inscription= new GestionAbonne($connexion);
			$inscription->ajout($nouvel_inscrit);
			
			
			
			
			
			
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
	      <p><a href=\"index.php?appel=scan&id=1\">Émulation d'un scan</a></p>";
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