

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="user-scalable=no, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, width=device-width">
        <link href="../style/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../style/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <title>Kuchikomi</title>
    </head>
    
    <body>
    
	
		<header class="row" > <h1 class="span12"><a href="index.php">KuchiKomi</a></h1> </header>
		
		
		
		<?php
		include_once('../includes/formulaire_auth.php');
		?>
		
   
   
    
    






    <?php
	if ($bandeau=='None')
		{
		echo '<footer style="background-color: black; color: white; margin-top:25px;">Bandeau d\'information dynamique';
		}
	else
		{
		echo '<footer >';
		}
	echo '</footer>';

    
    ?>


</body>


</html>


