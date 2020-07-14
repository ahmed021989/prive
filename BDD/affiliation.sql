-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 08 juil. 2020 à 20:53
-- Version du serveur :  5.7.28
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sirh_sp`
--

-- --------------------------------------------------------

--
-- Structure de la table `affiliation`
--

DROP TABLE IF EXISTS `affiliation`;
CREATE TABLE IF NOT EXISTS `affiliation` (
  `id_employe` int(11) NOT NULL,
  `nom_pere` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `nom_mere` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_employe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `affiliation`
--

INSERT INTO `affiliation` (`id_employe`, `nom_pere`, `nom_mere`, `photo`) VALUES
(1000, 'ahmed', 'fsdfsd', '1000.gif'),
(85, 'rzerz', 'doooo', '85.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
