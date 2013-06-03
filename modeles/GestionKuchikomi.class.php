<?php

include_once('../includes/configuration.php');
include_once('Connexion.class.php');





class GestionAbonne
	{
	private $_bdd;
	
	
	public function __construct($bdd)		// Le constructeur récupère l'instance de connexion.
		  {
		  $this->setBdd($bdd);
		  
		  }

	public function ajout(Abonne $perso)	// Cette fonction ajoute simplement un abonné à la base.
		{
		try
			{			
			$q = $this->_bdd->prepare('INSERT INTO abonne (pseudo, mot_de_passe) VALUES(?, ?)');
			$q->execute(array($perso->pseudo(), $perso->mdp()));
			return $this->_bdd->lastInsertId();			
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		
		}
		
	public function desinscription($id)	// Cette fonction DÉSACTIVE un abonné en mettant le champ « actif » à 0.
		{
		try
			{
			echo 'Désinscription en cours.';
			$req = $this->_bdd->prepare('UPDATE abonne SET actif = 0 WHERE id_abonne = ?');
 			$req->execute(array($id));
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		
		}
		
		
	public function dejaInscrit(Abonne $perso)		// Cette fonction vérifie si un abonné est déjà dans la base.
		{
		$req = $this->_bdd->prepare('SELECT * FROM abonne WHERE pseudo = ?');
		$req->execute(array($perso->pseudo()));
		$donnees = $req->fetch();
		echo '<br />';
		if ($donnees['id_abonne']=='')				// Cet abonné n'existe  pas.
			{
			return 0;
			}
		else
			{
			if ($perso->mdp()==$donnees['mot_de_passe'])						// Cet aboné existe mais est-ce le bon mot de passe ?
				{
				if ($donnees['actif']==1)
					{
					return $donnees['id_abonne'];								// Oui, c'est le bon mot de passe.
					}
				else
					{
					echo 'Utilisateur inactif';
					}
				}
			else
				{
				return 0;
				}
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