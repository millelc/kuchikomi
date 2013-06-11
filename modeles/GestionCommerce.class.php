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
 		
 	public function ajout (Commerce $commerce)
		{
		try
			{			
			$req = $this->_bdd->prepare('INSERT INTO commerce (nom, gerant, logo, image, horaires, num_tel, email, adresse, ligne_bus, arret, donnees_google_map, donnees_GPS) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
			$req->execute(array($commerce->nom(), $commerce->gerant(), $commerce->logo(), $commerce->image(), $commerce->horaires(), $commerce->num_tel(), $commerce->email(), $commerce->adresse(), $commerce->ligne_bus(), $commerce->arret(), $commerce->donnees_gm(), $commerce->donnees_gps()));
			return $this->_bdd->lastInsertId();
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		}
	
	public function modif (Commerce $commerce)
		{
		try
			{
			//var_dump($commerce);
			$req = $this->_bdd->prepare('UPDATE commerce SET nom = ?, gerant = ?, logo = ?, image = ?, horaires = ?, num_tel = ?, email = ?, adresse = ?, ligne_bus = ?, arret = ?, donnees_google_map = ?, donnees_GPS = ? WHERE id_commerce = ?');
			$req->execute(array($commerce->nom(), $commerce->gerant(), $commerce->logo(), $commerce->image(),  $commerce->horaires(), $commerce->num_tel(), $commerce->email(),  $commerce->adresse(), $commerce->ligne_bus(), $commerce->arret(), $commerce->donnees_gm(), $commerce->donnees_gps(), $commerce->id_commerce()));
			
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
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