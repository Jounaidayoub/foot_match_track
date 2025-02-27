
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

