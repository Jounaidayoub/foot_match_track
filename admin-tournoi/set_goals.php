<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Extract goal data
    $match_id = isset($data['match_id']) ? intval($data['match_id']) : 0;
    $team_id = isset($data['team_id']) ? intval($data['team_id']) : 0;
    $player_id = isset($data['player_id']) ? intval($data['player_id']) : 0;
    $assist_player_id = !empty($data['assist_player_id']) ? intval($data['assist_player_id']) : null;
    $goal_time = isset($data['goal_time']) ? intval($data['goal_time']) : 0;
    $goal_type = isset($data['goal_type']) ? $data['goal_type'] : 'regular'; // Note: different default value
    
    // Validate required data
    if (!$match_id || !$team_id || !$player_id || !$goal_time) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }
    
    try {
        // Insert goal into database with your table structure
        $sql = "INSERT INTO but (id_match, id_team, id_buteur, id_assisteur, minute, goal_type) 
                VALUES (:match_id, :team_id, :player_id, :assist_player_id, :goal_time, :goal_type)";
        
        $stmt = $bd->prepare($sql);
        $stmt->execute([
            'match_id' => $match_id,
            'team_id' => $team_id,
            'player_id' => $player_id,
            'assist_player_id' => $assist_player_id,
            'goal_time' => $goal_time,
            'goal_type' => $goal_type
        ]);
        
        $goal_id = $bd->lastInsertId();
        
        echo json_encode(['success' => true, 'goal_id' => $goal_id]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>