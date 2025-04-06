<?php
session_start();
require '../includes/db.php';

function getPlayer($id){
    global $bd;
    $sql = "SELECT * from players 
            JOIN composer ON players.id = composer.id_player 
            JOIN teams ON teams.id = composer.id_team
            JOIN player_position ON composer.id_position = player_position.id
            JOIN countries ON players.id_country = countries.id
            where players.id = $id ";
    $player = $bd->query($sql);
    $player->execute();
    $player = $player->fetch(PDO::FETCH_ASSOC);
    return $player;
}
if(!isset($_GET['id']) || empty($_GET['id'])){	
    header("Location: ../home/home.php");
}
$id = $_GET['id'];//get id
$player = getPlayer($id);//get player
$ageSeconds = strtotime(date('Y-m-d')) - strtotime($player["birth_date"]);//get age in seconds
$player["age"] = floor($ageSeconds / 60 / 60 / 24 / 365);//convert seconds to years
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Profile</title>
    <link rel="stylesheet" href="home-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">

</head>
<body>
<style>
body{
    margin: 0;
}
</style>
<?php require('../includes/header.php');?>


    <div class="main_card" style="width: 800px; height: 400px;">
        <?php if(isset($player["player_photo"]) && !empty($player["player_photo"])):?>
            <div class="card" style="max-width: fit-content;">
                <img class="card" src="<?= !empty($player["player_photo"])? $player["player_photo"] : '../assets/imgs/no_user.jpg'?>" alt="Player Photo">
                <div class="gradient"></div>
            </div>
        <?php endif;?>
        <div class="player-details" style="padding: 1em">
            <h2 class="player-name"><?=$player["first_name"] . " " . $player["last_name"] ?></h2>
            <div class="player-info-grid" >
                <div class="info-item">
                    <div><?=$player["age"]?> years</div>
                    <div class="info-item-info""> Age</div>
                </div>
                <div class="info-item">
                <?=$player["team_name"]?> <img class="flag" src="../assets/<?= $player["logo_path"] ?>" style="width:20px; position: relative;top: -1px; left: 3px; vertical-align: middle;">  
                    <div class="info-item-info">Club</div>
                </div>
                <div class="info-item">
                    <?=$player["height"]?> 
                    <div class="info-item-info">Heghit</div>
                    </div>
                <div class="info-item"> <?=$player["position_name"]?> 
                    <div class="info-item-info">Position</div>
                </div>
                <div class="info-item"><?=$player["num_maillot"]?> 
                    <div class="info-item-info">Num</div>
                </div>
                <div class="info-item">
                    <?=$player["country_name"]?>  <span class="country-img fi fi-<?=strtolower($player['alpha2_code']) ?>"></span> 
                     <div class="info-item-info">Nationality</div>            
                </div>


            </div>
        </div>
    </div> 
        
    <div class="main_card stats " style="width: 370px ; height: 400px; padding: 1em ">

        <!-- <div class="card"> -->
            <!-- <div class="card"> -->
                <div class="player-stats" style="font-size: 1rem;">
                    <div class="stat"> <?=$player["goals"]?? ''?>
                        <div class="stats-under"> ⚽ Goals</div>
                    </div>
                    <div class="stat"> <?=$player["assists"]?? ''?>
                        <div class="stats-under"> 🦶 Assist</div>

                    </div>
                    <div class="stat">20
                        <div class="stats-under"> ✈ Matches</div>

                    </div>
                </div>
                <div class="separator"></div>
                <div class="next-game">
                    <!-- <div>
                        <span>Wolves</span>
                        <img class="flag" src="download.png" alt="Portugal Flag" style="width:40px; position: relative;top: -1px; left: 3px; vertical-align: middle;" >  
                        <span style="font-size: 15px;"> 18:30 </span>
                        <span></span><img class="flag" src="chealsea.png" alt="Portugal Flag" style="width:40px; position: relative;top: -1px; left: 3px; vertical-align: middle;"> Chealsea</span>

                    </div> -->

                    
                </div>
            <!-- </div> -->
            
        <!-- </div> -->
        
        
        <!-- Example: Insert this inside your existing div for the player profile -->
