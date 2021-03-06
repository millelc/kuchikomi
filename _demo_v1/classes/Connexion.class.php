<?php
// Singleton fournissant la connexion à la base de données.
// Une seule instance de connexion pour tous.
// Évite de surcharger la base de données.

class Outils_Bd {
  // Pour être sûr qu'il n'y a qu'une et une seule instance.
  private static $instance;

  // Le lien de connexion BD (objet PDO).
  protected $connexion;

  // Constructeur privé qui initialise la connexion.
  private function __construct() {
    // Création d'un objet PDO avec les constantes définies dans la configuration.
    $this->connexion = new PDO('mysql:host=localhost;dbname=kuchikomi', 'root', 'Vuwa2tha');
    // Mettre Exception comme mode d'erreur.
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  // Clonage impossible.
  private function __clone() {}

  //Accéder à l'UNIQUE instance de la classe.
  static public function getInstance() {
    if (! (self::$instance instanceof self)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  // Accesseur de la connexion.
  public function getConnexion() {
    return $this->connexion;
  }
}
?>
