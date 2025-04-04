<?php
session_start();
require_once '../includes/db.php'; // Connexion à la base de données

// Récupérer les données du formulaire
$tournament_name = $_POST['tournament_name'];
$format = $_POST['format'];
$sdate = $_POST['sdate'];
$edate = $_POST['edate'];
$location = $_POST['Location'];
$numteams = $_POST['numteams'];

// Vérifier si le tournoi existe déjà
$sql = "SELECT * FROM tournaments WHERE tournament_name = :tournament_name";
$stmt = $bd->prepare($sql);
$stmt->bindParam(':tournament_name', $tournament_name, PDO::PARAM_STR);
$stmt->execute();

// Si un tournoi avec le même nom existe déjà
if ($stmt->rowCount() > 0) {
    echo "A tournament with this name already exists. Please choose a different name.";
    exit();
}

// Vérifier l'état du tournoi
$current_date = date('Y-m-d'); // Date actuelle
$status = "upcoming"; // Par défaut, le tournoi est "upcoming"

if ($current_date > $sdate && $current_date < $edate) {
    $status = "active"; // Si la date actuelle est entre la date de début et de fin
} elseif ($current_date > $edate) {
    $status = "completed"; // Si la date actuelle est après la date de fin
}

// Préparer la requête d'insertion
$sql = "INSERT INTO tournaments (tournament_name, format, start_date, end_date, location, status, num_teams, created_at) 
        VALUES (:tournament_name, :format, :start_date, :end_date, :location, :status, :num_teams, :created_at)";
$stmt = $bd->prepare($sql);

// Lier les paramètres
$stmt->bindParam(':tournament_name', $tournament_name, PDO::PARAM_STR);
$stmt->bindParam(':format', $format, PDO::PARAM_STR);
$stmt->bindParam(':start_date', $sdate, PDO::PARAM_STR);
$stmt->bindParam(':end_date', $edate, PDO::PARAM_STR);
$stmt->bindParam(':location', $location, PDO::PARAM_STR);
$stmt->bindParam(':status', $status, PDO::PARAM_STR);
$stmt->bindParam(':num_teams', $numteams, PDO::PARAM_INT);
$stmt->bindParam(':created_at', $current_date, PDO::PARAM_STR);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Tournament added successfully.";
    header("location: ../admin-general/index.php");
} else {
    echo "Error: " . $stmt->errorInfo()[2];
    header("location: ../admin-general/gestion_tournoi.php");
}

// Fermer la connexion
$bd = null;
?>
