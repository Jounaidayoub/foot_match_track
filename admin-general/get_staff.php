<?php
session_start();
require_once '../includes/db.php';

if (isset($_POST['staff_id'])) {
    $staff_id = (int)$_POST['staff_id'];

    // Requête pour récupérer les informations du staff, y compris l'équipe et le pays
    $query = "SELECT s.id_staff, s.nom, s.prenom, s.role, s.photo, t.team_name, c.country_name
              FROM staff s
              LEFT JOIN teams t ON s.id_team = t.id
              LEFT JOIN countries c ON s.id_country = c.id
              WHERE s.id_staff = :staff_id";

    try {
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
        $stmt->execute();

        $staff = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($staff) {
            echo json_encode([
                'success' => true,
                'data' => $staff
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Staff not found.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}
?>
