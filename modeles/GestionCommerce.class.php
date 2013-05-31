<?php

include_once('../includes/configuration.php');
include_once('Connexion.class.php');





class GestionCommerce
	{
	private $_bdd;
	
	
	public function __construct($bdd)
		  {
		  $this->setBdd($bdd);
		  echo 'Classe de GestionCommerce lancée.';
		  }
		  
	public function quereur ($id_commerce)
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