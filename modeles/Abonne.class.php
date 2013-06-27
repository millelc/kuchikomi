<?php
// La classe abonné gère UNIQUEMENT les
// données propres aux abonnés.

include_once('Connexion.class.php');

class Abonne
	{
	private $_id;
	private $_pseudo;
	private $_adresse_ip;
	private $_actif;
	
	public function __construct(array $donnees)
	//Le constructeur reçoit les données et passe la main à l'hydrateur
		{
		$this->hydrate($donnees);
		}
	
	public function hydrate (array $donnees)
	// L'hydrateur récupère l'array et en répartit les données dans l'objet
		{
		if (isset($donnees['pseudo']))
			{
			$this->setPseudo($donnees['pseudo']);
			}		
		if (isset($donnees['mdp']))
			{
			$this->setMdp($donnees['mdp']);
			}
		if (isset($donnees['adresse_ip']))
			{
			$this->setAdresse_ip($donnees['adresse_ip']);
			}
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
		
	private function setAdresse_ip($adresse_ip)
		{
		$this->_adresse_ip = $adresse_ip;
		}
	
	private function setActif($actif)
		{
		if (is_bool($actif))
			{
			$this->_actif = $actif;
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
	
	public function actif()
		{
		return $this->_actif;
		}
	
	public function adresse_ip()
		{
		return $this->_adresse_ip;
		}
#####################################################	
	}
?>