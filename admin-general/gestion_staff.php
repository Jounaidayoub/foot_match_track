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
                <div class="tab active" data-tab="personal">Staff Personal information</div>
                <div class="tab" data-tab="football">Edit Staff</div>
                <div class="tab" data-tab="delete">Delete Staff</div>
            </div>
            
            <!-- Personal Info Tab -->
            <div class="tab-content active" id="personal">
                <form action="add_staff.php" method="POST">
                    <div class="form-section">
                    <h2>Personal Information</h2>
                        
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="required">First Name</label>
                                <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>
                            </div>
                                
                            <div class="form-group">
                                    <label for="last_name" class="required">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                            <label for="role" class="required">Role</label>
                                <select name="role" id="role">
                                    <option value="">Select role</option>
                                    <option value="coach">Coach</option>
                                    <option value="assistant">Assistant</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="physiotherapist">Physiotherapist</option>
                                    <option value="headcoach">Head coach</option>
                                    <option value="headcoach">Manager</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="nationality" class="required">Nationality</label>
                                <select name="nationality" id="nationality" required>
                                    <option value="">Select a nationality</option>
                                    <?php
                                    // Exécution de la requête pour récupérer les pays
                                    $query = "SELECT id, country_name FROM countries";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();
                                    
                                    // Affichage des options
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["country_name"]) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="photo" class="required">image path</label>
                            <input type="text" id="photo" name="photo" placeholder="Enter image path" required>
                        </div>
                        <div class="form-group">
                            <label for="team" class="required">Current team</label>
                            <select name="team" id="team">
                                <option value="">Select team</option>
                                <?php
                                if ($result) {
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["team_name"]) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" id="personal-next">Add</button>
                    
                </form>
            </div>
            
            <!-- Football Info Tab -->
            <div class="tab-content" id="football">
                <form action="update_staff.php" method="POST">
                    <div class="form-section">
                        <h2>Edit staff information</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="team">Select Staff</label>
                                <select name="staff_id1" id="staff_id">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer les admins ayant le rôle 'admintournoi'
                                    $query = "SELECT id_staff, nom, prenom FROM staff";
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
                                <label for="first_name" class="required">First Name</label>
                                <input type="text" id="first_name1" name="first_name1" placeholder="Enter first name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="last_name" class="required">Last Name</label>
                                <input type="text" id="last_name1" name="last_name1" placeholder="Enter last name" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                            <label for="role" class="required">Role</label>
                                <select name="role1" id="role1">
                                    <option value="">Select role</option>
                                    <option value="coach">Coach</option>
                                    <option value="assistant">Assistant</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="physiotherapist">Physiotherapist</option>
                                    <option value="headcoach">Head coach</option>
                                    <option value="headcoach">Manager</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="nationality" class="required">Nationality</label>
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
                    

                    <div class="form-row">
                        <div class="form-group">
                            <label for="photo" class="required">image path</label>
                            <input type="text" id="photo1" name="photo1" placeholder="Enter image path" required>
                        </div>
                        <div class="form-group">
                            <label for="team" class="required">Current team</label>
                            <select name="team1" id="team1">
                            <option value="">Select team</option>
                                <?php
                                $query = "SELECT team_name FROM teams";
                                $stmt = $bd->prepare($query);
                                $stmt->execute();
                                
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row["team_name"] . "'>" . htmlspecialchars($row["team_name"]) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                        <div class="actions">
                            <button type="submit" class="btn btn-primary" id="personal-next">Edit</button>
                        </div>

                    </div>
                </form>
            </div>
            <!-- Delete Staff Tab -->
            <div class="tab-content" id="delete">
                <div class="form-section">
                    <!-- Formulaire pour supprimer un staff -->
                    <form action="delete_staff.php" method="POST">
                        <h2>Delete A Staff</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="team">Select Staff</label>
                                <select name="staff_id1" id="staff_id">
                                    <option value="">Select staff</option>
                                    <?php
                                    // Récupérer tous les membres du staff
                                    $query = "SELECT id_staff, nom, prenom FROM staff";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id_staff"] . "'>" . htmlspecialchars($row["prenom"]) . " " . htmlspecialchars($row["nom"]) . "</option>";
                                    }
                                    ?>
                                </select>  
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" id="personal-next">Delete</button>
                    </form>
                </div>
            </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Lorsque l'utilisateur sélectionne un staff
            $("#staff_id").change(function () {
                var staffId = $(this).val();

                if (staffId) {
                    $.ajax({
                        url: "get_staff.php",
                        type: "POST",
                        data: { staff_id: staffId },
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                var data = response.data;

                                // Remplir les champs avec les données récupérées
                                $("#first_name1").val(data.prenom);
                                $("#last_name1").val(data.nom);
                                $("#role1").val(data.role);
                                $("#photo1").val(data.photo);

                                // Remplir la sélection du pays
                                $("#nationality1").val(data.country_name);
                                
                                // Remplir la sélection de l'équipe
                                $("#team1").val(data.team_name);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function () {
                            alert("Error while fetching staff details.");
                        }
                    });
                } else {
                    // Si aucun staff n'est sélectionné, réinitialiser les champs
                    $("#first_name1, #last_name1, #role1, #nationality1, #photo1, #team1").val("");
                }
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
    </script>
    
</body>
</html>