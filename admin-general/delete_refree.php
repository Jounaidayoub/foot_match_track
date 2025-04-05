<?php
session_start();
require_once '../includes/db.php'; // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["staff_id1"]) && !empty($_POST["staff_id1"])) {
        $refree_id = $_POST["staff_id1"];

        try {
            // Vérifier si l'arbitre existe
            $checkQuery = "SELECT id FROM refree WHERE id = :id";
            $checkStmt = $bd->prepare($checkQuery);
            $checkStmt->bindParam(":id", $refree_id, PDO::PARAM_INT);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                // Supprimer l'arbitre
                $deleteQuery = "DELETE FROM refree WHERE id = :id";
                $deleteStmt = $bd->prepare($deleteQuery);
                $deleteStmt->bindParam(":id", $refree_id, PDO::PARAM_INT);

                if ($deleteStmt->execute()) {
                    $_SESSION["success"] = "Referee deleted successfully.";
                    header("Location: ../admin-general/index.php");
                } else {
                    $_SESSION["error"] = "Error deleting referee. Please try again.";
                    header("Location: ../admin-general/gestion_arbitre.php");
                }
            } else {
                $_SESSION["error"] = "Referee not found.";
            }
        } catch (PDOException $e) {
            $_SESSION["error"] = "Database error: " . $e->getMessage();
        }
    } else {
        $_SESSION["error"] = "Please select a referee to delete.";
    }
}

// Redirection vers la page de gestion des arbitres
header("http://localhost/Projectfootball/admin-general/gestion_arbitre.php");
exit();
?>
