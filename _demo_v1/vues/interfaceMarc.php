<?php
// Cette vue est réservée aux commerçants
// Elle affiche une interface permettant de poster
// un kuchikomi.

include_once('fragments/enteteMarc.php');

$now = date("Y-m-d");
echo '<section>
	<p><br /><a class="btn btn-medium btn-info margin:auto;" href="espmarc.php"><i class="icon-white icon-chevron-left"></i> Retour</a></p>
      <form action="espmarc.php?appel=interface" method="post" enctype="multipart/form-data">
      <textarea name="texte" id="texte" rows="5" >Tapez votre alerte shopping ici.</textarea>
      <p><label for="photokk">Ajouter une photo (2Mo maximum) :<br /> <input type="file" name="photokk" id="photokk" /></label></p>
      <p><label for="date_debut">Date de début :<br /> <input type="date" name="date_debut" id="date_debut" value="' . $now . 	'" class="input-medium" /></label></p>
      <p><label for="date_publi">Date de publication :<br /> <input type="date" name="date_publi" id="date_publi" value="' . $now . 	'" class="input-medium" /></label></p>
      <p><label for="date_fin">Date de fin :<br />  <input type="date" name="date_fin" id="date_fin" value="' . $now . 	'" class="input-medium" /></label></p>
      <textarea name ="mentions" id="mentions" rows="5">Conditions particulières, mentions légales, etc...</textarea>
      <br />
      <input class="btn btn-medium btn-success" type="submit" style="margin-right: 50px;" value="Envoyer" />
      </form>';
      
include_once('fragments/pied.php');
?>