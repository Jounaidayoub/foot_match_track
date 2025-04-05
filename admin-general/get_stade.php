<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $stmt = $bd->prepare("SELECT * FROM stadium WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stadium = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stadium) {
            echo json_encode($stadium);
        } else {
            echo json_encode(['error' => 'Stade introuvable.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Requête invalide.']);
}
