<?php
require_once '../includes/db.php';

if (isset($_GET['player_id'])) {
    $player_id = $_GET['player_id'];
    $query = "SELECT * FROM players WHERE id = ?";
    $stmt = $bd->prepare($query);
    $stmt->execute([$player_id]);
    $player = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($player) {
        echo json_encode($player);
    } else {
        echo json_encode(['error' => 'Player not found']);
    }
} else {
    echo json_encode(['error' => 'No player ID provided']);
}
