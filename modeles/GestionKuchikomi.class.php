<?php
// Cette classe s'occupe de toutes les actions possibles
// et souhaitées sur les commerces.

include_once('../includes/configuration.php');
include_once('Connexion.class.php');

class GestionKuchikomi
	{
	private $_bdd;
	
	public function __construct($bdd)
	// Le constructeur récupère l'instance de connexion.
		  {
		  $this->setBdd($bdd);
		  }

	public function ajout(Kuchikomi $kk)
	// Cette fonction ajoute simplement un abonné à la base.
		{
		try
			{
			$q = $this->_bdd->prepare('INSERT INTO kuchikomi
			(id_commerce, mentions, texte, photo, date_debut, date_fin)
			VALUES(?, ?, ?, ?, ?, ?)');
			$q->execute(array($kk->id_commerce(), $kk->mentions(),
			$kk->texte(), $kk->image(), $kk->date_debut(), $kk->date_fin() ));
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