-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 01, 2025 at 10:30 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `football_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `but`
--

DROP TABLE IF EXISTS `but`;
CREATE TABLE IF NOT EXISTS `but` (
  `id_but` int NOT NULL AUTO_INCREMENT,
  `id_match` int NOT NULL,
  `id_team` int NOT NULL,
  `id_buteur` int NOT NULL,
  `id_assisteur` int DEFAULT NULL,
  `minute` int DEFAULT NULL,
  PRIMARY KEY (`id_but`),
  KEY `id_match` (`id_match`),
  KEY `id_team` (`id_team`),
  KEY `id_buteur` (`id_buteur`),
  KEY `id_assisteur` (`id_assisteur`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `but`
--

INSERT INTO `but` (`id_but`, `id_match`, `id_team`, `id_buteur`, `id_assisteur`, `minute`) VALUES
(1, 1, 2, 1, 2, 12),
(2, 1, 1, 3, NULL, 27),
(3, 2, 3, 2, 2, 34),
(4, 2, 2, 1, NULL, 45),
(5, 3, 1, 1, 3, 50),
(6, 1, 2, 2, NULL, 73),
(7, 4, 22, 1, 3, 12),
(8, 4, 17, 3, NULL, 34),
(9, 5, 7, 2, NULL, 45),
(10, 5, 20, 5, 2, 67),
(11, 3, 11, 4, NULL, 80),
(12, 7, 8, 3, 1, 15),
(13, 5, 7, 2, 3, 90),
(14, 7, 12, 7, 5, 77),
(15, 6, 9, 1, 6, 60),
(16, 6, 9, 6, NULL, 66),
(17, 6, 11, 4, NULL, 93);

-- --------------------------------------------------------

--
-- Table structure for table `composer`
--

DROP TABLE IF EXISTS `composer`;
CREATE TABLE IF NOT EXISTS `composer` (
  `id_composer` int NOT NULL AUTO_INCREMENT,
  `id_player` int DEFAULT NULL,
  `id_team` int DEFAULT NULL,
  `id_position` int DEFAULT NULL,
  `d_debut` date DEFAULT NULL,
  `d_fin` date DEFAULT NULL,
  `num_maillot` int DEFAULT NULL,
  PRIMARY KEY (`id_composer`),
  KEY `id_position` (`id_position`),
  KEY `id_team` (`id_team`),
  KEY `id_player` (`id_player`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `composer`
--

INSERT INTO `composer` (`id_composer`, `id_player`, `id_team`, `id_position`, `d_debut`, `d_fin`, `num_maillot`) VALUES
(1, 1, 5, 4, '2020-03-01', '2025-02-10', 9),
(2, 2, 6, 1, '2020-03-01', '2025-02-10', 6),
(3, 3, 8, 3, '2020-03-01', '2025-02-10', 1),
(4, 4, 9, 2, '2020-03-01', '2025-02-10', 15),
(5, 5, 10, 1, '2020-03-01', '2025-02-10', 20),
(6, 6, 8, 2, '2020-03-01', '2025-02-10', 23),
(7, 7, 8, 1, '2020-03-01', '2025-02-10', 1),
(8, 8, 8, 3, '2020-03-01', '2025-02-10', 18);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `country_name` varchar(100) NOT NULL,
  `alpha2_code` char(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alpha2_code` (`alpha2_code`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`, `alpha2_code`) VALUES
(1, 'Afghanistan', 'AF'),
(2, 'Albania', 'AL'),
(3, 'Algeria', 'DZ'),
(4, 'Andorra', 'AD'),
(5, 'Angola', 'AO'),
(6, 'Argentina', 'AR'),
(7, 'Armenia', 'AM'),
(8, 'Australia', 'AU'),
(9, 'Austria', 'AT'),
(10, 'Azerbaijan', 'AZ'),
(11, 'Bahrain', 'BH'),
(12, 'Bangladesh', 'BD'),
(13, 'Belarus', 'BY'),
(14, 'Belgium', 'BE'),
(15, 'Benin', 'BJ'),
(16, 'Bhutan', 'BT'),
(17, 'Bolivia', 'BO'),
(18, 'Brazil', 'BR'),
(19, 'Bulgaria', 'BG'),
(20, 'Burkina Faso', 'BF'),
(21, 'Burundi', 'BI'),
(22, 'Cambodia', 'KH'),
(23, 'Cameroon', 'CM'),
(24, 'Canada', 'CA'),
(25, 'Chad', 'TD'),
(26, 'Chile', 'CL'),
(27, 'China', 'CN'),
(28, 'Colombia', 'CO'),
(29, 'Comoros', 'KM'),
(30, 'Costa Rica', 'CR'),
(31, 'Croatia', 'HR'),
(32, 'Cuba', 'CU'),
(33, 'Cyprus', 'CY'),
(34, 'Czech Republic', 'CZ'),
(35, 'Denmark', 'DK'),
(36, 'Djibouti', 'DJ'),
(37, 'Dominica', 'DM'),
(38, 'Dominican Republic', 'DO'),
(39, 'Ecuador', 'EC'),
(40, 'Egypt', 'EG'),
(41, 'El Salvador', 'SV'),
(42, 'Estonia', 'EE'),
(43, 'Ethiopia', 'ET'),
(44, 'Fiji', 'FJ'),
(45, 'Finland', 'FI'),
(46, 'France', 'FR'),
(47, 'Gabon', 'GA'),
(48, 'Gambia', 'GM'),
(49, 'Georgia', 'GE'),
(50, 'Germany', 'DE'),
(51, 'Ghana', 'GH'),
(52, 'Greece', 'GR'),
(53, 'Guatemala', 'GT'),
(54, 'Guinea', 'GN'),
(55, 'Haiti', 'HT'),
(56, 'Honduras', 'HN'),
(57, 'Hungary', 'HU'),
(58, 'Iceland', 'IS'),
(59, 'India', 'IN'),
(60, 'Indonesia', 'ID'),
(61, 'Iran', 'IR'),
(62, 'Iraq', 'IQ'),
(63, 'Ireland', 'IE'),
(64, 'Israel', 'IL'),
(65, 'Italy', 'IT'),
(66, 'Jamaica', 'JM'),
(67, 'Japan', 'JP'),
(68, 'Jordan', 'JO'),
(69, 'Kazakhstan', 'KZ'),
(70, 'Kenya', 'KE'),
(71, 'Kuwait', 'KW'),
(72, 'Latvia', 'LV'),
(73, 'Lebanon', 'LB'),
(74, 'Libya', 'LY'),
(75, 'Lithuania', 'LT'),
(76, 'Luxembourg', 'LU'),
(77, 'Madagascar', 'MG'),
(78, 'Malaysia', 'MY'),
(79, 'Mali', 'ML'),
(80, 'Malta', 'MT'),
(81, 'Mexico', 'MX'),
(82, 'Monaco', 'MC'),
(83, 'Mongolia', 'MN'),
(84, 'Morocco', 'MA'),
(85, 'Mozambique', 'MZ'),
(86, 'Namibia', 'NA'),
(87, 'Nepal', 'NP'),
(88, 'Netherlands', 'NL'),
(89, 'New Zealand', 'NZ'),
(90, 'Niger', 'NE'),
(91, 'Nigeria', 'NG'),
(92, 'Norway', 'NO'),
(93, 'Oman', 'OM'),
(94, 'Pakistan', 'PK'),
(95, 'Panama', 'PA'),
(96, 'Paraguay', 'PY'),
(97, 'Peru', 'PE'),
(98, 'Philippines', 'PH'),
(99, 'Poland', 'PL'),
(100, 'Portugal', 'PT'),
(101, 'Qatar', 'QA'),
(102, 'Romania', 'RO'),
(103, 'Russia', 'RU'),
(104, 'Rwanda', 'RW'),
(105, 'Saudi Arabia', 'SA'),
(106, 'Senegal', 'SN'),
(107, 'Serbia', 'RS'),
(108, 'Singapore', 'SG'),
(109, 'Slovakia', 'SK'),
(110, 'Slovenia', 'SI'),
(111, 'South Africa', 'ZA'),
(112, 'South Korea', 'KR'),
(113, 'Spain', 'ES'),
(114, 'Sri Lanka', 'LK'),
(115, 'Sudan', 'SD'),
(116, 'Sweden', 'SE'),
(117, 'Switzerland', 'CH'),
(118, 'Syria', 'SY'),
(119, 'Tanzania', 'TZ'),
(120, 'Thailand', 'TH'),
(121, 'Togo', 'TG'),
(122, 'Tunisia', 'TN'),
(123, 'Turkey', 'TR'),
(124, 'Uganda', 'UG'),
(125, 'Ukraine', 'UA'),
(126, 'United Arab Emirates', 'AE'),
(127, 'United Kingdom', 'GB'),
(128, 'United States', 'US'),
(129, 'Uruguay', 'UY'),
(130, 'Uzbekistan', 'UZ'),
(131, 'Venezuela', 'VE'),
(132, 'Vietnam', 'VN'),
(133, 'Yemen', 'YE'),
(134, 'Zambia', 'ZM'),
(135, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Stand-in structure for view `latest_matches`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `latest_matches`;
CREATE TABLE IF NOT EXISTS `latest_matches` (
`date_match` date
,`id_match` int
,`id_team1` int
,`id_team2` int
,`Nom_match` varchar(50)
,`team1_logo` varchar(255)
,`team1_name` varchar(255)
,`team2_logo` varchar(255)
,`team2_name` varchar(255)
,`time_match` time
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `match_info`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `match_info`;
CREATE TABLE IF NOT EXISTS `match_info` (
`butes_team1` bigint
,`butes_team2` bigint
,`date_match` date
,`id_match` int
,`id_team1` int
,`id_team2` int
,`Nom_match` varchar(50)
,`team1_logo` varchar(255)
,`team1_name` varchar(255)
,`team2_logo` varchar(255)
,`team2_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `birth_place` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `social_media` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `secondary_position` varchar(255) DEFAULT NULL,
  `jersey_number` int DEFAULT NULL,
  `preferred_foot` varchar(10) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `goals` int DEFAULT '0',
  `assists` int DEFAULT '0',
  `appearances` int DEFAULT '0',
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `fitness_level` int DEFAULT NULL,
  `medical_conditions` text,
  `contract_start` date DEFAULT NULL,
  `contract_end` date DEFAULT NULL,
  `agent_name` varchar(255) DEFAULT NULL,
  `agent_contact` varchar(255) DEFAULT NULL,
  `release_clause` decimal(15,2) DEFAULT NULL,
  `market_value` decimal(15,2) DEFAULT NULL,
  `contract_notes` text,
  `player_photo` varchar(255) DEFAULT NULL,
  `id_country` int DEFAULT NULL,
  `id_position` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_position` (`id_position`),
  KEY `id_country` (`id_country`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `first_name`, `last_name`, `birth_date`, `nationality`, `birth_place`, `email`, `phone`, `social_media`, `position`, `secondary_position`, `jersey_number`, `preferred_foot`, `team`, `goals`, `assists`, `appearances`, `height`, `weight`, `bmi`, `fitness_level`, `medical_conditions`, `contract_start`, `contract_end`, `agent_name`, `agent_contact`, `release_clause`, `market_value`, `contract_notes`, `player_photo`, `id_country`, `id_position`) VALUES
(1, 'Karim', 'Benzema', '1987-12-19', 'France', 'Lyon', 'karim@example.com', '+33 123 456 789', 'instagram.com/karimbenzema', '', 'Winger', 9, 'Right', 'Real Madrid', 230, 120, 600, 1.85, 81.50, 23.80, 90, NULL, '2021-07-01', '2025-06-30', 'Agent X', '+33 987 654 321', 100000000.00, 50000000.00, NULL, 'benzema.jpg', 15, 4),
(2, 'Lionel', 'Messi', '1987-06-24', 'Argentina', 'Rosario', 'messi@example.com', '+54 234 567 890', 'instagram.com/leomessi', '', 'Attacking Midfielder', 10, 'Left', 'FC Barcelona', 672, 268, 778, 1.70, 72.00, 24.90, 95, NULL, '2020-07-01', '2023-06-30', 'Agent Y', '+54 876 543 210', 700000000.00, 120000000.00, NULL, 'messi.jpg', 22, 1),
(3, 'Cristiano', 'Ronaldo', '1985-02-05', 'Portugal', 'Madeira', 'cr7@example.com', '+351 345 678 901', 'instagram.com/cristiano', '', 'Winger', 7, 'Right', 'Manchester United', 800, 250, 1100, 1.87, 83.00, 23.70, 98, NULL, '2021-07-01', '2024-06-30', 'Agent Z', '+351 543 210 987', 500000000.00, 150000000.00, NULL, 'ronaldo.jpg', 42, 4),
(4, 'Mohamed', 'El Karti', '1995-06-17', 'Moroccan', 'Casablanca', NULL, NULL, NULL, '', NULL, 10, 'Right', 'Wydad Casablanca', 30, 15, 120, 1.80, 75.00, 23.10, 90, NULL, '2023-07-01', '2026-06-30', 'Agent1', 'agent1@example.com', NULL, 1500000.00, NULL, NULL, 13, 1),
(5, 'Ayoub', 'El Kaabi', '1993-06-26', 'Moroccan', 'Rabat', NULL, NULL, NULL, '', NULL, 9, 'Right', 'FAR Rabat', 45, 10, 110, 1.82, 76.00, 22.90, 88, NULL, '2022-08-01', '2025-07-30', 'Agent2', 'agent2@example.com', NULL, 1800000.00, NULL, NULL, 10, 3),
(6, 'Soufiane', 'Rahimi', '1996-06-02', 'Moroccan', 'Marrakech', NULL, NULL, NULL, '', NULL, 11, 'Left', 'Raja Casablanca', 50, 20, 140, 1.78, 73.00, 23.00, 92, NULL, '2023-01-01', '2026-12-31', 'Agent3', 'agent3@example.com', NULL, 2000000.00, NULL, NULL, 5, 3),
(7, 'Anas', 'Zniti', '1990-10-28', 'Moroccan', 'Fez', NULL, NULL, NULL, '', NULL, 1, 'Right', 'Maghreb Fez', 0, 0, 180, 1.85, 80.00, 23.40, 95, NULL, '2023-07-01', '2026-06-30', 'Agent4', 'agent4@example.com', NULL, 1000000.00, NULL, NULL, 7, 1),
(8, 'Achraf', 'Dari', '1999-05-06', 'Moroccan', 'Casablanca', NULL, NULL, NULL, '', NULL, 5, 'Right', 'RS Berkane', 5, 2, 100, 1.87, 78.00, 22.50, 90, NULL, '2022-07-01', '2026-06-30', 'Agent5', 'agent5@example.com', NULL, 1200000.00, NULL, NULL, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `player_position`
--

DROP TABLE IF EXISTS `player_position`;
CREATE TABLE IF NOT EXISTS `player_position` (
  `id` int NOT NULL AUTO_INCREMENT,
  `position_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `position_name` (`position_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `player_position`
--

INSERT INTO `player_position` (`id`, `position_name`) VALUES
(1, 'Goalkeeper'),
(2, 'Defender'),
(3, 'Midfielder'),
(4, 'Attacker');

-- --------------------------------------------------------

--
-- Table structure for table `refree`
--

DROP TABLE IF EXISTS `refree`;
CREATE TABLE IF NOT EXISTS `refree` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `date_de_naissance` date NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `refree`
--

INSERT INTO `refree` (`id`, `nom`, `prenom`, `date_de_naissance`, `status`) VALUES
(3, 'Jiyed', 'Redouane', '1979-04-09', 'active'),
(4, 'test2', 'test2', '2008-07-24', 'actif'),
(5, 'arbitre1', 'arbitre1', '1990-06-13', 'actif'),
(6, 'arbitre1', 'arbitre1', '1980-06-18', 'actif'),
(7, 'arbitre1', 'arbitre1', '1976-02-10', 'retraite');

-- --------------------------------------------------------

--
-- Stand-in structure for view `score`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
`butes` bigint
,`id_match` int
,`id_team` int
);

-- --------------------------------------------------------

--
-- Table structure for table `stadium`
--

DROP TABLE IF EXISTS `stadium`;
CREATE TABLE IF NOT EXISTS `stadium` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `ville` int NOT NULL,
  `date_de_creation` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `id_team` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stadium`
--

INSERT INTO `stadium` (`id`, `nom`, `ville`, `date_de_creation`, `status`, `id_team`) VALUES
(1, 'Moulay Abdellah', 0, '1985-01-23', 'actif', 7);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `id_staff` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `id_team` int DEFAULT NULL,
  `id_country` int DEFAULT NULL,
  PRIMARY KEY (`id_staff`),
  KEY `id_team` (`id_team`),
  KEY `id_country` (`id_country`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id_staff`, `nom`, `prenom`, `role`, `photo`, `id_team`, `id_country`) VALUES
(1, 'Elsiss', 'Hamid', 'Coach', '', 8, 84),
(2, 'FIE', 'Jamal', 'Assistant Coach', '', 8, 3),
(3, 'Hmdsi', 'Said', 'Team Manager', '', 8, 128),
(4, 'Simons', 'Xavi', 'assistant', '&amp;quot;C:\\Users\\ilias\\Pictures\\w15.jpg&amp;quot;', 16, 10),
(5, 'Test1', 'Test1', 'assistant', '&quot;C:\\Users\\ilias\\Pictures\\w15.jpg&quot;', 22, 60);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_name` varchar(255) NOT NULL,
  `founded_year` int NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `primary_color` varchar(7) DEFAULT NULL,
  `secondary_color` varchar(7) DEFAULT NULL,
  `home_stadium` varchar(255) DEFAULT NULL,
  `stadium_capacity` int DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `head_coach` varchar(255) DEFAULT NULL,
  `assistant_coach` varchar(255) DEFAULT NULL,
  `team_manager` varchar(255) DEFAULT NULL,
  `physiotherapist` varchar(255) DEFAULT NULL,
  `history` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `team_name`, `founded_year`, `country`, `city`, `logo_path`, `primary_color`, `secondary_color`, `home_stadium`, `stadium_capacity`, `website`, `email`, `phone`, `address`, `head_coach`, `assistant_coach`, `team_manager`, `physiotherapist`, `history`) VALUES
(5, 'AS Sale', 0, 'Morocco', 'Sale', 'teams_logos/AS_Sale.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Difaa Hassani El Jadidi', 0, 'Morocco', 'El Jadida', 'teams_logos/Difaa_Hassani_El_Jadidi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'FAR Rabat', 0, 'Morocco', 'Rabat', 'teams_logos/FAR_Rabat.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'FUS Rabat', 0, 'Morocco', 'Rabat', 'teams_logos/FUS_Rabat.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Hassania Agadir', 0, 'Morocco', 'Agadir', 'teams_logos/Hassania_Agadir.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'IR Tanger', 0, 'Morocco', 'Tanger', 'teams_logos/IR_Tanger.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Maghreb Fez', 0, 'Morocco', 'Fez', 'teams_logos/Maghreb_Fez.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Moghreb Tetouan', 0, 'Morocco', 'Tetouan', 'teams_logos/Moghreb_Tetouan.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Chabab Mohammedia', 0, 'Morocco', 'Mohammedia', 'teams_logos/mohammedia.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Mouloudia Oujda', 0, 'Morocco', 'Oujda', 'teams_logos/Mouloudia_Oujda.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Olympic Club Safi', 0, 'Morocco', 'Safi', 'teams_logos/Olympic_Club_Safi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Racing de Casablanca', 0, 'Morocco', 'Casablanca', 'teams_logos/Racing_de_Casablanca.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Raja Casablanca', 0, 'Morocco', 'Casablanca', 'teams_logos/Raja_Casablanca.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Rapide Oued Zem', 0, 'Morocco', 'Oued Zem', 'teams_logos/Rapide_Oued_Zem.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Riadi Salmi', 0, 'Morocco', 'Salmi', 'teams_logos/Riadi_Salmi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'RS Berkane', 0, 'Morocco', 'Berkane', 'teams_logos/RS_Berkane.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'US Touarga', 0, 'Morocco', 'Touarga', 'teams_logos/US_Touarga.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Wydad Casablanca', 0, 'Morocco', 'Casablanca', 'teams_logos/Wydad_Casablanca.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Youssoufia Berrechid', 0, 'Morocco', 'Berrechid', 'teams_logos/Youssoufia_Berrechid.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Nehda', 2025, 'Morocco', 'Mohammedia', '', '#00ffff', '#2563eb', 'Eljf', 23521, 'http://www.sldkqj.com', 'lqkjsdf@jle', '3292325', 'lksjqfmlksdjfk qsmflkqs flkqjds fls', 'abc', 'abc', 'abc', 'abc', 'abc abc abcv vabcabcabcabcabcabcabcabcabcabcabcabcabcabcabcabc'),
(25, 'Difaa Hassani El Jadidi', 2000, 'Morocco', 'Jedida', 'teams_logos/Difaa_Hassani_El_Jadidi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

DROP TABLE IF EXISTS `tournaments`;
CREATE TABLE IF NOT EXISTS `tournaments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tournament_name` varchar(255) NOT NULL,
  `format` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('upcoming','active','completed') NOT NULL DEFAULT 'upcoming',
  `num_teams` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`id`, `tournament_name`, `format`, `start_date`, `end_date`, `location`, `status`, `num_teams`, `created_at`) VALUES
(1, 'Botola Pro\r\n', 'Les points', '2025-04-01', '2025-04-30', 'Morocco', 'upcoming', 16, '2025-04-01 10:37:40'),
(2, 'coupe du trone', 'Elimination', '2025-04-09', '2025-04-18', 'Morocco', 'upcoming', 16, '2025-04-01 22:02:10');

-- --------------------------------------------------------

--
-- Table structure for table `tournament_teams`
--

DROP TABLE IF EXISTS `tournament_teams`;
CREATE TABLE IF NOT EXISTS `tournament_teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tournament_id` int NOT NULL,
  `team_id` int NOT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  `position` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_tournament_team` (`tournament_id`,`team_id`),
  KEY `team_id` (`team_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(25) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tournament_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `tournament_id`) VALUES
(1, 'Alice Dupont', '', 'alice@example.com', '1', 'g', 0),
(2, 'Thomas Bernard', '', 'thomas@example.com', 'motdepasse3', 't', 0),
(3, 'Marie Dupont', '', 'marie@marie.com', 'marie', 'u', 0),
(4, 'haqiq', 'iliass', 'iliass.haqiq@gmail.com', '$2y$10$2z4jvSiL5YdT.yf/8pL6wO5w1OFp6FGTKwmDIz8c9zu4eYxbc9s3y', 'admintournoi', 1),
(5, 'Test1', 'Test1', 'e@example.com', '$2y$10$3dckLi1TITPndkexJLS4BOy67xNPdCkWth/tbpDj.tUReikjTQbRe', 'admintournoi', 2);

-- --------------------------------------------------------

--
-- Table structure for table `_match`
--

DROP TABLE IF EXISTS `_match`;
CREATE TABLE IF NOT EXISTS `_match` (
  `id_match` int NOT NULL AUTO_INCREMENT,
  `Nombre_spectateur` int DEFAULT NULL,
  `date_match` date NOT NULL,
  `time_match` time NOT NULL,
  `Nom_match` varchar(50) DEFAULT NULL,
  `id_equipe1` int NOT NULL,
  `id_equipe2` int NOT NULL,
  PRIMARY KEY (`id_match`),
  KEY `id_equipe1` (`id_equipe1`),
  KEY `id_equipe2` (`id_equipe2`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `_match`
--

INSERT INTO `_match` (`id_match`, `Nombre_spectateur`, `date_match`, `time_match`, `Nom_match`, `id_equipe1`, `id_equipe2`) VALUES
(4, 25000, '2025-03-01', '19:00:00', 'Wydad vs Raja', 22, 17),
(5, 18000, '2025-03-02', '18:30:00', 'FAR Rabat vs RS Berkane', 7, 20),
(6, 12000, '2025-03-03', '17:00:00', 'Maghreb Fez vs Hassania Agadir', 11, 9),
(7, 22000, '2025-03-04', '20:00:00', 'FUS Rabat vs Moghreb Tetouan', 8, 12),
(8, 15000, '2025-03-05', '16:00:00', 'AS Sale vs IR Tanger', 5, 10),
(9, 2392, '2025-03-15', '15:00:50', 'Derbi El Hassania', 9, 6),
(10, 2256, '2025-03-28', '11:00:20', NULL, 14, 15);

-- --------------------------------------------------------

--
-- Structure for view `latest_matches`
--
DROP TABLE IF EXISTS `latest_matches`;

DROP VIEW IF EXISTS `latest_matches`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `latest_matches`  AS SELECT DISTINCT `m`.`id_match` AS `id_match`, `m`.`Nom_match` AS `Nom_match`, `m`.`date_match` AS `date_match`, `m`.`time_match` AS `time_match`, `t1`.`id` AS `id_team1`, `t2`.`id` AS `id_team2`, `t1`.`team_name` AS `team1_name`, `t1`.`logo_path` AS `team1_logo`, `t2`.`team_name` AS `team2_name`, `t2`.`logo_path` AS `team2_logo` FROM ((`_match` `m` join `teams` `t1` on((`m`.`id_equipe1` = `t1`.`id`))) join `teams` `t2` on((`m`.`id_equipe2` = `t2`.`id`))) WHERE ((`m`.`date_match` < curdate()) OR ((`m`.`date_match` = curdate()) AND (`m`.`time_match` < (curtime() + interval 3 hour)))) ORDER BY `m`.`date_match` DESC, `m`.`time_match` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `match_info`
--
DROP TABLE IF EXISTS `match_info`;

DROP VIEW IF EXISTS `match_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `match_info`  AS SELECT `l`.`Nom_match` AS `Nom_match`, `l`.`date_match` AS `date_match`, `l`.`team1_name` AS `team1_name`, `l`.`team1_logo` AS `team1_logo`, `l`.`team2_name` AS `team2_name`, `l`.`team2_logo` AS `team2_logo`, `l`.`id_match` AS `id_match`, `l`.`id_team1` AS `id_team1`, `l`.`id_team2` AS `id_team2`, `s1`.`butes` AS `butes_team1`, `s2`.`butes` AS `butes_team2` FROM ((`latest_matches` `l` join `score` `s1`) join `score` `s2` on(((`l`.`id_match` = `s1`.`id_match`) and (`l`.`id_match` = `s2`.`id_match`) and (`l`.`id_team1` = `s1`.`id_team`) and (`l`.`id_team2` = `s2`.`id_team`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `score`
--
DROP TABLE IF EXISTS `score`;

DROP VIEW IF EXISTS `score`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `score`  AS SELECT `b`.`id_match` AS `id_match`, `b`.`id_team` AS `id_team`, count(`b`.`id_match`) AS `butes` FROM (`latest_matches` `l` join `but` `b` on((`l`.`id_match` = `b`.`id_match`))) GROUP BY `b`.`id_team`, `b`.`id_match` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
