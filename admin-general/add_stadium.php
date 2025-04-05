<?php
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $city = htmlspecialchars(trim($_POST["city"]));
    $construction_date = $_POST["construction_date"];
    $capacity = htmlspecialchars(trim($_POST["capacity"]));

    if (empty($name) || empty($city) || empty($construction_date) || empty($capacity)) {
        echo "Tous les champs sont obligatoires.";
        exit();
    }

    $status = "actif";

    try {
        // Vérifier si le stade existe déjà (par nom + ville)
        $checkQuery = "SELECT COUNT(*) FROM stadium WHERE nom = :name AND ville = :city";
        $checkStmt = $bd->prepare($checkQuery);
        $checkStmt->bindParam(':name', $name);
        $checkStmt->bindParam(':city', $city);
        $checkStmt->execute();
        $exists = $checkStmt->fetchColumn();

        if ($exists > 0) {
            echo "⚠️ Le stade '$name' à '$city' existe déjà dans la base de données.";
        } else {
            // Insertion du stade
            $query = "INSERT INTO stadium (nom, ville, date_de_creation, status, capacity) 
                      VALUES (:name, :city, :construction_date, :status, :capacity)";
            
            $stmt = $bd->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':construction_date', $construction_date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':capacity', $capacity);

            if ($stmt->execute()) {
                echo " Le stade a été ajouté avec succès !";
                header("Location: ../admin-general/index.php");
            } else {
                echo " Erreur lors de l'ajout du stade.";
                header("Location: ../admin-general/gestion_stade.php");
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Méthode non autorisée.";
}
?>
