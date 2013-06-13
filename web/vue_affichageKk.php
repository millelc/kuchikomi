<?php
include_once('../includes/entete.php');

echo '<br /><a style="margin-top: 15px;" class="btn btn-medium btn-info" href="index.php?appel=liste&amp;id=' . $kuchikomi[1] . '"><i class="icon-white icon-chevron-left"></i> Retour à la liste</a><br />';


echo '<p><br /><br />' . $kuchikomi[0] . '<br /><br /><br /><br /></p>';

echo '<a class="btn btn-medium btn-success"  style="margin-right: 50px;" href="index.php?appel=jaime&amp;id=' . $_GET['id'] . '"><i class="icon-white icon-thumbs-up"></i>J\'aime !</a>';
echo '<a class="btn btn-medium btn-success" href="">Faites passer !<i class="icon-white icon-hand-right"></i></a>';

include_once('../includes/pied.php');

?>