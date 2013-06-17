<?php

echo 	'<form method="post" action="index.php?appel=scan&id=' . $_GET['id'] . '">
	<p>
	<label for="id">Votre identifiant :</label><br />
	<input type="text" name="id" id="id" required /><br />
	<input type="submit" value="Connexion" name="connexion" class="btn btn-primary btn-small" />
	<input type="submit" value="Inscription" name="inscription" class="btn btn-primary btn-small" />
	</p>
	</form>';









?>