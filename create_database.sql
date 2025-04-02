
    -- Create the dataase
    CREATE DATABASE IF NOT EXISTS football_db;

    -- 
CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    founded_year INT NOT NULL,
    country VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    logo_path VARCHAR(255),
    primary_color VARCHAR(7),
    secondary_color VARCHAR(7),
    home_stadium VARCHAR(255),
    stadium_capacity INT,
    website VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    address VARCHAR(255),
    head_coach VARCHAR(255),
    assistant_coach VARCHAR(255),
    team_manager VARCHAR(255),
    physiotherapist VARCHAR(255),
    history TEXT
);

-- 
CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    nationality VARCHAR(255) NOT NULL,
    birth_place VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    social_media VARCHAR(255),
    position VARCHAR(255) NOT NULL,
    secondary_position VARCHAR(255),
    jersey_number INT,
    preferred_foot VARCHAR(10),
    team VARCHAR(255),
    goals INT DEFAULT 0,
    assists INT DEFAULT 0,
    appearances INT DEFAULT 0,
    height DECIMAL(5, 2),
    weight DECIMAL(5, 2),
    bmi DECIMAL(5, 2),
    fitness_level INT,
    medical_conditions TEXT,
    contract_start DATE,
    contract_end DATE,
    agent_name VARCHAR(255),
    agent_contact VARCHAR(255),
    release_clause DECIMAL(15, 2),
    market_value DECIMAL(15, 2),
    contract_notes TEXT,
    player_photo VARCHAR(255)
);

CREATE TABLE _match (
    id_match INT PRIMARY KEY AUTO_INCREMENT,
    Nombre_spectateur INT DEFAULT NULL,
    date_match DATE NOT NULL,
    time_match TIME NOT NULL,
    Nom_match VARCHAR(50) DEFAULT NULL,
    id_equipe1 INT NOT NULL,
    id_equipe2 INT NOT NULL,
    tournament_id INT ,
    staduim varchar(255),
    FOREIGN KEY (id_equipe1) REFERENCES teams(id),
    FOREIGN KEY (id_equipe2) REFERENCES teams(id),
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE

);


-- but
create table but(
    id_but int primary key AUTO_INCREMENT,
    id_match int NOT NULL,
    id_team int NOT NULL,
    id_buteur int NOT NULL,
    id_assisteur int,
    minute int,
    foreign key(id_match) references _match(id_match),
    foreign key(id_team) references teams(id),
    foreign key(id_buteur) references players(id),
    foreign key(id_assisteur) references players(id)
);


create table users(
 id INT primary key auto_increment, 
nom varchar(50),
email varchar(100),
password varchar(100),
role char(1),
  tournament_id INT ,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE
);


CREATE TABLE countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_name VARCHAR(100) NOT NULL,
    alpha2_code CHAR(2) NOT NULL UNIQUE
);


-- staff
create table staff(
id_staff int primary key auto_increment,
nom varchar(20),
prenom varchar(20),
role varchar(30),
photo varchar(100),
d_debut date,
d_fin date,
id_team int,
id_country int,
foreign key(id_team) references teams(id),
foreign key(id_country) references countries(id)
);


CREATE TABLE player_position (
    id INT AUTO_INCREMENT PRIMARY KEY,
    position_name VARCHAR(50) NOT NULL UNIQUE
);


alter table players add column id_position int;
alter table players add FOREIGN key (id_position) references player_position(id);


ALTER TABLE `players` ADD `id_country` INT AFTER `player_photo`; 
ALTER TABLE `players` ADD FOREIGN KEY(id_country) REFERENCES countries(id);





