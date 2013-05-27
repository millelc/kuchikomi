<?php


include_once('Connexion.class.php');
include("../includes/configuration.php");



class Abonnement
	{
	protected $id_commerce;
	protected $id_abonne;
	
	
	public function abonner()
		{
		echo $this->id_commerce;
		echo $this->id_abonne;
		
		try
			{
			$bdd = Outils_Bd::getInstance()->getConnexion();
			//$req = $bdd->prepare('INSERT INTO abonne (pseudo, mot_de_passe) VALUES(?, ?)');
			//$req->execute(array($_POST['pseudo'], $_POST['pwd']));
			
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		}
	
	}



?>