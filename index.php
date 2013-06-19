<?php

session_start();
header('Location: web/index.php?appel=' . $_GET['appel'] . '&id=' . $_GET['id'] . '');


?>