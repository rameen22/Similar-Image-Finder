<?php



//database connection
$con = new mysqli('localhost:3308','root','','imagefinder');
if(!$con){
    die(mysqli_error($con));
}

?>