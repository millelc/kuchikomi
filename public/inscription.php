<?php

session_start();

if (isset($_GET['appel']) AND isset($_GET['id']))
	{
	if (isset($_POST['pseudo']) AND isset($_POST['pwd']))
		{
		echo "J'ai reçu des variables";
		echo $_POST['pseudo'];
		echo $_POST['pwd'];
		include_once('../modeles/Abonne.class.php');
		$nouvel_arrive = new Abonne(1);
		$nouvel_arrive->ajout();
		$_SESSION['connexion'] = 1;
		echo 'test';
		header('Location: ../index.php?appel=' . $_GET['appel'] . '&id=' . $_GET['id'] . '');
		}
		
	else				// Si le formulaire n'a pas encore été rempli.
		{
		echo "Formulaire d'inscription";
		echo '<form method="post" action="inscription.php?appel=';
		echo $_GET['appel'];
		echo '&id=';
		echo $_GET['id'];
		echo '">';
		echo '<p>
			<label for="pseudo">Votre pseudo :</label>
			<input type="text" name="pseudo" id="pseudo" />
			<br />
			<label for="pwd">Votre mot de passe :</label>
			<input type="password" name="pwd" id="pwd" />
			</p>
			<br />
			<input type="submit" value="Inscription" />
			</form>';
		}
	}
	
else
	{
	echo 'Pas assez de variables';
	}


	


	
?>