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
    <title>Add New Staff</title>
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
        <br><br><br><br>
        <div class="header">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h1>Staff Management</h1>
        </div>
        
        
            <div class="tabs">
                <div class="tab active" data-tab="personal">Stadium information</div>
                <div class="tab" data-tab="football">Edit Stadium</div>
                <div class="tab" data-tab="list">List of Stadium</div>
            </div>
            
            <!-- Personal Info Tab -->
            <div class="tab-content active" id="personal">
                <form action="add_stadium.php" method="POST">
                    <div class="form-section">
                    <h2>Personal Information</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="required">Name</label>
                                <input type="text" id="name" name="name" placeholder="Enter a name" required>
                            </div>
                                
                            <div class="form-group">
                                    <label for="last_name" class="required">City</label>
                                    <input type="text" id="city" name="city" placeholder="Enter a city" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                            <label for="construction_date" class="required">Construction date</label>
                                <input type="date" id="construction_date" name="construction_date" required>
                            </div>
                            <div class="form-group">
                                <label for="capacity" class="required">Capacity</label>
                                <input type="text" id="capacity" name="capacity" placeholder="Enter a capacity" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="personal-next">Add</button>   
                </form>
            </div>
            
            <!-- Football Info Tab -->
            <div class="tab-content active" id="football">
                <form action="update_stadium.php" method="POST">
                    <div class="form-section">
                    <h2>Edit Stadium Information</h2>
                        <div class ="form-row">
                            <div class="form-group">
                                <label for="team">Select Stadium</label>
                                <select name="staff_id1" id="staff_id">
                                    <option value="">Select stadium</option>
                                    <?php
                                    $query = "SELECT id, nom FROM stadium";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="required">Name</label>
                                <input type="text" id="name1" name="name1" placeholder="Enter a name" required>
                            </div>
                                
                            <div class="form-group">
                                    <label for="last_name" class="required">City</label>
                                    <input type="text" id="city1" name="city1" placeholder="Enter a city" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                            <label for="construction_date" class="required">Construction date</label>
                                <input type="date" id="construction_date1" name="construction_date1" required>
                            </div>
                            <div class="form-group">
                                <label for="status" class="required">Current Status</label>
                                <select name="status1" id="status1">
                                    <option value="">Select a status</option>
                                    <option value="actif">actif</option>
                                    <option value="reconstruction">In reconstruction</option>
                                    <option value="deleted">Deleted</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="capacity" class="required">Capacity</label>
                                <input type="text" id="capacity1" name="capacity1" placeholder="Enter a capacity" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="personal-next">Edit</button>   
                </form>
            </div>
            <div class="tab-content active" id="list">
                <div class="form-row">
                    <div class="form-group">
                        <!-- Liste des stades -->
                        <h2>List of Stadiums</h2>
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Construction Date</th>
                                    <th>Status</th>
                                    <th>Capacity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM stadium";
                                $stmt = $bd->prepare($query);
                                $stmt->execute();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["ville"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["date_de_creation"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["capacity"]) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const select = document.getElementById('staff_id');

            select.addEventListener('change', function () {
                const stadiumId = this.value;
                if (!stadiumId) return;

                fetch(`get_stade.php?id=${stadiumId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert("Erreur : " + data.error);
                            return;
                        }

                        // Remplissage des champs avec les données récupérées
                        document.getElementById('name1').value = data.nom || '';
                        document.getElementById('city1').value = data.ville || '';
                        document.getElementById('construction_date1').value = data.date_de_creation || '';
                        document.getElementById('status1').value = data.status || '';
                        document.getElementById('capacity1').value = data.capacity || '';
                    })
                    .catch(error => {
                        console.error("Erreur de chargement :", error);
                    });
            });
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
        });
        tabs.forEach(function(tab) {
            tab.addEventListener("click", function() {
                const targetTab = tab.getAttribute("data-tab");
                console.log("Tab clicked: ", targetTab); // Pour vérifier que le clic fonctionne

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

    </script>
    
</body>
</html>