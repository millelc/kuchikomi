-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 20 Juin 2013 à 16:50
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
  `adresse_ip` varchar(25) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_abonne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=136 ;

--
-- Contenu de la table `abonne`
--

INSERT INTO `abonne` (`id_abonne`, `pseudo`, `adresse_ip`, `actif`) VALUES
(1, 'user1', '', 0),
(2, 'user2', '', 0),
(3, 'user3', '', 0),
(4, 'user4', '', 0),
(5, 'user5', '', 0),
(6, 'user6', '', 1),
(7, 'user7', '', 1),
(8, 'user8', '', 1),
(9, 'user9', '', 1),
(10, 'user10', '', 1),
(11, 'user11', '', 1),
(12, 'user12', '', 1),
(13, 'user13', '', 1),
(14, 'user14', '', 1),
(15, 'user15', '', 0),
(16, 'user16', '', 0),
(17, 'user17', '', 1),
(18, 'user18', '', 1),
(19, 'user19', '', 1),
(134, 'f2f84d9da6a87126', '192.168.1.251', 1),
(135, '355921043022829', '192.168.1.251', 1);

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
(7, 1, '2013-05-28 00:00:00'),
(8, 1, '2013-05-28 16:50:11'),
(2, 3, '2013-05-28 16:56:38'),
(19, 3, '2013-05-29 15:02:11'),
(20, 1, '2013-05-29 15:02:39'),
(20, 5, '2013-05-29 15:02:47'),
(21, 1, '2013-05-29 16:03:28'),
(6, 3, '2013-05-29 16:18:04'),
(22, 3, '2013-05-29 16:20:02'),
(4, 1, '2013-05-31 09:04:13'),
(23, 1, '2013-02-28 13:18:48'),
(23, 2, '2013-05-31 13:21:37'),
(3, 2, '2013-05-31 17:04:32'),
(3, 1, '2013-05-31 17:34:18'),
(4, 2, '2013-05-31 17:36:17'),
(10, 2, '2013-06-03 16:36:28'),
(12, 2, '2013-06-04 09:54:46'),
(12, 1, '2013-06-04 09:57:06'),
(13, 1, '2013-06-04 10:02:43'),
(13, 2, '2013-06-04 10:02:53'),
(14, 1, '2013-06-04 10:03:25'),
(17, 2, '2012-10-04 10:18:50'),
(18, 2, '2012-08-04 10:19:13'),
(18, 1, '2013-06-05 10:57:23'),
(6, 5, '2013-06-05 15:01:37'),
(6, 1, '2013-06-05 16:50:13'),
(20, 2, '2013-06-06 09:27:58'),
(25, 1, '2013-06-06 10:31:27'),
(20, 4, '2013-06-06 11:11:20'),
(25, 2, '2013-06-06 11:48:11'),
(22, 2, '2013-06-06 13:31:38'),
(26, 3, '2013-06-06 14:09:11'),
(26, 1, '2013-06-06 14:10:44'),
(2, 1, '2013-06-06 14:15:21'),
(27, 1, '2013-06-06 14:18:49'),
(26, 2, '2013-06-06 14:31:50'),
(24, 1, '2013-06-06 15:39:32'),
(28, 1, '2013-06-06 15:54:41'),
(28, 2, '2013-06-06 15:54:45'),
(30, 1, '2013-06-07 09:56:13'),
(34, 1, '2013-06-07 10:22:44'),
(35, 1, '2013-06-10 09:03:09'),
(35, 2, '2013-06-11 12:07:32'),
(36, 2, '2013-06-11 15:36:55'),
(36, 1, '2013-06-11 16:41:56'),
(24, 2, '2013-06-12 10:41:54'),
(38, 1, '2013-06-12 13:26:00'),
(38, 4, '2013-06-12 13:28:41'),
(38, 5, '2013-06-12 13:28:45'),
(38, 2, '2013-06-12 13:32:43'),
(39, 1, '2013-06-12 15:37:02'),
(39, 2, '2013-06-12 16:06:51'),
(39, 3, '2013-06-12 16:06:54'),
(39, 4, '2013-06-12 16:06:57'),
(39, 5, '2013-06-12 16:06:59'),
(40, 3, '2013-06-12 16:07:32'),
(40, 5, '2013-06-12 16:07:51'),
(39, 6, '2013-06-12 16:10:27'),
(40, 6, '2013-06-12 16:10:33'),
(40, 7, '2013-06-12 16:10:37'),
(40, 8, '2013-06-12 16:10:41'),
(40, 9, '2013-06-12 16:10:44'),
(40, 10, '2013-06-12 16:10:48'),
(40, 11, '2013-06-12 16:10:52'),
(39, 7, '2013-06-12 16:16:06'),
(39, 8, '2013-06-12 16:16:08'),
(39, 9, '2013-06-12 16:16:10'),
(39, 10, '2013-06-12 16:16:11'),
(39, 11, '2013-06-12 16:16:13'),
(41, 2, '2013-06-13 12:01:12'),
(11, 1, '2013-06-13 12:08:20'),
(11, 3, '2013-06-13 12:09:59'),
(11, 2, '2013-06-13 12:10:16'),
(42, 3, '2013-06-13 14:12:55'),
(41, 1, '2013-06-13 15:07:59'),
(40, 2, '2013-06-14 11:22:56'),
(40, 1, '2013-06-14 16:42:31'),
(42, 2, '2013-06-17 11:07:27'),
(49, 1, '2013-06-17 11:31:50'),
(51, 3, '2013-06-17 11:51:44'),
(51, 2, '2013-06-17 11:51:48'),
(55, 3, '2013-06-17 11:53:46'),
(55, 2, '2013-06-17 11:53:54'),
(51, 1, '2013-06-17 11:55:55'),
(67, 2, '2013-06-18 13:45:59'),
(67, 1, '2013-06-18 13:46:03'),
(85, 4, '2013-06-18 17:02:38'),
(6, 2, '2013-06-19 09:55:51'),
(21, 2, '2013-06-20 11:50:49'),
(21, 3, '2013-06-20 13:36:13'),
(134, 2, '2013-06-20 15:24:28'),
(134, 1, '2013-06-20 15:28:36');

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
  `horaires` varchar(100) NOT NULL,
  `num_tel` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `ligne_bus` tinyint(3) unsigned NOT NULL,
  `arret` varchar(100) NOT NULL,
  `donnees_google_map` text NOT NULL,
  `donnees_GPS` text NOT NULL,
  PRIMARY KEY (`id_commerce`),
  KEY `id_statut` (`id_statut`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `commerce`
--

INSERT INTO `commerce` (`id_commerce`, `id_statut`, `nom`, `gerant`, `logo`, `image`, `horaires`, `num_tel`, `email`, `adresse`, `ligne_bus`, `arret`, `donnees_google_map`, `donnees_GPS`) VALUES
(1, 0, 'Le Pion Magique', 'Pascal Descartes', '48e4185672aee9f9efeb460b53a9092a.jpg', '6926c31eed1d61a6c9ecc3a2ce32a57f.jpg', 'de 10H Ã  19H', '02 31 85 17 77', 'pionmagique@pionm.com', '13 Rue de Bras, 14000 Caen', 4, 'Arret Place Saint-Pierre', 'Non renseignÃ©', 'Non renseignÃ©'),
(2, 0, 'Le nouveau cafÃ©', 'Marcel Durand', '7fced08644922c9af4468d0ab8e81253.png', 'a2f29c9287aec3e9d6388df886fbd873.png', 'de 09H30 Ã  19H', '02 31 45 89 74', 'marcel@nouveaucafe.fr', '3 rue du cafÃ© 14 000 Caen', 5, 'Rue du cafÃ©', 'Non renseignÃ©', 'Non renseignÃ©'),
(3, 0, 'DEVRED', 'Alexandre Poniatovski', '282f90647da1b8a6fb9b8431ba246cb7.jpg', 'c1663578f9fb2f9d034a12b97dbcd0e9.jpg', '09H30 Ã  19H 7/7', '02 31 85 08 81', 'devred@devred.com', '36 Rue Saint-Jean, 14000 Caen', 10, 'ArrÃªt PathÃ©', 'Non renseignÃ©', 'Non renseignÃ©'),
(4, 0, 'Plein Ciel', 'Joseph Murat', '6eb29491b15b9a2c0f510c8cd4523c4c.jpg', 'a3446111138b92e4adea42b936536fe5.jpg', '10H-19H sauf le lundi 14H/19H', '02 31 86 58 00', 'pleinciel@pleinciel.com', 'Place Pierre Bouchard 14000 Caen', 4, 'arrÃªt St Pierre', 'Non renseignÃ©', 'Non renseignÃ©'),
(5, 0, 'FNAC', 'Gédéon Spilett', 'fc238c036474e21cc90d5864c526ac39.jpg', 'd77658240ad30884da9df62ba01162a4.jpg', 'de 09H Ã  19H 7/7', '0 825 02 00 20', 'fnac@fnac.com', 'centre Paul-Doumer, rue de Bras, 14000 Caen', 4, 'arrÃªt rue de bras', 'Non renseignÃ©', 'Non renseignÃ©'),
(6, 0, 'H&M', 'Arne Saknussem', 'e7ae30263f7d1178fd3a0c2d81dc5ffe.jpg', 'b05cfc02928aa0e81636f5f859db0ff8.jpg', '10H-13H 14H-20H', '02 31 27 98 00', 'hetm@hetm.com', '53 Rue Saint-Pierre, 14000 Caen', 4, 'ArrÃªt Saint-Pierre', 'Non renseignÃ©', 'Non renseignÃ©'),
(7, 0, 'C&A', 'Otto Lindenbrock', '92a8ffa2a0b64d8cdaa17dcea281f96f.jpg', '25c0b70ad7a39147f42c6077d0c3ba85.jpg', '09H30-19H 6J/7J', '02 31 90 45 74', 'ceta@ceta.com', 'Boulevard du MarÃ©chal Leclerc 14000 Caen', 7, 'ArrÃªt MarÃ©chal Leclerc', 'Non renseignÃ©', 'Non renseignÃ©'),
(8, 0, 'McDonald''s', 'GÃ©dÃ©on Spilett', 'fde8ad92e25a03e4521f7d19efd0012d.jpg', '428daf3a41f63f9ed5017cca73d46878.jpg', 'De 07:30 Ã  23:00', '02 31 50 17 83', 'mcdo@mcdo.com', '88 Boulevard MarÃ©chal Leclerc, 14000 Caen', 10, 'ArrÃªt Place Saint-Pierre', 'Non renseignÃ©', 'Non renseignÃ©'),
(9, 0, 'Le Printemps', 'Michel Ardan', 'd5127ac367b47e5b22db135c22715c12.jpg', '09a3bf6cc10c427d9256bd7f8813dad6.jpg', '09H30-19H00 6/7', '02 31 15 65 50', 'printemps@leprintemps.com', '28 Rue Saint-Jean, 14000 Caen', 10, 'Arrpet St-Jean', 'Non renseignÃ©', 'Non renseignÃ©'),
(10, 0, 'Monoprix', 'Pierre Aronnax', '4e3a3e6de9e0515a1d28a22898eb9e8c.jpg', 'f1363640e2081e69b22d74b0db17b15f.jpg', '9H-20H 6/7 et 10H-19H le dimanche', '02 31 50 28 28', 'monoprix@monoprix.com', '49 Boulevard MarÃ©chal Leclerc, 14011 Caen', 10, 'ArrÃªt boulevard Leclerc', 'Non renseignÃ©', 'Non renseignÃ©'),
(11, 0, 'Galeries Lafayette', 'John Hatteras', '8d10d6ee4ef0eaadbb9d7e6a64041840.jpg', 'a83c6b56a403213a7b53804f60e01a84.jpg', '9:30 â€“ 19:30 6/7', '02.31.39.31.00', 'galeries@lafayette.com', '108 â€“ 114 bvd MarÃ©chal Leclerc 14000 CAEN', 10, 'ArrÃªt MarÃ©chal Leclerc', 'Non renseignÃ©', 'Non renseignÃ©'),
(12, 0, 'Ikea', 'Michel Durand', 'ceca1c3244cef31037ec35f9423881a1.jpg', 'c70149975665687e8fb5090c878760c4.jpg', 'De 9H Ã  19H 7/7', '0 891 36 00 36', 'ikea@ikea.com', '14970 avenue de Suisse Normande  14123 Fleury-sur-Orne', 1, 'arrÃªt Fleury', 'Non renseignÃ©', 'Non renseignÃ©');

-- --------------------------------------------------------

--
-- Structure de la table `gerant`
--

CREATE TABLE IF NOT EXISTS `gerant` (
  `id_gerant` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `mot_de_passe` varchar(50) NOT NULL,
  `id_commerce` mediumint(9) unsigned NOT NULL,
  `id_telephone_commercant` varchar(25) NOT NULL,
  `adresse_ip` varchar(25) NOT NULL,
  PRIMARY KEY (`id_gerant`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `gerant`
--

INSERT INTO `gerant` (`id_gerant`, `pseudo`, `mot_de_passe`, `id_commerce`, `id_telephone_commercant`, `adresse_ip`) VALUES
(10, 'Michel Durand', 'michel', 12, '', ''),
(11, 'Gédéon Spilett', 'gedeons', 5, '', ''),
(12, 'Alexandre Poniatovski', 'alex', 3, '', ''),
(13, 'Joseph Murat', 'joseph', 4, '', ''),
(14, 'Pascal Descartes', 'pascald', 1, '', ''),
(15, 'Arne Saknussem', 'arne', 6, '', ''),
(16, 'Otto Lindenbrock', 'ottol', 7, '', ''),
(17, 'GÃ©dÃ©on Spilett', 'gÃ©dÃ©ons', 8, '', ''),
(18, 'Michel Ardan', 'michela', 9, '', ''),
(19, 'Pierre Aronnax', 'pierrea', 10, '', ''),
(20, 'John Hatteras', 'johnh', 11, '', ''),
(21, 'Marcel Durand', 'marceld', 2, 'f2f84d9da6a87126', '');

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
  `heure` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mentions` varchar(200) NOT NULL,
  `texte` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id_kuchikomi`),
  KEY `id_commerce` (`id_commerce`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `kuchikomi`
--

INSERT INTO `kuchikomi` (`id_kuchikomi`, `id_commerce`, `heure`, `mentions`, `texte`, `photo`, `date_debut`, `date_fin`) VALUES
(10, 1, '2013-06-20 06:47:54', '', 'Sortie du jeu Takenoko, venez l''essayer dans nos locaux.', 'f01eac99ad898d1a7788f03ec5bcbe60.jpg', '2013-06-20', '2013-07-20'),
(11, 1, '2013-06-20 06:49:18', 'Dans la limite des stocks disponibles.', '-10% sur le chromino.', '894d86394a4da23c8808bd7270810912.jpg', '2013-06-02', '2013-06-05'),
(12, 2, '2013-06-20 07:03:47', 'Dans la limite des stocks disponibles.', 'Attentionâ€¯! Nouvel arrivageâ€¯!\r\nVenez dÃ©couvrir le thÃ© blanc de Bretagneâ€¯! DÃ©gustation offerteâ€¯!', '00449be53d7050efa81ad1cb5754f7f8.png', '2013-05-30', '2013-06-30'),
(13, 2, '2013-06-20 07:06:26', '', 'Et si on se faisait une vente privÃ©eâ€¯?\r\nRDV ce soir de 19H Ã  21H.', 'eee473fe5eb64edd87f574bf5f2b5b44.png', '2013-07-17', '2013-08-17'),
(22, 2, '2013-06-20 13:38:08', '', 'Venez boire notre nouveau cafÃ©.', 'aa0128b79bef8964c22156d53130cc6f.jpg', '2013-06-20', '2013-06-25');

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
