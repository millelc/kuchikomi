<?php

include_once('../includes/configuration.php');
include_once('Connexion.class.php');





class GestionAbonnement
	{
	private $_bdd;
	
	
	public function __construct($bdd)		// Le constructeur récupère l'instance de connexion.
		  {
		  $this->setBdd($bdd);
		  
		  }

	public function ajout(Abonnement $abo)	// Cette fonction ajoute un abonnement à la table.
		{
		try
			{
			$q = $this->_bdd->prepare('INSERT INTO abonnement (id_abonne, id_commerce, date) VALUES(?, ?, NOW())');
			$q->execute(array($abo->id_abonne(), $abo->id_commerce()));
			$this->incremente($abo);
			}
			
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		
		}
	
	
	public function suppr(Abonnement $abo)	// Cette fonction supprime un abonnement de la table.
		{
		try
			{
			$q = $this->_bdd->prepare('DELETE FROM abonnement WHERE id_abonne = ? AND id_commerce=?');
			$q->execute(array($abo->id_abonne(), $abo->id_commerce()));
			$this->decremente($abo);
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
		
	private function incremente(Abonnement $abo)	// Cette fonction incrémete le compteur du nombre d'abonnés d'un commerce de la base.
		{
		$idcom=$abo->id_commerce();
		echo '<br />J\'incrémente ';
		echo $idcom;
		$req = $this->_bdd->prepare('UPDATE commerce SET nb_abonnes = nb_abonnes+1 WHERE id_commerce = ?');
		$req->execute(array($idcom));
		echo '<br /<Variable incrémentée.<br />';
		}
		
	private function decremente(Abonnement $abo)	// Cette fonction décrémete le compteur du nombre d'abonnés d'un commerce de la base.
		{
		$idcom=$abo->id_commerce();
		echo '<br />Je décrémente ';
		echo $idcom;
		$req = $this->_bdd->prepare('UPDATE commerce SET nb_abonnes = nb_abonnes-1 WHERE id_commerce = ?');
		$req->execute(array($idcom));
		echo '<br /<Variable décrémentée.<br />';
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