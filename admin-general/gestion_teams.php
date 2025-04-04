<?php
session_start();
require_once '../includes/db.php';


$sql = "SELECT id, tournament_name FROM tournaments";
$result = $bd->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Player</title>
    <link rel="stylesheet" href="../css/adminplayer.css">
    <style>
        
/* Menu horizontal */
.main-menu {
    display: flex;
    justify-content: space-between; /* Distribution des éléments à gauche et à droite */
    align-items: center;
    background-color: var(--bg-darker);
    padding: 15px 20px;  /* Ajoute du padding autour du menu */
    position: fixed;  /* Fixe le menu en haut de la page */
    top: 0;  /* Colle le menu au haut de la page */
    left: 0; /* Colle le menu au bord gauche */
    right: 0; /* Colle le menu au bord droit */
    z-index: 1000;  /* Place le menu au-dessus de tout autre contenu */
    margin: 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);  /* Ombre pour un effet de profondeur */
}

/* Conteneur pour l'icône du menu (à gauche) */
.main-menu .logo {
    display: flex;
    align-items: center;
    color: var(--text-light);
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    text-decoration: none; /* Supprime le soulignement */
    color: inherit; /* Conserve la couleur du texte */
}

/* Menu principal (horizontal) */
.main-menu ul {
    display: flex;
    list-style-type: none;
    padding: 0;
    margin: 0;
    width: 100%;
    justify-content: center;  /* Centrer les éléments du menu */
}

.main-menu ul li {
    position: relative;
    padding: 12px 20px;
    margin: 0 15px;
    cursor: pointer;
    color: var(--text-light);
    font-weight: 500;
    text-transform: capitalize;
    transition: color 0.3s, background-color 0.3s;
}

/* Survol du menu */
.main-menu ul li:hover {
    color: var(--primary-color);
}

/* Menu "Player" avec sous-menu */
#player-menu {
    color: var(--text-muted);
}

#player-menu:hover {
    color: var(--primary-color);
}

/* Sous-menu pour "Player" */
#player-menu > ul {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: var(--bg-darker);
    border-radius: 4px;
    min-width: 200px;
    margin-top: 5px;
    z-index: 10;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s 0.3s, opacity 0.3s ease;
}

#player-menu:hover > ul {
    visibility: visible;
    opacity: 1;
    transition-delay: 0s;
}

/* Menu "Management" avec sous-menu */
#management-menu {
    color: var(--text-muted);
}

#management-menu:hover {
    color: var(--primary-color);
}

/* Sous-menu pour "Management" */
#management-menu > ul {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: var(--bg-darker);
    border-radius: 4px;
    min-width: 200px;
    margin-top: 5px;
    z-index: 10;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s 0.3s, opacity 0.3s ease;
}

#management-menu:hover > ul {
    visibility: visible;
    opacity: 1;
    transition-delay: 0s;
}

/* Menu "Tournament Admin" */
#tournament-admin-menu {
    color: var(--text-muted);
}

#tournament-admin-menu:hover {
    color: var(--text-muted); /* Pas de changement de couleur au survol */
    background-color: transparent; /* Pas de fond au survol */
}

#tournament-admin-menu.active {
    color: var(--text-muted); /* Pas de changement de couleur même lorsqu'il est actif */
}

/* Style pour le bouton de déconnexion */
#logout-btn {
    padding: 10px 20px;
    background-color: var(--primary-color);
    color: var(--bg-darker);
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    text-transform: capitalize;
    transition: background-color 0.3s;
}

#logout-btn:hover {
    background-color: var(--primary-hover);
}

#logout-btn a {
    text-decoration: none; /* Supprime le soulignement */
    color: inherit; /* Conserve la couleur du texte */
    display: inline-block; /* Assure un bon alignement */
}

/* Styles pour le lien de sous-menu */
.main-menu li a {
    color: var(--text-muted);
    text-decoration: none;
}

.main-menu li a:hover {
    color: var(--primary-color);
}

/* Responsivité pour petit écran */
@media (max-width: 768px) {
    .main-menu ul {
        flex-direction: column;
        align-items: center;
    }

    .main-menu ul li {
        margin-bottom: 10px;
        padding: 10px;
    }

    #player-menu ul,
    #management-menu ul {
        position: static;
        display: block;
        box-shadow: none;
    }

    #player-menu > ul,
    #management-menu > ul {
        margin-top: 0;
    }
}

    </style>
