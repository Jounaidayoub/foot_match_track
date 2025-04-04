<?php
session_start();
require '../includes/db.php';

// Récupérer les valeurs des inputs
$email = trim($_POST["email"] ?? '');
$pass = trim($_POST["password"] ?? '');
$type = $_POST["type"] ?? '';

if (empty($email) || empty($pass)) {
    $_SESSION["error-login"] = "Veuillez remplir tous les champs !";
    header("Location: auth.php");
    exit;
}

switch ($type) {
    case "login":
        checkUser($email, $pass);
        break;
    case "register":
        $nom = trim($_POST["nom"] ?? '');
        register($nom, $email, $pass);
        break;
    default:
        $_SESSION["error-login"] = "Action non reconnue.";
        header("Location: auth.php");
        exit;
}

function storeInSession($user) {
    $_SESSION["id"] = $user["id"];
    $_SESSION["nom"] = $user["nom"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["role"] = $user["role"];
    unset($_SESSION["error-login"]);
}

function checkUser($email, $pass) {
    global $bd;
    $sql = "SELECT id, nom, email, role, password FROM users WHERE email = ? AND password = ?";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$email, $pass]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //user existe
    if($user){
        //verifier le mot de passe 
        // if (password_verify($pass, $user['password'])) {
            storeInSession($user);
            redirectUser($user["role"]);
        // }
    } else {
        $_SESSION["error-login"] = "Email ou mot de passe incorrect.";
        header("Location: auth.php");
        exit;
    }
}

function register($nom, $email, $pass) {
    global $bd;
    if (empty($nom)) {
        $_SESSION["error-login"] = "Le nom est obligatoire.";
        header("Location: auth.php");
        exit;
    }
    
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION["error-login"] = "Cet utilisateur existe déjà.";
        header("Location: auth.php");
        exit;
    }

    // $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, 'u')";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$nom, $email, $pass]);

    checkUser($email, $pass);
}

function redirectUser($role) {
    $routes = [
        "u" => "../home/home.php",
        "g" => "../home/home.php",
        "t" => "../home/home.php"
    ];
    header("Location: " . ($routes[$role] ?? "auth.php"));
    echo $routes[$role];
    exit;
}
