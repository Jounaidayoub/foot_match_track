<?php
require_once '../includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $player_id = $_POST['player_id'];
    $fields = [
        'first_name', 'last_name', 'birth_date', 'birth_place', 'nationality', 'email', 'phone',
        'social_media', 'position', 'secondary_position', 'jersey_number', 'preferred_foot', 'team',
        'goals', 'assists', 'appearances', 'height', 'weight', 'bmi', 'fitness_level',
        'medical_conditions', 'contract_start', 'contract_end', 'agent_name', 'agent_contact',
        'release_clause', 'market_value', 'contract_notes'
    ];

    $updateFields = [];
    $params = [];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $updateFields[] = "$field = :$field";
            $params[":$field"] = $_POST[$field];
        }
    }

    // Handle file upload (optional)
    if (!empty($_FILES['player_photo']['name'])) {
        $photoName = basename($_FILES['player_photo']['name']);
        $targetPath = '../uploads/' . $photoName;
        if (move_uploaded_file($_FILES['player_photo']['tmp_name'], $targetPath)) {
            $updateFields[] = "player_photo = :player_photo";
            $params[":player_photo"] = $photoName;
        }
    }

    $params[":id"] = $player_id;

    $query = "UPDATE players SET " . implode(', ', $updateFields) . " WHERE id = :id";
    $stmt = $bd->prepare($query);

    if ($stmt->execute($params)) {
        echo "Player information updated successfully.";
        header("Location: ../admin_general/index.php");
    } else {
        echo "Error updating player information.";
        header("Location: ../admin_general/gestion_modification_joueur.php");
    }
}
