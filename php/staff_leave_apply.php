<?php

// Include config file
require_once "connect.php";

session_start();

// if the user is not admin return to the login page.
if($_SESSION['userlevel'] !== "staff" ){
    header("location: ../sign_in.php");
}


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../sign_in.php");
    exit;
}


$leave_reason = $leave_reason_err = "";
$staff_id = trim($_SESSION['id']);


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty($_POST['leave_reason'])){
        $leave_reason_err = "You must have a reason to submit";
    }
    else{
        $leave_reason = $_POST['leave_reason'];
    }


if(empty($leave_reason_err)){

     // Prepare an insert statement
     $sql = "INSERT INTO form (staff_id, reason, status) VALUES ($staff_id, ?, 'NOT DONE')";

      
     if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_leave_reason);
        
        // Set parameters
        
        $param_leave_reason = $leave_reason;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            echo '<div class="alert alert-success" role="alert">
            Form submitted!
          </div>';
          
            
        } else{
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
        }
    }

// Close connection
mysqli_close($conn);
}

?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
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

           

        .option:checked ~ .spann{
                color: white;
                background-color: #2e86de;
                transform: scale(1.1);
        }

        .spann{
                position: relative;
                display: inline-block;
                margin: 20px 10px;
                padding: 12px;
                width: 100px;
                background: #000;
                border: 2.5px solid #2e86de;
                color: white;
                border-radius: 25px;
                cursor: pointer;
                margin-bottom: 10px;
                margin-top: 0px;
                font-weight: 100;
                text-align: center;
    
            }
        input{
                display: none;
            }
            .help-block{
                color: red;
            }

            
        
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Leave form</h2>
        <p>Please fill this form to apply for leave</p>

        <br>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        


            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Reason for leave</label>
                <textarea name="leave_reason" class="form-control" placeholder = "Write your reason here"></textarea>
                <span class="help-block"><?php echo $leave_reason_err; ?></span>
            </div>    
            
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>

            

            <a href ="staff.php" class ="btn btn-success">Menu Page</a>

            

    
           
        </form>
    </div>    
</body>
</html>
