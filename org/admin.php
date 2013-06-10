<?php

session_start();
include_once('../modeles/fonctions.php');
include_once('../modeles/Commerce.class.php');
include_once('../modeles/GestionCommerce.class.php');
include_once('../modeles/Gerant.class.php');
include_once('../modeles/GestionGerant.class.php');
/*
####################################### Fragment HTML (En-tête) ##########################################
*/
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="user-scalable=no, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, width=device-width">
        <link href="../style/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../style/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <link href="../style/css/correction.css" rel="stylesheet" type="text/css">
        <title>Kuchikomi</title>
    </head>
 
    <body>
    
    <header class="page-header">
      <h1><a href="admin.php">KuchiKomi</a></h1>
    </header>

<?php
/*
###########################################################################################################
*/

//Pour le moment, l'admin doit pouvoir créer un commerce et son gérant.

if (isset($_POST['choix_ajouter']))
	{
	include_once('vue_ajouter.php');
	}

else if (isset($_POST['ajouter']))
	{
	ajouterCommerce();
	}

else if (isset($_POST['modifier']))
	{
	include_once('vue_modifier.php');
	echo $_POST['idcom'];;
	}


else if (isset($_POST['supprimer']))
	{
	include_once('vue_supprimer.php');
	echo $_POST['idcom'];;
	}


else if (isset($_POST['bandeau']))
	{
	include_once('vue_bandeau.php');
	}


else
	{
	include_once('vue_admin.php');
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
?>
