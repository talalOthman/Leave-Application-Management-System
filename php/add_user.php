<?php
// Include config file
require_once "connect.php";

session_start();

// if the user is not admin return to the login page.
if($_SESSION['userlevel'] !== "admins"){
    header("location: ../sign_in.php");
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../sign_in.php");
    exit;
}



 
// Define variables and initialize with empty values
$username = $firstname = $lastname = $password = $confirm_password = $chosenUser = "";

$chosenUserError = "";

$id = random_int(1, 1000000); // this will be the manager and staff ids



$username_err = $firstname_err = $lastname_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(empty($_POST['user'])){
        $chosenUserError = "Please choose between the two options above";
    } else{
    $chosenUser = $_POST['user'];
    }
 
    // Validate username
    if(empty(trim($_POST["new_username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM $chosenUser WHERE username = ? 
        UNION SELECT id FROM admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username1, $param_username2);
            
            // Set parameters
            $param_username1 = trim($_POST["new_username"]);
            $param_username2 = trim($_POST["new_username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["new_username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["new_password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_new_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_new_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your first name";
    }else{
        $firstname = $_POST["firstname"];
    }

    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter your last name";
    }else{
        $lastname = $_POST["lastname"];
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err)){
        
        
        // Prepare an insert statement
        $sql = "INSERT INTO $chosenUser (id, username, password, status, userType, applied_leave_num) VALUES ( '$id',?, ?, 'ACTIVE', '$chosenUser', 0)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                echo '<div class="alert alert-success" role="alert">
                User added!
              </div>';
              
              
                
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        
        
        
        
       




        
        

        

        // will add the firstname and lastname in a seperate table

        if($chosenUser === "staff"){
            // Prepare an insert statement
        $sql2 = "INSERT INTO staffinfo (staff_id, Firstname, Lastname) VALUES ($id, ?, ?)";
         
        if($stmt2 = mysqli_prepare($conn, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt2, "ss",  $param_firstname, $param_lastname);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt2)){

                

            }else{
             header("location admins.php");
            }
                

            // Close statement
            mysqli_stmt_close($stmt2);
        }
        }elseif($chosenUser === "manager"){
            // Prepare an insert statement
        $sql2 = "INSERT INTO managerinfo (Firstname, Lastname, manager_id) VALUES (?, ?, $id)";
         
        if($stmt2 = mysqli_prepare($conn, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt2, "ss", $param_firstname, $param_lastname);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            
            
            // Attempt to execute the prepared statement
           if(mysqli_stmt_execute($stmt2)){
               
           }else{
            header("location admins.php");
           }
                

            // Close statement
            mysqli_stmt_close($stmt2);
        }
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
    <!--Bootsrap 4 CDNs-->
    <!-- Bootstrap CSS -->
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
    <link rel="stylesheet" type="text/css" href="css/styles.css?ts=<?=time()?>" />
    <!--This was added because the CSS was not updating as it was loading from browser cache-->
    <style type="text/css">
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
            width: 100px;
        }

        .fix{
            width: 120px;
            padding: 10px;
            margin: 5px;
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
                    <a href="admin_view_profile.php" class="nav-link btn ">View Profile</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="update_admin.php" class="nav-link btn ">Edit Profile</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="add_user.php" class="nav-link btn">Add User</a>
                </li>
                <li class=" nav-item d-sm-block d-md-none">
                    <a href="users_details.php" class="nav-link btn">User Details</a>
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
                    <a href="admin_view_profile.php" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">View Profile</span>
                    </a>
                    <a href="update_admin.php" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">Edit Profile</span>
                    </a>
                </div>

                <!-- Separator with title -->
                <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                    <small>APPLICATION OPTIONS</small>
                </li>
                <!-- /END Separator -->
                <a href="add_user.php" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-tasks fa-fw mr-3"></span>
                        <span class="menu-collapsed">Add User</span>
                    </div>
                </a>
                <a href="users_details.php" class="bg-dark list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-tasks fa-fw mr-3"></span>
                        <span class="menu-collapsed">User Details</span>
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
                <h1>Add User</h1>
                <hr>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-4">
                        <div class="text-center">
                            <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
                            <h6>Upload a different photo...</h6>

                            <input type="file" class="form-control">
                        </div>
                    </div>

                    <!-- edit form column -->
                    <div class="col-md-8 personal-info">
                        <div class="alert alert-info alert-dismissable">
                            <a class="panel-close close" data-dismiss="alert">×</a>
                            <i class="fa fa-coffee"></i>
                            This is an <strong>.alert</strong>. Use this to show important messages to the user.
                        </div>
                        

                        <form class="form-horizontal" role="form" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">




                        <div class="form-group <?php echo (!empty($chosenUserError)) ? 'has-error' : ''; ?>">
                        <label>
                            <input type="radio" class="option" id="manager" name="user" value="manager">
                            <span class="spann">MANAGER</span>

                        </label>

                        <label>
                            <input type="radio" class="option" id="staff" name="user" value="staff">
                            <span class="spann">STAFF</span>
                        </label>
                        <br>
                        <span class="help-block"><?php echo $chosenUserError; ?></span>
                    </div>





                            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                                <label class="col-lg-3 control-label">First name:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" name ="firstname" >
                                    <span class="help-block"><?php echo $firstname_err;?></span>
                                </div>
                            </div>
                            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                                <label class="col-lg-3 control-label">Last name:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" name ="lastname"  >
                                    <span class="help-block"><?php echo $lastname_err;?></span>
                                </div>
                            </div>
                            
                            
                            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                <label class="col-lg-3 control-label">Username:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" name ="new_username" >
                                    <span class="help-block"><?php echo $username_err;?></span>
                                </div>
                            </div>
                            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                                <label class="col-lg-3 control-label">New password:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="password" name ="new_password" >
                                    <span class="help-block"><?php echo $password_err;?></span>
                                </div>
                            </div>
                            <div class="form-group <?php echo (!empty($confirm_new_password_err)) ? 'has-error' : ''; ?>">
                                <label class="col-lg-4 control-label">Confirm new password:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="password" name ="confirm_new_password" >
                                    <span class="help-block"><?php echo $confirm_password_err;?></span>
                                </div>
                            </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-8">

                                        <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?>>    
                                        <input type="submit" class="btn btn-primary fix" value="Save Changes">
                                        <span></span>
                                        <input type="reset" class="btn btn-danger fix" value="Cancel">
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>








                </form>
            </div>
        </div>
    </div>
    <!--Row end-->


    <!--Bootstrap 4 Things-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>
