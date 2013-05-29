<?php

include_once('includes/configuration.php');
include_once('Connexion.class.php');





class GestionAbonnement
	{
	private $_bdd;
	
	
	public function __construct($bdd)
		  {
		  $this->setBdd($bdd);
		  
		  }

	public function ajout(Abonnement $abo)
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
		
	public function dejaAbonne(Abonnement $abo)
		{
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
		
		
	public function commerceExistant(Abonnement $abo)
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
		
	private function incremente(Abonnement $abo)
		{
		$idcom=$abo->id_commerce();
		echo '<br />J\'incrémente ';
		echo $idcom;
		$req = $this->_bdd->prepare('UPDATE commerce SET nb_abonnes = nb_abonnes+1 WHERE id_commerce = ?');
		$req->execute(array($idcom));
		echo '<br /<Variable incrémentée.<br />';
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