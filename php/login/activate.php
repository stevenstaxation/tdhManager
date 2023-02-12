<?php
session_start();
include('connect.php');
?>

<!DOCTYPE html>
<HTML lang='en'>
    <HEAD>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name = "viewport" content="width-device-width, initial-scale=1">
        <title>Account Activation</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <style>
        h1 {
            color: purple;
        }
        .contactForm {
            border: 1px solid mediumseagreen;
            margin-top: 50px;
            border-radius: 15px;
        }
        </style>

    </HEAD>

    <BODY>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-sm offset-1 col-sm-10 contactForm'>
                    <h1>TDH Manager</h1>
                
                    <?php
                    // If email or activation key is missing then show an error
                    if (!isset($_GET['email']) || !isset($_GET['key'])) {
                        echo '<div class="alert alert-warning">There was an error registering your account, please click on the activation link you received by email</div>';
                        exit();
                    }
                    // Store them in two variables
                    $email = $_GET['email'];
                    $key = $_GET['key'];
                    // Prepare variables for query
                    $email = mysqli_real_escape_string($link, $email);
                    $key = mysqli_real_escape_string($link, $key);
                    //    Run query - set activation field to activated for the email provided
                    $sql = "UPDATE tblUsers SET activation='activated' WHERE (email = '$email' AND activation ='$key') LIMIT 1";
                    $result = mysqli_query($link,$sql);
                    //    If query is successful, show success message and invite user to login
                    if (mysqli_affected_rows($link) == 1) {
                        $sql = "SELECT userID FROM tblUsers WHERE (email='$email' AND activation='activated')";
                        $result = mysqli_query($link, $sql);
                        $row = mysqli_fetch_array($result);
            
                        echo '<div class="alert alert-success">Your account registration has been completed successfully</div>';
                        echo '<a href="index.php" type="button" class="btn-lg btn-success" style="margin-bottom: 10px;">Log In</a>'; 

                        $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('New user has activated their account', '" . $row['userID']. "')";
                        $result = mysqli_query($link, $sql);

                 
                    } else {
                        // Show error message
                        echo '<div class="alert alert-danger">Your account could not be activated.</div>';
                    }       
                    ?>
                
                </div>
            </div>
        </div>
    </BODY>


</HTML>





