<!-- <div class="last-five-matches">
    <h3>Last three Matches</h3>
    <div class="match-list">
      <div class="match-item">
        <span class="match-date">Man city</span>
        <span class="match-opponent">🆚 Woleves</span>
        <span class="match-oponemnet">|</span>
        <span class="match-result win">  Rating  🔟</span>
      </div>
      <div class="match-item">
        <span class="match-date">Man city</span>
        <span class="match-opponent">🆚 Woleves</span>
        <span class="match-oponemnet">|</span>
        <span class="match-result win"> Rating  📁</span>
      </div>
      <div class="match-item">
        <span class="match-date">Lievrpool</span>
        <span class="match-opponent">🆚 Woleves</span>
        <span class="match-oponemnet">|</span>
        <span class="match-result win"> Rating  🎉</span>
      </div>
    
    
    
      
    </div>
  </div> -->
  
    </div>

        
       
    <!-- <div class="main_card" style="width: 800px; height:fit-content;flex-direction: column;">
        <h3 style="margin: 0px;padding: 0px;font-size: smaller;">Last 10 Matches</h3>
        <div class="tabel-container">
            <table class="match-table">
                 <thead> 
                  <tr class="table-header">
                    <th><i class="hgi-stroke hgi-calendar-03 " style="position:  relative; top: 2px;"></i>
                        Date</th>
                    <th><i class="hgi-stroke hgi-football"></i></th>
                    <th><i class="hgi-stroke hgi-football-pitch"></i></th>
                    <th><i class="hgi-stroke hgi-time-quarter-02"></i></th>
                    <th><i class="fa-solid fa-futbol"></i></th>
                    <th></th>
                    <th>🟨</th>
                    <th>🟥</th>
                    <th>Rating</th>
                  </tr>
                </thead> 
                <tbody> 
                  <tr class="table-row">
                    <td>Feb 15</td>
                    <td>
                        <img class="png-teams" src="vardy.png" alt="Portugal Flag" >  

                        Leicester City</td>
                    <td>0 - 2</td>
                    <td>90</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>8.5</td>
                  </tr>
                  <tr class="table-row">
                    <td>Feb 8</td>
                    <td>
                        <img class="png-teams" src="newcastle.png" alt="Portugal Flag" >  
                        Newcastle United</td>
                    <td>2 - 2</td>
                    <td>90</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>7.8</td>
                  </tr>
                <tr class="table-row">
                    <td>Feb 1</td>
                    <td>
                        <img class="png-teams" src="united.png" alt="Portugal Flag" >  
                        Manchester United</td>
                    <td>1 - 3</td>
                    <td>90</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>6.9</td>
                </tr>
                <tr class="table-row">
                    <td>Jan 25</td>
                    <td>
                        <img class="png-teams" src="arsenal.png" alt="Portugal Flag" >  
                        Arsenal</td>
                    <td>0 - 1</td>
                    <td>90</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>7.2</td>
                </tr>
                <tr class="table-row">
                    <td>Jan 18</td>
                    <td>
                        <img class="png-teams" src="djaj.png" alt="Portugal Flag" >  
                        Tottenham</td>
                    <td>2 - 1</td>
                    <td>90</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>8.0</td>
                </tr>
                <tr class="table-row">
                    <td>Jan 11</td>
                    <td>
                        <img class="png-teams" src="everton.png" alt="Portugal Flag" >  
                        Everton</td>
                    <td>1 - 1</td>
                    <td>90</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>7.5</td>
                </tr>
                <tr class="table-row">
                    <td>Jan 4</td>
                    <td>
                        <img class="png-teams" src="south.png" alt="Portugal Flag" >  
                        Southampton</td>
                    <td>3 - 0</td>
                    <td>90</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>9.0</td>
                </tr>
                <tr class="table-row">
                    <td>Dec 28</td>
                    <td>
                        <img class="png-teams" src="brighton.png" alt="Portugal Flag" >  
                        Brighton</td>
                    <td>0 - 0</td>
                    <td>90</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>7.0</td>
                </tr>
                <tr class="table-row">
                    <td>Dec 21</td>
                    <td>
                        <img class="png-teams" src="westham.png" alt="Portugal Flag" ">  
                        Burnley</td>
                    <td>2 - 2</td>
                    <td>90</td>
                    <td>1</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>8.3</td>
                </tr>
                <tr class="table-row">
                    <td>Dec 14</td>
                    <td>
                        <img class="png-teams" src="westham.png" alt="Portugal Flag" >  
                        West Ham</td>
                    <td>1 - 1</td>
                    <td>90</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>7.4</td>
                </tr>
              </table>
    </div> -->
         
