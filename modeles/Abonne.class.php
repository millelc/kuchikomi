<?php


include_once('Connexion.class.php');



// Tout commenter 

class Abonne
	{
	private $_id;
	private $_pseudo;
	private $_mdp;
	
	public function __construct(array $donnees) //Le constructeur reçoit les données et passe la main à l'hydrateur
		{
		$this->hydrate($donnees);
		}
	
	public function hydrate (array $donnees)	// L'hydrateur récupère l'array et en répartit les données dans l'objet
		{
		$this->setPseudo($donnees['pseudo']);
		$this->setMdp($donnees['mdp']);
		
		}
	
	
	
################## Setters #########################	
	
	
	private function setId($id)
		{
		$id = (int) $id;
		if ($id > 0)
			{
			$this->_id = $id;
			}
		}
		
	
	private function setPseudo($pseudo)
		{
		if (is_string($pseudo))
			{
			$this->_pseudo = $pseudo;
			}
		}
		
	private function setMdp($mdp)
		{
		if (is_string($mdp))
			{
			$this->_mdp = $mdp;
			}
		}
	
	
	
	
#################### Getters ########################

	public function id()
		{
		return $this->_id;
		}
	
	public function pseudo()
		{
		return $this->_pseudo;
		}
	
	public function mdp()
		{
		return $this->_mdp;
		}
#####################################################	
	
	
	}






?>