<?php
session_start();
require '../includes/db.php';

//get the latest played matches
function getLatestMatches($limit = 10){
    global $bd;
    //create a view of the latest matches
    $LatestMatchesView = " CREATE OR REPLACE VIEW latest_matches AS SELECT DISTINCT 
            m.id_match AS id_match, 
            m.Nom_match, 
            m.date_match, 
            m.time_match, 
            t1.id AS id_team1, 
            t2.id AS id_team2, 
            t1.team_name AS team1_name, 
            t1.logo_path AS team1_logo, 
            t2.team_name AS team2_name, 
            t2.logo_path AS team2_logo
        FROM _match m
        JOIN teams t1 ON id_equipe1 = t1.id
        JOIN teams t2 ON id_equipe2 = t2.id
        WHERE 
            (date_match < CURRENT_DATE) 
            OR 
            (date_match = CURRENT_DATE AND time_match < (CURRENT_TIME + INTERVAL 3 HOUR))
        ORDER BY date_match DESC, time_match ASC
    ";
    $bd->query($LatestMatchesView)->execute();


    //Get scores table
    $ScoreView = "CREATE OR REPLACE VIEW score AS select b.id_match, b.id_team, count(b.id_match) as butes
                         from latest_matches l JOIN but b on l.id_match = b.id_match
                         group by b.id_team, b.id_match  ";
    $bd->query($ScoreView)->execute();

    $matchInfo = "CREATE OR REPLACE VIEW match_info AS SELECT 
                l.Nom_match ,l.date_match  ,l.team1_name ,l.team1_logo ,l.team2_name ,
                l.team2_logo, l.id_match, l.id_team1, l.id_team2, s1.butes as 'butes_team1', s2.butes as 'butes_team2' 
                FROM  latest_matches l join score s1 JOIN score s2 
                on l.id_match = s1.id_match and l.id_match = s2.id_match 
                and l.id_team1 = s1.id_team and l.id_team2 = s2.id_team
            ";
    $bd->query($matchInfo)->execute();

    $stmt = $bd->query("SELECT * FROM match_info limit $limit");

    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

  
    //Get scores

    return $matches;
}

function getComingMatches($limit = 10){
    global $bd;
    $comingSql = "SELECT id_match, Nom_match, date_match, time_match,  t1.id AS id_team1, t1.team_name AS team1_name, t1.logo_path AS team1_logo,t1.id AS id_team2, t2.team_name AS team2_name, t2.logo_path AS team2_logo
            FROM _match JOIN teams t1, teams t2 where id_equipe1=t1.id and id_equipe2=t2.id
            AND 
                (date_match > CURRENT_DATE) 
                OR (date_match = CURRENT_DATE AND time_match > CURRENT_TIME)
            ORDER BY date_match ASC, time_match ASC limit $limit
            ";
    $comingStmt = $bd->query($comingSql);
    $comingStmt->execute();
    $matches = $comingStmt->fetchAll(PDO::FETCH_ASSOC);
    return $matches;
}

$comingMatches = getComingMatches();
$closestMatch = $comingMatches[0];
$latestMatches = getLatestMatches(10);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="home-style.css">

    <link
  href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
  rel="stylesheet"
/>

</head>
<body>

<?php require('../includes/header.php') ?>

<main class="match-container">
  <div class="match-layout">
    <section class="match-video-section">
      <!-- <img
        src="../assets/://cdn.builder.io/api/v1/image/assets/TEMP/e84e93d41cdedb2ab30d787c222706464117e11247d92ef306a3b5e1456b33e8?placeholderIfAbsent=true&apiKey=b69a661c5a894991ba35079be4d28be0"
        class="match-video"
        alt="Live match stream"
      /> -->

    <img src="../assets/<?= $closestMatch["team1_logo"]?>" alt="">
      <div class="info">
        <h2 class="info-match-name"><?= $closestMatch ? $closestMatch["Nom_match"] : ''?></h2>
        <h2 class="info-match-date"><?= $closestMatch ? $closestMatch["date_match"] : ''?></h2>
        <h2 class="info-match-time"><?= $closestMatch ? $closestMatch["time_match"] : ''?></h2>
      </div>
      <img src="../assets/<?= $closestMatch["team2_logo"]?>" alt="">
    </section>
    <section class="stats-section">
      <article class="stats-card">
        <header class="match-header">
          <h1 class="match-status">Latest Match</h1>
          <p class="match-time"><?=$latestMatches[0]["Nom_match"]?></p>
        </header>
        <section class="teams-score">
          <img
            src="../assets/<?=$latestMatches[0]["team1_logo"]?>"
          class="team-logo"
            alt="Home team logo"
          />
          <p class="score-display">2 - 2</p>
          <img
          src="../assets/<?=$latestMatches[0]["team2_logo"]?>"
          class="team-logo"
            alt="Away team logo"
          />
        </section>
        <section class="match-stats">
          <div class="stat-group">
            <h2 class="stat-title">Shoot on Target</h2>
            <div class="stat-values">
              <span class="home-stat">7</span>
              <span class="away-stat">3</span>
            </div>
          </div>
          <div class="stat-group">
            <h2 class="stat-title">Shoot</h2>
            <div class="stat-values">
              <span class="home-stat">12</span>
              <span class="away-stat">7</span>
            </div>
          </div>
          <div class="stat-group">
            <h2 class="stat-title">Fouls</h2>
            <div class="stat-values">
              <span class="home-stat">7</span>
              <span class="away-stat">3</span>
            </div>
          </div>
        </section>
      </article>
    </section>
  </div>
