<?php

echo 	'<form method="post" action="index.php?appel=';
echo $_GET['appel'];
echo '&id=';
echo $_GET['id'];
echo '">
	<p>
	<label for="pseudo">Votre pseudo :</label><br />
	<input type="text" name="pseudo" id="pseudo" required /><br />
	<label for="pwd">Votre mot de passe :</label><br />
	<input type="password" name="pwd" id="pwd" required /><br />
	<input type="submit" value="Connexion" name="connexion" class="btn btn-primary btn-small" />
	<input type="submit" value="Inscription" name="inscription" class="btn btn-primary btn-small" />
	</p>
	</form>';









?>