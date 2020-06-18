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
            width: 900px;
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
        body{ font: 14px sans-serif; text-align: center; 
        }
        body{ font: 14px sans-serif; background-color: #2f323a;}
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
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Leave Applications</h2>
                        
                        <a href ="manager.php" class ="btn btn-success"> Menu Page</a>
                        
                    </div>
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
                    
                    // Attempt select query execution
                    $sql = "SELECT form.id, form.reason, staff.username FROM form, staff WHERE form.staff_id = staff.id AND form.status = 'NOT DONE'";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Leave Reason</th>";
                                        echo "<th>Staff Username</th>";
                                        echo "<th>Action";
                                       
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['reason'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        
                                        echo "<td>";
                                            echo "<a href='Approve_application.php?id=". $row['id'] ."' title='Approve Application' data-toggle='tooltip'><span class='glyphicon glyphicon-ok'></span></a>";
                                            echo "<a href='Decline_application.php?id=". $row['id'] ."' title='Decline Application' data-toggle='tooltip'><span class='glyphicon glyphicon-remove'></span></a>";
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
            </div>        
        </div>
    </div>
</body>
</html>