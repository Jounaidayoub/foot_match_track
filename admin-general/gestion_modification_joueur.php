<?php
session_start();
require_once '../includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Joueur</title>
    <link rel="stylesheet" href="../css/adminplayer.css"> <!-- Ton CSS ici -->
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
    <br>
    <br>
    <br>
    <br>
    <div class="header">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h1>Player Management</h1>
        </div>

        <h2>Modifier les Informations d'un Joueur</h2>
        <br>
        <br>
        <form action="update_player.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                <label for="player_id" class="required">Sélectionner un joueur :</label>
                <select name="player_id" id="player_id" required>
                    <option value=""> Choisir un joueur </option>
                    <?php
                    $query = "SELECT id, first_name, last_name FROM players";
                    $stmt = $bd->prepare($query);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["first_name"] . " " . $row["last_name"]) . "</option>";
                    }
                    ?>
                </select>
                </div>
            </div>

            <!-- Infos de base -->
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name" class="required">Prénom</label>
                    <input type="text" name="first_name" id="first_name">
                </div>
                <div class="form-group">
                    <label for="last_name" class="required">Nom</label>
                    <input type="text" name="last_name" id="last_name">
                </div>
                <div class="form-group">
                    <label for="birth_date" class="required">Date de naissance</label>
                    <input type="date" name="birth_date" id="birth_date">
                </div>
                <div class="form-group">
                    <label for="birth_place" class="required">Lieu de naissance</label>
                    <input type="text" name="birth_place" id="birth_place">
                </div>
                <div class="form-group">
                    <label for="nationality" class="required">Nationalité</label>
                    <input type="text" name="nationality" id="nationality">
                </div>
            </div>

            <!-- Contact et position -->
            <div class="form-row">
                <div class="form-group">
                    <label for="email"  class="required">Email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="phone" class="required">Téléphone</label>
                    <input type="text" name="phone" id="phone">
                </div>
                <div class="form-group" >
                    <label for="social_media" class="required">Réseaux sociaux</label>
                    <input type="text" name="social_media" id="social_media">
                </div>
                <div class="form-group" >
                    <label for="position" class="required">Position principale</label>
                    <input type="text" name="position" id="position">
                </div>
                <div class="form-group" >
                    <label for="secondary_position" class="required">Position secondaire</label>
                    <input type="text" name="secondary_position" id="secondary_position">
                </div>
            </div>

            <!-- Statistiques et infos physiques -->
            <div class="form-row">
                <div class="form-group">
                    <label for="jersey_number" class="required">Numéro</label>
                    <input type="number" name="jersey_number" id="jersey_number">
                </div>
                <div class="form-group">
                    <label for="preferred_foot" class="required">Pied préféré</label>
                    <select name="preferred_foot" id="preferred_foot">
                        <option value="">select the prederred foot</option>
                        <option value="Droit">Droit</option>
                        <option value="Gauche">Gauche</option>
                        <option value="Les deux">Les deux</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="team" class="required">Équipe</label>
                    <input type="text" name="team" id="team">
                </div>
                <div class="form-group">
                    <label for="goals" class="required">Buts</label>
                    <input type="number" name="goals" id="goals">
                </div>
                <div class="form-group">
                    <label for="assists" class="required">Passes décisives</label>
                    <input type="number" name="assists" id="assists">
                </div>
                <div class="form-group">
                    <label for="appearances" class="required">Apparitions</label>
                    <input type="number" name="appearances" id="appearances">
                </div>
                <div class="form-group">
                    <label for="height" class="required">Taille (cm)</label>
                    <input type="number" step="0.01" name="height" id="height">
                </div>
                <div class="form-group" >
                    <label for="weight" class="required">Poids (kg)</label>
                    <input type="number" step="0.01" name="weight" id="weight">
                </div>
                <div class="form-group">
                    <label for="bmi" class="required">IMC</label>
                    <input type="number" step="0.01" name="bmi" id="bmi">
                </div>
                <div class="form-group">
                    <label for="fitness_level" class="required">Niveau de forme</label>
                    <input type="number" name="fitness_level" id="fitness_level">
                </div>
            </div>

            <!-- Médical, contrat et agent -->
            <div class="form-row">
                <div class="form-group">
                    <label for="medical_conditions" class="required">Conditions médicales</label>
                    <textarea name="medical_conditions" id="medical_conditions"></textarea>
                </div>
                <div class="form-group">
                    <label for="contract_start" class="required">Début du contrat</label>
                    <input type="date" name="contract_start" id="contract_start">
                </div>
                <div class="form-group">
                    <label for="contract_end" class="required">Fin du contrat</label>
                    <input type="date" name="contract_end" id="contract_end">
                </div>
                <div class="form-group">
                    <label for="release_clause" class="required">Clause libératoire (€)</label>
                    <input type="number" step="0.01" name="release_clause" id="release_clause">
                </div>
                <div class="form-group">
                    <label for="market_value" class="required">Valeur marchande (€)</label>
                    <input type="number" step="0.01" name="market_value" id="market_value">
                </div>
                <div class="form-group">
                    <label for="contract_notes" class="required">Notes sur le contrat</label>
                    <textarea name="contract_notes" id="contract_notes"></textarea>
                </div>
                <div class="form-group">
                    <label for="agent_name" class="required">Nom de l'agent</label>
                    <input type="text" name="agent_name" id="agent_name">
                </div>
                <div class="form-group">
                    <label for="agent_contact" class="required">Contact de l'agent</label>
                    <input type="text" name="agent_contact" id="agent_contact">
                </div>
                <div class="form-group">
                    <label for="player_photo" class="required">Photo du joueur</label>
                    <input type="file" name="player_photo" id="player_photo" accept="image/*">
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const playerSelect = document.getElementById('player_id');

            playerSelect.addEventListener('change', function () {
                const playerId = this.value;
                if (playerId) {
                    fetch(`get_player.php?player_id=${playerId}`)
                        .then(response => response.json())
                        .then(data => {
                            for (let key in data) {
                                const el = document.getElementById(key);
                                if (el) {
                                    if (el.type === "file") continue;
                                    el.value = data[key];
                                }
                            }
                        })
                        .catch(error => console.error('Error loading player data:', error));
                }
            });
        });
    </script>
</body>
</html>
