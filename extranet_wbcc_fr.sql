-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 31 jan. 2025 à 16:38
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
-- Structure de la table `wbcc_appartement`
--

CREATE TABLE `wbcc_appartement` (
  `idApp` int(11) NOT NULL,
  `numeroApp` varchar(100) DEFAULT NULL,
  `codeApp` varchar(100) DEFAULT NULL,
  `etage` varchar(100) DEFAULT NULL,
  `codePorte` varchar(100) DEFAULT NULL,
  `escalier` varchar(25) DEFAULT NULL,
  `batiment` varchar(100) DEFAULT NULL,
  `lot` varchar(255) DEFAULT NULL,
  `typeLot` varchar(25) DEFAULT 'PP',
  `libellePartieCommune` varchar(200) DEFAULT NULL,
  `cote` varchar(100) DEFAULT NULL,
  `digicode` varchar(100) DEFAULT NULL,
  `interphone` varchar(50) DEFAULT NULL,
  `idImmeubleF` int(11) DEFAULT NULL,
  `etatApp` int(11) NOT NULL DEFAULT 1,
  `indexCompteur` varchar(255) DEFAULT NULL,
  `numeroCompteur` varchar(100) DEFAULT NULL,
  `photoCompteur` text DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `nbPiece` varchar(255) DEFAULT NULL,
  `surface` varchar(255) DEFAULT NULL,
  `codeWBCC` varchar(255) DEFAULT NULL,
  `codeImmeubleWBCC` varchar(255) DEFAULT NULL,
  `proprietaire` varchar(255) DEFAULT NULL,
  `occupant` varchar(255) DEFAULT NULL,
  `typeOccupation` varchar(255) DEFAULT NULL,
  `typeOccupant` varchar(255) DEFAULT NULL,
  `compagnieAssuranceOccupant` varchar(255) DEFAULT NULL,
  `courtierOccupant` varchar(255) DEFAULT NULL,
  `refOccupant` varchar(255) DEFAULT NULL,
  `numPoliceOccupant` varchar(255) DEFAULT NULL,
  `dateEffetOccupant` varchar(255) DEFAULT NULL,
  `dateEcheanceOccupant` varchar(255) DEFAULT NULL,
  `copieOccupant` varchar(255) DEFAULT NULL,
  `typeProprietaire` varchar(255) DEFAULT NULL,
  `compagnieAssuranceProprietaire` varchar(255) DEFAULT NULL,
  `numPoliceProprietaire` varchar(255) DEFAULT NULL,
  `dateEffetProprietaire` varchar(255) DEFAULT NULL,
  `dateEcheanceProprietaire` varchar(255) DEFAULT NULL,
  `copieProprietaire` varchar(255) DEFAULT NULL,
  `nomImmeubleSyndic` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `codePostal` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `dateDebutContrat` varchar(25) DEFAULT NULL,
  `dateFinContrat` varchar(25) DEFAULT NULL,
  `createDate` varchar(50) DEFAULT current_timestamp(),
  `editDate` varchar(50) DEFAULT current_timestamp(),
  `departement` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `gererApp` varchar(255) DEFAULT NULL,
  `guidOccupant` varchar(50) DEFAULT NULL,
  `guidProprietaire` varchar(50) DEFAULT NULL,
  `idOccupant` int(11) DEFAULT NULL,
  `idProprietaire` int(11) DEFAULT NULL,
  `idAgenceImmobiliere` int(11) DEFAULT NULL,
  `idCompanyCopro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_appartement`
--

INSERT INTO `wbcc_appartement` (`idApp`, `numeroApp`, `codeApp`, `etage`, `codePorte`, `escalier`, `batiment`, `lot`, `typeLot`, `libellePartieCommune`, `cote`, `digicode`, `interphone`, `idImmeubleF`, `etatApp`, `indexCompteur`, `numeroCompteur`, `photoCompteur`, `commentaire`, `nbPiece`, `surface`, `codeWBCC`, `codeImmeubleWBCC`, `proprietaire`, `occupant`, `typeOccupation`, `typeOccupant`, `compagnieAssuranceOccupant`, `courtierOccupant`, `refOccupant`, `numPoliceOccupant`, `dateEffetOccupant`, `dateEcheanceOccupant`, `copieOccupant`, `typeProprietaire`, `compagnieAssuranceProprietaire`, `numPoliceProprietaire`, `dateEffetProprietaire`, `dateEcheanceProprietaire`, `copieProprietaire`, `nomImmeubleSyndic`, `adresse`, `codePostal`, `ville`, `dateDebutContrat`, `dateFinContrat`, `createDate`, `editDate`, `departement`, `region`, `gererApp`, `guidOccupant`, `guidProprietaire`, `idOccupant`, `idProprietaire`, `idAgenceImmobiliere`, `idCompanyCopro`) VALUES
(1, '11', '111', '1', '1111', NULL, NULL, NULL, 'PP', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'current_timestamp()', 'current_timestamp()', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_appartement_contact`
--

CREATE TABLE `wbcc_appartement_contact` (
  `idAppCon` int(11) NOT NULL,
  `idAppartementF` int(11) NOT NULL,
  `idContactF` int(11) NOT NULL,
  `numeroAppartementF` varchar(100) DEFAULT NULL,
  `numeroContactF` varchar(100) DEFAULT NULL,
  `etatAppCon` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_company`
--

CREATE TABLE `wbcc_company` (
  `idCompany` int(11) NOT NULL,
  `numeroCompany` varchar(255) DEFAULT NULL,
  `numeroRCS` varchar(255) DEFAULT NULL,
  `villeRCS` varchar(255) DEFAULT NULL,
  `numeroSiret` varchar(255) DEFAULT NULL,
  `codeSociete` varchar(255) DEFAULT NULL,
  `dateCreationJuridique` varchar(25) DEFAULT NULL,
  `etatConvention` int(11) DEFAULT 0,
  `dateEffetConvention` varchar(25) DEFAULT NULL,
  `dateEcheanceConvention` varchar(25) DEFAULT NULL,
  `categorieDO` varchar(255) DEFAULT NULL,
  `sousCategorieDO` varchar(255) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `secteur` varchar(255) DEFAULT NULL,
  `convention` varchar(255) DEFAULT NULL,
  `kbs` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nomCommercial` varchar(255) DEFAULT NULL,
  `codeCommercial` varchar(255) DEFAULT NULL,
  `idCommercial` int(11) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `enseigne` varchar(255) DEFAULT NULL,
  `nomGestionnaire` varchar(255) DEFAULT NULL,
  `codeGestionnaire` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `businessPostalCode` varchar(255) DEFAULT NULL,
  `businessLine1` text DEFAULT NULL,
  `businessLine2` text DEFAULT NULL,
  `businessCity` varchar(255) DEFAULT NULL,
  `businessCountryName` varchar(255) DEFAULT NULL,
  `businessState` varchar(255) DEFAULT NULL,
  `businessPhone` varchar(255) DEFAULT NULL,
  `faxPhone` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `webaddress` varchar(255) DEFAULT NULL,
  `siccode` varchar(255) DEFAULT NULL,
  `revenue` varchar(255) DEFAULT NULL,
  `numEmployees` varchar(25) DEFAULT NULL,
  `referredBy` varchar(255) DEFAULT NULL,
  `editDate` varchar(50) DEFAULT current_timestamp(),
  `createDate` varchar(50) DEFAULT current_timestamp(),
  `idTitreF` int(11) DEFAULT NULL,
  `idServiceF` int(11) DEFAULT NULL,
  `idGerantF` int(11) DEFAULT NULL,
  `idGuidAA` varchar(50) DEFAULT NULL,
  `idApporteurDO` int(11) DEFAULT NULL,
  `idGuidAADO` varchar(50) DEFAULT NULL,
  `formeJuridique` varchar(255) DEFAULT NULL,
  `natureJuridique` varchar(255) DEFAULT NULL,
  `idArtisanDevisF` int(11) DEFAULT NULL,
  `registreCommerce` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_company`
--

INSERT INTO `wbcc_company` (`idCompany`, `numeroCompany`, `numeroRCS`, `villeRCS`, `numeroSiret`, `codeSociete`, `dateCreationJuridique`, `etatConvention`, `dateEffetConvention`, `dateEcheanceConvention`, `categorieDO`, `sousCategorieDO`, `commentaire`, `industry`, `secteur`, `convention`, `kbs`, `email`, `nomCommercial`, `codeCommercial`, `idCommercial`, `region`, `enseigne`, `nomGestionnaire`, `codeGestionnaire`, `name`, `businessPostalCode`, `businessLine1`, `businessLine2`, `businessCity`, `businessCountryName`, `businessState`, `businessPhone`, `faxPhone`, `category`, `description`, `webaddress`, `siccode`, `revenue`, `numEmployees`, `referredBy`, `editDate`, `createDate`, `idTitreF`, `idServiceF`, `idGerantF`, `idGuidAA`, `idApporteurDO`, `idGuidAADO`, `formeJuridique`, `natureJuridique`, `idArtisanDevisF`, `registreCommerce`, `logo`) VALUES
(1, 'SGSDGSD', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Test Organisme', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ORGANISME', NULL, NULL, NULL, NULL, NULL, NULL, 'current_timestamp()', 'current_timestamp()', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_condition`
--

CREATE TABLE `wbcc_condition` (
  `idCondition` int(11) NOT NULL,
  `numeroCondition` varchar(50) DEFAULT NULL,
  `idTypeConditionF` int(11) DEFAULT NULL,
  `operateur` varchar(255) DEFAULT NULL,
  `signeOperateur` varchar(255) DEFAULT NULL,
  `valeur` varchar(255) DEFAULT NULL,
  `createDate` varchar(25) DEFAULT current_timestamp(),
  `editDate` varchar(25) DEFAULT current_timestamp(),
  `idAuteur` int(11) DEFAULT NULL,
  `etatCondition` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_condition_critere`
--

CREATE TABLE `wbcc_condition_critere` (
  `idConditionCritere` int(11) NOT NULL,
  `idConditionF` int(11) DEFAULT NULL,
  `idCritereF` int(11) NOT NULL,
  `createDate` varchar(25) DEFAULT current_timestamp(),
  `editDate` varchar(25) DEFAULT current_timestamp(),
  `idAuteur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_contact`
--

CREATE TABLE `wbcc_contact` (
  `idContact` int(11) NOT NULL,
  `numeroContact` varchar(100) DEFAULT NULL,
  `nomContact` varchar(255) DEFAULT NULL,
  `prenomContact` varchar(255) DEFAULT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `telContact` varchar(255) DEFAULT NULL,
  `emailContact` varchar(255) DEFAULT NULL,
  `dateNaissance` varchar(25) DEFAULT NULL,
  `adresseContact` text DEFAULT NULL,
  `codePostalContact` varchar(25) DEFAULT NULL,
  `villeContact` varchar(100) DEFAULT NULL,
  `statutContact` varchar(255) DEFAULT NULL,
  `etatContact` int(11) DEFAULT 1,
  `civiliteContact` varchar(25) DEFAULT NULL,
  `copieCNI` text DEFAULT NULL,
  `copieCA` text DEFAULT NULL,
  `copieTP` text DEFAULT NULL,
  `commentaireCNI` text DEFAULT NULL,
  `commentaireCA` text DEFAULT NULL,
  `commentaireTP` text DEFAULT NULL,
  `lienParente` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `fiscalementCharge` varchar(255) DEFAULT NULL,
  `fileJustificatifOcc` text DEFAULT NULL,
  `idContactFContact` int(11) DEFAULT NULL,
  `codeFiche` varchar(100) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(100) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `departement` varchar(255) DEFAULT NULL,
  `mobilePhone` varchar(100) DEFAULT NULL,
  `faxPhone` varchar(100) DEFAULT NULL,
  `emailCollaboratif` varchar(255) DEFAULT NULL,
  `businessLine2` varchar(255) DEFAULT NULL,
  `businessState` varchar(255) DEFAULT NULL,
  `businessCountryName` varchar(255) DEFAULT NULL,
  `digicode1` varchar(100) DEFAULT NULL,
  `codePorte` varchar(50) DEFAULT NULL,
  `batiment` varchar(50) DEFAULT NULL,
  `etage` varchar(50) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `referredBy` varchar(255) DEFAULT NULL,
  `createDate` varchar(50) DEFAULT current_timestamp(),
  `editDate` varchar(50) DEFAULT current_timestamp(),
  `jobTitle` varchar(255) DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  `motifSuppressionCompte` text DEFAULT NULL,
  `isUser` int(11) NOT NULL DEFAULT 0,
  `isPersonnel` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_contact`
--

INSERT INTO `wbcc_contact` (`idContact`, `numeroContact`, `nomContact`, `prenomContact`, `fullName`, `telContact`, `emailContact`, `dateNaissance`, `adresseContact`, `codePostalContact`, `villeContact`, `statutContact`, `etatContact`, `civiliteContact`, `copieCNI`, `copieCA`, `copieTP`, `commentaireCNI`, `commentaireCA`, `commentaireTP`, `lienParente`, `age`, `fiscalementCharge`, `fileJustificatifOcc`, `idContactFContact`, `codeFiche`, `skype`, `whatsapp`, `commentaire`, `category`, `companyName`, `departement`, `mobilePhone`, `faxPhone`, `emailCollaboratif`, `businessLine2`, `businessState`, `businessCountryName`, `digicode1`, `codePorte`, `batiment`, `etage`, `source`, `referredBy`, `createDate`, `editDate`, `jobTitle`, `service`, `motifSuppressionCompte`, `isUser`, `isPersonnel`) VALUES
(1, 'vdfgsdfsddfhdffgd', 'BALTI', 'Jawher', 'Jawher BALTI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-01 11:50:34', '2024-12-16 11:50:34', NULL, NULL, NULL, 0, 0),
(2, 'CON_05050404', 'nc1', 'pc1', 'npc1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01 11:50:34', '2024-10-01 11:50:34', NULL, NULL, NULL, 1, 1),
(100, 'CON_1', 'nabila', 'nabila', 'nabila nabila', NULL, 'nabila.nabila@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-01 11:50:34', '2024-10-01 11:50:34', NULL, NULL, NULL, 0, 0),
(1998, 'CON_05050404202420242024115034', 'DRIDI', 'Hamza', 'Hamza DRIDI', '0766596464', 'jeanmarc.d@wbcc.fr', NULL, '', '', '', NULL, 1, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, '', '', '', '', 'jeanmarc.d@wbcc.fr', '', '', NULL, NULL, '', '', '', NULL, 'Extranet WBCC', '2024-04-05 11:50:34', '2024-08-30 08:50:33', '', '', NULL, 1, 0),
(8462, 'CON_05050404202420242024115035', 'admin', 'admin', 'admin admin', NULL, 'admin.admin@wbcc.fr', NULL, '', '', '', 'Commercial', 1, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, '', '', '', '', NULL, '', '', NULL, NULL, '', '', '', NULL, 'Extranet WBCC', '', '', '', '', NULL, 1, 0),
(8464, 'CON_05050404202420242024115034', 'MEHERZI', 'Mohamed Achref', 'Mohamed Achref MEHERZI', '0766596464', 'achref@wbcc.fr', NULL, '', '', '', NULL, 1, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, '', '', '', '', 'achref@wbcc.fr', '', '', NULL, NULL, '', '', '', NULL, 'Extranet WBCC', '2024-04-05 11:50:34', '2024-08-30 08:50:33', '', '', NULL, 1, 0),
(8465, 'CON_4', 'TAGUEZ', 'nabila', 'nabila TAGUEZ', '0766596463', 'tagueznabila8@gmail.com', NULL, '', '', '', 'Commercial', 1, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, 'Commercial', '', '', '', '', 'test.test@wbcc.fr', '', '', NULL, NULL, '', '', '', NULL, 'Extranet WBCC', '2024-04-05 11:50:34', '2024-08-30 08:50:33', '', '', NULL, 1, 0),
(8466, 'CON_4', 'OUESLATI', 'hend', 'hend OUESLATI', '0766596463', 'oueslatihend@wbcc.fr', NULL, '', '', '', 'Commercial', 1, 'M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', NULL, 'Extranet WBCC', '2024-04-05 11:50:34', '2024-08-30 08:50:33', '', '', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_contact_company`
--

CREATE TABLE `wbcc_contact_company` (
  `idContactCompany` int(11) NOT NULL,
  `idContactF` int(11) NOT NULL,
  `idCompanyF` int(11) NOT NULL,
  `numeroContactF` varchar(255) DEFAULT NULL,
  `numeroCompanyF` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_critere`
--

CREATE TABLE `wbcc_critere` (
  `idCritere` int(11) NOT NULL,
  `numeroCritere` varchar(50) DEFAULT NULL,
  `valeurCritere` varchar(255) DEFAULT NULL,
  `typeValeurCritere` varchar(255) DEFAULT NULL,
  `createDate` varchar(25) DEFAULT current_timestamp(),
  `editDate` varchar(25) DEFAULT current_timestamp(),
  `idAuteur` int(11) DEFAULT NULL,
  `etatCritere` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_critere`
--

INSERT INTO `wbcc_critere` (`idCritere`, `numeroCritere`, `valeurCritere`, `typeValeurCritere`, `createDate`, `editDate`, `idAuteur`, `etatCritere`) VALUES
(1, 'C181220241050521', '10', 'Pourcentage', '2024-12-18 10:50:52', '2024-12-18 10:50:52', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_critere_subvention`
--

CREATE TABLE `wbcc_critere_subvention` (
  `idCritereSubvention` int(11) NOT NULL,
  `numeroCritereSubvention` varchar(50) DEFAULT NULL,
  `idCritereF` int(11) DEFAULT NULL,
  `idSubventionF` int(11) DEFAULT NULL,
  `createDate` varchar(25) DEFAULT current_timestamp(),
  `editDate` varchar(25) DEFAULT current_timestamp(),
  `idAuteur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_critere_subvention`
--

INSERT INTO `wbcc_critere_subvention` (`idCritereSubvention`, `numeroCritereSubvention`, `idCritereF`, `idSubventionF`, `createDate`, `editDate`, `idAuteur`) VALUES
(1, NULL, 1, 1, '2024-12-18 10:50:52', '2024-12-18 10:50:52', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_demandesconge`
--

CREATE TABLE `wbcc_demandesconge` (
  `idDemande` int(11) NOT NULL,
  `idUtilisateurF` int(11) DEFAULT NULL,
  `idTypeCongeF` int(11) DEFAULT NULL,
  `motif` text DEFAULT NULL,
  `dateDebutDeCongeSouhaite` date DEFAULT NULL,
  `dateFinDeCongeSouhaite` date DEFAULT NULL,
  `dateDebutDeCongePropose` date DEFAULT NULL,
  `dateFinDeCongePropose` date DEFAULT NULL,
  `dateDebutDeCongeReelle` date DEFAULT NULL,
  `dateFinDeCongeReelle` date DEFAULT NULL,
  `commentaire` varchar(200) DEFAULT NULL,
  `statut` enum('0','1','2','3') DEFAULT NULL COMMENT '0=en_attente, 1=approuvé, 2=rejeté, 3=annulé',
  `quotasRestant` int(11) NOT NULL,
  `dateCreation` datetime DEFAULT NULL,
  `dateModification` datetime DEFAULT NULL,
  `idTraiteF` int(11) DEFAULT NULL,
  `jours` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_demandesconge`
--

INSERT INTO `wbcc_demandesconge` (`idDemande`, `idUtilisateurF`, `idTypeCongeF`, `motif`, `dateDebutDeCongeSouhaite`, `dateFinDeCongeSouhaite`, `dateDebutDeCongePropose`, `dateFinDeCongePropose`, `dateDebutDeCongeReelle`, `dateFinDeCongeReelle`, `commentaire`, `statut`, `quotasRestant`, `dateCreation`, `dateModification`, `idTraiteF`, `jours`) VALUES
(1, 609, 1, 'motif123123', '2024-08-08', '2024-08-16', NULL, NULL, '2024-08-07', '2024-08-10', '', '1', 0, NULL, '2025-01-23 17:51:16', 1, NULL),
(2, 611, 1, 'bb', '2024-09-11', '2024-09-28', NULL, NULL, NULL, NULL, 'vvv', '0', 0, '2024-09-17 02:38:50', '2025-01-23 17:48:50', 2, NULL),
(8, 609, 3, 'ttt', '2024-09-20', '2024-09-28', '2025-01-25', '2025-01-26', NULL, NULL, 'azer', '2', 0, '2024-09-17 02:38:50', '2025-01-24 14:14:38', 1, NULL),
(9, 609, 3, 'sddssd', '2024-09-01', '2024-09-30', NULL, NULL, NULL, NULL, NULL, '1', 0, '2024-09-27 01:32:49', '2025-01-22 14:08:25', 609, NULL),
(10, 611, 1, '', '2024-09-07', '2024-09-29', NULL, NULL, '2024-08-21', '2024-08-23', NULL, '1', 0, '2024-09-27 01:33:49', '2025-01-23 17:49:15', 1, NULL),
(31, 609, 2, 'azeazeazeazeazeazeqqqqqqqqqqqqqqqqqqqqqqq', '2025-01-22', '2025-01-24', '2025-01-25', '2025-01-31', '2025-01-25', '2025-01-31', 'zzzzzzzzzzzzzzzzzzzzzz', '1', 0, '2025-01-21 15:57:20', '2025-01-23 10:57:24', 1, NULL),
(32, 1, 3, 'pppppppppppppppppppppppp', '2025-01-24', '2025-01-26', NULL, NULL, NULL, NULL, NULL, '2', 0, '2025-01-21 15:57:56', '2025-01-23 17:49:46', 1, NULL),
(33, 1, 2, 'qsdqsdqsdqs', '2025-01-23', '2025-01-28', NULL, NULL, '2025-01-23', '2025-01-28', NULL, '1', 0, '2025-01-21 15:58:56', '2025-01-23 17:35:27', 1, NULL),
(34, 1, 3, '1231234564', '2025-01-30', '2025-01-31', '2025-01-25', '2025-01-26', NULL, NULL, 'commentaire', '0', 0, '2025-01-21 15:59:56', '2025-01-24 14:13:27', 1, NULL),
(41, 609, 2, '111111111111111', '2025-01-24', '2025-01-25', NULL, NULL, NULL, NULL, NULL, '2', 0, '2025-01-23 11:07:14', '2025-01-23 11:16:36', 1, NULL),
(42, 609, 1, 'azeazeaze', '2025-01-29', '2025-01-31', NULL, NULL, '2025-01-29', '2025-01-31', NULL, '1', 0, '2025-01-23 11:12:39', '2025-01-23 11:17:09', 1, NULL),
(43, 609, 3, '4\r\n45\r\n4', '2025-01-25', '2025-01-27', '2025-01-30', '2025-01-31', '2025-01-22', '2025-01-31', 'azeaze', '1', 0, '2025-01-23 11:17:37', '2025-01-23 11:18:49', 1, NULL),
(44, 609, 1, 'sdfgsdfg', '2025-01-23', '2025-01-26', '2025-01-24', '2025-01-26', NULL, NULL, '456', '3', 0, '2025-01-23 11:19:25', '2025-01-24 14:15:14', 1, NULL),
(45, 609, 2, '123456789', '2025-01-24', '2025-01-28', NULL, NULL, '2025-01-24', '2025-01-28', NULL, '1', 0, '2025-01-23 14:53:51', '2025-01-23 17:49:39', 1, NULL),
(46, 609, 2, '1111111111111111111111', '2025-01-24', '2025-01-27', '2025-01-24', '2025-01-25', '2025-01-24', '2025-01-25', 'azeaze', '1', 0, '2025-01-24 12:25:52', '2025-01-24 12:36:37', 1, NULL),
(47, 609, 1, 'motif2', '2025-01-25', '2025-01-28', NULL, NULL, NULL, NULL, 'Raison rejet: azerazerazer', '2', 0, '2025-01-24 14:15:59', '2025-01-27 09:38:54', 1, NULL),
(48, 609, 2, 'azeqsdwxc', '2025-01-28', '2025-01-29', '2025-01-29', '2025-01-30', '2025-01-29', '2025-01-30', 'commentaire proposition', '1', 0, '2025-01-27 10:19:32', '2025-01-27 10:31:39', 1, NULL),
(49, 609, 1, 'qsdwxc', '2025-01-30', '2025-01-31', NULL, NULL, '2025-01-30', '2025-01-31', NULL, '1', 0, '2025-01-27 10:28:09', '2025-01-27 10:31:18', 1, NULL),
(50, 609, 1, 'qqqqqqqqqqqq', '2025-01-30', '2025-01-31', '2025-01-29', '2025-01-30', NULL, NULL, '456', '2', 0, '2025-01-27 10:32:12', '2025-01-27 10:32:51', 1, NULL),
(53, 609, 2, 'aaaaaaaaaaaaa', '2025-01-28', '2025-01-30', NULL, NULL, '2025-01-28', '2025-01-30', NULL, '1', 0, '2025-01-28 16:39:16', '2025-01-28 16:56:18', 1, 3),
(54, 609, 2, 'qwwwwwwwwwwwwwwwwwwwwwwwww', '2025-01-28', '2025-01-29', '2025-01-29', '2025-01-30', '2025-01-29', '2025-01-30', 'aazeaze', '1', 0, '2025-01-28 16:55:33', '2025-01-28 17:05:44', 1, 2),
(55, 609, 3, 'xxxxxxxxxxxxxxxxxxxxx', '2025-01-28', '2025-01-31', '2025-01-28', '2025-01-30', '2025-01-28', '2025-01-30', 'zzzzzzzzzzzzzzzzzzzzzz', '1', 0, '2025-01-28 16:55:53', '2025-01-28 17:03:53', 1, 3),
(56, 609, 2, '', '2025-01-30', '2025-01-31', '2025-01-29', '2025-01-30', '2025-01-29', '2025-01-30', '', '1', 0, '2025-01-28 17:07:39', '2025-01-28 17:09:05', 1, 2),
(57, 609, 2, 'aaaaaaaaaaaaa', '2025-01-28', '2025-01-31', NULL, NULL, '2025-01-28', '2025-01-31', NULL, '1', 0, '2025-01-28 17:15:28', '2025-01-28 17:15:45', 1, 4),
(58, 609, 2, 'aaaaaaaaaaaaaa', '2025-01-28', '2025-01-31', '2025-01-28', '2025-01-30', '2025-01-28', '2025-01-30', 'aaaaaaaaaaaaa', '1', 0, '2025-01-28 17:16:05', '2025-01-28 17:16:51', 1, 3),
(59, 609, 2, 'ssssssssssssssssss', '2025-01-28', '2025-01-29', '2025-01-29', '2025-01-30', '2025-01-29', '2025-01-30', 'sssssssss', '1', 0, '2025-01-28 17:17:11', '2025-01-28 17:17:51', 1, 2),
(60, 609, 3, 'qqqqqqqqqqqqqq', '2025-01-30', '2025-01-31', '2025-02-10', '2025-02-11', '2025-02-10', '2025-02-11', '', '3', 0, '2025-01-29 14:15:06', '2025-01-30 15:37:31', 1, 2),
(61, 609, 3, 'qqqqqqqqqqqqqq', '2025-01-29', '2025-01-31', '2025-02-19', '2025-02-20', '2025-02-19', '2025-02-20', '', '1', 0, '2025-01-29 14:16:22', '2025-01-30 13:37:34', 1, 2),
(62, 609, 2, 'aaaaaaaaaaaaaaaaaaaaaaaa', '2025-02-06', '2025-02-17', NULL, NULL, '2025-02-06', '2025-02-17', NULL, '1', 0, '2025-01-29 17:27:37', '2025-01-30 16:45:22', 1, 8),
(63, 609, 2, 'aaaaaaaaaaaaaaaaaaaaaaaa', '2025-02-06', '2025-02-17', NULL, NULL, '2025-02-06', '2025-02-17', NULL, '1', 0, '2025-01-29 17:27:37', '2025-01-30 15:35:08', 1, 8),
(64, 609, 1, 'aaaaaaaaaaaaaaaa', '2025-02-07', '2025-02-11', NULL, NULL, '2025-02-07', '2025-02-11', NULL, '3', 0, '2025-01-30 10:06:26', '2025-01-30 16:57:26', 1, 3),
(65, 609, 1, 'aaaaaaaaaaaaaaaa', '2025-02-07', '2025-02-11', NULL, NULL, NULL, NULL, NULL, '3', 0, '2025-01-30 10:06:26', '2025-01-30 15:38:15', NULL, 3),
(66, 609, 2, 'aaaaaaaa', '2025-02-07', '2025-02-13', NULL, NULL, '2025-02-07', '2025-02-13', NULL, '1', 0, '2025-01-30 16:58:10', '2025-01-30 16:58:20', 1, 5),
(67, 609, 2, '', '2025-02-07', '2025-02-13', NULL, NULL, '2025-02-07', '2025-02-13', NULL, '1', 0, '2025-01-30 16:59:55', '2025-01-30 17:00:02', 1, 5),
(68, 609, 2, 'aaaaaaaaaaaaa', '2025-02-10', '2025-02-11', NULL, NULL, '2025-02-10', '2025-02-11', NULL, '3', 0, '2025-01-31 08:18:25', '2025-01-31 09:44:54', 1, 2),
(69, 609, 2, 'aaaaaaaaaaaaaaaaaa', '2025-02-10', '2025-02-12', NULL, NULL, '2025-02-10', '2025-02-12', NULL, '1', 0, '2025-01-31 09:48:59', '2025-01-31 09:49:26', 1, 3),
(70, 609, 2, 'aaaaaaaaaaaaaaa', '2025-02-10', '2025-02-12', NULL, NULL, '2025-02-10', '2025-02-12', NULL, '1', 0, '2025-01-31 09:58:52', '2025-01-31 09:59:11', 1, 3),
(71, 609, 2, 'aaaaaaaaaaaaaaaaaaaa', '2025-02-10', '2025-02-11', NULL, NULL, '2025-02-10', '2025-02-11', NULL, '1', 0, '2025-01-31 10:01:42', '2025-01-31 10:01:52', 1, 2),
(72, 609, 2, 'aaaaaaaaaaaa', '2025-02-10', '2025-02-11', NULL, NULL, '2025-02-10', '2025-02-11', NULL, '1', 0, '2025-01-31 10:02:19', '2025-01-31 10:02:32', 1, 2),
(73, 609, 2, 'aaaaaaaaaaaaaaaaaaaa', '2025-02-10', '2025-02-11', NULL, NULL, '2025-02-10', '2025-02-11', NULL, '1', 0, '2025-01-31 10:04:37', '2025-01-31 10:04:51', 1, 2),
(74, 609, 2, 'qqqqqqqqqqqqqqqqqqqqqq', '2025-02-10', '2025-02-11', NULL, NULL, '2025-02-10', '2025-02-11', NULL, '1', 0, '2025-01-31 10:08:08', '2025-01-31 10:08:26', 1, 2),
(75, 609, 2, 'aaaaaaaaaaaaaaaaaaaaaaaa', '2025-02-20', '2025-02-21', NULL, NULL, '2025-02-20', '2025-02-21', NULL, '1', 0, '2025-01-31 10:10:24', '2025-01-31 10:10:34', 1, 2),
(76, 609, 2, 'aaaaaaaaaaaaaaaaaaa', '2025-02-10', '2025-02-11', NULL, NULL, '2025-02-10', '2025-02-11', NULL, '1', 0, '2025-01-31 10:11:23', '2025-01-31 10:11:39', 1, 2),
(77, 609, 2, 'fffffffffffffffffff', '2025-02-10', '2025-02-12', NULL, NULL, '2025-02-10', '2025-02-12', NULL, '1', 0, '2025-01-31 10:14:28', '2025-01-31 10:14:43', 1, 3),
(78, 1, 2, 'qqqqqqqqqqqqqq', '2025-02-10', '2025-02-12', NULL, NULL, '2025-02-10', '2025-02-12', NULL, '1', 0, '2025-01-31 10:23:28', '2025-01-31 10:25:44', 609, 3),
(79, 1, 2, 'ccccccccccccccc', '2025-02-10', '2025-02-12', '2025-02-10', '2025-02-11', NULL, NULL, 'xxxxxxxxxxxxxxx', '0', 0, '2025-01-31 10:28:25', '2025-01-31 10:28:40', 609, 3),
(80, 609, 2, 'wwwwwwwwwwwwwwww', '2025-02-10', '2025-02-11', NULL, NULL, NULL, NULL, NULL, '0', 0, '2025-01-31 10:45:21', '2025-01-31 10:45:21', NULL, 2),
(81, 609, 2, 'wwwwwwwwwwwwwwwwww', '2025-02-10', '2025-02-12', NULL, NULL, NULL, NULL, NULL, '0', 0, '2025-01-31 10:46:27', '2025-01-31 10:46:27', NULL, 3),
(82, 609, 2, 'wwwwwwwwwwwwwwwwwwww', '2025-02-10', '2025-02-11', NULL, NULL, NULL, NULL, NULL, '0', 0, '2025-01-31 10:47:17', '2025-01-31 10:47:17', NULL, 2),
(83, 609, 2, 'wwwwwwwwwwwwwwwww', '2025-02-10', '2025-02-11', NULL, NULL, NULL, NULL, NULL, '0', 0, '2025-01-31 11:13:33', '2025-01-31 11:13:33', NULL, 2),
(84, 609, 2, 'wwwwwwwwwwwwwwwwwffffffffffwwwwwwwwww', '2025-02-10', '2025-02-11', NULL, NULL, NULL, NULL, NULL, '0', 0, '2025-01-31 11:13:53', '2025-01-31 11:35:41', NULL, 2),
(85, 609, 2, 'wwwwwwwwwwwwwwww', '2025-02-10', '2025-02-11', NULL, NULL, NULL, NULL, NULL, '0', 0, '2025-01-31 12:25:30', '2025-01-31 12:25:30', NULL, 2),
(86, 609, 2, 'ccccccccccccccccccccc', '2025-02-10', '2025-02-11', NULL, NULL, NULL, NULL, NULL, '0', 0, '2025-01-31 12:29:37', '2025-01-31 12:29:37', NULL, 2),
(87, 609, 2, 'xxxxxxxxxxxxxxxxaaaa', '2025-02-10', '2025-03-05', NULL, NULL, NULL, NULL, NULL, '0', 0, '2025-01-31 12:34:58', '2025-01-31 14:33:59', NULL, 18);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_document`
--

CREATE TABLE `wbcc_document` (
  `idDocument` int(11) NOT NULL,
  `numeroDocument` varchar(255) DEFAULT NULL,
  `nomDocument` varchar(255) DEFAULT NULL,
  `urlDocument` varchar(255) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `editDate` varchar(25) DEFAULT current_timestamp(),
  `etatDocument` int(11) DEFAULT 1,
  `idUtilisateurF` int(11) DEFAULT NULL,
  `guidNote` varchar(50) DEFAULT NULL,
  `guidActivity` varchar(50) DEFAULT NULL,
  `guidHistory` varchar(50) DEFAULT NULL,
  `typeFichier` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `guidUser` varchar(255) DEFAULT NULL,
  `source` varchar(50) DEFAULT NULL,
  `auteur` varchar(255) DEFAULT NULL,
  `publie` int(11) NOT NULL DEFAULT 1,
  `isDeleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_document`
--

INSERT INTO `wbcc_document` (`idDocument`, `numeroDocument`, `nomDocument`, `urlDocument`, `commentaire`, `createDate`, `editDate`, `etatDocument`, `idUtilisateurF`, `guidNote`, `guidActivity`, `guidHistory`, `typeFichier`, `size`, `guidUser`, `source`, `auteur`, `publie`, `isDeleted`) VALUES
(49829, 'DOC231220240227485380', 'vrrs', 'Pj_538_vrrs_20241223022748.jpg', 'cvee', '2024-12-23 02:27:48', '2024-12-23 02:27:48', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49830, 'DOC231220240928395450', 'bb1', 'Pj_545_bb1_20241223092839.jpg', 'bb1', '2024-12-23 09:28:39', '2024-12-23 09:28:39', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49833, 'DOC231220240934465450', 'bb1', 'Pj_545_bb1_20241223093446.jpg', 'test update', '2024-12-23 09:34:46', '2024-12-24 00:55:43', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49840, 'DOC261220240204006100', 'pic1test', 'Pj_610_pic1_20241226020400.jpg', 'pic1 comentt', '2024-12-26 02:04:00', '2024-12-26 02:48:23', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49844, 'DOC261220240248236100', 'testpic', 'Pj_610_testpic_20241226024823.jpg', 'poic', '2024-12-26 02:48:23', '2024-12-26 02:48:23', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49845, 'DOC100120251104415300', 'a', 'Pj_530a20250110110441.png', NULL, '2025-01-10 11:04:41', '2025-01-10 11:04:41', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49846, 'DOC100120251108035300', ' ', 'Pj_53020250110110803.png', NULL, '2025-01-10 11:08:03', '2025-01-10 11:08:03', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49847, 'DOC100120251109565300', 'q', 'Pj_530q20250110110956.png', NULL, '2025-01-10 11:09:56', '2025-01-10 11:09:56', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49848, 'DOC100120251112135300', 'q', 'Pj_530q20250110111213.png', NULL, '2025-01-10 11:12:13', '2025-01-10 11:12:13', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49849, 'DOC100120251114525300', 'a', 'Pj_530a20250110111452.png', NULL, '2025-01-10 11:14:52', '2025-01-10 11:14:52', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49850, 'DOC100120251115195300', '1', 'Pj_530120250110111519.png', NULL, '2025-01-10 11:15:19', '2025-01-10 11:15:19', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49851, 'DOC100120251118365300', 'w', 'Pj_530w20250110111836.png', NULL, '2025-01-10 11:18:36', '2025-01-10 11:18:36', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49852, 'DOC100120251120305300', 'azeaze', 'Pj_530a20250110112030.png', NULL, '2025-01-10 11:20:30', '2025-01-10 11:20:30', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49853, 'DOC100120251139245110', '', 'Pj_511UnnamedDocument020250110113924.png', NULL, '2025-01-10 11:39:24', '2025-01-10 11:39:24', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49854, 'DOC100120251139535110', 'wxc', 'Pj_511w20250110113953.png', NULL, '2025-01-10 11:39:53', '2025-01-10 11:39:53', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49855, 'DOC100120251141365110', 'undefined', 'Pj_511u20250110114136.png', NULL, '2025-01-10 11:41:36', '2025-01-10 11:41:36', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49856, 'DOC100120251142515110', 'qsd', 'Pj_511q20250110114251.png', NULL, '2025-01-10 11:42:51', '2025-01-10 11:42:51', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49857, 'DOC100120251144303740', 'aze&é\"&é\"', 'Pj_374a20250110114430.png', NULL, '2025-01-10 11:44:30', '2025-01-10 11:44:30', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49858, 'DOC100120251144363740', 'aze&é\"&é\"', 'Pj_374a20250110114436.png', NULL, '2025-01-10 11:44:36', '2025-01-10 11:44:36', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49859, 'DOC100120251231355110', 'azeazeazeaze', 'Pj_511a20250110123135.png', NULL, '2025-01-10 12:31:35', '2025-01-10 12:31:35', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49860, 'DOC100120251238175110', 'qsd', 'Pj_511q20250110123817.png', NULL, '2025-01-10 12:38:17', '2025-01-10 12:38:17', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49861, 'DOC100120251454175110', 'azeaze', 'Pj_511a20250110145417.png', NULL, '2025-01-10 14:54:17', '2025-01-10 14:54:17', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49862, 'DOC100120251455245050', '', 'Pj_505UnnamedDocument020250110145524.png', NULL, '2025-01-10 14:55:24', '2025-01-10 14:55:24', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49863, 'DOC100120251456115050', 'ttttt', 'Pj_505t20250110145611.png', NULL, '2025-01-10 14:56:11', '2025-01-10 14:56:11', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49864, 'DOC100120251554311900', 'aaze', 'Pj_190a20250110155431.png', NULL, '2025-01-10 15:54:31', '2025-01-10 15:54:31', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49865, 'DOC100120251555161900', 'aze', 'Pj_190a20250110155516.png', NULL, '2025-01-10 15:55:16', '2025-01-10 15:55:16', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49866, 'DOC100120251556421900', 'aze', 'Pj_190a20250110155642.png', NULL, '2025-01-10 15:56:42', '2025-01-10 15:56:42', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49867, 'DOC100120251558553660', 'justificatifArrivée', 'Pj_366j20250110155855.png', NULL, '2025-01-10 15:58:55', '2025-01-10 15:58:55', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49868, 'DOC100120251559363660', 'justificatifDepart', 'Pj_366j20250110155936.png', NULL, '2025-01-10 15:59:36', '2025-01-10 15:59:36', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49869, 'DOC100120251600232020', 'justificatifDabsence', 'Pj_202j20250110160023.png', NULL, '2025-01-10 16:00:23', '2025-01-10 16:00:23', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49870, 'DOC130120250938335050', 'nomJustificatifArrivée', 'Pj_505n20250113093833.png', NULL, '2025-01-13 09:38:33', '2025-01-13 09:38:33', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49871, 'DOC130120250939245050', 'JustificatifDepart', 'Pj_505J20250113093924.png', NULL, '2025-01-13 09:39:24', '2025-01-13 09:39:24', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49872, 'DOC140120251453383470', 'nomDocument', 'Pj_347n20250114145338.png', NULL, '2025-01-14 14:53:38', '2025-01-14 14:53:38', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49875, 'DOC200120251011514870', 'AZE', 'Pj_487A20250120101151.png', NULL, '2025-01-20 10:11:51', '2025-01-20 10:11:51', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49885, 'DOC200120251154314870', 'eeeeeeee', 'Pj_487_e_20250120115431.png', 'zzzzzzzzz', '2025-01-20 11:54:31', '2025-01-20 11:54:31', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49886, 'DOC200120251206424870', 'aaaaaaaaaaaaaa', 'Pj_487_a_20250120120642.png', 'zzzzzzzzzzzzzzzzz', '2025-01-20 12:06:42', '2025-01-20 12:06:42', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49887, 'DOC200120251209513250', '111111111111111', 'Pj_325_1_20250120120951.png', '222222222222', '2025-01-20 12:09:51', '2025-01-20 12:09:51', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49888, 'DOC29012025141506600', 'a', 'Pj_60a20250129141506.png', 'z', '2025-01-29 14:15:06', '2025-01-29 14:15:06', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49889, 'DOC31012025104521800', 'q', 'Pj_80q20250131104521.png', 'c', '2025-01-31 10:45:21', '2025-01-31 10:45:21', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49890, 'DOC31012025104627810', 'a', 'Pj_81a20250131104627.png', 'c', '2025-01-31 10:46:27', '2025-01-31 10:46:27', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49891, 'DOC31012025104717820', 'a', 'Pj_82a20250131104717.png', 'c', '2025-01-31 10:47:17', '2025-01-31 10:47:17', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49892, 'DOC31012025122530850', 'a', 'Pj_85a20250131122530.png', 'z', '2025-01-31 12:25:30', '2025-01-31 12:25:30', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49893, 'DOC31012025122937860', '[', 'Pj_8620250131122937.png', '[', '2025-01-31 12:29:37', '2025-01-31 12:29:37', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49894, 'DOC31012025123458870', 'n', 'Pj_87n20250131123458.png', 'c', '2025-01-31 12:34:58', '2025-01-31 12:34:58', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0),
(49895, 'DOC31012025141514870', 'Unnamed_Document_0', 'Pj_87UnnamedDocument020250131141514.png', NULL, '2025-01-31 14:15:14', '2025-01-31 14:15:14', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EXTRANET', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_document_conge`
--

CREATE TABLE `wbcc_document_conge` (
  `idDocumentConge` int(11) NOT NULL,
  `idDocumentF` int(11) NOT NULL,
  `idDemandeF` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wbcc_document_conge`
--

INSERT INTO `wbcc_document_conge` (`idDocumentConge`, `idDocumentF`, `idDemandeF`) VALUES
(3, 49887, 59),
(4, 49886, 59),
(5, 49885, 58),
(6, 49875, 57),
(7, 49872, 56),
(18, 49888, 60),
(19, 49889, 80),
(20, 49890, 81),
(21, 49891, 82),
(22, 49892, 85),
(23, 49893, 86),
(24, 49894, 87),
(25, 49895, 87);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_document_pointage`
--

CREATE TABLE `wbcc_document_pointage` (
  `id` int(11) NOT NULL,
  `idDocumentF` int(11) NOT NULL,
  `idPointageF` int(11) NOT NULL,
  `nomDocument` varchar(255) DEFAULT NULL,
  `isArrive` tinyint(1) DEFAULT NULL,
  `associationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `isAbsent` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wbcc_document_pointage`
--

INSERT INTO `wbcc_document_pointage` (`id`, `idDocumentF`, `idPointageF`, `nomDocument`, `isArrive`, `associationDate`, `isAbsent`) VALUES
(1, 49372, 153, NULL, NULL, '2024-10-27 14:54:23', NULL),
(2, 49373, 153, NULL, NULL, '2024-10-27 14:54:23', NULL),
(3, 49377, 151, NULL, NULL, '2024-10-27 14:59:49', NULL),
(4, 49378, 151, NULL, NULL, '2024-10-27 14:59:49', NULL),
(5, 49379, 151, NULL, NULL, '2024-10-27 14:59:49', NULL),
(6, 49380, 151, NULL, NULL, '2024-10-27 14:59:49', NULL),
(7, 49381, 151, NULL, NULL, '2024-10-27 14:59:49', NULL),
(8, 49357, 161, NULL, NULL, '2024-10-28 09:43:36', NULL),
(9, 49382, 160, NULL, NULL, '2024-10-28 09:54:48', NULL),
(11, 49384, 167, NULL, NULL, '2024-10-30 11:15:03', NULL),
(12, 49385, 167, NULL, NULL, '2024-10-30 11:18:14', NULL),
(13, 49386, 167, NULL, NULL, '2024-10-30 11:18:14', NULL),
(14, 49387, 167, NULL, NULL, '2024-10-30 11:18:14', NULL),
(15, 49388, 167, NULL, NULL, '2024-10-30 11:18:14', NULL),
(16, 49389, 167, NULL, NULL, '2024-10-30 11:18:14', NULL),
(17, 49390, 167, NULL, NULL, '2024-10-30 11:18:14', NULL),
(22, 49392, 164, NULL, NULL, '2024-11-03 23:49:54', NULL),
(26, 49394, 169, NULL, NULL, '2024-11-04 00:25:17', NULL),
(27, 49395, 169, NULL, NULL, '2024-11-04 00:25:17', NULL),
(28, 49396, 163, NULL, NULL, '2024-11-04 00:29:34', NULL),
(29, 49397, 163, NULL, NULL, '2024-11-04 00:29:34', NULL),
(30, 49398, 169, NULL, NULL, '2024-11-04 09:03:12', NULL),
(31, 49398, 169, NULL, NULL, '2024-11-04 09:04:09', NULL),
(32, 49399, 162, NULL, NULL, '2024-11-04 09:29:31', NULL),
(33, 49400, 167, NULL, NULL, '2024-11-04 10:27:26', NULL),
(45, 49405, 173, NULL, NULL, '2024-11-06 23:19:16', NULL),
(46, 49405, 173, NULL, NULL, '2024-11-06 23:19:42', NULL),
(47, 49405, 173, NULL, NULL, '2024-11-06 23:24:22', NULL),
(48, 49405, 173, NULL, NULL, '2024-11-06 23:28:33', NULL),
(52, 49406, 190, NULL, NULL, '2024-11-07 19:34:57', NULL),
(53, 49404, 190, NULL, NULL, '2024-11-07 19:42:57', NULL),
(54, 49401, 190, NULL, NULL, '2024-11-07 19:52:31', NULL),
(55, 49405, 173, NULL, NULL, '2024-11-07 20:07:43', NULL),
(57, 49408, 213, NULL, NULL, '2024-11-09 18:05:51', NULL),
(59, 49410, 202, NULL, NULL, '2024-11-09 18:43:42', NULL),
(60, 49410, 202, NULL, NULL, '2024-11-09 18:46:26', NULL),
(63, 49413, 203, 'maladie', NULL, '2024-11-10 22:44:59', NULL),
(64, 49414, 203, 'maladie 2', NULL, '2024-11-10 22:52:10', NULL),
(65, 49415, 69, 'dossier manager de site', NULL, '2024-11-12 00:28:23', NULL),
(79, 49426, 216, 'test camer et select', NULL, '2024-11-12 23:36:30', NULL),
(80, 49427, 246, 'other test', NULL, '2024-11-12 23:52:35', NULL),
(81, 49428, 246, 'other test camera', NULL, '2024-11-12 23:55:51', NULL),
(82, 49429, 246, 'tt', NULL, '2024-11-13 09:07:23', NULL),
(83, 49429, 246, 'tt', NULL, '2024-11-13 09:24:50', NULL),
(84, 49430, 246, 'bbb', NULL, '2024-11-13 09:27:05', NULL),
(168, 49496, 251, 'test camera video', NULL, '2024-11-17 00:24:48', NULL),
(169, 49497, 251, 'Tt', NULL, '2024-11-17 16:39:52', NULL),
(170, 49498, 251, 'Tttvkbv', NULL, '2024-11-17 16:51:44', NULL),
(171, 49499, 251, 'Tttttttttttt', NULL, '2024-11-17 17:42:55', NULL),
(172, 49500, 251, 'Tttttttttttt6', NULL, '2024-11-17 17:44:08', NULL),
(173, 49501, 248, 'Jjj', NULL, '2024-11-17 17:56:31', NULL),
(174, 49502, 248, 'Jjj', NULL, '2024-11-17 17:56:31', NULL),
(175, 49503, 251, 'testvideo_video', NULL, '2024-11-18 00:10:09', NULL),
(176, 49504, 251, 'testvideoetpdf', NULL, '2024-11-18 00:11:36', NULL),
(177, 49505, 251, 'testvideoetpdf_video', NULL, '2024-11-18 00:11:36', NULL),
(184, 49512, 277, '123', NULL, '2024-11-18 14:18:00', NULL),
(185, 49513, 277, 'Dupont ', NULL, '2024-11-18 14:22:41', NULL),
(186, 49514, 277, 'Dupont ', NULL, '2024-11-18 14:22:41', NULL),
(187, 49515, 277, 'Jacquot ', NULL, '2024-11-18 14:44:28', NULL),
(188, 49516, 277, 'teeeesthettt', NULL, '2024-11-20 23:36:47', NULL),
(189, 49517, 303, 'azertyuio', NULL, '2024-11-22 00:44:24', NULL),
(190, 49518, 303, 'azertyhhhh', NULL, '2024-11-22 00:50:45', NULL),
(191, 49519, 303, 'wxcvbn', NULL, '2024-11-22 00:53:24', NULL),
(192, 49520, 303, 'fouleeen', NULL, '2024-11-22 00:56:23', NULL),
(193, 49521, 303, 'nabila nabila', NULL, '2024-11-22 01:03:08', NULL),
(194, 49522, 303, 'maladie dentaire', NULL, '2024-11-22 08:09:13', NULL),
(195, 49523, 304, 'testfortest', NULL, '2024-11-23 23:10:35', NULL),
(196, 49524, 304, '', NULL, '2024-11-23 23:57:27', NULL),
(197, 49525, 304, '', NULL, '2024-11-23 23:58:56', NULL),
(198, 49526, 304, 'testfortest', NULL, '2024-11-24 00:05:59', NULL),
(199, 49527, 304, '', NULL, '2024-11-24 00:07:40', NULL),
(200, 49528, 304, 'testtesta', NULL, '2024-11-24 00:08:47', NULL),
(201, 49529, 304, 'testhhh', NULL, '2024-11-24 00:10:38', NULL),
(202, 49530, 304, 'testtesttest', NULL, '2024-11-24 00:12:51', NULL),
(203, 49531, 304, 'testtesthhh', NULL, '2024-11-24 00:14:33', NULL),
(204, 49532, 304, 'testtesthhh11', NULL, '2024-11-24 00:14:52', NULL),
(205, 49533, 304, 'newtestupdate', NULL, '2024-11-24 00:18:08', NULL),
(206, 49534, 304, 'newgg', NULL, '2024-11-24 00:21:00', NULL),
(207, 49535, 304, 'newcc', NULL, '2024-11-24 00:24:07', NULL),
(208, 49536, 304, 'testhere', NULL, '2024-11-24 00:58:10', NULL),
(209, 49537, 304, 'timeout', NULL, '2024-11-24 00:59:19', NULL),
(210, 49538, 304, 'bienvenue', NULL, '2024-11-24 01:04:33', NULL),
(211, 49539, 304, 'bienvenue 2', NULL, '2024-11-24 01:07:21', NULL),
(212, 49540, 304, 'tunisia', NULL, '2024-11-24 01:20:57', NULL),
(213, 49541, 304, 'tunis', NULL, '2024-11-24 01:23:14', NULL),
(214, 49542, 304, 'tunis11', NULL, '2024-11-24 01:26:47', NULL),
(215, 49543, 304, 'tunisia2020', NULL, '2024-11-24 01:31:13', NULL),
(216, 49544, 304, 'tunisia2021', NULL, '2024-11-24 01:34:44', NULL),
(217, 49545, 304, 'forlast', NULL, '2024-11-24 01:43:53', NULL),
(218, 49546, 304, 'this', NULL, '2024-11-24 01:53:53', NULL),
(219, 49547, 304, 'finn', NULL, '2024-11-24 01:57:20', NULL),
(220, 49548, 304, 'testnabila', NULL, '2024-11-24 14:00:52', NULL),
(221, 49549, 304, 'hola', NULL, '2024-11-24 14:09:38', NULL),
(222, 49550, 304, 'hihi', NULL, '2024-11-24 14:13:14', NULL),
(223, 49551, 304, 'hihi2', NULL, '2024-11-24 14:22:55', NULL),
(231, 49559, 304, 'nomjustt', NULL, '2024-11-24 15:52:02', NULL),
(232, 49560, 304, 'testhh', NULL, '2024-11-24 23:40:27', NULL),
(233, 49561, 304, 'trrrht', NULL, '2024-11-24 23:43:31', NULL),
(235, 49563, 304, 'vvghff', NULL, '2024-11-24 23:49:02', NULL),
(239, 49567, 304, 'testdepart', NULL, '2024-11-25 00:39:00', NULL),
(240, 49568, 304, 'depar', NULL, '2024-11-25 00:44:07', NULL),
(250, 49584, 304, 'testarrrrivh', 1, '2024-11-25 01:44:39', NULL),
(251, 49585, 304, 'testarrfff', 1, '2024-11-25 01:56:50', NULL),
(258, 49587, 304, 'null', 1, '2024-11-25 02:18:23', NULL),
(267, 49596, 304, 'BonjourJusitfArrive', 1, '2024-11-25 08:16:39', NULL),
(268, 49597, 304, 'bonjj', 1, '2024-11-25 08:21:15', NULL),
(269, 49598, 304, 'bonjrDepart', 0, '2024-11-25 08:21:47', NULL),
(272, 49601, 303, 'testbj', 1, '2024-11-25 09:29:24', NULL),
(273, 49602, 304, 'test555', 1, '2024-11-25 09:30:50', NULL),
(274, 49603, 303, 'bnjdepart2', 0, '2024-11-25 09:32:16', NULL),
(275, 49604, 303, 'morning', 0, '2024-11-25 09:33:16', NULL),
(283, 49612, 316, 'testadminarrive', 1, '2024-11-25 11:00:35', NULL),
(287, 49616, 316, 'test new admin new', 1, '2024-11-25 11:52:50', NULL),
(290, 49619, 320, 'accident', 1, '2024-11-26 10:53:49', NULL),
(291, 49620, 320, 'urgence', 0, '2024-11-26 12:56:28', NULL),
(292, 49621, 320, 'cause urgente _video', 0, '2024-11-26 15:06:53', NULL),
(293, 49622, 319, 'frflllkk', 0, '2024-11-26 18:05:24', NULL),
(296, 49625, 320, 'Hhh_video', 1, '2024-11-27 08:43:03', NULL),
(297, 49626, 319, 'Ooo_video', 1, '2024-11-27 09:13:06', NULL),
(298, 49627, 319, 'Pppppp_video', 1, '2024-11-27 09:15:17', NULL),
(299, 49628, 319, 'Bbnj_video', 1, '2024-11-27 09:27:04', NULL),
(322, 49651, 319, 'Nnbb', 1, '2024-11-27 10:42:31', NULL),
(323, 49652, 319, 'Nnbb_video', 1, '2024-11-27 10:42:31', NULL),
(324, 49653, 317, 'Vvccxx', 1, '2024-11-27 10:47:51', NULL),
(325, 49654, 317, 'Vvccxx_video', 1, '2024-11-27 10:47:51', NULL),
(326, 49655, 317, 'Nounou', 1, '2024-11-27 10:57:44', NULL),
(327, 49656, 317, 'Nounou_video', 1, '2024-11-27 10:57:44', NULL),
(328, 49657, 303, 'Jjbbb', 1, '2024-11-27 11:03:23', NULL),
(329, 49658, 303, 'Jjbbb_video', 1, '2024-11-27 11:03:23', NULL),
(330, 49659, 305, 'Bjdjdjd', 1, '2024-11-27 11:05:28', NULL),
(331, 49660, 305, 'Bjdjdjd_video', 1, '2024-11-27 11:05:28', NULL),
(332, 49661, 305, 'Pppo', 0, '2024-11-27 11:06:35', NULL),
(333, 49662, 305, 'Pppo_video', 0, '2024-11-27 11:06:35', NULL),
(334, 49663, 317, 'nnb', 1, '2024-11-27 11:47:10', NULL),
(335, 49664, 319, 'Jjjjkkkl', 1, '2024-11-27 12:54:56', NULL),
(338, 49667, 321, 'Accident bus/metro', 1, '2024-11-27 13:21:18', NULL),
(339, 49668, 321, 'Mal du dos', 0, '2024-11-27 13:47:14', NULL),
(341, 49670, 321, 'Mal du dos et des pieds ', 0, '2024-11-27 13:52:29', NULL),
(387, 49716, 325, 'cas urg', 1, '2024-11-28 13:35:23', NULL),
(388, 49717, 325, 'cas urgent2', 1, '2024-11-28 13:36:02', NULL),
(389, 49718, 325, 'maladie hormonale_video', 0, '2024-11-28 13:41:35', NULL),
(390, 49719, 321, 'maladie hormonale', 0, '2024-11-28 23:35:46', NULL),
(391, 49720, 321, 'frflllkkcc', 0, '2024-11-28 23:36:57', NULL),
(392, 49721, 321, 'ddde', 0, '2024-11-28 23:39:39', NULL),
(393, 49722, 321, 'dezd', 0, '2024-11-28 23:44:57', NULL),
(394, 49723, 321, 'testtestliil', 0, '2024-11-29 00:17:09', NULL),
(396, 49725, 345, 'retard bus manouba', 1, '2024-11-29 07:39:20', NULL),
(399, 49728, 345, 'bureau d\'emploi', 0, '2024-11-29 07:50:32', NULL),
(401, 49730, 346, 'testhaho1', 1, '2024-11-29 09:47:20', NULL),
(402, 49731, 346, 'hihihihihohoho', 1, '2024-11-29 09:49:39', NULL),
(403, 49732, 346, 'ghanja', 1, '2024-11-29 09:52:09', NULL),
(450, 49779, 367, 'Metro', 1, '2024-12-05 10:04:40', NULL),
(451, 49780, 367, 'Metro2', 1, '2024-12-05 10:11:17', NULL),
(452, 49781, 367, 'Metro3', 0, '2024-12-05 10:32:06', NULL),
(453, 49782, 367, 'Metro4', 0, '2024-12-05 10:34:12', NULL),
(456, 49785, 367, 'xwcw', 1, '2024-12-07 11:43:18', NULL),
(457, 49786, 374, 'jjjj', 1, '2024-12-07 11:50:10', NULL),
(458, 49787, 418, 'maison', 1, '2024-12-09 07:42:29', NULL),
(479, 49808, 487, 'Pj_487_photo_1.jpg', 1, '2024-12-16 15:51:30', NULL),
(493, 49822, 511, 'nabila', 1, '2024-12-18 08:10:59', NULL),
(494, 49823, 517, 'nabila1', 1, '2024-12-19 13:12:23', NULL),
(495, 49824, 517, 'nabila2', 1, '2024-12-19 13:12:23', NULL),
(499, 49828, 538, 'tffeee', 1, '2024-12-23 00:27:08', NULL),
(500, 49829, 538, 'vrrs', 1, '2024-12-23 00:27:48', NULL),
(501, 49830, 545, 'bb1', 1, '2024-12-23 07:28:39', NULL),
(504, 49833, 545, 'bb1', 1, '2024-12-23 07:34:46', NULL),
(0, 49829, 485, 'Pj_538_vrrs_20241223022748.jpg', NULL, '2025-01-08 10:36:41', NULL),
(505, 49829, 485, 'Pj_538_vrrs_20241223022748.jpg', NULL, '2025-01-08 10:37:31', NULL),
(0, 49846, 530, ' ', 1, '2025-01-10 10:08:03', 0),
(0, 49847, 530, 'q', 1, '2025-01-10 10:09:56', 0),
(0, 49848, 530, 'q', 1, '2025-01-10 10:12:13', 0),
(0, 49849, 530, 'a', 1, '2025-01-10 10:14:52', 0),
(0, 49850, 530, '1', 1, '2025-01-10 10:15:19', 0),
(0, 49851, 530, 'w', 1, '2025-01-10 10:18:36', 0),
(0, 49852, 530, 'a', 1, '2025-01-10 10:20:30', 0),
(0, 49853, 511, 'Unnamed_Document_0', 0, '2025-01-10 10:39:24', 0),
(0, 49854, 511, 'w', 1, '2025-01-10 10:39:53', 0),
(0, 49855, 511, 'u', 0, '2025-01-10 10:41:36', 0),
(0, 49856, 511, 'q', 0, '2025-01-10 10:42:51', 0),
(0, 49857, 374, 'a', NULL, '2025-01-10 10:44:30', 1),
(0, 49858, 374, 'a', NULL, '2025-01-10 10:44:36', 1),
(0, 49859, 511, 'a', 0, '2025-01-10 11:31:35', 0),
(0, 49860, 511, 'q', 0, '2025-01-10 11:38:17', 0),
(0, 49861, 511, 'a', 0, '2025-01-10 13:54:17', 0),
(0, 49862, 505, 'Unnamed_Document_0', 1, '2025-01-10 13:55:24', 0),
(0, 49863, 505, 't', 1, '2025-01-10 13:56:11', 0),
(0, 49864, 190, 'a', 1, '2025-01-10 14:54:31', 0),
(0, 49865, 190, 'a', 1, '2025-01-10 14:55:16', 0),
(0, 49866, 190, 'a', 1, '2025-01-10 14:56:42', 0),
(0, 49867, 366, 'j', 1, '2025-01-10 14:58:55', 0),
(0, 49868, 366, 'j', 0, '2025-01-10 14:59:36', 0),
(0, 49869, 202, 'j', NULL, '2025-01-10 15:00:23', 1),
(0, 49870, 505, 'n', 1, '2025-01-13 08:38:33', 0),
(0, 49871, 505, 'J', 0, '2025-01-13 08:39:24', 0),
(0, 49872, 347, 'n', NULL, '2025-01-14 13:53:38', 1),
(0, 49873, 487, 'a', NULL, '2025-01-20 08:17:37', 1),
(0, 49874, 487, 'q', NULL, '2025-01-20 09:07:59', 1),
(0, 49875, 487, 'A', NULL, '2025-01-20 09:11:51', 1),
(0, 49876, 487, 'a', NULL, '2025-01-20 09:14:54', 1),
(0, 49877, 487, NULL, NULL, '2025-01-20 09:31:32', 1),
(0, 49878, 487, NULL, NULL, '2025-01-20 09:39:44', 1),
(0, 49879, 487, NULL, NULL, '2025-01-20 09:40:43', 1),
(0, 49880, 487, NULL, NULL, '2025-01-20 09:45:35', 1),
(0, 49881, 487, NULL, NULL, '2025-01-20 10:47:32', 1),
(0, 49882, 487, NULL, NULL, '2025-01-20 10:47:32', 1),
(0, 49883, 487, NULL, NULL, '2025-01-20 10:47:55', 1),
(0, 49884, 487, NULL, NULL, '2025-01-20 10:47:55', 1),
(0, 49885, 487, NULL, NULL, '2025-01-20 10:54:31', 1),
(0, 49886, 487, NULL, NULL, '2025-01-20 11:06:42', 1),
(0, 49887, 325, NULL, 1, '2025-01-20 11:09:51', 0);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_document_requis`
--

CREATE TABLE `wbcc_document_requis` (
  `idDocumentRequis` int(11) NOT NULL,
  `libelleDocumentRequis` varchar(255) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `createDate` varchar(25) DEFAULT current_timestamp(),
  `editDate` varchar(25) DEFAULT current_timestamp(),
  `idAuteur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_document_requis_subvention`
--

CREATE TABLE `wbcc_document_requis_subvention` (
  `idDocumentRequisSubvention` int(11) NOT NULL,
  `idDocumentRequisF` int(11) DEFAULT NULL,
  `idSubventionF` int(11) DEFAULT NULL,
  `etatDocumentRequisSubvention` int(11) DEFAULT NULL COMMENT 'Obligatoire ou Facultatif',
  `editDate` varchar(25) DEFAULT current_timestamp(),
  `createDate` varchar(25) DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_encaissement`
--

CREATE TABLE `wbcc_encaissement` (
  `idEncaissement` int(11) NOT NULL,
  `numeroEncaissement` varchar(50) DEFAULT NULL,
  `dateEncaissement` varchar(25) DEFAULT NULL,
  `dateEnreg` varchar(35) DEFAULT NULL,
  `typeEncaissement` varchar(100) DEFAULT NULL COMMENT 'Devis ou Franchise ou ',
  `montantEncaissement` varchar(100) DEFAULT NULL,
  `tireur` varchar(255) DEFAULT NULL,
  `donneurOrdre` varchar(255) DEFAULT NULL,
  `artisan` varchar(255) DEFAULT NULL,
  `idOPEncaissement` int(11) DEFAULT NULL,
  `nameOPEncaissement` varchar(25) DEFAULT NULL,
  `typeReglement` varchar(100) DEFAULT NULL COMMENT 'Virement ou Chèque',
  `montantAEncaisser` varchar(100) DEFAULT NULL,
  `idAuteurEncaissement` int(11) DEFAULT NULL,
  `auteurEncaissement` varchar(255) DEFAULT NULL,
  `modeReglement` varchar(100) DEFAULT NULL COMMENT 'En une seule fois / En deux temps',
  `commentaireEncaissement` text DEFAULT NULL,
  `journalFile` varchar(150) DEFAULT NULL,
  `idDevisF` int(11) DEFAULT NULL,
  `idChequeF` int(11) DEFAULT NULL,
  `irregulariteImmediat` int(11) DEFAULT 0,
  `mntIrreguraliteImmediat` varchar(100) DEFAULT NULL,
  `irregulariteDiffere` int(11) DEFAULT 0,
  `mntIrreguraliteDiffere` varchar(100) DEFAULT NULL,
  `idCompteBancaireF` int(5) DEFAULT NULL,
  `numeroCompteBancaire` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_encaissement`
--

INSERT INTO `wbcc_encaissement` (`idEncaissement`, `numeroEncaissement`, `dateEncaissement`, `dateEnreg`, `typeEncaissement`, `montantEncaissement`, `tireur`, `donneurOrdre`, `artisan`, `idOPEncaissement`, `nameOPEncaissement`, `typeReglement`, `montantAEncaisser`, `idAuteurEncaissement`, `auteurEncaissement`, `modeReglement`, `commentaireEncaissement`, `journalFile`, `idDevisF`, `idChequeF`, `irregulariteImmediat`, `mntIrreguraliteImmediat`, `irregulariteDiffere`, `mntIrreguraliteDiffere`, `idCompteBancaireF`, `numeroCompteBancaire`) VALUES
(1, 'ENC_4002_230720244', '2024-07-18', NULL, 'devis -Encaissement Immédiat -Encaissement Immédiat', '400', NULL, NULL, NULL, 4002, 'OP2024-01-19-0137', 'Chèque', '500', 4, 'Aicha Diagne', 'En Deux Temps', 'test encaissement chèque', NULL, 6, 14, 0, NULL, 1, '100', NULL, NULL),
(2, 'ENC_4002_230720244', '2024-07-18', NULL, 'devis -Encaissement Immédiat -Encaissement Différé', '400', NULL, NULL, NULL, 4002, 'OP2024-01-19-0137', 'Chèque', '500', 4, 'Aicha Diagne', 'En Deux Temps', 'test encaissement chèque', NULL, 6, 14, 0, NULL, 0, NULL, NULL, NULL),
(3, 'ENC_4002_230720244', '2024-07-16', '23-07-2024 15:06', 'devis -Encaissement Immédiat -Encaissement Différé', '400', NULL, NULL, NULL, 4002, 'OP2024-01-19-0137', 'Chèque', '500', 4, 'Aicha Diagne', 'En Deux Temps', 'test comment confirmation encaissement chèque', NULL, 6, 14, 0, NULL, 0, NULL, NULL, NULL),
(4, 'ENC_3997_240720244', '2024-07-10', '24-07-2024 15:59', 'devis -Encaissement Immédiat', '500', NULL, NULL, NULL, 3997, 'OP2024-01-19-0136', 'Virement', '500', 4, 'Aicha Diagne', '', 'azdza', NULL, 9, 0, 0, NULL, 0, NULL, 5, 'FR7616958000018248503263004'),
(5, 'ENC_4002_250720244', '2024-07-10', '25-07-2024 09:49', 'devis -Encaissement Différé', '500', 'AXAA', NULL, NULL, 4002, 'OP2024-01-19-0137', 'Virement', '100', 4, 'Aicha Diagne', 'En Deux Temps', 'tesr', NULL, 6, 0, 0, NULL, 1, '-400', 3, 'FR7616958000016448916615984'),
(6, 'ENC_4002_250720244', '2024-07-16', '25-07-2024 10:58', 'devis -Encaissement Différé -Encaissement Différé', '100', 'AXAA', 'Aicha DUPONT', 'FRANCE TRAVAUX', 4002, 'OP2024-01-19-0137', 'Chèque', '100', 4, 'Aicha Diagne', 'En Deux Temps', 'rttr', NULL, 6, 18, 0, NULL, 0, NULL, 4, 'FR7616958000011154821882644');

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_historique`
--

CREATE TABLE `wbcc_historique` (
  `idHistorique` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `nomComplet` varchar(255) NOT NULL,
  `dateAction` timestamp NOT NULL DEFAULT current_timestamp(),
  `heureAction` datetime DEFAULT NULL,
  `idUtilisateurF` int(11) NOT NULL,
  `idOpportunityF` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_historique`
--

INSERT INTO `wbcc_historique` (`idHistorique`, `action`, `nomComplet`, `dateAction`, `heureAction`, `idUtilisateurF`, `idOpportunityF`) VALUES
(1, 'Connexion', 'Jawher BALTI', '2024-12-18 09:17:48', NULL, 1, NULL),
(2, 'Déconnexion', 'Jawher BALTI', '2024-12-19 16:22:51', NULL, 1, NULL),
(3, 'Connexion', 'Jawher BALTI', '2024-12-19 16:22:57', NULL, 1, NULL),
(4, 'Déconnexion', 'Jawher BALTI', '2024-12-19 16:23:05', NULL, 1, NULL),
(5, 'Connexion', 'Jawher BALTI', '2024-12-19 16:23:42', NULL, 1, NULL),
(6, 'Déconnexion', 'Jawher BALTI', '2024-12-19 16:46:12', NULL, 1, NULL),
(7, 'Connexion', 'Jawher BALTI', '2024-12-19 16:46:17', NULL, 1, NULL),
(8, 'Déconnexion', 'Jawher BALTI', '2024-12-19 16:46:25', NULL, 1, NULL),
(9, 'Connexion', 'Jawher BALTI', '2024-12-19 16:46:43', NULL, 1, NULL),
(10, 'Déconnexion', 'Jawher BALTI', '2024-12-19 16:47:18', NULL, 1, NULL),
(11, 'Connexion', 'Jawher BALTI', '2024-12-19 16:47:40', NULL, 1, NULL),
(12, 'Déconnexion', 'Jawher BALTI', '2024-12-19 16:55:16', NULL, 1, NULL),
(13, 'Connexion', 'Jawher BALTI', '2024-12-19 16:55:21', NULL, 1, NULL),
(14, 'Déconnexion', 'Jawher BALTI', '2024-12-20 07:56:09', NULL, 1, NULL),
(15, 'Connexion', 'Jawher BALTI', '2024-12-20 07:56:13', NULL, 1, NULL),
(16, 'Déconnexion', 'Jawher BALTI', '2024-12-20 09:41:27', NULL, 1, NULL),
(17, 'Connexion', 'Jawher BALTI', '2024-12-20 09:41:32', NULL, 1, NULL),
(18, 'Déconnexion', 'Jawher BALTI', '2024-12-20 10:33:43', NULL, 1, NULL),
(19, 'Connexion', 'Jawher BALTI', '2024-12-20 10:33:48', NULL, 1, NULL),
(20, 'Déconnexion', 'Jawher BALTI', '2024-12-20 10:33:56', NULL, 1, NULL),
(21, 'Connexion', 'Jawher BALTI', '2024-12-20 10:34:11', NULL, 1, NULL),
(22, 'Déconnexion', 'Jawher BALTI', '2024-12-20 10:57:51', NULL, 1, NULL),
(23, 'Connexion', 'Jawher BALTI', '2024-12-20 10:57:56', NULL, 1, NULL),
(24, 'Déconnexion', 'Jawher BALTI', '2024-12-20 11:03:02', NULL, 1, NULL),
(25, 'Connexion', 'Jawher BALTI', '2024-12-20 11:03:07', NULL, 1, NULL),
(26, 'Déconnexion', 'Jawher BALTI', '2024-12-20 14:15:09', NULL, 1, NULL),
(27, 'Connexion', 'Jawher BALTI', '2024-12-20 14:15:15', NULL, 1, NULL),
(28, 'Déconnexion', 'Jawher BALTI', '2024-12-20 14:15:31', NULL, 1, NULL),
(29, 'Connexion', 'Jawher BALTI', '2024-12-20 14:15:36', NULL, 1, NULL),
(30, 'Déconnexion', 'Jawher BALTI', '2024-12-20 14:15:39', NULL, 1, NULL),
(31, 'Connexion', 'Jawher BALTI', '2024-12-20 14:15:52', NULL, 1, NULL),
(32, 'Déconnexion', 'Jawher BALTI', '2024-12-20 15:28:47', NULL, 1, NULL),
(33, 'Connexion', 'Jawher BALTI', '2024-12-20 15:28:50', NULL, 1, NULL),
(34, 'Déconnexion', 'Jawher BALTI', '2024-12-20 15:29:00', NULL, 1, NULL),
(35, 'Connexion', 'Jawher BALTI', '2024-12-20 15:29:27', NULL, 1, NULL),
(36, 'Déconnexion', 'Jawher BALTI', '2024-12-20 15:32:11', NULL, 1, NULL),
(37, 'Connexion', 'Jawher BALTI', '2024-12-20 15:32:17', NULL, 1, NULL),
(38, 'Déconnexion', 'Jawher BALTI', '2024-12-20 16:20:11', NULL, 1, NULL),
(39, 'Connexion', 'Jawher BALTI', '2024-12-20 16:20:15', NULL, 1, NULL),
(40, 'Déconnexion', 'Jawher BALTI', '2024-12-20 16:21:12', NULL, 1, NULL),
(41, 'Connexion', 'Jawher BALTI', '2024-12-20 16:21:17', NULL, 1, NULL),
(42, 'Connexion', 'Jawher BALTI', '2024-12-23 08:01:21', NULL, 1, NULL),
(43, 'Déconnexion', 'Jawher BALTI', '2024-12-23 08:55:30', NULL, 1, NULL),
(44, 'Connexion', 'Jawher BALTI', '2024-12-23 08:55:44', NULL, 1, NULL),
(45, 'Déconnexion', 'Jawher BALTI', '2024-12-23 08:59:29', NULL, 1, NULL),
(46, 'Connexion', 'Jawher BALTI', '2024-12-23 08:59:34', NULL, 1, NULL),
(47, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:03:13', NULL, 1, NULL),
(48, 'Connexion', 'Jawher BALTI', '2024-12-23 09:03:18', NULL, 1, NULL),
(49, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:11:13', NULL, 1, NULL),
(50, 'Connexion', 'Jawher BALTI', '2024-12-23 09:11:18', NULL, 1, NULL),
(51, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:14:20', NULL, 1, NULL),
(52, 'Connexion', 'Jawher BALTI', '2024-12-23 09:14:25', NULL, 1, NULL),
(53, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:20:33', NULL, 1, NULL),
(54, 'Connexion', 'Jawher BALTI', '2024-12-23 09:20:37', NULL, 1, NULL),
(55, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:22:01', NULL, 1, NULL),
(56, 'Connexion', 'Jawher BALTI', '2024-12-23 09:22:06', NULL, 1, NULL),
(57, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:28:35', NULL, 1, NULL),
(58, 'Connexion', 'Jawher BALTI', '2024-12-23 09:28:39', NULL, 1, NULL),
(59, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:31:37', NULL, 1, NULL),
(60, 'Connexion', 'Jawher BALTI', '2024-12-23 09:31:42', NULL, 1, NULL),
(61, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:34:29', NULL, 1, NULL),
(62, 'Connexion', 'Jawher BALTI', '2024-12-23 09:34:34', NULL, 1, NULL),
(63, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:47:31', NULL, 1, NULL),
(64, 'Connexion', 'Jawher BALTI', '2024-12-23 09:47:36', NULL, 1, NULL),
(65, 'Déconnexion', 'Jawher BALTI', '2024-12-23 09:56:07', NULL, 1, NULL),
(66, 'Connexion', 'Jawher BALTI', '2024-12-23 09:56:11', NULL, 1, NULL),
(67, 'Déconnexion', 'Jawher BALTI', '2024-12-23 10:52:29', NULL, 1, NULL),
(68, 'Connexion', 'Jawher BALTI', '2024-12-23 10:52:33', NULL, 1, NULL),
(69, 'Déconnexion', 'Jawher BALTI', '2024-12-23 10:54:26', NULL, 1, NULL),
(70, 'Connexion', 'Jawher BALTI', '2024-12-23 10:54:30', NULL, 1, NULL),
(71, 'Déconnexion', 'Jawher BALTI', '2024-12-23 11:22:20', NULL, 1, NULL),
(72, 'Connexion', 'Jawher BALTI', '2024-12-23 11:22:24', NULL, 1, NULL),
(73, 'Déconnexion', 'Jawher BALTI', '2024-12-23 11:22:52', NULL, 1, NULL),
(74, 'Connexion', 'Jawher BALTI', '2024-12-23 11:23:14', NULL, 1, NULL),
(75, 'Déconnexion', 'Jawher BALTI', '2024-12-23 12:54:19', NULL, 1, NULL),
(76, 'Connexion', 'Jawher BALTI', '2024-12-23 12:54:24', NULL, 1, NULL),
(77, 'Déconnexion', 'Jawher BALTI', '2024-12-23 13:21:09', NULL, 1, NULL),
(78, 'Connexion', 'Jawher BALTI', '2024-12-23 13:21:14', NULL, 1, NULL),
(79, 'Déconnexion', 'Jawher BALTI', '2024-12-23 13:22:35', NULL, 1, NULL),
(80, 'Connexion', 'Jawher BALTI', '2024-12-23 13:22:40', NULL, 1, NULL),
(81, 'Déconnexion', 'Jawher BALTI', '2024-12-23 13:28:58', NULL, 1, NULL),
(82, 'Connexion', 'Jawher BALTI', '2024-12-23 13:29:02', NULL, 1, NULL),
(83, 'Déconnexion', 'Jawher BALTI', '2024-12-23 14:26:04', NULL, 1, NULL),
(84, 'Connexion', 'Jawher BALTI', '2024-12-23 14:26:10', NULL, 1, NULL),
(85, 'Déconnexion', 'Jawher BALTI', '2024-12-23 14:33:52', NULL, 1, NULL),
(86, 'Connexion', 'Jawher BALTI', '2024-12-23 14:33:57', NULL, 1, NULL),
(87, 'Déconnexion', 'Jawher BALTI', '2024-12-23 14:34:22', NULL, 1, NULL),
(88, 'Connexion', 'Jawher BALTI', '2024-12-23 14:34:38', NULL, 1, NULL),
(89, 'Déconnexion', 'Jawher BALTI', '2024-12-23 14:51:48', NULL, 1, NULL),
(90, 'Connexion', 'Jawher BALTI', '2024-12-23 14:51:52', NULL, 1, NULL),
(91, 'Déconnexion', 'Jawher BALTI', '2024-12-23 14:53:30', NULL, 1, NULL),
(92, 'Connexion', 'Jawher BALTI', '2024-12-23 14:53:36', NULL, 1, NULL),
(93, 'Déconnexion', 'Jawher BALTI', '2024-12-23 14:55:38', NULL, 1, NULL),
(94, 'Connexion', 'Jawher BALTI', '2024-12-23 14:55:44', NULL, 1, NULL),
(95, 'Déconnexion', 'Jawher BALTI', '2024-12-23 14:59:47', NULL, 1, NULL),
(96, 'Connexion', 'Jawher BALTI', '2024-12-23 14:59:51', NULL, 1, NULL),
(97, 'Déconnexion', 'Jawher BALTI', '2024-12-23 15:03:11', NULL, 1, NULL),
(98, 'Connexion', 'Jawher BALTI', '2024-12-23 15:03:15', NULL, 1, NULL),
(99, 'Déconnexion', 'Jawher BALTI', '2024-12-23 15:03:42', NULL, 1, NULL),
(100, 'Connexion', 'Jawher BALTI', '2024-12-23 15:03:47', NULL, 1, NULL),
(101, 'Déconnexion', 'Jawher BALTI', '2024-12-23 15:31:42', NULL, 1, NULL),
(102, 'Connexion', 'Jawher BALTI', '2024-12-23 15:31:46', NULL, 1, NULL),
(103, 'Déconnexion', 'Jawher BALTI', '2024-12-23 15:32:11', NULL, 1, NULL),
(104, 'Connexion', 'Jawher BALTI', '2024-12-23 15:32:15', NULL, 1, NULL),
(105, 'Déconnexion', 'Jawher BALTI', '2024-12-23 15:33:58', NULL, 1, NULL),
(106, 'Connexion', 'Jawher BALTI', '2024-12-23 15:34:03', NULL, 1, NULL),
(107, 'Déconnexion', 'Jawher BALTI', '2024-12-23 15:34:31', NULL, 1, NULL),
(108, 'Connexion', 'Jawher BALTI', '2024-12-23 15:34:35', NULL, 1, NULL),
(109, 'Déconnexion', 'Jawher BALTI', '2024-12-23 16:23:42', NULL, 1, NULL),
(110, 'Connexion', 'Jawher BALTI', '2024-12-23 16:23:46', NULL, 1, NULL),
(111, 'Déconnexion', 'Jawher BALTI', '2024-12-23 16:26:05', NULL, 1, NULL),
(112, 'Connexion', 'Jawher BALTI', '2024-12-23 16:26:10', NULL, 1, NULL),
(113, 'Déconnexion', 'Jawher BALTI', '2024-12-23 16:26:53', NULL, 1, NULL),
(114, 'Connexion', 'Jawher BALTI', '2024-12-23 16:26:58', NULL, 1, NULL),
(115, 'Connexion', 'Jawher BALTI', '2025-01-07 11:02:04', NULL, 1, NULL),
(116, 'Déconnexion', 'Jawher BALTI', '2025-01-07 11:03:44', NULL, 1, NULL),
(117, 'Connexion', 'Jawher BALTI', '2025-01-07 11:03:48', NULL, 1, NULL),
(118, 'Déconnexion', 'Jawher BALTI', '2025-01-07 11:04:55', NULL, 1, NULL),
(119, 'Connexion', 'Jawher BALTI', '2025-01-07 11:04:59', NULL, 1, NULL),
(120, 'Déconnexion', 'Jawher BALTI', '2025-01-07 11:14:21', NULL, 1, NULL),
(121, 'Connexion', 'Jawher BALTI', '2025-01-07 11:14:25', NULL, 1, NULL),
(122, 'Connexion', 'Jawher BALTI', '2025-01-08 10:21:47', NULL, 1, NULL),
(123, 'Déconnexion', 'Jawher BALTI', '2025-01-09 08:25:12', NULL, 1, NULL),
(124, 'Connexion', 'Jawher BALTI', '2025-01-09 08:25:51', NULL, 1, NULL),
(125, 'Déconnexion', 'Jawher BALTI', '2025-01-09 08:27:37', NULL, 1, NULL),
(126, 'Connexion', 'Hamza DRIDI', '2025-01-09 08:28:03', NULL, 609, NULL),
(127, 'Déconnexion', 'Hamza DRIDI', '2025-01-09 08:31:25', NULL, 609, NULL),
(128, 'Connexion', 'Jawher BALTI', '2025-01-09 08:31:44', NULL, 1, NULL),
(129, 'Déconnexion', 'Jawher BALTI', '2025-01-09 08:31:55', NULL, 1, NULL),
(130, 'Connexion', 'Jawher BALTI', '2025-01-09 08:32:31', NULL, 1, NULL),
(131, 'Déconnexion', 'Jawher BALTI', '2025-01-09 08:32:53', NULL, 1, NULL),
(132, 'Connexion', 'Hamza DRIDI', '2025-01-09 08:32:58', NULL, 609, NULL),
(133, 'Déconnexion', 'Hamza DRIDI', '2025-01-09 08:33:10', NULL, 609, NULL),
(134, 'Connexion', 'Jawher BALTI', '2025-01-09 08:33:15', NULL, 1, NULL),
(135, 'Déconnexion', 'Jawher BALTI', '2025-01-09 10:55:03', NULL, 1, NULL),
(136, 'Connexion', 'Hamza DRIDI', '2025-01-09 10:55:13', NULL, 609, NULL),
(137, 'Déconnexion', 'Hamza DRIDI', '2025-01-09 10:58:20', NULL, 609, NULL),
(138, 'Connexion', 'Jawher BALTI', '2025-01-09 10:58:25', NULL, 1, NULL),
(139, 'Déconnexion', 'Jawher BALTI', '2025-01-09 15:37:52', NULL, 1, NULL),
(140, 'Connexion', 'Hamza DRIDI', '2025-01-09 15:37:57', NULL, 609, NULL),
(141, 'Déconnexion', 'Hamza DRIDI', '2025-01-09 15:39:33', NULL, 609, NULL),
(142, 'Connexion', 'Jawher BALTI', '2025-01-09 15:40:04', NULL, 1, NULL),
(143, 'Déconnexion', 'Jawher BALTI', '2025-01-09 16:06:44', NULL, 1, NULL),
(144, 'Connexion', 'Hamza DRIDI', '2025-01-09 16:06:51', NULL, 609, NULL),
(145, 'Déconnexion', 'Hamza DRIDI', '2025-01-09 16:52:49', NULL, 609, NULL),
(146, 'Connexion', 'Jawher BALTI', '2025-01-09 16:52:53', NULL, 1, NULL),
(147, 'Déconnexion', 'Jawher BALTI', '2025-01-09 16:58:12', NULL, 1, NULL),
(148, 'Connexion', 'Jawher BALTI', '2025-01-09 16:58:16', NULL, 1, NULL),
(149, 'Déconnexion', 'Jawher BALTI', '2025-01-09 17:25:23', NULL, 1, NULL),
(150, 'Connexion', 'Jawher BALTI', '2025-01-09 17:25:29', NULL, 1, NULL),
(151, 'Déconnexion', 'Jawher BALTI', '2025-01-09 17:29:47', NULL, 1, NULL),
(152, 'Connexion', 'Jawher BALTI', '2025-01-09 17:29:51', NULL, 1, NULL),
(153, 'Déconnexion', 'Jawher BALTI', '2025-01-09 17:31:37', NULL, 1, NULL),
(154, 'Connexion', 'Jawher BALTI', '2025-01-09 17:31:42', NULL, 1, NULL),
(155, 'Déconnexion', 'Jawher BALTI', '2025-01-09 17:32:54', NULL, 1, NULL),
(156, 'Connexion', 'Jawher BALTI', '2025-01-09 17:32:59', NULL, 1, NULL),
(157, 'Déconnexion', 'Jawher BALTI', '2025-01-10 08:18:55', NULL, 1, NULL),
(158, 'Connexion', 'Jawher BALTI', '2025-01-10 08:18:59', NULL, 1, NULL),
(159, 'Déconnexion', 'Jawher BALTI', '2025-01-10 08:29:56', NULL, 1, NULL),
(160, 'Connexion', 'Hamza DRIDI', '2025-01-10 08:30:05', NULL, 609, NULL),
(161, 'Déconnexion', 'Hamza DRIDI', '2025-01-10 08:30:22', NULL, 609, NULL),
(162, 'Connexion', 'Jawher BALTI', '2025-01-10 08:30:26', NULL, 1, NULL),
(163, 'Déconnexion', 'Jawher BALTI', '2025-01-10 08:30:38', NULL, 1, NULL),
(164, 'Connexion', 'Jawher BALTI', '2025-01-10 08:30:43', NULL, 1, NULL),
(165, 'Déconnexion', 'Jawher BALTI', '2025-01-10 08:33:53', NULL, 1, NULL),
(166, 'Connexion', 'Jawher BALTI', '2025-01-10 08:34:07', NULL, 1, NULL),
(167, 'Déconnexion', 'Jawher BALTI', '2025-01-10 08:35:41', NULL, 1, NULL),
(168, 'Connexion', 'Hamza DRIDI', '2025-01-10 08:35:45', NULL, 609, NULL),
(169, 'Déconnexion', 'Hamza DRIDI', '2025-01-10 11:13:14', NULL, 609, NULL),
(170, 'Connexion', 'Jawher BALTI', '2025-01-10 11:13:18', NULL, 1, NULL),
(171, 'Déconnexion', 'Jawher BALTI', '2025-01-10 11:25:53', NULL, 1, NULL),
(172, 'Connexion', 'Hamza DRIDI', '2025-01-10 11:25:57', NULL, 609, NULL),
(173, 'Déconnexion', 'Hamza DRIDI', '2025-01-10 11:47:07', NULL, 609, NULL),
(174, 'Connexion', 'Jawher BALTI', '2025-01-10 11:47:11', NULL, 1, NULL),
(175, 'Déconnexion', 'Jawher BALTI', '2025-01-10 11:56:49', NULL, 1, NULL),
(176, 'Connexion', 'Jawher BALTI', '2025-01-10 11:56:54', NULL, 1, NULL),
(177, 'Déconnexion', 'Jawher BALTI', '2025-01-10 11:57:22', NULL, 1, NULL),
(178, 'Connexion', 'Hamza DRIDI', '2025-01-10 11:57:27', NULL, 609, NULL),
(179, 'Déconnexion', 'Hamza DRIDI', '2025-01-10 14:02:08', NULL, 609, NULL),
(180, 'Connexion', 'Jawher BALTI', '2025-01-10 14:02:14', NULL, 1, NULL),
(181, 'Déconnexion', 'Jawher BALTI', '2025-01-10 14:02:27', NULL, 1, NULL),
(182, 'Connexion', 'Jawher BALTI', '2025-01-10 14:02:32', NULL, 1, NULL),
(183, 'Déconnexion', 'Jawher BALTI', '2025-01-10 14:19:31', NULL, 1, NULL),
(184, 'Connexion', 'Hamza DRIDI', '2025-01-10 14:19:35', NULL, 609, NULL),
(185, 'Connexion', 'Jawher BALTI', '2025-01-13 08:03:58', NULL, 1, NULL),
(186, 'Déconnexion', 'Jawher BALTI', '2025-01-13 08:18:32', NULL, 1, NULL),
(187, 'Connexion', 'Hamza DRIDI', '2025-01-13 08:18:39', NULL, 609, NULL),
(188, 'Déconnexion', 'Hamza DRIDI', '2025-01-14 07:56:47', NULL, 609, NULL),
(189, 'Connexion', 'Jawher BALTI', '2025-01-14 07:56:53', NULL, 1, NULL),
(190, 'Déconnexion', 'Jawher BALTI', '2025-01-14 07:57:15', NULL, 1, NULL),
(191, 'Connexion', 'Hamza DRIDI', '2025-01-14 07:57:20', NULL, 609, NULL),
(192, 'Déconnexion', 'Hamza DRIDI', '2025-01-14 08:04:50', NULL, 609, NULL),
(193, 'Connexion', 'Jawher BALTI', '2025-01-14 08:04:56', NULL, 1, NULL),
(194, 'Déconnexion', 'Jawher BALTI', '2025-01-14 12:43:02', NULL, 1, NULL),
(195, 'Connexion', 'Jawher BALTI', '2025-01-14 12:43:07', NULL, 1, NULL),
(196, 'Déconnexion', 'Jawher BALTI', '2025-01-14 13:50:22', NULL, 1, NULL),
(197, 'Connexion', 'Hamza DRIDI', '2025-01-14 13:52:40', NULL, 609, NULL),
(198, 'Déconnexion', 'Hamza DRIDI', '2025-01-15 09:39:26', NULL, 609, NULL),
(199, 'Connexion', 'Jawher BALTI', '2025-01-15 09:39:31', NULL, 1, NULL),
(200, 'Déconnexion', 'Jawher BALTI', '2025-01-15 14:53:05', NULL, 1, NULL),
(201, 'Connexion', 'Hamza DRIDI', '2025-01-15 14:53:11', NULL, 609, NULL),
(202, 'Déconnexion', 'Hamza DRIDI', '2025-01-16 08:35:53', NULL, 609, NULL),
(203, 'Connexion', 'Jawher BALTI', '2025-01-16 08:35:58', NULL, 1, NULL),
(204, 'Déconnexion', 'Jawher BALTI', '2025-01-16 08:36:18', NULL, 1, NULL),
(205, 'Connexion', 'Hamza DRIDI', '2025-01-16 08:36:23', NULL, 609, NULL),
(206, 'Déconnexion', 'Hamza DRIDI', '2025-01-16 14:23:10', NULL, 609, NULL),
(207, 'Connexion', 'Jawher BALTI', '2025-01-16 14:23:14', NULL, 1, NULL),
(208, 'Déconnexion', 'Jawher BALTI', '2025-01-16 14:25:34', NULL, 1, NULL),
(209, 'Connexion', 'Jawher BALTI', '2025-01-16 14:25:38', NULL, 1, NULL),
(210, 'Déconnexion', 'Jawher BALTI', '2025-01-16 14:29:19', NULL, 1, NULL),
(211, 'Connexion', 'Hamza DRIDI', '2025-01-16 14:29:26', NULL, 609, NULL),
(212, 'Déconnexion', 'Hamza DRIDI', '2025-01-16 14:45:53', NULL, 609, NULL),
(213, 'Connexion', 'Jawher BALTI', '2025-01-16 14:45:58', NULL, 1, NULL),
(214, 'Déconnexion', 'Jawher BALTI', '2025-01-16 15:30:01', NULL, 1, NULL),
(215, 'Connexion', 'Jawher BALTI', '2025-01-16 15:30:13', NULL, 1, NULL),
(216, 'Déconnexion', 'Jawher BALTI', '2025-01-16 15:39:44', NULL, 1, NULL),
(217, 'Connexion', 'Jawher BALTI', '2025-01-16 15:39:48', NULL, 1, NULL),
(218, 'Déconnexion', 'Jawher BALTI', '2025-01-16 15:47:15', NULL, 1, NULL),
(219, 'Connexion', 'Hamza DRIDI', '2025-01-16 15:47:20', NULL, 609, NULL),
(220, 'Déconnexion', 'Hamza DRIDI', '2025-01-16 15:51:45', NULL, 609, NULL),
(221, 'Connexion', 'Jawher BALTI', '2025-01-16 15:51:49', NULL, 1, NULL),
(222, 'Déconnexion', 'Jawher BALTI', '2025-01-16 15:52:01', NULL, 1, NULL),
(223, 'Connexion', 'Jawher BALTI', '2025-01-16 15:52:14', NULL, 1, NULL),
(224, 'Déconnexion', 'Jawher BALTI', '2025-01-16 16:22:50', NULL, 1, NULL),
(225, 'Connexion', 'Hamza DRIDI', '2025-01-16 16:22:54', NULL, 609, NULL),
(226, 'Déconnexion', 'Hamza DRIDI', '2025-01-20 13:53:18', NULL, 609, NULL),
(227, 'Connexion', 'Jawher BALTI', '2025-01-20 13:53:22', NULL, 1, NULL),
(228, 'Déconnexion', 'Jawher BALTI', '2025-01-21 09:32:13', NULL, 1, NULL),
(229, 'Connexion', 'Hamza DRIDI', '2025-01-21 09:32:18', NULL, 609, NULL),
(230, 'Déconnexion', 'Hamza DRIDI', '2025-01-21 09:34:02', NULL, 609, NULL),
(231, 'Connexion', 'Jawher BALTI', '2025-01-21 09:34:06', NULL, 1, NULL),
(232, 'Déconnexion', 'Jawher BALTI', '2025-01-21 09:45:36', NULL, 1, NULL),
(233, 'Connexion', 'Hamza DRIDI', '2025-01-21 09:45:41', NULL, 609, NULL),
(234, 'Déconnexion', 'Hamza DRIDI', '2025-01-21 09:49:35', NULL, 609, NULL),
(235, 'Connexion', 'Jawher BALTI', '2025-01-21 09:49:39', NULL, 1, NULL),
(236, 'Déconnexion', 'Jawher BALTI', '2025-01-21 09:49:46', NULL, 1, NULL),
(237, 'Connexion', 'Jawher BALTI', '2025-01-21 09:49:50', NULL, 1, NULL),
(238, 'Déconnexion', 'Jawher BALTI', '2025-01-21 09:49:57', NULL, 1, NULL),
(239, 'Connexion', 'Hamza DRIDI', '2025-01-21 09:50:01', NULL, 609, NULL),
(240, 'Déconnexion', 'Hamza DRIDI', '2025-01-21 09:53:21', NULL, 609, NULL),
(241, 'Connexion', 'Jawher BALTI', '2025-01-21 09:53:25', NULL, 1, NULL),
(242, 'Déconnexion', 'Jawher BALTI', '2025-01-21 11:02:12', NULL, 1, NULL),
(243, 'Connexion', 'Hamza DRIDI', '2025-01-21 11:02:18', NULL, 609, NULL),
(244, 'Déconnexion', 'Hamza DRIDI', '2025-01-21 11:02:51', NULL, 609, NULL),
(245, 'Connexion', 'Jawher BALTI', '2025-01-21 11:02:56', NULL, 1, NULL),
(246, 'Déconnexion', 'Jawher BALTI', '2025-01-21 12:49:05', NULL, 1, NULL),
(247, 'Connexion', 'Hamza DRIDI', '2025-01-21 12:49:10', NULL, 609, NULL),
(248, 'Déconnexion', 'Hamza DRIDI', '2025-01-21 12:49:29', NULL, 609, NULL),
(249, 'Connexion', 'Jawher BALTI', '2025-01-21 12:49:34', NULL, 1, NULL),
(250, 'Déconnexion', 'Jawher BALTI', '2025-01-21 14:34:04', NULL, 1, NULL),
(251, 'Connexion', 'Hamza DRIDI', '2025-01-21 14:34:11', NULL, 609, NULL),
(252, 'Déconnexion', 'Hamza DRIDI', '2025-01-21 14:57:28', NULL, 609, NULL),
(253, 'Connexion', 'Jawher BALTI', '2025-01-21 14:57:36', NULL, 1, NULL),
(254, 'Déconnexion', 'Jawher BALTI', '2025-01-21 15:18:12', NULL, 1, NULL),
(255, 'Connexion', 'Hamza DRIDI', '2025-01-21 15:18:23', NULL, 609, NULL),
(256, 'Déconnexion', 'Hamza DRIDI', '2025-01-21 15:18:35', NULL, 609, NULL),
(257, 'Connexion', 'Jawher BALTI', '2025-01-21 15:18:39', NULL, 1, NULL),
(258, 'Déconnexion', 'Jawher BALTI', '2025-01-21 15:44:31', NULL, 1, NULL),
(259, 'Connexion', 'Hamza DRIDI', '2025-01-21 15:44:36', NULL, 609, NULL),
(260, 'Déconnexion', 'Hamza DRIDI', '2025-01-21 15:45:15', NULL, 609, NULL),
(261, 'Connexion', 'Jawher BALTI', '2025-01-21 15:45:19', NULL, 1, NULL),
(262, 'Connexion', 'Jawher BALTI', '2025-01-21 16:56:38', NULL, 1, NULL),
(263, 'Déconnexion', 'Jawher BALTI', '2025-01-22 11:28:44', NULL, 1, NULL),
(264, 'Connexion', 'Hamza DRIDI', '2025-01-22 11:28:48', NULL, 609, NULL),
(265, 'Déconnexion', 'Hamza DRIDI', '2025-01-22 11:37:21', NULL, 609, NULL),
(266, 'Connexion', 'Jawher BALTI', '2025-01-22 11:37:27', NULL, 1, NULL),
(267, 'Déconnexion', 'Jawher BALTI', '2025-01-22 13:07:29', NULL, 1, NULL),
(268, 'Connexion', 'Hamza DRIDI', '2025-01-22 13:07:36', NULL, 609, NULL),
(269, 'Déconnexion', 'Hamza DRIDI', '2025-01-22 13:09:33', NULL, 609, NULL),
(270, 'Connexion', 'Jawher BALTI', '2025-01-22 13:09:38', NULL, 1, NULL),
(271, 'Déconnexion', 'Jawher BALTI', '2025-01-22 13:38:00', NULL, 1, NULL),
(272, 'Connexion', 'Hamza DRIDI', '2025-01-22 13:38:05', NULL, 609, NULL),
(273, 'Déconnexion', 'Hamza DRIDI', '2025-01-22 13:49:00', NULL, 609, NULL),
(274, 'Connexion', 'Jawher BALTI', '2025-01-22 13:49:05', NULL, 1, NULL),
(275, 'Déconnexion', 'Jawher BALTI', '2025-01-22 14:15:10', NULL, 1, NULL),
(276, 'Connexion', 'Hamza DRIDI', '2025-01-22 14:15:15', NULL, 609, NULL),
(277, 'Déconnexion', 'Hamza DRIDI', '2025-01-22 14:15:44', NULL, 609, NULL),
(278, 'Connexion', 'Jawher BALTI', '2025-01-22 14:15:53', NULL, 1, NULL),
(279, 'Déconnexion', 'Jawher BALTI', '2025-01-22 15:42:25', NULL, 1, NULL),
(280, 'Connexion', 'Hamza DRIDI', '2025-01-22 15:42:37', NULL, 609, NULL),
(281, 'Déconnexion', 'Hamza DRIDI', '2025-01-22 15:49:49', NULL, 609, NULL),
(282, 'Connexion', 'Jawher BALTI', '2025-01-22 15:49:53', NULL, 1, NULL),
(283, 'Déconnexion', 'Jawher BALTI', '2025-01-23 07:18:53', NULL, 1, NULL),
(284, 'Connexion', 'Hamza DRIDI', '2025-01-23 07:19:01', NULL, 609, NULL),
(285, 'Connexion', 'Jawher BALTI', '2025-01-23 07:28:23', NULL, 1, NULL),
(286, 'Déconnexion', 'Hamza DRIDI', '2025-01-23 08:21:28', NULL, 609, NULL),
(287, 'Connexion', 'Jawher BALTI', '2025-01-23 08:21:39', NULL, 1, NULL),
(288, 'Déconnexion', 'Jawher BALTI', '2025-01-23 08:35:43', NULL, 1, NULL),
(289, 'Connexion', 'Hamza DRIDI', '2025-01-23 08:35:52', NULL, 609, NULL),
(290, 'Déconnexion', 'Hamza DRIDI', '2025-01-23 08:43:21', NULL, 609, NULL),
(291, 'Connexion', 'Jawher BALTI', '2025-01-23 08:43:26', NULL, 1, NULL),
(292, 'Déconnexion', 'Jawher BALTI', '2025-01-23 08:51:40', NULL, 1, NULL),
(293, 'Connexion', 'Jawher BALTI', '2025-01-23 08:51:44', NULL, 1, NULL),
(294, 'Déconnexion', 'Jawher BALTI', '2025-01-23 08:51:58', NULL, 1, NULL),
(295, 'Connexion', 'Hamza DRIDI', '2025-01-23 08:52:17', NULL, 609, NULL),
(296, 'Déconnexion', 'Hamza DRIDI', '2025-01-23 09:25:55', NULL, 609, NULL),
(297, 'Connexion', 'Jawher BALTI', '2025-01-23 09:26:02', NULL, 1, NULL),
(298, 'Déconnexion', 'Jawher BALTI', '2025-01-23 09:28:04', NULL, 1, NULL),
(299, 'Connexion', 'Hamza DRIDI', '2025-01-23 09:28:09', NULL, 609, NULL),
(300, 'Déconnexion', 'Hamza DRIDI', '2025-01-23 09:54:47', NULL, 609, NULL),
(301, 'Connexion', 'Jawher BALTI', '2025-01-23 09:54:53', NULL, 1, NULL),
(302, 'Déconnexion', 'Jawher BALTI', '2025-01-23 09:55:46', NULL, 1, NULL),
(303, 'Connexion', 'Hamza DRIDI', '2025-01-23 09:55:51', NULL, 609, NULL),
(304, 'Déconnexion', 'Hamza DRIDI', '2025-01-23 10:13:10', NULL, 609, NULL),
(305, 'Connexion', 'Jawher BALTI', '2025-01-23 10:13:17', NULL, 1, NULL),
(306, 'Connexion', 'Hamza DRIDI', '2025-01-23 10:14:18', NULL, 609, NULL),
(307, 'Déconnexion', 'Jawher BALTI', '2025-01-23 16:54:21', NULL, 1, NULL),
(308, 'Connexion', 'Hamza DRIDI', '2025-01-23 16:54:25', NULL, 609, NULL),
(309, 'Déconnexion', 'Hamza DRIDI', '2025-01-23 16:57:20', NULL, 609, NULL),
(310, 'Connexion', 'Jawher BALTI', '2025-01-23 16:57:25', NULL, 1, NULL),
(311, 'Déconnexion', 'Jawher BALTI', '2025-01-24 10:29:51', NULL, 1, NULL),
(312, 'Connexion', 'Hamza DRIDI', '2025-01-24 10:29:58', NULL, 609, NULL),
(313, 'Déconnexion', 'Hamza DRIDI', '2025-01-24 10:42:30', NULL, 609, NULL),
(314, 'Connexion', 'Jawher BALTI', '2025-01-24 10:42:35', NULL, 1, NULL),
(315, 'Déconnexion', 'Jawher BALTI', '2025-01-24 11:22:42', NULL, 1, NULL),
(316, 'Connexion', 'Jawher BALTI', '2025-01-24 11:22:46', NULL, 1, NULL),
(317, 'Déconnexion', 'Jawher BALTI', '2025-01-24 11:23:03', NULL, 1, NULL),
(318, 'Connexion', 'Jawher BALTI', '2025-01-24 11:23:12', NULL, 1, NULL),
(319, 'Déconnexion', 'Jawher BALTI', '2025-01-24 14:01:42', NULL, 1, NULL),
(320, 'Connexion', 'Hamza DRIDI', '2025-01-24 14:01:48', NULL, 609, NULL),
(321, 'Déconnexion', 'Hamza DRIDI', '2025-01-24 14:08:54', NULL, 609, NULL),
(322, 'Connexion', 'Jawher BALTI', '2025-01-24 14:09:02', NULL, 1, NULL),
(323, 'Connexion', 'Jawher BALTI', '2025-01-27 07:59:47', NULL, 1, NULL),
(324, 'Connexion', 'Hamza DRIDI', '2025-01-27 08:00:29', NULL, 609, NULL),
(325, 'Connexion', 'Jawher BALTI', '2025-01-28 14:37:00', NULL, 1, NULL),
(326, 'Connexion', 'Hamza DRIDI', '2025-01-28 15:21:36', NULL, 609, NULL),
(327, 'Déconnexion', 'Jawher BALTI', '2025-01-29 10:53:20', NULL, 1, NULL),
(328, 'Connexion', 'Jawher BALTI', '2025-01-29 10:53:25', NULL, 1, NULL),
(329, 'Déconnexion', 'Jawher BALTI', '2025-01-29 11:28:39', NULL, 1, NULL),
(330, 'Connexion', 'Jawher BALTI', '2025-01-29 11:28:44', NULL, 1, NULL),
(331, 'Déconnexion', 'Jawher BALTI', '2025-01-31 09:22:01', NULL, 1, NULL),
(332, 'Connexion', 'Jawher BALTI', '2025-01-31 09:22:05', NULL, 1, NULL),
(333, 'Déconnexion', 'Hamza DRIDI', '2025-01-31 09:22:10', NULL, 609, NULL),
(334, 'Connexion', 'Hamza DRIDI', '2025-01-31 09:22:17', NULL, 609, NULL),
(335, 'Déconnexion', 'Jawher BALTI', '2025-01-31 09:29:58', NULL, 1, NULL),
(336, 'Connexion', 'Jawher BALTI', '2025-01-31 09:30:03', NULL, 1, NULL),
(337, 'Déconnexion', 'Hamza DRIDI', '2025-01-31 09:30:07', NULL, 609, NULL),
(338, 'Connexion', 'Hamza DRIDI', '2025-01-31 09:30:13', NULL, 609, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_immeuble`
--

CREATE TABLE `wbcc_immeuble` (
  `idImmeuble` int(11) NOT NULL,
  `numeroImmeuble` varchar(255) DEFAULT NULL,
  `codeImmeuble` varchar(200) DEFAULT NULL,
  `typeImmeuble` varchar(100) DEFAULT 'HLM',
  `adresse` text DEFAULT NULL,
  `codePostal` varchar(25) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `nomDO` varchar(255) DEFAULT NULL,
  `idDO` int(11) DEFAULT NULL,
  `guidDO` varchar(100) DEFAULT NULL,
  `idProprietaire` int(11) DEFAULT NULL,
  `nomProprietaire` varchar(200) DEFAULT NULL,
  `guidProprietaire` varchar(100) DEFAULT NULL,
  `typeProprietaire` varchar(50) DEFAULT NULL,
  `createDate` varchar(50) DEFAULT current_timestamp(),
  `idUserF` int(11) DEFAULT NULL,
  `editDate` varchar(50) DEFAULT current_timestamp(),
  `photoImmeuble` varchar(255) DEFAULT NULL,
  `etatImmeuble` int(11) NOT NULL DEFAULT 1,
  `codeWBCC` varchar(255) DEFAULT NULL,
  `codeImmeubleDO` varchar(255) DEFAULT NULL,
  `nomImmeubleSyndic` varchar(255) DEFAULT NULL,
  `idSyndic` int(11) DEFAULT NULL,
  `guidSyndic` varchar(100) DEFAULT NULL,
  `adresse2` text DEFAULT NULL,
  `departement` varchar(255) DEFAULT NULL,
  `digicode1` varchar(100) DEFAULT NULL,
  `digicode2` varchar(100) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `nomInterphone` varchar(100) DEFAULT NULL,
  `codeDO` varchar(100) DEFAULT NULL,
  `refCourtier` varchar(100) DEFAULT NULL,
  `numPolice` varchar(100) DEFAULT NULL,
  `dateEffetContrat` varchar(100) DEFAULT NULL,
  `dateEcheanceContrat` varchar(50) DEFAULT NULL,
  `copieContrat` varchar(255) DEFAULT NULL,
  `codeFiche` varchar(100) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `nbreBatiment` varchar(100) DEFAULT NULL,
  `libelleBatiment` varchar(100) DEFAULT NULL,
  `nomPCS` varchar(255) DEFAULT NULL,
  `nomGardien` varchar(255) DEFAULT NULL,
  `nomCourtier` varchar(255) DEFAULT NULL,
  `nomCompagnieAssurance` varchar(255) DEFAULT NULL,
  `idChefSecteur` int(11) DEFAULT NULL,
  `nomChefSecteur` varchar(200) DEFAULT NULL,
  `idGardien` int(11) DEFAULT NULL,
  `idCourtier` int(11) DEFAULT NULL,
  `idCompagnieAssurance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_immeuble`
--

INSERT INTO `wbcc_immeuble` (`idImmeuble`, `numeroImmeuble`, `codeImmeuble`, `typeImmeuble`, `adresse`, `codePostal`, `ville`, `nomDO`, `idDO`, `guidDO`, `idProprietaire`, `nomProprietaire`, `guidProprietaire`, `typeProprietaire`, `createDate`, `idUserF`, `editDate`, `photoImmeuble`, `etatImmeuble`, `codeWBCC`, `codeImmeubleDO`, `nomImmeubleSyndic`, `idSyndic`, `guidSyndic`, `adresse2`, `departement`, `digicode1`, `digicode2`, `region`, `pays`, `nomInterphone`, `codeDO`, `refCourtier`, `numPolice`, `dateEffetContrat`, `dateEcheanceContrat`, `copieContrat`, `codeFiche`, `commentaire`, `nbreBatiment`, `libelleBatiment`, `nomPCS`, `nomGardien`, `nomCourtier`, `nomCompagnieAssurance`, `idChefSecteur`, `nomChefSecteur`, `idGardien`, `idCourtier`, `idCompagnieAssurance`) VALUES
(1, '1', '111', 'HLM', 'addr1', '1111', 'ville1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'current_timestamp()', NULL, 'current_timestamp()', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2456, '2', '222', 'HLM', 'addr2', '2222', 'ville2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'current_timestamp()', NULL, 'current_timestamp()', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_module`
--

CREATE TABLE `wbcc_module` (
  `idModule` int(11) NOT NULL,
  `nomModule` varchar(255) DEFAULT NULL,
  `lieu` varchar(255) DEFAULT NULL,
  `etatModule` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_module`
--

INSERT INTO `wbcc_module` (`idModule`, `nomModule`, `lieu`, `etatModule`) VALUES
(1, 'Gestion Opportunite', NULL, 1),
(2, 'Gestion Interne', NULL, 1),
(3, 'Expert', NULL, 1),
(4, 'Artisan', NULL, 1),
(5, 'Commercial', NULL, 1),
(6, 'Comptabilite', NULL, 1),
(7, 'Coproprietaire', NULL, 1),
(8, 'Occupant', NULL, 1),
(9, 'Particulier', NULL, 1),
(10, 'Espace DO', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_notification`
--

CREATE TABLE `wbcc_notification` (
  `idNotification` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `idPointage` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wbcc_notification`
--

INSERT INTO `wbcc_notification` (`idNotification`, `idUtilisateur`, `idPointage`, `title`, `message`, `created_at`, `is_read`) VALUES
(1, 2, NULL, 'Acceptation justification', 'Votre manager a été accepter votre justification', '2024-11-11 20:22:20', 0),
(2, 2, NULL, 'Retard détecté', 'Votre manager a été accepter votre justification', '2024-11-11 20:32:27', 0),
(3, 609, NULL, 'Retard détecté', 'Votre manager a été accepter votre justification', '2024-11-11 20:33:50', 1),
(4, 609, NULL, 'Retard détecté', 'Votre manager a été accepter votre justification 1', '2024-11-11 20:33:50', 1),
(5, 609, NULL, 'Retard détecté', 'Votre manager a été accepter votre justification 2', '2024-11-11 20:33:50', 1),
(6, 609, NULL, 'Retard détecté', 'Votre manager a été accepter votre justification 3', '2024-11-11 20:33:50', 1),
(7, 609, NULL, 'Retard détecté', 'Votre manager a été accepter votre justification 4', '2024-11-11 20:33:50', 1),
(8, 613, NULL, 'Retard détecté', 'Votre manager a été accepter votre justification 5', '2024-11-11 20:33:50', 1),
(12, 609, NULL, 'Retard détecté', 'Votre manager a été accepter votre justification', '2024-11-14 14:31:46', 1),
(13, 609, NULL, 'Justification Confirmée', 'Le résultat de la justification est : Accepté', '2024-11-14 20:57:36', 1),
(17, 609, NULL, 'Retard détecté', 'Votre manager a été accepter votre justification', '2024-11-18 15:30:14', 1),
(21, 613, NULL, 'Retard détecté', 'Vous avez un retard de 11 heures et 23 minutes.', '2024-11-19 20:23:34', 1),
(22, 613, NULL, 'Retard détecté', 'Vous avez un retard de 11 heures et 49 minutes.', '2024-11-19 20:49:07', 1),
(23, 613, NULL, 'Retard détecté', 'Vous avez un retard de 12 heures et 13 minutes.', '2024-11-19 21:13:08', 1),
(24, 613, NULL, 'Retard détecté', 'Vous avez un retard de 5 heures et 58 minutes.', '2024-11-20 14:58:59', 1),
(25, 613, NULL, 'Retard détecté', 'Vous avez un retard de 6 heures et 5 minutes.', '2024-11-20 15:05:37', 1),
(26, 613, NULL, 'Retard détecté', 'Vous avez un retard de 6 heures et 11 minutes.', '2024-11-20 15:11:26', 1),
(27, 613, NULL, 'Retard détecté', 'Vous avez un retard de 6 heures et 13 minutes.', '2024-11-20 15:13:15', 1),
(28, 613, NULL, 'Retard détecté', 'Vous avez un retard de 6 heures et 13 minutes.', '2024-11-20 15:13:56', 1),
(29, 613, NULL, 'Retard détecté', 'Vous avez un retard de 10 heures et 48 minutes.', '2024-11-20 19:48:45', 1),
(30, 613, NULL, 'Retard détecté', 'Vous avez un retard de 10 heures et 49 minutes.', '2024-11-20 19:49:40', 1),
(31, 613, NULL, 'Retard détecté', 'Vous avez un retard de 11 heures et 25 minutes.', '2024-11-20 20:25:08', 1),
(32, 609, NULL, 'Retard détecté', 'Vous avez un retard de 4 heures et 52 minutes.', '2024-11-21 13:52:13', 1),
(33, 609, NULL, 'Résultat de votre justification', 'Votre manager a été accepter votre justification', '2024-11-22 09:10:37', 1),
(34, 609, NULL, 'Résultat de votre justification', 'Votre manager a été accepter votre justification', '2024-11-22 09:10:50', 1),
(35, 609, NULL, 'Retard détecté', 'Vous avez un retard de 18 minutes.', '2024-11-22 09:18:52', 1),
(36, 613, NULL, 'Retard détecté', ' Vous êtes en retard de 29 minutes. Veuillez justifier ce retard.', '2024-11-22 09:29:59', 1),
(37, 609, NULL, 'Résultat de votre justification', 'Votre manager a été accepter votre justification', '2024-11-22 09:33:45', 1),
(38, 609, NULL, 'Résultat de votre justification', 'Votre manager a été accepter votre justification', '2024-11-22 09:33:47', 1),
(39, 609, NULL, 'Temps restant', 'Il vous reste 7 heures et 38 minutes pour terminer votre journée.', '2024-11-22 10:21:22', 1),
(40, 613, NULL, 'Temps restant', 'Il vous reste 4 heures et 32 minutes pour terminer votre journée.Connectez-vous à votre profil pour justifier', '2024-11-22 10:27:45', 1),
(41, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 1 heures et 45 minutes. Veuillez justifier ce retard.', '2024-11-22 10:45:47', 1),
(42, 613, NULL, 'Retour imminent:', ' Il vous reste 4 heures et 12 minutes avant la fin de votre journée. Veuillez justifier votre retour avant l\'heure de départ.', '2024-11-22 10:48:00', 1),
(43, 609, NULL, 'Justificatif accepté', 'Votre justificatif a été approuvé par votre manager.', '2024-11-22 11:12:06', 1),
(44, 609, NULL, 'Justificatif accepté', 'Votre justificatif a été approuvé par votre manager.', '2024-11-22 11:12:43', 1),
(45, 609, NULL, 'Justificatif refusé', 'Votre justificatif a été rejeté par votre manager.', '2024-11-22 11:21:40', 1),
(46, 609, NULL, 'Justificatif accepté', 'Votre justificatif a été approuvé par votre manager.', '2024-11-22 11:21:59', 1),
(47, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 10 heures et 52 minutes. Veuillez justifier ce retard.', '2024-11-22 19:52:36', 1),
(48, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 11 heures et 2 minutes. Veuillez justifier ce retard.', '2024-11-22 20:02:50', 1),
(49, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 11 heures et 14 minutes. Veuillez justifier ce retard.', '2024-11-22 20:14:43', 1),
(50, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 11 heures et 19 minutes. Veuillez justifier ce retard.', '2024-11-22 20:19:25', 1),
(51, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 11 heures et 48 minutes. Veuillez justifier ce retard.', '2024-11-22 20:48:04', 1),
(52, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 11 heures et 56 minutes. Veuillez justifier ce retard.', '2024-11-22 20:56:20', 1),
(53, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 6 heures et 50 minutes. Veuillez justifier ce retard.', '2024-11-23 16:50:11', 1),
(54, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 8 heures et 10 minutes. Veuillez justifier ce retard.', '2024-11-23 17:10:13', 1),
(55, 613, NULL, 'Retard détecté:', ' Vous êtes en retard de 8 heures et 56 minutes. Veuillez justifier ce retard.', '2024-11-23 17:56:50', 1),
(56, 613, NULL, 'Fin de journée imminente:', ' Il vous reste 1 heures et 2 minutes avant la fin de votre journée. Veuillez justifier votre retour avant l\'heure de départ.', '2024-11-23 17:57:17', 1),
(69, 613, NULL, 'Justification Confirmée', 'Le résultat de la justification d\'arrivée est : Accepté', '2024-11-26 11:17:52', 1),
(70, 613, NULL, 'Justification Confirmée', 'Le résultat de la justification d\'arrivée est : Accepté', '2024-11-26 11:21:23', 1),
(71, 609, NULL, 'Retard détecté:', ' Vous êtes en retard de 3 heures et 25 minutes. Veuillez justifier ce retard.', '2024-11-26 11:25:11', 1),
(73, 609, NULL, 'Fin de journée imminente:', ' Il vous reste 7 minutes avant la fin de votre journée. Veuillez justifier votre retour avant l\'heure de départ.', '2024-11-26 13:52:15', 1),
(87, 613, NULL, 'Justificatif accepté', 'Votre justificatif d\'arrivée a été approuvé par votre manager.', '2024-11-27 01:39:06', 1),
(88, 613, NULL, 'Justificatif refusé', 'Votre justificatif de départ pour le 23/11/24 a été rejeté par votre manager.', '2024-11-27 01:52:49', 1),
(89, 609, NULL, 'Justificatif accepté', 'Votre justificatif de départ pour le 22/11/2024 a été approuvé par votre manager. ', '2024-11-27 02:08:16', 1),
(91, 609, NULL, 'Retard détecté:', ' Vous êtes en retard de 6 heures et 15 minutes. Veuillez justifier ce retard.', '2024-11-27 14:15:27', 1),
(92, 609, NULL, 'Justificatif accepté', 'Votre justificatif d\'arrivée pour le - a été approuvé par votre manager.', '2024-11-27 14:24:23', 1),
(93, 609, NULL, 'Justificatif accepté', 'Votre justificatif d\'arrivée pour le 27/11/24 a été approuvé par votre manager.', '2024-11-27 14:40:50', 1),
(105, 609, NULL, 'Retard détecté:', ' Vous êtes en retard de 6 heures et 32 minutes. Veuillez justifier ce retard.', '2024-11-28 14:32:47', 1),
(106, 613, NULL, 'Justificatif d\'arrivée envoyé', 'Hamza DRIDI a été envoyer une justification d\'arrivé', '2024-11-28 14:36:10', 1),
(107, 609, NULL, 'Justificatif accepté', 'Votre justificatif d\'arrivée  pour le 28/11/2024 a été approuvé par votre manager.', '2024-11-28 14:37:34', 1),
(108, 609, NULL, 'Fin de journée imminente:', ' Il vous reste 2 heures et 19 minutes avant la fin de votre journée. Veuillez justifier votre retour avant l\'heure de départ.', '2024-11-28 14:40:30', 1),
(109, 609, NULL, 'Justificatif refusé', 'Votre justificatif de départ pour le 28/11/24 a été rejeté par votre manager.', '2024-11-28 14:42:48', 1),
(110, 609, NULL, 'Justificatif accepté', 'Votre justificatif de départ pour le 28/11/24 a été approuvé par votre manager.', '2024-11-28 15:13:47', 1),
(112, 613, NULL, 'Nouvelle justification de départ', 'Hamza DRIDI a soumis une justification pour son départ. Veuillez la consulter.', '2024-11-29 00:44:57', 1),
(113, 613, NULL, 'Nouvelle justification de départ', 'Hamza DRIDI a soumis une justification pour son départ. Veuillez la consulter.', '2024-11-29 01:17:16', 1),
(114, 611, NULL, 'Retard détecté:', ' Vous êtes en retard de 28 minutes. Veuillez justifier ce retard.', '2024-11-29 08:28:21', 1),
(115, 613, NULL, 'Nouvelle justification d\'arrivée', 'Mohamed Achref MEHERZI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-11-29 08:31:53', 1),
(116, 613, NULL, 'Nouvelle justification d\'arrivée', 'Mohamed Achref MEHERZI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-11-29 08:39:28', 1),
(117, 611, NULL, 'Justificatif refusé', 'Votre justificatif d\'arrivée pour le 29/11/24 a été rejeté par votre manager.', '2024-11-29 08:40:06', 1),
(118, 611, NULL, 'Fin de journée imminente:', 'Veuillez noter qu\'il vous reste 5 heures et 13 minutes avant la fin de votre journée. Il est impératif de justifier votre retour dans ce délai.', '2024-11-29 08:46:05', 1),
(119, 613, NULL, 'Nouvelle justification de départ', 'Mohamed Achref MEHERZI a soumis une justification pour son départ. Veuillez la consulter.', '2024-11-29 08:50:32', 1),
(120, 611, NULL, 'Justificatif accepté', 'Votre justificatif de départ pour le 29/11/2024 a été approuvé par votre manager.', '2024-11-29 08:52:13', 1),
(121, 614, NULL, 'Retard détecté:', ' Vous êtes en retard de 1 heures et 42 minutes. Veuillez justifier ce retard.', '2024-11-29 09:42:11', 1),
(124, 2, NULL, 'Nouvelle justification d\'arrivée', 'hend OUESLATI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-11-29 11:08:16', 0),
(171, 613, NULL, 'Nouvelle justification d\'arrivée', 'Hamza DRIDI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-12-02 16:26:31', 1),
(172, 613, NULL, 'Nouvelle justification d\'arrivée', 'Hamza DRIDI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-12-02 16:27:08', 0),
(173, 613, NULL, 'Nouvelle justification d\'arrivée', 'Hamza DRIDI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-12-02 16:28:46', 1),
(174, 609, NULL, 'Justificatif accepté', 'Votre justificatif d\'arrivée pour le 02/12/24 a été approuvé par votre manager.', '2024-12-02 16:30:19', 1),
(175, 613, NULL, 'Nouvelle justification d\'arrivée', 'Hamza DRIDI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-12-02 20:07:16', 1),
(193, 609, NULL, 'Retard détecté:', ' Vous êtes en retard de 1 heures et 53 minutes. Veuillez justifier ce retard.', '2024-12-04 09:53:22', 1),
(194, 609, 403, 'Retard détecté:::', ' Vous êtes en retard de 2 heures et 36 minutes. Veuillez justifier ce retard.', '2024-12-05 10:36:26', 1),
(195, 613, NULL, 'Nouvelle justification d\'arrivée', 'Hamza DRIDI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-12-05 11:11:45', 0),
(196, 609, NULL, 'Justificatif accepté', 'Votre justificatif d\'arrivée pour le 05/12/2024 a été approuvé par votre manager.', '2024-12-05 11:26:35', 1),
(197, 609, NULL, 'Justificatif refusé', 'Votre justificatif d\'arrivée pour le 05/12/2024 a été rejeté par votre manager.', '2024-12-05 11:27:23', 1),
(198, 609, NULL, 'Justificatif accepté', 'Votre justificatif d\'arrivée pour le 05/12/2024 a été approuvé par votre manager.', '2024-12-05 11:29:11', 1),
(199, 613, NULL, 'undefined', 'undefined', '2024-12-05 11:32:12', 0),
(200, 613, NULL, 'Nouvelle justification de départ', 'Hamza DRIDI a soumis une justification pour son départ. Veuillez la consulter.', '2024-12-05 11:34:18', 0),
(201, 609, NULL, 'Justificatif accepté', 'Votre justificatif de départ pour le 05/12/2024 a été approuvé par votre manager.', '2024-12-05 11:43:54', 1),
(202, 609, NULL, 'Fin de journée imminente:', 'Veuillez noter qu\'il vous reste 5 heures et 7 minutes avant la fin de votre journée. Il est impératif de justifier votre retour dans ce délai.', '2024-12-05 11:52:24', 1),
(203, 613, NULL, 'Nouvelle justification d\'arrivée', 'Hamza DRIDI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-12-07 12:43:26', 0),
(204, 613, NULL, 'Nouvelle justification d\'arrivée', 'Hamza DRIDI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-12-07 12:50:19', 1),
(205, 609, 418, 'Retard détecté', 'Vous avez un retard de 20 minutes.', '2024-12-09 08:20:00', 1),
(206, 613, NULL, 'Nouvelle justification d\'arrivée', 'Hamza DRIDI a soumis une justification pour son arrivée. Veuillez la consulter.', '2024-12-09 08:42:36', 1),
(207, 609, 418, 'Justificatif accepté', 'Votre justificatif d\'arrivée pour le 09/12/2024 a été approuvé par votre manager.', '2024-12-09 10:03:03', 1),
(208, 609, 530, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 51 minutes. Veuillez justifier ce retard.', '2024-12-20 14:51:18', 1),
(209, 611, 524, 'Retard détecté:', 'Vous êtes en retard de 9 heures et 9 minutes. Veuillez justifier ce retard.', '2024-12-20 19:39:48', 0),
(210, 609, 533, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 41 minutes. Veuillez justifier ce retard.', '2024-12-20 19:41:29', 1),
(211, 609, 534, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 57 minutes. Veuillez justifier ce retard.', '2024-12-20 19:57:09', 1),
(212, 609, 535, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 4 minutes. Veuillez justifier ce retard.', '2024-12-20 20:04:11', 1),
(213, 609, 535, 'Pointage Avant l\'Heure', 'Vous êtes pointer avant l\'heure de 55 minutes. Veuillez justifier ce pointage.', '2024-12-20 20:04:17', 1),
(214, 611, 545, 'Retard détecté:', 'Vous êtes en retard de 20 minutes. Veuillez justifier ce retard.', '2024-12-23 08:20:20', 1),
(215, 611, 545, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 5 heures et 21 minutes. Veuillez justifier ce pointage.', '2024-12-23 08:38:11', 0),
(216, 611, 550, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 40 minutes. Veuillez justifier ce retard.', '2024-12-25 12:40:45', 0),
(217, 614, 555, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 42 minutes. Veuillez justifier ce retard.', '2024-12-25 12:42:06', 0),
(218, 611, 556, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 52 minutes. Veuillez justifier ce retard.', '2024-12-25 12:52:24', 0),
(219, 611, 557, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 4 minutes. Veuillez justifier ce retard.', '2024-12-25 13:04:35', 0),
(220, 614, 555, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 5 minutes. Veuillez justifier ce retard.', '2024-12-25 13:05:45', 0),
(221, 614, 555, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 6 minutes. Veuillez justifier ce retard.', '2024-12-25 13:06:27', 0),
(222, 614, 555, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 15 minutes. Veuillez justifier ce retard.', '2024-12-25 13:15:34', 0),
(223, 613, 554, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 16 minutes. Veuillez justifier ce retard.', '2024-12-25 13:16:27', 0),
(224, 611, 558, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 17 minutes. Veuillez justifier ce retard.', '2024-12-25 13:17:41', 0),
(225, 613, 554, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 22 minutes. Veuillez justifier ce retard.', '2024-12-25 13:22:16', 0),
(226, 611, 558, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 36 minutes. Veuillez justifier ce pointage.', '2024-12-25 13:23:20', 0),
(227, 611, 559, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 37 minutes. Veuillez justifier ce retard.', '2024-12-25 14:37:10', 0),
(228, 613, 554, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 47 minutes. Veuillez justifier ce retard.', '2024-12-25 14:47:36', 1),
(229, 611, 561, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 54 minutes. Veuillez justifier ce retard.', '2024-12-25 14:54:59', 0),
(230, 611, 562, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 45 minutes. Veuillez justifier ce retard.', '2024-12-25 15:45:24', 0),
(231, 611, 563, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 46 minutes. Veuillez justifier ce retard.', '2024-12-25 15:46:12', 0),
(232, 611, 564, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 58 minutes. Veuillez justifier ce retard.', '2024-12-25 15:58:05', 0),
(233, 611, 565, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 59 minutes. Veuillez justifier ce retard.', '2024-12-25 15:59:19', 0),
(234, 614, 566, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 0 minutes. Veuillez justifier ce retard.', '2024-12-25 16:00:02', 0),
(235, 614, 566, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 59 minutes. Veuillez justifier ce pointage.', '2024-12-25 16:00:11', 0),
(236, 614, 567, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 0 minutes. Veuillez justifier ce retard.', '2024-12-25 16:00:48', 0),
(237, 614, 568, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 1 minutes. Veuillez justifier ce retard.', '2024-12-25 16:01:34', 0),
(238, 611, 569, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 1 minutes. Veuillez justifier ce retard.', '2024-12-25 16:01:42', 0),
(239, 614, 570, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 2 minutes. Veuillez justifier ce retard.', '2024-12-25 16:02:55', 0),
(240, 614, 571, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 3 minutes. Veuillez justifier ce retard.', '2024-12-25 16:03:36', 0),
(241, 614, 571, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 55 minutes. Veuillez justifier ce pointage.', '2024-12-25 16:04:02', 0),
(242, 614, 572, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 11 minutes. Veuillez justifier ce retard.', '2024-12-25 16:11:58', 0),
(243, 614, 573, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 12 minutes. Veuillez justifier ce retard.', '2024-12-25 16:12:35', 0),
(244, 611, 574, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 13 minutes. Veuillez justifier ce retard.', '2024-12-25 16:13:15', 0),
(245, 614, 575, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 13 minutes. Veuillez justifier ce retard.', '2024-12-25 16:13:21', 0),
(246, 611, 576, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 17 minutes. Veuillez justifier ce retard.', '2024-12-25 16:17:29', 0),
(247, 614, 577, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 18 minutes. Veuillez justifier ce retard.', '2024-12-25 16:18:33', 0),
(248, 611, 578, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 19 minutes. Veuillez justifier ce retard.', '2024-12-25 16:19:34', 0),
(249, 611, 579, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 20 minutes. Veuillez justifier ce retard.', '2024-12-25 16:20:16', 0),
(250, 611, 580, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 21 minutes. Veuillez justifier ce retard.', '2024-12-25 16:21:35', 0),
(251, 611, 581, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 24 minutes. Veuillez justifier ce retard.', '2024-12-25 16:24:53', 0),
(252, 611, 582, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 27 minutes. Veuillez justifier ce retard.', '2024-12-25 16:27:27', 0),
(253, 614, 583, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 27 minutes. Veuillez justifier ce retard.', '2024-12-25 16:27:39', 0),
(254, 614, 584, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 28 minutes. Veuillez justifier ce retard.', '2024-12-25 16:28:51', 0),
(255, 614, 585, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 33 minutes. Veuillez justifier ce retard.', '2024-12-25 19:33:55', 0),
(256, 611, 586, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 34 minutes. Veuillez justifier ce retard.', '2024-12-25 19:34:52', 0),
(257, 614, 587, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 35 minutes. Veuillez justifier ce retard.', '2024-12-25 19:35:03', 0),
(258, 611, 588, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 36 minutes. Veuillez justifier ce retard.', '2024-12-25 19:36:45', 0),
(259, 611, 589, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 38 minutes. Veuillez justifier ce retard.', '2024-12-25 19:38:20', 0),
(260, 614, 590, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 38 minutes. Veuillez justifier ce retard.', '2024-12-25 19:38:32', 0),
(261, 611, 593, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 48 minutes. Veuillez justifier ce retard.', '2024-12-25 19:48:57', 0),
(262, 614, 594, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 49 minutes. Veuillez justifier ce retard.', '2024-12-25 19:49:05', 0),
(263, 611, 595, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 49 minutes. Veuillez justifier ce retard.', '2024-12-25 19:49:43', 0),
(264, 614, 596, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 49 minutes. Veuillez justifier ce retard.', '2024-12-25 19:49:52', 0),
(265, 611, 597, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 53 minutes. Veuillez justifier ce retard.', '2024-12-25 19:53:52', 0),
(266, 614, 598, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 55 minutes. Veuillez justifier ce retard.', '2024-12-25 19:55:53', 0),
(267, 611, 599, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 56 minutes. Veuillez justifier ce retard.', '2024-12-25 19:56:37', 0),
(268, 614, 600, 'Retard détecté:', 'Vous êtes en retard de 11 heures et 56 minutes. Veuillez justifier ce retard.', '2024-12-25 19:56:50', 0),
(269, 609, 553, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 6 minutes. Veuillez justifier ce retard.', '2024-12-25 20:06:15', 1),
(270, 609, 601, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 10 minutes. Veuillez justifier ce retard.', '2024-12-25 20:10:15', 1),
(271, 609, 602, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 14 minutes. Veuillez justifier ce retard.', '2024-12-25 20:14:15', 1),
(272, 609, 603, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 19 minutes. Veuillez justifier ce retard.', '2024-12-25 20:19:42', 1),
(273, 609, 605, 'Retard détecté:', 'Vous êtes en retard de 18 minutes. Veuillez justifier ce retard.', '2024-12-26 00:18:33', 1),
(274, 609, 606, 'Retard détecté:', 'Vous êtes en retard de 26 minutes. Veuillez justifier ce retard.', '2024-12-26 00:26:11', 1),
(275, 609, 607, 'Retard détecté:', 'Vous êtes en retard de 29 minutes. Veuillez justifier ce retard.', '2024-12-26 00:29:04', 1),
(276, 609, 608, 'Retard détecté:', 'Vous êtes en retard de 31 minutes. Veuillez justifier ce retard.', '2024-12-26 00:31:16', 1),
(277, 609, 609, 'Retard détecté:', 'Vous êtes en retard de 48 minutes. Veuillez justifier ce retard.', '2024-12-26 00:48:59', 1),
(278, 609, 610, 'Retard détecté:', 'Vous êtes en retard de 52 minutes. Veuillez justifier ce retard.', '2024-12-26 00:52:34', 1),
(279, 611, 616, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 39 minutes. Veuillez justifier ce retard.', '2024-12-26 09:39:44', 0),
(280, 614, 615, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 50 minutes. Veuillez justifier ce retard.', '2024-12-26 09:50:04', 0),
(281, 609, 610, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 5 minutes. Veuillez justifier ce retard.', '2024-12-26 11:05:16', 1),
(282, 609, 617, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 20 minutes. Veuillez justifier ce retard.', '2024-12-26 11:20:22', 1),
(283, 611, 619, 'Retard détecté:', 'Vous êtes en retard de 39 minutes. Veuillez justifier ce retard.', '2024-12-27 11:09:45', 0),
(284, 611, 625, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 4 minutes. Veuillez justifier ce retard.', '2024-12-27 11:34:29', 0),
(285, 609, 622, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 28 minutes. Veuillez justifier ce retard.', '2024-12-27 12:28:52', 1),
(286, 614, 624, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 49 minutes. Veuillez justifier ce retard.', '2024-12-27 15:49:17', 0),
(287, 614, 624, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 1 heures et 10 minutes. Veuillez justifier ce pointage.', '2024-12-27 15:49:32', 0),
(288, 609, 629, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 14 heures et 43 minutes. Veuillez justifier ce pointage.', '2024-12-30 02:16:11', 1),
(289, 609, 635, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 1 minutes. Veuillez justifier ce retard.', '2024-12-30 09:01:19', 1),
(290, 609, 635, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 7 heures et 54 minutes. Veuillez justifier ce pointage.', '2024-12-30 09:05:40', 1),
(291, 611, 632, 'Retard détecté:', 'Vous êtes en retard de 2 heures et 31 minutes. Veuillez justifier ce retard.', '2024-12-30 10:31:59', 1),
(292, 613, 633, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 28 minutes. Veuillez justifier ce retard.', '2024-12-30 11:28:19', 0),
(293, 614, 634, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 25 minutes. Veuillez justifier ce retard.', '2024-12-30 13:25:43', 0),
(294, 614, 636, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 5 minutes. Veuillez justifier ce retard.', '2024-12-30 14:05:53', 0),
(295, 614, 637, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 10 minutes. Veuillez justifier ce retard.', '2024-12-30 14:10:00', 0),
(296, 614, 638, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 57 minutes. Veuillez justifier ce retard.', '2024-12-30 14:57:55', 0),
(297, 611, 640, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 4 minutes. Veuillez justifier ce retard.', '2024-12-30 15:04:05', 0),
(298, 611, 643, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 6 minutes. Veuillez justifier ce retard.', '2024-12-30 15:06:12', 0),
(299, 611, 644, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 7 minutes. Veuillez justifier ce retard.', '2024-12-30 15:07:58', 0),
(300, 614, 642, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 12 minutes. Veuillez justifier ce retard.', '2024-12-30 15:12:34', 0),
(301, 613, 641, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 15 minutes. Veuillez justifier ce retard.', '2024-12-30 15:15:35', 0),
(302, 611, 645, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 18 minutes. Veuillez justifier ce retard.', '2024-12-30 15:18:59', 0),
(303, 611, 646, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 21 minutes. Veuillez justifier ce retard.', '2024-12-30 15:21:32', 0),
(304, 611, 647, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 22 minutes. Veuillez justifier ce retard.', '2024-12-30 15:22:40', 0),
(305, 611, 648, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 31 minutes. Veuillez justifier ce retard.', '2024-12-30 15:31:08', 0),
(306, 614, 649, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 32 minutes. Veuillez justifier ce retard.', '2024-12-30 15:32:29', 0),
(307, 614, 649, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 1 heures et 27 minutes. Veuillez justifier ce pointage.', '2024-12-30 15:32:35', 0),
(308, 611, 650, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 34 minutes. Veuillez justifier ce retard.', '2024-12-30 15:34:34', 0),
(309, 614, 651, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 34 minutes. Veuillez justifier ce retard.', '2024-12-30 15:34:57', 0),
(310, 614, 651, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 1 heures et 24 minutes. Veuillez justifier ce pointage.', '2024-12-30 15:35:03', 0),
(311, 613, 652, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 42 minutes. Veuillez justifier ce retard.', '2024-12-30 15:42:14', 0),
(312, 613, 653, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 46 minutes. Veuillez justifier ce retard.', '2024-12-30 15:46:25', 1),
(313, 609, 639, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 47 minutes. Veuillez justifier ce retard.', '2024-12-30 15:47:24', 1),
(314, 609, 639, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 1 heures et 12 minutes. Veuillez justifier ce pointage.', '2024-12-30 15:47:34', 1),
(315, 611, 655, 'Retard détecté:', 'Vous êtes en retard de 13 heures et 18 minutes. Veuillez justifier ce retard.', '2024-12-30 21:18:57', 1),
(316, 611, 661, 'Retard détecté:', 'Vous êtes en retard de 31 minutes. Veuillez justifier ce retard.', '2024-12-31 08:31:05', 1),
(317, 611, 664, 'Retard détecté:', 'Vous êtes en retard de 40 minutes. Veuillez justifier ce retard.', '2024-12-31 08:40:31', 1),
(318, 611, 664, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 7 heures et 25 minutes. Veuillez justifier ce pointage.', '2024-12-31 09:34:01', 1),
(319, 609, 660, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 12 minutes. Veuillez justifier ce retard.', '2024-12-31 11:12:46', 1),
(320, 609, 660, 'Pointage Avant l\'Heure :', 'Vous êtes pointer avant l\'heure de 5 heures et 46 minutes. Veuillez justifier ce pointage.', '2024-12-31 11:13:50', 1),
(321, 611, 665, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 33 minutes. Veuillez justifier ce retard.', '2025-01-01 15:33:53', 0),
(322, 609, 666, 'Retard détecté:', 'Vous êtes en retard de 13 heures et 34 minutes. Veuillez justifier ce retard.', '2025-01-01 21:34:40', 1),
(323, 611, 667, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 14 heures et 2 minutes. Veuillez justifier ce pointage.', '2025-01-01 23:57:35', 0),
(324, 613, 668, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 13 heures et 58 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:01:42', 0),
(325, 614, 669, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 16 heures et 57 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:02:41', 0),
(326, 613, 670, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 13 heures et 55 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:04:46', 0),
(327, 613, 671, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 13 heures et 54 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:05:41', 0),
(328, 614, 672, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 16 heures et 53 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:06:27', 0),
(329, 613, 673, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 13 heures et 52 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:07:21', 0),
(330, 614, 674, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 16 heures et 50 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:09:04', 0),
(331, 613, 675, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 13 heures et 49 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:10:55', 0),
(332, 614, 676, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 16 heures et 47 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:12:02', 0),
(333, 611, 677, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 13 heures et 46 minutes. Veuillez justifier ce pointage.', '2025-01-02 00:13:28', 0),
(334, 611, 683, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 21 minutes. Veuillez justifier ce retard.', '2025-01-02 09:21:15', 0),
(335, 614, 682, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 22 minutes. Veuillez justifier ce retard.', '2025-01-02 09:22:47', 0),
(336, 611, 684, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 24 minutes. Veuillez justifier ce retard.', '2025-01-02 09:24:27', 0),
(337, 611, 684, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 4 heures et 35 minutes. Veuillez justifier ce pointage.', '2025-01-02 09:24:34', 0),
(338, 609, 680, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 29 minutes. Veuillez justifier ce retard.', '2025-01-02 09:29:17', 1),
(339, 609, 685, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 33 minutes. Veuillez justifier ce retard.', '2025-01-02 09:33:27', 1),
(340, 609, 686, 'Retard détecté:', 'Vous êtes en retard de 2 heures et 50 minutes. Veuillez justifier ce retard.', '2025-01-02 10:50:15', 1),
(341, 609, 687, 'Retard détecté:', 'Vous êtes en retard de 2 heures et 57 minutes. Veuillez justifier ce retard.', '2025-01-02 10:57:00', 1),
(342, 609, 688, 'Retard détecté:', 'Vous êtes en retard de 2 heures et 58 minutes. Veuillez justifier ce retard.', '2025-01-02 10:58:17', 1),
(343, 609, 689, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 0 minutes. Veuillez justifier ce retard.', '2025-01-02 11:00:30', 1),
(344, 609, 689, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 59 minutes. Veuillez justifier ce pointage.', '2025-01-02 11:00:57', 1),
(345, 609, 689, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 54 minutes. Veuillez justifier ce pointage.', '2025-01-02 11:05:44', 1),
(346, 609, 690, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 6 minutes. Veuillez justifier ce retard.', '2025-01-02 11:06:33', 1),
(347, 609, 690, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 53 minutes. Veuillez justifier ce pointage.', '2025-01-02 11:06:42', 1),
(348, 609, 691, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 8 minutes. Veuillez justifier ce retard.', '2025-01-02 11:08:28', 1),
(349, 609, 691, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 51 minutes. Veuillez justifier ce pointage.', '2025-01-02 11:08:34', 1),
(350, 611, 692, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 14 minutes. Veuillez justifier ce retard.', '2025-01-02 11:14:31', 0),
(351, 611, 692, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 2 heures et 45 minutes. Veuillez justifier ce pointage.', '2025-01-02 11:14:34', 0),
(352, 614, 693, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 16 minutes. Veuillez justifier ce retard.', '2025-01-02 11:16:24', 0),
(353, 614, 693, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 43 minutes. Veuillez justifier ce pointage.', '2025-01-02 11:16:59', 0),
(354, 611, 694, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 21 minutes. Veuillez justifier ce retard.', '2025-01-02 11:21:43', 1),
(355, 611, 694, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 2 heures et 38 minutes. Veuillez justifier ce pointage.', '2025-01-02 11:21:46', 1),
(356, 614, 695, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 59 minutes. Veuillez justifier ce retard.', '2025-01-02 13:59:13', 0),
(357, 613, 681, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 2 minutes. Veuillez justifier ce retard.', '2025-01-02 14:02:02', 0),
(358, 614, 696, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 7 minutes. Veuillez justifier ce retard.', '2025-01-02 14:07:32', 0),
(359, 613, 697, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 29 minutes. Veuillez justifier ce retard.', '2025-01-02 14:29:41', 1),
(360, 614, 698, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 33 minutes. Veuillez justifier ce retard.', '2025-01-02 15:33:34', 0),
(361, 614, 699, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 51 minutes. Veuillez justifier ce retard.', '2025-01-02 15:51:36', 0),
(362, 614, 699, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 1 heures et 8 minutes. Veuillez justifier ce pointage.', '2025-01-02 15:51:40', 0),
(363, 609, 700, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 56 minutes. Veuillez justifier ce retard.', '2025-01-02 15:56:29', 1),
(364, 609, 700, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 1 heures et 0 minutes. Veuillez justifier ce pointage.', '2025-01-02 15:59:07', 1),
(365, 609, 701, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 0 minutes. Veuillez justifier ce retard.', '2025-01-02 16:00:13', 1),
(366, 609, 701, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 59 minutes. Veuillez justifier ce pointage.', '2025-01-02 16:00:35', 1),
(367, 609, 702, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 3 minutes. Veuillez justifier ce retard.', '2025-01-02 16:03:32', 1),
(368, 609, 702, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 55 minutes. Veuillez justifier ce pointage.', '2025-01-02 16:04:20', 1),
(369, 609, 703, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 8 minutes. Veuillez justifier ce retard.', '2025-01-02 16:08:39', 1),
(370, 609, 703, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 49 minutes. Veuillez justifier ce pointage.', '2025-01-02 16:10:17', 1),
(371, 613, 704, 'Retard détecté:', 'Vous êtes en retard de 10 heures et 25 minutes. Veuillez justifier ce retard.', '2025-01-02 18:25:15', 0),
(372, 613, 705, 'Retard détecté:', 'Vous êtes en retard de 10 heures et 31 minutes. Veuillez justifier ce retard.', '2025-01-02 18:31:53', 1),
(373, 611, 706, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 3 heures et 37 minutes. Veuillez justifier ce pointage.', '2025-01-03 10:22:09', 0),
(374, 611, 707, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 20 minutes. Veuillez justifier ce retard.', '2025-01-03 13:50:58', 1),
(383, 611, 708, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 7 minutes. Veuillez justifier ce retard.', '2025-01-03 14:37:57', 1),
(385, 613, 708, 'Nouvelle justification d\'arrivée', 'Le salarié a soumis une justification pour son arrivée : \"mkhfff\"', '2025-01-03 14:54:03', 1),
(386, 613, 708, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée\"', '2025-01-03 14:59:57', 0),
(387, 613, 708, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-03 15:47:37', 0),
(388, 611, 714, 'Retard détecté:', 'Vous êtes en retard de 13 heures et 59 minutes. Veuillez justifier ce retard.', '2025-01-05 22:59:56', 1),
(389, 611, 715, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 17 heures et 52 minutes. Veuillez justifier ce pointage.', '2025-01-05 23:07:24', 1),
(390, 613, 715, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 00:39:58', 0),
(391, 613, 715, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 00:43:41', 0),
(392, 613, 715, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 00:57:52', 0),
(393, 613, 715, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 00:58:10', 0),
(394, 613, 715, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 01:03:37', 1),
(395, 613, 715, 'Nouvelle justification de départ', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son départ\"', '2025-01-06 01:07:43', 1),
(397, 611, 694, 'Justification refusée', 'Votre justification d\'arrivée est refusée par votre manager.', '2025-01-06 09:18:22', 0),
(400, 611, 694, 'Justification refusée', 'Votre justification d\'arrivée pour le 02/01/2025 00:00 est refusée par votre manager.', '2025-01-06 09:40:35', 0),
(401, 611, 694, 'Justification refusée', 'Votre justification d\'arrivée pour le 2025-01-02 est refusée par votre manager.', '2025-01-06 09:46:20', 1),
(402, 611, 694, 'Justification refusée', 'Votre justification d\'arrivée pour le 02/01/2025 est refusée par votre manager.', '2025-01-06 09:49:48', 1),
(403, 611, 722, 'Retard détecté:', 'Vous êtes en retard de 2 heures et 55 minutes. Veuillez justifier ce retard.', '2025-01-06 10:55:26', 1),
(404, 613, 722, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 10:57:33', 1),
(405, 613, 722, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 11:06:47', 1),
(406, 611, 722, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 3 heures et 8 minutes. Veuillez justifier ce pointage.', '2025-01-06 13:51:27', 1),
(407, 613, 722, 'Nouvelle justification de départ', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son départ\"', '2025-01-06 13:52:28', 1),
(408, 613, 722, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 14:08:38', 1),
(409, 613, 722, 'Nouvelle justification de départ', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son départ\"', '2025-01-06 14:16:23', 0),
(410, 613, 722, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 14:16:56', 0),
(411, 613, 722, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 14:19:39', 0),
(412, 613, 722, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 14:20:27', 1),
(413, 613, 722, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 14:21:14', 1),
(414, 613, 722, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 14:22:16', 1),
(415, 613, 722, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-06 14:23:48', 1),
(416, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 14:56:23', 0),
(417, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 14:57:09', 0),
(418, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:01:14', 0),
(419, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:01:30', 0),
(420, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:05:40', 0),
(421, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:07:39', 0),
(422, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:09:20', 0),
(423, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:10:28', 0),
(424, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:12:52', 0),
(425, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:13:40', 0),
(426, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:13:48', 0),
(427, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:14:06', 0),
(428, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:14:10', 0),
(429, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:14:26', 0),
(430, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:18:22', 0),
(431, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:41:16', 0),
(432, 611, 722, 'Justification refusée', 'Votre justification d\'arrivée pour le 06/01/2025 est refusée par votre manager.', '2025-01-06 15:57:05', 0),
(433, 611, 722, 'Justification acceptée', 'Votre justification d\'arrivée pour le 06/01/2025 a été acceptée comme temporaire.', '2025-01-06 16:07:03', 0),
(434, 611, 722, 'Justification acceptée', 'Votre justification d\'arrivée pour le 06/01/2025 a été acceptée comme définitive.', '2025-01-06 16:10:01', 0),
(435, 611, 722, 'Justification de départ refusée', 'Votre justification de départ pour le 06/01/2025 a été refusée.', '2025-01-06 16:30:52', 1),
(436, 611, 722, 'Justification acceptée', 'Votre justification de départ pour le 06/01/2025 a été acceptée comme temporaire.', '2025-01-06 16:40:23', 0),
(437, 611, 722, 'Justification acceptée', 'Votre justification de départ pour le 06/01/2025 a été acceptée comme définitive.', '2025-01-06 16:40:34', 0),
(438, 609, 721, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 17 heures et 7 minutes. Veuillez justifier ce pointage.', '2025-01-06 23:52:44', 1),
(439, 613, 723, 'Retard détecté:', 'Vous êtes en retard de 6 minutes. Veuillez justifier ce retard.', '2025-01-07 08:06:41', 1),
(440, 2, 723, 'Nouvelle justification d\'arrivée', 'Le salarié nabila TAGUEZ a soumis une justification pour son arrivée.', '2025-01-07 09:06:58', 0),
(441, 613, 723, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 07/01/2025 a été acceptée comme définitive.', '2025-01-07 09:11:46', 1),
(442, 613, 723, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 4 heures et 13 minutes. Veuillez justifier ce pointage.', '2025-01-07 09:46:24', 1),
(443, 2, 723, 'Nouvelle justification de départ', 'Le salarié nabila TAGUEZ a soumis une justification pour son départ.', '2025-01-07 09:54:15', 0),
(444, 613, 723, 'Justification de départ refusée', 'Votre justification de départ pour le 07/01/2025 a été refusée.', '2025-01-07 09:55:18', 1),
(445, 2, 723, 'Nouvelle justification de départ', 'Le salarié nabila TAGUEZ a soumis une justification pour son départ.', '2025-01-07 09:57:38', 0),
(446, 2, 723, 'Nouvelle justification de départ', 'Le salarié nabila TAGUEZ a soumis une justification pour son départ.', '2025-01-07 09:57:56', 0),
(450, 614, 729, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 13 minutes. Veuillez justifier ce retard.', '2025-01-07 11:13:38', 0),
(451, 611, 730, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 14 minutes. Veuillez justifier ce retard.', '2025-01-07 11:14:05', 0),
(452, 614, 729, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 45 minutes. Veuillez justifier ce pointage.', '2025-01-07 11:14:09', 0),
(453, 611, 730, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 45 minutes. Veuillez justifier ce pointage.', '2025-01-07 11:14:13', 0),
(454, 611, 731, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 25 minutes. Veuillez justifier ce retard.', '2025-01-07 11:25:02', 0),
(455, 611, 731, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 34 minutes. Veuillez justifier ce pointage.', '2025-01-07 11:25:04', 0),
(456, 614, 732, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 33 minutes. Veuillez justifier ce retard.', '2025-01-07 11:33:54', 0),
(457, 614, 732, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 26 minutes. Veuillez justifier ce pointage.', '2025-01-07 11:33:57', 0),
(458, 611, 733, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 42 minutes. Veuillez justifier ce retard.', '2025-01-07 11:42:44', 0),
(459, 611, 733, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 17 minutes. Veuillez justifier ce pointage.', '2025-01-07 11:42:51', 0),
(460, 614, 734, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 45 minutes. Veuillez justifier ce retard.', '2025-01-07 11:45:26', 0),
(461, 614, 734, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 5 heures et 14 minutes. Veuillez justifier ce pointage.', '2025-01-07 11:45:30', 0),
(462, 614, 735, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 46 minutes. Veuillez justifier ce retard.', '2025-01-07 11:46:57', 0),
(463, 614, 736, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 47 minutes. Veuillez justifier ce retard.', '2025-01-07 11:47:22', 0),
(464, 611, 737, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 10 minutes. Veuillez justifier ce retard.', '2025-01-07 12:10:23', 0),
(465, 611, 737, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 4 heures et 49 minutes. Veuillez justifier ce pointage.', '2025-01-07 12:10:29', 0),
(466, 614, 738, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 34 minutes. Veuillez justifier ce retard.', '2025-01-07 13:34:10', 0),
(467, 614, 738, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 3 heures et 25 minutes. Veuillez justifier ce pointage.', '2025-01-07 13:34:21', 0),
(468, 614, 739, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 39 minutes. Veuillez justifier ce retard.', '2025-01-07 13:39:49', 0),
(469, 614, 739, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 3 heures et 6 minutes. Veuillez justifier ce pointage.', '2025-01-07 13:53:41', 0),
(470, 614, 740, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 54 minutes. Veuillez justifier ce retard.', '2025-01-07 13:54:15', 0),
(471, 609, 726, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 7 minutes. Veuillez justifier ce retard.', '2025-01-07 14:07:51', 1),
(472, 613, 726, 'Nouvelle justification d\'arrivée', 'Le salarié Hamza DRIDI a soumis une justification pour son arrivée.', '2025-01-07 14:09:13', 1);
INSERT INTO `wbcc_notification` (`idNotification`, `idUtilisateur`, `idPointage`, `title`, `message`, `created_at`, `is_read`) VALUES
(473, 609, 726, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 07/01/2025 est refusée par votre manager.', '2025-01-07 14:10:10', 1),
(474, 609, 726, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 07/01/2025 est refusée par votre manager.', '2025-01-07 14:13:39', 1),
(475, 609, 726, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 07/01/2025 est refusée par votre manager.', '2025-01-07 14:16:00', 1),
(476, 609, 726, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 07/01/2025 est refusée par votre manager.', '2025-01-07 14:16:08', 1),
(477, 609, 726, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 07/01/2025 est refusée par votre manager.', '2025-01-07 14:16:38', 1),
(478, 614, 741, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 43 minutes. Veuillez justifier ce retard.', '2025-01-07 14:43:59', 0),
(479, 614, 742, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 47 minutes. Veuillez justifier ce retard.', '2025-01-07 14:47:05', 0),
(480, 614, 743, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 14 minutes. Veuillez justifier ce retard.', '2025-01-07 15:14:13', 0),
(481, 614, 744, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 15 minutes. Veuillez justifier ce retard.', '2025-01-07 15:15:34', 0),
(482, 611, 745, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 32 minutes. Veuillez justifier ce retard.', '2025-01-07 15:32:21', 0),
(483, 614, 746, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 32 minutes. Veuillez justifier ce retard.', '2025-01-07 15:32:28', 0),
(484, 611, 745, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 1 heures et 27 minutes. Veuillez justifier ce pointage.', '2025-01-07 15:32:46', 0),
(485, 614, 746, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 1 heures et 17 minutes. Veuillez justifier ce pointage.', '2025-01-07 15:42:48', 0),
(486, 614, 747, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 43 minutes. Veuillez justifier ce retard.', '2025-01-07 15:43:41', 0),
(487, 614, 747, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 1 heures et 16 minutes. Veuillez justifier ce pointage.', '2025-01-07 15:43:47', 0),
(488, 609, 748, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 0 minutes. Veuillez justifier ce retard.', '2025-01-07 16:00:10', 1),
(489, 609, 748, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 33 minutes. Veuillez justifier ce pointage.', '2025-01-07 16:26:12', 1),
(490, 609, 749, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 27 minutes. Veuillez justifier ce retard.', '2025-01-07 16:27:11', 1),
(491, 614, 750, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 19 minutes. Veuillez justifier ce retard.', '2025-01-07 20:19:27', 0),
(492, 614, 751, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 25 minutes. Veuillez justifier ce retard.', '2025-01-07 20:25:15', 0),
(493, 614, 752, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 30 minutes. Veuillez justifier ce retard.', '2025-01-07 20:30:01', 0),
(494, 614, 753, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 34 minutes. Veuillez justifier ce retard.', '2025-01-07 20:34:54', 0),
(495, 614, 754, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 36 minutes. Veuillez justifier ce retard.', '2025-01-07 20:36:59', 0),
(496, 614, 755, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 38 minutes. Veuillez justifier ce retard.', '2025-01-07 20:38:37', 0),
(497, 614, 756, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 42 minutes. Veuillez justifier ce retard.', '2025-01-07 20:42:16', 0),
(498, 614, 757, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 46 minutes. Veuillez justifier ce retard.', '2025-01-07 20:46:05', 0),
(499, 614, 758, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 46 minutes. Veuillez justifier ce retard.', '2025-01-07 20:46:43', 0),
(500, 614, 759, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 52 minutes. Veuillez justifier ce retard.', '2025-01-07 20:52:04', 0),
(501, 614, 760, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 53 minutes. Veuillez justifier ce retard.', '2025-01-07 20:53:05', 0),
(502, 614, 761, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 54 minutes. Veuillez justifier ce retard.', '2025-01-07 20:54:27', 0),
(503, 614, 762, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 55 minutes. Veuillez justifier ce retard.', '2025-01-07 20:55:06', 0),
(504, 614, 763, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 56 minutes. Veuillez justifier ce retard.', '2025-01-07 20:56:00', 0),
(505, 614, 764, 'Retard détecté:', 'Vous êtes en retard de 12 heures et 56 minutes. Veuillez justifier ce retard.', '2025-01-07 20:56:39', 0),
(506, 614, 765, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 16 heures et 37 minutes. Veuillez justifier ce pointage.', '2025-01-08 00:22:30', 0),
(507, 614, 766, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 16 heures et 34 minutes. Veuillez justifier ce pointage.', '2025-01-08 00:25:02', 0),
(508, 611, 767, 'Retard détecté:', 'Vous êtes en retard de 11 minutes. Veuillez justifier ce retard.', '2025-01-08 08:11:35', 0),
(509, 614, 768, 'Retard détecté:', 'Vous êtes en retard de 12 minutes. Veuillez justifier ce retard.', '2025-01-08 08:12:10', 0),
(510, 613, 777, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 12 heures et 25 minutes. Veuillez justifier ce pointage.', '2025-01-08 08:35:00', 1),
(511, 614, 784, 'Retard détecté:', 'Vous êtes en retard de 59 minutes. Veuillez justifier ce retard.', '2025-01-08 08:59:40', 0),
(512, 609, 773, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 26 minutes. Veuillez justifier ce retard.', '2025-01-08 09:26:21', 1),
(513, 609, 787, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 28 minutes. Veuillez justifier ce retard.', '2025-01-08 09:28:51', 1),
(514, 609, 788, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 33 minutes. Veuillez justifier ce retard.', '2025-01-08 09:33:04', 1),
(515, 609, 789, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 34 minutes. Veuillez justifier ce retard.', '2025-01-08 09:34:04', 1),
(527, 609, 798, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 51 minutes. Veuillez justifier ce retard.', '2025-01-08 09:51:38', 1),
(528, 609, 799, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 52 minutes. Veuillez justifier ce retard.', '2025-01-08 09:52:15', 1),
(529, 609, 799, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 7 heures et 7 minutes. Veuillez justifier ce pointage.', '2025-01-08 09:52:22', 1),
(530, 609, 800, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 52 minutes. Veuillez justifier ce retard.', '2025-01-08 09:52:40', 1),
(531, 609, 801, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 56 minutes. Veuillez justifier ce retard.', '2025-01-08 09:56:43', 1),
(532, 609, 807, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 54 minutes. Veuillez justifier ce retard.', '2025-01-08 11:54:05', 1),
(533, 609, 812, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 0 minutes. Veuillez justifier ce retard.', '2025-01-08 12:00:32', 1),
(534, 611, 813, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 3 minutes. Veuillez justifier ce retard.', '2025-01-08 12:03:33', 1),
(535, 607, 814, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 6 minutes. Veuillez justifier ce retard.', '2025-01-08 12:06:19', 0),
(536, 614, 815, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 6 minutes. Veuillez justifier ce retard.', '2025-01-08 12:06:23', 0),
(537, 2, 816, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 6 minutes. Veuillez justifier ce retard.', '2025-01-08 12:06:26', 0),
(538, 2, 816, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 1 heures et 53 minutes. Veuillez justifier ce pointage.', '2025-01-08 12:06:57', 0),
(539, 609, 818, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 12 minutes. Veuillez justifier ce retard.', '2025-01-08 12:12:07', 1),
(540, 613, 813, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-08 13:19:49', 0),
(541, 613, 813, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-08 14:08:31', 1),
(542, 611, 819, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 46 minutes. Veuillez justifier ce retard.', '2025-01-08 14:46:32', 0),
(543, 609, 820, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 46 minutes. Veuillez justifier ce retard.', '2025-01-08 14:46:56', 1),
(544, 609, 821, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 49 minutes. Veuillez justifier ce retard.', '2025-01-08 14:49:08', 1),
(545, 609, 822, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 52 minutes. Veuillez justifier ce retard.', '2025-01-08 14:52:44', 1),
(546, 611, 823, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 3 minutes. Veuillez justifier ce retard.', '2025-01-08 15:03:25', 1),
(547, 613, 824, 'Retard détecté:', 'Vous êtes en retard de 3 heures et 11 minutes. Veuillez justifier ce retard.', '2025-01-08 15:14:38', 0),
(548, 614, 825, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 39 minutes. Veuillez justifier ce retard.', '2025-01-08 15:39:28', 0),
(549, 614, 826, 'Retard détecté:', 'Vous êtes en retard de 7 heures et 44 minutes. Veuillez justifier ce retard.', '2025-01-08 15:44:59', 0),
(550, 613, 824, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 1 heures et 8 minutes. Veuillez justifier ce pointage.', '2025-01-08 19:51:55', 0),
(554, 609, 828, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-09 00:46:38', 1),
(555, 613, 363, 'Nouvelle justification d\'absence', 'Le salarié Hamza DRIDI a soumis une justification pour son absence.', '2025-01-09 08:56:11', 1),
(556, 613, 822, 'Nouvelle justification d\'arrivée', 'Le salarié Hamza DRIDI a soumis une justification pour son arrivée.', '2025-01-09 10:50:26', 1),
(557, 613, 749, 'Nouvelle justification d\'arrivée', 'Le salarié Hamza DRIDI a soumis une justification pour son arrivée.', '2025-01-09 11:29:08', 1),
(558, 613, 538, 'Nouvelle justification d\'absence', 'Le salarié Hamza DRIDI a soumis une justification pour son absence.', '2025-01-09 11:31:22', 1),
(559, 613, 538, 'Nouvelle justification d\'absence', 'Le salarié Hamza DRIDI a soumis une justification pour son absence.', '2025-01-09 12:13:30', 1),
(560, 613, 538, 'Nouvelle justification d\'absence', 'Le salarié Hamza DRIDI a soumis une justification pour son absence.', '2025-01-09 12:31:50', 1),
(561, 611, 831, 'Justification d\'absence refusée', 'Votre justification d\'absence pour le 09/01/2025 a été refusée.', '2025-01-09 15:23:37', 0),
(562, 611, 831, 'Justification d\'absence acceptée', 'Votre justification d\'absence pour le 09/01/2025 a été acceptée comme temporaire.', '2025-01-09 15:24:31', 0),
(563, 611, 831, 'Justification d\'absence acceptée', 'Votre justification d\'absence pour le 09/01/2025 a été acceptée comme définitive.', '2025-01-09 15:24:52', 0),
(564, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 15:36:02', 1),
(565, 609, 828, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-09 15:43:09', 0),
(566, 609, 828, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 1 heures et 16 minutes. Veuillez justifier ce pointage.', '2025-01-09 15:43:09', 0),
(567, 613, 828, 'Nouvelle justification de départ', 'Le salarié Hamza DRIDI a soumis une justification pour son départ.', '2025-01-09 15:43:52', 1),
(568, 613, 828, 'Nouvelle justification de départ', 'Le salarié Hamza DRIDI a soumis une justification pour son départ.', '2025-01-09 16:11:37', 0),
(569, 613, 828, 'Nouvelle justification de départ', 'Le salarié Hamza DRIDI a soumis une justification pour son départ.', '2025-01-09 16:14:41', 0),
(570, 613, 832, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-09 16:16:47', 0),
(571, 613, 832, 'Retard détecté:', 'Vous êtes en retard de 8 heures et 16 minutes. Veuillez justifier ce retard.', '2025-01-09 16:16:47', 0),
(572, 613, 832, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-09 16:18:05', 0),
(573, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 16:31:31', 0),
(574, 613, 823, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-09 16:36:00', 1),
(575, 611, 834, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-09 17:00:31', 0),
(576, 611, 834, 'Retard détecté:', 'Vous êtes en retard de 9 heures et 0 minutes. Veuillez justifier ce retard.', '2025-01-09 17:00:32', 0),
(577, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 20:25:42', 0),
(578, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 20:34:57', 0),
(579, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 20:36:37', 0),
(580, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 20:41:18', 0),
(581, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 20:49:36', 0),
(582, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 20:51:56', 0),
(583, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 20:52:42', 0),
(584, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 20:53:52', 0),
(585, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 20:54:37', 0),
(586, 613, 745, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-09 20:58:08', 0),
(587, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 21:01:40', 0),
(588, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-09 21:04:36', 0),
(589, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 00:29:33', 0),
(590, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 00:33:33', 0),
(591, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 00:36:17', 0),
(592, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 00:37:36', 0),
(593, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 00:39:55', 0),
(594, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 00:50:30', 0),
(595, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 00:56:20', 0),
(596, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 00:56:34', 0),
(597, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 00:59:09', 0),
(598, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 01:34:04', 0),
(599, 613, 823, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-10 01:36:10', 0),
(600, 613, 745, 'Nouvelle justification de départ', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son départ.', '2025-01-10 01:38:52', 0),
(601, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 10:05:11', 0),
(602, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 10:07:42', 0),
(603, 613, 823, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-10 10:15:31', 0),
(604, 613, 823, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-10 10:19:11', 0),
(605, 613, 823, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-10 10:25:34', 0),
(606, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 10:26:04', 0),
(607, 611, 844, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-10 10:41:48', 0),
(608, 611, 844, 'Retard détecté:', 'Vous êtes en retard de 11 minutes. Veuillez justifier ce retard.', '2025-01-10 10:41:48', 0),
(609, 611, 844, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-10 10:41:54', 0),
(610, 611, 844, 'Pointage Avant l\'Heure :', 'Vous avez pointé avant l\'heure de 3 heures et 18 minutes. Veuillez justifier ce pointage.', '2025-01-10 10:41:54', 0),
(611, 613, 834, 'Nouvelle justification d\'absence', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son absence.', '2025-01-10 12:10:02', 0),
(612, 2, 714, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-12 19:29:57', 0),
(613, 613, 714, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-12 19:29:57', 0),
(614, 614, 714, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-12 19:29:57', 0),
(615, 2, 851, 'Nouvelle justification d\'arrivée', 'Le salarié nabila TAGUEZ a soumis une justification pour son arrivée.', '2025-01-13 01:28:05', 0),
(617, 611, 859, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 09:05:12', 0),
(618, 611, 859, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 5 minutes. Veuillez justifier ce retard.', '2025-01-13 09:05:13', 0),
(619, 611, 860, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 09:05:37', 0),
(620, 611, 860, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 5 minutes. Veuillez justifier ce retard.', '2025-01-13 09:05:37', 0),
(621, 611, 861, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 09:08:57', 0),
(622, 611, 861, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 8 minutes. Veuillez justifier ce retard.', '2025-01-13 09:08:57', 0),
(623, 611, 862, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 09:18:21', 0),
(624, 611, 863, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 09:18:54', 0),
(625, 611, 864, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 09:20:23', 0),
(626, 611, 865, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 09:23:25', 0),
(627, 611, 866, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 09:27:20', 0),
(628, 611, 867, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 09:28:33', 1),
(629, 611, 868, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 10:07:48', 0),
(630, 611, 870, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 11:10:00', 0),
(631, 611, 870, 'Retard détecté:', 'Vous êtes en retard de 5 minutes. Veuillez justifier ce retard.', '2025-01-13 11:10:00', 0),
(632, 611, 871, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-13 11:11:26', 0),
(633, 2, 714, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-13 23:01:09', 0),
(634, 613, 714, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-13 23:01:09', 0),
(635, 614, 714, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-13 23:01:10', 0),
(636, 2, 857, 'Nouvelle justification d\'arrivée', 'Le salarié nabila TAGUEZ a soumis une justification pour son arrivée.', '2025-01-14 08:38:02', 0),
(637, 611, 872, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-14 09:29:30', 0),
(638, 611, 872, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 24 minutes. Veuillez justifier ce retard.', '2025-01-14 09:29:30', 1),
(639, 2, 872, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 09:44:03', 0),
(640, 613, 872, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 09:44:03', 1),
(641, 614, 872, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 09:44:03', 0),
(642, 611, 872, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme temporaire.', '2025-01-14 09:45:29', 0),
(643, 611, 872, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme temporaire.', '2025-01-14 09:45:33', 0),
(644, 611, 872, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 14/01/2025 est refusée par votre manager.', '2025-01-14 09:52:36', 0),
(645, 611, 872, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme temporaire.', '2025-01-14 09:53:53', 0),
(646, 611, 872, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme temporaire.', '2025-01-14 09:54:23', 0),
(647, 611, 872, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 14/01/2025 est refusée par votre manager.', '2025-01-14 09:56:10', 0),
(648, 611, 872, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 14/01/2025 est refusée par votre manager.', '2025-01-14 09:56:14', 0),
(649, 611, 872, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme temporaire.', '2025-01-14 09:56:51', 0),
(650, 611, 873, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-14 09:59:26', 0),
(651, 611, 873, 'Retard détecté:', 'Vous êtes en retard de 1 heures et 54 minutes. Veuillez justifier ce retard.', '2025-01-14 09:59:26', 1),
(652, 2, 873, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 10:01:37', 0),
(653, 613, 873, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 10:01:37', 1),
(654, 614, 873, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 10:01:37', 0),
(655, 611, 873, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 14/01/2025 est refusée par votre manager.', '2025-01-14 10:02:43', 0),
(656, 611, 873, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme temporaire.', '2025-01-14 10:03:05', 0),
(657, 2, 873, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 10:04:13', 0),
(658, 613, 873, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 10:04:13', 0),
(659, 614, 873, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 10:04:13', 0),
(660, 611, 873, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme définitive.', '2025-01-14 10:04:57', 0),
(661, 611, 844, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 10/01/2025 est refusée par votre manager.', '2025-01-14 10:32:46', 1),
(662, 2, 844, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 10:36:12', 0),
(663, 613, 844, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 10:36:13', 0),
(664, 614, 844, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 10:36:13', 0),
(665, 609, 874, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-14 10:43:58', 0),
(666, 609, 874, 'Retard détecté:', 'Vous êtes en retard de 2 heures et 38 minutes. Veuillez justifier ce retard.', '2025-01-14 10:43:59', 0),
(667, 2, 874, 'Nouvelle justification d\'arrivée', 'Le salarié Hamza DRIDI a soumis une justification pour son arrivée.', '2025-01-14 10:44:28', 0),
(668, 613, 874, 'Nouvelle justification d\'arrivée', 'Le salarié Hamza DRIDI a soumis une justification pour son arrivée.', '2025-01-14 10:44:28', 0),
(669, 614, 874, 'Nouvelle justification d\'arrivée', 'Le salarié Hamza DRIDI a soumis une justification pour son arrivée.', '2025-01-14 10:44:29', 0),
(670, 609, 874, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme temporaire.', '2025-01-14 10:45:07', 0),
(671, 609, 822, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 08/01/2025 a été acceptée comme temporaire.', '2025-01-14 10:46:28', 0),
(672, 609, 828, 'Justification de départ refusée', 'Votre justification de départ pour le 09/01/2025 a été refusée.', '2025-01-14 10:58:16', 0),
(673, 609, 828, 'Justification de départ acceptée', 'Votre justification de départ pour le 09/01/2025 a été acceptée comme temporaire.', '2025-01-14 11:01:01', 0),
(674, 611, 875, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-14 12:31:29', 0),
(675, 611, 875, 'Retard détecté:', 'Vous êtes en retard de 4 heures et 26 minutes. Veuillez justifier ce retard.', '2025-01-14 12:31:29', 1),
(676, 2, 875, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 12:34:52', 0),
(677, 613, 875, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 12:34:52', 1),
(678, 614, 875, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 12:34:52', 0),
(679, 611, 875, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 14/01/2025 est refusée par votre manager.', '2025-01-14 12:36:08', 1),
(680, 2, 875, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 12:37:41', 0),
(681, 613, 875, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 12:37:42', 0),
(682, 614, 875, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 12:37:42', 0),
(683, 611, 875, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme définitive.', '2025-01-14 12:38:32', 0),
(684, 611, 876, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-14 13:45:01', 0),
(685, 611, 876, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 40 minutes. Veuillez justifier ce retard.', '2025-01-14 13:45:01', 1),
(686, 2, 876, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:46:29', 0),
(687, 613, 876, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:46:30', 0),
(688, 614, 876, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:46:30', 0),
(689, 2, 876, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:47:21', 0),
(690, 613, 876, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:47:21', 0),
(691, 614, 876, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:47:21', 0),
(692, 611, 877, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-14 13:49:47', 0),
(693, 611, 877, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 44 minutes. Veuillez justifier ce retard.', '2025-01-14 13:49:48', 1),
(694, 2, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:51:10', 0),
(695, 613, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:51:10', 0),
(696, 614, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:51:10', 0),
(697, 2, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:53:02', 0),
(698, 613, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:53:02', 0),
(699, 2, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:53:02', 0),
(700, 614, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:53:02', 0),
(701, 613, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:53:02', 0),
(702, 614, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:53:02', 0),
(703, 2, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:54:24', 0),
(704, 613, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:54:24', 0),
(705, 614, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:54:24', 0),
(706, 2, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:54:28', 0),
(707, 613, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:54:28', 0),
(708, 614, 877, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 13:54:28', 0),
(709, 611, 878, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-14 13:59:19', 0),
(710, 611, 878, 'Retard détecté:', 'Vous êtes en retard de 5 heures et 54 minutes. Veuillez justifier ce retard.', '2025-01-14 13:59:19', 0),
(711, 2, 878, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 14:00:54', 0),
(712, 613, 878, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 14:00:54', 1),
(713, 614, 878, 'Nouvelle justification d\'arrivée', 'Le salarié Mohamed Achref MEHERZI a soumis une justification pour son arrivée.', '2025-01-14 14:00:54', 0),
(714, 611, 878, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 14/01/2025 est refusée par votre manager.', '2025-01-14 14:03:13', 0),
(715, 611, 878, 'Justification d\'arrivée refusée', 'Votre justification d\'arrivée pour le 14/01/2025 est refusée par votre manager.', '2025-01-14 14:04:38', 0),
(716, 611, 878, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme temporaire.', '2025-01-14 14:05:06', 0),
(717, 611, 878, 'Justification d\'arrivée acceptée', 'Votre justification d\'arrivée pour le 14/01/2025 a été acceptée comme définitive.', '2025-01-14 14:05:22', 0),
(718, 609, 879, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-14 14:08:07', 0),
(719, 609, 879, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 3 minutes. Veuillez justifier ce retard.', '2025-01-14 14:08:07', 0),
(720, 609, 880, 'Problème d\'adresse:', 'Il y a un problème avec votre adresse. Veuillez la vérifier avec l\'administrateur.', '2025-01-14 14:09:14', 0),
(721, 609, 880, 'Retard détecté:', 'Vous êtes en retard de 6 heures et 4 minutes. Veuillez justifier ce retard.', '2025-01-14 14:09:14', 1),
(722, 2, 880, 'Nouvelle justification d\'arrivée', 'Le salarié Hamza DRIDI a soumis une justification pour son arrivée.', '2025-01-14 14:11:03', 0),
(723, 613, 880, 'Nouvelle justification d\'arrivée', 'Le salarié Hamza DRIDI a soumis une justification pour son arrivée.', '2025-01-14 14:11:03', 0),
(724, 614, 880, 'Nouvelle justification d\'arrivée', 'Le salarié Hamza DRIDI a soumis une justification pour son arrivée.', '2025-01-14 14:11:03', 0);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_parametres`
--

CREATE TABLE `wbcc_parametres` (
  `id` int(11) NOT NULL,
  `numeroDemandeCloture` int(11) NOT NULL DEFAULT 0,
  `numeroDemandeValidation` int(11) NOT NULL DEFAULT 0,
  `numeroOpProvisoire` int(11) DEFAULT 0,
  `numeroBordereau` int(11) NOT NULL,
  `numeroOP` int(11) NOT NULL DEFAULT 0,
  `numeroOPamo` int(11) DEFAULT NULL,
  `numeroBordereauCheque` int(100) DEFAULT NULL,
  `numeroJournal` int(11) DEFAULT NULL,
  `numeroFacture` int(11) DEFAULT NULL,
  `numeroFactureProvisoire` int(11) DEFAULT NULL,
  `numeroClient` int(11) DEFAULT NULL,
  `numeroLotOP` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_parametres`
--

INSERT INTO `wbcc_parametres` (`id`, `numeroDemandeCloture`, `numeroDemandeValidation`, `numeroOpProvisoire`, `numeroBordereau`, `numeroOP`, `numeroOPamo`, `numeroBordereauCheque`, `numeroJournal`, `numeroFacture`, `numeroFactureProvisoire`, `numeroClient`, `numeroLotOP`) VALUES
(1, 5, 0, 1267, 168, 1618, 591, 67, 1, 1, 1247, 2, 5002);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_pointage`
--

CREATE TABLE `wbcc_pointage` (
  `idPointage` int(11) NOT NULL,
  `numeroPointage` varchar(50) DEFAULT NULL,
  `datePointage` date DEFAULT NULL,
  `heureDebutPointage` varchar(25) DEFAULT NULL,
  `adressePointage` text DEFAULT NULL,
  `heureDebutJour` varchar(25) DEFAULT NULL,
  `heureFinJour` varchar(25) DEFAULT NULL,
  `marge` int(11) DEFAULT 0,
  `adresseProgramme` text DEFAULT NULL,
  `anomalieDebutJour` int(11) DEFAULT 0,
  `nbMinuteRetard` int(11) DEFAULT 0,
  `retard` int(11) DEFAULT 0,
  `absent` int(11) DEFAULT 0,
  `motifRetard` text DEFAULT NULL,
  `motifRetardDepart` text DEFAULT NULL,
  `traite` int(11) DEFAULT 0,
  `idTraiteF` int(11) DEFAULT NULL,
  `auteurTraite` varchar(255) DEFAULT NULL,
  `dateTraite` varchar(25) DEFAULT NULL,
  `resultatTraite` varchar(255) DEFAULT NULL,
  `heureFinPointage` varchar(25) DEFAULT NULL,
  `nbMinuteDepart` int(11) DEFAULT 0,
  `traiteDepart` int(11) DEFAULT 0,
  `idTraiteDepartF` int(11) DEFAULT NULL,
  `auteurTraiteDepart` varchar(255) DEFAULT NULL,
  `dateTraiteDepart` varchar(25) DEFAULT NULL,
  `resultatTraiteDepart` varchar(255) DEFAULT NULL,
  `adresseFinPointage` text DEFAULT NULL,
  `adresseProgrammeFin` text DEFAULT NULL,
  `anomalieFinJour` int(11) DEFAULT 0,
  `idUserF` int(11) DEFAULT NULL,
  `idDocumentF` int(11) DEFAULT NULL,
  `auteur` varchar(255) DEFAULT NULL,
  `typeTraite` enum('Définitif','Temporaire') DEFAULT NULL,
  `raisonRejet` text DEFAULT NULL,
  `typeTraiteDepart` enum('Définitif','Temporaire') DEFAULT NULL,
  `raisonRejetDepart` text DEFAULT NULL,
  `traiteAbsent` int(11) DEFAULT 0,
  `idTraiteAbsentF` int(11) DEFAULT NULL,
  `auteurTraiteAbsent` varchar(255) DEFAULT NULL,
  `dateTraiteAbsent` varchar(25) DEFAULT NULL,
  `resultatTraiteAbsent` varchar(255) DEFAULT NULL,
  `motifAbsent` text DEFAULT NULL,
  `typeTraiteAbsent` enum('Définitif','Temporaire') DEFAULT NULL,
  `raisonRejetAbsence` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_pointage`
--

INSERT INTO `wbcc_pointage` (`idPointage`, `numeroPointage`, `datePointage`, `heureDebutPointage`, `adressePointage`, `heureDebutJour`, `heureFinJour`, `marge`, `adresseProgramme`, `anomalieDebutJour`, `nbMinuteRetard`, `retard`, `absent`, `motifRetard`, `motifRetardDepart`, `traite`, `idTraiteF`, `auteurTraite`, `dateTraite`, `resultatTraite`, `heureFinPointage`, `nbMinuteDepart`, `traiteDepart`, `idTraiteDepartF`, `auteurTraiteDepart`, `dateTraiteDepart`, `resultatTraiteDepart`, `adresseFinPointage`, `adresseProgrammeFin`, `anomalieFinJour`, `idUserF`, `idDocumentF`, `auteur`, `typeTraite`, `raisonRejet`, `typeTraiteDepart`, `raisonRejetDepart`, `traiteAbsent`, `idTraiteAbsentF`, `auteurTraiteAbsent`, `dateTraiteAbsent`, `resultatTraiteAbsent`, `motifAbsent`, `typeTraiteAbsent`, `raisonRejetAbsence`) VALUES
(1, 'PNTG001', '2024-09-16', '09:30:00', '123 Rue Principale, Tunis', '09:00:00', NULL, 30, 'Siège Social', 0, 30, 1, 0, NULL, NULL, 1, 101, 'John Doe', '2024-09-16', 'Traité', '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '456 Rue Secondaire, Tunis\n', 'Succursale', 0, 605, 49357, 'Jane Doe', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'maladie', NULL, NULL),
(2, 'PNTG002', '2024-09-20', '09:00:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 0, 'Entrepôt', 0, 0, 0, 0, NULL, NULL, 1, 102, 'Mary Smith', '2024-09-16', NULL, '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, NULL, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'PNTG003', '2024-09-18', '07:45:00', '456 Rue Pin, Tunis', '07:30:00', NULL, 15, 'Site Client', 0, 15, 0, 0, '', NULL, 0, NULL, NULL, NULL, 'Non traité', '15:30:00', 0, 0, NULL, NULL, NULL, NULL, '789 Rue Bouleau, Tunis', 'Bureau sur le terrain', 0, 1003, NULL, 'Michael Brown', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'PNTG004', '2024-03-05', '00:00:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 0, 'Entrepôt', 0, 0, 0, 1, 'test1', NULL, 1, 102, 'Mary Smith', '2024-09-16', NULL, '00:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, NULL, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'PNTG005', '2024-09-20', '09:00:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 0, 'Entrepôt', 0, 0, 0, 0, NULL, NULL, 1, 102, 'Mary Smith', '2024-09-16', NULL, '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 3, NULL, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'PNTG006', '2024-09-24', '09:30:00', '123 Rue Principale, Tunis', '09:00:00', NULL, 30, 'Siège Social', 0, 30, 1, 0, 'test3', NULL, 1, 101, 'John Doe', '2024-09-24', 'Traité', '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '456 Rue Secondaire, Tunis\r\n', 'Succursale', 0, 605, NULL, 'Jane Doe', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'PNTG006', '2024-09-23', '09:20:00', '123 Rue Principale, Dakar', '09:00:00', NULL, 30, 'Siège Social', 0, 20, 1, 0, 'testnabila', NULL, 1, 101, 'John Doe', '2024-09-24', 'Traité', '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '456 Rue Secondaire, Tunis\r\n', 'Succursale', 0, 605, NULL, 'Jane Doe', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'PNTG006', '2024-09-19', '00:00:00', '123 Rue Principale, Paris', '09:00:00', NULL, 0, 'Siège Social', 0, 0, 0, 1, 'tttttt', NULL, 1, 101, 'John Doe', '2024-09-24', 'Traité', '00:00:00', 0, 0, NULL, NULL, NULL, NULL, '456 Rue Secondaire, Tunis\r\n', 'Succursale', 0, 605, NULL, 'Jane Doe', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'PNTG005', '2024-09-21', '11:20:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 0, 'Entrepôt', 0, 140, 1, 0, NULL, NULL, 1, 102, 'Mary Smith', '2024-09-16', NULL, '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 3, NULL, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'PNTG005', '2024-05-20', '00:00:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 0, 'Entrepôt', 0, 0, 0, 1, NULL, NULL, 1, 102, 'Mary Smith', '2024-09-16', NULL, '00:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 3, NULL, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'PNTG002', '2024-09-25', '09:20:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 20, 'Entrepôt', 0, 20, 1, 0, 'wbcc test', NULL, 1, 102, 'Mary Smith', '2024-09-16', NULL, '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, NULL, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'PNTG002', '2024-09-26', '09:10:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 10, 'Entrepôt', 0, 10, 1, 0, 'retard métro', NULL, 1, 102, 'Mary Smith', '2024-09-16', NULL, '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, NULL, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'PNTG002', '2024-09-29', '13:10:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 0, 'Entrepôt', 0, 190, 1, 0, 'retard bus', NULL, 1, 2, 'nabila taguez', '2024-09-29 21:28:23', 'Accepté', '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, 49343, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'PNTG002', '2024-09-30', '09:05:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 5, 'Entrepôt', 0, 5, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, 'Non traité', '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, NULL, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'PNTG002', '2024-10-01', '09:05:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 5, 'Entrepôt', 0, 5, 1, 0, 'retard bus', NULL, 1, 2, 'nabila taguez', '2024-10-01 15:23:22', 'Accepté', '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, 49344, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'PNTG002', '2024-10-03', '14:30:00', '789 Rue Orme, Tunis', '10:00:00', '15:00:00', 30, 'Entrepôt', 0, 30, 1, 0, 'retard metro', NULL, 1, 2, 'nabila taguez', '2024-10-03 15:28:03', 'Refusé', '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, 49351, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'PNTG002', '2024-10-04', '09:40:00', '789 Rue Orme, Tunis', '09:00:00', '15:00:00', 40, 'Entrepôt', 0, 40, 1, 0, 'retard bus', NULL, 1, 2, 'nabila taguez', '2024-10-04 16:16:39', 'Accepté', '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, 49352, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'PNTG002', '2024-10-07', '09:20:00', '789 Rue Orme, Tunis', '09:00:00', NULL, 0, 'Entrepôt', 0, 20, 1, 0, NULL, NULL, 1, 2, 'nabila taguez', '2024-10-07 23:27:02', 'Accepté', '15:00:00', 0, 0, NULL, NULL, NULL, NULL, '123 Rue Chêne, Tunis', 'Bureau Secondaire', 0, 605, 49353, 'Alex Johnson', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, NULL, '2024-10-22', '08:11:14', '789 Rue Orme, Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 0, 'manager de site test', NULL, 1, 1, 'Jawher BALTI', '2025-01-08 14:41:57', 'Refusé', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, 49415, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, NULL, '2024-10-22', '08:12:20', NULL, NULL, NULL, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, NULL, '2024-10-22', '08:15:07', NULL, NULL, NULL, 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, NULL, '2024-10-22', '08:18:01', NULL, NULL, NULL, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-08 14:52:34', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, NULL, '2024-10-22', '08:41:53', NULL, NULL, NULL, 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-08 14:53:05', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, NULL, '2024-10-23', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 1, 2, 'nabila taguez', '2024-10-29 01:42:30', 'Refusé', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, NULL, '2024-10-08', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(151, NULL, '2024-10-21', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, 'test 5', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49381, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(152, NULL, '2024-10-22', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, 'test', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49360, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(153, NULL, '2024-10-23', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, 'new test', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49376, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, NULL, '2024-10-24', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, 'xx', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49382, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(161, NULL, '2024-10-25', '10:29:20', NULL, '09:00', NULL, 0, NULL, 0, 89, 1, 0, 'Développer un module de gestion de présence intégré aux applications iOS,\nAndroid et Web existantes pour automatiser le suivi des heures de travail, des\nretards, des absences, et des demandes de congés des salariés, en utilisant les\ndonnées des lecteurs d\'empreintes digitales.\n2. Fonctionnalités Clés\n2.1. Intégration des Données\n• 2.1.1. Importation automatique des données de présence depuis les\nlecteurs d\'empreintes vers une base de données centralisée.\n• 2.1.2. Synchronisation en temps réel avec les applications existantes.\n2.2. Gestion de Présence\n• 2.2.1. Affichage des données de présence dans le module \"Gestion de\nprésence\" pour iOS, Android et Web.\n• 2.2.2. Visualisation en temps réel des arrivées, départs, et retards par\nsalarié et par groupe.\n• 2.2.3. Calcul et affichage des retards en minutes avec cumul journalier,\nhebdomadaire, mensuel, trimestriel, semestriel et annuel.\n• 2.2.4. Personnalisation des horaires de travail par salarié selon les contrats.', NULL, 1, 2, 'nabila taguez', '2024-10-28 22:12:41', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49359, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(162, NULL, '2024-10-26', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49399, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(163, NULL, '2024-10-28', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, 'test Mo', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49397, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(164, NULL, '2024-10-29', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, 'test', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49392, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(167, NULL, '2024-10-30', '11:33:00', '123 Rue Principale, Paris', '09:00', NULL, 0, NULL, 0, 153, 1, 0, 'test', NULL, 1, 2, 'nabila taguez', '2024-10-30 13:18:58', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49400, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(169, NULL, '2024-10-31', '08:14:38', NULL, '09:00', NULL, 0, NULL, 0, 0, 1, 0, NULL, NULL, 1, 605, 'Jean-Marc DJOSSINOU', '2024-11-01 16:51:21', 'Retard Refusé', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49398, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(170, NULL, '2024-11-01', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(171, NULL, '2024-11-02', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(172, NULL, '2024-11-04', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(173, NULL, '2024-11-05', '10:28:56', NULL, '09:00', NULL, 0, NULL, 0, 88, 1, 0, 'Ccc', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, 49405, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(174, NULL, '2024-11-05', '17:01:39', NULL, '09:00', NULL, 0, NULL, 0, 481, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 608, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(175, NULL, '2024-10-24', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(176, NULL, '2024-10-25', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(177, NULL, '2024-10-26', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(178, NULL, '2024-10-28', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(179, NULL, '2024-10-29', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(180, NULL, '2024-10-30', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(181, NULL, '2024-10-31', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(182, NULL, '2024-11-01', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(183, NULL, '2024-11-02', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(184, NULL, '2024-11-04', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(185, NULL, '2024-11-05', '17:09:05', NULL, '09:00', NULL, 0, NULL, 0, 489, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(186, NULL, '2024-11-05', '17:27:22', NULL, '09:00', NULL, 0, NULL, 0, 507, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 608, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(190, NULL, '2024-11-06', '09:38:50', NULL, '09:00', NULL, 0, NULL, 0, 38, 1, 0, 'wxcwxc', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49401, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, NULL, '2024-11-06', '09:43:44', NULL, '09:00', NULL, 0, NULL, 0, 43, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(192, NULL, '2024-11-06', '09:44:42', NULL, '09:00', NULL, 0, NULL, 0, 44, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 612, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(195, NULL, '2024-11-06', '17:14:57', NULL, '09:00', NULL, 0, NULL, 0, 494, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(196, NULL, '2024-11-06', '23:43:20', NULL, '09:00', '15:00', 0, NULL, 0, 883, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, NULL, '2024-11-07', '00:46:45', NULL, '09:00', '15:00', 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, 2, 'nabila TAGUEZ', '2024-11-08 11:22:44', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(198, NULL, '2024-11-07', '00:47:27', NULL, '09:00', '15:00', 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, NULL, '2024-11-07', '21:55:49', NULL, '09:00', '15:00', 0, NULL, 0, 775, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(200, NULL, '2024-11-07', '21:57:12', NULL, '09:00', '15:00', 0, NULL, 0, 777, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(201, NULL, '2024-11-07', '22:01:18', NULL, '09:00', '15:00', 0, NULL, 0, 781, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(202, NULL, '2024-11-07', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, 'test', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49410, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'maladie', NULL, NULL),
(203, NULL, '2024-11-08', '09:55:14', NULL, '09:00', '15:00', 0, NULL, 0, 55, 1, 0, 'test', NULL, 1, 2, 'nabila TAGUEZ', '2024-11-08 11:26:45', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49414, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(213, NULL, '2024-11-08', '14:57:29', NULL, '09:00', '15:00', 0, NULL, 0, 357, 1, 0, 'new test', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 49408, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(214, NULL, '2024-11-09', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(216, NULL, '2024-11-09', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, 'test', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49426, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, NULL, '2024-10-24', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(222, NULL, '2024-10-25', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(223, NULL, '2024-10-26', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(224, NULL, '2024-10-28', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(225, NULL, '2024-10-29', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(226, NULL, '2024-10-30', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(227, NULL, '2024-10-31', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(228, NULL, '2024-11-01', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(229, NULL, '2024-11-02', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(230, NULL, '2024-11-04', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(231, NULL, '2024-11-05', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(232, NULL, '2024-11-06', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(233, NULL, '2024-11-07', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(234, NULL, '2024-11-08', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(235, NULL, '2024-11-09', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(242, NULL, '2024-11-11', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(246, NULL, '2024-11-12', '16:31:08', 'Tunis', '09:00', '15:00', 0, NULL, 0, 451, 1, 0, 'rrr', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, 49430, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(247, NULL, '2024-11-11', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, 'malade', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49489, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(248, NULL, '2024-11-12', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, 'Yyy', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49502, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(249, NULL, '2024-11-13', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, 'ted', NULL, 1, 613, 'nabila TAGUEZ', '2024-11-14 15:31:46', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49456, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(251, NULL, '2024-11-14', '10:56:09', 'Tunis', '09:00', '15:00', 0, NULL, 0, 116, 1, 0, 'testvdpdf', NULL, 1, 2, 'nabila nabila', '2024-11-14 21:57:36', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49505, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(255, NULL, '2024-11-13', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(256, NULL, '2024-11-14', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, 'Utilisation d\'une Machine Virtuelle macOS sur PC :\nInstaller une machine virtuelle macOS sur mon PC pourrait me permettre d\'accéder à Xcode et de lancer l’émulateur iOS. Cependant, cela peut être assez exigeant en ressources et ne garantit pas toujours des performances optimales, notamment pour des tests en temps réel. De plus, la configuration de la VM nécessite une machine puissante et une gestion rigoureuse des deux environnements distincts (iOS et Android).', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(259, NULL, '2024-11-15', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(268, NULL, '2024-11-15', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(276, NULL, '2024-11-16', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(277, NULL, '2024-11-18', '16:03:01', 'Tunis', '09:00', '15:00', 0, NULL, 0, 423, 1, 0, 'testheeet', NULL, 1, 613, 'nabila TAGUEZ', '2024-11-18 16:30:13', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49516, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(278, NULL, '2024-11-16', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(279, NULL, '2024-11-18', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(283, NULL, '2024-11-19', '09:00', 'Tunis', '09:00', '15:00', 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '22:13:08', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(284, NULL, '2024-11-19', '10:00', 'Tunis', '09:00', '15:00', 0, NULL, 0, 60, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '15:00', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(285, NULL, '2024-11-19', '20:17:11', 'Tunis', '09:00', '15:00', 0, NULL, 0, 677, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '22:13:08', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(286, NULL, '2024-11-19', '20:18:50', 'Tunis', '09:00', '15:00', 0, NULL, 0, 678, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2024-11-19 22:13:08', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(287, NULL, '2024-11-19', '20:20:25', 'Tunis', '09:00', '15:00', 0, NULL, 0, 680, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2024-11-19 22:13:08', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(288, NULL, '2024-11-19', '20:22:15', 'Tunis', '09:00', '15:00', 0, NULL, 0, 682, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2024-11-19 22:13:08', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(289, NULL, '2024-11-19', '20:23:33', 'Tunis', '09:00', '15:00', 0, NULL, 0, 683, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2024-11-19 22:13:08', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(300, NULL, '2024-11-20', '20:25:07', 'Tunis', '09:00', '22:00', 0, NULL, 0, 685, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '21:25:49', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(301, NULL, '2024-11-19', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(302, NULL, '2024-11-20', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, '', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49610, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(303, NULL, '2024-11-21', '13:52:13', 'Tunis', '09:00', '18:00', 0, NULL, 0, 292, 1, 0, 'Jjj', 'bonj2', 1, 613, 'nabila TAGUEZ', '2024-11-22 10:10:50', 'Refusé', '17:52:50', 0, 0, 613, 'nabila TAGUEZ', '2024-11-25 11:34:55', 'Accepté', NULL, NULL, 0, 609, 49658, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(304, NULL, '2024-11-22', '09:18:50', 'Tunis', '09:00', '18:00', 0, NULL, 0, 18, 1, 0, '', 'bonjjDepart', 1, 609, 'Hamza DRIDI', '2024-11-26 12:19:22', 'Refusé', '11:21:22', 0, 0, 613, 'nabila TAGUEZ', '2024-11-27 03:09:15', 'Accepté', NULL, NULL, 0, 609, 49606, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(305, NULL, '2024-11-21', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, 'Hhhhkllskjz', 'Hjjj', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, 49662, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(313, NULL, '2024-11-22', '21:56:20', 'Tunis', '09:00', '15:00', 0, NULL, 0, 776, 1, 0, 'Ttt', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, 49641, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(316, NULL, '2024-11-23', '18:56:50', 'Tunis', '10:00', '20:00', 0, NULL, 0, 536, 1, 0, '', NULL, 1, 613, 'nabila TAGUEZ', '2024-11-27 02:39:06', 'Accepté', '18:57:17', 0, 1, 613, 'nabila TAGUEZ', '2024-11-27 02:52:49', 'Refusé', NULL, NULL, 0, 613, 49637, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(317, NULL, '2024-11-23', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, 'thte', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49663, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(319, NULL, '2024-11-25', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, 'Ww', 'frfrf', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49666, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(320, NULL, '2024-11-26', '12:25:10', 'Tunis', '09:00', '15:00', 0, NULL, 0, 205, 1, 0, '', '', 1, 613, 'nabila TAGUEZ', '2024-11-26 20:11:16', 'Accepté', '14:52:14', 0, 1, 613, 'nabila TAGUEZ', '2024-11-25 22:11:34', 'Refusé', NULL, NULL, 0, 609, 49650, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(321, NULL, '2024-11-27', '15:15:27', 'Tunis', '09:00', '15:00', 0, NULL, 0, 375, 1, 0, 'Uuhhhyhjvcggj', 'test', 1, 613, 'nabila TAGUEZ', '2024-11-27 15:40:50', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49723, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(325, NULL, '2024-11-28', '15:32:47', 'Tunis', '09:00', '18:00', 0, NULL, 0, 392, 1, 0, '33333333333333', '', 0, NULL, NULL, NULL, NULL, '15:40:29', 0, 1, 613, 'nabila TAGUEZ', '2024-11-28 16:13:47', 'Accepté', NULL, NULL, 0, 609, 49772, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(326, NULL, '2024-11-07', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(327, NULL, '2024-11-08', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(328, NULL, '2024-11-09', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(329, NULL, '2024-11-11', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(330, NULL, '2024-11-12', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(331, NULL, '2024-11-13', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(332, NULL, '2024-11-14', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(333, NULL, '2024-11-15', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(334, NULL, '2024-11-16', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(335, NULL, '2024-11-18', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(336, NULL, '2024-11-19', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(337, NULL, '2024-11-20', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(338, NULL, '2024-11-21', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(339, NULL, '2024-11-22', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(340, NULL, '2024-11-23', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(341, NULL, '2024-11-25', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(342, NULL, '2024-11-26', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(343, NULL, '2024-11-27', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(344, NULL, '2024-11-28', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(345, NULL, '2024-11-29', '09:28:21', 'Tunis', '09:00', '15:00', 0, NULL, 0, 28, 1, 0, 'le but fait un retrad de 10 min\n\n', 'des photos du document du bureau d\'emploi', 0, NULL, NULL, NULL, NULL, '09:46:05', 0, 0, 613, 'nabila TAGUEZ', '2024-11-29 09:52:12', 'Accepté', NULL, NULL, 0, 611, 49728, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(346, NULL, '2024-11-29', '10:42:11', 'Tunis', '09:00', '18:00', 0, NULL, 0, 102, 1, 0, 'deeeedaae', 'teddzz', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, 49733, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(347, NULL, '2024-11-29', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'maladie', NULL, NULL),
(350, NULL, '2024-11-25', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(351, NULL, '2024-11-26', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(352, NULL, '2024-11-27', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(353, NULL, '2024-11-28', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(354, NULL, '2024-11-29', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(362, NULL, '2024-11-30', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(363, NULL, '2024-12-02', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, '', '', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49775, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(365, NULL, '2024-12-03', NULL, 'Tunis', NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(366, NULL, '2024-12-04', '10:53:21', 'Tunis', '09:00', '18:00', 0, NULL, 0, 113, 1, 0, 'retard bus', 'maladie', 0, NULL, NULL, NULL, NULL, '14:00:00', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(367, NULL, '2024-12-05', '11:36:25', 'Tunis', '09:00', '18:00', 0, NULL, 0, 156, 1, 0, 'fdvsv\n', 'Metro4', 0, NULL, NULL, NULL, NULL, '14:00', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49785, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(368, NULL, '2024-12-06', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370, NULL, '2024-12-06', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(371, NULL, '2024-12-06', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(372, NULL, '2024-12-06', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(373, NULL, '2024-12-06', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(374, NULL, '2024-12-06', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, 0, 1, 'k,nojp,njoh', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49786, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'undefined', NULL, NULL),
(394, NULL, '2024-12-07', NULL, NULL, '10:00', '14:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(395, NULL, '2024-12-07', NULL, NULL, '10:00', '14:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(396, NULL, '2024-12-07', NULL, NULL, '10:00', '14:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(397, NULL, '2024-12-07', NULL, NULL, '10:00', '14:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(398, NULL, '2024-12-07', NULL, NULL, '10:00', '20:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-14 14:42:14', 'Refusé', NULL, NULL, NULL),
(399, NULL, '2024-12-07', NULL, NULL, '10:00', '18:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(401, NULL, '2024-12-08', NULL, NULL, '10:00', '14:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(402, NULL, '2024-12-08', NULL, NULL, '10:00', '14:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(416, NULL, '2024-12-09', NULL, NULL, '09:00', '15:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(417, NULL, '2024-12-09', NULL, NULL, '09:00', '15:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(418, NULL, '2024-12-09', '09:20:00', NULL, '09:00', '18:00', 0, NULL, 0, 20, 1, 0, 'bonjour ,je suis vraiment dsol pour ce retard c a cause d\'un probleme dans la maison', NULL, 1, 613, 'nabila TAGUEZ', '2024-12-09 21:13:25', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49787, NULL, 'Définitif', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(419, NULL, '2024-12-09', NULL, NULL, '09:00', '15:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(420, NULL, '2024-12-09', NULL, NULL, '09:00', '15:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(421, NULL, '2024-12-09', NULL, NULL, '09:00', '18:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(428, NULL, '2024-12-10', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(429, NULL, '2024-12-10', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(430, NULL, '2024-12-10', '09:30', 'TUNIS', '09:00', '15:00', 0, NULL, 0, 30, 1, 0, 'nkln', NULL, 1, 613, 'nabila TAGUEZ', '2024-12-10 15:21:44', 'Refusé', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, '', 'njjjjjjjjjjjjjjj', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(431, NULL, '2024-12-10', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(432, NULL, '2024-12-10', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(433, NULL, '2024-12-10', NULL, 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(458, NULL, '2024-12-11', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(459, NULL, '2024-12-11', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wbcc_pointage` (`idPointage`, `numeroPointage`, `datePointage`, `heureDebutPointage`, `adressePointage`, `heureDebutJour`, `heureFinJour`, `marge`, `adresseProgramme`, `anomalieDebutJour`, `nbMinuteRetard`, `retard`, `absent`, `motifRetard`, `motifRetardDepart`, `traite`, `idTraiteF`, `auteurTraite`, `dateTraite`, `resultatTraite`, `heureFinPointage`, `nbMinuteDepart`, `traiteDepart`, `idTraiteDepartF`, `auteurTraiteDepart`, `dateTraiteDepart`, `resultatTraiteDepart`, `adresseFinPointage`, `adresseProgrammeFin`, `anomalieFinJour`, `idUserF`, `idDocumentF`, `auteur`, `typeTraite`, `raisonRejet`, `typeTraiteDepart`, `raisonRejetDepart`, `traiteAbsent`, `idTraiteAbsentF`, `auteurTraiteAbsent`, `dateTraiteAbsent`, `resultatTraiteAbsent`, `motifAbsent`, `typeTraiteAbsent`, `raisonRejetAbsence`) VALUES
(460, NULL, '2024-12-11', NULL, 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(461, NULL, '2024-12-11', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(462, NULL, '2024-12-11', NULL, 'TUNIS', '09:00', '22:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '10:31:02', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(463, NULL, '2024-12-11', NULL, 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(469, NULL, '2024-12-12', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(470, NULL, '2024-12-12', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(472, NULL, '2024-12-12', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 0, 0, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-08 14:53:39', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(473, NULL, '2024-12-12', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(474, NULL, '2024-12-12', NULL, 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(478, NULL, '2024-12-12', '23:58:02', 'TUNIS', '09:00', '18:00', 0, NULL, 0, 898, 1, 1, 'vwc cvcbcd', NULL, 0, NULL, NULL, NULL, NULL, '23:59:00', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-08 14:54:35', 'Accepté', NULL, NULL, NULL),
(479, NULL, '2024-12-13', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(480, NULL, '2024-12-13', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(481, NULL, '2024-12-13', '09:24:25', 'TUNIS', '09:00', '18:00', 0, NULL, 0, 24, 1, 0, 'new test', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(482, NULL, '2024-12-13', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(483, NULL, '2024-12-13', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(484, NULL, '2024-12-13', NULL, 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(485, NULL, '2024-12-14', NULL, 'PARIS', '10:00', '14:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, 49829, NULL, NULL, NULL, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-08 12:30:10', 'Accepté', 'maladie', NULL, NULL),
(486, NULL, '2024-12-14', NULL, 'PARIS', '10:00', '14:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(487, NULL, '2024-12-14', NULL, 'TUNIS', '10:00', '14:00', 0, NULL, 0, 0, 0, 1, 'vbn v', NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49808, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'eeeeeeeeeeeeeeee', NULL, NULL),
(488, NULL, '2024-12-14', NULL, 'TUNIS', '10:00', '14:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(489, NULL, '2024-12-14', NULL, 'TUNIS', '10:00', '20:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(490, NULL, '2024-12-14', NULL, 'TUNIS', '10:00', '18:00', 0, NULL, 0, 0, 0, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(491, NULL, '2024-12-16', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(492, NULL, '2024-12-16', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(493, NULL, '2024-12-16', '11:15:51', 'TUNIS', '09:00', '18:00', 0, NULL, 0, 135, 1, 0, 'retard bus', NULL, 1, 1, 'Jawher BALTI', '2025-01-08 14:56:06', 'Accepté', '20:29:12', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49815, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(494, NULL, '2024-12-16', '17:16:12', 'TUNIS', '09:00', '15:00', 0, NULL, 0, 496, 1, 0, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-08 14:57:30', 'Accepté', '17:22:58', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(495, NULL, '2024-12-16', '17:23:07', 'TUNIS', '09:00', '15:00', 0, NULL, 0, 503, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '17:23:39', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(496, NULL, '2024-12-16', '17:23:44', 'TUNIS', '09:00', '18:00', 0, NULL, 0, 503, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '20:28:54', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(503, NULL, '2024-12-17', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(504, NULL, '2024-12-17', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(505, NULL, '2024-12-17', '17:10:44', 'TUNIS', '09:00', '18:00', 0, NULL, 0, 490, 1, 0, '', 'maladie', 0, NULL, NULL, NULL, NULL, '17:10:59', 130, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49810, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(506, NULL, '2024-12-17', '17:10:50', 'TUNIS', '09:00', '18:00', 0, NULL, 0, 490, 1, 0, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-14 13:46:55', 'Accepté', '17:11:17', 131, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(507, NULL, '2024-12-17', '18:18:43', 'TUNIS', '09:00', '15:00', 0, NULL, 0, 558, 1, 0, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-09 16:31:42', 'Refusé', '18:18:51', 198, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(508, NULL, '2024-12-17', NULL, 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(509, NULL, '2024-12-18', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(510, NULL, '2024-12-18', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(511, NULL, '2024-12-18', '09:29:28', 'TUNIS', '09:00', '18:00', 0, NULL, 0, 29, 1, 0, 'undefined', 'wxcwxc', 1, 613, 'nabila TAGUEZ', '2024-12-18 17:57:05', 'Refusé', '10:24:48', 455, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, 49822, NULL, '', 'FGBFGG', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(512, NULL, '2024-12-18', '16:31:47', 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-09 16:31:14', 'Refusé', '16:31:52', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(513, NULL, '2024-12-18', NULL, 'TUNIS', '09:00', '22:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(514, NULL, '2024-12-18', '01:57:48', 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 0, 0, NULL, 'test', 0, NULL, NULL, NULL, NULL, '01:58:14', 961, 1, 1, 'Jawher BALTI', '2025-01-08 14:42:46', 'Accepté', NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(515, NULL, '2024-12-19', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-08 14:55:05', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(516, NULL, '2024-12-19', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(517, NULL, '2024-12-19', '15:07:25', 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 1, 0, 'retard bus', 'maladie', 1, 1, 'Jawher BALTI', '2025-01-08 14:55:56', 'Accepté', '15:15:45', 164, 1, 1, 'Jawher BALTI', '2025-01-08 14:55:36', 'Accepté', NULL, NULL, 0, 609, 49824, NULL, 'Définitif', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(518, NULL, '2024-12-19', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(519, NULL, '2024-12-19', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(520, NULL, '2024-12-19', NULL, 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(521, NULL, '2024-12-20', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 1, 1, 'Jawher BALTI', '2025-01-09 16:30:39', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(522, NULL, '2024-12-20', NULL, 'PARIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 605, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(524, NULL, '2024-12-20', NULL, 'TUNIS', '11:30', '15:00', 0, NULL, 0, 182, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 611, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(525, NULL, '2024-12-20', NULL, 'TUNIS', '09:00', '15:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 613, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(526, NULL, '2024-12-20', NULL, 'TUNIS', '09:00', '18:00', 0, NULL, 0, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 614, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(530, NULL, '2024-12-20', '12:35:40', 'Tunis', NULL, NULL, 0, NULL, 0, 0, 1, 0, 'qsdqsd', NULL, 1, 1, 'Jawher BALTI', '2025-01-08 14:54:55', 'Accepté', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 609, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(26, 'qs', 'df', '2024-12-19 14:17:07', 2456, NULL),
(27, 'aze', 'qsd', '2024-12-19 14:27:22', 2456, NULL),
(28, 'aze', 'qsd', '2024-12-19 14:38:52', NULL, 1),
(29, 'sdfgsd', 'sdfsdf', '2024-12-19 14:54:50', 2456, NULL),
(30, 'aaaa', 'vdfsd', '2024-12-19 14:57:46', 1, NULL),
(31, NULL, NULL, '2024-12-19 14:58:08', NULL, NULL),
(32, 'bbbbb', 'sdfsdfsd', '2024-12-19 14:58:24', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_roles`
--

CREATE TABLE `wbcc_roles` (
  `idRole` int(11) NOT NULL,
  `libelleRole` varchar(200) NOT NULL,
  `etatRole` tinyint(1) NOT NULL DEFAULT 1,
  `accessibilite` text NOT NULL,
  `visibleInscription` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_roles`
--

INSERT INTO `wbcc_roles` (`idRole`, `libelleRole`, `etatRole`, `accessibilite`, `visibleInscription`) VALUES
(1, 'Administrateur', 1, '1;2;', 0),
(2, 'Manager', 1, '', 0),
(3, 'Gestionnaire', 1, '', 0),
(4, 'Expert', 1, '', 0),
(5, 'Commercial', 1, '', 0),
(6, 'Artisan', 1, '', 0),
(7, 'RH', 1, '', 0),
(8, 'Assistant de Direction', 1, '', 0),
(9, 'Comptable', 1, '', 0),
(10, 'Informaticien', 1, '', 0),
(11, 'Test', 1, '', 0),
(12, 'Télé-Opérateur', 1, '', 0),
(13, 'Dirigeant', 1, '', 0),
(14, 'Responsable', 1, '', 0),
(15, 'Salarie', 1, '', 0),
(16, 'Particulier', 1, '', 0),
(17, 'En attente de validation', 1, '', 0),
(18, 'Responsable Technique', 1, '', 0),
(19, 'RHSR', 1, '', 0),
(20, 'Apporteur d\'Affaires', 1, '', 0),
(21, 'Occupant', 1, '', 0),
(22, 'Coproprietaire', 1, '', 0),
(23, 'Candidat Artisan', 1, '', 1),
(24, 'Candidat Commercial', 1, '', 1),
(25, 'Manager de Site', 1, '', 0),
(33, 'PRESENCE', 1, '', 0),
(34, 'Pointage', 1, '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_role_sous_module`
--

CREATE TABLE `wbcc_role_sous_module` (
  `idRoleSousModule` int(11) NOT NULL,
  `numeroRoleSousModule` varchar(50) NOT NULL,
  `idRoleF` int(11) NOT NULL,
  `idSousModuleF` int(11) NOT NULL,
  `etatRoleSousModule` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_role_sous_module`
--

INSERT INTO `wbcc_role_sous_module` (`idRoleSousModule`, `numeroRoleSousModule`, `idRoleF`, `idSousModuleF`, `etatRoleSousModule`) VALUES
(1, '', 1, 1, 1),
(2, '', 1, 2, 1),
(3, '', 1, 3, 1),
(4, '', 1, 4, 1),
(5, '', 1, 5, 1),
(6, '', 1, 6, 1),
(7, '', 1, 7, 1),
(8, '', 1, 8, 1),
(9, '', 1, 9, 1),
(10, '', 1, 10, 1),
(11, '', 1, 11, 1),
(12, '', 1, 12, 1),
(13, '', 1, 13, 1),
(14, '', 1, 14, 1),
(15, '', 1, 15, 1),
(16, '', 1, 16, 1),
(17, '', 1, 17, 1),
(18, '', 1, 18, 1),
(19, '', 1, 19, 1),
(20, '', 1, 20, 1),
(21, '', 1, 21, 1),
(22, '', 1, 22, 1),
(23, '', 1, 23, 1),
(24, '', 1, 24, 1),
(25, '', 1, 25, 1),
(26, '', 1, 26, 1),
(27, '', 1, 27, 0),
(28, '', 1, 28, 0),
(29, '', 1, 29, 0),
(30, '', 1, 30, 0),
(31, '', 1, 31, 0),
(32, '', 1, 32, 0),
(33, '', 1, 33, 0),
(34, '', 1, 34, 0),
(35, '', 1, 35, 0),
(36, '', 1, 36, 0),
(37, '', 1, 37, 0),
(38, '', 1, 38, 1),
(39, '', 1, 39, 0),
(40, '', 1, 40, 0),
(41, '', 2, 1, 1),
(42, '', 2, 2, 1),
(43, '', 2, 3, 1),
(44, '', 2, 4, 1),
(45, '', 2, 5, 1),
(46, '', 2, 6, 1),
(47, '', 2, 7, 1),
(48, '', 2, 8, 1),
(49, '', 2, 9, 1),
(50, '', 2, 10, 1),
(51, '', 2, 11, 1),
(52, '', 2, 12, 1),
(53, '', 2, 13, 1),
(54, '', 2, 14, 1),
(55, '', 2, 15, 1),
(56, '', 2, 16, 1),
(57, '', 2, 17, 1),
(58, '', 2, 18, 1),
(59, '', 2, 19, 1),
(60, '', 2, 20, 1),
(61, '', 2, 21, 1),
(62, '', 2, 22, 1),
(63, '', 2, 23, 1),
(64, '', 2, 24, 1),
(65, '', 2, 25, 1),
(66, '', 2, 26, 1),
(67, '', 2, 27, 0),
(68, '', 2, 28, 0),
(69, '', 2, 29, 0),
(70, '', 2, 30, 0),
(71, '', 2, 31, 0),
(72, '', 2, 32, 0),
(73, '', 2, 33, 0),
(74, '', 2, 34, 0),
(75, '', 2, 35, 0),
(76, '', 2, 36, 0),
(77, '', 2, 37, 0),
(78, '', 2, 38, 1),
(79, '', 2, 39, 0),
(80, '', 2, 40, 0),
(81, '', 3, 1, 1),
(82, '', 3, 2, 1),
(83, '', 3, 3, 1),
(84, '', 3, 4, 1),
(85, '', 3, 5, 1),
(86, '', 3, 6, 1),
(87, '', 3, 7, 1),
(88, '', 3, 8, 1),
(89, '', 3, 9, 1),
(90, '', 3, 10, 1),
(91, '', 3, 11, 0),
(92, '', 3, 12, 0),
(93, '', 3, 13, 0),
(94, '', 3, 14, 0),
(95, '', 3, 15, 0),
(96, '', 3, 16, 1),
(97, '', 3, 17, 1),
(98, '', 3, 18, 1),
(99, '', 3, 19, 0),
(100, '', 3, 20, 0),
(101, '', 3, 21, 0),
(102, '', 3, 22, 0),
(103, '', 3, 23, 1),
(104, '', 3, 24, 0),
(105, '', 3, 25, 0),
(106, '', 3, 26, 0),
(107, '', 3, 27, 0),
(108, '', 3, 28, 0),
(109, '', 3, 29, 0),
(110, '', 3, 30, 0),
(111, '', 3, 31, 0),
(112, '', 3, 32, 0),
(113, '', 3, 33, 0),
(114, '', 3, 34, 0),
(115, '', 3, 35, 0),
(116, '', 3, 36, 0),
(117, '', 3, 37, 0),
(118, '', 3, 38, 0),
(119, '', 3, 39, 0),
(120, '', 3, 40, 0),
(121, '', 4, 1, 1),
(122, '', 4, 2, 1),
(123, '', 4, 3, 1),
(124, '', 4, 4, 1),
(125, '', 4, 5, 0),
(126, '', 4, 6, 0),
(127, '', 4, 7, 0),
(128, '', 4, 8, 0),
(129, '', 4, 9, 0),
(130, '', 4, 10, 0),
(131, '', 4, 11, 0),
(132, '', 4, 12, 0),
(133, '', 4, 13, 0),
(134, '', 4, 14, 0),
(135, '', 4, 15, 0),
(136, '', 4, 16, 0),
(137, '', 4, 17, 1),
(138, '', 4, 18, 0),
(139, '', 4, 19, 0),
(140, '', 4, 20, 0),
(141, '', 4, 21, 0),
(142, '', 4, 22, 0),
(143, '', 4, 23, 0),
(144, '', 4, 24, 0),
(145, '', 4, 25, 0),
(146, '', 4, 26, 0),
(147, '', 4, 27, 0),
(148, '', 4, 28, 0),
(149, '', 4, 29, 0),
(150, '', 4, 30, 0),
(151, '', 4, 31, 0),
(152, '', 4, 32, 0),
(153, '', 4, 33, 0),
(154, '', 4, 34, 0),
(155, '', 4, 35, 0),
(156, '', 4, 36, 0),
(157, '', 4, 37, 0),
(158, '', 4, 38, 0),
(159, '', 4, 39, 0),
(160, '', 4, 40, 0),
(161, '', 5, 1, 1),
(162, '', 5, 2, 1),
(163, '', 5, 3, 1),
(164, '', 5, 4, 1),
(165, '', 5, 5, 0),
(166, '', 5, 6, 0),
(167, '', 5, 7, 1),
(168, '', 5, 8, 1),
(169, '', 5, 9, 1),
(170, '', 5, 10, 1),
(171, '', 5, 11, 0),
(172, '', 5, 12, 0),
(173, '', 5, 13, 0),
(174, '', 5, 14, 0),
(175, '', 5, 15, 0),
(176, '', 5, 16, 0),
(177, '', 5, 17, 1),
(178, '', 5, 18, 1),
(179, '', 5, 19, 1),
(180, '', 5, 20, 0),
(181, '', 5, 21, 0),
(182, '', 5, 22, 0),
(183, '', 5, 23, 0),
(184, '', 5, 24, 0),
(185, '', 5, 25, 0),
(186, '', 5, 26, 0),
(187, '', 5, 27, 0),
(188, '', 5, 28, 0),
(189, '', 5, 29, 0),
(190, '', 5, 30, 0),
(191, '', 5, 31, 0),
(192, '', 5, 32, 0),
(193, '', 5, 33, 0),
(194, '', 5, 34, 0),
(195, '', 5, 35, 0),
(196, '', 5, 36, 0),
(197, '', 5, 37, 0),
(198, '', 5, 38, 0),
(199, '', 5, 39, 0),
(200, '', 5, 40, 0),
(201, '', 6, 1, 0),
(202, '', 6, 2, 0),
(203, '', 6, 3, 0),
(204, '', 6, 4, 0),
(205, '', 6, 5, 0),
(206, '', 6, 6, 0),
(207, '', 6, 7, 0),
(208, '', 6, 8, 0),
(209, '', 6, 9, 0),
(210, '', 6, 10, 0),
(211, '', 6, 11, 0),
(212, '', 6, 12, 0),
(213, '', 6, 13, 0),
(214, '', 6, 14, 0),
(215, '', 6, 15, 0),
(216, '', 6, 16, 0),
(217, '', 6, 17, 0),
(218, '', 6, 18, 1),
(219, '', 6, 19, 0),
(220, '', 6, 20, 0),
(221, '', 6, 21, 0),
(222, '', 6, 22, 0),
(223, '', 6, 23, 0),
(224, '', 6, 24, 0),
(225, '', 6, 25, 0),
(226, '', 6, 26, 0),
(227, '', 6, 27, 0),
(228, '', 6, 28, 0),
(229, '', 6, 29, 0),
(230, '', 6, 30, 0),
(231, '', 6, 31, 0),
(232, '', 6, 32, 0),
(233, '', 6, 33, 0),
(234, '', 6, 34, 0),
(235, '', 6, 35, 0),
(236, '', 6, 36, 0),
(237, '', 6, 37, 0),
(238, '', 6, 38, 0),
(239, '', 6, 39, 1),
(240, '', 6, 40, 0),
(241, '', 7, 1, 0),
(242, '', 7, 2, 0),
(243, '', 7, 3, 0),
(244, '', 7, 4, 0),
(245, '', 7, 5, 0),
(246, '', 7, 6, 0),
(247, '', 7, 7, 0),
(248, '', 7, 8, 0),
(249, '', 7, 9, 0),
(250, '', 7, 10, 0),
(251, '', 7, 11, 0),
(252, '', 7, 12, 0),
(253, '', 7, 13, 0),
(254, '', 7, 14, 0),
(255, '', 7, 15, 1),
(256, '', 7, 16, 1),
(257, '', 7, 17, 0),
(258, '', 7, 18, 0),
(259, '', 7, 19, 0),
(260, '', 7, 20, 0),
(261, '', 7, 21, 0),
(262, '', 7, 22, 0),
(263, '', 7, 23, 0),
(264, '', 7, 24, 0),
(265, '', 7, 25, 0),
(266, '', 7, 26, 0),
(267, '', 7, 27, 0),
(268, '', 7, 28, 0),
(269, '', 7, 29, 0),
(270, '', 7, 30, 0),
(271, '', 7, 31, 0),
(272, '', 7, 32, 0),
(273, '', 7, 33, 0),
(274, '', 7, 34, 0),
(275, '', 7, 35, 0),
(276, '', 7, 36, 0),
(277, '', 7, 37, 0),
(278, '', 7, 38, 0),
(279, '', 7, 39, 0),
(280, '', 7, 40, 0),
(281, '', 8, 1, 1),
(282, '', 8, 2, 1),
(283, '', 8, 3, 1),
(284, '', 8, 4, 1),
(285, '', 8, 5, 1),
(286, '', 8, 6, 1),
(287, '', 8, 7, 1),
(288, '', 8, 8, 1),
(289, '', 8, 9, 1),
(290, '', 8, 10, 1),
(291, '', 8, 11, 1),
(292, '', 8, 12, 0),
(293, '', 8, 13, 1),
(294, '', 8, 14, 0),
(295, '', 8, 15, 1),
(296, '', 8, 16, 0),
(297, '', 8, 17, 1),
(298, '', 8, 18, 1),
(299, '', 8, 19, 1),
(300, '', 8, 20, 1),
(301, '', 8, 21, 1),
(302, '', 8, 22, 1),
(303, '', 8, 23, 1),
(304, '', 8, 24, 1),
(305, '', 8, 25, 1),
(306, '', 8, 26, 1),
(307, '', 8, 27, 0),
(308, '', 8, 28, 0),
(309, '', 8, 29, 0),
(310, '', 8, 30, 0),
(311, '', 8, 31, 0),
(312, '', 8, 32, 0),
(313, '', 8, 33, 0),
(314, '', 8, 34, 0),
(315, '', 8, 35, 1),
(316, '', 8, 36, 0),
(317, '', 8, 37, 0),
(318, '', 8, 38, 0),
(319, '', 8, 39, 0),
(320, '', 8, 40, 0),
(321, '', 9, 1, 1),
(322, '', 9, 2, 0),
(323, '', 9, 3, 0),
(324, '', 9, 4, 0),
(325, '', 9, 5, 0),
(326, '', 9, 6, 0),
(327, '', 9, 7, 0),
(328, '', 9, 8, 0),
(329, '', 9, 9, 0),
(330, '', 9, 10, 0),
(331, '', 9, 11, 0),
(332, '', 9, 12, 0),
(333, '', 9, 13, 0),
(334, '', 9, 14, 0),
(335, '', 9, 15, 0),
(336, '', 9, 16, 0),
(337, '', 9, 17, 0),
(338, '', 9, 18, 0),
(339, '', 9, 19, 0),
(340, '', 9, 20, 0),
(341, '', 9, 21, 0),
(342, '', 9, 22, 1),
(343, '', 9, 23, 1),
(344, '', 9, 24, 1),
(345, '', 9, 25, 1),
(346, '', 9, 26, 1),
(347, '', 9, 27, 0),
(348, '', 9, 28, 0),
(349, '', 9, 29, 0),
(350, '', 9, 30, 0),
(351, '', 9, 31, 0),
(352, '', 9, 32, 0),
(353, '', 9, 33, 0),
(354, '', 9, 34, 0),
(355, '', 9, 35, 0),
(356, '', 9, 36, 0),
(357, '', 9, 37, 0),
(358, '', 9, 38, 0),
(359, '', 9, 39, 0),
(360, '', 9, 40, 0),
(361, '', 10, 1, 0),
(362, '', 10, 2, 0),
(363, '', 10, 3, 0),
(364, '', 10, 4, 0),
(365, '', 10, 5, 0),
(366, '', 10, 6, 0),
(367, '', 10, 7, 0),
(368, '', 10, 8, 0),
(369, '', 10, 9, 0),
(370, '', 10, 10, 0),
(371, '', 10, 11, 0),
(372, '', 10, 12, 0),
(373, '', 10, 13, 0),
(374, '', 10, 14, 0),
(375, '', 10, 15, 0),
(376, '', 10, 16, 0),
(377, '', 10, 17, 0),
(378, '', 10, 18, 0),
(379, '', 10, 19, 0),
(380, '', 10, 20, 0),
(381, '', 10, 21, 0),
(382, '', 10, 22, 0),
(383, '', 10, 23, 0),
(384, '', 10, 24, 0),
(385, '', 10, 25, 0),
(386, '', 10, 26, 0),
(387, '', 10, 27, 0),
(388, '', 10, 28, 0),
(389, '', 10, 29, 0),
(390, '', 10, 30, 0),
(391, '', 10, 31, 0),
(392, '', 10, 32, 0),
(393, '', 10, 33, 0),
(394, '', 10, 34, 0),
(395, '', 10, 35, 0),
(396, '', 10, 36, 0),
(397, '', 10, 37, 0),
(398, '', 10, 38, 0),
(399, '', 10, 39, 0),
(400, '', 10, 40, 0),
(401, '', 11, 1, 0),
(402, '', 11, 2, 0),
(403, '', 11, 3, 0),
(404, '', 11, 4, 0),
(405, '', 11, 5, 0),
(406, '', 11, 6, 0),
(407, '', 11, 7, 0),
(408, '', 11, 8, 0),
(409, '', 11, 9, 0),
(410, '', 11, 10, 0),
(411, '', 11, 11, 0),
(412, '', 11, 12, 0),
(413, '', 11, 13, 0),
(414, '', 11, 14, 0),
(415, '', 11, 15, 0),
(416, '', 11, 16, 0),
(417, '', 11, 17, 0),
(418, '', 11, 18, 0),
(419, '', 11, 19, 0),
(420, '', 11, 20, 0),
(421, '', 11, 21, 0),
(422, '', 11, 22, 0),
(423, '', 11, 23, 0),
(424, '', 11, 24, 0),
(425, '', 11, 25, 0),
(426, '', 11, 26, 0),
(427, '', 11, 27, 0),
(428, '', 11, 28, 0),
(429, '', 11, 29, 0),
(430, '', 11, 30, 0),
(431, '', 11, 31, 0),
(432, '', 11, 32, 0),
(433, '', 11, 33, 0),
(434, '', 11, 34, 0),
(435, '', 11, 35, 0),
(436, '', 11, 36, 0),
(437, '', 11, 37, 0),
(438, '', 11, 38, 0),
(439, '', 11, 39, 0),
(440, '', 11, 40, 0),
(441, '', 12, 1, 0),
(442, '', 12, 2, 0),
(443, '', 12, 3, 0),
(444, '', 12, 4, 0),
(445, '', 12, 5, 0),
(446, '', 12, 6, 0),
(447, '', 12, 7, 0),
(448, '', 12, 8, 0),
(449, '', 12, 9, 0),
(450, '', 12, 10, 0),
(451, '', 12, 11, 0),
(452, '', 12, 12, 0),
(453, '', 12, 13, 0),
(454, '', 12, 14, 0),
(455, '', 12, 15, 0),
(456, '', 12, 16, 0),
(457, '', 12, 17, 0),
(458, '', 12, 18, 0),
(459, '', 12, 19, 0),
(460, '', 12, 20, 0),
(461, '', 12, 21, 0),
(462, '', 12, 22, 0),
(463, '', 12, 23, 0),
(464, '', 12, 24, 0),
(465, '', 12, 25, 0),
(466, '', 12, 26, 0),
(467, '', 12, 27, 0),
(468, '', 12, 28, 0),
(469, '', 12, 29, 0),
(470, '', 12, 30, 0),
(471, '', 12, 31, 0),
(472, '', 12, 32, 0),
(473, '', 12, 33, 0),
(474, '', 12, 34, 0),
(475, '', 12, 35, 0),
(476, '', 12, 36, 0),
(477, '', 12, 37, 0),
(478, '', 12, 38, 0),
(479, '', 12, 39, 0),
(480, '', 12, 40, 0),
(481, '', 13, 1, 0),
(482, '', 13, 2, 0),
(483, '', 13, 3, 0),
(484, '', 13, 4, 0),
(485, '', 13, 5, 0),
(486, '', 13, 6, 0),
(487, '', 13, 7, 0),
(488, '', 13, 8, 0),
(489, '', 13, 9, 0),
(490, '', 13, 10, 0),
(491, '', 13, 11, 0),
(492, '', 13, 12, 0),
(493, '', 13, 13, 0),
(494, '', 13, 14, 0),
(495, '', 13, 15, 0),
(496, '', 13, 16, 0),
(497, '', 13, 17, 0),
(498, '', 13, 18, 1),
(499, '', 13, 19, 0),
(500, '', 13, 20, 0),
(501, '', 13, 21, 0),
(502, '', 13, 22, 0),
(503, '', 13, 23, 0),
(504, '', 13, 24, 0),
(505, '', 13, 25, 0),
(506, '', 13, 26, 0),
(507, '', 13, 27, 0),
(508, '', 13, 28, 0),
(509, '', 13, 29, 0),
(510, '', 13, 30, 0),
(511, '', 13, 31, 0),
(512, '', 13, 32, 1),
(513, '', 13, 33, 1),
(514, '', 13, 34, 1),
(515, '', 13, 35, 0),
(516, '', 13, 36, 1),
(517, '', 13, 37, 1),
(518, '', 13, 38, 0),
(519, '', 13, 39, 1),
(520, '', 13, 40, 1),
(521, '', 14, 1, 0),
(522, '', 14, 2, 0),
(523, '', 14, 3, 0),
(524, '', 14, 4, 0),
(525, '', 14, 5, 0),
(526, '', 14, 6, 0),
(527, '', 14, 7, 0),
(528, '', 14, 8, 0),
(529, '', 14, 9, 0),
(530, '', 14, 10, 0),
(531, '', 14, 11, 0),
(532, '', 14, 12, 0),
(533, '', 14, 13, 0),
(534, '', 14, 14, 0),
(535, '', 14, 15, 0),
(536, '', 14, 16, 0),
(537, '', 14, 17, 0),
(538, '', 14, 18, 1),
(539, '', 14, 19, 0),
(540, '', 14, 20, 0),
(541, '', 14, 21, 0),
(542, '', 14, 22, 0),
(543, '', 14, 23, 0),
(544, '', 14, 24, 0),
(545, '', 14, 25, 0),
(546, '', 14, 26, 0),
(547, '', 14, 27, 0),
(548, '', 14, 28, 0),
(549, '', 14, 29, 0),
(550, '', 14, 30, 0),
(551, '', 14, 31, 0),
(552, '', 14, 32, 1),
(553, '', 14, 33, 1),
(554, '', 14, 34, 1),
(555, '', 14, 35, 0),
(556, '', 14, 36, 1),
(557, '', 14, 37, 1),
(558, '', 14, 38, 0),
(559, '', 14, 39, 1),
(560, '', 14, 40, 1),
(561, '', 15, 1, 0),
(562, '', 15, 2, 0),
(563, '', 15, 3, 0),
(564, '', 15, 4, 0),
(565, '', 15, 5, 0),
(566, '', 15, 6, 0),
(567, '', 15, 7, 0),
(568, '', 15, 8, 0),
(569, '', 15, 9, 0),
(570, '', 15, 10, 0),
(571, '', 15, 11, 0),
(572, '', 15, 12, 0),
(573, '', 15, 13, 0),
(574, '', 15, 14, 0),
(575, '', 15, 15, 0),
(576, '', 15, 16, 0),
(577, '', 15, 17, 0),
(578, '', 15, 18, 1),
(579, '', 15, 19, 0),
(580, '', 15, 20, 0),
(581, '', 15, 21, 0),
(582, '', 15, 22, 0),
(583, '', 15, 23, 0),
(584, '', 15, 24, 0),
(585, '', 15, 25, 0),
(586, '', 15, 26, 0),
(587, '', 15, 27, 0),
(588, '', 15, 28, 0),
(589, '', 15, 29, 0),
(590, '', 15, 30, 0),
(591, '', 15, 31, 0),
(592, '', 15, 32, 1),
(593, '', 15, 33, 1),
(594, '', 15, 34, 1),
(595, '', 15, 35, 0),
(596, '', 15, 36, 1),
(597, '', 15, 37, 0),
(598, '', 15, 38, 0),
(599, '', 15, 39, 1),
(600, '', 15, 40, 0),
(601, '', 16, 1, 0),
(602, '', 16, 2, 0),
(603, '', 16, 3, 0),
(604, '', 16, 4, 0),
(605, '', 16, 5, 0),
(606, '', 16, 6, 0),
(607, '', 16, 7, 0),
(608, '', 16, 8, 0),
(609, '', 16, 9, 0),
(610, '', 16, 10, 0),
(611, '', 16, 11, 0),
(612, '', 16, 12, 0),
(613, '', 16, 13, 0),
(614, '', 16, 14, 0),
(615, '', 16, 15, 0),
(616, '', 16, 16, 0),
(617, '', 16, 17, 0),
(618, '', 16, 18, 0),
(619, '', 16, 19, 0),
(620, '', 16, 20, 0),
(621, '', 16, 21, 0),
(622, '', 16, 22, 0),
(623, '', 16, 23, 0),
(624, '', 16, 24, 0),
(625, '', 16, 25, 0),
(626, '', 16, 26, 0),
(627, '', 16, 27, 0),
(628, '', 16, 28, 0),
(629, '', 16, 29, 0),
(630, '', 16, 30, 1),
(631, '', 16, 31, 1),
(632, '', 16, 32, 0),
(633, '', 16, 33, 0),
(634, '', 16, 34, 0),
(635, '', 16, 35, 0),
(636, '', 16, 36, 0),
(637, '', 16, 37, 0),
(638, '', 16, 38, 0),
(639, '', 16, 39, 0),
(640, '', 16, 40, 0),
(641, '', 17, 1, 0),
(642, '', 17, 2, 0),
(643, '', 17, 3, 0),
(644, '', 17, 4, 0),
(645, '', 17, 5, 0),
(646, '', 17, 6, 0),
(647, '', 17, 7, 0),
(648, '', 17, 8, 0),
(649, '', 17, 9, 0),
(650, '', 17, 10, 0),
(651, '', 17, 11, 0),
(652, '', 17, 12, 0),
(653, '', 17, 13, 0),
(654, '', 17, 14, 0),
(655, '', 17, 15, 0),
(656, '', 17, 16, 0),
(657, '', 17, 17, 0),
(658, '', 17, 18, 0),
(659, '', 17, 19, 0),
(660, '', 17, 20, 0),
(661, '', 17, 21, 0),
(662, '', 17, 22, 0),
(663, '', 17, 23, 0),
(664, '', 17, 24, 0),
(665, '', 17, 25, 0),
(666, '', 17, 26, 0),
(667, '', 17, 27, 0),
(668, '', 17, 28, 0),
(669, '', 17, 29, 0),
(670, '', 17, 30, 0),
(671, '', 17, 31, 0),
(672, '', 17, 32, 0),
(673, '', 17, 33, 0),
(674, '', 17, 34, 0),
(675, '', 17, 35, 0),
(676, '', 17, 36, 0),
(677, '', 17, 37, 0),
(678, '', 17, 38, 0),
(679, '', 17, 39, 0),
(680, '', 17, 40, 0),
(681, '', 18, 1, 1),
(682, '', 18, 2, 1),
(683, '', 18, 3, 1),
(684, '', 18, 4, 1),
(685, '', 18, 5, 1),
(686, '', 18, 6, 1),
(687, '', 18, 7, 1),
(688, '', 18, 8, 1),
(689, '', 18, 9, 1),
(690, '', 18, 10, 1),
(691, '', 18, 11, 0),
(692, '', 18, 12, 0),
(693, '', 18, 13, 1),
(694, '', 18, 14, 0),
(695, '', 18, 15, 0),
(696, '', 18, 16, 0),
(697, '', 18, 17, 0),
(698, '', 18, 18, 0),
(699, '', 18, 19, 0),
(700, '', 18, 20, 0),
(701, '', 18, 21, 0),
(702, '', 18, 22, 0),
(703, '', 18, 23, 0),
(704, '', 18, 24, 0),
(705, '', 18, 25, 0),
(706, '', 18, 26, 0),
(707, '', 18, 27, 0),
(708, '', 18, 28, 0),
(709, '', 18, 29, 0),
(710, '', 18, 30, 0),
(711, '', 18, 31, 0),
(712, '', 18, 32, 0),
(713, '', 18, 33, 0),
(714, '', 18, 34, 0),
(715, '', 18, 35, 0),
(716, '', 18, 36, 0),
(717, '', 18, 37, 0),
(718, '', 18, 38, 0),
(719, '', 18, 39, 0),
(720, '', 18, 40, 0),
(721, '', 19, 1, 0),
(722, '', 19, 2, 0),
(723, '', 19, 3, 0),
(724, '', 19, 4, 0),
(725, '', 19, 5, 0),
(726, '', 19, 6, 0),
(727, '', 19, 7, 0),
(728, '', 19, 8, 0),
(729, '', 19, 9, 0),
(730, '', 19, 10, 0),
(731, '', 19, 11, 0),
(732, '', 19, 12, 0),
(733, '', 19, 13, 0),
(734, '', 19, 14, 0),
(735, '', 19, 15, 0),
(736, '', 19, 16, 0),
(737, '', 19, 17, 0),
(738, '', 19, 18, 0),
(739, '', 19, 19, 0),
(740, '', 19, 20, 0),
(741, '', 19, 21, 0),
(742, '', 19, 22, 0),
(743, '', 19, 23, 0),
(744, '', 19, 24, 0),
(745, '', 19, 25, 0),
(746, '', 19, 26, 0),
(747, '', 19, 27, 0),
(748, '', 19, 28, 0),
(749, '', 19, 29, 0),
(750, '', 19, 30, 0),
(751, '', 19, 31, 0),
(752, '', 19, 32, 0),
(753, '', 19, 33, 0),
(754, '', 19, 34, 0),
(755, '', 19, 35, 0),
(756, '', 19, 36, 0),
(757, '', 19, 37, 0),
(758, '', 19, 38, 0),
(759, '', 19, 39, 0),
(760, '', 19, 40, 0),
(761, '', 20, 1, 0),
(762, '', 20, 2, 0),
(763, '', 20, 3, 0),
(764, '', 20, 4, 0),
(765, '', 20, 5, 0),
(766, '', 20, 6, 0),
(767, '', 20, 7, 0),
(768, '', 20, 8, 0),
(769, '', 20, 9, 0),
(770, '', 20, 10, 0),
(771, '', 20, 11, 0),
(772, '', 20, 12, 0),
(773, '', 20, 13, 0),
(774, '', 20, 14, 0),
(775, '', 20, 15, 0),
(776, '', 20, 16, 0),
(777, '', 20, 17, 0),
(778, '', 20, 18, 0),
(779, '', 20, 19, 0),
(780, '', 20, 20, 0),
(781, '', 20, 21, 0),
(782, '', 20, 22, 0),
(783, '', 20, 23, 0),
(784, '', 20, 24, 0),
(785, '', 20, 25, 0),
(786, '', 20, 26, 0),
(787, '', 20, 27, 0),
(788, '', 20, 28, 0),
(789, '', 20, 29, 0),
(790, '', 20, 30, 0),
(791, '', 20, 31, 0),
(792, '', 20, 32, 0),
(793, '', 20, 33, 0),
(794, '', 20, 34, 0),
(795, '', 20, 35, 0),
(796, '', 20, 36, 0),
(797, '', 20, 37, 0),
(798, '', 20, 38, 0),
(799, '', 20, 39, 0),
(800, '', 20, 40, 0),
(801, '', 21, 1, 0),
(802, '', 21, 2, 0),
(803, '', 21, 3, 0),
(804, '', 21, 4, 0),
(805, '', 21, 5, 0),
(806, '', 21, 6, 0),
(807, '', 21, 7, 0),
(808, '', 21, 8, 0),
(809, '', 21, 9, 0),
(810, '', 21, 10, 0),
(811, '', 21, 11, 0),
(812, '', 21, 12, 0),
(813, '', 21, 13, 0),
(814, '', 21, 14, 0),
(815, '', 21, 15, 0),
(816, '', 21, 16, 0),
(817, '', 21, 17, 0),
(818, '', 21, 18, 0),
(819, '', 21, 19, 0),
(820, '', 21, 20, 0),
(821, '', 21, 21, 0),
(822, '', 21, 22, 0),
(823, '', 21, 23, 0),
(824, '', 21, 24, 0),
(825, '', 21, 25, 0),
(826, '', 21, 26, 0),
(827, '', 21, 27, 0),
(828, '', 21, 28, 0),
(829, '', 21, 29, 1),
(830, '', 21, 30, 0),
(831, '', 21, 31, 0),
(832, '', 21, 32, 0),
(833, '', 21, 33, 0),
(834, '', 21, 34, 0),
(835, '', 21, 35, 0),
(836, '', 21, 36, 0),
(837, '', 21, 37, 0),
(838, '', 21, 38, 0),
(839, '', 21, 39, 0),
(840, '', 21, 40, 0),
(841, '', 22, 1, 0),
(842, '', 22, 2, 0),
(843, '', 22, 3, 0),
(844, '', 22, 4, 0),
(845, '', 22, 5, 0),
(846, '', 22, 6, 0),
(847, '', 22, 7, 0),
(848, '', 22, 8, 0),
(849, '', 22, 9, 0),
(850, '', 22, 10, 0),
(851, '', 22, 11, 0),
(852, '', 22, 12, 0),
(853, '', 22, 13, 0),
(854, '', 22, 14, 0),
(855, '', 22, 15, 0),
(856, '', 22, 16, 0),
(857, '', 22, 17, 0),
(858, '', 22, 18, 0),
(859, '', 22, 19, 0),
(860, '', 22, 20, 0),
(861, '', 22, 21, 0),
(862, '', 22, 22, 0),
(863, '', 22, 23, 0),
(864, '', 22, 24, 0),
(865, '', 22, 25, 0),
(866, '', 22, 26, 0),
(867, '', 22, 27, 1),
(868, '', 22, 28, 1),
(869, '', 22, 29, 0),
(870, '', 22, 30, 0),
(871, '', 22, 31, 0),
(872, '', 22, 32, 0),
(873, '', 22, 33, 0),
(874, '', 22, 34, 0),
(875, '', 22, 35, 0),
(876, '', 22, 36, 0),
(877, '', 22, 37, 0),
(878, '', 22, 38, 0),
(879, '', 22, 39, 0),
(880, '', 22, 40, 0),
(881, '', 23, 1, 0),
(882, '', 23, 2, 0),
(883, '', 23, 3, 0),
(884, '', 23, 4, 0),
(885, '', 23, 5, 0),
(886, '', 23, 6, 0),
(887, '', 23, 7, 0),
(888, '', 23, 8, 0),
(889, '', 23, 9, 0),
(890, '', 23, 10, 0),
(891, '', 23, 11, 0),
(892, '', 23, 12, 0),
(893, '', 23, 13, 0),
(894, '', 23, 14, 0),
(895, '', 23, 15, 0),
(896, '', 23, 16, 0),
(897, '', 23, 17, 0),
(898, '', 23, 18, 0),
(899, '', 23, 19, 0),
(900, '', 23, 20, 0),
(901, '', 23, 21, 0),
(902, '', 23, 22, 0),
(903, '', 23, 23, 0),
(904, '', 23, 24, 0),
(905, '', 23, 25, 0),
(906, '', 23, 26, 0),
(907, '', 23, 27, 0),
(908, '', 23, 28, 0),
(909, '', 23, 29, 0),
(910, '', 23, 30, 0),
(911, '', 23, 31, 0),
(912, '', 23, 32, 0),
(913, '', 23, 33, 0),
(914, '', 23, 34, 0),
(915, '', 23, 35, 0),
(916, '', 23, 36, 0),
(917, '', 23, 37, 0),
(918, '', 23, 38, 0),
(919, '', 23, 39, 0),
(920, '', 23, 40, 0),
(921, '', 24, 1, 0),
(922, '', 24, 2, 0),
(923, '', 24, 3, 0),
(924, '', 24, 4, 0),
(925, '', 24, 5, 0),
(926, '', 24, 6, 0),
(927, '', 24, 7, 0),
(928, '', 24, 8, 0),
(929, '', 24, 9, 0),
(930, '', 24, 10, 0),
(931, '', 24, 11, 0),
(932, '', 24, 12, 0),
(933, '', 24, 13, 0),
(934, '', 24, 14, 0),
(935, '', 24, 15, 0),
(936, '', 24, 16, 0),
(937, '', 24, 17, 0),
(938, '', 24, 18, 0),
(939, '', 24, 19, 0),
(940, '', 24, 20, 0),
(941, '', 24, 21, 0),
(942, '', 24, 22, 0),
(943, '', 24, 23, 0),
(944, '', 24, 24, 0),
(945, '', 24, 25, 0),
(946, '', 24, 26, 0),
(947, '', 24, 27, 0),
(948, '', 24, 28, 0),
(949, '', 24, 29, 0),
(950, '', 24, 30, 0),
(951, '', 24, 31, 0),
(952, '', 24, 32, 0),
(953, '', 24, 33, 0),
(954, '', 24, 34, 0),
(955, '', 24, 35, 0),
(956, '', 24, 36, 0),
(957, '', 24, 37, 0),
(958, '', 24, 38, 0),
(959, '', 24, 39, 0),
(960, '', 24, 40, 0),
(961, '', 25, 1, 1),
(962, '', 25, 2, 1),
(963, '', 25, 3, 1),
(964, '', 25, 4, 1),
(965, '', 25, 5, 1),
(966, '', 25, 6, 1),
(967, '', 25, 7, 1),
(968, '', 25, 8, 1),
(969, '', 25, 9, 1),
(970, '', 25, 10, 1),
(971, '', 25, 11, 0),
(972, '', 25, 12, 0),
(973, '', 25, 13, 0),
(974, '', 25, 14, 0),
(975, '', 25, 15, 0),
(976, '', 25, 16, 1),
(977, '', 25, 17, 1),
(978, '', 25, 18, 1),
(979, '', 25, 19, 0),
(980, '', 25, 20, 1),
(981, '', 25, 21, 1),
(982, '', 25, 22, 0),
(983, '', 25, 23, 1),
(984, '', 25, 24, 0),
(985, '', 25, 25, 0),
(986, '', 25, 26, 0),
(987, '', 25, 27, 0),
(988, '', 25, 28, 0),
(989, '', 25, 29, 0),
(990, '', 25, 30, 0),
(991, '', 25, 31, 0),
(992, '', 25, 32, 0),
(993, '', 25, 33, 0),
(994, '', 25, 34, 0),
(995, '', 25, 35, 0),
(996, '', 25, 36, 0),
(997, '', 25, 37, 0),
(998, '', 25, 38, 0),
(999, '', 25, 39, 0),
(1000, '', 25, 40, 0),
(1001, '', 1, 41, 1),
(1002, '', 2, 41, 1),
(1003, '', 3, 41, 0),
(1004, '', 4, 41, 0),
(1005, '', 5, 41, 0),
(1006, '', 6, 41, 0),
(1007, '', 7, 41, 0),
(1008, '', 8, 41, 0),
(1009, '', 9, 41, 0),
(1010, '', 10, 41, 0),
(1011, '', 11, 41, 0),
(1012, '', 12, 41, 0),
(1013, '', 13, 41, 0),
(1014, '', 14, 41, 0),
(1015, '', 15, 41, 0),
(1016, '', 16, 41, 0),
(1017, '', 17, 41, 0),
(1018, '', 18, 41, 0),
(1019, '', 19, 41, 0),
(1020, '', 20, 41, 0),
(1021, '', 21, 41, 0),
(1022, '', 22, 41, 0),
(1023, '', 23, 41, 0),
(1024, '', 24, 41, 0),
(1025, '', 25, 41, 0),
(1026, '', 1, 42, 1);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_site`
--

CREATE TABLE `wbcc_site` (
  `idSite` int(11) NOT NULL,
  `numeroSite` varchar(50) DEFAULT NULL,
  `nomSite` varchar(255) DEFAULT NULL,
  `etatSite` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_site`
--

INSERT INTO `wbcc_site` (`idSite`, `numeroSite`, `nomSite`, `etatSite`) VALUES
(0, 'SITE170820240228325', '', 0),
(1, 'SITE170820240208255', 'PARIS', 1),
(2, 'SITE170820240208325', 'DAKAR', 1),
(3, 'SITE170820240208395', 'TUNIS', 1),
(4, 'SITE170820240208455', 'COTONOU', 1);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_solde_conge`
--

CREATE TABLE `wbcc_solde_conge` (
  `idSoldeConge` int(11) NOT NULL,
  `idUtilisateurF` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `soldeCumule` int(11) DEFAULT NULL,
  `soldeRestant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wbcc_solde_conge`
--

INSERT INTO `wbcc_solde_conge` (`idSoldeConge`, `idUtilisateurF`, `annee`, `soldeCumule`, `soldeRestant`) VALUES
(1, 1, 2025, 10, 10),
(2, 2, 2025, 6, 6),
(3, 605, 2025, 6, 6),
(4, 609, 2025, 20, 20),
(5, 611, 2025, 6, 6),
(6, 3, 2025, 6, 6),
(7, 613, 2025, 6, 6),
(8, 614, 2025, 6, 6),
(9, 607, 2025, 6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_sous_module`
--

CREATE TABLE `wbcc_sous_module` (
  `idSousModule` int(11) NOT NULL,
  `nomSousModule` varchar(255) DEFAULT NULL,
  `numeroSousModule` varchar(50) DEFAULT NULL,
  `controller` varchar(150) DEFAULT NULL,
  `function` varchar(150) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `etatSousModule` int(11) DEFAULT 1,
  `idModuleF` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_sous_module`
--

INSERT INTO `wbcc_sous_module` (`idSousModule`, `nomSousModule`, `numeroSousModule`, `controller`, `function`, `icon`, `etatSousModule`, `idModuleF`) VALUES
(1, 'Opportunités', NULL, 'Gestionnaire', 'indexOpportunite', 'fas fa-fw fa-folder', 1, 1),
(2, 'Gestion Ticket', NULL, 'Ticket', 'index', 'fas fa-fw fa-envelope', 1, 1),
(3, 'Tableau de Bord', NULL, 'GestionnaireExterne', 'tbdOpportunite', 'fas fa-fw fa-chart-line', 1, 1),
(4, 'Anomalies', NULL, 'GestionnaireExterne', 'indexOpportunite', 'fas fa-fw fa-times-circle', 1, 1),
(5, 'Audit', NULL, 'Gestionnaire', 'indexAudit', 'fa fa-solid fa-search', 1, 1),
(6, 'Liste des Tâches', NULL, 'Gestionnaire', 'indexTache', 'fas fa-fw fa-file-alt', 1, 1),
(7, 'Contacts', NULL, 'Gestionnaire', 'indexContact', 'fas fa-fw fa-address-book', 1, 1),
(8, 'Sociétés', NULL, 'Gestionnaire', 'indexSociete', 'fas fa-fw fa-briefcase', 1, 1),
(9, 'Immeuble', NULL, 'Gestionnaire', 'indexImmeuble', 'fas fa-fw fa-building', 1, 1),
(10, 'Appartement', NULL, 'Gestionnaire', 'indexAppartement', 'fas fa-fw fa-warehouse', 1, 1),
(11, 'Gestion Equipement', NULL, 'GestionInterne', 'indexEquipement', 'fa fa-solid fa-warehouse', 1, 2),
(12, 'Gestion Site', NULL, 'GestionInterne', 'indexSite', 'fa fa-solid fa-warehouse', 1, 2),
(13, 'Gestion Artisan', NULL, 'GestionInterne', 'indexArtisan', 'fa fa-solid fa-users', 1, 2),
(14, ' Gestion Subvention', NULL, 'GestionInterne', 'indexSubvention', 'fa fa-solid fa-euro-sign', 1, 2),
(15, 'Recrutement', NULL, 'Recrutement', 'index', 'fa fa-solid fa-users', 1, 2),
(16, 'Gestion Personnel', NULL, 'GestionInterne', 'indexPersonnel', 'fa fa-solid fa-user', 1, 2),
(17, 'Rendez-Vous', NULL, 'RendezVous', 'index/expert', 'fas fa-fw fa-calendar', 1, 3),
(18, 'Rendez-Vous', NULL, 'RendezVous', 'index/artisan', 'fas fa-fw fa-calendar', 1, 4),
(19, 'Proposition Commerciale', NULL, 'VRP', 'index', 'fa fa-solid fa-handshake', 1, 5),
(20, 'Gestion DO', NULL, 'DonneurOrdre', 'index', 'fas fa-fw fa-users', 1, 1),
(21, 'Gestion Copro', NULL, 'Copro', 'index', 'fas fa-fw fa-users', 1, 1),
(22, 'Règlements', NULL, 'Comptable', 'listeReglement', 'fa fa-solid fa-euro-sign', 1, 6),
(23, 'Encaissements', NULL, 'Comptable', 'indexEncaissement', 'fa fa-solid fa-euro-sign', 1, 6),
(24, 'Enveloppes', NULL, 'Comptable', 'indexEnveloppe', 'fa fa-envelope', 1, 6),
(25, 'Chèques', NULL, 'Comptable', 'indexCheque', 'fa fa-solid fa-money-check', 1, 6),
(26, 'Liste des Tâches', NULL, 'Comptable', 'indexTache', 'fa fa-list', 1, 6),
(27, 'Dossier', NULL, 'Copro', 'indexDossier', 'fas fa-fw fa-folder', 1, 7),
(28, 'Lot', NULL, 'Copro', 'indexLot', 'fas fa-fw fa-warehouse', 1, 7),
(29, 'Dossier', NULL, 'Occupant', 'indexOccupant', 'fas fa-fw fa-folder', 1, 8),
(30, 'Déclarer un sinistre', NULL, 'Sinistre', 'declaration', 'fas fa-house-damage', 1, 9),
(31, 'Mes sinistres', NULL, 'Sinistre', 'index', 'fas fa-folder', 1, 9),
(32, 'Espace', NULL, 'Espace', 'index', 'fas fa-fw fa-home', 1, 10),
(33, 'Dossier', NULL, 'Dossier', 'index', 'fas fa-fw fa-folder', 1, 10),
(34, 'Immeuble', NULL, 'Immeuble', 'index', 'fas fa-fw fa-building', 1, 10),
(35, 'Lot', NULL, 'Lot', 'index', 'fas fa-fw fa-warehouse', 1, 10),
(36, 'Signature', NULL, 'Signature', 'index', 'fas fa-fw fa-file-signature', 1, 10),
(37, 'Personnel', NULL, 'Personnel', 'index', 'fas fa-fw fa-users', 1, 10),
(38, 'Personnel', NULL, 'Utilisateur', 'users', 'fas fa-fw fa-user-tie', 1, 2),
(39, 'Espace', NULL, 'Espace', 'index', 'fas fa-fw fa-home', 1, 4),
(40, 'Personnel', NULL, 'Personnel', 'index', 'fas fa-fw fa-users', 1, 4),
(41, 'Gestion des Rôles', NULL, 'GestionInterne', 'indexRole', 'fa fa-solid fa-warehouse', 1, 2),
(42, 'Gestion Projet', NULL, 'GestionInterne', 'indexProjet', 'fa fa-regular fa-folder-open', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_subvention`
--

CREATE TABLE `wbcc_subvention` (
  `idSubvention` int(11) NOT NULL,
  `numeroSubvention` varchar(50) DEFAULT NULL,
  `titreSubvention` varchar(255) DEFAULT NULL,
  `montantSubvention` varchar(50) DEFAULT NULL,
  `taux` int(11) DEFAULT NULL,
  `natureTravaux` varchar(255) DEFAULT NULL,
  `natureAide` varchar(255) DEFAULT NULL,
  `idOrganisme` int(11) DEFAULT NULL,
  `createDate` varchar(25) DEFAULT NULL,
  `editDate` varchar(25) DEFAULT NULL,
  `idAuteur` int(11) DEFAULT NULL,
  `etatSubvention` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_subvention`
--

INSERT INTO `wbcc_subvention` (`idSubvention`, `numeroSubvention`, `titreSubvention`, `montantSubvention`, `taux`, `natureTravaux`, `natureAide`, `idOrganisme`, `createDate`, `editDate`, `idAuteur`, `etatSubvention`) VALUES
(1, 'SUB181220241049261', 'tEST', '1000', 10, 'Collectif', 'Collectif', 1, '2024-12-18 10:49:26', '2024-12-18 10:49:26', 1, 1),
(2, 'SUB191220241355581', 'aze', '1000', 1, 'Collectif', 'Collectif', 1, '2024-12-19 13:55:58', '2024-12-19 13:55:58', 1, 1),
(3, 'SUB191220241409281', 'tEST', '1000', 1, '', '', 1, '2024-12-19 14:09:28', '2024-12-19 14:09:28', 1, 1),
(4, 'SUB191220241412231', 'aze', '1000', 1, '', 'Collectif', 1, '2024-12-19 14:12:23', '2024-12-19 14:12:23', 1, 1),
(5, 'SUB191220241413081', 'aze', '1000', 1, 'Privatif', 'Collectif', 1, '2024-12-19 14:13:08', '2024-12-19 14:13:08', 1, 1),
(6, 'SUB191220241414371', 'aze', '1000', 1, 'Privatif', 'Collectif', 1, '2024-12-19 14:14:37', '2024-12-19 14:14:37', 1, 1),
(7, 'SUB191220241423091', 'az', '1000', 0, '', 'Collectif', 1, '2024-12-19 14:23:09', '2024-12-19 14:23:09', 1, 1),
(8, 'SUB191220241423511', 'tEST', '1000', 1, 'Collectif', '', 1, '2024-12-19 14:23:51', '2024-12-19 14:23:51', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_type_condition`
--

CREATE TABLE `wbcc_type_condition` (
  `idTypeCondition` int(11) NOT NULL,
  `numeroTypeCondition` varchar(50) DEFAULT NULL,
  `libelleTypeCondition` varchar(255) DEFAULT NULL,
  `nomVariable` varchar(255) DEFAULT NULL,
  `createDate` varchar(25) DEFAULT current_timestamp(),
  `editDate` varchar(25) DEFAULT current_timestamp(),
  `idAuteur` int(11) DEFAULT NULL,
  `etatTypeCondition` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_type_conge`
--

CREATE TABLE `wbcc_type_conge` (
  `idTypeConge` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `quotas` int(11) DEFAULT NULL,
  `politique` varchar(255) DEFAULT NULL,
  `createDate` varchar(25) DEFAULT NULL,
  `editDate` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wbcc_type_conge`
--

INSERT INTO `wbcc_type_conge` (`idTypeConge`, `type`, `quotas`, `politique`, `createDate`, `editDate`) VALUES
(1, 'Congé maladie', 3, 'politique1aze', '2025-01-26 14:53:32', '2025-01-27 14:53:32'),
(2, 'Congé payé', 22, 'politique23', '2025-01-23 14:53:32', '2025-01-31 12:19:18'),
(3, 'Congé de paternité', 2, 'politique3', '2025-01-27 14:53:32', '2025-01-27 16:04:39'),
(7, 'Congé de maternité', 30, 'politique4', '2025-01-27 14:53:32', '2025-01-27 14:53:32');

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_user_access`
--

CREATE TABLE `wbcc_user_access` (
  `idUserAccess` int(11) NOT NULL,
  `lien` text DEFAULT NULL,
  `idUserF` int(11) DEFAULT NULL,
  `nomUser` varchar(255) DEFAULT NULL,
  `dateAccess` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wbcc_utilisateur`
--

CREATE TABLE `wbcc_utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matricule` varchar(50) DEFAULT '',
  `role` int(1) NOT NULL,
  `etatUser` int(11) NOT NULL,
  `idContactF` int(11) NOT NULL,
  `firstConnection` int(11) NOT NULL DEFAULT 0,
  `isVerified` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `tokenPwd` varchar(255) DEFAULT NULL,
  `valideCompte` int(11) NOT NULL DEFAULT 0,
  `jourTravail` varchar(255) DEFAULT '',
  `horaireTravail` varchar(255) DEFAULT '',
  `margeTravail` varchar(50) DEFAULT '',
  `cpZoneRV` varchar(255) DEFAULT '',
  `villeZoneRV` varchar(255) DEFAULT '',
  `adresseZoneRV` text DEFAULT '',
  `typeZoneRV` varchar(255) DEFAULT NULL,
  `codeDepartement` varchar(255) DEFAULT NULL,
  `commentaireConfig` text DEFAULT '',
  `moyenTransport` varchar(100) DEFAULT 'pied',
  `idGuidWbccGroup` varchar(50) DEFAULT NULL,
  `jourTravailB2C` varchar(255) DEFAULT NULL,
  `horaireTravailB2C` varchar(255) DEFAULT NULL,
  `margeTravailB2C` varchar(100) DEFAULT NULL,
  `commentaireConfigB2C` text DEFAULT NULL,
  `nbOpPrevuB2C` varchar(100) DEFAULT NULL,
  `nbVisitePrevuB2C` varchar(100) DEFAULT NULL,
  `nbGardienB2C` varchar(100) DEFAULT NULL,
  `cpZoneB2C` varchar(255) DEFAULT NULL,
  `villeZoneB2C` varchar(255) DEFAULT NULL,
  `typeZoneB2C` varchar(255) DEFAULT NULL,
  `codeDepartementB2C` varchar(255) DEFAULT NULL,
  `dateDesactivation` varchar(25) DEFAULT NULL,
  `isExpert` int(11) DEFAULT 0,
  `isAdmin` int(11) DEFAULT 0,
  `isCommercial` int(11) DEFAULT 0,
  `isDirecteurCommercial` int(11) DEFAULT 0,
  `isGestionnaire` int(11) DEFAULT 0,
  `isFormateur` int(11) NOT NULL DEFAULT 0,
  `idSiteF` int(11) DEFAULT 0,
  `isInterne` int(11) DEFAULT 0,
  `typeUser` varchar(100) DEFAULT NULL,
  `isServiceTechnique` int(11) DEFAULT 0,
  `isAccessAllOP` int(11) DEFAULT 0,
  `isPointageInterne` tinyint(1) NOT NULL DEFAULT 1,
  `photo` varchar(255) DEFAULT NULL,
  `typePointage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wbcc_utilisateur`
--

INSERT INTO `wbcc_utilisateur` (`idUtilisateur`, `login`, `mdp`, `email`, `matricule`, `role`, `etatUser`, `idContactF`, `firstConnection`, `isVerified`, `token`, `tokenPwd`, `valideCompte`, `jourTravail`, `horaireTravail`, `margeTravail`, `cpZoneRV`, `villeZoneRV`, `adresseZoneRV`, `typeZoneRV`, `codeDepartement`, `commentaireConfig`, `moyenTransport`, `idGuidWbccGroup`, `jourTravailB2C`, `horaireTravailB2C`, `margeTravailB2C`, `commentaireConfigB2C`, `nbOpPrevuB2C`, `nbVisitePrevuB2C`, `nbGardienB2C`, `cpZoneB2C`, `villeZoneB2C`, `typeZoneB2C`, `codeDepartementB2C`, `dateDesactivation`, `isExpert`, `isAdmin`, `isCommercial`, `isDirecteurCommercial`, `isGestionnaire`, `isFormateur`, `idSiteF`, `isInterne`, `typeUser`, `isServiceTechnique`, `isAccessAllOP`, `isPointageInterne`, `photo`, `typePointage`) VALUES
(1, 'jawher@wbcc.fr', '482f7629a2511d23ef4e958b13a5ba54bdba06f2', 'jawher@wbcc.fr', '', 1, 1, 1, 1, 11, NULL, NULL, 1, '', '', '', '', '', '', NULL, NULL, '', 'pied', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 3, 1, NULL, 0, 0, 1, NULL, NULL),
(2, 'nabila.nabila@gmail.com', 'b5103fcf2b47213b852e9004c5ba76a03656c0d0', 'nabila.nabila@gmail.com', 'nabila', 1, 1, 2, 1, 1, NULL, NULL, 1, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '09:00-15:00;09:00-15:00;09:00-15:00;09:00-15:00;09:00-15:00;10:00-14:00', '', '', '', '', NULL, NULL, '', 'pied', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, 1, NULL, 0, 0, 1, NULL, NULL),
(3, 'test.test@wbcc.fr', '482f7629a2511d23ef4e958b13a5ba54bdba06f2', 'test.test@wbcc.fr', 'tt', 33, 1, 3, 1, 1, '', NULL, 1, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '09:00-15:00;09:00-15:00;09:00-15:00;09:00-15:00;09:00-15:00;10:00-14:00', '', '', '', '', NULL, '', '', 'voiture', NULL, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00', NULL, NULL, '5', '40', NULL, '', '', 'Ville', '', NULL, 0, 1, 0, 0, 0, 0, 1, 1, NULL, 0, 0, 1, NULL, NULL),
(605, 'jeanmarc.d@wbcc.fr', '482f7629a2511d23ef4e958b13a5ba54bdba06f2', 'jeanmarc.d@wbcc.fr', 'cc', 3, 1, 8460, 1, 1, '', NULL, 1, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi;Dimanche', '09:00-15:00;09:00-15:00;09:00-15:00;09:00-15:00;09:00-15:00;10:00-14:00;10:00-14:00', '', '', '', '', NULL, '', '', 'voiture', NULL, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00', NULL, NULL, '5', '40', NULL, '', '', 'Ville', '', NULL, 0, 0, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 1, NULL, NULL),
(607, 'admin.admin@wbcc.fr', '482f7629a2511d23ef4e958b13a5ba54bdba06f2', 'admin.admin@wbcc.fr', 'mm', 34, 1, 8462, 1, 1, '', NULL, 1, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi;Dimanche', '09:00-15:00;09:00-15:00;09:00-15:00;09:00-15:00;09:00-15:00;10:00-14:00;10:00-14:00', '', '', '', '', NULL, '', '', 'voiture', NULL, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00', NULL, NULL, '5', '40', NULL, '', '', 'Ville', '', NULL, NULL, 0, NULL, NULL, NULL, 0, 3, 1, NULL, 0, 0, 1, NULL, NULL),
(609, 'hamzatestwbcc@yopmail.com', '482f7629a2511d23ef4e958b13a5ba54bdba06f2', 'hamzatestwbcc@yopmail.com', 'cc', 3, 1, 1998, 1, 1, '', NULL, 1, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi;Dimanche', '09:00-18:00;09:00-18:00;09:00-18:00;09:00-18:00;09:00-12:50;10:00-14:00;10:00-14:00', '', '', '', '', NULL, '', '', 'voiture', NULL, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00', NULL, NULL, '5', '40', NULL, '', '', 'Ville', '', NULL, 0, 0, 0, 0, 1, 0, 1, 1, NULL, 0, 0, 1, NULL, NULL),
(611, 'achref@wbcc.fr', '482f7629a2511d23ef4e958b13a5ba54bdba06f2', 'achref@wbcc.fr', 'cc', 3, 1, 8464, 1, 1, '', NULL, 1, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi;Dimanche', '09:00-15:00;09:00-18:00;09:00-15:00;09:00-15:00;11:30-15:00;10:00-14:00;10:00-14:00', '', '', '', '', NULL, '', '', 'voiture', NULL, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00', NULL, NULL, '5', '40', NULL, '', '', 'Ville', '', NULL, 0, 0, 0, 0, 1, 0, 3, 1, NULL, 0, 0, 1, NULL, NULL),
(613, 'tagueznabila8@gmail.com', 'b5103fcf2b47213b852e9004c5ba76a03656c0d0', 'tagueznabila8@gmail.com', 'nabila', 33, 1, 8465, 1, 1, '', NULL, 1, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '09:00-15:00;09:00-15:00;09:00-22:00;09:00-15:00;09:00-15:00;10:00-20:00', '', '', '', '', NULL, '', '', 'voiture', NULL, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00', NULL, NULL, '5', '40', NULL, '', '', 'Ville', '', NULL, 0, 1, 0, 0, 0, 0, 3, 1, NULL, 0, 0, 1, NULL, NULL),
(614, 'oueslatihend@wbcc.fr', 'b5103fcf2b47213b852e9004c5ba76a03656c0d0', 'oueslatihend@wbcc.fr', 'hend', 33, 1, 8466, 1, 1, '', NULL, 1, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '09:00-18:00;09:00-18:00;09:00-18:00;09:00-18:00;09:00-18:00;10:00-18:00', '', '', '', '', NULL, '', '', 'voiture', NULL, 'Lundi;Mardi;Mercredi;Jeudi;Vendredi;Samedi', '16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00;16:00-20:00', NULL, NULL, '5', '40', NULL, '', '', 'Ville', '', NULL, 0, 1, 0, 0, 0, 0, 3, 1, NULL, 0, 0, 1, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `wbcc_appartement`
--
ALTER TABLE `wbcc_appartement`
  ADD PRIMARY KEY (`idApp`),
  ADD KEY `idImmeubleF` (`idImmeubleF`),
  ADD KEY `idProprietaire` (`idProprietaire`),
  ADD KEY `idAgenceImmobiliere` (`idAgenceImmobiliere`),
  ADD KEY `idCompanyCopro` (`idCompanyCopro`),
  ADD KEY `idOccupant` (`idOccupant`);

--
-- Index pour la table `wbcc_appartement_contact`
--
ALTER TABLE `wbcc_appartement_contact`
  ADD PRIMARY KEY (`idAppCon`),
  ADD KEY `idAppartementF` (`idAppartementF`),
  ADD KEY `idContactF` (`idContactF`);

--
-- Index pour la table `wbcc_company`
--
ALTER TABLE `wbcc_company`
  ADD PRIMARY KEY (`idCompany`),
  ADD KEY `idTitreF` (`idTitreF`),
  ADD KEY `idServiceF` (`idServiceF`),
  ADD KEY `getCompaniesBySuperArtisan` (`idArtisanDevisF`);

--
-- Index pour la table `wbcc_condition`
--
ALTER TABLE `wbcc_condition`
  ADD PRIMARY KEY (`idCondition`),
  ADD KEY `idAuteur` (`idAuteur`),
  ADD KEY `idTypeConditionF` (`idTypeConditionF`);

--
-- Index pour la table `wbcc_condition_critere`
--
ALTER TABLE `wbcc_condition_critere`
  ADD PRIMARY KEY (`idConditionCritere`),
  ADD KEY `idConditionF` (`idConditionF`),
  ADD KEY `idCritereF` (`idCritereF`),
  ADD KEY `idAuteur` (`idAuteur`);

--
-- Index pour la table `wbcc_contact`
--
ALTER TABLE `wbcc_contact`
  ADD PRIMARY KEY (`idContact`),
  ADD KEY `idContactFContact` (`idContactFContact`);

--
-- Index pour la table `wbcc_contact_company`
--
ALTER TABLE `wbcc_contact_company`
  ADD PRIMARY KEY (`idContactCompany`),
  ADD KEY `idContactF` (`idContactF`),
  ADD KEY `idCompanyF` (`idCompanyF`);

--
-- Index pour la table `wbcc_critere`
--
ALTER TABLE `wbcc_critere`
  ADD PRIMARY KEY (`idCritere`),
  ADD KEY `idAuteur` (`idAuteur`);

--
-- Index pour la table `wbcc_critere_subvention`
--
ALTER TABLE `wbcc_critere_subvention`
  ADD PRIMARY KEY (`idCritereSubvention`),
  ADD KEY `idSubventionF` (`idSubventionF`),
  ADD KEY `idAuteur` (`idAuteur`),
  ADD KEY `idCritereF` (`idCritereF`);

--
-- Index pour la table `wbcc_demandesconge`
--
ALTER TABLE `wbcc_demandesconge`
  ADD PRIMARY KEY (`idDemande`),
  ADD KEY `fk_idUtilisateur` (`idUtilisateurF`),
  ADD KEY `fk_idTypeConge` (`idTypeCongeF`);

--
-- Index pour la table `wbcc_document`
--
ALTER TABLE `wbcc_document`
  ADD PRIMARY KEY (`idDocument`),
  ADD KEY `idUserF` (`idUtilisateurF`);

--
-- Index pour la table `wbcc_document_conge`
--
ALTER TABLE `wbcc_document_conge`
  ADD PRIMARY KEY (`idDocumentConge`),
  ADD KEY `idDocumentF` (`idDocumentF`),
  ADD KEY `idDemandeF` (`idDemandeF`);

--
-- Index pour la table `wbcc_document_requis`
--
ALTER TABLE `wbcc_document_requis`
  ADD PRIMARY KEY (`idDocumentRequis`);

--
-- Index pour la table `wbcc_document_requis_subvention`
--
ALTER TABLE `wbcc_document_requis_subvention`
  ADD PRIMARY KEY (`idDocumentRequisSubvention`),
  ADD KEY `idDocumentRequisF` (`idDocumentRequisF`),
  ADD KEY `idSubventionF` (`idSubventionF`);

--
-- Index pour la table `wbcc_historique`
--
ALTER TABLE `wbcc_historique`
  ADD PRIMARY KEY (`idHistorique`),
  ADD KEY `idUtilsateur` (`idUtilisateurF`);

--
-- Index pour la table `wbcc_immeuble`
--
ALTER TABLE `wbcc_immeuble`
  ADD PRIMARY KEY (`idImmeuble`),
  ADD KEY `idUserF` (`idUserF`);

--
-- Index pour la table `wbcc_module`
--
ALTER TABLE `wbcc_module`
  ADD PRIMARY KEY (`idModule`);

--
-- Index pour la table `wbcc_notification`
--
ALTER TABLE `wbcc_notification`
  ADD PRIMARY KEY (`idNotification`),
  ADD KEY `idUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `wbcc_parametres`
--
ALTER TABLE `wbcc_parametres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wbcc_pointage`
--
ALTER TABLE `wbcc_pointage`
  ADD PRIMARY KEY (`idPointage`),
  ADD KEY `idUserF` (`idUserF`),
  ADD KEY `idTraiteF` (`idTraiteF`);

--
-- Index pour la table `wbcc_projet`
--
ALTER TABLE `wbcc_projet`
  ADD PRIMARY KEY (`idProjet`),
  ADD KEY `wbcc_projet_ibfk_1` (`idImmeuble`),
  ADD KEY `wbcc_projet_ibfk_2` (`idApp`);

--
-- Index pour la table `wbcc_roles`
--
ALTER TABLE `wbcc_roles`
  ADD PRIMARY KEY (`idRole`);

--
-- Index pour la table `wbcc_role_sous_module`
--
ALTER TABLE `wbcc_role_sous_module`
  ADD PRIMARY KEY (`idRoleSousModule`),
  ADD KEY `idSousModuleF` (`idSousModuleF`),
  ADD KEY `idRoleF` (`idRoleF`);

--
-- Index pour la table `wbcc_site`
--
ALTER TABLE `wbcc_site`
  ADD PRIMARY KEY (`idSite`);

--
-- Index pour la table `wbcc_solde_conge`
--
ALTER TABLE `wbcc_solde_conge`
  ADD PRIMARY KEY (`idSoldeConge`),
  ADD KEY `idUtilisateurF` (`idUtilisateurF`),
  ADD KEY `idSoldeConge` (`idSoldeConge`,`idUtilisateurF`,`annee`,`soldeCumule`,`soldeRestant`);

--
-- Index pour la table `wbcc_sous_module`
--
ALTER TABLE `wbcc_sous_module`
  ADD PRIMARY KEY (`idSousModule`),
  ADD KEY `idModule` (`idModuleF`);

--
-- Index pour la table `wbcc_subvention`
--
ALTER TABLE `wbcc_subvention`
  ADD PRIMARY KEY (`idSubvention`),
  ADD KEY `idAuteur` (`idAuteur`),
  ADD KEY `idOrganisme` (`idOrganisme`);

--
-- Index pour la table `wbcc_type_condition`
--
ALTER TABLE `wbcc_type_condition`
  ADD PRIMARY KEY (`idTypeCondition`),
  ADD KEY `idAuteur` (`idAuteur`);

--
-- Index pour la table `wbcc_type_conge`
--
ALTER TABLE `wbcc_type_conge`
  ADD PRIMARY KEY (`idTypeConge`);

--
-- Index pour la table `wbcc_user_access`
--
ALTER TABLE `wbcc_user_access`
  ADD PRIMARY KEY (`idUserAccess`),
  ADD KEY `idUserF` (`idUserF`);

--
-- Index pour la table `wbcc_utilisateur`
--
ALTER TABLE `wbcc_utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD KEY `role` (`role`),
  ADD KEY `idEmployeF` (`idContactF`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `wbcc_appartement`
--
ALTER TABLE `wbcc_appartement`
  MODIFY `idApp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `wbcc_appartement_contact`
--
ALTER TABLE `wbcc_appartement_contact`
  MODIFY `idAppCon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wbcc_company`
--
ALTER TABLE `wbcc_company`
  MODIFY `idCompany` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `wbcc_condition`
--
ALTER TABLE `wbcc_condition`
  MODIFY `idCondition` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wbcc_condition_critere`
--
ALTER TABLE `wbcc_condition_critere`
  MODIFY `idConditionCritere` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wbcc_contact`
--
ALTER TABLE `wbcc_contact`
  MODIFY `idContact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8467;

--
-- AUTO_INCREMENT pour la table `wbcc_contact_company`
--
ALTER TABLE `wbcc_contact_company`
  MODIFY `idContactCompany` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wbcc_critere`
--
ALTER TABLE `wbcc_critere`
  MODIFY `idCritere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `wbcc_critere_subvention`
--
ALTER TABLE `wbcc_critere_subvention`
  MODIFY `idCritereSubvention` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `wbcc_demandesconge`
--
ALTER TABLE `wbcc_demandesconge`
  MODIFY `idDemande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT pour la table `wbcc_document`
--
ALTER TABLE `wbcc_document`
  MODIFY `idDocument` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49896;

--
-- AUTO_INCREMENT pour la table `wbcc_document_conge`
--
ALTER TABLE `wbcc_document_conge`
  MODIFY `idDocumentConge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `wbcc_document_requis`
--
ALTER TABLE `wbcc_document_requis`
  MODIFY `idDocumentRequis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wbcc_document_requis_subvention`
--
ALTER TABLE `wbcc_document_requis_subvention`
  MODIFY `idDocumentRequisSubvention` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wbcc_historique`
--
ALTER TABLE `wbcc_historique`
  MODIFY `idHistorique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT pour la table `wbcc_immeuble`
--
ALTER TABLE `wbcc_immeuble`
  MODIFY `idImmeuble` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2458;

--
-- AUTO_INCREMENT pour la table `wbcc_module`
--
ALTER TABLE `wbcc_module`
  MODIFY `idModule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `wbcc_notification`
--
ALTER TABLE `wbcc_notification`
  MODIFY `idNotification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=725;

--
-- AUTO_INCREMENT pour la table `wbcc_parametres`
--
ALTER TABLE `wbcc_parametres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `wbcc_pointage`
--
ALTER TABLE `wbcc_pointage`
  MODIFY `idPointage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=531;

--
-- AUTO_INCREMENT pour la table `wbcc_projet`
--
ALTER TABLE `wbcc_projet`
  MODIFY `idProjet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `wbcc_roles`
--
ALTER TABLE `wbcc_roles`
  MODIFY `idRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `wbcc_role_sous_module`
--
ALTER TABLE `wbcc_role_sous_module`
  MODIFY `idRoleSousModule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1027;

--
-- AUTO_INCREMENT pour la table `wbcc_site`
--
ALTER TABLE `wbcc_site`
  MODIFY `idSite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `wbcc_solde_conge`
--
ALTER TABLE `wbcc_solde_conge`
  MODIFY `idSoldeConge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `wbcc_sous_module`
--
ALTER TABLE `wbcc_sous_module`
  MODIFY `idSousModule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `wbcc_subvention`
--
ALTER TABLE `wbcc_subvention`
  MODIFY `idSubvention` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `wbcc_type_condition`
--
ALTER TABLE `wbcc_type_condition`
  MODIFY `idTypeCondition` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wbcc_type_conge`
--
ALTER TABLE `wbcc_type_conge`
  MODIFY `idTypeConge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `wbcc_user_access`
--
ALTER TABLE `wbcc_user_access`
  MODIFY `idUserAccess` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wbcc_utilisateur`
--
ALTER TABLE `wbcc_utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6092;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `wbcc_appartement`
--
ALTER TABLE `wbcc_appartement`
  ADD CONSTRAINT `wbcc_appartement_ibfk_1` FOREIGN KEY (`idImmeubleF`) REFERENCES `wbcc_immeuble` (`idImmeuble`);

--
-- Contraintes pour la table `wbcc_appartement_contact`
--
ALTER TABLE `wbcc_appartement_contact`
  ADD CONSTRAINT `wbcc_appartement_contact_ibfk_1` FOREIGN KEY (`idAppartementF`) REFERENCES `wbcc_appartement` (`idApp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wbcc_appartement_contact_ibfk_2` FOREIGN KEY (`idContactF`) REFERENCES `wbcc_contact` (`idContact`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wbcc_condition`
--
ALTER TABLE `wbcc_condition`
  ADD CONSTRAINT `wbcc_condition_ibfk_1` FOREIGN KEY (`idTypeConditionF`) REFERENCES `wbcc_condition` (`idCondition`);

--
-- Contraintes pour la table `wbcc_condition_critere`
--
ALTER TABLE `wbcc_condition_critere`
  ADD CONSTRAINT `wbcc_condition_critere_ibfk_1` FOREIGN KEY (`idConditionF`) REFERENCES `wbcc_condition` (`idCondition`),
  ADD CONSTRAINT `wbcc_condition_critere_ibfk_2` FOREIGN KEY (`idCritereF`) REFERENCES `wbcc_critere` (`idCritere`);

--
-- Contraintes pour la table `wbcc_contact_company`
--
ALTER TABLE `wbcc_contact_company`
  ADD CONSTRAINT `wbcc_contact_company_ibfk_1` FOREIGN KEY (`idContactF`) REFERENCES `wbcc_contact` (`idContact`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wbcc_contact_company_ibfk_2` FOREIGN KEY (`idCompanyF`) REFERENCES `wbcc_company` (`idCompany`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wbcc_critere_subvention`
--
ALTER TABLE `wbcc_critere_subvention`
  ADD CONSTRAINT `wbcc_critere_subvention_ibfk_1` FOREIGN KEY (`idCritereF`) REFERENCES `wbcc_critere` (`idCritere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wbcc_critere_subvention_ibfk_2` FOREIGN KEY (`idSubventionF`) REFERENCES `wbcc_subvention` (`idSubvention`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wbcc_demandesconge`
--
ALTER TABLE `wbcc_demandesconge`
  ADD CONSTRAINT `fk_idTypeConge` FOREIGN KEY (`idTypeCongeF`) REFERENCES `wbcc_type_conge` (`idTypeConge`),
  ADD CONSTRAINT `fk_idUtilisateur` FOREIGN KEY (`idUtilisateurF`) REFERENCES `wbcc_utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `wbcc_document`
--
ALTER TABLE `wbcc_document`
  ADD CONSTRAINT `wbcc_document_ibfk_1` FOREIGN KEY (`idUtilisateurF`) REFERENCES `wbcc_utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `wbcc_document_conge`
--
ALTER TABLE `wbcc_document_conge`
  ADD CONSTRAINT `wbcc_document_conge_ibfk_1` FOREIGN KEY (`idDocumentF`) REFERENCES `wbcc_document` (`idDocument`) ON DELETE CASCADE,
  ADD CONSTRAINT `wbcc_document_conge_ibfk_2` FOREIGN KEY (`idDemandeF`) REFERENCES `wbcc_demandesconge` (`idDemande`) ON DELETE CASCADE;

--
-- Contraintes pour la table `wbcc_document_requis_subvention`
--
ALTER TABLE `wbcc_document_requis_subvention`
  ADD CONSTRAINT `wbcc_document_requis_subvention_ibfk_1` FOREIGN KEY (`idDocumentRequisF`) REFERENCES `wbcc_document_requis` (`idDocumentRequis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wbcc_document_requis_subvention_ibfk_2` FOREIGN KEY (`idSubventionF`) REFERENCES `wbcc_subvention` (`idSubvention`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wbcc_historique`
--
ALTER TABLE `wbcc_historique`
  ADD CONSTRAINT `wbcc_historique_ibfk_1` FOREIGN KEY (`idUtilisateurF`) REFERENCES `wbcc_utilisateur` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wbcc_notification`
--
ALTER TABLE `wbcc_notification`
  ADD CONSTRAINT `wbcc_notification_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `wbcc_utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `wbcc_projet`
--
ALTER TABLE `wbcc_projet`
  ADD CONSTRAINT `wbcc_projet_ibfk_1` FOREIGN KEY (`idImmeuble`) REFERENCES `wbcc_immeuble` (`idImmeuble`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wbcc_projet_ibfk_2` FOREIGN KEY (`idApp`) REFERENCES `wbcc_appartement` (`idApp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wbcc_role_sous_module`
--
ALTER TABLE `wbcc_role_sous_module`
  ADD CONSTRAINT `wbcc_role_sous_module_ibfk_1` FOREIGN KEY (`idRoleF`) REFERENCES `wbcc_roles` (`idRole`),
  ADD CONSTRAINT `wbcc_role_sous_module_ibfk_2` FOREIGN KEY (`idSousModuleF`) REFERENCES `wbcc_sous_module` (`idSousModule`);

--
-- Contraintes pour la table `wbcc_solde_conge`
--
ALTER TABLE `wbcc_solde_conge`
  ADD CONSTRAINT `wbcc_solde_conge_ibfk_1` FOREIGN KEY (`idUtilisateurF`) REFERENCES `wbcc_utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `wbcc_sous_module`
--
ALTER TABLE `wbcc_sous_module`
  ADD CONSTRAINT `wbcc_sous_module_ibfk_1` FOREIGN KEY (`idModuleF`) REFERENCES `wbcc_module` (`idModule`);

--
-- Contraintes pour la table `wbcc_user_access`
--
ALTER TABLE `wbcc_user_access`
  ADD CONSTRAINT `wbcc_user_access_ibfk_1` FOREIGN KEY (`idUserF`) REFERENCES `wbcc_utilisateur` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
