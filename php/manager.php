<?php

session_start();

require_once "connect.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../sign_in.php");
    exit;
}


if($_SESSION['userlevel'] !== "manager"){
    header("location: ../sign_in.php");
}


function approvedCount ($conn) 
{
    $sql = "SELECT COUNT(id) FROM form WHERE status = 'APPROVED'";
    $result = mysqli_query($conn,$sql);
    $rows = mysqli_fetch_row($result);
    return $rows[0];
}

function declinedCount ($conn) 
{
    $sql = "SELECT COUNT(id) FROM form WHERE status = 'DECLINED'";
    $result = mysqli_query($conn,$sql);
    $rows = mysqli_fetch_row($result);
    return $rows[0];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manager page</title>
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
                <a href="view_leave_form.php" class="bg-dark list-group-item list-group-item-action pb-3 mb-3">
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
        
        <div class="row">
                <div class="container col-sm-6">
                <canvas id="myChart" width = "800" height = "800"></canvas>

                </div>

               

                
                <div class="container col-sm-6">
                <canvas id="myChart2" width = "800" height = "800"></canvas>
                </div>
                
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script> <!-- CHART JS -->
    <script src="../javascript/script.js"></script>

  
    <script>
                
                
                let myChart = document.getElementById('myChart').getContext('2d');
                let myChart2 = document.getElementById('myChart2').getContext('2d');
                
                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 18;
                Chart.defaults.global.defaultFontColor = '#777';
                
                let Chart1 = new Chart(myChart, {
                  type:'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                  data:{
                    labels:['Approved applications', 'Declined applications'],
                    datasets:[{
                      label:'Population',
                      data:[
                       <?php echo approvedCount($conn); ?>,
                       <?php echo declinedCount($conn); ?>
                        
                      ],
                      //backgroundColor:'green',
                      backgroundColor:[
                        'rgb(0,128,128, 0.9)',
                        'rgb(58, 93, 122, 0.9)'
                      ],
                      borderWidth:1,
                      borderColor:'white',
                      hoverBorderWidth:3,
                      hoverBorderColor:'#000'
                    }]
                  },
                  options:{
                    
                    title:{
                      display:false,
                      text:'Number of users',
                      fontSize:25,
                      
                    },
                    legend:{
                      display:true,
                      position:'right',
                      labels:{
                        fontColor:'white'
                      }
                    },
                    layout:{
                      padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                      }
                    },
                    tooltips:{
                      enabled:true
                    }
                  }
                });
                
                
                
                let Chart2 = new Chart(myChart2, {
                  type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                  data:{
                    labels:['Approved applications', 'Declined applications'],
                    datasets:[{
                      
                      data:[
                       <?php echo approvedCount($conn); ?>,
                       <?php echo declinedCount($conn); ?>
                        
                      ],
                      //backgroundColor:'green',
                      backgroundColor:[
                        'rgb(0,128,128, 0.9)',
                        'rgb(58, 93, 122, 0.9)'
                 
                      ],
                      borderWidth:1,
                      borderColor:'white',
                      hoverBorderWidth:3,
                      hoverBorderColor:'black'
                    }]
                  },
                  options:{
                    
                    title:{
                      display:false,
                      text:'Number of users',
                      fontSize:25,
                      
                    },
                    legend:{
                      display:false,
                      position:'right',
                      labels:{
                        fontColor:'white'
                      }
                    },
                    layout:{
                      padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                      }
                    },
                    tooltips:{
                      enabled:true
                    },
                    scales: {
                      xAxes: [{
                        display: true,
                        ticks: {
                          min: 1,
                          fontColor: "rgb(255, 255, 255, 0.5)"
                        }
                      }],
                      yAxes: [{
                        display: true,
                        ticks: {
                            min: 0,
                            fontColor: "rgb(255, 255, 255, 0.5)"
                        }
                      }],
                    }
                  }
                });
                                
                                
                                </script>

    
</body>

</html>