<!-- filepath: c:\xampp\htdocs\foot_match_track\player\player-info.php -->
<!-- ...existing code... -->
<!-- <div class="main_card stats" style="width: 800px; height: auto; margin-top: 20px;font-size: 1rem; padding: 2em;">
    <h3 style="text-align: center; color: var(--primary-color);">Player Statistics</h3>
    <div class="player-stats-grid" style="width: 70%">
        <div class="stat-item">
            <i class="fa-solid fa-futbol stat-icon" style="color: black;"></i>
            <span class="stat-value"><?=$player["goals"] ?? 0?></span>
            <span class="stat-label">Goals</span>
        </div>
        <div class="stat-item">
            <i class="fa-solid fa-handshake stat-icon" style="color: black;"></i>
            <span class="stat-value"><?=$player["assists"] ?? 0?></span>
            <span class="stat-label">Assists</span>
        </div>
        <div class="stat-item">
            <i class="fa-solid fa-calendar-days stat-icon" style="color: black;"></i>
            <span class="stat-value"><?=$player["appearances"] ?? 0?></span>
            <span class="stat-label">Matches</span>
        </div>
        <div class="stat-item">
            <i class="fa-solid fa-ruler-vertical stat-icon" style="color: black;"></i>
            <span class="stat-value"><?=$player["height"] ?? 'N/A'?> cm</span>
            <span class="stat-label">Height</span>
        </div>
        <div class="stat-item">
            <i class="fa-solid fa-weight-scale stat-icon" style="color: black;"></i>
            <span class="stat-value"><?=$player["weight"] ?? 'N/A'?> kg</span>
            <span class="stat-label">Weight</span>
        </div>
        <div class="stat-item">
            <i class="fa-solid fa-person-running stat-icon" style="color: black;"></i>
            <span class="stat-value"><?=$player["position_name"] ?? 'N/A'?></span>
            <span class="stat-label">Position</span>
        </div>
    </div>
</div> -->

<style>
    .player-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .stat-item {
        text-align: center;
        background: var(--bg-darker);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }
    .stat-icon {
        font-size: 2.5em;
        margin-bottom: 10px;
    }
    .stat-value {
        font-size: 1.8em;
        font-weight: bold;
        color: var(--text-light);
    }
    .stat-label {
        font-size: 1em;
        color: var(--text-muted);
    }
</style>
<!-- ...existing code... -->

<style>
    .player-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 20px;
        margin-top: 10px;
    }
    .stat-item {
        text-align: center;
        background: #f9f9f9;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .stat-value {
        font-size: 1.5em;
        font-weight: bold;
        color: #333;
    }
    .stat-label {
        font-size: 0.9em;
        color: #666;
    }
</style>
<!-- ...existing code... -->
    </div>


    <!-- <div class="main_card"> test cards </div> -->
    <!-- <div class="main_card"> test cards </div> -->


    
</body>
</html>