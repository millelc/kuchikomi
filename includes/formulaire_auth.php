<?php

// Ce formulaire d'authentification ne sert
// qu'à connecter ou inscrire des ABONNÉS.
// Il s'agit d'une roue de secours pour des
// et vérifications.

echo 	'<form method="post" action="index.php?appel=liste&id=none">
	<p>
	<label for="id">Votre identifiant :</label><br />
	<input type="text" name="id" id="id" required /><br />
	<input type="submit" value="Connexion" name="connexion" class="btn btn-primary btn-small" />
	<input type="submit" value="Inscription" name="inscription" class="btn btn-primary btn-small" />
	</p>
	</form>';
?>