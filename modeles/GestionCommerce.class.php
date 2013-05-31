<?php

include_once('../includes/configuration.php');
include_once('Connexion.class.php');





class GestionCommerce
	{
	private $_bdd;
	
	
	public function __construct($bdd)		// Le constructeur récupère l'instance de connexion.
		  {
		  $this->setBdd($bdd);
		  }
		  
	public function quereur ($id_commerce)	// Le quéreur récupère les données d'un commerce et renvoie l'array correspondant.
		{
		$req = $this->_bdd->prepare('SELECT * FROM commerce WHERE id_commerce = ?');
 		$req->execute(array($id_commerce));
 		$donnees = $req->fetch();
 		return $donnees;
 		}

	
	
################## Setters #########################	
	
	 public function setBdd(/*PDO*/ $bdd)
		{
		$this->_bdd = $bdd;
		}
  
#####################################################	
	

#################### Getters ########################

	public function bdd()
		{
		return $this->_bdd;
		}
		
#####################################################	
		
	}


?>