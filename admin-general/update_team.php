<?php
// Assuming you have already established a connection to the database
session_start();
require_once '../includes/db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $team_id = $_POST['team1']; // ID of the team to update
    $team_name = $_POST['team_name1'];
    $country_name = $_POST['nationality2'];
    $city_name = $_POST['city_name1'];
    $logo_path = $_POST['logo_path1'];
    $founded_year = $_POST['founded_year1'];
    $head_coach = $_POST['staff_id9'];
    $primary_color = $_POST['primary_color1'];
    $secondary_color = $_POST['secondary_color1'];
    $home_stadium = $_POST['home_stadium1'];
    $stadium_capacity = $_POST['stadium_capacity1'];
    $website = $_POST['website1'];
    $email = $_POST['email1'];
    $phone = $_POST['phone1'];
    $address = $_POST['address1'];
    $assistant_coach = $_POST['staff_id6'];
    $team_manager = $_POST['staff_id7'];
    $physiotherapist = $_POST['staff_id8'];
    $history = $_POST['history1'];

    // Update the team data in the database
    $query = "UPDATE teams SET 
                team_name = :team_name, 
                country = :country_name,  -- Fixed this
                city = :city_name,        -- Fixed this
                logo_path = :logo_path, 
                founded_year = :founded_year, 
                head_coach = :head_coach, 
                primary_color = :primary_color, 
                secondary_color = :secondary_color, 
                home_stadium = :home_stadium, 
                stadium_capacity = :stadium_capacity, 
                website = :website, 
                email = :email, 
                phone = :phone, 
                address = :address, 
                assistant_coach = :assistant_coach, 
                team_manager = :team_manager, 
                physiotherapist = :physiotherapist, 
                history = :history 
              WHERE id = :team_id";

    // Prepare the statement
    $stmt = $bd->prepare($query);

    // Bind parameters to avoid SQL injection
    $stmt->bindParam(':team_name', $team_name);
    $stmt->bindParam(':country_name', $country_name);  // Fixed this
    $stmt->bindParam(':city_name', $city_name);        // Fixed this
    $stmt->bindParam(':logo_path', $logo_path);
    $stmt->bindParam(':founded_year', $founded_year);
    $stmt->bindParam(':head_coach', $head_coach);
    $stmt->bindParam(':primary_color', $primary_color);
    $stmt->bindParam(':secondary_color', $secondary_color);
    $stmt->bindParam(':home_stadium', $home_stadium);
    $stmt->bindParam(':stadium_capacity', $stadium_capacity);
    $stmt->bindParam(':website', $website);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':assistant_coach', $assistant_coach);
    $stmt->bindParam(':team_manager', $team_manager);
    $stmt->bindParam(':physiotherapist', $physiotherapist);
    $stmt->bindParam(':history', $history);
    $stmt->bindParam(':team_id', $team_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Team information updated successfully!";
        header("Location: ../admin-general/index.php");
    } else {
        echo "Error updating team information.";
        header("Location: ../admin-general/gestion_teams.php");
    }
}
?>
