<?php
session_start();
require_once '../includes/db.php'; // Connection to the database

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the tournament and team data from the form
    $tournament_id = $_POST['tournament'];
    $team_id = $_POST['team'];

    // Validate the input data
    if (empty($tournament_id) || empty($team_id)) {
        echo "Please select both a tournament and a team.";
        exit();
    }

    // Check the tournament status
    $query = "SELECT status FROM tournaments WHERE id = :tournament_id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':tournament_id', $tournament_id, PDO::PARAM_INT);
    $stmt->execute();
    $tournament = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the tournament does not exist or has started (status != "upcoming")
    if (!$tournament || $tournament['status'] !== 'upcoming') {
        echo "You cannot unaffect a team from this tournament because the status is not 'upcoming'.";
        exit();
    }

    // Check if the team is currently affected to the tournament
    $query = "SELECT * FROM tournament_teams WHERE tournament_id = :tournament_id AND team_id = :team_id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':tournament_id', $tournament_id, PDO::PARAM_INT);
    $stmt->bindParam(':team_id', $team_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        echo "This team is not currently assigned to the selected tournament.";
        exit();
    }

    // Unaffect the team from the tournament (delete the record from tournament_teams table)
    $query = "DELETE FROM tournament_teams WHERE tournament_id = :tournament_id AND team_id = :team_id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':tournament_id', $tournament_id, PDO::PARAM_INT);
    $stmt->bindParam(':team_id', $team_id, PDO::PARAM_INT);

    // Execute the deletion
    if ($stmt->execute()) {
        echo "Team successfully unaffacted from the tournament.";
        header("Location: ../admin-general/index.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
        header("Location: ../admin-general/gestion_affectationtn.php");
    }
}
?>
