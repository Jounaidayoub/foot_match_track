<?php
session_start();
require_once '../includes/db.php';

$sql = "SELECT id, team_name FROM teams";
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
        <br>
        <br><br><br>
        <div class="header">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h1>Tournament Management</h1>
        </div>
        
        
            <div class="tabs">
                <div class="tab active" data-tab="personal">Tournament information</div>
                <div class="tab" data-tab="football">Edit Tournament</div>
                <div class = "tab" data-tab="delete">Delete Tournament</div>
            </div>
            
            <!-- Personal Info Tab -->
            <div class="tab-content active" id="personal">
                <form action="add_tournoi.php" method="POST">
                    <div class="form-section">
                    <h2>Personal Information</h2>
                        
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="tournament_name" class="required"> Name</label>
                                <input type="text" id="tournament_name" name="tournament_name" placeholder="Enter tournament name" required>
                            </div>
                                
                            <div class="form-group">
                                    <label for="format" class="required">format</label>
                                    <select name="format" id="format">
                                        <option value="">Select format</option>
                                        <option value="elimination">Elimination</option>
                                        <option value="Lespoints">Points</option>
                                    </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                            <label for="sdate" class="required">Starting date</label>
                                <input type="date" id="sdate" name="sdate" required>
                            </div>
                            <div class="form-group">
                            <label for="edate" class="required">Ending date</label>
                                <input type="date" id="edate" name="edate" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                            <label for="location" class="required">Location</label>
                                <input type="text" id="Location" name="Location" placeholder="Enter the location of the tournament" required>
                            </div>
                            <div class="form-group">
                                <label for="numteams" class="required">Number of teams</label>
                                <input type="text" id="numteams" name="numteams" placeholder="Enter number of teams" required>
                            </div>
                        </div>
                        
                    </div>
                    <button type="submit" class="btn btn-primary" id="personal-next">Add</button>  
                </form>
            </div>
            
            <!-- Football Info Tab -->
            <div class="tab-content" id="football">
                <form action="update_tournoi.php" method="POST">
                    <div class="form-section">
                        <h2>Edit Tournament information</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="team">Select Tournament</label>
                                <select name="staff_id1" id="staff_id">
                                    <option value="">Select tournament</option>
                                    <?php
                                    $query = "SELECT id, tournament_name FROM tournaments";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["tournament_name"]) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="tournament_name" class="required"> Name</label>
                                <input type="text" id="tournament_name1" name="tournament_name1" placeholder="Enter tournament name" required>
                            </div>
                                
                            <div class="form-group">
                                    <label for="format" class="required">format</label>
                                    <select name="format1" id="format1">
                                        <option value="">Select format</option>
                                        <option value="elimination">Elimination</option>
                                        <option value="Lespoints">Points</option>
                                    </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                            <label for="sdate" class="required">Starting date</label>
                                <input type="date" id="sdate1" name="sdate1" required>
                            </div>
                            <div class="form-group">
                            <label for="edate" class="required">Ending date</label>
                                <input type="date" id="edate1" name="edate1" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                            <label for="location" class="required">Location</label>
                                <input type="text" id="Location1" name="Location1" placeholder="Enter the location of the tournament" required>
                            </div>
                            <div class="form-group">
                                <label for="numteams" class="required">Number of teams</label>
                                <input type="text" id="numteams1" name="numteams1" placeholder="Enter number of teams" required>
                            </div>
                        </div>
                        
                        <div class="actions">
                            <button type="submit" class="btn btn-primary" id="personal-next">Edit</button>
                        </div>

                    
                </form>
            </div>
            <!-- Delete Refree Tab -->
            <div class="tab-content" id="delete">
                <form action="delete_tournoi.php" method="POST">
                <div class="form-section">
                        <h2>Delete A Tournament</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="team">Select Tournament</label>
                                <select name="staff_id1" id="staff_id">
                                    <option value="">Select tournament</option>
                                    <?php
                                    $query = "SELECT id, tournament_name FROM tournaments";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["tournament_name"]) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="actions">
                            <button type="submit" class="btn btn-primary" id="personal-next">Delete</button>
                        </div>
                </form>
            </div>
        </div>
    </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Charger les données du tournoi lorsque l'utilisateur sélectionne un tournoi
        document.getElementById('staff_id').addEventListener('change', function() {
            var tournamentId = this.value;

            if (tournamentId) {
                fetch('get_tournoi.php?id=' + tournamentId)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.error) {
                            // Remplir les champs du formulaire avec les données du tournoi
                            document.getElementById('tournament_name1').value = data.tournament_name;
                            document.getElementById('format1').value = data.format;
                            document.getElementById('sdate1').value = data.start_date;
                            document.getElementById('edate1').value = data.end_date;
                            document.getElementById('Location1').value = data.location;
                            document.getElementById('numteams1').value = data.num_teams;
                        } else {
                            alert(data.error);
                        }
                    })
                    .catch(error => console.log('Error:', error));
            }
        });


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

            // S'assurer que le premier onglet et son contenu sont actifs
            if (tabs.length > 0 && tabContents.length > 0) {
                tabs[0].classList.add("active");
                tabContents[0].classList.add("active");
            }
        });

    </script>
    
</body>
</html>