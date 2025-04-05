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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $id = $_POST['staff_id1']; // Get the publication ID
    $title = $_POST['title1'];
    $image_path = $_POST['image_path1'];
    $details = $_POST['details1'];

    // Sanitize the inputs
    $title = htmlspecialchars($title);
    $image_path = htmlspecialchars($image_path);
    $details = htmlspecialchars($details);

    try {
        // Prepare the SQL query to update the publication
        $sql = "UPDATE publication SET titre = :titre, image_path = :image_path, contenue = :contenue WHERE id = :id";
        $stmt = $bd->prepare($sql);

        // Bind the parameters to the query
        $stmt->bindParam(':titre', $title, PDO::PARAM_STR);
        $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
        $stmt->bindParam(':contenue', $details, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to a success page or back to the publication list
            header('Location: ../admin-general/index.php');

            exit();
        } else {
            echo "Error: Could not update the publication.";
            header('Location: ../admin-general/gestion_publication.php');
        }
    } catch (PDOException $e) {
        // Catch any errors and display a message
        echo "Error: " . $e->getMessage();
    }
}
?>
