<?php
session_start();

?>

<!DOCTYPE HTML>
<HTML lang="en">

<HEAD>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" integrity="sha384-xeJqLiuOvjUBq3iGOjvSQSIlwrpqjSHXpduPd6rQpuiM3f5/ijby8pCsnbu5S81n" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" type="text/css" href="styles/styles.css">

    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
   
    <title>TDH Manager</title>
    <script src='scripts/clickEvents.js'></script>
</HEAD>

<BODY>
    <div class='mainLogIn'>
        <section class='logIn'>
            <div class='container'>
                <div class='logInContent'>
                    <form method='POST' id='logInForm' class='logInForm'>
                        <img src='images/logo_swirl.png' alt='Data Hub Logo'>
                        <h2 class='form-header text-center' style='color: #0078bd; float: right; margin-top: 17px;'><strong>TDH Manager</strong></h2>
                        <h3 class='form-title h4' style='text-align: center; margin-top: 8px; margin-bottom: 30px;'>Log in to your account</h3>
                        <div class='form-group'>
                            <input type='text' class='form-input' name='userName' id='userName' placeholder='Enter your email address...' autocomplete='username'>
                        </div>
                        
                        <div class='input-group'>
                            <input style='width: 87%; margin-left: 0' type='password' class='form-control py-2 border-right-0 border' name='password' id='password' placeholder='Enter a password...' autocomplete='current-password'>
                            <span class='input-group-append'>
                                <button class='btn shadow-none border-left-0 border' id='pwButton' type='button' onclick='togglePassword()'>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </span>
                        </div>
                        <div id='logInMessage' style='margin-top:15px;'></div>
                        <div class='form-group text-center'>
                            <button type='submit' name='submit' id='submit' class='form-submit btn btn-success' style='border-radius: 10px; margin-top: 15px'>Log In</button>
                        </div>
                    </form>
                    <p class='forgotPassword text-center'>
                        <small>Forgot password? <a href='forgot.php' class='forgotLink'>reset it here</a></small>
                    </p>

                </div>
            </div>
        </section>
    </div>
  
    <script src='scripts/index.js'></script>
</BODY>

</HTML>
