<?php
session_start();

require 'includes/db.php';

global $bd;

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

//function to check if the match has ended or not
function isMatchEnded($match_id) {
    global $bd;
    try {
        $sql = "SELECT date_match, time_match FROM _match WHERE id_match = :id_match";
        $stmt = $bd->prepare($sql);
        $stmt->execute([':id_match' => $match_id]);
        $match_info = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($match_info) {
            $match_date_time = strtotime($match_info['date_match'] . ' ' . $match_info['time_match']);
            return time() > $match_date_time + 10800; // 3 hours after the match time
        } else {
            return false; // Match not found
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //pas possible de voter après la fin de match
    if(isMatchEnded(intval($_POST['match_id']))) {
        echo json_encode(["status" => "error", "message" => "You cannot vote for a match that has already ended."]);
        exit;
    }
    $user_id = $_SESSION['id'];
    $match_id = intval($_POST['match_id']);
    $vote_type = $_POST['vote_type']; // "home", "draw", or "away"

    try {
        // Check if the user has already voted for this match
        $checkVoteQuery = "SELECT * FROM votes WHERE user_id = :user_id AND match_id = :match_id";
        $stmt = $bd->prepare($checkVoteQuery);
        $stmt->execute(['user_id' => $user_id, 'match_id' => $match_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "error", "message" => "You have already voted for this match."]);
        } else {
            // Insert the vote
            $team_id = null; // Default to null for "draw" votes
            if ($vote_type === "home") {
                $team_id = intval(getMatchTeams($match_id)['id_equipe1']);
            } elseif ($vote_type === "away") {
                $team_id = intval(getMatchTeams($match_id)['id_equipe2']);
            }

            $insertVoteQuery = "INSERT INTO votes (user_id, match_id, team_id) VALUES (:user_id, :match_id, :team_id)";
            $stmt = $bd->prepare($insertVoteQuery);
            $stmt->execute(['user_id' => $user_id, 'match_id' => $match_id, 'team_id' => $team_id]);

            echo json_encode(["status" => "success", "message" => "Vote recorded successfully."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Failed to record vote: " . $e->getMessage()]);
    }
}

// Handle GET request to fetch poll results
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $match_id = intval($_GET['match_id']);

    try {
        // Fetch vote counts
        $homeVotesQuery = "SELECT COUNT(*) AS home_votes FROM votes WHERE match_id = :match_id AND team_id = (SELECT id_equipe1 FROM _match WHERE id_match = :match_id)";
        $drawVotesQuery = "SELECT COUNT(*) AS draw_votes FROM votes WHERE match_id = :match_id AND team_id IS NULL";
        $awayVotesQuery = "SELECT COUNT(*) AS away_votes FROM votes WHERE match_id = :match_id AND team_id = (SELECT id_equipe2 FROM _match WHERE id_match = :match_id)";

        $stmt = $bd->prepare($homeVotesQuery);
        $stmt->execute(['match_id' => $match_id]);
        $homeVotes = $stmt->fetch(PDO::FETCH_ASSOC)['home_votes'] ?? 0;

        $stmt = $bd->prepare($drawVotesQuery);
        $stmt->execute(['match_id' => $match_id]);
        $drawVotes = $stmt->fetch(PDO::FETCH_ASSOC)['draw_votes'] ?? 0;

        $stmt = $bd->prepare($awayVotesQuery);
        $stmt->execute(['match_id' => $match_id]);
        $awayVotes = $stmt->fetch(PDO::FETCH_ASSOC)['away_votes'] ?? 0;

        echo json_encode([
            "status" => "success",
            "home" => $homeVotes,
            "draw" => $drawVotes,
            "away" => $awayVotes
        ]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Failed to fetch poll results: " . $e->getMessage()]);
    }
}
?>
