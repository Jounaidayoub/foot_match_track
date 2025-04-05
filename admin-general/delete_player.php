<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_id'])) {
    $player_id = $_POST['player_id'];

    // Check if player exists
    $check = $bd->prepare("SELECT * FROM players WHERE id = ?");
    $check->execute([$player_id]);

    if ($check->rowCount() > 0) {
        $delete = $bd->prepare("DELETE FROM players WHERE id = ?");
        if ($delete->execute([$player_id])) {
            echo "Player successfully deleted.";
            header("Location: ../admin_general/index.php");
        } else {
            echo "Error: Failed to delete the player.";
            header("Location: ../admin_general/gestion_supp_player.php");
        }
    } else {
        echo "Error: Player not found.";
    }
} else {
    echo "Invalid request.";
}
