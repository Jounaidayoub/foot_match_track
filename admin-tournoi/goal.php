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
    $goal_type = isset($data['goal_type']) ? $data['goal_type'] : 'normal';
    
    // Validate required data
    if (!$match_id || !$team_id || !$player_id || !$goal_time) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }
    
    try {
        // Insert goal into database
        $sql = "INSERT INTO goals (match_id, team_id, player_id, assist_player_id, goal_time, goal_type) 
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
        
        // Update match score
        updateMatchScore($bd, $match_id);
        
        echo json_encode(['success' => true, 'goal_id' => $goal_id]);
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
}

// Function to update match score based on goals
function updateMatchScore($db, $match_id) {
    // Get all goals for the match
    $sql = "SELECT g.*, m.id_equipe1 as home_team_id, m.id_equipe2 as away_team_id 
            FROM goals g
            JOIN _match m ON g.match_id = m.id_match
            WHERE g.match_id = :match_id";
            
    $stmt = $db->prepare($sql);
    $stmt->execute(['match_id' => $match_id]);
    $goals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate scores
    $home_score = 0;
    $away_score = 0;
    $home_team_id = null;
    $away_team_id = null;
    
    foreach ($goals as $goal) {
        // Set team IDs from the first goal record
        if (!$home_team_id) {
            $home_team_id = $goal['home_team_id'];
            $away_team_id = $goal['away_team_id'];
        }
        
        // Normal goal logic - team who scored gets a point
        if ($goal['goal_type'] !== 'own-goal') {
            if ($goal['team_id'] == $home_team_id) {
                $home_score++;
            } else {
                $away_score++;
            }
        } 
        // Own goal logic - opposite team gets a point
        else {
            if ($goal['team_id'] == $home_team_id) {
                $away_score++;
            } else {
                $home_score++;
            }
        }
    }
    
    // Update match scores
    $update_sql = "UPDATE _match 
                   SET home_score = :home_score, away_score = :away_score 
                   WHERE id_match = :match_id";
                   
    $update_stmt = $db->prepare($update_sql);
    $update_stmt->execute([
        'home_score' => $home_score,
        'away_score' => $away_score,
        'match_id' => $match_id
    ]);
}
?>