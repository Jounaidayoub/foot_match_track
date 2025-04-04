<?php
require_once '../includes/db.php'; // Assurez-vous d'inclure votre connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données du formulaire
    $prenom = htmlspecialchars(trim($_POST["first_name"]));
    $nom = htmlspecialchars(trim($_POST["last_name"]));
    $date_naissance = $_POST["birth_date"];

    // Vérification des champs obligatoires
    if (empty($prenom) || empty($nom) || empty($date_naissance)) {
        echo "Tous les champs sont obligatoires.";
        exit();
    }

    // Vérification si l'arbitre existe déjà dans la base de données
    $query_check = "SELECT COUNT(*) FROM refree WHERE nom = :nom AND prenom = :prenom";
    $stmt_check = $bd->prepare($query_check);
    $stmt_check->bindParam(':nom', $nom);
    $stmt_check->bindParam(':prenom', $prenom);
    $stmt_check->execute();
    
    if ($stmt_check->fetchColumn() > 0) {
        echo "Un arbitre avec ce nom et prénom existe déjà.";
        exit();
    }

    // Calcul de l'âge à partir de la date de naissance
    $date_naissance_obj = new DateTime($date_naissance);
    $now = new DateTime();
    $age = $date_naissance_obj->diff($now)->y;

    // Vérification de l'âge : il ne peut pas être inférieur à 18 ans
    if ($age < 18) {
        echo "L'âge de l'arbitre ne peut pas être inférieur à 18 ans.";
        header("Location: http://localhost/Projectfootball/admin-general/gestion_arbitre.php");
        exit();
    }

    // Déterminer le statut automatiquement (retraite si > 45 ans, sinon actif)
    $status = ($age > 45) ? "retraite" : "actif";

    try {
        // Requête d'insertion
        $query = "INSERT INTO refree (nom, prenom, date_de_naissance, status) VALUES (:nom, :prenom, :date_naissance, :status)";
        $stmt = $bd->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':date_naissance', $date_naissance);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            echo "Arbitre ajouté avec succès !";
            header("Location: ../admin-general/index.php");
        } else {
            echo "Erreur lors de l'ajout de l'arbitre.";
            header("Location: ../admin-general/gestion_arbitre.php");
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Méthode non autorisée.";
}
?>
