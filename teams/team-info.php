<?php
session_start();
require '../includes/db.php';
    $id = $_GET["idTeam"];
    if(!isset($_GET["idTeam"])) header("Location: ../home/home.php");

    function getTeam($id){
        global $bd;
        $sql = "SELECT * FROM teams where id = :id";
        $pst = $bd->prepare($sql);
        $pst->bindValue("id", $id);
        $pst->execute();
        $team = $pst->fetch(PDO::FETCH_ASSOC);
        return $team;
    }

    function getStaffByIdTeam($idTeam){
        global $bd;
        $sql = "SELECT * FROM staff join countries on staff.id_country = countries.id where id_team = :idTeam";
        $pst = $bd->prepare($sql);
        $pst->bindValue("idTeam", $idTeam);
        $pst->execute();
        $staff = $pst->fetchAll(PDO::FETCH_ASSOC);
        return $staff;
    }

    $team = getTeam($id);
    if($team == false ) header("Location: ../home/home.php");
    $staff = getStaffByIdTeam($id);

    // players
    /** TO DO: get players by team id 
    */
    function getPlayersByPosition($idTeam){
        global $bd;
        $sql = " SELECT position_name , first_name, last_name, country_name, alpha2_code  
                FROM players JOIN composer on players.id = composer.id_player
                JOIN teams on composer.id_team = teams.id
                JOIN player_position on composer.id_position = player_position.id 
                left join countries on players.id_country = countries.id 
                where composer.id_team = :idTeam
                order by player_position.position_name 
                ";
        $pst = $bd->prepare($sql);
        $pst->bindValue("idTeam", $idTeam);
        $pst->execute();

        $players_by_position = [];

        // if ($result->num_rows > 0) {
            while ($row = $pst->fetch(PDO::FETCH_ASSOC)) {
                $players_by_position[$row['position_name']][] = $row;
            }
        // }

        return $players_by_position;
    }

    $players_by_position = getPlayersByPosition($id);
    // print_r($staff);
    // print_r($team);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="team-page-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">
<!-- use: https://www.iso.org/obp/ui/ -->
</head>
<!-- <body style="background-color: white"> -->
<body style="background-color: white">

<?php require('../includes/header.php');?>


    <!-- the header -->
    <header class="header">
        <section class="header-subsec1">
            <div class="header-subsec1-team">
                <div class="header-subsec1-team-img-container">
                    <img src="../assets/<?= $team["logo_path"] ?>" alt="">
                </div>
                <div class="header-subsec1-team-title">
                    <h3 class="white-font"><?= $team["team_name"] ?></h3>
                    <h4 class="grey-font"><?=$team["city"] ?></h4>
                </div>
            </div>
            <button class="header-subsec1-calendar white-font tooltiped" data-tooltip="Ajouter Les matches du Arsenal dans votre Google calendar">Sync to calendar 🗓️</button>
        </section>
        <section class="header-nav">
            <ul class="header-nav-ul">
                <li class="header-nav-li white-font team-nav-selected">Overview</li>
                <li class="header-nav-li grey-font">Table </li>
                <li class="header-nav-li grey-font">Fixture</li>
                <li class="header-nav-li grey-font">Squad</li>
                <li class="header-nav-li grey-font">Stats</li>
                <li class="header-nav-li grey-font">Transfers</li>
                <li class="header-nav-li grey-font">History</li>
                <li class="header-nav-li grey-font">News</li>
            </ul>
        </section>
    </header>
    <!-- End of the header -->

    <!-- main -->
     

    <!-- players -->
    <main class="staff-container">
        <!-- this section is for a specific type of staff(coach, Defenders, Medecins) -->
         
        <?php foreach ($players_by_position as $position => $players) : ?>
        <section class="staff-subcontainer">
            <h3 class="white staff-title white-font"><?= $position?></h3>
            <section class="staff-section">
                <!-- this card represent a staff member(a player, a coach, a medecin) -->

                <?php foreach ($players as $player) : ?>
                <a href="" class="staff-card">
                    <div class="staff-card-person">
                        <img src="<?= !empty($player["player_photo"])? $player["player_photo"] : '../assets/imgs/no_user.jpg'?>" alt="" >
                    </div>
                    <div class="staff-card-info">
                        <h3 class="staff-name white-font"><?=$player['first_name'] .' ' . $player['last_name'] ?></h3>
                        <h4 class="staff-country grey-font">
                            <span class="country-img fi fi-<?=strtolower($player['alpha2_code']) ?>"></span>
                            <?=$player['country_name'] ?></h4>
                    </div>
                </a>
                <?php endforeach;?>

            </section>
        </section>
        <?php endforeach;?>                



<style>
.badge{
    background-color: var(--third-clr);
    padding: .2em .6em .3em;
    font-size: 65%;
    font-weight: 700;
    line-height: 1;
    color: #000;
    position: absolute;
    top: 8px;
    right: 8px;
    border-radius: .25em;
    margin: 0 0 auto auto;
}

</style>

        <!-- staff -->
        <!-- this section is for a specific type of staff(coach, Medecins) -->
        <section class="staff-subcontainer">
            <h3 class="white staff-title white-font">Staff</h3>
            <section class="staff-section">
                <!-- this card represent a staff member(a player, a coach, a medecin) -->
                <?php foreach($staff as $s): ?>

                    <a href="" class="staff-card" style="position:relative;">
                        <span class="badge"><?= $s["role"]?></span>
                        <div class="staff-card-person">
                            <img src="<?= !empty($s["photo"])? $s["photo"] : '../assets/imgs/no_user.jpg'?>" alt="">
                        </div>
                        <div class="staff-card-info">
                            <h3 class="staff-name white-font"><?= $s["nom"]?> <?= $s["prenom"]?></h3>
                            <h4 class="staff-country grey-font">
                                <span class="country-img fi fi-<?=strtolower($s["alpha2_code"])?>"></span>
                                <?= $s["country_name"]?></h4>
                        </div>
                    </a>

                <?php endforeach;?>                
            </section>
        </section>
    </main>

    <!-- end of main -->
</body>
</html>