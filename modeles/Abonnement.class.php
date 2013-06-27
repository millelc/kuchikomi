<?php
// Cette classe gère UNIQUEMENT
// les données concernant les abonnements

include_once('Connexion.class.php');

class Abonnement
	{
	private $_id_commerce;
	private $_id_abonne;
	private $_ladate;
	
	public function __construct(array $donnees)	// Le constructeur reçoit les données et passe la main à l'hydrateur
		{
		$this->hydrate($donnees);
		}
	
	public function hydrate (array $donnees)		// L'hydrateur récupère les données et les répartit dans l'objet
		{
		$this->setId_commerce($donnees['id_commerce']);
		$this->setId_abonne($donnees['id_abonne']);
		}
	
################## Setters #########################	
	private function setId_commerce($id)
		{
		$id = (int) $id;
		if ($id > 0)
			{
			$this->_id_commerce = $id;
			}
		}
	
	private function setId_abonne($id)
		{
		$id = (int) $id;
		if ($id > 0)
			{
			$this->_id_abonne = $id;
			}
		}
		
	private function setLadate($date)
		{
		$this->_ladate = $date;
		}
#####################################################			
	
	
#################### Getters ########################

	public function id_commerce()
		{
		return $this->_id_commerce;
		}
	
	public function id_abonne()
		{
		return $this->_id_abonne;
		}
	
	public function ladate()
		{
		return $this->_ladate;
		}
#####################################################	
	}

?>


