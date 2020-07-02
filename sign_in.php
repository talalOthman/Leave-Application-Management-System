<?php

session_start();






// if the user is already logged in 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

    // each user will be directed to the page that describe their roles.
    header("location:  php/".$_SESSION['userlevel'].".php");
}



require_once "php/connect.php";


// if the user entered after processing the form. this used to stop user from entering directly to the site by using the URL.
if($_SERVER["REQUEST_METHOD"] == "POST"){

    

    $userLevel = ""; // the role the user chose
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $usernameError ="";
    $passwordError = "";
    $inactiveError = "";
    $applied_leave_num = "";


    




    
    
    


    // to check if the username and password have values.
    if(!empty($username) && !empty($password)){
        
        //The sql query to  check for the username entered by the user.
        
        $sql ="SELECT id, username, password, status, userType, applied_leave_num FROM admins WHERE username = ? 
        UNION SELECT id, username, password, status, userType, applied_leave_num FROM manager WHERE username = ? 
        UNION SELECT id, username, password, status, userType, applied_leave_num FROM staff WHERE username = ?;";

        //preparing the statement
        if($stmt = mysqli_prepare($conn, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username1, $param_username2, $param_username3);

            // Set parameters
            $param_username1 = $username;
            $param_username2 = $username;
            $param_username3 = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){

                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $status, $userLevel, $applied_leave_num);

                    if(mysqli_stmt_fetch($stmt)){
                        //comparing the password given with the hashed password in the database
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            if($status === "ACTIVE"){
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            // will store which option the user chose.
                            $_SESSION['userlevel'] = $userLevel;
                            $_SESSION["id"] = $id;
                            // will store the username if the user
                            $_SESSION["username"] = $username; 
                            $_SESSION["password"] = $password;

                            $_SESSION["applied_leave_num"] = $applied_leave_num;

                            // will direct the user to the page of what type of user they chose.
                            header("location: php/".$userLevel.".php");
                           
                            } else{
                                $inactiveError = "Your account is de-activaited";
                                
                            }
                            
                        } else{
                            $passwordError = "The password you entered was not valid.";
                        }
                    }

                } else{
                    $usernameError = "No account found with that username.";
                }
            } else{
                echo "Something went wrong!";
            }
            

            mysqli_close($conn);
        }




        



    }


}






   


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Management edited</title>
    <!--Font awesome kit-->
    <script src="https://kit.fontawesome.com/7887806c2e.js" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

    <!--Bootsrap 4 CDNs-->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css?ts=<?=time()?>" />
    <!--This was added because the CSS was not updating as it was loading from browser cache-->
</head>

<body>
    
    <form class="form" id="form" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
        <h2 class = "bolder"><b>Leave Application <br> Management System</b> </h2>
        <br>
        <i class="fas fa-address-card "></i>
        
        <p class="deactive">
            <?php 
        if(isset($_POST['login-submit'])){
        echo $inactiveError;} 
        ?>
        </p>
        <br>

        <br>
        <input class="username" id="username" type="text" name="username" placeholder="Username" value=<?php if(isset($_POST['login-submit'])){echo $username;}?>>
        <p id="errmessage-username">
            <?php 
        if(isset($_POST['login-submit'])){
        echo $usernameError;} 
        ?>
        </p>
        <br>

        <input class="password" id="password" type="password" name="password" placeholder="Password">
        <p id="errmessage-password">
            <?php
            if(isset($_POST['login-submit'])){
            echo $passwordError;} 
            ?>
        </p>
        <br>


        <button class="login" name="login-submit">Login</button>

    </form>

    <script src="javascript/script.js"></script>
    <!--Bootstrap 4 Things-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>
