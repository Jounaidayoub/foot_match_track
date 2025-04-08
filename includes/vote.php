<?php
session_start();

require '../includes/db.php';

global $bd;

// get teams for a match not played yet
function getMatchInfo($match_id) {
    // AND (
    //     m.date_match < CURRENT_DATE OR 
    //     (m.date_match = CURRENT_DATE AND m.time_match < CURRENT_TIME)
    // )
    try {
        $sql = "
        SELECT 
            m.id_match,
            m.Nom_match,
            m.date_match,
            t1.id AS id_team1, 
            t2.id AS id_team2, 
            t1.team_name AS team1_name,
            t1.logo_path AS team1_logo,
            t2.team_name AS team2_name,
            t2.logo_path AS team2_logo,
        FROM _match m
        JOIN teams t1 ON m.id_equipe1 = t1.id
        JOIN teams t2 ON m.id_equipe2 = t2.id
        WHERE m.id_match = :id_match
        ORDER BY m.date_match DESC, m.time_match ASC
        ";

        $stmt = $bd->prepare($sql);
        $stmt->execute([
            ':id_match' => $match_id
        ]);
        $match_info = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($match_info) {
            $team1_name = $match_info['team1_name'];
            $team2_name = $match_info['team2_name'];
            $team1_id = $match_info['id_team1'];
            $team2_id = $match_info['id_team2'];
            return [
                'team1_name' => $team1_name,
                'team2_name' => $team2_name,
                'team1_id' => $team1_id,
                'team2_id' => $team2_id,
            ];
        } else {
            return null;
        }
    } catch (PDOException $e) {
        // Handle exception
        error_log("Database error: " . $e->getMessage());
        return null;
    }
}


//get teams id from a match
function getMatchTeams($match_id) {
    global $bd;
    try {
        $sql = "SELECT id_equipe1, id_equipe2 FROM _match WHERE id_match = :id_match";
        $stmt = $bd->prepare($sql);
        $stmt->execute([':id_match' => $match_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return null;
    }
}
?>