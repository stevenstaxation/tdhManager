<?php
session_start();
include('connect.php');
?>

<!DOCTYPE html>
<HTML lang='en'>
    <HEAD>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name = "viewport" content="width=device-width, initial-scale=1">
        <title>Password Reset</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
        <style>
        .contactForm {
            margin-top: 50px;
        }
        </style>

    </HEAD>

    <BODY>
        <div class='container'>
            <div class='row'>
                <div class='col-sm offset-1 col-sm-10 contactForm'>
                 
            
                    <?php
                    // If userID or activation key is missing then show an error
                    if (!isset($_GET['userID']) || !isset($_GET['key'])) {
                        echo '<div class="alert alert-warning">Please click on the link you received by email to reset your password.</div>';
                        exit();
                    }
                    // Store them in two variables
                    $userID = $_GET['userID'];
                    $key = $_GET['key'];
                    $time = time() - 3600;              
                    
                    // Prepare variables for query
                    $userID = mysqli_real_escape_string($link, $userID);
                    $key = mysqli_real_escape_string($link, $key);
                    
                    $sql = "SELECT userID FROM tblForgotPassword WHERE (userID = '$userID' AND validationKey ='$key' AND time > '$time' AND status='pending')";
                
                    $result = mysqli_query($link,$sql);
                    if (!$result) {
                        echo "<div class='alert alert-danger'>Cannot find user</div>";
                        exit();
                    }
                    
                    $count = mysqli_num_rows($result);
                    
                    if ($count !== 1) {
                        echo $sql;
                        echo "<div class='alert alert-danger'>This link is no longer valid</div>";
                        exit();
                    }
                     
                    echo "
                    <HTML><HEAD><Title>Reset Password</Title>
                    <link href='styles/styles.css' rel='stylesheet'>
                    <link rel='preconnect' href='https://fonts.gstatic.com'>
                    <link href='https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap' rel='stylesheet'>
  
                    <style>body {
                    background-color: #000;
                    background-repeat: repeat-y;
                    background-size:cover;
                    font-family: Lato, sans-serif;
                    height: 100%;
                    }
                    </style>
                    </HEAD>
                    <BODY>
                    <div class='resetLogIn'>
                    <section class='reset'>
                    <div class='container'>
                    <div class='logInContent'>
                    <form method='POST' id='passwordReset' class='resetForm'>
                        <input type='hidden' name='validationKey' value = '$key'>
                        <input type='hidden' name='userID' value = '$userID' autocomplete='username'>
                        <img src='images/logo_white_100.png'>
                        <h2 class='form-header' style='color:#0078bd; text-align: center'><strong>TDH Manager</strong></h2>
                        <h3 class='form-title h4' style='text-align: center; margin-bottom: 30px;'>Enter new password</h3>
                        <div class='form-group'>
                            <input type='password' name='password' id='password' placeholder='Enter new password...' class='form-input' autocomplete='new-password'>
                        </div>
                        <div class='form-group'>    
                            <input type='password' name='password2' id='password2' placeholder='Confirm new password...' class='form-input' autocomplete='new-password'>
                        </div>
                        <div class='form-group'>
                            <button type='submit' style='border-radius:10px' name='resetPassword' id='resetPassword' class='form-submit btn btn-success text-center'>Reset Password</button>    
                        </div>
                        </form>
                        <div id='resetPasswordMessage'></div>
                        <p class='logInInstead text-center'>
                        <small>Return to <a href='index.php' class='logMeInLink'>log in page</a></small>
                        </p>
                        </div></div></section></div></BODY></HTML>
                    ";
                        ?>
                  </div>
            </div>
        </div>
    
        
    <script>
       $('#passwordReset').submit(function (event) {
            // prevent default PHP processing 
            event.preventDefault();
            // collect user inputs
            var dataToPost = $(this).serializeArray();
            // send to storesetpassword.php using AJAX
            $.ajax({
                url: "storesetpassword.php",
                type: "POST",
                data: dataToPost,
                success: function (data) {
                 if (data.includes("success")) {
                        $('#resetPasswordMessage').html(data +"<br><br><p style='font-size:12px'>You will be redirected to the log in page in 5 seconds</p>");
                        window.setTimeout(function() {
                            window.location.href = "index.php";
                        }, 5000);
                    }
                    else {
                       $('#resetPasswordMessage').html(data); 
                       }
                },
                error: function () {
                    // if call is NOT successful show AJAX call error
                    $('#resetPasswordMessage').html("<div class='alert alert-danger'>There was an error with an AJAX call.  Try again later.</div>");
                }    
            });
        }); 
    </script>
    
    </BODY>


</HTML>





































