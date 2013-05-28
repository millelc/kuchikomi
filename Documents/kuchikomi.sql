-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 28 Mai 2013 à 15:15
-- Version du serveur: 5.5.27
-- Version de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `kuchikomi`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonne`
--

CREATE TABLE IF NOT EXISTS `abonne` (
  `id_abonne` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `mot_de_passe` varchar(200) NOT NULL,
  PRIMARY KEY (`id_abonne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `abonne`
--

INSERT INTO `abonne` (`id_abonne`, `pseudo`, `mot_de_passe`) VALUES
(1, 'user1', 'user1'),
(2, 'user2', 'user2'),
(3, 'user3', 'user3'),
(4, 'user4', 'user4'),
(5, 'user5', 'user5'),
(6, 'user6', 'user6'),
(7, 'user7', 'user7'),
(8, 'user8', 'user8'),
(9, 'user9', 'user9'),
(10, 'user10', 'user10'),
(11, 'user11', 'user11'),
(12, 'user12', 'user12'),
(13, 'user13', 'user13'),
(14, 'user14', 'user14'),
(15, 'user15', 'user15'),
(16, 'user16', 'user16'),
(17, 'user17', 'user17');

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE IF NOT EXISTS `abonnement` (
  `id_abonne` int(10) unsigned NOT NULL,
  `id_commerce` mediumint(8) unsigned NOT NULL,
  `date` date NOT NULL,
  KEY `id_abonne` (`id_abonne`,`id_commerce`),
  KEY `id_commerce` (`id_commerce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `abonnement`
--

INSERT INTO `abonnement` (`id_abonne`, `id_commerce`, `date`) VALUES
(10, 4, '2013-05-28'),
(9, 8, '2013-05-28'),
(11, 4, '2013-05-28'),
(1, 4, '2013-05-28'),
(2, 2, '2013-05-28'),
(4, 6, '2013-05-28');

-- --------------------------------------------------------

--
-- Structure de la table `commerce`
--

CREATE TABLE IF NOT EXISTS `commerce` (
  `id_commerce` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `id_statut` tinyint(3) unsigned NOT NULL,
  `nom` varchar(100) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `horaires` varchar(25) NOT NULL,
  `num_tel` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `ligne_bus` tinyint(3) unsigned NOT NULL,
  `arret` varchar(100) NOT NULL,
  `nb_abonnes` mediumint(8) unsigned NOT NULL,
  `donnees_google_map` text NOT NULL,
  `donnees_GPS` text NOT NULL,
  PRIMARY KEY (`id_commerce`),
  KEY `id_statut` (`id_statut`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `commerce`
--

INSERT INTO `commerce` (`id_commerce`, `id_statut`, `nom`, `logo`, `image`, `horaires`, `num_tel`, `email`, `ligne_bus`, `arret`, `nb_abonnes`, `donnees_google_map`, `donnees_GPS`) VALUES
(4, 0, 'commerce1', 'logo-commerce1', 'image-commerce1', 'horaires-commerce1', 'numtél-commerce1', 'email-commerce1', 1, 'arrêt-commerce1', 0, 'données google map du commerce1', 'données gps du commerce1');

-- --------------------------------------------------------

--
-- Structure de la table `gerant`
--

CREATE TABLE IF NOT EXISTS `gerant` (
  `id_gerant` mediumint(8) unsigned NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `mot_de_passe` varchar(50) NOT NULL,
  PRIMARY KEY (`id_gerant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `jaime`
--

CREATE TABLE IF NOT EXISTS `jaime` (
  `id_abonne` int(10) unsigned NOT NULL,
  `id_kuchikomi` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  KEY `id_abonne` (`id_abonne`,`id_kuchikomi`),
  KEY `id_kuchikomi` (`id_kuchikomi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `kuchikomi`
--

CREATE TABLE IF NOT EXISTS `kuchikomi` (
  `id_kuchikomi` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_commerce` mediumint(9) unsigned NOT NULL,
  `texte_alerte` varchar(200) NOT NULL,
  `texte` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nb_jaime` mediumint(9) NOT NULL,
  `nb_passe` mediumint(9) NOT NULL,
  PRIMARY KEY (`id_kuchikomi`),
  KEY `id_commerce` (`id_commerce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `passe`
--

CREATE TABLE IF NOT EXISTS `passe` (
  `id_abonne` int(10) unsigned NOT NULL,
  `id_kuchikomi` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  KEY `id_abonne` (`id_abonne`,`id_kuchikomi`),
  KEY `id_kuchikomi` (`id_kuchikomi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `quigerequoi`
--

CREATE TABLE IF NOT EXISTS `quigerequoi` (
  `id_commerce` mediumint(8) unsigned NOT NULL,
  `id_gerant` mediumint(8) unsigned NOT NULL,
  KEY `id_commerce` (`id_commerce`,`id_gerant`),
  KEY `id_gerant` (`id_gerant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE IF NOT EXISTS `statut` (
  `id_statut` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nom_statut` varchar(50) NOT NULL,
  `descriptif` text NOT NULL,
  PRIMARY KEY (`id_statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `gerant`
--
ALTER TABLE `gerant`
  ADD CONSTRAINT `gerant_ibfk_1` FOREIGN KEY (`id_gerant`) REFERENCES `quigerequoi` (`id_gerant`);

--
-- Contraintes pour la table `jaime`
--
ALTER TABLE `jaime`
  ADD CONSTRAINT `jaime_ibfk_1` FOREIGN KEY (`id_abonne`) REFERENCES `abonne` (`id_abonne`),
  ADD CONSTRAINT `jaime_ibfk_2` FOREIGN KEY (`id_kuchikomi`) REFERENCES `kuchikomi` (`id_kuchikomi`);

--
-- Contraintes pour la table `kuchikomi`
--
ALTER TABLE `kuchikomi`
  ADD CONSTRAINT `kuchikomi_ibfk_1` FOREIGN KEY (`id_commerce`) REFERENCES `commerce` (`id_commerce`);

--
-- Contraintes pour la table `passe`
--
ALTER TABLE `passe`
  ADD CONSTRAINT `passe_ibfk_1` FOREIGN KEY (`id_abonne`) REFERENCES `abonne` (`id_abonne`),
  ADD CONSTRAINT `passe_ibfk_2` FOREIGN KEY (`id_kuchikomi`) REFERENCES `kuchikomi` (`id_kuchikomi`);

--
-- Contraintes pour la table `quigerequoi`
--
ALTER TABLE `quigerequoi`
  ADD CONSTRAINT `quigerequoi_ibfk_1` FOREIGN KEY (`id_commerce`) REFERENCES `commerce` (`id_commerce`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
