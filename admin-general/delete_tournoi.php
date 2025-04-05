<?php
session_start();
require_once '../includes/db.php'; // Connexion à la base de données

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID du tournoi
    $tournament_id = $_POST['staff_id1'];

    // Vérifier si un tournoi a été sélectionné
    if (empty($tournament_id)) {
        echo "Please select a tournament.";
        exit();
    }

    // Vérifier le statut du tournoi
    $query = "SELECT status FROM tournaments WHERE id = :id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':id', $tournament_id, PDO::PARAM_INT);
    $stmt->execute();
    $tournament = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le tournoi n'existe pas
    if (!$tournament) {
        echo "Tournament not found.";
        exit();
    }

    // Vérifier si le tournoi est "upcoming"
    if ($tournament['status'] !== 'upcoming') {
        echo "You cannot delete this tournament as it has already started or finished.";
        exit();
    }

    // Supprimer le tournoi
    $query = "DELETE FROM tournaments WHERE id = :id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':id', $tournament_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Tournament deleted successfully.";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
