<?php

include_once('includes/configuration.php');
include_once('Connexion.class.php');





class GestionAbonne
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
			$q = $this->_bdd->prepare('INSERT INTO abonnement (id_abonne, id_commerce, date) VALUES(?, ?, ?)');
			$q->execute(array($abo->id_abonne(), $abo->id_commerce(), $abo->date()));
			
			
			}
		catch (Exception $e)
			{
			die('Erreur : ' . $e->getMessage());
			}
		
		}
		/*
	public function dejaInscrit(Abonne $perso)
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
				return $donnees['id_abonne'];								// Oui, c'est le bon mot de passe.
				}
			else
				{
				return 0;
				}
			}
		}
*/
  
	
	
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