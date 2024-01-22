<?php
session_start();

// Include your database connection file
include "connect2.php";

// Get the user's email from the session
$userEmail = $_SESSION['email'];

// Number of images per page
$imagesPerPage = 8;

// Get the current page number
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting index for the LIMIT clause
$start = ($page - 1) * $imagesPerPage;

// Fetch total number of images for the logged-in user
$sqlCount = "SELECT COUNT(*) AS total FROM library WHERE email = ?";
$stmtCount = $con->prepare($sqlCount);

if ($stmtCount === false) {
    die('Error preparing count statement.');
}

$stmtCount->bind_param("s", $userEmail);

if ($stmtCount->execute() === false) {
    die('Error executing count statement.');
}

$resultCount = $stmtCount->get_result();

if ($resultCount === false) {
    die('Error getting count result.');
}

$totalImagesRow = $resultCount->fetch_assoc();
$totalImages = $totalImagesRow['total'];

// Calculate total pages
$totalPages = ceil($totalImages / $imagesPerPage);

// Prepare the statement to fetch images with pagination
$sql = "SELECT id, image FROM library WHERE email = ? LIMIT ?, ?";
$stmt = $con->prepare($sql);

if ($stmt === false) {
    die('Error preparing statement.');
}

$stmt->bind_param("sii", $userEmail, $start, $imagesPerPage);

if ($stmt->execute() === false) {
    die('Error executing statement.');
}

$result = $stmt->get_result();

if ($result === false) {
    die('Error getting result.');
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="indexStyle.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css">

    <link href="index.html" rel="import" />
    <link href="find.php" rel="import" />
    <link href="gallery.php" rel="import" />
    
    <link href="home.php" rel="import" />
    <title>Image Gallery</title>
    <style>
       body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }
    .pagination {
        margin-top: 1px; /* Adjust margin as needed */
    bottom: 70px;
    position: relative;
    z-index: 1;
    }

    h1 {
        text-align: center;
        margin-bottom: 2px;
        color: #333333;
    }

    #gallery {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        max-width: 2300px;
        
    }

    .image-container {
        display: flex;
        flex-direction: column;
        position: relative;
        margin: 5px; /* Adjust margin as needed */
        overflow: hidden;
    }


        .image-wrapper {
            flex-grow: 1;
        }

      

        .image-container img {
            max-width: 100%;
            max-height: 80%;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: transform 0.3s ease-in-out;
        }

        .image-container:hover img {
            border: 3px solid #ddd;
        }

    

        
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="banner">
            <div class="d-flex" id="wrapper">
                <!-- Sidebar -->
                <div class="bg-white" id="sidebar-wrapper">
                    <div class="navbar navbar-expand-lg navbar-light py-2 px-4">
                        <img style="width: 140px; height: 35px; " src="finder-logo-removebg-preview.png" class="logo">
                    </div>
                    <div class="list-group list-group-flush my-3">
                        <a href="index.html" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                                class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                       
                                <a href="gallery.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                            <i class="fas fa-image"></i> Library</a>
                                <a href="find.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                                    <i class="fa fa-search"></i>Find Similar Images</a>
                                      
                        <a href="home.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                                class="fas fa-power-off me-2"></i>Logout</a>
                    </div>
                </div>
                <!-- /#sidebar-wrapper -->

                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <nav class="navbar navbar-expand-lg navbar-light py-2 px-4" style="background-color: white;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                            <h2 class="fs-2 m-0">Dashboard</h2>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user me-2"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#">Profile</a></li>
                                        <li><a class="dropdown-item" href="#">Settings</a></li>
                                        <li><a class="dropdown-item" href="home.php">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
<h1>Library</h1>
                    <div id="gallery" class="d-flex flex-wrap justify-content-center">
        <?php
        $imageCount = 0;
        while ($row = $result->fetch_assoc()) {
            $filename = $row['image'];
            $imageId = $row['id'];
            $fullPath = "Dataset/$filename";

            // Get image dimensions
            [$width, $height] = getimagesize($fullPath);

            // Calculate aspect ratio to maintain proportions
            $aspectRatio = $width / $height;

            echo "<div class='image-container' style='flex: 0 0 calc(30% * $aspectRatio); position: relative;'>";
echo "    <div class='image-wrapper'>";
echo "        <img src='$fullPath' alt='Image in Gallery' style='width: 100%; height: 90%;'>";
echo "    </div>";

echo "    <div class='action-buttons'>";
echo "        <a href='javascript:void(0);' class='btn btn-primary' style='position: absolute; bottom: 80px; left: 50px;' onclick='downloadImage(\"$fullPath\");'>Download</a>";

echo "        <form method='post' action='delete_image.php' style='position: absolute; bottom: 80px; right: 30px;'>";
echo "            <input type='hidden' name='image_id' value='$imageId'>";
echo "            <button type='submit' class='btn btn-danger'>Delete</button>";
echo "        </form>";
echo "    </div>";
echo "</div>";

            $imageCount++;
        }
        ?>
     </div>

<!-- Pagination inside the #gallery div -->
<div class="d-flex justify-content-center mt-0">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">';
                echo '<a class="page-link" href="gallery.php?page=' . $i . '">' . $i . '</a>';
                echo '</li>';
            }
            ?>
        </ul>
    </nav>
</div>
</div>
</div>
</div>
</div>
    <script>
        function downloadImage(imagePath) {
            var link = document.createElement('a');
            link.href = imagePath;
            link.download = imagePath.split('/').pop();
            link.click();
        }
    </script>

    <!-- Bootstrap JS (optional, only needed if you want to use Bootstrap JavaScript features) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>

</html>