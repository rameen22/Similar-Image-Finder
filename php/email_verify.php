<?php
session_start();
include "connect2.php";

if (isset($_SESSION['username'], $_SESSION['email'], $_SESSION['password'],  $_SESSION['otp'], $_SESSION['activation_code'])) {
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    $otp = $_SESSION['otp'];
    $activation_code = $_SESSION['activation_code'];

    if (isset($_POST['verify'])) {
        $entered_otp = $_POST['otp'];

        if ($entered_otp == $otp) {
            // Correct OTP, insert user details into the database
            $sqlInsert = "INSERT INTO registration (username, email, password, otp, activationcode, status) VALUES ('$username', '$email', '$password',  '$otp', '$activation_code', 'active')";
            $insertResult = mysqli_query($con, $sqlInsert);

            if ($insertResult) {
                echo '<script>alert("Account successfully registered ,Now Login")</script>';
                session_unset(); // Clear session variables
                session_destroy(); // Destroy the session
                header("Refresh:1; url=home.php"); // Redirect to login page after a short delay
                exit();
            } else {
                echo '<script>alert("Opss something wrong failed to insert data")</script>';
            }
        } else {
            echo '<script>alert("Incorrect OTP")</script>';
        }
    }
} else {
    echo "Invalid access! Please register first.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Services</title>
</head>
<style>

    .otp-form{
        width: 380px;
  height: 280px;
  position: relative;
  margin: 6% auto;
  background: #fff;
  padding: 5px;
  border: black ;
 
  border-radius: 15px;
 
overflow:hidden ;    }
   @keyframes slideInFromLeft {
    0% {
        opacity: 0;
        transform: translateX(-50%);
    }
    100% {
        opacity: 1;
        transform: translateX(0%);
    }
}
.hidden {
            display: none;}

            .button-box{
  width: 220px;
  margin: 35px auto;
  position: relative;
  box-shadow: 0 0 20x 9px #ff61241f;
  border-radius: 30px;
}
.message{
    color:black;
    font-weight:bold;
}
.input{
    top:80px;
    left:30px;
  text-align: center;
margin-right:50px;
  width: 300px;
  transition: .5s;
  line-height: 8px;
  font-size: medium;
  font-family: 'Times New Roman', Times, serif;
  padding:10px 0;
  margin: 5px 1px;
  float: left;
  height: 50px;

}

.submit:hover {
transform: scale(1.05); /* Increase size on hover */
box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); /* Add a subtle shadow */
}
.submit{
    margin-top:350px;

    padding-top: 20px;
  width: 65%;
  padding: 15px 35px;
  cursor:pointer;
  font-weight:bold;
  font-family: 'Times New Roman', Times, serif;
  display: block;
  margin: auto;
  font-size:95px;
background-color:steelblue;
  border: 0;
  outline: none;
  border-radius: 20px;
  line-height: top 9px;
  font-size: medium;
}
  
.animate-onload {
    animation: slideInFromLeft 2s ease-out forwards;
}</style>
<body>
<div class="banner">
        <div class="navbar">
            <img src="finder-logo-removebg-preview.png" class="logo">
            <a href="#" onclick="toggleLogin()">Login</a>
            <a href="aboutus.html">About</a>
            <a href="home.php">Home</a>
        </div>
        <div class="content ">
        <div class="otp-form">
        <form action="" method="POST">

            <div class="form-group"><br>
            <label class="message">Verification OTP is sent to your Email,<br>Kindly Enter to register Account</label>
                <input type="text" name="otp" class=input placeholder="Enter OTP" required>
            </div><br><br><br><br><br><br><br>
                <input type="submit" name="verify" value="Verify Email"class="submit">
            </div>
        </form>
    </div>
</div>
   
       

</div>
    </div>

    <div class="services"id="services">
        <h2>Our Services</h2>
        <div class="service-cards-container">

        <div class="service-card">
            <img src="magnifying-glass.png" alt="Service 1"><br><br>
            <h3>Similarity Finder</h3>
        </div>
        <div class="service-card">
            <img src="art-gallery-icon-20.png" alt="Service 2"><br><br>
            <h3>Personal Library</h3>
        </div>
        <div class="service-card">
            <img src="download.png" alt="3"><br><br>
            <h3>Easy Download</h3>
        </div>
        <div class="service-card">
            <img src="AI.png" alt="Service 3"><br>
            <h3>Accurate Result</h3>
        </div>
      </div>
    </div>
    <div class="footer">
        <div class="contact-info">
            <h3>Contact Info</h3><br>
            <div class="info">
                <i class="fa fa-phone"></i>
                <p>0922-565656</p>
            </div>
            <div class="info">
                <i class="far fa-envelope"></i>
                <p>imagefinder@gmail.com</p>
            </div>
        </div>
        

        <div class="quick-links">
            <h3>Quick Links</h3><br>
            <ul>
                <li><a href="aboutus.html">About</a></li>
                <li><a href="#Services">Services</a></li>

            </ul>
        </div>

        <div class="social-media">
            <h3>Social Media</h3><br>
            <i class="fab fa-facebook fa-3x"></i>
            <i class="fab fa-instagram fa-3x"></i>
            <i class="fab fa-twitter fa-3x"></i>

        </div>
    </div>

           

               
</body>

</html>