INSERT INTO countries (name, alpha2_code) VALUES
    ('Afghanistan', 'AF'),
    ('Albania', 'AL'),
    ('Algeria', 'DZ'),
    ('Andorra', 'AD'),
    ('Angola', 'AO'),
    ('Argentina', 'AR'),
    ('Armenia', 'AM'),
    ('Australia', 'AU'),
    ('Austria', 'AT'),
    ('Azerbaijan', 'AZ'),
    ('Bahrain', 'BH'),
    ('Bangladesh', 'BD'),
    ('Belarus', 'BY'),
    ('Belgium', 'BE'),
    ('Benin', 'BJ'),
    ('Bhutan', 'BT'),
    ('Bolivia', 'BO'),
    ('Brazil', 'BR'),
    ('Bulgaria', 'BG'),
    ('Burkina Faso', 'BF'),
    ('Burundi', 'BI'),
    ('Cambodia', 'KH'),
    ('Cameroon', 'CM'),
    ('Canada', 'CA'),
    ('Chad', 'TD'),
    ('Chile', 'CL'),
    ('China', 'CN'),
    ('Colombia', 'CO'),
    ('Comoros', 'KM'),
    ('Costa Rica', 'CR'),
    ('Croatia', 'HR'),
    ('Cuba', 'CU'),
    ('Cyprus', 'CY'),
    ('Czech Republic', 'CZ'),
    ('Denmark', 'DK'),
    ('Djibouti', 'DJ'),
    ('Dominica', 'DM'),
    ('Dominican Republic', 'DO'),
    ('Ecuador', 'EC'),
    ('Egypt', 'EG'),
    ('El Salvador', 'SV'),
    ('Estonia', 'EE'),
    ('Ethiopia', 'ET'),
    ('Fiji', 'FJ'),
    ('Finland', 'FI'),
    ('France', 'FR'),
    ('Gabon', 'GA'),
    ('Gambia', 'GM'),
    ('Georgia', 'GE'),
    ('Germany', 'DE'),
    ('Ghana', 'GH'),
    ('Greece', 'GR'),
    ('Guatemala', 'GT'),
    ('Guinea', 'GN'),
    ('Haiti', 'HT'),
    ('Honduras', 'HN'),
    ('Hungary', 'HU'),
    ('Iceland', 'IS'),
    ('India', 'IN'),
    ('Indonesia', 'ID'),
    ('Iran', 'IR'),
    ('Iraq', 'IQ'),
    ('Ireland', 'IE'),
    ('Israel', 'IL'),
    ('Italy', 'IT'),
    ('Jamaica', 'JM'),
    ('Japan', 'JP'),
    ('Jordan', 'JO'),
    ('Kazakhstan', 'KZ'),
    ('Kenya', 'KE'),
    ('Kuwait', 'KW'),
    ('Latvia', 'LV'),
    ('Lebanon', 'LB'),
    ('Libya', 'LY'),
    ('Lithuania', 'LT'),
    ('Luxembourg', 'LU'),
    ('Madagascar', 'MG'),
    ('Malaysia', 'MY'),
    ('Mali', 'ML'),
    ('Malta', 'MT'),
    ('Mexico', 'MX'),
    ('Monaco', 'MC'),
    ('Mongolia', 'MN'),
    ('Morocco', 'MA'),
    ('Mozambique', 'MZ'),
    ('Namibia', 'NA'),
    ('Nepal', 'NP'),
    ('Netherlands', 'NL'),
    ('New Zealand', 'NZ'),
    ('Niger', 'NE'),
    ('Nigeria', 'NG'),
    ('Norway', 'NO'),
    ('Oman', 'OM'),
    ('Pakistan', 'PK'),
    ('Panama', 'PA'),
    ('Paraguay', 'PY'),
    ('Peru', 'PE'),
    ('Philippines', 'PH'),
    ('Poland', 'PL'),
    ('Portugal', 'PT'),
    ('Qatar', 'QA'),
    ('Romania', 'RO'),
    ('Russia', 'RU'),
    ('Rwanda', 'RW'),
    ('Saudi Arabia', 'SA'),
    ('Senegal', 'SN'),
    ('Serbia', 'RS'),
    ('Singapore', 'SG'),
    ('Slovakia', 'SK'),
    ('Slovenia', 'SI'),
    ('South Africa', 'ZA'),
    ('South Korea', 'KR'),
    ('Spain', 'ES'),
    ('Sri Lanka', 'LK'),
    ('Sudan', 'SD'),
    ('Sweden', 'SE'),
    ('Switzerland', 'CH'),
    ('Syria', 'SY'),
    ('Tanzania', 'TZ'),
    ('Thailand', 'TH'),
    ('Togo', 'TG'),
    ('Tunisia', 'TN'),
    ('Turkey', 'TR'),
    ('Uganda', 'UG'),
    ('Ukraine', 'UA'),
    ('United Arab Emirates', 'AE'),
    ('United Kingdom', 'GB'),
    ('United States', 'US'),
    ('Uruguay', 'UY'),
    ('Uzbekistan', 'UZ'),
    ('Venezuela', 'VE'),
    ('Vietnam', 'VN'),
    ('Yemen', 'YE'),
    ('Zambia', 'ZM'),
    ('Zimbabwe', 'ZW');

