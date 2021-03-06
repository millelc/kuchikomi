<?php
// Cette classe gère UNIQUEMENT
// les données des Kuchikomi.

include_once('Connexion.class.php');

class Kuchikomi
	{
	private $_id_kuchikomi;
	private $_id_commerce;
	private $_texte;
	private $_image;
	private $_date_debut;
	private $_date_fin;
	private $_date_publication;
	private $_mentions;
	
	public function __construct(array $donnees)
	//Le constructeur reçoit les données et passe la main à l'hydrateur
		{
		$this->hydrate($donnees);
		}
	
	public function hydrate (array $donnees)
	// L'hydrateur récupère l'array et en répartit les données dans l'objet
		{
		$this->setId_commerce($donnees['id_commerce']);
		$this->setMentions($donnees['mentions']);
		$this->setTexte($donnees['texte']);
		$this->setImage($donnees['image']);
		$this->setDate_debut($donnees['date_debut']);
		$this->setDate_fin($donnees['date_fin']);
		$this->setDate_publication($donnees['date_publication']);
		if (isset($donnees['image']))
			{
			$this->setImage($donnees['image']);
			}
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
	
	private function setTexte($texte)
		{
		if (is_string($texte))
			{
			$this->_texte = $texte;
			}
		}
		
	private function setImage($image)
		{
		if (is_string($image))
			{
			$this->_image = $image;
			}
		}
	
	private function setDate_debut($date_debut)
		{
		$this->_date_debut = $date_debut;
		}
	
	private function setDate_fin($date_fin)
		{
		$this->_date_fin = $date_fin;
		}
	
	private function setDate_publication($date_publication)
		{
		$this->_date_publication = $date_publication;
		}
	
	private function setMentions($mentions)
		{
		if (is_string($mentions))
			{
			$this->_mentions = $mentions;
			}
		}
	
#################### Getters ########################

	public function id_kuchikomi()
		{
		return $this->_id_kuchikomi;
		}
	
	public function id_commerce()
		{
		return $this->_id_commerce;
		}
	
	public function texte()
		{
		return $this->_texte;
		}
	
	public function image()
		{
		return $this->_image;
		}
	
	public function date_debut()
		{
		return $this->_date_debut;
		}
	
	public function date_fin()
		{
		return $this->_date_fin;
		}
	
	public function date_publication()
		{
		return $this->_date_publication;
		}
	
	public function mentions()
		{
		return $this->_mentions;
		}
#####################################################	
	}
?>