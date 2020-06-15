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

$username = "talal";
$password = "talal123";

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admins(username, password) VALUES ('$username', '$hashed_password');";

if(mysqli_query($conn, $sql)){
    
}
*/



