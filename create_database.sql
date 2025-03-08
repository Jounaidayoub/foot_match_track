
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
  id_but INT PRIMARY KEY AUTO_INCREMENT,
min_but int, 
id_buteur INT NOT NULL,
id_assisteur INT,
foreign key(id_buteur) references players(id),
foreign key(id_assisteur) references players(id)
);

INSERT INTO but (min_but, id_buteur, id_assisteur) VALUES
(12, 1, 3),  
(27, 3, NULL), 
(43, 2, 1), 
(55, 1, NULL)


