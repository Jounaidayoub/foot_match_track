<?php
// Include the database connection
include('../includes/db.php');

// Start the session
session_start();

// Check if the user is logged in and the session variable 'user_id' exists
if (!isset($_SESSION['id'])) {
    // Redirect to login page if the user is not logged in
    header('Location: login.php');
    exit();
}

// Get the logged-in user's ID (id_admin)
$id_admin = $_SESSION['id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $title = $_POST['title'];
    $image_path = $_POST['image_path'];
    $details = $_POST['details'];

    // Sanitize the inputs (to prevent XSS and other issues)
    $title = htmlspecialchars($title);
    $image_path = htmlspecialchars($image_path);
    $details = htmlspecialchars($details);

    try {
        // Prepare the SQL query to insert the publication into the database
        $sql = "INSERT INTO publication (id_admin, image_path, titre, contenue) 
                VALUES (:id_admin, :image_path, :titre, :contenue)";
        $stmt = $bd->prepare($sql);
        
        // Bind the values to the SQL statement
        $stmt->bindParam(':id_admin', $id_admin, PDO::PARAM_INT);
        $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
        $stmt->bindParam(':titre', $title, PDO::PARAM_STR);
        $stmt->bindParam(':contenue', $details, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            // If the query is successful, redirect to a success page or the publication list
            
            header('Location: ../admin-general/index.php');
            exit();
        } else {
            // If the query fails, display an error message
            echo "Error: Could not add the publication.";
            header('Location: ../admin-general/gestion_publication.php');
        }
    } catch (PDOException $e) {
        // Catch any exceptions and display the error message
        echo "Error: " . $e->getMessage();
    }
}
?>
