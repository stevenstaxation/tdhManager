<?php
session_start();
include "connect.php";

//check if user and activation key are present and correct
$logInType = "";
if (isset($_GET['email']) && isset($_GET['activationKey'])) {
    $sql = "SELECT * FROM tblInvites WHERE email='" . $_GET['email'] . "' AND activationKey='" . $_GET['activationKey'] . "'";
    $result = mysqli_query($link, $sql);

    if (!$result || mysqli_num_rows($result)!=1) {
        echo "You are not authorised to access this page";
        exit();
    }  
    $row = mysqli_fetch_array($result);
    $logInType = $row['loginType'];

    // invite can only be used once and so delete it now
    $sql = "DELETE FROM tblInvites WHERE email='" . $_GET['email'] . "' AND activationKey='" . $_GET['activationKey'] . "'";

} else {
    echo "You are not authorised to access this page";
    exit();
}

?>


<!DOCTYPE HTML>
<HTML lang="en">
        
<HEAD>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" description content="Book library database">


    
     
    <!-- bootstrap  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Font Awesome 5 Icons-->
   <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Font -->
     <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">

    
        <!-- standard style sheets -->
         <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <title>TDH Manager</title>



</HEAD>
   
    
    <BODY>
    
        <div class='main'>
            <section class='signUp'>
                <div class='container'>
                    <div class='signUpContent'>
                        <form method = 'POST' id = 'signUpForm' class='signUpForm'>
                        <img src='images/logo_swirl.png'>
                        <h2 class='form-header text-center' style='color: #0078bd; float: right; margin-top: 17px;'><strong>TDH Manager</strong></h2>
                          <h3 class='form-title h4' style='text-align: center; margin-top: 8px; margin-bottom: 30px;'>Create an account</h3>
                                <div id='registerMessage'></div>
                                <div class='form-group'>
                                    <input type='text' class='form-input' name='userEmail' readonly='readonly' id='userEmail' value='<?php echo $_GET['email']?>'>
                                </div> 
                                <div class='form-group'>
                                    <input type='text' class='form-input' name='userName' id='userName' placeholder='Enter a user name...' autocomplete='username' autofocus>
                                </div> 
                                <div class='form-group'>
                                    <input type='password' class='form-input' name='password' id='password' placeholder='Create a password...' autocomplete='new-password'>
                                    <span toggle='#password'></span> 
                                </div> 
                                <div class='form-group'>
                                    <input type='password' class='form-input' name='password2' id='password2' placeholder='Confirm your password...' autocomplete='new-password'>
                                </div> 
                                <div class='form-group'>
                                    <div id='hiddenUserType' style='display:none'><?php echo $logInType?></div>
                                </div>
                                <div class='form-group text-center'>
                                    <button type='submit' name='submit' id='submit' class='form-submit btn btn-success' style='border-radius: 10px;'>Register Account</button>
                                </div>
                               
                        </form>
                        <p class='logInInstead text-center'>
                        <small>Already Registered? Then <a href='index.php' class='logMeInLink'>log in here</a></small>
                        </p>
                    </div>   
                </div>
            </section>
        </div>
        
        
      
        
    <script src='scripts/index.js'></script>
</BODY>
    
</HTML>



                        