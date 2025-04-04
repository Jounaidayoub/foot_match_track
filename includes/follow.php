<?php
session_start();
require '../includes/db.php';

global $bd;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id_event = $_POST['id_event'] ;
    $event_type= $_POST["event_type"] ;
    $id_user = $_SESSION['id']; 
    if (isset($id_event) && isset($event_type) && isset($id_user) && (isFollowing( $id_event, $id_user, $event_type)=== false) ) {
        try {
            $sql = "INSERT INTO follow (event_id, id_user, event_type) VALUES (:id_event, :id_user, :event_type)";

            $stmt = $bd->prepare($sql);
            $stmt->execute([
                'id_event' => $id_event,
                'event_type' => $event_type,
                'id_user' => $id_user
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    }
}

?>