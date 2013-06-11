<?php


echo '
      <p>Que voulez-vous faire ?</p>
      
      <form method="post" action="admin.php">
      <input type="submit" value="Ajouter un commerce ?" name="choix_ajouter" />
      </form>
      
      <form method="post" action="admin.php">
      <input type="submit" value="Modifier un commerce ?" name="choix_modifier" />
      <input type="number" name="idcom" required placeholder="Identifiant du commerce" />
      </form>
      
      <form method="post" action="admin.php">
      <input type="submit" value="Supprimer un commerce ?" name="choix_supprimer" />
      <input type="number" name="idcom" required placeholder="Identifiant du commerce" />
      </form>
      
      <form action="admin.php" method="post" enctype="multipart/form-data">
      
      <p><label for="bandeau">Nouveau bandeau :<br /> <input type="file" name="bandeau" id="bandeau" required /></label></p>
      
      <input class="btn btn-medium btn-success" type="submit" style="margin-right: 50px;" value="Modifier le bandeau" name="modifier_bandeau" />
      </form>
      ';

recupererStats();      
      
?>
