<?php
require '../includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $match_id = $_GET['match_id'] ?? null;
    
    if (!$match_id || !is_numeric($match_id)) {
        echo json_encode(['error' => 'Invalid match ID']);
        exit;
    }
    
    // Check if stats exist for this match
    $check_sql = "SELECT COUNT(*) FROM match_stats WHERE match_id = :match_id";
    $check_stmt = $bd->prepare($check_sql);
    $check_stmt->execute(['match_id' => $match_id]);
    $exists = $check_stmt->fetchColumn();
    
    if ($exists == 0) {
        // Create default stats for this match
        $insert_sql = "INSERT INTO match_stats (match_id) VALUES (:match_id)";
        $insert_stmt = $bd->prepare($insert_sql);
        $insert_stmt->execute(['match_id' => $match_id]);
    }
    
    // Get the stats
    $sql = "SELECT * FROM match_stats WHERE match_id = :match_id";
    $stmt = $bd->prepare($sql);
    $stmt->execute(['match_id' => $match_id]);
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($stats);
}
?>