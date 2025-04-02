<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['match_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit;
}

try {
    // Update the match record with referee data
    $sql = "UPDATE _match SET
            id_referee_main = :main_referee,
            id_referee_assistant1 = :assistant1,
            id_referee_assistant2 = :assistant2
            WHERE id_match = :match_id";

    $stmt = $bd->prepare($sql);
    $params = [
        ':match_id' => $data['match_id'],
        ':main_referee' => $data['main_referee'] ?: null,
        ':assistant1' => $data['assistant1'] ?: null,
        ':assistant2' => $data['assistant2'] ?: null
    ];

    $result = $stmt->execute($params);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database update failed']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

?>