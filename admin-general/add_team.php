<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_name = $_POST['team_name'];
    $founded_year = date('Y', strtotime($_POST['founded_year'])); // Extraire l'année de la date
    $country_name = $_POST['nationality1'];
    $city_name = $_POST['city_name'];
    $logo_path = $_POST['logo_path'];
    $primary_color = $_POST['primary_color'];
    $secondary_color = $_POST['secondary_color'];
    $home_stadium = $_POST['home_stadium'];
    $stadium_capacity = $_POST['stadium_capacity'];
    $website = $_POST['website'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $head_coach = $_POST['staff_id1'];
    $assistant_coach = $_POST['staff_id2'];
    $team_manager = $_POST['staff_id3'];
    $physiotherapist = $_POST['staff_id4'];
    $history = $_POST['history'];

    try {
        // Vérifier si l'équipe existe déjà
        $query = "SELECT COUNT(*) FROM teams WHERE team_name = :team_name";
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':team_name', $team_name);
        $stmt->execute();
        $team_exists = $stmt->fetchColumn();

        if ($team_exists) {
            $_SESSION['error'] = "This team already exists!";
            header("Location: add_team_form.php");
            exit();
        }

        // Vérifier si le coach est déjà assigné à une autre équipe
        $query = "SELECT id_team FROM staff WHERE id_staff = :head_coach AND id_team IS NOT NULL";
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':head_coach', $head_coach);
        $stmt->execute();
        $coach_assigned = $stmt->fetchColumn();

        if ($coach_assigned) {
            $_SESSION['error'] = "This head coach is already assigned to another team!";
            header("Location: add_team_form.php");
            exit();
        }

        $query = "INSERT INTO teams (team_name, founded_year, country, city, logo_path, primary_color, secondary_color, home_stadium, stadium_capacity, website, email, phone, address, head_coach, assistant_coach, team_manager, physiotherapist, history) 
              VALUES (:team_name, :founded_year, :country_name, :city_name, :logo_path, :primary_color, :secondary_color, :home_stadium, :stadium_capacity, :website, :email, :phone, :address, :head_coach, :assistant_coach, :team_manager, :physiotherapist, :history)";

    $stmt = $bd->prepare($query);

    // Lier les paramètres
    $stmt->bindParam(':team_name', $team_name);
    $stmt->bindParam(':founded_year', $founded_year);
    $stmt->bindParam(':country_name', $country_name);
    $stmt->bindParam(':city_name', $city_name);
    $stmt->bindParam(':logo_path', $logo_path);
    $stmt->bindParam(':primary_color', $primary_color);
    $stmt->bindParam(':secondary_color', $secondary_color);
    $stmt->bindParam(':home_stadium', $home_stadium);
    $stmt->bindParam(':stadium_capacity', $stadium_capacity);
    $stmt->bindParam(':website', $website);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':head_coach', $head_coach);
    $stmt->bindParam(':assistant_coach', $assistant_coach);
    $stmt->bindParam(':team_manager', $team_manager);
    $stmt->bindParam(':physiotherapist', $physiotherapist);
    $stmt->bindParam(':history', $history);

    // Exécution de la requête
    if ($stmt->execute()) {
        $_SESSION['success'] = "Team added successfully!";
        header("Location: ../admin_general/index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to add team.";
        header("Location: ../admin_general/gestion_teams.php");

    }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Invalid request method.";
}

?>
