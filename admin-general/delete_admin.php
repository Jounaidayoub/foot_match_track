<?php
session_start();
require_once '../includes/db.php';



// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer l'ID de l'admin à supprimer
    $admin_id = isset($_GET['staff_id1']) ? (int)$_GET['staff_id1'] : null;

    // Vérification de l'existence de l'ID
    if (empty($admin_id)) {
        echo "Veuillez sélectionner un admin à supprimer.";
        exit();
    }

    // Préparer la requête pour vérifier si l'admin existe
    $check_query = "SELECT id FROM users WHERE id = :admin_id AND role = 't'";
    try {
        $stmt = $bd->prepare($check_query);
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Préparer la requête pour supprimer l'admin
            $delete_query = "DELETE FROM users WHERE id = :admin_id AND role = 't'";

            $delete_stmt = $bd->prepare($delete_query);
            $delete_stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
            $delete_stmt->execute();

            // Vérifier si la suppression a réussi
            if ($delete_stmt->rowCount() > 0) {
                echo "L'admin a été supprimé avec succès.";
                header("Location: ../admin_general/index.php");
            } else {
                echo "Une erreur est survenue lors de la suppression de l'admin.";
                header("Location: ../admin_general/gestion_admin_tournoi.php");
            }
        } else {
            echo "L'admin sélectionné n'existe pas.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Accès interdit. Veuillez soumettre le formulaire.";
}
?>
