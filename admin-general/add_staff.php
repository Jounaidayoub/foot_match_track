<?php
// Démarrer la session si nécessaire
session_start();

// Inclure le fichier de connexion à la base de données
require_once '../includes/db.php';

// Vérifier si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les valeurs du formulaire
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $nationality_id = intval($_POST['nationality']);  // ID du pays
    $role = htmlspecialchars($_POST['role']);
    $photo = htmlspecialchars($_POST['photo']);
    $team_id = intval($_POST['team']);  // ID de l'équipe

    // Préparer la requête SQL pour insérer les données dans la table `staff`
    $sql = "INSERT INTO staff (nom, prenom, role, photo, id_team, id_country) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    // Préparer la requête
    $stmt = $bd->prepare($sql);
    
    // Exécuter la requête en passant les valeurs récupérées du formulaire
    $stmt->execute([$last_name, $first_name, $role, $photo, $team_id, $nationality_id]);
    
    // Vérifier si l'insertion a réussi
    if ($stmt->rowCount() > 0) {
        // Succès - redirection ou message de succès
        echo "Staff member added successfully!";
        header('Location: ../admin-general/index.php');
        // Vous pouvez aussi rediriger l'utilisateur vers une autre page
        // header('Location: some_page.php');
    } else {
        // Erreur - message d'erreur
        echo "There was an error adding the staff member. Please try again.";
        header('Location: ../admin-general/gestion_staff.php');
    }
}
?>
