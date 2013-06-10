<?php

echo '<p>Ici seront mises des statistiques générales.</p>
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
      
      <form method="post" action="admin.php">
      <input type="submit" value="Modifier le bandeau ?" name="bandeau" />
      </form>
      
      ';

?>
