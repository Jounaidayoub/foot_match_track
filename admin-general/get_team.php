<?php
require '../includes/db.php';

header('Content-Type: application/json');

if (isset($_GET['team_id'])) {
    $team_id = $_GET['team_id'];

    try {
        $query = "SELECT * FROM teams WHERE id = :team_id";
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':team_id', $team_id, PDO::PARAM_INT);
        $stmt->execute();

        $team = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($team ? $team : ['error' => 'No team found']);
    } catch (Exception $e) {
        echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No team ID provided']);
}
?>
