<?php

session_start();
include_once('../modeles/fonctions.php');
include_once('../modeles/Commerce.class.php');
include_once('../modeles/GestionCommerce.class.php');
include_once('../modeles/Gerant.class.php');
include_once('../modeles/GestionGerant.class.php');

$bandeau='None';
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
	try
		{
		include_once('vue_ajouter.php');
		}  
	catch (Exception $e)
		{
		throw new Exception( 'Le script plante.', 0, $e);
		}  
	
	}

else if (isset($_POST['ajouter']))
	{
	try
		{
		ajouterCommerce();
		}  
	catch (Exception $e)
		{
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

else if (isset($_POST['choix_modifier']))
	{
	// On récupère les données du commerce et du gérant correspondants
	$nouveau_commerce= new GestionCommerce (Outils_Bd::getInstance()->getConnexion());
	$commerce = $nouveau_commerce-> quereur ($_POST['idcom']); 	// $commerce est un array contenant toutes les données relatives à ce sujet.
	//var_dump($commerce);
	$nouveau_gerant = new GestionGerant (Outils_Bd::getInstance()->getConnexion());
	$gerant = $nouveau_gerant-> quereur ($_POST['idcom']);		// De même $gerant est un array contenant toutes les données du gérant du commerce correspondant.
	include_once('vue_modifier.php');
	}

else if (isset($_POST['modifier']))
	{
	modifierCommerce();
	}


else if (isset($_POST['choix_supprimer']))
	{
	supprimerCommerce($_POST['idcom']);
	}


else if (isset($_POST['bandeau']))
	{
	include_once('vue_bandeau.php');
	}

else if (isset($_POST['modifier_bandeau']))
	{
	$bandeau = modifierBandeau();
	header('Location: admin.php');
	echo $bandeau;
	}


else
	{
	include_once('vue_admin.php');
	}

echo '<footer><p><img src="../web/uploads/' . recupBandeau() . '" alt="Nearforge" title="Nearforge" /></p>';
	

?>



    </footer>



</body>


</html>