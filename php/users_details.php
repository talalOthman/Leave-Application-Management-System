<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
        a.btn{
            margin-left: 10px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Managers details</h2>
                        
                        <a href ="admins.php" class ="btn btn-success"> Menu Page</a>
                        
                    </div>
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
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM manager";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Username</th>";
                                        echo "<th>Password</th>";
                                        echo "<th>Status</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['password'] . "</td>";
                                        echo "<td>" . $row['status'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='view_manager.php?id=". $row['id'] ."' title='View Manager' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update_manager.php?id=". $row['id'] ."' title='Update Manager' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete_manager.php?id=". $row['id'] ."' title='De-Activate Manager' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
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
                        <h2 class="pull-left">Staff details</h2>
                        
                    </div>
                    <?php

                    
                    

                    if($_SESSION['userlevel'] !== "admins"){
                        header("location: ../sign_in.php");
                        }
                    

                    // Include config file
                    require_once "connect.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM staff";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Username</th>";
                                        echo "<th>Password</th>";
                                        echo "<th>Status</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['password'] . "</td>";
                                        echo "<td>" . $row['status'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='view_staff.php?id=". $row['id'] ."' title='View staff' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update_staff.php?id=". $row['id'] ."' title='Update staff' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete_staff.php?id=". $row['id'] ."' title='De-Activate staff' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
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
</body>
</html>