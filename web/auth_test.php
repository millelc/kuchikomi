<?php

echo 	'<form method="post" action="index.php?appel=';
echo $_GET['appel'];
echo '&amp;id=';
echo $_GET['id'];
echo '">
	<p>
	<label for="pseudo">Votre pseudo :</label><br />
	<input type="text" name="pseudo" id="pseudo" required /><br />
	<input type="submit" value="Connexion" name="connexion" class="btn btn-primary btn-small" />
	
	</p>
	</form>';









?>