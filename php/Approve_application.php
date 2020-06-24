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


// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "connect.php";
    
    $manager_id = $_SESSION['id'];
    // Prepare a select statement
    $sql = "UPDATE form SET status = 'APPROVED' , manager_id = $manager_id  WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
    
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            
            header("location: view_leave_form.php");
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);








    
    // to add the amount of leave taken by this user
    $sql2 = "UPDATE form, staff SET staff.applied_leave_num = staff.applied_leave_num +1 WHERE form.staff_id = staff.id";
    
    
     mysqli_query($conn, $sql2);






    
    
    // Close connection
    mysqli_close($conn);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
