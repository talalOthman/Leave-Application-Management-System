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

$leave_taken = $_SESSION["applied_leave_num"];
$leave_limit = 20;
$leave_taken_err = "";
$leave_reason = $leave_reason_err = "";
$starting_date = $ending_date = "";
$starting_date_err = $ending_date_err = "";
$staff_id = trim($_SESSION['id']);


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty($_POST['leave_reason'])){
        $leave_reason_err = "You must have a reason to submit";
    }
    else{
        $leave_reason = $_POST['leave_reason'];
    }


    if(empty($_POST['starting_date'])){
        $starting_date_err = "You must enter the starting date of the leave";
    }
    else{
        $starting_date = $_POST['starting_date'];
    }

    if(empty($_POST['ending_date'])){
        $ending_date_err = "You must enter the ending date of the leave";
    }
    else{
        $ending_date = $_POST['ending_date'];
    }

    if($leave_taken >= 20){
        $leave_taken_err = "You reached your annual limit";
    }
    else{
        
    }
       


if(empty($leave_reason_err) && empty($starting_date_err) && empty($ending_date_err) && empty($leave_taken_err)){

     // Prepare an insert statement
     $sql = "INSERT INTO form (staff_id, reason, status , starting_date, ending_date) VALUES ($staff_id, ?, 'NOT DONE', ?, ?)";

      
     if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_leave_reason, $param_starting_date, $param_ending_date);
        
        // Set parameters
        
        $param_leave_reason = $leave_reason;
        $param_starting_date = $starting_date;
        $param_ending_date = $ending_date;
        
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
    

    // Prepare an insert statement
    $sql2 = "UPDATE staff SET applied_leave_num = ? WHERE id = $staff_id;";

      
    if($stmt2 = mysqli_prepare($conn, $sql2)){
       // Bind variables to the prepared statement as parameters
       mysqli_stmt_bind_param($stmt2, "i", $param_applied_leave_num);
       
       // Set parameters
       
      $param_applied_leave_num = $leave_taken;
       
       // Attempt to execute the prepared statement
       if(mysqli_stmt_execute($stmt2)){
           
         $_SESSION["applied_leave_num"] = $leave_taken;
           
       } else{
           echo "Something went wrong. Please try again later.";
       }

       // Close statement
       mysqli_stmt_close($stmt2);
       }



// Close connection
mysqli_close($conn);
    }
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
        .wrapper, .box{ 
            
             margin-left: 40%; 
             margin-top: 3%; color: white; 
             background-color: black; 
             padding: 30px; 
             border-radius: 10px; 
             
            } 

            .wrapper{
                width: 350px;
                box-shadow: 0px 0px 20px 0px rgba(253, 253, 253, 0.75);
            }

            .grid-container{
                display: grid;
                grid-gap : 20px;
                width: 100px;
                padding: 0;
                margin: 0;
                height: 100px;
                margin-top: 10px;
                margin-bottom: -30px;
                margin-left: 37%;
                
            }

            .box{
                grid-row: 1;
                width: 150px;
                padding: 0;
                text-align: center;
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

<div class="grid-container">
    
    <div class="box">
    <h1><?php echo $leave_taken ?></h1>
    <p>Leave taken</p>
    </div>

    <div class="box">
    <h1><?php echo $leave_limit ?></h1>
    <p>Annual Limit</p>
    </div>

    
</div>

    <div class="wrapper">

    <span class="help-block boxError"><?php echo $leave_taken_err; ?></span>
        <h2>Leave form</h2>
        <p>Please fill this form to apply for leave</p>

        <br>

        


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        


            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Reason for leave</label>
                <textarea name="leave_reason" class="form-control" placeholder = "Write your reason here"></textarea>
                <span class="help-block"><?php echo $leave_reason_err; ?></span>
            </div>    


            <div class="form-group <?php echo (!empty($starting_date_err)) ? 'has-error' : ''; ?>">
                <label>Leave starting date</label>
                <input type="date" name="starting_date" class="form-control" ></input>
                <span class="help-block"><?php echo $starting_date_err; ?></span>
            </div>   

            <div class="form-group <?php echo (!empty($ending_date_err)) ? 'has-error' : ''; ?>">
                <label>Leave ending date</label>
                <input type="date" name="ending_date" class="form-control" ></input>
                <span class="help-block"><?php echo $ending_date_err; ?></span>
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
