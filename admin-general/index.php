<?php
session_start();
require_once '../includes/db.php';

// Function to count rows from a table
function countTableRows($table, $bd) {
    $stmt = $bd->prepare("SELECT COUNT(*) AS total FROM $table");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

// Fetching counts
$teamCount = countTableRows('teams', $bd);
$playerCount = countTableRows('players', $bd);
$staffCount = countTableRows('staff', $bd);
$tournamentCount = countTableRows('tournaments', $bd);
$refereeCount = countTableRows('refree', $bd);
$stadiumCount = countTableRows('stadium', $bd);

// Count tournament admins (users with role = 'A')
$stmt = $bd->prepare("SELECT COUNT(*) AS total FROM users WHERE role = 't'");
$stmt->execute();
$adminCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/adminplayer.css"> <!-- Link to your provided CSS -->
    <style>
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .dashboard-card {
            background-color: var(--bg-darker);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.08);
        }

        .dashboard-card h2 {
            font-size: 36px;
            color: var(--primary-color);
            margin: 0;
        }

        .dashboard-card p {
            font-size: 16px;
            color: var(--text-muted);
            margin-top: 10px;
        }

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
        /* Existing CSS for the main menu */
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

/* Hover effect for all menu items */
.main-menu ul li:hover {
    color: var(--primary-color);
}

/* Submenu for "Tournament Admin" */
#tournament-admin-menu {
    color: var(--text-muted);
}

#tournament-admin-menu:hover {
    color: var(--primary-color);  /* Color change on hover */
    background-color: var(--bg-darker);  /* Background color change on hover */
}

/* Submenu visibility for "Tournament Admin" */
#tournament-admin-menu > ul {
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

/* Make submenu visible on hover */
#tournament-admin-menu:hover > ul {
    visibility: visible;
    opacity: 1;
    transition-delay: 0s;
}

/* Other submenus behavior is unchanged */
#player-menu > ul,
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

/* Display submenu on hover for "Player" and "Management" menus */
#player-menu:hover > ul,
#management-menu:hover > ul {
    visibility: visible;
    opacity: 1;
    transition-delay: 0s;
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
                <li><a href="gestion_publication.php">Publication</a></li>
            </ul>
        </li>
        <li id="tournament-admin-menu">
            Tournament
            <ul>
                <li><a href="gestion_admin_tournoi.php">Admin Tournament</a></li>
                <li><a href="gestion_tournoi.php">Tournament</a></li>
                <li><a href="gestion_affectationtn.php">Affectation</a></li>
            </ul>
        </li>
        <li>
            <a href="../home/home.php">home</a>
        </li>
        
    </ul>

    <!-- Bouton de déconnexion -->
    <button id="logout-btn"> <a href="../auth/signout.php">Logout</a></button>
</div>

<div class="container">
    <br>
    <br>
    <br>
    <br>
    <div class="header">
        
        <h1>Admin Dashboard</h1>
    </div>

    <div class="dashboard-cards">
        <div class="dashboard-card">
            <h2><?= $teamCount ?></h2>
            <p>Teams</p>
        </div>
        <div class="dashboard-card">
            <h2><?= $playerCount ?></h2>
            <p>Players</p>
        </div>
        <div class="dashboard-card">
            <h2><?= $staffCount ?></h2>
            <p>Staff Members</p>
        </div>
        <div class="dashboard-card">
            <h2><?= $tournamentCount ?></h2>
            <p>Tournaments</p>
        </div>
        <div class="dashboard-card">
            <h2><?= $refereeCount ?></h2>
            <p>Referees</p>
        </div>
        <div class="dashboard-card">
            <h2><?= $stadiumCount ?></h2>
            <p>Stadiums</p>
        </div>
        <div class="dashboard-card">
            <h2><?= $adminCount ?></h2>
            <p>Tournament Admins</p>
        </div>
    </div>
    <script>
  // Fonction pour détecter la position des éléments du menu
  // Fonction pour activer le menu au défilement
function activateMenuOnScroll() {
  const sections = ['#player-menu', '#management-menu', '#tournament-admin-menu', '#logout-btn']; // Include Tournament Admin
  const menuItems = document.querySelectorAll('.main-menu ul li');

  // Supprimer la classe active de tous les éléments du menu
  menuItems.forEach(item => {
    item.classList.remove('active');
  });

  // Vérifier si chaque élément du menu est visible
  sections.forEach(section => {
    const element = document.querySelector(section);
    const rect = element.getBoundingClientRect();

    // Si l'élément est visible dans la fenêtre
    if (rect.top <= 0 && rect.bottom >= 0) {
      document.querySelector(section).classList.add('active'); // Ajouter la classe active
    }
  });
}

// Écouteur d'événement pour activer/désactiver les menus au défilement
window.addEventListener('scroll', activateMenuOnScroll);
window.addEventListener('load', activateMenuOnScroll); // Activer les menus dès le chargement de la page
</script>
</div>


</body>
</html>
