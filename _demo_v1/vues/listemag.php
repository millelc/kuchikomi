<?php
include_once('fragments/entete.php');


echo '<a class="btn btn-medium btn-success"  style="margin-right: 50px;" href="index.php?appel=contact&amp;id=' . $_GET['id'] . '"><i class="icon-white icon-envelope"></i> Contacter</a>';

echo '<br /><a style="margin-top: 15px;" class="btn btn-medium btn-info" href="index.php?appel=liste&amp;id=none"><i class="icon-white icon-chevron-left"></i> Vos abonnements</a><br />';
echo '<p><br />Voici la liste des kuchikomi de ce commerce :</p>';

$now = date("Y-m-d");
while ($donnees = $listeKuchikomi->fetch())
  {
  if ($now>$donnees[8])
    {
    //echo '<p>Cette offre n\'est plus disponible.</p>';
    }
  else
    {
    recuplogo($_SESSION['commerce_consulte']);
    echo '<section style="border: 1px grey double; padding:10px; margin:10px;" id="' . $donnees['id_kuchikomi']  . '">';
    echo '<p>Cette offre est valable du ' . date("d-m-Y", strtotime($donnees['date_debut'])) . ' au ' . date("d-m-Y", strtotime($donnees['date_fin'])) . '</p>';
    echo '<a href="index.php?appel=kk&amp;id=' . $donnees['id_kuchikomi'] .    '" style="text-decoration: none;" >';
    echo $donnees['texte'] . '<br />';
    echo '<img src="images/' . $donnees['photo'] . '" style="width: 50%; margin:25px;" />';
    echo '<a class="btn btn-medium btn-success"  style="margin-left: 50px;" href="index.php?appel=jaime&amp;id=' . $donnees['id_kuchikomi'] . '|listemag"><i class="icon-white icon-thumbs-up"></i>J\'aime !</a>';
    echo '<br />' . $donnees['mentions'];
    echo '</a>';
    echo '</section>';
    }
  }

echo '<a class="btn btn-medium btn-info" style="margin-right: 15px;" href="index.php?&amp;appel=desabo&amp;id=' . $_GET['id'] . '">Se désabonner</a>';



include_once('fragments/pied.php');
?>
