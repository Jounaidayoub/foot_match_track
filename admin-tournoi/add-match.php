<?php
// filepath: c:\xampp\htdocs\foot_match_track\admin-general\add_match.php
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $tournament_id = $data['tournament_id'];
    $date_match = $data['date_match'];
    $time_match = $data['time_match'];
    $id_equipe1 = $data['id_equipe1'];
    $id_equipe2 = $data['id_equipe2'];
    $Nom_match = $data['Nom_match'] ?? null;

    // Validate input
    if (!is_numeric($tournament_id) || !is_numeric($id_equipe1) || !is_numeric($id_equipe2)) {
        echo json_encode(['error' => 'Invalid input']);
        exit;
    }

    // Insert match into the database
    $sql = "INSERT INTO match (tournament_id, date_match, time_match, id_equipe1, id_equipe2, Nom_match)
            VALUES (:tournament_id, :date_match, :time_match, :id_equipe1, :id_equipe2, :Nom_match)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'tournament_id' => $tournament_id,
        'date_match' => $date_match,
        'time_match' => $time_match,
        'id_equipe1' => $id_equipe1,
        'id_equipe2' => $id_equipe2,
        'Nom_match' => $Nom_match,
    ]);

    echo json_encode(['success' => true]);
}
?>