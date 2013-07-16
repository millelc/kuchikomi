<?php
include_once('fragments/entete.php'); 
echo '<br /><a style="margin-top: 15px;" class="btn btn-medium btn-info" href="index.php?appel=liste&amp;id=' . $kuchikomi[1] . '"><i class="icon-white icon-chevron-left"></i> Retour à la liste</a><br />';

$now = date("Y-m-d");

echo '<section style="border: 1px grey double; padding:10px; margin:10px;">';
recuplogo($kuchikomi['1']);
if ($now>$kuchikomi[4])
	{
	echo '<p>Cette offre n\'est plus disponible.</p>';
	}
else
	{
	echo '<p>Cette offre est valable du ' . date("d-m-Y", strtotime($kuchikomi['3'])) . ' au ' . date("d-m-Y", strtotime($kuchikomi['4'])) . '</p>';
	}

echo $kuchikomi['0'] . '<br />';
echo '<img src="images/' . $kuchikomi['5'] . '" style="width: 50%; margin:25px;" />';
echo '<a class="btn btn-medium btn-success"  style="margin-right: 50px;" href="index.php?appel=jaime&amp;id=' . $_GET['id'] . '"><i class="icon-white icon-thumbs-up"></i>J\'aime !</a>';
echo '<br />' . $kuchikomi['2'];
echo '</section>';
include_once('fragments/pied.php'); 

?>