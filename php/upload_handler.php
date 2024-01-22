<?php
$message = ''; // Initialize an empty message variable
$result_paths = ''; // Initialize an empty variable to store recommended image paths

// Check if a POST request was made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imagefile"]["name"]); // Path to the uploaded file
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Get the file extension

    // Check if image file is an actual image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["imagefile"]["tmp_name"]); // Get image information
        if ($check !== false) {
            $uploadOk = 1; // File is an image
        } else {
            $message = "File is not an image.";
            $uploadOk = 0; // File is not an image, set upload status to fail
        }
    }
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $message = "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file)) {
        $image_path = $target_file; // Path to the uploaded image

        // Execute the Python script passing the image path as an argument and capture the result
        $python_command = "python model.py \"$image_path\"";
        $output = shell_exec($python_command);

        // Debugging: Print the result paths if $output is not empty
        if (!empty($output) && strpos($output, "No similar images found") === false) {
            $result_paths = array_map('trim', explode(",", $output)); // Trim spaces from each path
            $result_paths = array_filter($result_paths); // Remove empty paths
        } else {
            $message = "No Similar Images Found";
        }
    }
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
    <link href="index.html" rel="import" />
    <link href="AddNewPatientInfo.php" rel="import" />
    <link href="doctor_inbox.php" rel="import" />
    <link href="uploadMRI.html" rel="import" />
    <link href="GenerateReport.html" rel="import" />

    <link href="home.php" rel="import" />
    <title>Doctors Dashboard</title>
</head><style>
.banner{
    background-image: url("Ice-Blue-Solid.webp");
    background-attachment: fixed;
}
        
.upload-container {
    background-color: #fff; /* White */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    width: 600px;
    margin: 20% auto; /* Adjusted to center vertically and horizontally */
}
    .attractive-div {
        background-color: #ffffff;
        border: 1px solid #ccc;
        margin-top: 50px;
        border-radius: 10px;
        padding: 20px;
        width: 680px;
        margin-left: 250px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .div-title {
        color: #333333;
        font-size: 24px;
        margin-bottom: 10px;
        float: left;
    }

    .result-content {
        color: #555555;
        font-size: 18px;
    }

    .result-img {
        max-width: 100%;
        margin-bottom: 10px;
        border:1px;
    }

.custom-file-input {
    cursor: pointer;
    margin-top: 10px; /* Added some spacing for the file input */
}

#upload-btn {
    background-color: #007BFF; /* Bootstrap Primary Color */
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px; /* Added some spacing for the button */
}
.btn btn-primary:hover{
    background-color: black; /* Bootstrap Primary Color */
    color: white;
    
    
} .result-img:hover {
            border: 2px solid #007BFF;
        }
    </style>

<body>
    <div class="banner">
    
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
                        <a href="profile.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                            
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
                <div class="attractive-div">
    <h1 class="div-title"> Similar Images</h1>
    <br><br>
    <?php if (!empty($result_paths) && $result_paths[0] !== "No similar images found. Try again."): ?>
        <div id="result" style="display: flex; flex-wrap: wrap; justify-content: center;">
            <?php
            $imageCount = 0; // Variable to count the number of images

            foreach ($result_paths as $filename) {
                $filenameParts = explode('\\', $filename);
                $filename = end($filenameParts); // get the last part, which is the filename
                $fullPath = 'Dataset/' . $filename;

                // Add a container div for each image with some styling
                echo "<div style='flex: 0 0 30%; margin: 10px; position: relative;'>";

                // Image with "Add to Library" button overlay
                echo "<img src='$fullPath' alt='Recommended Image' class='result-img' style='max-width: 100%; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; transition: border 0.3s ease-in-out;' onmouseover='this.style.border=\"2px solid #007BFF\"' onmouseout='this.style.border=\"1px solid #ddd\"'>";

                // "Add to Library" button overlay
                // Form for each image
                echo "<form method='post' action='library.php' enctype='multipart/form-data' style='position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);'>";
                echo "<input type='hidden' name='image_path' value='$filename'>";
                echo "<input type='submit' value='Add to Library' class='btn btn-primary' style='width: 190px; color: white; background-color: steelblue; transition: background-color 0.3s ease-in-out;' onmouseover='this.style.backgroundColor=\"black\"' onmouseout='this.style.backgroundColor=\"steelblue\"'>";
                echo "</form>";

                echo "</div>";

                $imageCount++;

                // Add a row break after every three images
                if ($imageCount % 3 == 0) {
                    echo "<div style='width: 100%;'></div>"; // Empty div to break the row
                }
            }
            ?>
        </div>
    <?php else: ?>
        <h3 class='result-content'><?php echo "No Similar Images Found"; ?></h3>
    <?php endif; ?>
</div>

                
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