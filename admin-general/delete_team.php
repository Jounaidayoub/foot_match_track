<?php
// Assuming you have already established a connection to the database
session_start();
require_once '../includes/db.php';

// Vérifier si une requête POST a été envoyée
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'ID de l'équipe à supprimer depuis le formulaire
    $team_id = $_POST['team2'];

    if (!empty($team_id)) {
        // Préparer la requête de suppression
        $query = "DELETE FROM teams WHERE id = :team_id";

        // Préparer la déclaration
        $stmt = $bd->prepare($query);

        // Lier le paramètre pour éviter les injections SQL
        $stmt->bindParam(':team_id', $team_id);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "L'équipe a été supprimée avec succès.";
            header("Location: ../admin-general/index.php");
        } else {
            echo "Une erreur est survenue lors de la suppression de l'équipe.";
            header("location: ../admin-general/gestion_supp_team.php")
        }
    } else {
        echo "L'ID de l'équipe est requis pour la suppression.";
    }
}
?>
