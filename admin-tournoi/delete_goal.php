<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' || 
    ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE')) {
    
    // Get goal ID from URL parameter
    $goal_id = isset($_GET['goal_id']) ? intval($_GET['goal_id']) : 0;
    
    if (!$goal_id) {
        echo json_encode(['success' => false, 'error' => 'Invalid goal ID']);
        exit;
    }
    
    try {

        // Delete the goal from the database - adjusted for your table
        $sql = "DELETE FROM but WHERE id_but = :goal_id";
        $stmt = $bd->prepare($sql);
        $stmt->execute(['goal_id' => $goal_id]);
        
        // Check if goal was actually deleted
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Goal not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>