<?php
$host = "localhost";
$dbname = "football_db";
$user = "root";
$password = "";

try {
    $bd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
