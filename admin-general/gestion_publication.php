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
            <h1>Publication Management</h1>
        </div>
        
        
        <div class="tabs">
                <div class="tab active" data-tab="personal">New Publication</div>
                <div class="tab" data-tab="football">Edit Publication</div>
                <div class = "tab" data-tab="list">List of publication</div>
            </div>
            
            <!-- Personal Info Tab -->
            <div class="tab-content active" id="personal">
                <form action="add_publication.php" method="POST">
                    <div class="form-section">
                    <h2>Information</h2>              
                        <div class="form-row">
                            <div class="form-group">
                                <label for="title" class="required">Title</label>
                                <input type="text" id="title" name="title" placeholder="Enter a title" required>
                            </div>
                                
                            <div class="form-group">
                                    <label for="last_name" class="required">image path</label>
                                    <input type="text" id="image_path" name="image_path" placeholder="Enter le chemin de la publication" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                            <label for="details" class="required">Information</label>
                                <textarea name="details" id="details"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="personal-next">Add</button>  
                </form>
            </div>
            
            <div class="tab-content" id="football">
                <form action="update_publication.php" method="POST">
                    <div class="form-section">
                        <h2>Edit Publication</h2>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="staff_id">Select Publication</label>
                                <select name="staff_id1" id="staff_id" onchange="loadPublicationData()">
                                    <option value="">Select Publication</option>
                                    <?php
                                    $query = "SELECT id, titre FROM publication";
                                    $stmt = $bd->prepare($query);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row["id"] . "'>". htmlspecialchars($row["titre"]) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="title" class="required">Title</label>
                                <input type="text" id="title1" name="title1" placeholder="Enter a title" required>
                            </div>

                            <div class="form-group">
                                <label for="image_path1" class="required">Image Path</label>
                                <input type="text" id="image_path1" name="image_path1" placeholder="Enter the image path" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="details1" class="required">Information</label>
                                <textarea name="details1" id="details1"></textarea>
                            </div>
                        </div>

                        <div class="actions">
                            <button type="submit" class="btn btn-primary" id="personal-next">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- List of Publications Tab -->
            <div class="tab-content " id="list">
                <h2>List of Publications</h2>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Image Path</th>
                            <th>Details</th>
                            <th>Admin ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        

                        // Récupérer toutes les publications
                        $sql = "SELECT * FROM publication ORDER BY id DESC";
                        $stmt = $bd->prepare($sql);
                        $stmt->execute();

                        // Affichage des publications
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['image_path']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['contenue']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['id_admin']) . "</td>";
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
        // Function to load the publication data based on the selected id
    function loadPublicationData() {
        var publicationId = document.getElementById("staff_id").value;

        if (publicationId) {
            // Make an AJAX request to get the publication details
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_publication.php?id=" + publicationId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var publication = JSON.parse(xhr.responseText);
                    document.getElementById("title1").value = publication.titre;
                    document.getElementById("image_path1").value = publication.image_path;
                    document.getElementById("details1").value = publication.contenue;
                } else {
                    alert("Error loading publication data.");
                }
            };
            xhr.send();
        } else {
            // Clear the form if no publication is selected
            document.getElementById("title1").value = "";
            document.getElementById("image_path1").value = "";
            document.getElementById("details1").value = "";
        }
    }
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