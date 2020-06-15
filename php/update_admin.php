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

// Include config file
require_once "connect.php";
 
// Define variables and initialize with empty values
$new_username = $new_password= "";
$username_err = $new_password_err = "";


 
// Processing form data when form is submitted
if(isset($_POST['id']) && !empty($_POST['id'])){
    // Get hidden input value
    $id = $_POST['id'];


    
   
 
    
    
    
    if(empty(trim($_POST['username']))){
        $username_err = "Please enter the new username.";
    } elseif(!filter_var($_POST['username'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/")))){
        $username_err = "Please enter a valid username.";
    } else{
        $_SESSION['username'] = $_POST['username'];
    }



        
    
    if(empty($_POST['new_password'])){
        $new_password_err = "Please enter a password.";     
    } else{
        
        $_SESSION['password'] = $_POST['new_password'];
    }


    
    
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($new_password_err)){
        // Prepare an update statement
        $sql = "UPDATE admins SET username=?, password=? WHERE id=?";
        
        // Set parameters
        $param_new_username = $_SESSION["username"];
        $param_new_password = password_hash($_SESSION["password"], PASSWORD_DEFAULT);
        $param_id = $_SESSION["id"];
        
         
        if($stmt = mysqli_prepare($conn, $sql)){

            

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_new_username,  $param_new_password, $param_id);
            
            
            
            // Attempt to execute the prepared statement

            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                
              header("location: admins.php");

                exit();
            } else{
                header("location: add_user.php");
                echo "Something went wrong. Please try again later.";
            }
            
        }

         // Close statement
        mysqli_stmt_close($stmt);
        
    }
    
    // Close connection
    mysqli_close($conn);
} 

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $_SESSION['username']; ?>">
                            <span class="help-block"><?php echo $username_err;?></span>
                        </div>
                    
                        <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                            <label>New password</label>
                            <input type="text" name="new_password" class="form-control" value="<?php echo $_SESSION['password']; ?>" >
                            <span class="help-block"><?php echo $new_password_err;?></span>
                        </div>
                        <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?>>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="admins.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>