<?php
require_once '../includes/db.php'; // Connexion à la base de données

// Vérifier si toutes les données sont envoyées
if (isset($_POST['staff_id1'], $_POST['first_name1'], $_POST['last_name1'], $_POST['birth_date1'])) {
    
    $refree_id = intval($_POST['staff_id1']);
    $prenom = htmlspecialchars($_POST['first_name1']);
    $nom = htmlspecialchars($_POST['last_name1']);
    $date_naissance = $_POST['birth_date1'];

    // Calculer l'âge à partir de la date de naissance
    $date_naissance_obj = new DateTime($date_naissance);
    $now = new DateTime();
    $age = $date_naissance_obj->diff($now)->y;

    // Vérifier si l'âge est valide (>= 18 ans)
    if ($age < 18) {
        echo json_encode(["success" => false, "message" => "L'âge de l'arbitre ne peut pas être inférieur à 18 ans."]);
        exit;
    }

    // Déterminer le statut automatiquement
    $status = ($age > 45) ? "retraite" : "actif";

    try {
        // Requête de mise à jour
        $query = "UPDATE refree SET prenom = ?, nom = ?, date_de_naissance = ?, status = ? WHERE id = ?";
        $stmt = $bd->prepare($query);
        $stmt->execute([$prenom, $nom, $date_naissance, $status, $refree_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Mise à jour réussie", "status" => $status]);
            header("Location: ../dashboard_admingenerale.php");
        } else {
            echo json_encode(["success" => false, "message" => "Aucune modification apportée"]);
            header("Location: ../dashboard_admingenerale.php");
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur SQL : " . $e->getMessage()]);
        header("Location: ../admin-general/index.php");
    }
} else {
    echo json_encode(["success" => false, "message" => "Tous les champs sont requis"]);
    header("Location: ../admin-general/gestion_arbitre.php");
}
?>
