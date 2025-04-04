<?php
session_start();
require_once '../includes/db.php';



// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées par le formulaire
    $admin_id = isset($_POST['staff_id1']) ? (int)$_POST['staff_id1'] : null;
    $first_name = isset($_POST['first_name1']) ? trim($_POST['first_name1']) : '';
    $email = isset($_POST['email1']) ? trim($_POST['email1']) : '';
    $tournament_id = isset($_POST['tournament1']) ? (int)$_POST['tournament1'] : null;

    // Validation de l'ID de l'admin, du nom et de l'email
    if (empty($admin_id) || empty($first_name) || empty($email)) {
        echo "Veuillez remplir tous les champs.";
        exit();
    }

    // Préparer la requête pour mettre à jour les informations de l'admin
    $query = "
        UPDATE users 
        SET nom = :first_name, email = :email, tournament_id = :tournament_id 
        WHERE id = :admin_id AND role = 't'"; 

    // Exécuter la requête avec des paramètres sécurisés
    try {
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':tournament_id', $tournament_id, PDO::PARAM_INT);
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);

        $stmt->execute();

        // Vérifier si la mise à jour a été effectuée avec succès
        if ($stmt->rowCount() > 0) {
            echo "L'admin a été mis à jour avec succès.";
            header("Location: ../admin-general/index.php");
        } else {
            echo "Aucune modification n'a été effectuée.";
            header("Location: ../admin-general/gestion_admin_tournoi.php");
        }
    } catch (PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Accès interdit. Veuillez soumettre le formulaire.";
}
?>
