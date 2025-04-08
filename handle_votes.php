<?php
session_start();

require 'includes/db.php';

global $bd;


// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                $team_id = intval($_POST['home_team_id']);
            } elseif ($vote_type === "away") {
                $team_id = intval($_POST['away_team_id']);
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
