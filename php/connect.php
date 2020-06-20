<?php

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$DBname = "practice";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $DBname);

if($conn === false){
    die("There was an error. ". mysqli_connect_error());
}






/*

$username = "Admin";
$password = "admin123";
$status = "ACTIVE";
$userType = "admins";

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admins(username, password, status, userType) VALUES ('$username', '$hashed_password', '$status', '$userType');";

if(mysqli_query($conn, $sql)){
    
}
*/






