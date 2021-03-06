<?php
include_once('fragments/entete.php'); 


echo '<br />Voici la liste de vos abonnements :<br /> ';

// D'abord on affiche la liste des logos des abonnements.
foreach($listeAbo as $cle => $valeur)
{
echo '<table style="float:left;"><a href="index.php?appel=liste&amp;id=' . $cle . '"><img src="images/' . $valeur . '" alt="Logo commerce" title="Logo commerce" style="width: 75px; margin-left: 20px; margin-top:10px; border: 1px black outset;" /></a>' .$listeKkActifs[$cle] . '';
}
echo '</table>';


// Ensuite on affiche les kuchikomi les plus récents.
$now = date("Y-m-d");
while ($donnees = $derniersKKConfondus->fetch())
{
echo '<section style="border: 1px grey double; padding:10px; margin:10px;" id="' . $donnees['id_kuchikomi']  . '">';
if ($now<$donnees['date_fin'])
  {
  echo '<p>Cette offre est valable du ' . date("d-m-Y", strtotime($donnees['date_debut'])) . ' au ' . date("d-m-Y", strtotime($donnees['date_fin'])) . '</p>';
  }
else
{
  echo '<p>Cette offre s\'est achevée le  ' . date("d-m-Y", strtotime($donnees['date_fin'])) . '</p>';
}
recuplogo($donnees['id_commerce']);  // Je triche : la vue n'est pas censée dialoguer avec le modèle.
echo '<a href="index.php?appel=kk&amp;id=' . $donnees['id_kuchikomi'] .    '" style="text-decoration: none;" >';
echo '<br />   ' . $donnees['texte'] . '<br />';
echo '<img src="images/' . $donnees['photo'] . '" style="width: 50%; margin:25px;" />';
echo '<table><tr><td><a class="btn btn-medium btn-success" href="index.php?appel=jaime&amp;id=' . $donnees['id_kuchikomi'] . '|listeconf"><i class="icon-white icon-thumbs-up"></i>J\'aime !</a></td></tr></table>';
echo '<br />' . $donnees['mentions'];
echo '</a></section>';
}


include_once('fragments/pied.php'); 
?>
