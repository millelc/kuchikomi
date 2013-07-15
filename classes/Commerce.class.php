<?php
// Cette classe gère UNIQUEMENT
// les données concernant les commerces.

include_once('Connexion.class.php');

class Commerce
	{
	private $_id_commerce;
	private $_nom;
	private $_gerant;
	private $_logo;
	private $_image;
	private $_horaires;
	private $_num_tel;
	private $_email;
	private $_ligne_bus;
	private $_arret;
	private $_nb_abonnes;
	private $_donnees_gm;
	private $_donnees_gps;
	
	public function __construct(array $donnees)	// Le constructeur reçoit les données et passe la main à l'hydrateur
		{
		$this->hydrate($donnees);
		}
	
	public function hydrate (array $donnees)		// L'hydrateur récupère les données et les répartit dans l'objet
		{
		if (isset($donnees['id_commerce']))
			{
			$this->setId_commerce($donnees['id_commerce']);
			}
		$this->setNom($donnees['nom']);
		$this->setGerant($donnees['gerant']);
		$this->setLogo($donnees['logo']);
		$this->setImage($donnees['image']);
		$this->setHoraires($donnees['horaires']);
		$this->setNum_tel($donnees['num_tel']);
		$this->setEmail($donnees['email']);
		$this->setAdresse($donnees['adresse']);
		$this->setLigne_bus($donnees['ligne_bus']);
		$this->setArret($donnees['arret']);
		if (isset($donnees['donnees_google_map']))
			{
			$this->setDonnes_gm($donnees['donnees_google_map']);
			}
		else
			{
			$this->setDonnes_gm('Non renseigné');
			}
		if (isset($donnees['donnees_GPS']))
			{
			$this->setDonnes_gps($donnees['donnees_GPS']);
			}
		else
			{
			$this->setDonnes_gps('Non renseigné');
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
	
	private function setNom($nom)
		{
		if (is_string($nom))
			{
			$this->_nom = $nom;
			}
		}
		
	private function setGerant($gerant)
		{
		if (is_string($gerant))
			{
			$this->_gerant = $gerant;
			}
		}	
		
	private function setLogo($logo)
		{
		if (is_string($logo))
			{
			$this->_logo = $logo;
			}
		}
	
	private function setImage($image)
		{
		if (is_string($image))
			{
			$this->_image = $image;
			}
		}
	private function setHoraires($horaires)
		{
		if (is_string($horaires))
			{
			$this->_horaires = $horaires;
			}
		}
	
	private function setNum_tel($num_tel)
		{
		if (is_string($num_tel))
			{
			$this->_num_tel = $num_tel;
			}
		}
	
	private function setEmail($email)
		{
		if (is_string($email))
			{
			$this->_email = $email;
			}
		}
		
	private function setAdresse($adresse)
		{
		if (is_string($adresse))
			{
			$this->_adresse = $adresse;
			}
		}
	
	private function setLigne_bus($ligne)
		{
		$ligne = (int) $ligne;
		if ($ligne > 0)
			{
			$this->_ligne_bus = $ligne;
			}
		}
	
	private function setArret($arret)
		{
		if (is_string($arret))
			{
			$this->_arret = $arret;
			}
		}
	
	private function setDonnes_gm($donnees_gm)
		{
		if (is_string($donnees_gm))
			{
			$this->_donnees_gm = $donnees_gm;
			}
		}
	
	private function setDonnes_gps($donnees_gps)
		{
		if (is_string($donnees_gps))
			{
			$this->_donnees_gps = $donnees_gps;
			}
		}	
#################### Getters ########################
	public function id_commerce()
		{
		return $this->_id_commerce;
		}
	
	public function nom()
		{
		return $this->_nom;
		}
	
	public function gerant()
		{
		return $this->_gerant;
		}
	
	public function logo()
		{
		return $this->_logo;
		}
		
	public function image()
		{
		return $this->_image;
		}
			
	public function horaires()
		{
		return $this->_horaires;
		}
	
	public function num_tel()
		{
		return $this->_num_tel;
		}
	
	public function email()
		{
		return $this->_email;
		}
	
	public function adresse()
		{
		return $this->_adresse;
		}
	
	public function ligne_bus()
		{
		return $this->_ligne_bus;
		}
	
	public function arret()
		{
		return $this->_arret;
		}	
	
	public function donnees_gm()
		{
		return $this->_donnees_gm;
		}
	
	public function donnees_gps()
		{
		return $this->_donnees_gps;
		}
#####################################################	
	}
?>