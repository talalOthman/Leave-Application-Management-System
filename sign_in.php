
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

    $userLevel = trim($_POST["user"]); // the role the user chose
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $usernameError ="";
    $passwordError = "";
    $inactiveError = "";

    
    
    


    // to check if the username and password have values.
    if(!empty($username) && !empty($password)){

        //The sql query to  check for the username entered by the user.
        $sql ="SELECT id, username, password FROM $userLevel WHERE username = ?;";

        //preparing the statement
        if($stmt = mysqli_prepare($conn, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){

                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)){
                        //comparing the password given with the hashed password in the database
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session

                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            // will store which option the user chose.
                            $_SESSION['userlevel'] = $userLevel;
                            $_SESSION["id"] = $id;
                            // will store the username if the user
                            $_SESSION["username"] = $username; 
                            $_SESSION["password"] = $password;
                            
                            // will direct the user to the page of what type of user they chose.
                            header("location: php/".$userLevel.".php");
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
    <title>Leave Application Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <form class="form" id="form" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
        <h2>Login</h2>
        <p>
        <?php 
        if(isset($_POST['login-submit']) && true){
        echo $inactiveError;} 
        ?>
        </p>
        <br>

        <br>
        
        <input class="username" id = "username" type="text" name="username" placeholder="Username" value = <?php if(isset($_POST['login-submit'])){echo $username;}?>>
        <p id="errmessage-username">
        <?php 
        if(isset($_POST['login-submit'])){
        echo $usernameError;} 
        ?>
        </p>
        <br>
        
        <input class="password" id = "password" type="password" name="password" placeholder="Password">
        <p id="errmessage-password">
            <?php
            if(isset($_POST['login-submit'])){
            echo $passwordError;} 
            ?>
        </p>
        <br>
        <label>
            <input type = "radio" class="option" id="admin" name="user" value="admins">
            <span>ADMIN</span>
        </label>

        <label>
            <input  type = "radio" class="option" id="manager" name="user" value="manager">
            <span>MANAGER</span>
            
        </label>

        <label>
            <input  type = "radio" class="option" id="staff" name="user" value="staff">
            <span>STAFF</span>
        </label>
        <p id="mainError"></p>
        <br>
        
        <button class="login" name="login-submit">Login</button>

    </form>

    <script src="javascript/script.js"></script>
</body>

</html>