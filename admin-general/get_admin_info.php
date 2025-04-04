<?php
session_start();
require_once '../includes/db.php';

// Vérifier si l'ID de l'admin a été envoyé
if (isset($_POST['refree_id']) && !empty($_POST['refree_id'])) {
    $admin_id = $_POST['refree_id'];

    // Préparer et exécuter la requête SQL avec jointure
    $query = "
        SELECT u.id, u.nom, u.email, u.password, u.tournament_id, t.tournament_name 
        FROM users u
        LEFT JOIN tournaments t ON u.tournament_id = t.id
        WHERE u.id = :id AND u.role = 't'"; 

    $stmt = $bd->prepare($query);
    $stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
    $stmt->execute();

    // Vérifier si un admin avec cet ID existe
    if ($stmt->rowCount() > 0) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        // Retourner les informations de l'admin et le nom du tournoi sous forme de JSON
        echo json_encode([
            'success' => true,
            'data' => $admin
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Admin not found or incorrect role.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Admin ID not provided.'
    ]);
}
?>
