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

TO ADD USERS MANUALLY



$username = "";
$password = "";

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO (WHAT KIND OF USER)(username, password) VALUES ('$username', '$hashed_password');";

if(mysqli_query($conn, $sql)){
    
}
*/


