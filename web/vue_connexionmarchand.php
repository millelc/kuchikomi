<?php
// Cette vue est réservée aux marchands.
// Elle leur permet de s'authentifier en cas
// de perte de leur carte

include_once('../includes/entete.php');

echo 'Espace réservé aux commerçants.';
echo 	'<form method="post" action="espmarc.php?appel=interface">
	<p>
	<label for="pseudo">Votre identifiant :</label>
	<input type="text" name="pseudo" id="pseudo" />
	<label for="pwd">Votre mot de passe :</label>
	<input type="password" name="pwd" id="pwd" /><br />
	<input type="submit" value="Connexion commerçants" name="connexionmarchande" />
	</p>
	</form>';

include_once('../includes/pied.php');
?>