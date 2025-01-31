-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 19 déc. 2024 à 09:48
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `extranet_wbcc_fr`
--

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_projet`
--

CREATE TABLE `wbcc_projet` (
  `idProjet` int(11) NOT NULL,
  `nomProjet` varchar(255) DEFAULT NULL,
  `descriptionProjet` varchar(255) DEFAULT NULL,
  `createDate` varchar(25) DEFAULT NULL,
  `idImmeuble` int(11) DEFAULT NULL,
  `idApp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_projet`
--

INSERT INTO `wbcc_projet` (`idProjet`, `nomProjet`, `descriptionProjet`, `createDate`, `idImmeuble`, `idApp`) VALUES
(1, 'Projet1', 'C\'est le projet 1', '2024-12-18 10:49:26', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `wbcc_projet`
--
ALTER TABLE `wbcc_projet`
  ADD KEY `wbcc_projet_ibfk_1` (`idImmeuble`),
  ADD KEY `wbcc_projet_ibfk_2` (`idApp`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `wbcc_projet`
--
ALTER TABLE `wbcc_projet`
  ADD CONSTRAINT `wbcc_projet_ibfk_1` FOREIGN KEY (`idImmeuble`) REFERENCES `wbcc_immeuble` (`idImmeuble`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wbcc_projet_ibfk_2` FOREIGN KEY (`idApp`) REFERENCES `wbcc_appartement` (`idApp`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
