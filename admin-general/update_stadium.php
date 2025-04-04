<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données pour mise à jour
    $id = $_POST['staff_id1'];
    $name = htmlspecialchars(trim($_POST['name1']));
    $city = htmlspecialchars(trim($_POST['city1']));
    $construction_date = $_POST['construction_date1'];
    $status = $_POST['status1'];
    $capacity = htmlspecialchars(trim($_POST['capacity1']));

    if (empty($id) || empty($name) || empty($city) || empty($construction_date) || empty($status)|| empty($capacity)) {
        echo "⚠️ Tous les champs sont obligatoires.";
        exit();
    }

    try {
        $sql = "UPDATE stadium 
                SET nom = :name, ville = :city, date_de_creation = :construction_date, status = :status, capacity = :capacity  
                WHERE id = :id";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':construction_date', $construction_date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':capacity', $capacity);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo " Stade mis à jour avec succès.";
            header("Location: ../admin-general/index.php");
        } else {
            echo " Échec de la mise à jour.";
            header("Location: ../admin-general/gestion_stade.php");
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Chargement des données d'un stade via AJAX
    $id = $_GET['id'];
    $sql = "SELECT * FROM stadium WHERE id = :id";
    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $stadium = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($stadium);
}
?>
