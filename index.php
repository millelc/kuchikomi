<?php
session_start();
if (isset($_GET['appel']) AND isset($_GET['id']))
{
header('Location: web/index.php?appel=' . $_GET['appel'] . '&id=' . $_GET['id'] . '');
}

else
{
header('Location: web/index.php');
}

?>
 
