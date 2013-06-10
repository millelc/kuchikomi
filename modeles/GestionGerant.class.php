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
		
		
	public function quelCommerce($id_gerant)		// Cette fonction récupère l'id du commerce du gérant.
		{
		$req = $this->_bdd->prepare('SELECT id_commerce FROM gerant WHERE id_gerant = ?');
		$req->execute(array($id_gerant));
		$donnees = $req->fetch();
		return $donnees['id_commerce'];
		}
		
	public function ajout (Gerant $gerant)
		{
		try
			{			
			$req = $this->_bdd->prepare('INSERT INTO gerant (pseudo, mot_de_passe, id_commerce) VALUES(?, ?, ?)');
			$req->execute(array($gerant->pseudo(), $gerant->mdp(), $gerant->id_commerce()));
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		}
	
	public function quereur ($id_commerce)	// Le quéreur récupère les données d'un commerce et renvoie l'array correspondant.
		{
		$req = $this->_bdd->prepare('SELECT * FROM gerant WHERE id_commerce = ?');
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