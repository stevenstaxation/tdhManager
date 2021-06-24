<?php
session_start();
?>

<!DOCTYPE HTML>
<HTML lang="en">

<HEAD>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" description content="TDH Manager">

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


     <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="styles/styles.css">

    <title>TDH Manager - Reset Password</title>
    <style>
        body {
            background: #0f0f0f;
        }

    </style>


</HEAD>


<BODY>



    <div class='main'>
        <section class='forgot'>
            <div class='container'>
                <div class='signUpContent'>
                    <form method='POST' id='forgotPasswordForm' class='forgotPasswordForm'>
                    <img src='images/logo_swirl.png'>
                        <h2 class='form-header text-center' style='color: #0078bd; float: right; margin-top: 17px;'><strong>TDH Manager</strong></h2>
        
                        <h3 class='form-title h4' style='text-align: center; margin-top: 8px; margin-bottom: 30px;'>Reset your password</h3>
                        <div id='registerMessage'></div>
                        <div class='form-group'>
                            <input type='email' class='form-input' name='forgotPasswordEmail' id='forgotPasswordEmail' placeholder='Enter your email address...'>
                        </div>
                        <div class='form-group text-center'>
                            <button type='submit' name='submit' id='submit' class='form-submit btn btn-success' style='border-radius: 10px;'>Reset Password</button>
                        </div>
                        <p class='logInInstead text-center'><small>Return to <a href='index.php' class='logMeInLink'>log in page</a></small>
                        </p>
                    </form>
                </div>
            </div>
        </section>
    </div>


    <script src='scripts/index.js'></script>
</BODY>

</HTML>
