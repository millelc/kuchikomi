<?php
// Cette classe s'occupe de toutes les actions possibles
// et souhaitées sur les abonnés.

include_once('Connexion.class.php');

class GestionAbonne
	{
	private $_bdd;
	
	public function __construct($bdd)
	// Le constructeur récupère l'instance de connexion.
		  {
		  $this->setBdd($bdd);
		  
		  }
	
	public function ajout(Abonne $perso)
	// Cette fonction ajoute simplement un abonné à la base.
		{
		try
			{			
			$q = $this->_bdd->prepare('INSERT INTO abonne (pseudo, adresse_ip) VALUES(?, ?)');
			$pseudo = $perso->pseudo();
			$adr = $perso->adresse_ip();
			$q->execute(array($pseudo, $adr));
			return $this->_bdd->lastInsertId();
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		
		}
		
	public function recupIdentifiant(Abonne $perso)
	// Cette fonction récupère l'identifiant de l'abonné
		{
		try
			{			
			$q = $this->_bdd->prepare('SELECT id_abonne FROM abonne WHERE pseudo = ?');
			$pseudo = $perso->pseudo();
			$q->execute(array($pseudo));
			$donnees = $q->fetch();
			return $donnees['id_abonne'];
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		
		}
	/*	
	public function desinscription($id)
	// Cette fonction DÉSACTIVE un abonné en mettant le champ « actif » à 0.
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
		
		
	public function dejaInscrit(Abonne $perso)
	// Cette fonction vérifie si un abonné est déjà dans la base.
		{
		$req = $this->_bdd->prepare('SELECT * FROM abonne WHERE pseudo = ?');
		$req->execute(array($perso->pseudo()));
		$donnees = $req->fetch();
		if ($donnees['id_abonne']=='')
		// Cet abonné n'existe  pas.
			{
			return 0;
			}
		else
			{
			if ($donnees['actif']==1)
					{
					// Abonné existant et actif
					return $donnees['id_abonne'];
					}
			else
				{
				// Abonné existant et inactif
				return 2;
				}
			}
		}
		
	public function connexion(Abonne $perso)
		{
		// Cette fonction prend en entrée un abonné qui aurait scanné un tag.
		// On commence par vérifier si l'utilisateur existe déjà.
			// Si oui, on le connecte et on met son identifiant en session.
			// Si non, on l'inscrit, on le connecte et on met son identifiant en session.
		echo 'je te connecte';
		$req = $this->_bdd->prepare('SELECT * FROM abonne WHERE pseudo = ?');
		$req->execute(array($perso->pseudo()));
		$donnees = $req->fetch();
		if ($donnees['id_abonne']=='')
		// L'abonné n'existe pas.donc, on le créé, on le connecte et on le redirige cers sa liste d'abonnements.
			{
			$nouvel_id = $this->ajout($perso);
			$_SESSION['connexion']=1;
			$_SESSION['pseudo']=$perso->pseudo();
			$_SESSION['id']= $nouvel_id;
			header('Location: index.php?appel=liste&id=none');
			}
		else
		// L'abonné existe donc on le connecte, on l'abonne et on le redirige vers sa liste d'abonnements si il est actif.
			{
			if ($donnees['actif']=='1')
				{
				echo 'l\'abonné existe.';
				$_SESSION['connexion']=1;
				$_SESSION['pseudo']=$perso->pseudo();
				$_SESSION['id']= $donnees['id_abonne'];
				header('Location: index.php?appel=abo&id=' . $_GET['id'] . '');
				}
			else
				{
				header('Location: index.php?appel=liste&id=none');
				}
			}
		}*/
	
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