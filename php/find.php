<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="indexStyle.css" />
    <link href="index.html" rel="import" />
    <link href="find.php" rel="import" />
    <link href="gallery.php" rel="import" />
  

    <link href="home.php" rel="import" />
    <title>Doctors Dashboard</title>
</head>  <style>
        .banner {
            background-image: url("Ice-Blue-Solid.webp");
            background-attachment: fixed;
        }
        .container{
            height: 700px;
            width: 800px;

        }
        .upload-container {
            background-color: #fff; /* White */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 800px;
            margin-top: 5%; /* Adjusted to center vertically and horizontally */
        }

        .custom-file-input {
            cursor: pointer;
            margin-top: 10px; /* Added some spacing for the file input */
            width: 600px;
        }

        #upload-btn {
            background-color: steelblue; /* Bootstrap Primary Color */
            color: #fff;
            font-weight:bold;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px; /* Added some spacing for the button */
            transition: background-color 0.3s ease-in-out; /* Added transition effect */
        }

        #upload-btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        #image-preview {
    max-width: 240px;
    margin: 20px auto; /* Center the image preview horizontally */
    display: none; /* Initially hide the image preview */
}

#preview {
    width: 250px;
    height: 300px;
    margin-top: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    display: block; /* Display the image preview */
    margin: 0 auto; /* Center the image preview horizontally */
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
                
                <div class="container">
        <div class="upload-container">
            <h2 class="mb-4">Discover Similar Images</h2>

            <form action="upload_handler.php" method="post" enctype="multipart/form-data">
                <input type="file" name="imagefile" id="imagefile" class="custom-file-input" onchange="previewImage()">
                <div id="image-preview">
                <img id="preview" alt="Image Preview">
            </div>
                <input type="submit" value="Upload Image" name="submit" id="upload-btn">
            </form>

            <!-- Image preview container -->
           
        </div>
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

        function previewImage() {
            var fileInput = document.getElementById('imagefile');
            var previewContainer = document.getElementById('image-preview');
            var previewImage = document.getElementById('preview');

            // Display the image preview
            previewContainer.style.display = 'block';

            // Update the image source
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    </script>
</body>

</html>