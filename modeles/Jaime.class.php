<?php
// Cette classe gère UNIQUEMENT
// les données des « J'aime ».

include_once('Connexion.class.php');

class Jaime
	{
	private $_id_abonne;
	private $_id_kuchikomi;
	private $_ladate;
	
	public function __construct(array $donnees)
	//Le constructeur reçoit les données et passe la main à l'hydrateur
		{
		$this->hydrate($donnees);
		}
	
	public function hydrate (array $donnees)
	// L'hydrateur récupère l'array et en répartit les données dans l'objet
		{
		$this->setId_abonne($donnees['id_abonne']);
		$this->setId_kuchikomi($donnees['id_kuchikomi']);
		}
	
################## Setters #########################	
	
	private function setId_abonne($id_abonne)
		{
		$id_abonne = (int) $id_abonne;
		if ($id_abonne > 0)
			{
			$this->_id_abonne = $id_abonne;
			}
		}
	
	private function setId_kuchikomi($id_kuchikomi)
		{
		$id_kuchikomi = (int) $id_kuchikomi;
		if ($id_kuchikomi > 0)
			{
			$this->_id_kuchikomi = $id_kuchikomi;
			}
		}
	
	private function setLadate($ladate)
		{
		if (is_string($ladate))
			{
			$this->_ladate = $ladate;
			}
		}
	
#################### Getters ########################

	public function id_abonne()
		{
		return $this->_id_abonne;
		}
	
	public function id_kuchikomi()
		{
		return $this->_id_kuchikomi;
		}
	
	public function ladate()
		{
		return $this->_ladate;
		}
	
#####################################################	
	}
?>