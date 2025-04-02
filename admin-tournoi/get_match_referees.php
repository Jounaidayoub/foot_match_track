<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

// Get the match_id from the query string
if (!isset($_GET['match_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit;
}

$match_id = $_GET['match_id'];

try {
    // Fetch the match referees based on match ID
    $sql = "SELECT 
                id_referee_main AS main_referee,
                id_referee_assistant1 AS assistant1,
                id_referee_assistant2 AS assistant2
            FROM _match
            WHERE id_match = :match_id";

    $stmt = $bd->prepare($sql);
    $stmt->execute([':match_id' => $match_id]);
    $referees = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($referees) {
        echo json_encode(['success' => true, 'referees' => $referees]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Match not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
