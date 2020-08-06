-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 05 août 2020 à 10:49
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gbaf`
--

-- --------------------------------------------------------

--
-- Structure de la table `visiteurs`
--

DROP TABLE IF EXISTS `visiteurs`;
CREATE TABLE IF NOT EXISTS `visiteurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `reponse` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `visiteurs`
--

INSERT INTO `visiteurs` (`id`, `nom`, `prenom`, `pseudo`, `password`, `question`, `reponse`) VALUES
(1, 'a', 'a', 'a', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'a', 'a'),
(2, 'a', 'a', 'a', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'a', 'a'),
(3, 'Jean', 'Dujardin', 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Couleur de voiture ?', 'Bleu'),
(4, 'Aiden', 'Pearce', 'WD', '0b7afc3e9363c80f619524194c0d7e4661396ecb', 'Couleur de casquette ?', 'Noir'),
(5, 'Azerty', 'Luc', 'Lulu', '0f300f33b728cabd2cd5cbde86757722de291ceb', 'Quelle a Ã©tÃ© votre premiÃ¨re voiture ?', 'Clio 4');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