</head>
<body>
<div class="main-menu">
    <a href="index.php" class="logo"> <!-- Ajout de la balise <a> -->
        <img src="../includes/icon.png" alt="logo">
        <span>OneFootball</span>
    </a>

    <ul>
        <li id="player-menu">
            Player
            <ul>
                <li><a href="gestion_joueur.php">Add Player</a></li>
                <li><a href="gestion_supp_player.php">Delete Player</a></li>
                <li><a href="gestion_modification_joueur.php">Edit Player</a></li>
            </ul>
        </li>
        <li id="management-menu">
            Management
            <ul>
                <li><a href="gestion_stade.php">Stadium</a></li>
                <li><a href="gestion_arbitre.php">Referee</a></li>
                <li><a href="gestion_teams.php">Teams</a></li>
                <li><a href="gestion_staff.php">Staffs</a></li>
            </ul>
        </li>
        <li id="tournament-admin-menu">
            <a href="gestion_admin_tournoi.php">  Tournament Admin </a>
        </li>
    </ul>

    <!-- Bouton de déconnexion -->
    <button id="logout-btn"> <a href="deconnexion.php">Logout</a></button>
</div>


    <div class="container">
        <!--  -->
        <br><br>
        <br><br>
        <div class="header">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h1>Add A New Team</h1>
        </div>
        
        
            <div class="tabs">
                <div class="tab active" data-tab="personal">Team Information</div>
                <div class="tab" data-tab="football">Edit Team Information</div>
                <div class="tab" data-tab="delete">Delete</div>
            </div>
            
            <!-- Personal Info Tab -->
            <div class="tab-content active" id="personal">
    <form action="add_team.php" method="POST">
        <div class="form-section">
            <h2>Personal Information</h2>

            <!-- Nom de l'équipe et pays -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="team_name" class="required">Team Name</label>
                        <input type="text" id="team_name" name="team_name" placeholder="Enter team name" required>
                    </div>
                    <div class="form-group">
                        <label for="country_name" class="required">Country</label>
                        <select name="nationality1" id="nationality1" required>
                                    <option value="">Select a nationality</option>
                                    <?php
                                    // Exécution de la requête pour récupérer les pays
                                    $query = "SELECT country_name FROM countries";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    // Affichage des options
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["country_name"] . "'>" . htmlspecialchars($row["country_name"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                </div>

                <!-- Ville et logo -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="city_name" class="required">City</label>
                        <input type="text" id="city_name" name="city_name" placeholder="Enter city name" required>
                    </div>
                    <div class="form-group">
                        <label for="logo_path" class="required">Logo Path</label>
                        <input type="text" id="logo_path" name="logo_path" placeholder="Enter logo path" required>
                    </div>
                </div>

                <!-- Année de création, Coach principal et autres informations -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="founded_year" class="required">Founded Year</label>
                        <input type="date" id="founded_year" name="founded_year" placeholder="Enter founding year" required>
                    </div>

                    <div class="form-group">
                        <label for="head_coach" class="required">Head Coach</label>
                        <select name="staff_id1" id="staff_id">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT id_staff, nom, prenom FROM staff WHERE role='head coach'";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id_staff"] . "'>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                </div>

                <!-- Description et autres informations -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="primary_color" class="required">Primary Color</label>
                        <input type="text" id="primary_color" name="primary_color" placeholder="Enter primary color (e.g., #FF0000)" required>
                    </div>
                    <div class="form-group">
                        <label for="secondary_color" class="required">Secondary Color</label>
                        <input type="text" id="secondary_color" name="secondary_color" placeholder="Enter secondary color (e.g., #00FF00)" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="home_stadium" class="required">Home Stadium</label>
                        <select name="home_stadium" id="home_stadium" required>
                                    <option value="">Select stadium</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT nom FROM stadium ";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["nom"] . "'>" . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                                    </select>
                    </div>
                    <div class="form-group">
                        <label for="stadium_capacity" class="required">Stadium Capacity</label>
                        <input type="text" id="stadium_capacity" name="stadium_capacity" placeholder="Enter stadium capacity" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="website" class="required">Website</label>
                        <input type="text" id="website" name="website" placeholder="Enter website URL" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="required">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter email address" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="required">Phone</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="required">Address</label>
                        <input type="text" id="address" name="address" placeholder="Enter team address" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="assistant_coach" class="required">Assistant Coach</label>
                        <select name="staff_id2" id="staff_id2">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT id_staff, nom, prenom FROM staff WHERE role='assistant coach'";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id_staff"] . "'>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="team_manager" class="required">Team Manager</label>
                        <select name="staff_id3" id="staff_id3">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT id_staff, nom, prenom FROM staff WHERE role='Manager'";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id_staff"] . "'>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="physiotherapist" class="required">Physiotherapist</label>
                        <select name="staff_id4" id="staff_id4">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT id_staff, nom, prenom FROM staff WHERE role='physiotherapist'";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id_staff"] . "'>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="history" class="required">History</label>
                        <textarea id="history" name="history" placeholder="Enter team history" required></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" id="personal-next">Add</button>
            </form>
        </div>
    </div>

            <!-- Football Info Tab -->
            <div class="tab-content" id="football">
                <form action="update_team.php" method="POST">
                    <div class="form-section">
                        <h2>Personal Information</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="team">Current teams</label>
                                <select name="team1" id="team1">
                                    <option value="">Select teams</option>
                                    <?php
                                    $query = "SELECT id, team_name FROM teams";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["team_name"]) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                    <div class="form-group">
                        <label for="team_name" class="required">Team Name</label>
                        <input type="text" id="team_name1" name="team_name1" placeholder="Enter team name" required>
                    </div>
                    <div class="form-group">
                        <label for="country_name" class="required">Country</label>
                        <select name="nationality2" id="nationality2" required>
                                    <option value="">Select a nationality</option>
                                    <?php
                                    // Exécution de la requête pour récupérer les pays
                                    $query = "SELECT country_name FROM countries";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    // Affichage des options
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["country_name"] . "'>" . htmlspecialchars($row["country_name"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                </div>

                <!-- Ville et logo -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="city_name" class="required">City</label>
                        <input type="text" id="city_name1" name="city_name1" placeholder="Enter city name" required>
                    </div>
                    <div class="form-group">
                        <label for="logo_path" class="required">Logo Path</label>
                        <input type="text" id="logo_path1" name="logo_path1" placeholder="Enter logo path" required>
                    </div>
                </div>

                <!-- Année de création, Coach principal et autres informations -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="founded_year" class="required">Founded Year</label>
                        <input type="date" id="founded_year1" name="founded_year1" placeholder="Enter founding year" required>
                    </div>

                    <div class="form-group">
                        <label for="head_coach" class="required">Head Coach</label>
                        <select name="staff_id9" id="staff_id9">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT id_staff, nom, prenom FROM staff WHERE role='head coach'";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id_staff"] . "'>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                </div>

                <!-- Description et autres informations -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="primary_color" class="required">Primary Color</label>
                        <input type="text" id="primary_color1" name="primary_color1" placeholder="Enter primary color (e.g., #FF0000)" required>
                    </div>
                    <div class="form-group">
                        <label for="secondary_color" class="required">Secondary Color</label>
                        <input type="text" id="secondary_color1" name="secondary_color1" placeholder="Enter secondary color (e.g., #00FF00)" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="home_stadium" class="required">Home Stadium</label>
                        <select name="home_stadium1" id="home_stadium1" required>
                                    <option value="">Select stadium</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT nom FROM stadium ";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["nom"] . "'>" . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                                    </select>
                    </div>
                    <div class="form-group">
                        <label for="stadium_capacity" class="required">Stadium Capacity</label>
                        <input type="text" id="stadium_capacity1" name="stadium_capacity1" placeholder="Enter stadium capacity" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="website" class="required">Website</label>
                        <input type="text" id="website1" name="website1" placeholder="Enter website URL" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="required">Email</label>
                        <input type="email" id="email1" name="email1" placeholder="Enter email address" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="required">Phone</label>
                        <input type="tel" id="phone1" name="phone1" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="required">Address</label>
                        <input type="text" id="address1" name="address1" placeholder="Enter team address" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="assistant_coach" class="required">Assistant Coach</label>
                        <select name="staff_id6" id="staff_id6">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT id_staff, nom, prenom FROM staff WHERE role='assistant coach'";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id_staff"] . "'>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="team_manager" class="required">Team Manager</label>
                        <select name="staff_id7" id="staff_id7">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT id_staff, nom, prenom FROM staff WHERE role='Manager'";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id_staff"] . "'>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="physiotherapist" class="required">Physiotherapist</label>
                        <select name="staff_id8" id="staff_id8">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT id_staff, nom, prenom FROM staff WHERE role='physiotherapist'";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id_staff"] . "'>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="history" class="required">History</label>
                        <textarea id="history1" name="history1" placeholder="Enter team history" required></textarea>
                    </div>
                </div>
                        <div class="actions">
                            <button type="submit" class="btn btn-primary" id="personal-next">Edit</button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="tab-content" id="delete">
                <div class="form-section">
                    <form action="delete_team.php" method="POST">
                        <h2>Delete A Team</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="team">Select Team</label>
                                <select name="team2" id="team2">
                                    <option value="">Select teams</option>
                                    <?php
                                    $query = "SELECT id, team_name FROM teams";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["team_name"]) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="actions">
                            <button type="submit" class="btn btn-primary" id="personal-next">Delete</button>
                        </div>
                    </div>


                    </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>                           
    <script>
        

        document.addEventListener('DOMContentLoaded', function() {
            const teamSelect = document.getElementById('team1');

            teamSelect.addEventListener('change', function() {
                const teamId = this.value;

                if (teamId) {
                    fetch(`get_team.php?team_id=${teamId}`)
                        .then(response => {
                            // Check if response is valid JSON
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                console.error('Error from server:', data.error);
                            } else {
                                // Populate the form with the fetched data
                                document.getElementById('team_name1').value = data.team_name || '';
                                document.getElementById('nationality2').value = data.country|| '';
                                document.getElementById('city_name1').value = data.city || '';
                                document.getElementById('logo_path1').value = data.logo_path || '';
                                if (data.founded_year) {
                                    // Check if the date is in the correct format (YYYY-MM-DD)
                                    const foundedDate = new Date(data.founded_year);
                                    if (!isNaN(foundedDate.getTime())) {  // If it's a valid date
                                        document.getElementById('founded_year1').value = foundedDate.toISOString().split('T')[0];  // Convert to YYYY-MM-DD
                                    } else {
                                        document.getElementById('founded_year1').value = '';  // Empty if invalid date
                                    }
                                } else {
                                    document.getElementById('founded_year1').value = '';  // Empty if no date
                                }
                                document.getElementById('staff_id9').value = data.head_coach || '';
                                document.getElementById('primary_color1').value = data.primary_color || '';
                                document.getElementById('secondary_color1').value = data.secondary_color || '';
                                document.getElementById('home_stadium1').value = data.home_stadium || '';
                                document.getElementById('stadium_capacity1').value = data.stadium_capacity || '';
                                document.getElementById('website1').value = data.website || '';
                                document.getElementById('email1').value = data.email || '';
                                document.getElementById('phone1').value = data.phone || '';
                                document.getElementById('address1').value = data.address || '';
                                document.getElementById('staff_id6').value = data.assistant_coach || '';
                                document.getElementById('staff_id7').value = data.team_manager || '';
                                document.getElementById('staff_id8').value = data.physiotherapist || '';
                                document.getElementById('history1').value = data.history || '';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching team data:', error);
                        });
                }
            });
        });

        // Lorsque le DOM est complètement chargé
        document.addEventListener("DOMContentLoaded", function() {
            // Sélectionner tous les onglets
            const tabs = document.querySelectorAll(".tab");
            // Sélectionner tous les contenus des onglets
            const tabContents = document.querySelectorAll(".tab-content");

            // Ajouter un gestionnaire d'événements pour chaque onglet
            tabs.forEach(function(tab) {
                tab.addEventListener("click", function() {
                    const targetTab = tab.getAttribute("data-tab");

                    // Désactiver tous les onglets et leur contenu
                    tabs.forEach(function(t) {
                        t.classList.remove("active");
                    });
                    tabContents.forEach(function(content) {
                        content.classList.remove("active");
                    });

                    // Activer l'onglet cliqué et le contenu associé
                    tab.classList.add("active");
                    document.getElementById(targetTab).classList.add("active");
                });
            });
        });
    </script>
    
    
</body>
</html>