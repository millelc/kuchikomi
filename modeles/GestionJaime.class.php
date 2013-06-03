<?php

include_once('../includes/configuration.php');
include_once('Connexion.class.php');





class GestionJaime
	{
	private $_bdd;
	
	
	public function __construct($bdd)		// Le constructeur récupère l'instance de connexion.
		  {
		  $this->setBdd($bdd);
		  
		  }

	public function ajout(Jaime $jaime)	// Cette fonction ajoute un abonnement à la table.
		{
		if ($this->Aimedeja($jaime)==True)
			{
			echo 'test';
			return False;
			}
			
		else
			{
			try
				{
				echo 'test2';
				$q = $this->_bdd->prepare('INSERT INTO jaime (id_abonne, id_kuchikomi, date) VALUES(?, ?, NOW())');
				$q->execute(array($jaime->id_abonne(), $jaime->id_kuchikomi()));
				}
			
			catch (Exception $e)
				{
				die('Erreur : ' . $e->getMessage());
				}
		
			}
		
		}
	
	public function Aimedeja(Jaime $jaime)	// Cette fonction ajoute un abonnement à la table.
		{
		$req = $this->_bdd->prepare('SELECT * FROM jaime WHERE id_abonne = ? AND id_kuchikomi = ?');
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
	
	
	
	
	
	
	
	public function suppr(Abonnement $abo)	// Cette fonction supprime un abonnement de la table.
		{
		try
			{
			$q = $this->_bdd->prepare('DELETE FROM abonnement WHERE id_abonne = ? AND id_commerce=?');
			$q->execute(array($abo->id_abonne(), $abo->id_commerce()));
			}
			
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		
		}
		
	
	public function supprtotale($id_abonne)	// Cette fonction supprime un abonnement de la table.
		{
		try
			{
			$q = $this->_bdd->prepare('DELETE FROM abonnement WHERE id_abonne = ?');
			$q->execute(array($id_abonne));
			}
			
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		
		}
	
	
	
	
	public function dejaAbonne(Abonnement $abo)	// Cette fonction vérifie si un abonné est déjà dans la table
		{					// ATTENTION ! False signifie que l'abonné est l'est déjà et True que l'abonné ne l'est pas.
 		$req = $this->_bdd->prepare('SELECT * FROM abonnement WHERE id_abonne = ?');
 		$req->execute(array($abo->id_abonne()));
 		while ($donnees = $req->fetch())
 			{
 			if ($donnees['id_commerce']==$abo->id_commerce())
				{
				return False;
				}
 			}
 		return True;
		}
		
		
	public function commerceExistant(Abonnement $abo)	// Cette fonction vérifie que le commerce existe bien dans la base.
		{
		$idcom=$abo->id_commerce();
		$req = $this->_bdd->prepare('SELECT id_commerce FROM commerce WHERE id_commerce = ?');
		$req->execute(array($idcom));
		while ($donnees = $req->fetch())
 			{
 			return True;
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