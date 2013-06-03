<?php



/*
####################################### Fragment HTML (en-tête) #####################################
*/



echo '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../style/proto.css" />
        <title>KuchiKomi</title>
    </head>
 
    <body>
    <header>
      <p><a href="index.php">KuchiKomi</a></p>
    </header>
    <body>';



/*
#####################################################################################################
*/


if (isset($_SESSION['commerçant']) AND $_SESSION['commerçant']==1)
	{
	echo 'Hello world';
	}
	
else
	{
	echo 'Espace réservé aux commerçants';
	}

?>