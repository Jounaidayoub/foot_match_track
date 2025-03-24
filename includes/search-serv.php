<?php

session_start();
require '../includes/db.php';

$query = isset($_GET["query"]) ? $_GET["query"] : "";

$teams = [];
$players = [];
global $bd;
if(isset($_GET["query"]) && !empty($_GET["query"])){
    $sql = "SELECT id, team_name, logo_path, city from teams where team_name like ?";
    $teams = $bd->prepare($sql);
    $teams->execute(["%$query%"]);
    $teams = $teams->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT players.id, first_name, last_name, player_photo, team_name from players 
            JOIN composer ON players.id = composer.id_player 
            JOIN teams ON teams.id = composer.id_team
            where first_name lIKE ? OR last_name like ?";
    $players = $bd->prepare($sql);
    $players->bindValue(1, "%$query%");
    $players->bindValue(2, "%$query%");
    // $players->execute(["%$query%","%$query%"]);
    $players->execute();
    $players = $players->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode([
    "teams" => $teams,
    "players" => $players
]);
?>