
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
    FOREIGN KEY (id_equipe1) REFERENCES teams(id),
    FOREIGN KEY (id_equipe2) REFERENCES teams(id)
);


INSERT INTO teams (team_name, founded_year, country, city, logo_path, primary_color, secondary_color, home_stadium, stadium_capacity, website, email, phone, address, head_coach, assistant_coach, team_manager, physiotherapist, history)  
VALUES  
('Real Madrid', 1902, 'Spain', 'Madrid', 'real_madrid_logo.png', '#FFFFFF', '#000000', 'Santiago Bernabéu', 81044, 'https://www.realmadrid.com', 'contact@realmadrid.com', '+34 123 456 789', 'Madrid, Spain', 'Carlo Ancelotti', 'Davide Ancelotti', 'José Ángel Sánchez', 'Dr. Juan Muro', 'One of the most successful clubs in history'),  

('FC Barcelona', 1899, 'Spain', 'Barcelona', 'barcelona_logo.png', '#A50044', '#004D98', 'Camp Nou', 99354, 'https://www.fcbarcelona.com', 'contact@fcbarcelona.com', '+34 987 654 321', 'Barcelona, Spain', 'Xavi Hernandez', 'Óscar Hernández', 'Mateu Alemany', 'Dr. Ricard Pruna', 'A club with a rich footballing culture'),  

('Manchester United', 1878, 'England', 'Manchester', 'manutd_logo.png', '#DA291C', '#FFE500', 'Old Trafford', 74879, 'https://www.manutd.com', 'contact@manutd.com', '+44 161 868 8000', 'Manchester, UK', 'Erik ten Hag', 'Mitchell van der Gaag', 'John Murtough', 'Dr. Steve McNally', 'A club with a deep Premier League history');

INSERT INTO players (first_name, last_name, birth_date, nationality, birth_place, email, phone, social_media, position, secondary_position, jersey_number, preferred_foot, team, goals, assists, appearances, height, weight, bmi, fitness_level, medical_conditions, contract_start, contract_end, agent_name, agent_contact, release_clause, market_value, contract_notes, player_photo)  
VALUES  
('Karim', 'Benzema', '1987-12-19', 'France', 'Lyon', 'karim@example.com', '+33 123 456 789', 'instagram.com/karimbenzema', 'Striker', 'Winger', 9, 'Right', 'Real Madrid', 230, 120, 600, 1.85, 81.5, 23.8, 90, NULL, '2021-07-01', '2025-06-30', 'Agent X', '+33 987 654 321', 100000000, 50000000, NULL, 'benzema.jpg'),  

('Lionel', 'Messi', '1987-06-24', 'Argentina', 'Rosario', 'messi@example.com', '+54 234 567 890', 'instagram.com/leomessi', 'Forward', 'Attacking Midfielder', 10, 'Left', 'FC Barcelona', 672, 268, 778, 1.70, 72.0, 24.9, 95, NULL, '2020-07-01', '2023-06-30', 'Agent Y', '+54 876 543 210', 700000000, 120000000, NULL, 'messi.jpg'),  

('Cristiano', 'Ronaldo', '1985-02-05', 'Portugal', 'Madeira', 'cr7@example.com', '+351 345 678 901', 'instagram.com/cristiano', 'Forward', 'Winger', 7, 'Right', 'Manchester United', 800, 250, 1100, 1.87, 83.0, 23.7, 98, NULL, '2021-07-01', '2024-06-30', 'Agent Z', '+351 543 210 987', 500000000, 150000000, NULL, 'ronaldo.jpg');


INSERT INTO _match (Nombre_spectateur, date_match, time_match, Nom_match, id_equipe1, id_equipe2)  
VALUES  
(80000, '2025-04-10', '20:00:00', 'El Clásico', 1, 2),  
(75000, '2025-04-15', '19:45:00', 'Champions League Semi-Final', 2, 3),  
(70000, '2025-04-20', '21:00:00', 'Premier League Clash', 3, 1);


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

INSERT INTO but (id_match, id_team, id_buteur, id_assisteur, minute) VALUES
(1, 2, 1, 2, 12),  -- Goal in match 1, scored by player 5 (team 2), assisted by player 8 in the 12th minute
(1, 1, 3, NULL, 27), -- Goal in match 1, scored by player 3 (team 1), no assist in the 27th minute
(2, 3, 2, 2, 34),  -- Goal in match 2, scored by player 7 (team 4), assisted by player 2 in the 34th minute
(2, 2, 1, NULL, 45), 
(3, 1, 1, 3, 50), 
(3, 3, 2, NULL, 73)


create table users(
 id INT primary key auto_increment, 
nom varchar(50),
email varchar(100),
password varchar(100),
role char(1)
);

insert into users values(1 ,'Alice Dupont' ,'alice@example.com' ,'1' ,'g');
insert into users values (2 ,'Thomas Bernard' ,'thomas@example.com' ,'motdepasse3' ,'t');


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
insert into staff values(1, "Elsiss", "Hamid", "Coach",'', '2020-03-01', '2033-02-01',8);
insert into staff values(2, "FIE", "Jamal", "Assistant Coach",'', '2020-03-01', '2033-02-01',8);
insert into staff values(3, "Hmdsi", "Said", "Team Manager", '', '2020-03-01', '2033-02-01',8);


CREATE TABLE countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    alpha2_code CHAR(2) NOT NULL UNIQUE
);

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



ALTER TABLE `players` ADD `id_country` INT AFTER `player_photo`; 
ALTER TABLE `players` ADD FOREIGN KEY(id_country) REFERENCES countries(id);

CREATE TABLE player_position (
    id INT AUTO_INCREMENT PRIMARY KEY,
    position_name VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO player_position (name) VALUES
    ('Goalkeeper'),
    ('Defender'),
    ('Midfielder'),
    ('Attacker');

alter table players add column id_position int;
alter table players add FOREIGN key (id_position) references player_position(id);