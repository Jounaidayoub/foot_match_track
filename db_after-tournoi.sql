SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `football_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `football_db`;

CREATE TABLE `but` (
  `id_but` int(11) NOT NULL,
  `id_match` int(11) NOT NULL,
  `id_team` int(11) NOT NULL,
  `id_buteur` int(11) NOT NULL,
  `id_assisteur` int(11) DEFAULT NULL,
  `minute` int(11) DEFAULT NULL,
  `goal_type` enum('normal','penalty','own-goal','free-kick','header') DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `but` (`id_but`, `id_match`, `id_team`, `id_buteur`, `id_assisteur`, `minute`, `goal_type`) VALUES
(20, 21, 9, 4, 4, 12, 'normal'),
(21, 21, 9, 4, 4, 12, 'normal');

CREATE TABLE `composer` (
  `id_composer` int(11) NOT NULL,
  `id_player` int(11) DEFAULT NULL,
  `id_team` int(11) DEFAULT NULL,
  `id_position` int(11) DEFAULT NULL,
  `d_debut` date DEFAULT NULL,
  `d_fin` date DEFAULT NULL,
  `num_maillot` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `composer` (`id_composer`, `id_player`, `id_team`, `id_position`, `d_debut`, `d_fin`, `num_maillot`) VALUES
(1, 1, 5, 4, '2020-03-01', '2025-02-10', 9),
(2, 2, 6, 1, '2020-03-01', '2025-02-10', 6),
(3, 3, 8, 3, '2020-03-01', '2025-02-10', 1),
(4, 4, 9, 2, '2020-03-01', '2025-02-10', 15),
(5, 5, 10, 1, '2020-03-01', '2025-02-10', 20),
(6, 6, 8, 2, '2020-03-01', '2025-02-10', 23),
(7, 7, 8, 1, '2020-03-01', '2025-02-10', 1),
(8, 8, 8, 3, '2020-03-01', '2025-02-10', 18);

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `alpha2_code` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `goals` (
  `goal_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `assist_player_id` int(11) DEFAULT NULL,
  `goal_time` int(11) NOT NULL,
  `goal_type` enum('normal','penalty','own-goal','free-kick','header') DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `goals` (`goal_id`, `match_id`, `team_id`, `player_id`, `assist_player_id`, `goal_time`, `goal_type`) VALUES
(1, 21, 9, 4, 4, 12, 'normal'),
(2, 21, 9, 4, 4, 2, 'normal'),
(3, 22, 10, 5, 5, 12, 'normal'),
(4, 22, 11, 4, 4, 2, 'normal'),
(5, 22, 10, 5, 5, 12, 'normal');
CREATE TABLE `latest_matches` (
`id_match` int(11)
,`Nom_match` varchar(50)
,`date_match` date
,`time_match` time
,`id_team1` int(11)
,`id_team2` int(11)
,`team1_name` varchar(255)
,`team1_logo` varchar(255)
,`team2_name` varchar(255)
,`team2_logo` varchar(255)
);
CREATE TABLE `match_info` (
`Nom_match` varchar(50)
,`date_match` date
,`team1_name` varchar(255)
,`team1_logo` varchar(255)
,`team2_name` varchar(255)
,`team2_logo` varchar(255)
,`id_match` int(11)
,`id_team1` int(11)
,`id_team2` int(11)
,`butes_team1` bigint(21)
,`butes_team2` bigint(21)
);

