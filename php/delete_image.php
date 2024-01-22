<?php
session_start();

// Include your database connection file
include "connect2.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the image ID from the form
    $imageId = $_POST["image_id"];

    // Prepare the SQL statement to delete the image
    $sql = "DELETE FROM library WHERE id = ? AND email = ?";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die('Error preparing statement.');
    }

    // Get the user's email from the session
    $userEmail = $_SESSION['email'];

    // Bind parameters
    $stmt->bind_param("ss", $imageId, $userEmail);

    // Execute the statement
    if ($stmt->execute() === false) {
        die('Error executing statement.');
    }

    // Close the statement
    $stmt->close();

    // Redirect back to the gallery page after deletion
    header('Location: gallery.php');
    exit();
} else {
    // If the form is not submitted, redirect to the gallery page
    header('Location: gallery.php');
    exit();
}

// Close the database connection
$con->close();
?>