<?php
session_start();
require_once '../includes/db.php'; // Connexion à la base de données

// Vérifier si l'ID du tournoi est passé
if (isset($_GET['id'])) {
    $tournament_id = $_GET['id'];

    // Requête pour récupérer les informations du tournoi
    $query = "SELECT * FROM tournaments WHERE id = :id";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':id', $tournament_id, PDO::PARAM_INT);
    $stmt->execute();

    // Vérifier si le tournoi existe
    if ($stmt->rowCount() > 0) {
        $tournament = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($tournament); // Retourner les données du tournoi en JSON
    } else {
        echo json_encode(['error' => 'Tournament not found']);
    }
} else {
    echo json_encode(['error' => 'Tournament ID not provided']);
}
?>
