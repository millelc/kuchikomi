<?php
// Cette classe s'occupe de toutes les actions possibles
// et souhaitées sur les appéciations de commerce.

include_once('../includes/configuration.php');
include_once('Connexion.class.php');

class GestionJaime
	{
	private $_bdd;
	
	public function __construct($bdd)
	
		  {
		  $this->setBdd($bdd);
		  }

	public function ajout(Jaime $jaime)	// Cette fonction ajoute un abonnement à la table.
		{
		if ($this->Aimedeja($jaime)==True)
			{
                        echo 'déjà trouvé';
			return False;
			}

		else
			{
			try
				{
				$q = $this->_bdd->prepare('INSERT INTO jaime
				(id_abonne, id_kuchikomi, date) VALUES(?, ?, NOW())');
				$q->execute(array($jaime->id_abonne(), $jaime->id_kuchikomi()));
				}
			
			catch (Exception $e)
				{
				die('Erreur : ' . $e->getMessage());
				}
			}
		}
	
	public function Aimedeja(Jaime $jaime)
	// Cette fonction ajoute un abonnement à la table.
		{
		$req = $this->_bdd->prepare('SELECT * FROM jaime
		WHERE id_abonne = ? AND id_kuchikomi = ?');
 		$req->execute(array($jaime->id_abonne(), $jaime->id_kuchikomi()));
 		while ($donnees = $req->fetch())
 			{
 			if ($donnees['id_abonne']==$jaime->id_abonne())
				{
				return True;
				}
 			}
		return False;
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
