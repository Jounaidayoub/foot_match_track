<?php

//fetch teams


require '../includes/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    

    
    

    // fetch matches for the given tournamnt id
    $sql = "SELECT * FROM `teams`;";
    $stmt = $bd->prepare($sql);
    $stmt->execute();
    $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($teams);
}
// echo "<pre>";
// print_r($matches);
// echo "</pre>";
?>