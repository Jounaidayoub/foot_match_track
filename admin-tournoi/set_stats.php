<?php
require '../includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $match_id = $data['match_id'] ?? null;
    
    if (!$match_id || !is_numeric($match_id)) {
        echo json_encode(['success' => false, 'error' => 'Invalid match ID']);
        exit;
    }
    
    // Prepare update data
    $update_fields = [
        'home_possession' => $data['home_possession'] ?? 50,
        'away_possession' => $data['away_possession'] ?? 50,
        'home_shots' => $data['home_shots'] ?? 0,
        'away_shots' => $data['away_shots'] ?? 0,
        'home_shots_target' => $data['home_shots_target'] ?? 0,
        'away_shots_target' => $data['away_shots_target'] ?? 0,
        'home_corners' => $data['home_corners'] ?? 0,
        'away_corners' => $data['away_corners'] ?? 0,
        'home_fouls' => $data['home_fouls'] ?? 0,
        'away_fouls' => $data['away_fouls'] ?? 0,
        'home_passes' => $data['home_passes'] ?? 0,
        'away_passes' => $data['away_passes'] ?? 0,
    ];
    
    try {
        ///cehck if alrady there is stats
        $check_sql = "SELECT COUNT(*) FROM match_stats WHERE match_id = :match_id";
        $check_stmt = $bd->prepare($check_sql);
        $check_stmt->execute(['match_id' => $match_id]);
        $exists = $check_stmt->fetchColumn();
        
        if ($exists == 0) {
            // new stats
            $sql = "INSERT INTO match_stats (match_id, home_possession, away_possession, home_shots, away_shots,
                    home_shots_target, away_shots_target, home_corners, away_corners, home_fouls, away_fouls, 
                    home_passes, away_passes) 
                    VALUES (:match_id, :home_possession, :away_possession, :home_shots, :away_shots,
                    :home_shots_target, :away_shots_target, :home_corners, :away_corners, :home_fouls, :away_fouls,
                    :home_passes, :away_passes)";
        } else {
            // just update them
            $sql = "UPDATE match_stats SET 
                    home_possession = :home_possession,
                    away_possession = :away_possession,
                    home_shots = :home_shots,
                    away_shots = :away_shots,
                    home_shots_target = :home_shots_target,
                    away_shots_target = :away_shots_target,
                    home_corners = :home_corners,
                    away_corners = :away_corners,
                    home_fouls = :home_fouls,
                    away_fouls = :away_fouls,
                    home_passes = :home_passes,
                    away_passes = :away_passes
                    WHERE match_id = :match_id";
        }
        
        $stmt = $bd->prepare($sql);
        $update_fields['match_id'] = $match_id;
        $stmt->execute($update_fields);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>