INSERT INTO player_position (position_name) VALUES
    ('Goalkeeper'),
    ('Defender'),
    ('Midfielder'),
    ('Attacker');


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

--
INSERT INTO `players` (`id`, `first_name`, `last_name`, `birth_date`, `nationality`, `birth_place`, `email`, `phone`, `social_media`, `secondary_position`, `jersey_number`, `preferred_foot`, `team`, `goals`, `assists`, `appearances`, `height`, `weight`, `bmi`, `fitness_level`, `medical_conditions`, `contract_start`, `contract_end`, `agent_name`, `agent_contact`, `release_clause`, `market_value`, `contract_notes`, `player_photo`, `id_country`, `id_position`) VALUES
(1, 'Karim', 'Benzema', '1987-12-19', 'France', 'Lyon', 'karim@example.com', '+33 123 456 789', 'instagram.com/karimbenzema', 'Winger', 9, 'Right', 'Real Madrid', 230, 120, 600, 1.85, 81.50, 23.80, 90, NULL, '2021-07-01', '2025-06-30', 'Agent X', '+33 987 654 321', 100000000.00, 50000000.00, NULL, 'benzema.jpg', 15, 4),
(2, 'Lionel', 'Messi', '1987-06-24', 'Argentina', 'Rosario', 'messi@example.com', '+54 234 567 890', 'instagram.com/leomessi', 'Attacking Midfielder', 10, 'Left', 'FC Barcelona', 672, 268, 778, 1.70, 72.00, 24.90, 95, NULL, '2020-07-01', '2023-06-30', 'Agent Y', '+54 876 543 210', 700000000.00, 120000000.00, NULL, 'messi.jpg', 22, 1),
(3, 'Cristiano', 'Ronaldo', '1985-02-05', 'Portugal', 'Madeira', 'cr7@example.com', '+351 345 678 901', 'instagram.com/cristiano', 'Winger', 7, 'Right', 'Manchester United', 800, 250, 1100, 1.87, 83.00, 23.70, 98, NULL, '2021-07-01', '2024-06-30', 'Agent Z', '+351 543 210 987', 500000000.00, 150000000.00, NULL, 'ronaldo.jpg', 42, 4),
(4, 'Mohamed', 'El Karti', '1995-06-17', 'Moroccan', 'Casablanca', NULL, NULL, NULL, NULL, 10, 'Right', 'Wydad Casablanca', 30, 15, 120, 1.80, 75.00, 23.10, 90, NULL, '2023-07-01', '2026-06-30', 'Agent1', 'agent1@example.com', NULL, 1500000.00, NULL, NULL, 13, 1),
(5, 'Ayoub', 'El Kaabi', '1993-06-26', 'Moroccan', 'Rabat', NULL, NULL, NULL, NULL, 9, 'Right', 'FAR Rabat', 45, 10, 110, 1.82, 76.00, 22.90, 88, NULL, '2022-08-01', '2025-07-30', 'Agent2', 'agent2@example.com', NULL, 1800000.00, NULL, NULL, 10, 3),
(6, 'Soufiane', 'Rahimi', '1996-06-02', 'Moroccan', 'Marrakech', NULL, NULL, NULL, NULL, 11, 'Left', 'Raja Casablanca', 50, 20, 140, 1.78, 73.00, 23.00, 92, NULL, '2023-01-01', '2026-12-31', 'Agent3', 'agent3@example.com', NULL, 2000000.00, NULL, NULL, 5, 3),
(7, 'Anas', 'Zniti', '1990-10-28', 'Moroccan', 'Fez', NULL, NULL, NULL, NULL, 1, 'Right', 'Maghreb Fez', 0, 0, 180, 1.85, 80.00, 23.40, 95, NULL, '2023-07-01', '2026-06-30', 'Agent4', 'agent4@example.com', NULL, 1000000.00, NULL, NULL, 7, 1),
(8, 'Achraf', 'Dari', '1999-05-06', 'Moroccan', 'Casablanca', NULL, NULL, NULL, NULL, 5, 'Right', 'RS Berkane', 5, 2, 100, 1.87, 78.00, 22.50, 90, NULL, '2022-07-01', '2026-06-30', 'Agent5', 'agent5@example.com', NULL, 1200000.00, NULL, NULL, 2, 4);


