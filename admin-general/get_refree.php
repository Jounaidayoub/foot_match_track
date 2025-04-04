<?php
require_once '../includes/db.php'; // Connexion à la base de données

if (isset($_POST['refree_id']) && !empty($_POST['refree_id'])) {
    $refree_id = intval($_POST['refree_id']);

    // Utilisation correcte de la colonne `id`
    $query = "SELECT id, nom, prenom, date_de_naissance, status FROM refree WHERE id = ?";
    
    $stmt = $bd->prepare($query);
    $stmt->execute([$refree_id]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode(["success" => true, "data" => $row]);
    } else {
        echo json_encode(["success" => false, "message" => "Arbitre introuvable."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Aucun ID d'arbitre reçu."]);
}
?>
