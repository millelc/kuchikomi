

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="../style/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../style/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <title>Kuchikomi</title>
    </head>
 
    <body>
    
    <header class="page-header">
      <h1><a href="index.php">KuchiKomi</a></h1>
    </header>





<?php


include_once('../includes/formulaire_auth.php');

?>



    
    <?php
	if ($bandeau=='None')
		{
		echo '<footer style="background-color: black; color: white;">Bandeau d\'information dynamique';
		}
	else
		{
		echo '<footer >';
		}

    
    ?>
    </footer>



</body>


</html>


