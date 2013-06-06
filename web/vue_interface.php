

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
      <h1><a href="espmarc.php">KuchiKomi</a></h1>
    </header>





<?php


echo '<p><br /><a class="btn btn-medium btn-info margin:auto;" href="espmarc.php?appel=stats">Vos statistiques</a></p>
      <form action="espmarc.php?appel=interface" method="post" enctype="multipart/form-data">
      <textarea name="texte" id="texte" rows="5" >Tapez votre alerte shopping ici.</textarea>
      <p><label for="photokk">Ajouter une photo :<br /> <input type="file" name="photokk" id="photokk" /></label></p>
      
      <p><label for="date_debut">Date de début :<br /> <input type="date" name="date_debut" id="date_debut" class="input-medium" /></label></p>
      
      <p><label for="date_fin">Date de fin :<br />  <input type="date" name="date_fin" id="date_fin" class="input-medium" /></label></p>
      
      
      <textarea name ="mentions" id="mentions" rows="5">Conditions particulières, mentions légales, etc...</textarea>
      <br />
      <input class="btn btn-medium btn-success" type="submit" style="margin-right: 50px;" value="Envoyer" />';

echo '<a class="btn btn-medium btn-warning" href="espmarc.php?appel=deco&amp;id=none">Déconnexion</a>';



if ($bandeau=='None')
	{
	echo '<footer style="background-color: black; color: white;">Pas de bandeau choisi';
	}
else
	{
	echo '<footer><p><img src="../style/NearforgeLogo1eCom-ePub.png" alt="Nearforge" title="Nearforge" /></p>';
	}
	

?>



    </footer>



</body>


</html>


