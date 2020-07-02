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

// Include config file
require_once "connect.php";
 
$id = $_SESSION['id'];



$sql = "SELECT managerinfo.Firstname, managerinfo.Lastname, manager.username FROM managerinfo, manager WHERE manager.id = ? AND managerinfo.manager_id = manager.id";



//preparing the statement
if($stmt = mysqli_prepare($conn, $sql)){

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);

    // Set parameters
    $param_id = $id;

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        
        // Store result
        mysqli_stmt_store_result($stmt);

        

            // Bind result variables
            mysqli_stmt_bind_result($stmt, $firstname, $lastname, $username);

            mysqli_stmt_fetch($stmt);

        
    } else{
        echo "Something went wrong!";
    }
    

    mysqli_close($conn);
}







 


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Profile</title>
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
                    <a href="manager_view_profile.php" class="nav-link btn ">View Profile</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="update_manager_own.php" class="nav-link btn ">Edit Profile</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="view_leave_form.php" class="nav-link btn">View Pending Applications</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="view_all_staff_application.php" class="nav-link btn">View All Application</a>
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
                <a class="bg-dark list-group-item list-group-item-action flex-column align-items-start" href="staff.php">
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
                    <a href="manager_view_profile.php" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">View Profile</span>
                    </a>
                    <a href="update_manager_own.php" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">Edit Profile</span>
                    </a>
                </div>

                <!-- Separator with title -->
                <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                    <small>APPLICATION OPTIONS</small>
                </li>
                <!-- /END Separator -->
                <a href="view_leave_form.php" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-tasks fa-fw mr-3"></span>
                        <span class="menu-collapsed">View Pending Applications</span>
                    </div>
                </a>
                <a href="view_all_staff_application.php" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-tasks fa-fw mr-3"></span>
                        <span class="menu-collapsed">View All Applications</span>
                    </div>
                </a>
                <!-- Separator without title -->
                <li class="list-group-item sidebar-separator menu-collapsed"></li>
                <!-- /END Separator -->
            </ul><!-- List Group END-->
        </div><!-- sidebar-container END -->
        <!--    navbar ends-->

        <!-- Main Section-->


        <div class="col">

            <div class="container text-white rounded mt-3 pt-3 " id="editform">
                <h1>My Profile</h1>
                <hr>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-4">
                        <div class="text-center">
                            <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
                        </div>
                    </div>

                    <!-- edit form column -->
                    <div class="col-md-8 personal-info">
                        <div class="alert alert-info alert-dismissable">
                            <a class="panel-close close" data-dismiss="alert">×</a>
                            <i class="fa fa-coffee"></i>
                            This is an <strong>.alert</strong>. Use this to show important messages to the user.
                        </div>
                        <h3>Personal info</h3>

                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">First name:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" value="<?php echo $firstname; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label ">Last name:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" value="<?php echo $lastname; ?>" readonly>
                                </div>
                            </div>
                            
                            
                            
                            
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Username:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" value="<?php echo $username ?>" readonly>
                                    </div>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <!--            <div class="container-fluid">
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
            </div> -->
        </div>
    </div>
    <!--Row end-->
    <!--Bootstrap 4 Things-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="../javascript/script.js"></script>
    </div>
    </div>
</body>

</html>