</main>

<!-- home matches -->
<?php
//get the latest played matches
/*
function getLatestMatches(){
    global $bd;
    $sql = "SELECT DISTINCT 
            id_match, 
            Nom_match, 
            date_match, 
            time_match, 
            t1.team_name AS team1_name, 
            t1.logo_path AS team1_logo, 
            t2.team_name AS team2_name, 
            t2.logo_path AS team2_logo
        FROM _match 
        JOIN teams t1 ON id_equipe1 = t1.id
        JOIN teams t2 ON id_equipe2 = t2.id
        WHERE 
            (date_match < CURRENT_DATE) 
            OR 
            (date_match = CURRENT_DATE AND time_match < (CURRENT_TIME + INTERVAL 3 HOUR))
        ORDER BY date_match DESC, time_match ASC
    ";
    $stmt = $bd->query($sql);
    $stmt->execute();
    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $matches;
}
*/
// $latestMatches = getLatestMatches();
// // print_r($latestMatches);
// $comingMatches = [];
?>

<main class="container">
  <header class="header">
    <h1 class="title">⚽ Football Match</h1>
      <ul class="menu-items">
        <li class="menu-item active" onclick="show('latest-matches', event)" >Latest Match</li>
        <li class="menu-item"  onclick="show('coming-matches', event)" >Coming Match</li>
        <li class="menu-item">Pre-season</li>
      </ul>
  </header>

  <!-- latest matches -->
  <section class="matches " id="latest-matches">
    <?php foreach($latestMatches as $match): ?>
    <article class="match">
      <div class="team-section">

        <a href="../teams/<?= $match["id_team1"]?>" class="team">
          <img
            src="../assets/<?= $match["team1_logo"]?>"
            alt="<?= $match["team1_name"]?>"
            class="team-flag"
          />
          <h2 class="team-name"><?= $match["team1_name"]?></h2>
        </a>

        <div class="score"><?=isset($match["butes_team1"]) ? $match["butes_team1"] : ""?> - <?=isset($match["butes_team1"]) ? $match["butes_team2"] : ""?></div>
        
        <a href="../teams/<?= $match["id_team2"]?>" class="team right">
          <h2 class="team-name right"><?= $match["team2_name"]?></h2>
          <img
            src="../assets/<?= $match["team2_logo"]?>"
            alt="<?= $match["team2_name"]?>"
            class="team-flag"
          />
        </a>

      </div>
      <div class="match-status">Full - Time</div>
      <div class="match-info">
        <time class="match-date"><?= $match["date_match"]?></time>
        <div class="match-icons">
          <button class="icon-button" aria-label="Match Information">
            <svg
              class="info-icon"
              width="24"
              height="24"
              viewBox="0 0 25 25"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M12.5 22.5C6.977 22.5 2.5 18.023 2.5 12.5C2.5 6.977 6.977 2.5 12.5 2.5C18.023 2.5 22.5 6.977 22.5 12.5C22.5 18.023 18.023 22.5 12.5 22.5ZM12.5 20.5C14.6217 20.5 16.6566 19.6571 18.1569 18.1569C19.6571 16.6566 20.5 14.6217 20.5 12.5C20.5 10.3783 19.6571 8.34344 18.1569 6.84315C16.6566 5.34285 14.6217 4.5 12.5 4.5C10.3783 4.5 8.34344 5.34285 6.84315 6.84315C5.34285 8.34344 4.5 10.3783 4.5 12.5C4.5 14.6217 5.34285 16.6566 6.84315 18.1569C8.34344 19.6571 10.3783 20.5 12.5 20.5V20.5ZM11.5 7.5H13.5V9.5H11.5V7.5ZM11.5 11.5H13.5V17.5H11.5V11.5Z"
                fill="#A4A4A4"
              />
            </svg>
          </button>
          <button class="icon-button" aria-label="Match Statistics">
            <svg
              class="stats-icon"
              width="24"
              height="24"
              viewBox="0 0 25 25"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M5.53133 3.5V19.5H21.7819V21.5H3.5V3.5H5.53133ZM21.0639 6.793L22.5 8.207L16.7036 13.914L13.6566 10.915L9.29639 15.207L7.86024 13.793L13.6566 8.086L16.7036 11.085L21.0639 6.793V6.793Z"
                fill="#A4A4A4"
              />
            </svg>
          </button>
        </div>
      </div>
    </article>
    <?php endforeach;?>
  </section>


  <!-- coming matches -->
  <section class="matches hidden" id="coming-matches">
    
    <?php
     foreach($comingMatches as $match): 
     ?>
    <article class="match">
      <div class="team-section">
        <a href="../teams/<?= $match["id_team1"]?>" class="team" >
          <img
            src="../assets/<?= $match["team1_logo"]?>"
            alt="<?= $match["team1_name"]?>"
            class="team-flag"
          />
          <h2 class="team-name"><?= $match["team1_name"]?></h2>
        </a>

        <div class="score"></div>

        <a href="../teams/<?= $match["id_team2"]?>" class="team right">
          <h2 class="team-name right"><?= $match["team2_name"]?></h2>
          <img
            src="../assets/<?= $match["team2_logo"]?>"
            alt="<?= $match["team2_name"]?>"
            class="team-flag"
          />
     </a>

      </div>
      <div class="match-status">Full - Time</div>
      <div class="match-info">
        <time class="match-date"><?= $match["date_match"]?></time>
        <div class="match-icons">
          <button class="icon-button" aria-label="Match Information">
            <svg
              class="info-icon"
              width="24"
              height="24"
              viewBox="0 0 25 25"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M12.5 22.5C6.977 22.5 2.5 18.023 2.5 12.5C2.5 6.977 6.977 2.5 12.5 2.5C18.023 2.5 22.5 6.977 22.5 12.5C22.5 18.023 18.023 22.5 12.5 22.5ZM12.5 20.5C14.6217 20.5 16.6566 19.6571 18.1569 18.1569C19.6571 16.6566 20.5 14.6217 20.5 12.5C20.5 10.3783 19.6571 8.34344 18.1569 6.84315C16.6566 5.34285 14.6217 4.5 12.5 4.5C10.3783 4.5 8.34344 5.34285 6.84315 6.84315C5.34285 8.34344 4.5 10.3783 4.5 12.5C4.5 14.6217 5.34285 16.6566 6.84315 18.1569C8.34344 19.6571 10.3783 20.5 12.5 20.5V20.5ZM11.5 7.5H13.5V9.5H11.5V7.5ZM11.5 11.5H13.5V17.5H11.5V11.5Z"
                fill="#A4A4A4"
              />
            </svg>
          </button>
          <button class="icon-button" aria-label="Match Statistics">
            <svg
              class="stats-icon"
              width="24"
              height="24"
              viewBox="0 0 25 25"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M5.53133 3.5V19.5H21.7819V21.5H3.5V3.5H5.53133ZM21.0639 6.793L22.5 8.207L16.7036 13.914L13.6566 10.915L9.29639 15.207L7.86024 13.793L13.6566 8.086L16.7036 11.085L21.0639 6.793V6.793Z"
                fill="#A4A4A4"
              />
            </svg>
          </button>
        </div>
      </div>
    </article>
    <?php endforeach;?>
  </section>
</main>



<script>

    function show(id, event){
        document.querySelectorAll(".matches").forEach((elm)=>{
            elm.classList.add("hidden");
        })
        document.getElementById(id).classList.remove("hidden");
        // change <li> style
        setActive(event)
    }

    //set the <li> to be active(just change the style so it's shown as if it's selected)
    function setActive(event){
        document.querySelectorAll(".active").forEach((elm)=>{
            elm.classList.remove("active");
        })
        event.target.classList.add("active");
    }

</script>
</body>
</html>