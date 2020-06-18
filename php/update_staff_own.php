<?php

session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../sign_in.php");
    exit;
}

if($_SESSION['userlevel'] !== "staff"){
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



        


    
    
    
    
    // Check input errors before inserting in database
    if(empty($username_err)){
        // Prepare an update statement
        $sql = "UPDATE staff SET username=? WHERE id=?";
        
        // Set parameters
        $param_new_username = $_SESSION["username"];
        $param_id = $_SESSION["id"];
        
         
        if($stmt = mysqli_prepare($conn, $sql)){

            

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_new_username,  $param_id);
            
            
            
            // Attempt to execute the prepared statement

            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                
              header("location: staff.php");

                exit();
            } else{
                header("location: .php");
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
        body{ font: 14px sans-serif; background-color: #2f323a;}
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
                    
                    
                        <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?>>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="staff.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>