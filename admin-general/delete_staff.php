<?php
session_start();
require_once '../includes/db.php';

// Vérification si l'ID du staff à supprimer est présent dans la requête POST
if (isset($_POST['staff_id1'])) {
    // Récupérer l'ID du staff
    $staff_id = $_POST['staff_id1'];

    // Validation de l'ID
    if (empty($staff_id)) {
        echo "Staff ID is required.";
        exit();
    }

    // Requête de suppression du staff
    $query = "DELETE FROM staff WHERE id_staff = :staff_id";

    try {
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Si l'enregistrement a été supprimé, afficher un message de succès
            echo "Staff member deleted successfully.";
            header("location: ../admin_general/index.php");
        } else {
            // Si aucune ligne n'a été affectée, afficher un message d'erreur
            echo "No staff found with the given ID.";
            header("location: ../admin_general/gestion_staff.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Staff ID is missing.";
}
?>
