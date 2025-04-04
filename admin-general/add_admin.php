<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sécuriser les données reçues
    $first_name = htmlspecialchars(trim($_POST["first_name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST["password"]); // À hasher
    $tournament_id = intval($_POST["tournament"]);
    $role = "T";

    // Vérifier si l'email est valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Vérifier si l'email existe déjà
    $checkEmail = $bd->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->execute([$email]);
    if ($checkEmail->fetch()) {
        die("This email is already used.");
    }

    // Vérifier la force du mot de passe
    if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
        die("Password must be at least 8 characters long and include a number and an uppercase letter.");
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insérer l'admin tournoi
    $sql = "INSERT INTO users (nom, email, password, role, tournament_id) VALUES ( ?, ?, ?, ?, ?)";
    $stmt = $bd->prepare($sql);
    if ($stmt->execute([$first_name,  $email, $hashed_password, $role, $tournament_id])) {
        echo "Admin tournament added successfully!";
        header("Location: ../admin-general/index.php");
    } else {
        echo "Error adding admin.";
        header("Location: ../admin-general/gestion_admin_tournoi.php");
    }
}
?>