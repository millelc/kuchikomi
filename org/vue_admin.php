<?php

echo '<p>Ici seront mises des statistiques générales.</p>
      <p>Que voulez-vous faire ?</p>
      
      <form method="post" action="admin.php">
      <input type="submit" value="Ajouter un commerce ?" name="choix_ajouter" />
      </form>
      
      <form method="post" action="admin.php">
      <input type="submit" value="Modifier un commerce ?" name="modifier" />
      <input type="number" name="idcom" />
      </form>
      
      <form method="post" action="admin.php">
      <input type="submit" value="Supprimer un commerce ?" name="supprimer" />
      <input type="number" name="idcom" />
      </form>
      
      <form method="post" action="admin.php">
      <input type="submit" value="Modifier le bandeau ?" name="bandeau" />
      </form>
      
      ';

?>
