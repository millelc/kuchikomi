<?php

//
// Simple page de redirection en cas de manipulation d'url
// ou d'arrivée ici par défaut.
// À terme, un système de contrôle pourra être implémenté
// ici-même.

session_start();
header('Location: web/index.php?appel=' . $_GET['appel'] . '&id=' . $_GET['id'] . '');

?>