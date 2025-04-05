<?php

// session_start();
require_once 'db.php'; // Assurez-vous que le chemin est correct
function getTournamentClassement($tournament_id)
{
    global $bd;

    $sql = "SELECT 
        t.id AS team_id,
        t.team_name,
        t.logo_path,
        COALESCE(SUM(CASE 
            WHEN t.id = m.id_equipe1 AND COALESCE(s1.butes, 0) > COALESCE(s2.butes, 0) THEN 3
            WHEN t.id = m.id_equipe2 AND COALESCE(s2.butes, 0) > COALESCE(s1.butes, 0) THEN 3
            WHEN t.id IN (m.id_equipe1, m.id_equipe2) AND COALESCE(s1.butes, 0) = COALESCE(s2.butes, 0) THEN 1
            ELSE 0
        END), 0) AS points,
        COALESCE(SUM(CASE 
            WHEN t.id = m.id_equipe1 THEN COALESCE(s1.butes, 0) - COALESCE(s2.butes, 0)
            WHEN t.id = m.id_equipe2 THEN COALESCE(s2.butes, 0) - COALESCE(s1.butes, 0)
            ELSE 0
        END), 0) AS goal_difference,
        COALESCE(SUM(CASE 
            WHEN t.id = m.id_equipe1 THEN COALESCE(s1.butes, 0)
            WHEN t.id = m.id_equipe2 THEN COALESCE(s2.butes, 0)
            ELSE 0
        END), 0) AS goals_scored
    FROM teams t
    LEFT JOIN _match m 
        ON t.id IN (m.id_equipe1, m.id_equipe2)
        AND m.tournament_id = 1
    LEFT JOIN (
        SELECT id_match, id_team, COUNT(*) AS butes
        FROM but
        GROUP BY id_match, id_team
    ) s1 ON m.id_match = s1.id_match AND m.id_equipe1 = s1.id_team
    LEFT JOIN (
        SELECT id_match, id_team, COUNT(*) AS butes
        FROM but
        GROUP BY id_match, id_team
    ) s2 ON m.id_match = s2.id_match AND m.id_equipe2 = s2.id_team
    GROUP BY t.id
    ORDER BY points DESC, goal_difference DESC, goals_scored DESC, t.team_name ASC;
    ";
    $stmt = $bd->prepare($sql);
    // $stmt->bindValue(':tournament_id', intval($tournament_id), PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// echo getTournamentClassement(1);
// Use the variable passed from the including file
$tournament_id = $tournament_id_for_classement ?? 1; // Default to tournament ID 1 if not set
$classement = getTournamentClassement($tournament_id);
?>

    <h1>Classement</h1>
    <table class="classement-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Team</th>
                <th>Points</th>
                <th>Goal Difference</th>
                <th>Goals Scored</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classement as $index => $team): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td>
                        <img src="../assets/<?= $team['logo_path'] ?>" alt="<?= $team['team_name'] ?>" class="team-logo">
                        <?= $team['team_name'] ?>
                    </td>
                    <td><?= $team['points'] ?></td>
                    <td><?= $team['goal_difference'] ?></td>
                    <td><?= $team['goals_scored'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
