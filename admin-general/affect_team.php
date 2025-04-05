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
    $query = "SELECT status, num_teams FROM tournaments WHERE id = :tournament_id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':tournament_id', $tournament_id, PDO::PARAM_INT);
    $stmt->execute();
    $tournament = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the tournament does not exist or has finished
    if (!$tournament || $tournament['status'] !== 'upcoming') {
        echo "You cannot affect a team to this tournament because its status is not 'upcoming'.";
        exit();
    }

    // Check the current number of teams assigned to the tournament
    $query = "SELECT COUNT(*) as team_count FROM tournament_teams WHERE tournament_id = :tournament_id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':tournament_id', $tournament_id, PDO::PARAM_INT);
    $stmt->execute();
    $team_count = $stmt->fetch(PDO::FETCH_ASSOC)['team_count'];

    // Check if the number of teams is less than the maximum allowed
    if ($team_count >= $tournament['num_teams']) {
        echo "The tournament has already reached the maximum number of teams.";
        exit();
    }

    // Check if the team is already affected to the tournament
    $query = "SELECT * FROM tournament_teams WHERE tournament_id = :tournament_id AND team_id = :team_id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':tournament_id', $tournament_id, PDO::PARAM_INT);
    $stmt->bindParam(':team_id', $team_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "This team is already affected to the selected tournament.";
        exit();
    }

    // Affect the team to the tournament
    $query = "INSERT INTO tournament_teams (tournament_id, team_id) VALUES (:tournament_id, :team_id)";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':tournament_id', $tournament_id, PDO::PARAM_INT);
    $stmt->bindParam(':team_id', $team_id, PDO::PARAM_INT);

    // Execute the insertion
    if ($stmt->execute()) {
        echo "Team successfully added to the tournament.";
        header("location: ../admin-general/index.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
        header("location: ../admin-general/gestion_affectationtn.php");
    }
}
?>
