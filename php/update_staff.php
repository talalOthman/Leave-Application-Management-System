

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
$new_username = $new_firstname = $new_lastname = $new_password = $confirm_new_password = "";
$username_err = $new_password_err = $confirm_new_password_err= $firstname_err = $lastname_err = "";






   // to get the current values of "firstname" and "lastname"

   $sql5 = "SELECT staffinfo.Firstname, staffinfo.Lastname, staff.username FROM staffinfo, staff WHERE staff.id = ? AND staff.id = staffinfo.staff_id";



   //preparing the statement
   if($stmt5 = mysqli_prepare($conn, $sql5)){
   
       // Bind variables to the prepared statement as parameters
       mysqli_stmt_bind_param($stmt5, "i", $param_id);
   
       // Set parameters
       $param_id = $_GET['id'];
   
       // Attempt to execute the prepared statement
       if(mysqli_stmt_execute($stmt5)){
           
           // Store result
           mysqli_stmt_store_result($stmt5);
   
           
   
               // Bind result variables
               mysqli_stmt_bind_result($stmt5, $firstname, $lastname, $username);
               
   
               mysqli_stmt_fetch($stmt5);

               
   
           
       } else{
           echo "Something went wrong!";
       }
       
       mysqli_stmt_close($stmt5);
      
   }








 
// Processing form data when form is submitted
if(isset($_POST['id']) && !empty($_POST['id'])){
    // Get hidden input value
    $id = $_GET['id'];

    
    




 




    
   
 
    
    
    
    if(empty(trim($_POST['new_username']))){
        $username_err = "Please enter the new username.";
    } elseif(!filter_var($_POST['new_username'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/")))){
        $username_err = "Please enter a valid username.";
    } else{
        // Prepare a select statement
        $sql7 = "SELECT id FROM staff WHERE username = ? AND NOT id = ?";
        
        
        if($stmt7 = mysqli_prepare($conn, $sql7)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt7, "si", $param_username1, $temp_param_id);
            
            // Set parameters
            $param_username1 = trim($_POST["new_username"]);
            $temp_param_id = $_GET['id'];
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt7)){
                /* store result */
                mysqli_stmt_store_result($stmt7);

                
                
                if(mysqli_stmt_num_rows($stmt7) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $new_username = trim($_POST["new_username"]);
                    $username = trim($_POST["new_username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt7);
        }
    }


     // Validate password
     if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_new_password"]))){
        $confirm_new_password_err = "Please confirm password.";     
    } else{
        $confirm_new_password = trim($_POST["confirm_new_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_new_password)){
            $confirm_new_password_err = "Password did not match.";
        }
    }



        


    
    
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($firstname_err) && empty($lastname_err) && empty($new_password_err) && empty($confirm_new_password_err)){
        // Prepare an update statement
        $sql = "UPDATE staff SET username=?, password = ? WHERE id=?";
        
        // Set parameters
        $param_new_username = $_POST['new_username'];
        $param_new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $param_id = $_GET["id"];
        
         
        if($stmt = mysqli_prepare($conn, $sql)){

            

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_new_username, $param_new_password, $param_id);
            
            
            
            // Attempt to execute the prepared statement

            if(mysqli_stmt_execute($stmt)){

        


        //update firstname and lastname values
        $sql6 = "UPDATE staffinfo SET Firstname = ?, Lastname = ? WHERE staff_id = ?";
        
        // Set parameters
        
        $param_firstname = $_POST['firstname'];
        $param_lastname = $_POST['lastname'];
        $param2_id = $_GET["id"];

        //updating the sessions
        

         
        if($stmt6 = mysqli_prepare($conn, $sql6)){

            

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt6, "ssi", $param_firstname, $param_lastname, $param2_id);
            
            
            
            // Attempt to execute the prepared statement

            if(mysqli_stmt_execute($stmt6)){

                
                echo '<div class="alert alert-success" role="alert">
                Successfully updated !
              </div>';

              header("location: users_details.php");
              
                
            } else{
                header("location: admins.php");
                echo "Something went wrong. Please try again later.";
            }
            
        }

         // Close statement
        mysqli_stmt_close($stmt6);
                
            } else{
                header("location: admins.php");
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
    <title>View Manager</title>
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
    <h1>Edit Profile</h1>
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
            <h3>Personal info</h3>

            <form class="form-horizontal" role="form" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                    <label class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" name ="firstname" value = "<?php echo $firstname; ?>">
                        <span class="help-block"><?php echo $firstname_err;?></span>
                    </div>
                </div>
                <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                    <label class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" name ="lastname" value = "<?php echo $lastname; ?>" >
                        <span class="help-block"><?php echo $lastname_err;?></span>
                    </div>
                </div>
                
                
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label class="col-lg-3 control-label">Username:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" name ="new_username" value = "<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err;?></span>
                    </div>
                </div>
                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                    <label class="col-lg-3 control-label">New password:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="password" name ="new_password" >
                        <span class="help-block"><?php echo $new_password_err;?></span>
                    </div>
                </div>
                <div class="form-group <?php echo (!empty($confirm_new_password_err)) ? 'has-error' : ''; ?>">
                    <label class="col-lg-4 control-label">Confirm new password:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="password" name ="confirm_new_password" >
                        <span class="help-block"><?php echo $confirm_new_password_err;?></span>
                    </div>
                </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8">

                            <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?>>    
                            <input type="submit" class="btn btn-primary" value="Save Changes">
                            <span></span>
                            <input type="reset" class="btn btn-danger" value="Cancel">
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

        <!--<div class="col">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1>View Manager</h1>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <p class="form-control-static"><?php echo $row["username"]; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <p class="form-control-static"><?php echo $row["status"]; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <p class="form-control-static"><?php echo $row["password"]; ?></p>
                        </div>
                        <p><a href="users_details.php" class="btn btn-primary">Back</a></p>
                    </div>
                </div>
            </div>
        </div>-->
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
