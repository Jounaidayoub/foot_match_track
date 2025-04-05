<?php
session_start();
require_once '../includes/db.php';

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $staff_id = $_POST['staff_id1'];
    $first_name = $_POST['first_name1'];
    $last_name = $_POST['last_name1'];
    $role = $_POST['role1'];
    $nationality_name = $_POST['nationality1']; // Nom du pays
    $photo = $_POST['photo1'];
    $team_name = $_POST['team1']; // Nom de l'équipe

    // Validation des données (facultatif, mais recommandé)
    if (empty($staff_id) || empty($first_name) || empty($last_name) || empty($role) || empty($nationality_name) || empty($photo) || empty($team_name)) {
        echo "All fields are required.";
        exit();
    }

    // Récupérer l'ID de l'équipe en fonction du nom
    $query_team = "SELECT id FROM teams WHERE team_name = :team_name";
    $stmt_team = $bd->prepare($query_team);
    $stmt_team->bindParam(':team_name', $team_name, PDO::PARAM_STR);
    $stmt_team->execute();
    $team_id = $stmt_team->fetchColumn(); // Récupérer l'ID de l'équipe

    // Récupérer l'ID du pays en fonction du nom
    $query_country = "SELECT id FROM countries WHERE country_name = :country_name";
    $stmt_country = $bd->prepare($query_country);
    $stmt_country->bindParam(':country_name', $nationality_name, PDO::PARAM_STR);
    $stmt_country->execute();
    $country_id = $stmt_country->fetchColumn(); // Récupérer l'ID du pays

    // Vérifier si les IDs ont été récupérés
    if (!$team_id || !$country_id) {
        echo "Invalid team or country.";
        exit();
    }

    // Requête de mise à jour dans la table staff
    $query = "UPDATE staff SET nom = :nom, prenom = :prenom, role = :role, photo = :photo, id_team = :team_id, id_country = :country_id WHERE id_staff = :staff_id";

    try {
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
        $stmt->bindParam(':team_id', $team_id, PDO::PARAM_INT); // Utilisation de l'ID de l'équipe
        $stmt->bindParam(':country_id', $country_id, PDO::PARAM_INT); // Utilisation de l'ID du pays
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Staff information updated successfully.";
            header("Location: ../admin-general/index.php");
        } else {
            echo "No changes made or staff not found.";
            header("Location: ../admin-general/gestion_staff.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
