<?php
session_start();
require_once '../includes/db.php'; // Connexion à la base de données

// Vérifier si les données du formulaire sont soumises
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $tournament_id = $_POST['staff_id1'];
    $tournament_name = $_POST['tournament_name1'];
    $format = $_POST['format1'];
    $sdate = $_POST['sdate1'];
    $edate = $_POST['edate1'];
    $location = $_POST['Location1'];
    $numteams = $_POST['numteams1'];

    // Vérifier l'état du tournoi
    $current_date = date('Y-m-d'); // Date actuelle
    $status = "upcoming"; // Par défaut, le tournoi est "upcoming"

    if ($current_date > $sdate && $current_date < $edate) {
        $status = "active"; // Si la date actuelle est entre la date de début et de fin
    } elseif ($current_date > $edate) {
        $status = "completed"; // Si la date actuelle est après la date de fin
    }

    // Récupérer la date de création initiale
    $query = "SELECT created_at FROM tournaments WHERE id = :id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':id', $tournament_id, PDO::PARAM_INT);
    $stmt->execute();
    $tournament = $stmt->fetch(PDO::FETCH_ASSOC);
    $created_at = $tournament['created_at']; // Conserver la date de création

    // Mettre à jour les informations du tournoi
    $query = "UPDATE tournaments SET tournament_name = :tournament_name, format = :format, start_date = :start_date, 
              end_date = :end_date, location = :location, status = :status, num_teams = :num_teams 
              WHERE id = :id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':tournament_name', $tournament_name, PDO::PARAM_STR);
    $stmt->bindParam(':format', $format, PDO::PARAM_STR);
    $stmt->bindParam(':start_date', $sdate, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $edate, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':num_teams', $numteams, PDO::PARAM_INT);
    $stmt->bindParam(':id', $tournament_id, PDO::PARAM_INT);

    // Exécuter la mise à jour
    if ($stmt->execute()) {
        echo "Tournament updated successfully.";
        header("Location: ../admin-general/index.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
        header("Location: ../admin-general/gestion_tournoi.php");
    }
}
?>
