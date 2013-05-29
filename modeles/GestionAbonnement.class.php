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







/*
class Abonne
	{
	protected $_id;
	protected $_pseudo;
	protected $_mdp;
	
	
	
	public function __construct($id)
		{
		try
			{
			$bdd = Outils_Bd::getInstance()->getConnexion();
			$req = $bdd->prepare('SELECT * from abonne WHERE id_abonne = ?');
			$req->execute(array($id));
			while ($donnees = $req->fetch())
				{
				echo $donnees['id_abonne'];
				echo '<br />';
				echo $donnees['pseudo'];
				echo '<br />';
				echo $donnees['mot_de_passe'];
				echo '<br />';
				echo $_SESSION['connexion'];
				echo '<br />';
				*/
				
				
				
				
				
				/*
				$_SESSION['id'] = this->$_id;
				$_SESSION['pseudo'] = this->$_pseudo;
				$_SESSION['mdp'] = this->$_mdp;
				echo $_SESSION['connexion'];
				echo '<br />';
				echo $_SESSION['id'];
				echo '<br />';
				echo $_SESSION['pseudo'];
				echo '<br />';
				echo $_SESSION['mdp'];
				echo '<br />';*/
				
				/*
				}
			$req->closeCursor();
			
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		}
		
	
	
	public function ajout()  //Cette méthode ajoute un nouvel inscrit dans la base.
		{
		try
			{
			$bdd = Outils_Bd::getInstance()->getConnexion();
			$req = $bdd->prepare('INSERT INTO abonne (pseudo, mot_de_passe) VALUES(?, ?)');
			$req->execute(array($_POST['pseudo'], $_POST['pwd']));
			
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		}
	
	}

*/

?>