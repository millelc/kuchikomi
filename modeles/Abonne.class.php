<?php


include_once('Connexion.class.php');
//include("includes/configuration.php");





class Abonne
	{
	private $_id;
	private $_pseudo;
	private $_mdp;
	
	public function __construct(array $donnees)
		{
		echo "Appel de la classe réussi.";
		$this->hydrate($donnees);
		}
	
	public function hydrate (array $donnees)
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