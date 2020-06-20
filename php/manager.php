<?php

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../sign_in.php");
    exit;
}


if($_SESSION['userlevel'] !== "manager"){
    header("location: ../sign_in.php");
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        body{ font: 14px sans-serif; background-color: #2f323a; color: white;}
        .wrapper{ 
            width: 350px;
             margin-left: 40%; 
             margin-top: 6%; color: white; 
             background-color: black; 
             padding: 30px; 
             border-radius: 10px; 
             box-shadow: 0px 0px 20px 0px rgba(253, 253, 253, 0.75);
            } 
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        <br>
        <h1>You're a <b><?php echo htmlspecialchars($_SESSION["userlevel"]); ?> </b></h1>
        
        
    </div>
    <p>
        
        <a href="sign_out.php" class="btn btn-danger">Sign Out</a>
        <a href="update_manager_own.php" class="btn btn-primary">Update personal information</a>
        <a href="view_leave_form.php" class="btn btn-primary">View current leave application</a>
        <a href="view_all_staff_application.php" class="btn btn-primary">View all staff applications</a>
    </p>
</body>
</html>