INSERT INTO `_match` (`id_match`, `Nombre_spectateur`, `date_match`, `time_match`, `Nom_match`, `id_equipe1`, `id_equipe2`) VALUES
(4, 25000, '2025-03-01', '19:00:00', 'Wydad vs Raja', 22, 17),
(5, 18000, '2025-03-02', '18:30:00', 'FAR Rabat vs RS Berkane', 7, 20),
(6, 12000, '2025-03-03', '17:00:00', 'Maghreb Fez vs Hassania Agadir', 11, 9),
(7, 22000, '2025-03-04', '20:00:00', 'FUS Rabat vs Moghreb Tetouan', 8, 12),
(8, 15000, '2025-03-05', '16:00:00', 'AS Sale vs IR Tanger', 5, 10),
(9, 2392, '2025-03-15', '15:00:50', 'Derbi El Hassania', 9, 6),
(10, 2256, '2025-03-28', '11:00:20', NULL, 14, 15);




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

insert into users values(1 ,'Alice Dupont' ,'alice@example.com' ,'1' ,'g');
insert into users values (2 ,'Thomas Bernard' ,'thomas@example.com' ,'motdepasse3' ,'t');
insert into users values (2 ,'Marie Dupont' ,'marie@marie.com' ,'marie' ,'u');


insert into staff values(1, "Elsiss", "Hamid", "Coach",'', '2020-03-01', '2033-02-01',8, 84);
insert into staff values(2, "FIE", "Jamal", "Assistant Coach",'', '2020-03-01', '2033-02-01',8, 3);
insert into staff values(3, "Hmdsi", "Said", "Team Manager", '', '2020-03-01', '2033-02-01',8, 128);


create table composer(
id_composer int primary key auto_increment,
id_player int,
id_team int,
id_position int ,
d_debut date,
d_fin date,
num_maillot int,
foreign key(id_position) references player_position(id),
foreign key(id_team) references teams(id),
foreign key(id_player) references players(id)
);


insert into composer(id_player, id_team,id_position, d_debut,d_fin,num_maillot)
values(1,5,4,'2020-03-01','2025-02-10' ,9),
(2,6,1,'2020-03-01','2025-02-10' ,6),
(3,8,3,'2020-03-01','2025-02-10' ,1),
(4,9,2,'2020-03-01','2025-02-10' ,15),
(5,10,1,'2020-03-01','2025-02-10' ,20),
(6,8,2,'2020-03-01','2025-02-10' ,23),
(7,8,1,'2020-03-01','2025-02-10' ,1),
(8,8,3,'2020-03-01','2025-02-10' ,18);





-- Create tournaments table
CREATE TABLE IF NOT EXISTS tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tournament_name VARCHAR(255) NOT NULL,
    format VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    location VARCHAR(255) NOT NULL,
    status ENUM('upcoming', 'active', 'completed') NOT NULL DEFAULT 'upcoming',
    num_teams INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create tournament_teams table (to link tournaments with teams)
CREATE TABLE IF NOT EXISTS tournament_teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tournament_id INT NOT NULL,
    team_id INT NOT NULL,
    group_name VARCHAR(50), -- For group stage tournaments
    position INT, -- For seeding or final position
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    UNIQUE KEY unique_tournament_team (tournament_id, team_id)
);


CREATE TABLE refree (
  id INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(25) NOT NULL,
  prenom VARCHAR(25) NOT NULL,
  date_de_naissance DATE NOT NULL,
  status VARCHAR(20) NOT NULL,
  PRIMARY KEY (id)
);
INSERT INTO refree (id, nom, prenom, date_de_naissance, status) VALUES
(3, 'Jiyed', 'Redouane', '1979-04-09', 'active'),
(4, 'test2', 'test2', '2008-07-24', 'actif'),
(5, 'arbitre1', 'arbitre1', '1990-06-13', 'actif'),
(6, 'arbitre1', 'arbitre1', '1980-06-18', 'actif'),
(7, 'arbitre1', 'arbitre1', '1976-02-10', 'retraite');

CREATE TABLE stadium (
  id INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(25) NOT NULL,
  ville INT NOT NULL,
  date_de_creation DATE NOT NULL,
  status VARCHAR(20) NOT NULL,
  id_team INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_team) REFERENCES teams(id)
);
INSERT INTO stadium (id, nom, ville, date_de_creation, status, id_team) VALUES
(1, 'Moulay Abdellah', 0, '1985-01-23', 'actif', 7);

-- alter table users add column tournament_id int;
-- alter table users add FOREIGN key (tournament_id) references tournaments(id);

-- alter table _match add column tournament_id int;
-- alter table _match add FOREIGN key (tournament_id) references tournaments(id);

-- alter table _match add column staduim varchar(255);