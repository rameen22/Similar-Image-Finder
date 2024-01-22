<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect2.php';

session_start();

// Check if the form is submitted
if(isset($_POST['submit'])){
    // Retrieve the doctor's ID from the session
    if (isset($_SESSION['id'])) {
        $doctorID = $_SESSION['id'];

        // Retrieve form data
        $drname  = $_POST['drname'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $experience = $_POST['experience'];

        // Check if data exists for the doctor ID
        $checkSql = "SELECT * FROM addpatient WHERE id = '$doctorID'";
        $checkResult = mysqli_query($con, $checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            // Modify the UPDATE query to update the specific doctor's data
            $sql = "UPDATE addpatient SET name='$name', drname='$drname', age='$age', experience='$experience' WHERE id='$doctorID'";
        } else {
            // Modify the INSERT query to include the doctor's ID
            $sql = "INSERT INTO addpatient (id, drname, name, age, experience) VALUES ('$doctorID','$drname', '$name', '$age',  '$experience')";
        }

        // Execute the query
        $result = mysqli_query($con, $sql);

        if($result){
            header('location:AddNewPatientInfo.php');
        } else {
            die(mysqli_error($con));
        }
    } else {
        // Handle the case when the doctor ID is not found in the session
        // Redirect or display an error message
    }
}

// Fetch data if the doctor ID exists in the form data table
if (isset($_SESSION['id'])) {
    $doctorID = $_SESSION['id'];

    // Fetch data from the database for the specific doctor
    $sql = "SELECT * FROM addpatient WHERE id = '$doctorID'";
    $result = mysqli_query($con, $sql);

    // Check if data exists for the doctor ID
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign fetched values to variables
        $name = $row['name'];
        $age = $row['age'];
        $drname = $row['drname'];
        $experience = $row['experience'];

        $displayButton = "update";
    } else {
        // Set default values if no data exists for the doctor ID
        $name = isset($_SESSION['email']) ? $_SESSION['email'] : '';
        $age = '';
        $drname = '';
        $experience = '';

        $displayButton = "submit";
    }
} else {
    // Handle when the doctor ID is not found in the session
    // Redirect or display an error message
    // For now, setting empty values and displaying the Submit button
    $name = '';
    $age = '';
    $fee = '';
    $experience = '';
    $displayButton = "submit";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="indexStyle.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="index.html" rel="import" />
    <link href="AddNewPatientInfo.php" rel="import" />
    <link href="prescriptionform.php" rel="import" />
    <link href="uploadMRI.html" rel="import" />
    <link href="GenerateReport.html" rel="import" />
    <link href="doctor
    _inbox.php" rel="import" />
    <link href="indexStyle.css" rel="import" />

    <link href="home.php" rel="import" />
    <title>profile</title>
<style>
    body {
            background-color: #f0f0f0;
        }

        .container {
            margin-top: 20px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 40px;
        }
.form-control {
    background-color:#eeeeee;
}
        .note-div {
            background-color: #ffe599;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
.banner{
    background-image: url("brain-model-side-view-brain-mri-imaging-background.jfif");
    background-attachment: fixed;
}

        .btn-submit {
            background-color: steelblue;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            color: white;
            float:right;
        }

        .btn-submit:hover {
            background-color: #24537e;
        }
        .btn {
            
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            color: white;
            float:right;
        }
    </style>
</head>


<body> <div class="banner">
    
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
                        
                        <i class="fas fa-user me-2"></i>Profile</a>
                    <a href="doctor_inbox.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fa fa-envelope me-2"></i>Library</a>
                          
                            
                    <a href="home.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                            class="fas fa-power-off me-2"></i>Logout</a>
                </div>
            </div>
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

             
      <br><br> <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                     <h2 class="text-left mb-4"><i class="fas fa-user-md fa-lg" style="color: #141414;"></i>Profile </h2>

                     <form id="addpatient" method="post" action="addNewPatientInfo.php">
                            <!-- Note div inside the form -->
                            <div class="note-div">
                                <p>Please note that providing accurate information is crucial. Providing wrong information may lead to strict actions.Make sure to enter the email associated with your doctor account 
</p>
                            </div>

<!-- name -->

                     <!-- Email -->
<div class="mb-3 row align-items-center">
    <label class="col-sm-2 col-form-label"><i class="bi bi-envelope-fill"></i> Email:</label>
    <div class="col-sm-10">
                   <input type="email" class="form-control" placeholder="abc@gmail.com" name="name" autocomplete="off" value="<?php echo $name; ?>">
        </div>
    </div>

<!-- Age -->
<div class="mb-3 row align-items-center">
    <label class="col-sm-2 col-form-label"><i class="bi bi-person-fill"></i> Username:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" placeholder="Enter Your Age" name="age" autocomplete="off" value="<?php echo $age; ?>">
    </div>
</div>

<!-- Experience -->
<div class="mb-3 row align-items-center">
    <label class="col-sm-2 col-form-label"> Password</label>
    <div class="col-sm-10">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Experience" name="experience" autocomplete="off" value="<?php echo $experience; ?>">
        </div>
    </div>
</div>


                           <div class="mb-3">
    <?php if($displayButton === "update"): ?>
        <!-- Display the Update button if the form is filled -->
        <button type="submit" name="submit" class="btn btn-submit btn-lg">Update</button>
    <?php else: ?>
        <!-- Display the Submit button if the form is empty -->
        <button type="submit" name="submit" class="btn btn-submit btn-lg">Submit</button>
    <?php endif; ?>
</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
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