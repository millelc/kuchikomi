<?php

include_once('../includes/configuration.php');
include_once('Connexion.class.php');





class GestionGerant
	{
	private $_bdd;
	
	
	public function __construct($bdd)		// Le constructeur récupère l'instance de connexion.
		  {
		  $this->setBdd($bdd);
		  
		  }

		
	public function existe(Gerant $gerant)		// Cette fonction vérifie si un abonné est déjà dans la base.
		{
		$req = $this->_bdd->prepare('SELECT * FROM gerant WHERE pseudo = ?');
		$req->execute(array($gerant->pseudo()));
		$donnees = $req->fetch();
		echo '<br />';
		if ($donnees['id_gerant']=='')				// Cet abonné n'existe  pas.
			{
			return 0;
			}
		else
			{
			if ($gerant->mdp()==$donnees['mot_de_passe'])						// Cet abonné existe mais est-ce le bon mot de passe ?
				{
				$id_du_gerant=$donnees['id_gerant'];
				return $id_du_gerant;								// Oui, c'est le bon mot de passe.
				}
				
			else
				{
				return 0;									// Mauvais mot de passe.
				}
			}
		
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