<?php


include_once('Connexion.class.php');



class Abonnement
	{
	private $_id_commerce;
	private $_id_abonne;
	private $_date;
	
	public function __consctruct(array $donnees)
		{
		echo "Appel de la classe d'abonnement réussi.";
		$this->hydrate($donnees);
		}
	
	public function hydrate (array $donnees)
		{
		$this->setId_commerce($donnees['id_commerce']);
		$this->setId_abonne($donnees['id_abonne']);
		$this->setDate($donnees['date']);
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
		
	private function setDate($date)
		{
		$this->_id_date = $date;
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
	
	public function date()
		{
		return $this->_date;
		}
#####################################################	
	
	}



	
	
	
	
	
	
	
?>


