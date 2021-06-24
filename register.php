<?php
session_start();
include ('connect.php');


// Check user's input
// Possible errors include
$missingEmail = '<p><strong>Please enter your email address.</strong></p>';
$missingUserName = '<p><strong>Please enter a user name.</strong></p>';
$invalidEmail = '<p><strong>You must enter a valid email address to register.</strong></p>';
$missingPassword = '<p><strong>Please enter a password</strong></p>';
$invalidPassword = '<p><strong>Your password does not meet the minimum security requirements.  Your password should be at least 8 characters long and include at least one capital letter and one number.</strong></p>';
$differentPassword = '<p><strong>Your passwords do not match.</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password.</strong></p>';
$errors = "";

// Get the user's input and check for errors
// Email address
if (empty($_POST['userEmail'])) {
    $errors .= $missingEmail;
} else {
    $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}
if (empty($_POST['userName'])) {
    $errors .= $missingUserName;
} else {
    $userName = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
}

// password
if (empty($_POST['password'])) {
    $errors .= $missingPassword;
} elseif (!(strlen($_POST['password'])>=8 and preg_match('/[A-Z]/', $_POST['password']) and preg_match('/[0-9]/', $_POST['password']))) {
        $errors .= $invalidPassword;        
    } else {
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        if (empty($_POST['password2'])) {
            $errors .= $missingPassword2;
        } else {
                 $password2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);
                if ($password !== $password2) {
                    $errors .= $differentPassword;
                }
            }
        }   


// Are there any errors?
if ($errors) {
    $resultMessage = "<div class='alart alert-danger' style='border-radius: 7px; padding: 4px 7px;margin-bottom: 10px;'>" . $errors . "</div";
    echo $resultMessage;
    exit();
}


// No errors
$userEmail = mysqli_real_escape_string($link, $userEmail);
$userName = mysqli_real_escape_string($link, $userName);
$password = mysqli_real_escape_string($link, $password);
$password = hash('sha256', $password);

// does email already exist?
$sql = "SELECT * FROM tblUsers WHERE email = '$userEmail'";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo '<div class="alert alert-danger">TDH Manager database is not currently available.</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}
if(mysqli_num_rows($result)) {
    echo '<div class="alert alert-danger">That email address has already been registered.  Do you want to <a href="logIn.php">log in</a>?</div>';
    exit();
}

// create a unique activation
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
$sql = "INSERT INTO tblUsers (email, userName, password, activation) VALUES ('$userEmail', '$userName', '$password', '$activationKey')";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Could not update the database.</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$newUserID = $link->insert_id;
$sql = "INSERT INTO tblUserRecord (userID) VALUES('$newUserID')";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo '<div class="alert alert-danger">Could not update the database.</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}




// send user an email with an activation link
require_once('mailer/SMTP.php');
require_once('mailer/PHPMailer.php');
require_once('mailer/Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

$mail=new PHPMailer(true); // Passing `true` enables exceptions
try {
    //settings
    $mail->SMTPDebug=0; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host='mail.overssl.net';
    $mail->SMTPAuth=true; // Enable SMTP authentication
    $mail->Username='mailbox@stevenstaxation.com'; // SMTP username
    $mail->Password='will220307'; // SMTP password
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    $mail->setFrom('mailbox@stevenstaxation.com', 'TDH Manager');
    //recipient
    $mail->addAddress($userEmail, $userEmail);     // Add a recipient
    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='TDH Manager - Confirm your Registration';
    $mail->Body="<html><head></head><body><h3 style='color: blue'>Thanks for registering for access to TDH Manager.</h3><br><br>If you are happy to continue your registration please click on the following link to activate your account.<br><br> http://tdhmanager.office-on-the.net/activate.php?email=" . urlencode($userEmail) . "&key=$activationKey</body></html>";
    $mail->AltBody= "Thanks for registering for access to TDH Manager.\n\nIf you are happy to continue your registration please click on the following link to activate your account.\n\n http://tdhmanager.office-on-the.net/activate.php?email=" . urlencode($userEmail) . "&key=$activationKey</body></html>";
    $mail->send();

    echo "<div class='alert alert-success'>Thank you for registering.  A confirmation email has been sent to $userEmail.  You will need to click on the activation link in this email to activate your account before you can log in.</div>";
}
catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: '.$mail->ErrorInfo;   
}




?>


