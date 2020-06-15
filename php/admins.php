<?php

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../sign_in.php");
    exit;
}

if($_SESSION['userlevel'] !== "admins"){
    header("location: ../sign_in.php");
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        <br>
        <h1>You're an <b>admin </b></h1>
        <h1>Password is <?php echo htmlspecialchars($_SESSION["password"]); ?></h1>
    </div>
    <p>
        
        <a href="sign_out.php" class="btn btn-danger">Sign Out</a>
        <a href ="add_user.php" class ="btn btn-primary">Add User</a>
        <a href ="users_details.php" class ="btn btn-primary">User details</a>
        <a href="update_admin.php" class="btn btn-primary">Update personal information</a>

    </p>
</body>
</html>