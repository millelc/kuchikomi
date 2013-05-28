<?php


include_once('Connexion.class.php');
//include("includes/configuration.php");





class Abonne
	{
	private $_id;
	private $_pseudo;
	private $_mdp;
	
	public function __construct(array $donnees)
		{
		echo "Appel de la classe réussi.";
		$this->hydrate($donnees);
		}
	
	public function hydrate (array $donnees)
		{
		$this->setPseudo($donnees['pseudo']);
		$this->setMdp($donnees['mdp']);
		
		}
	
	
	
################## Setters #########################	
	
	
	private function setId($id)
		{
		$id = (int) $id;
		if ($id > 0)
			{
			$this->_id = $id;
			}
		}
		
	
	private function setPseudo($pseudo)
		{
		if (is_string($pseudo))
			{
			$this->_pseudo = $pseudo;
			}
		}
		
	private function setMdp($mdp)
		{
		if (is_string($mdp))
			{
			$this->_mdp = $mdp;
			}
		}
	
	
	
	
#################### Getters ########################

	public function id()
		{
		return $this->_id;
		}
	
	public function pseudo()
		{
		return $this->_pseudo;
		}
	
	public function mdp()
		{
		return $this->_mdp;
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