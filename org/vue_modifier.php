<?php


echo '
      <form action="admin.php?p=' . $commerce['image'] . '&amp;l=' . $commerce['logo'] . '" method="post" enctype="multipart/form-data">
      
      <p><label for="nom_com">Nom du commerce : <input type="text" name="nom_com" id="nom_com" autofocus required placeholder="Obligatoire" value="' . $commerce['nom'] . '" /></label></p>
      
      <p><label for="nom_gerant">Nom du gérant : <input type="text" name="nom_gerant" id="nom_gerant" required placeholder="Obligatoire" value="' . $commerce['gerant'] . '" /></label></p>
      
      <p><label for="mdp">Mot de passe : <input type="text" name="mdp" id="mdp" required placeholder="Obligatoire" value="' . $gerant['mot_de_passe'] . '" /></label></p>
      
      <p><label for="logo">Logo du magasin :<br /> <input type="file" name="logo" id="logo" /></label></p>
      
      <p><label for="photo">Photo du magasin :<br /> <input type="file" name="photo" id="photo" /></label></p>
      
      <p><label for="horaires">Horaires : <input type="text" name="horaires" id="horaires" required placeholder="Obligatoire" value="' . $commerce['horaires'] . '" /></label></p>
            
      <p><label for="num_tel">Téléphone : <input type="tel" name="num_tel" id="num_tel" required placeholder="Obligatoire" value="' . $commerce['num_tel'] . '" /></label></p>
      
      <p><label for="email">E-mail : <input type="email" name="email" id="email" required placeholder="Obligatoire" value="' . $commerce['email'] . '" /></label></p>
      
      <p><label for="adresse">Adresse du commerce : <input type="text" name="adresse" id="adresse" required placeholder="Obligatoire" value="' . $commerce['adresse'] . '" /></label></p>
      
      <p><label for="ligne_bus">Ligne de bus : <input type="number" name="ligne_bus" id="ligne_bus" required placeholder="Obligatoire" value="' . $commerce['ligne_bus'] . '" /></label></p>
      
      <p><label for="arret">Arrêt de bus : <input type="text" name="arret" id="arret" required placeholder="Obligatoire" value="' . $commerce['arret'] . '" /></label></p>
      
      <input class="btn btn-medium btn-success" type="submit" style="margin-right: 50px;" value="Modifier" name="modifier" />
      </form>';

?>