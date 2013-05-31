-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 31 Mai 2013 à 12:21
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

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
(17, 'user17', 'user17'),
(18, 'user18', 'user18'),
(19, 'user19', 'user19'),
(20, 'user20', 'user20'),
(22, 'user21', 'user21');

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE IF NOT EXISTS `abonnement` (
  `id_abonne` int(10) unsigned NOT NULL,
  `id_commerce` mediumint(8) unsigned NOT NULL,
  `date` datetime NOT NULL,
  KEY `id_abonne` (`id_abonne`,`id_commerce`),
  KEY `id_commerce` (`id_commerce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `abonnement`
--

INSERT INTO `abonnement` (`id_abonne`, `id_commerce`, `date`) VALUES
(10, 4, '2013-05-28 00:00:00'),
(11, 4, '2013-05-28 00:00:00'),
(1, 4, '2013-05-28 00:00:00'),
(2, 2, '2013-05-28 00:00:00'),
(1, 2, '2013-05-28 00:00:00'),
(5, 5, '2013-05-28 00:00:00'),
(7, 1, '2013-05-28 00:00:00'),
(8, 1, '2013-05-28 16:50:11'),
(2, 3, '2013-05-28 16:56:38'),
(6, 1, '2013-05-28 17:07:36'),
(6, 2, '2013-05-29 08:44:38'),
(19, 3, '2013-05-29 15:02:11'),
(20, 1, '2013-05-29 15:02:39'),
(20, 5, '2013-05-29 15:02:47'),
(21, 1, '2013-05-29 16:03:28'),
(6, 3, '2013-05-29 16:18:04'),
(22, 3, '2013-05-29 16:20:02'),
(4, 1, '2013-05-31 09:04:13'),
(1, 1, '2013-05-31 11:09:14');

-- --------------------------------------------------------

--
-- Structure de la table `commerce`
--

CREATE TABLE IF NOT EXISTS `commerce` (
  `id_commerce` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `id_statut` tinyint(3) unsigned NOT NULL,
  `nom` varchar(100) NOT NULL,
  `gerant` varchar(75) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `horaires` varchar(25) NOT NULL,
  `num_tel` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `ligne_bus` tinyint(3) unsigned NOT NULL,
  `arret` varchar(100) NOT NULL,
  `nb_abonnes` mediumint(8) unsigned NOT NULL,
  `donnees_google_map` text NOT NULL,
  `donnees_GPS` text NOT NULL,
  PRIMARY KEY (`id_commerce`),
  KEY `id_statut` (`id_statut`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `commerce`
--

INSERT INTO `commerce` (`id_commerce`, `id_statut`, `nom`, `gerant`, `logo`, `image`, `horaires`, `num_tel`, `email`, `adresse`, `ligne_bus`, `arret`, `nb_abonnes`, `donnees_google_map`, `donnees_GPS`) VALUES
(1, 1, 'nom-commerce1', 'gerant1', 'logo-commerce1', 'image-commerce1', 'horaires-commerce1', 'numtel-commerce1', 'email-commerce1', 'adresse1', 1, 'arret-commerce1', 4, 'données google map commerce 1', 'données GPS commerce 1'),
(2, 2, 'nom_commerce2', 'gerant2', 'logo-commerce2', 'image-commerce2', 'horaires-commerce2', 'num_tél-commerce2', 'email-commerce2', 'adresse2', 2, 'arret 2', 0, 'Données gm c2', 'données gps 2'),
(3, 3, 'nom commerce3', 'gerant3', 'logo-commerce3', 'image-commerce3', 'horaires-commerce3', 'numtel-commerce3', 'email-commerce3', 'adresse3', 3, 'arret-commerce3', 2, 'données gm commerce3', 'données gps commerce3'),
(4, 0, 'nom-commerce4', 'gerant4', 'logo-commerce4', 'image-commerce4', 'horaires-commerce4', 'numtél-commerce4', 'email-commerce4', 'adresse4', 4, 'arret-commerce4', 1, 'données google map du commerce4', 'données gps du commerce4'),
(5, 5, 'nom_commerce5', 'gerant5', 'logo-commerce5', 'image-commerce5', 'horaires-commerce5', 'num_tél-commerce5', 'email-commerce5', 'adresse5', 5, 'arret5', 2, 'données gm commerce 5', 'données gps commerce5');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `kuchikomi`
--

INSERT INTO `kuchikomi` (`id_kuchikomi`, `id_commerce`, `texte_alerte`, `texte`, `photo`, `date_debut`, `date_fin`, `nb_jaime`, `nb_passe`) VALUES
(1, 1, 'texte-alerte_du_kuchikomi du commerce_1', 'texte du kuchikomi 1 du commerce 1', 'photo du kuchikomi 1 du commerce 1', '0000-00-00', '0000-00-00', 0, 0),
(2, 1, 'texte alerte du kuchikomi 2 du commerce 1', 'texte du kuchikomi 2 du commerce 1', 'photo du kuchikomi 2 du commerce 1', '0000-00-00', '0000-00-00', 0, 0),
(3, 1, 'texte alerte du kuchikomi 3 du commerce 1', 'texte du kuchikomi 3 du commerce 1', 'photo du kuchikomi 3 du commerce 1', '0000-00-00', '0000-00-00', 0, 0),
(4, 1, 'texte alerte du kuchikomi 4 du commerce 1', 'texte du kuchikomi 4 du commerce 1', 'photo du kuchikomi 4 du commerce 1', '0000-00-00', '0000-00-00', 0, 0),
(5, 2, 'texte alerte du kuchikomi 1 du commerce 2', 'texte du kuchikomi 1 du commerce 2', 'photo du kuchikomi 1 du commerce 2', '0000-00-00', '0000-00-00', 0, 0),
(6, 2, 'texte alerte du kuchikomi 2 du commerce 2', 'texte du kuchikomi 2 du commerce 2', 'photo du kuchikomi 2 du commerce 2', '0000-00-00', '0000-00-00', 0, 0),
(7, 3, 'texte alerte du kuchikomi 1 du commerce 3', 'texte du kuchikomi 1 du commerce 3', 'photo du kuchikomi 1 du commerce 3', '0000-00-00', '0000-00-00', 0, 0),
(8, 3, 'texte alerte du kuchikomi 2 du commerce 3', 'texte du kuchikomi 2 du commerce 3', 'photo du kuchikomi 2 du commerce 3', '0000-00-00', '0000-00-00', 0, 0),
(9, 3, 'texte alerte du kuchikomi 3 du commerce 3', 'texte du kuchikomi 3 du commerce 3', 'photo du kuchikomi 3 du commerce 3', '0000-00-00', '0000-00-00', 0, 0),
(10, 4, 'texte alerte du kuchikomi 1 du commerce 4', 'texte du kuchikomi 1 du commerce 4', 'photo du kuchikomi 1 du commerce 4', '0000-00-00', '0000-00-00', 0, 0),
(11, 5, 'texte alerte du kuchikomi 1 du commerce 5', 'texte du kuchikomi 1 du commerce 5', 'photo du kuchikomi 1 du commerce 5', '0000-00-00', '0000-00-00', 0, 0);

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
