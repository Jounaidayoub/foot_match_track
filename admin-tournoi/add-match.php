<?php
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Extract data from the request
    $tournament_id = $data['tournament_id'];
    $id_equipe1 = $data['id_equipe1'];
    $id_equipe2 = $data['id_equipe2'];
    $date_match = $data['date_match'];
    $time_match = $data['time_match'];
    $Nom_match = $data['Nom_match'] ?? null;
    $staduim = $data['staduim'] ?? null;
    $Nombre_spectateur = $data['Nombre_spectateur'] ?? 0;
    
    // Basic validation
    if (!$tournament_id || !$id_equipe1 || !$id_equipe2 || !$date_match || !$time_match) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }
    
    try {
        // Use backticks around _match to avoid SQL keyword issues
        $sql = "INSERT INTO `_match` (tournament_id, id_equipe1, id_equipe2, date_match, time_match, Nom_match, staduim, Nombre_spectateur) 
                VALUES (:tournament_id, :id_equipe1, :id_equipe2, :date_match, :time_match, :Nom_match, :staduim, :Nombre_spectateur)";
        
        $stmt = $bd->prepare($sql);
        $stmt->execute([
            'tournament_id' => $tournament_id,
            'id_equipe1' => $id_equipe1,
            'id_equipe2' => $id_equipe2,
            'date_match' => $date_match,
            'time_match' => $time_match,
            'Nom_match' => $Nom_match,
            'staduim' => $staduim,
            'Nombre_spectateur' => $Nombre_spectateur
        ]);
        
        // Get the ID of the inserted match
        $match_id = $bd->lastInsertId();
        
        echo json_encode(['success' => true, 'match_id' => $match_id]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>