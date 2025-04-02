<?php
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    //delete by match id
    $match_id = $data['match_id'];
    
    
    
    try {
       // Use backticks around _match to avoid SQL keyword issues
        $sql = "DELETE FROM `_match` WHERE id_match = :match_id";
        $stmt = $bd->prepare($sql);
        $stmt->execute(['match_id' => $match_id]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>