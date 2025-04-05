<?php
require_once '../includes/db.php';

if (isset($_GET['stadium_name'])) {
    $stadium_name = $_GET['stadium_name'];

    // Préparer et exécuter la requête pour obtenir la capacité du stade
    $query = "SELECT capacity FROM stadium WHERE nom = :stadium_name";
    $stmt = $bd->prepare($query);
    $stmt->bindParam(':stadium_name', $stadium_name, PDO::PARAM_STR);
    $stmt->execute();

    // Vérifier si une capacité est retournée
    $stadium = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stadium) {
        // Renvoi de la capacité sous forme JSON
        echo json_encode(['capacity' => $stadium['capacity']]);
    } else {
        // Si aucun stade n'est trouvé
        echo json_encode(['capacity' => '']);
    }
}
?>
