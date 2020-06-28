<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Results</title>
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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 900px;
            margin: 0 auto;
    
        }
        table tr td:last-child a{
            margin-right: 15px;
            
        }
        a.btn{
            margin-left: 10px;
        }
    
        .wrapper{ 
             background-color: black;
             margin-top: 6%; 
             color: #23527C;
             padding: 30px; 
             border-radius: 10px; 
             box-shadow: 0px 0px 20px 0px rgba(253, 253, 253, 0.75);
            } 
    </style>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
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
        
        
    <!--Row end-->
        <div class="col">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left display-4 text-white" >Approved applications</h2>
                            <br>


                        </div>
                        <?php 
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
                        $staff_id = $_SESSION['id'];
                        // Attempt select query execution
                        $sql = "SELECT form.id, form.reason, manager.username, form.starting_date, form.ending_date  FROM form, manager WHERE form.manager_id = manager.id AND form.status = 'APPROVED' AND form.staff_id = $staff_id;";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo "<table class='table table-bordered table-dark table-striped'>";
                                    echo "<thead class='thead-dark'>";
                                        echo "<tr>";


                                            echo "<th>Leave Reason</th>";
                                            echo "<th>Manager Username</th>";
                                            echo "<th>Starting Date</th>";
                                            echo "<th>Ending Date</th>";

                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<tr>";

                                        echo "<td>" . $row['reason'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['starting_date'] . "</td>";
                                        echo "<td>" . $row['ending_date'] . "</td>";

                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free result set

                            } else{
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }


                        ?>


                        <div class="page-header clearfix">
                            <h2 class="pull-left display-4 text-white">Declined applications</h2>

                        </div>
                        <?php              

                        // Include config file
                            require_once "connect.php";

                            // Attempt select query execution
                            $sql = "SELECT form.id, form.reason, manager.username, form.starting_date, form.ending_date FROM form, manager WHERE form.manager_id = manager.id AND form.status = 'DECLINED' AND form.staff_id = $staff_id;";
                            if($result = mysqli_query($conn, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    echo "<table class='table table-bordered table-dark table-striped'>";
                                        echo "<thead>";
                                            echo "<tr>";

                                            echo "<th>Leave Reason</th>";
                                                echo "<th>Manager Username</th>";
                                                echo "<th>Starting Date</th>";
                                                echo "<th>Ending Date</th>";

                                            echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";
                                        while($row = mysqli_fetch_array($result)){
                                            echo "<tr>";

                                            echo "<td>" . $row['reason'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['starting_date'] . "</td>";
                                            echo "<td>" . $row['ending_date'] . "</td>";

                                            echo "</tr>";
                                        }
                                        echo "</tbody>";                            
                                    echo "</table>";
                                    // Free result set
                                    mysqli_free_result($result);
                                } else{
                                    echo "<p class='lead'><em>No records were found.</em></p>";
                                }
                            } else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }

                            // Close connection
                            mysqli_close($conn);
                        ?>

                    </div>
                </div>        
            </div>
        </div>    
    </div>

    <!--Bootstrap 4 Things-->
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script src="../javascript/script.js"></script>
</body>
</html>