CREATE TABLE `match_stats` (
  `stat_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `home_possession` int(11) DEFAULT 50,
  `away_possession` int(11) DEFAULT 50,
  `home_shots` int(11) DEFAULT 0,
  `away_shots` int(11) DEFAULT 0,
  `home_shots_target` int(11) DEFAULT 0,
  `away_shots_target` int(11) DEFAULT 0,
  `home_corners` int(11) DEFAULT 0,
  `away_corners` int(11) DEFAULT 0,
  `home_fouls` int(11) DEFAULT 0,
  `away_fouls` int(11) DEFAULT 0,
  `home_passes` int(11) DEFAULT 0,
  `away_passes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `match_stats` (`stat_id`, `match_id`, `home_possession`, `away_possession`, `home_shots`, `away_shots`, `home_shots_target`, `away_shots_target`, `home_corners`, `away_corners`, `home_fouls`, `away_fouls`, `home_passes`, `away_passes`) VALUES
(2, 21, 50, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 25, 12, 50, 0, 21, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 24, 50, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 26, 50, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 22, 50, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 23, 50, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 27, 50, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
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
  `jersey_number` int(11) DEFAULT NULL,
  `preferred_foot` varchar(10) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `goals` int(11) DEFAULT 0,
  `assists` int(11) DEFAULT 0,
  `appearances` int(11) DEFAULT 0,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `fitness_level` int(11) DEFAULT NULL,
  `medical_conditions` text DEFAULT NULL,
  `contract_start` date DEFAULT NULL,
  `contract_end` date DEFAULT NULL,
  `agent_name` varchar(255) DEFAULT NULL,
  `agent_contact` varchar(255) DEFAULT NULL,
  `release_clause` decimal(15,2) DEFAULT NULL,
  `market_value` decimal(15,2) DEFAULT NULL,
  `contract_notes` text DEFAULT NULL,
  `player_photo` varchar(255) DEFAULT NULL,
  `id_country` int(11) DEFAULT NULL,
  `id_position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `players` (`id`, `first_name`, `last_name`, `birth_date`, `nationality`, `birth_place`, `email`, `phone`, `social_media`, `position`, `secondary_position`, `jersey_number`, `preferred_foot`, `team`, `goals`, `assists`, `appearances`, `height`, `weight`, `bmi`, `fitness_level`, `medical_conditions`, `contract_start`, `contract_end`, `agent_name`, `agent_contact`, `release_clause`, `market_value`, `contract_notes`, `player_photo`, `id_country`, `id_position`) VALUES
(1, 'Karim', 'Benzema', '1987-12-19', 'France', 'Lyon', 'karim@example.com', '+33 123 456 789', 'instagram.com/karimbenzema', '', 'Winger', 9, 'Right', 'Real Madrid', 230, 120, 600, 1.85, 81.50, 23.80, 90, NULL, '2021-07-01', '2025-06-30', 'Agent X', '+33 987 654 321', 100000000.00, 50000000.00, NULL, 'benzema.jpg', 15, 4),
(2, 'Lionel', 'Messi', '1987-06-24', 'Argentina', 'Rosario', 'messi@example.com', '+54 234 567 890', 'instagram.com/leomessi', '', 'Attacking Midfielder', 10, 'Left', 'FC Barcelona', 672, 268, 778, 1.70, 72.00, 24.90, 95, NULL, '2020-07-01', '2023-06-30', 'Agent Y', '+54 876 543 210', 700000000.00, 120000000.00, NULL, 'messi.jpg', 22, 1),
(3, 'Cristiano', 'Ronaldo', '1985-02-05', 'Portugal', 'Madeira', 'cr7@example.com', '+351 345 678 901', 'instagram.com/cristiano', '', 'Winger', 7, 'Right', 'Manchester United', 800, 250, 1100, 1.87, 83.00, 23.70, 98, NULL, '2021-07-01', '2024-06-30', 'Agent Z', '+351 543 210 987', 500000000.00, 150000000.00, NULL, 'ronaldo.jpg', 42, 4),
(4, 'Mohamed', 'El Karti', '1995-06-17', 'Moroccan', 'Casablanca', NULL, NULL, NULL, '', NULL, 10, 'Right', 'Wydad Casablanca', 30, 15, 120, 1.80, 75.00, 23.10, 90, NULL, '2023-07-01', '2026-06-30', 'Agent1', 'agent1@example.com', NULL, 1500000.00, NULL, NULL, 13, 1),
(5, 'Ayoub', 'El Kaabi', '1993-06-26', 'Moroccan', 'Rabat', NULL, NULL, NULL, '', NULL, 9, 'Right', 'FAR Rabat', 45, 10, 110, 1.82, 76.00, 22.90, 88, NULL, '2022-08-01', '2025-07-30', 'Agent2', 'agent2@example.com', NULL, 1800000.00, NULL, NULL, 10, 3),
(6, 'Soufiane', 'Rahimi', '1996-06-02', 'Moroccan', 'Marrakech', NULL, NULL, NULL, '', NULL, 11, 'Left', 'Raja Casablanca', 50, 20, 140, 1.78, 73.00, 23.00, 92, NULL, '2023-01-01', '2026-12-31', 'Agent3', 'agent3@example.com', NULL, 2000000.00, NULL, NULL, 5, 3),
(7, 'Anas', 'Zniti', '1990-10-28', 'Moroccan', 'Fez', NULL, NULL, NULL, '', NULL, 1, 'Right', 'Maghreb Fez', 0, 0, 180, 1.85, 80.00, 23.40, 95, NULL, '2023-07-01', '2026-06-30', 'Agent4', 'agent4@example.com', NULL, 1000000.00, NULL, NULL, 7, 1),
(8, 'Achraf', 'Dari', '1999-05-06', 'Moroccan', 'Casablanca', NULL, NULL, NULL, '', NULL, 5, 'Right', 'RS Berkane', 5, 2, 100, 1.87, 78.00, 22.50, 90, NULL, '2022-07-01', '2026-06-30', 'Agent5', 'agent5@example.com', NULL, 1200000.00, NULL, NULL, 2, 4),
(9, 'jvqjhda', 'hjvads ', '2025-02-25', 'adgj', NULL, NULL, NULL, NULL, 'Midfielder', '', 0, '', '', 0, 0, 0, 0.00, 0.00, 0.00, 0, '', '0000-00-00', '0000-00-00', '', '', 0.00, 0.00, '', NULL, NULL, NULL);

CREATE TABLE `player_position` (
  `id` int(11) NOT NULL,
  `position_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `player_position` (`id`, `position_name`) VALUES
(4, 'Attacker'),
(2, 'Defender'),
(1, 'Goalkeeper'),
(3, 'Midfielder');
CREATE TABLE `score` (
`id_match` int(11)
,`id_team` int(11)
,`butes` bigint(21)
);

CREATE TABLE `staff` (
  `id_staff` int(11) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `d_debut` date DEFAULT NULL,
  `d_fin` date DEFAULT NULL,
  `id_team` int(11) DEFAULT NULL,
  `id_country` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `staff` (`id_staff`, `nom`, `prenom`, `role`, `photo`, `d_debut`, `d_fin`, `id_team`, `id_country`) VALUES
(1, 'Elsiss', 'Hamid', 'Coach', '', '2020-03-01', '2033-02-01', 8, 84),
(2, 'FIE', 'Jamal', 'Assistant Coach', '', '2020-03-01', '2033-02-01', 8, 3),
(3, 'Hmdsi', 'Said', 'Team Manager', '', '2020-03-01', '2033-02-01', 8, 128);

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `founded_year` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `primary_color` varchar(7) DEFAULT NULL,
  `secondary_color` varchar(7) DEFAULT NULL,
  `home_stadium` varchar(255) DEFAULT NULL,
  `stadium_capacity` int(11) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `head_coach` varchar(255) DEFAULT NULL,
  `assistant_coach` varchar(255) DEFAULT NULL,
  `team_manager` varchar(255) DEFAULT NULL,
  `physiotherapist` varchar(255) DEFAULT NULL,
  `history` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `tournaments` (
  `id` int(11) NOT NULL,
  `tournament_name` varchar(255) NOT NULL,
  `format` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('upcoming','active','completed') NOT NULL DEFAULT 'upcoming',
  `num_teams` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tournaments` (`id`, `tournament_name`, `format`, `start_date`, `end_date`, `location`, `status`, `num_teams`, `created_at`) VALUES
(1, 'BOTOLA', 'LEAGUE', '2024-09-01', '2025-07-20', 'MOROCCO', 'active', 20, '2025-03-24 16:56:09');

CREATE TABLE `tournament_teams` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `nom`, `email`, `password`, `role`) VALUES
(1, 'Alice Dupont', 'alice@example.com', '1', 'g'),
(2, 'Thomas Bernard', 'thomas@example.com', 'motdepasse3', 't');

CREATE TABLE `_match` (
  `id_match` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `Nombre_spectateur` int(11) DEFAULT NULL,
  `date_match` date NOT NULL,
  `time_match` time NOT NULL,
  `Nom_match` varchar(50) DEFAULT NULL,
  `id_equipe1` int(11) NOT NULL,
  `id_equipe2` int(11) NOT NULL,
  `staduim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `_match` (`id_match`, `tournament_id`, `Nombre_spectateur`, `date_match`, `time_match`, `Nom_match`, `id_equipe1`, `id_equipe2`, `staduim`) VALUES
(4, 0, 25000, '2025-03-01', '19:00:00', 'Wydad vs Raja', 22, 17, NULL),
(5, 0, 18000, '2025-03-02', '18:30:00', 'FAR Rabat vs RS Berkane', 7, 20, NULL),
(6, 0, 12000, '2025-03-03', '17:00:00', 'Maghreb Fez vs Hassania Agadir', 11, 9, NULL),
(7, 0, 22000, '2025-03-04', '20:00:00', 'FUS Rabat vs Moghreb Tetouan', 8, 12, NULL),
(8, 0, 15000, '2025-03-05', '16:00:00', 'AS Sale vs IR Tanger', 5, 10, NULL),
(10, 0, 2256, '2025-03-28', '11:00:20', NULL, 14, 15, NULL),
(21, 1, 120340, '2025-03-26', '09:10:00', '', 9, 12, 'Des'),
(22, 1, 10000, '2025-03-05', '09:11:00', '', 11, 10, 'Dnasda'),
(23, 1, 213, '2025-03-25', '12:21:00', '', 9, 12, 'asd'),
(24, 1, 124444, '2025-03-14', '11:38:00', 'jasdb jahsdjahsd', 11, 12, 'qwugeqwe'),
(25, 1, 12234, '2025-10-02', '07:01:00', '3123123', 12, 14, '121134'),
(26, 1, 21312, '2025-04-05', '11:05:00', 'qwiadjansdb', 7, 12, 'ajsdvajhdvas'),
(27, 1, 1321323, '2025-03-30', '13:28:00', '', 5, 21, 'moulud'),
(28, 1, 213823, '2025-06-10', '15:26:00', '', 11, 13, 'uavsdjhasd'),
(30, 1, 400000, '2025-04-05', '20:30:00', '', 17, 22, 'asdad');
DROP TABLE IF EXISTS `latest_matches`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `latest_matches`  AS SELECT DISTINCT `m`.`id_match` AS `id_match`, `m`.`Nom_match` AS `Nom_match`, `m`.`date_match` AS `date_match`, `m`.`time_match` AS `time_match`, `t1`.`id` AS `id_team1`, `t2`.`id` AS `id_team2`, `t1`.`team_name` AS `team1_name`, `t1`.`logo_path` AS `team1_logo`, `t2`.`team_name` AS `team2_name`, `t2`.`logo_path` AS `team2_logo` FROM ((`_match` `m` join `teams` `t1` on(`m`.`id_equipe1` = `t1`.`id`)) join `teams` `t2` on(`m`.`id_equipe2` = `t2`.`id`)) WHERE `m`.`date_match` < curdate() OR `m`.`date_match` = curdate() AND `m`.`time_match` < curtime() + interval 3 hour ORDER BY `m`.`date_match` DESC, `m`.`time_match` ASC ;
DROP TABLE IF EXISTS `match_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `match_info`  AS SELECT `l`.`Nom_match` AS `Nom_match`, `l`.`date_match` AS `date_match`, `l`.`team1_name` AS `team1_name`, `l`.`team1_logo` AS `team1_logo`, `l`.`team2_name` AS `team2_name`, `l`.`team2_logo` AS `team2_logo`, `l`.`id_match` AS `id_match`, `l`.`id_team1` AS `id_team1`, `l`.`id_team2` AS `id_team2`, `s1`.`butes` AS `butes_team1`, `s2`.`butes` AS `butes_team2` FROM ((`latest_matches` `l` join `score` `s1`) join `score` `s2` on(`l`.`id_match` = `s1`.`id_match` and `l`.`id_match` = `s2`.`id_match` and `l`.`id_team1` = `s1`.`id_team` and `l`.`id_team2` = `s2`.`id_team`)) ;
DROP TABLE IF EXISTS `score`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `score`  AS SELECT `b`.`id_match` AS `id_match`, `b`.`id_team` AS `id_team`, count(`b`.`id_match`) AS `butes` FROM (`latest_matches` `l` join `but` `b` on(`l`.`id_match` = `b`.`id_match`)) GROUP BY `b`.`id_team`, `b`.`id_match` ;


ALTER TABLE `but`
  ADD PRIMARY KEY (`id_but`),
  ADD KEY `id_match` (`id_match`),
  ADD KEY `id_team` (`id_team`),
  ADD KEY `id_buteur` (`id_buteur`),
  ADD KEY `id_assisteur` (`id_assisteur`);

ALTER TABLE `composer`
  ADD PRIMARY KEY (`id_composer`),
  ADD KEY `id_position` (`id_position`),
  ADD KEY `id_team` (`id_team`),
  ADD KEY `id_player` (`id_player`);

ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alpha2_code` (`alpha2_code`);

ALTER TABLE `goals`
  ADD PRIMARY KEY (`goal_id`),
  ADD KEY `match_id` (`match_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `player_id` (`player_id`),
  ADD KEY `assist_player_id` (`assist_player_id`);

ALTER TABLE `match_stats`
  ADD PRIMARY KEY (`stat_id`),
  ADD KEY `match_id` (`match_id`);

ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_position` (`id_position`),
  ADD KEY `id_country` (`id_country`);

ALTER TABLE `player_position`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `position_name` (`position_name`);

ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`),
  ADD KEY `id_team` (`id_team`),
  ADD KEY `id_country` (`id_country`);

ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tournament_teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_tournament_team` (`tournament_id`,`team_id`),
  ADD KEY `team_id` (`team_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `_match`
  ADD PRIMARY KEY (`id_match`),
  ADD KEY `id_equipe1` (`id_equipe1`),
  ADD KEY `id_equipe2` (`id_equipe2`);


ALTER TABLE `but`
  MODIFY `id_but` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `composer`
  MODIFY `id_composer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

ALTER TABLE `goals`
  MODIFY `goal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `match_stats`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `player_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `staff`
  MODIFY `id_staff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `tournament_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `_match`
  MODIFY `id_match` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;


ALTER TABLE `but`
  ADD CONSTRAINT `but_ibfk_1` FOREIGN KEY (`id_match`) REFERENCES `_match` (`id_match`),
  ADD CONSTRAINT `but_ibfk_2` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `but_ibfk_3` FOREIGN KEY (`id_buteur`) REFERENCES `players` (`id`),
  ADD CONSTRAINT `but_ibfk_4` FOREIGN KEY (`id_assisteur`) REFERENCES `players` (`id`);

ALTER TABLE `composer`
  ADD CONSTRAINT `composer_ibfk_1` FOREIGN KEY (`id_position`) REFERENCES `player_position` (`id`),
  ADD CONSTRAINT `composer_ibfk_2` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `composer_ibfk_3` FOREIGN KEY (`id_player`) REFERENCES `players` (`id`);

ALTER TABLE `goals`
  ADD CONSTRAINT `goals_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `_match` (`id_match`) ON DELETE CASCADE,
  ADD CONSTRAINT `goals_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `goals_ibfk_3` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  ADD CONSTRAINT `goals_ibfk_4` FOREIGN KEY (`assist_player_id`) REFERENCES `players` (`id`);

ALTER TABLE `match_stats`
  ADD CONSTRAINT `match_stats_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `_match` (`id_match`) ON DELETE CASCADE;

ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`id_position`) REFERENCES `player_position` (`id`),
  ADD CONSTRAINT `players_ibfk_2` FOREIGN KEY (`id_country`) REFERENCES `countries` (`id`);

ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`id_country`) REFERENCES `countries` (`id`);

ALTER TABLE `tournament_teams`
  ADD CONSTRAINT `tournament_teams_ibfk_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tournament_teams_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

ALTER TABLE `_match`
  ADD CONSTRAINT `_match_ibfk_1` FOREIGN KEY (`id_equipe1`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `_match_ibfk_2` FOREIGN KEY (`id_equipe2`) REFERENCES `teams` (`id`);
SET FOREIGN_KEY_CHECKS=1;
