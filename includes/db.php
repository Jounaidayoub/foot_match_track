<?php
$host = "localhost";
$dbname = "football_db";
$user = "root";
$password = "";

try {
    $bd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}




function isFollowing($id_event, $id_user, $event_type){
    global $bd;
    
    $sql = "SELECT id FROM follow WHERE event_id = :id_event AND id_user = :id_user AND event_type = :event_type";
    $stmt = $bd->prepare($sql); 
    $stmt->execute(['id_event' => $id_event, 'id_user' => $id_user, 'event_type' => $event_type]); 
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $row ? true : false; 
}
?>
