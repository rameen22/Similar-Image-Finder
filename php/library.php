<?php
session_start();

include("connect2.php");
if (isset($_POST["image_path"])) {
    $userEmail = $_SESSION['email'];
    $imagePath = $_POST["image_path"];


    // Perform database operations to add the image to the library table
    $stmt = $con->prepare("INSERT INTO library (email, image) VALUES (?, ?)");
    $stmt->bind_param("ss", $userEmail, $imagePath);

    if ($stmt->execute()) {
        header('location:gallery.php');

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request!";
}

$con->close();
?>