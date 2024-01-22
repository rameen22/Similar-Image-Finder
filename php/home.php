<?php
session_start();

include "connect2.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sqlLogin = "SELECT * FROM registration WHERE email ='".$email."' AND password = '".$password."' AND status = 'active'";
    $resultLogin = mysqli_query($con, $sqlLogin);

    if (mysqli_num_rows($resultLogin) > 0) {
        $rememberme = isset($_POST['rememberme']) ? $_POST['rememberme'] : '';

        if ($rememberme == "checked") {
            setcookie('email', $email);
            setcookie('password', $password);
        } else {
            setcookie('email', '');
            setcookie('password', '');
        }

        if ($row = mysqli_fetch_assoc($resultLogin)) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            $email = $row['email'];

            // Redirect to index page
            header('location:index.html');
            exit();
        }
    } else {
        echo "<script>alert('Incorrect email or password');</script>";
    }
}
?>
<?php

// Use the correct namespace
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include "connect2.php";

// SIGNUP PROCESS CODE
if (isset($_POST['register'])) {
    $otp_str = str_shuffle("0123456789");
    $otp = substr($otp_str, 0, 5);

    $act_str = rand(100000, 10000000);
    $activation_code = str_shuffle("abcdefghijklmno" . $act_str);

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $selectDatabase = "SELECT * FROM registration WHERE email = '$email'";
    $selectResult = mysqli_query($con, $selectDatabase);

    if (mysqli_num_rows($selectResult) > 0) {
        // Email already exists
        echo "<script>alert('Email already registered')</script>";
    } else {
        // Email doesn't exist, send OTP and redirect to OTP page
        $subject = 'Verification code for Verify Your Email Address';
        $message_body = "For verify your email address, enter this verification code when prompted: $otp.\nSincerely,";

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'entertainment.pkk@gmail.com'; // your Gmail username
            $mail->Password   = 'oepcksbqulxlyctf'; // your Gmail password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('entertainment.pkk@gmail.com', 'ImageFinder');
            $mail->addAddress($email, $username);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message_body;

            $mail->send();

            // OTP sent successfully, store details in session and redirect to OTP page
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['otp'] = $otp;
            $_SESSION['activation_code'] = $activation_code;

            header("Location: email_verify.php");
            exit();
        } catch (Exception $e) {
            // Error in sending email
            echo "<script>alert('Failed to send OTP');</script>";
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }
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
        






        <div class="content animate-onload">
        
    <h1>Discover alike images effortlessly






</h1>
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
    <div class="overlay_login" id="overlaylogin">
        <div class="form-box" id="form">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log in </button>
                <button type="button" class="toggle-btn" onclick="Register()">Register</button>
                <button type="button" class="close-btn" onclick="closeForm()">X</button>
            </div>
            <form id="login" class="input" action=" " method="post">
                <input type="email" class="input-field" name="email" placeholder="Email"
                    value="<?php if(isset($_COOKIE['email'])){ echo $_COOKIE['email']; }?>" autocomplete="off" required>
                <input type="password" class="input-field" name="password" placeholder="Password "
                    value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password']; }?>" autocomplete="off"
                    required>
                <br><br><br><br>
                <br><br><button type="submit" class="submit" value="login" name="login">Login</button><br><br><br><br>
                <div class="styletext">
                    <input type="checkbox" name="rememberme" value="checked"
                        <?php if(isset($_COOKIE['email'])){ echo 'checked'; }?>><label class="rem">Remember me</label>
                </div>
            </form>
            <form id="Register" class="input" action=" " method="post">
                <br>
                <input type="text" class="input-field" name="username" placeholder="Username" required>
                <input type="email" class="input-field" name="email" placeholder="Email" autocomplete="off" required>
                <input type="password" class="input-field" name="password" placeholder="Password " required>
                
                <button type="submit" class="submit" value="register" name="register">Register</button>
                <br><br><br><p class="styletext">Already Have an Account?Login</p class="selecttext"><p>

            </form>
        </div> 
        </div><?php unset($_SESSION['email_alert']);?>
 </body>
        <script>
var x = document.getElementById("login");
var y = document.getElementById("Register");
var z = document.getElementById("btn");

function Register() {
x.style.left ="-400px";
y.style.left ="50px";
z.style.left ="110px";

}

function login() {
x.style.left ="-45px";
y.style.left ="450px";
z.style.left ="0px";}

function toggleLogin() {
            var overlay = document.getElementById("overlaylogin");
            overlay.style.display = "block";
            login()
        }
        function closeForm() {
    var overlay = document.getElementById("overlaylogin");
    overlay.style.display = "none";
}


</script>
</body>
</html>
