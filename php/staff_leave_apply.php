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
    <title>Apply For Leave</title>
    <!--Font awesome kit-->
    <script src="https://kit.fontawesome.com/7887806c2e.js" crossorigin="anonymous"></script>
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

    <!--Bootsrap 4 CDNs-->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../css/stylesB.css?ts=<?=time()?>" />
    <!--This was added because the CSS was not updating as it was loading from browser cache-->
    <style type="text/css">
        body {
            font:  "Roboto";
            background-color: #2f323a;
        }

        .wrapper,
        .box {


            color: white;
            background-color: #47717a;
            padding: 30px;
            border-radius: 10px;

        }

        .wrapper {
            
            width: 350px;
            box-shadow: 0px 0px 20px 0px rgba(253, 253, 253, 0.75);
        }



        .box {
            
            width: 150px;
            padding: 0;
            text-align: center;
            justify-content: center;
        }







        .option:checked~.spann {
            color: white;
            background-color: #2e86de;
            transform: scale(1.1);
        }

        .spann {
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

        input {
            display: none;
        }

        .help-block {
            color: red;
        }

    </style>
</head>

<body>
    <!--    Navbar begins-->
    <!-- Bootstrap NavBar -->
    <!-- Bootstrap NavBar -->
    <nav class="navbar navbar-expand-md navbar-dark ">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon "></span>
        </button>
        <a class="navbar-brand" href="../sign_in.php">
            <i class="fas fa-address-card align-middle  "></i>
            <span class="menu-collapsed navtitle align-middle "><b>Leave Management System</b></span>
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <!-- This menu is hidden in bigger devices with d-sm-none. 
                    The sidebar isn't proper for smaller screens imo, so this dropdown menu can keep all the
                        useful sidebar itens exclusively for smaller screens  -->
                <li class="nav-item dropdown d-sm-block d-md-none">
                    <div class="dropdown-menu" aria-labelledby="smallerscreenmenu">
                        <!-- <li class=" nav-item d-sm-block d-md-none"> to hide from bigger screens -->
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="staff_view_profile.php" class="nav-link btn ">View Profile</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="update_staff_own.php" class="nav-link btn ">Edit Profile</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="staff_leave_apply.php" class="nav-link btn">Apply for leave</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="view_application_result.php" class="nav-link btn">View application results</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="view_pending_application.php" class="nav-link btn">View pending applications</a>
                </li>
                <li class="nav-item active">
                    <a href="sign_out.php" class="nav-link btn btn-danger">Sign Out</a>
                </li>
        </div>
        </li>
        </ul>
        </div>
    </nav><!-- NavBar END -->
    <!-- Bootstrap row -->
    <div class="row" id="body-row">
        <!-- Sidebar -->
        <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
            <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
            <!-- Bootstrap List Group -->
            <ul class="list-group">
                <!-- Separator with title -->
                <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                    <small>MAIN MENU</small>
                </li>
                <!-- /END Separator -->
                <!-- Menu with submenu -->
                <a href="staff.php" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-tachometer-alt fa-fw mr-3"></span>
                        <span class="menu-collapsed">Home</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>

                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-user fa-fw mr-3"></span>
                        <span class="menu-collapsed">Profile</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- Submenu content -->
                <div id='submenu2' class="collapse sidebar-submenu">
                    <a href="staff_view_profile.php" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">View Profile</span>
                    </a>
                    <a href="update_staff_own.php" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">Edit Profile</span>
                    </a>
                </div>

                <!-- Separator with title -->
                <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                    <small>APPLICATION OPTIONS</small>
                </li>
                <!-- /END Separator -->
                <a href="staff_leave_apply.php" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-tasks fa-fw mr-3"></span>
                        <span class="menu-collapsed">Apply for Leave</span>
                    </div>
                </a>
                <a href="view_application_result.php" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-tasks fa-fw mr-3"></span>
                        <span class="menu-collapsed">Application results</span>
                    </div>
                </a>
                <a href="view_pending_application.php" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-tasks fa-fw mr-3"></span>
                        <span class="menu-collapsed">Pending applications</span>
                    </div>
                </a>
                <!-- Separator without title -->
                <li class="list-group-item sidebar-separator menu-collapsed"></li>
                <!-- /END Separator -->
            </ul><!-- List Group END-->
        </div><!-- sidebar-container END -->
        <!--    navbar ends-->


        <!-- Main Section-->




        <div class="container col">
            <br><br><br>
            <div class="row justify-content-center ">
                <div class="row">
                <div class="box mr-5 ">
                    <h1><?php echo $leave_taken ?></h1>
                    <p>Leave taken</p>
                </div>
                <div class="box">
                    <h1><?php echo $leave_limit ?></h1>
                    <p>Annual Limit</p>
                    </div>
                </div>
            </div>
            <br><br><br><br>

            <div class="row justify-content-center">
                <div class="wrapper">


                    <span class="help-block boxError"><?php echo $leave_taken_err; ?></span>
                    <h2>Leave form</h2>
                    <p>Please fill this form to apply for leave</p>

                    <br>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Reason for leave</label>
                            <textarea name="leave_reason" class="form-control" placeholder="Write your reason here"></textarea>
                            <span class="help-block"><?php echo $leave_reason_err; ?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($starting_date_err)) ? 'has-error' : ''; ?>">
                            <label>Leave starting date</label>
                            <input type="date" name="starting_date" class="form-control"></input>
                            <span class="help-block"><?php echo $starting_date_err; ?></span>
                        

                        <div class="form-group <?php echo (!empty($ending_date_err)) ? 'has-error' : ''; ?>">
                            <label>Leave ending date</label>
                            <input type="date" name="ending_date" class="form-control"></input>
                            <span class="help-block"><?php echo $ending_date_err; ?></span>
                        </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-info mr-3" value="Submit">
                            <input type="reset" class="btn btn-info" value="Reset">
                        </div>
                </div>
            </div>
        </div>
             </form>
        </div>
   
  
    <!--Row end-->

    <!--Bootstrap 4 Things-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="../javascript/script.js"></script>

</body>

</html>
