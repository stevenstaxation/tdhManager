<?php

// Start Session 
session_start();
// Connect to the database
include('../../connect.php');



// Check user inputs
//     Define error messages 
    $missingEmail = '<p>Please enter your email address</p>';
    $invalidEmail = '<p>The Email address entered is invalid</p>';
    $errors = "";
//     Get email
    if(empty($_POST['forgotPasswordEmail'])) {
        $errors .= $missingEmail;
    } else {
        $email = filter_var($_POST['forgotPasswordEmail'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors .= $invalidEmail;
        }
    }
   
// If there are any errors then print error
if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

// If there are no errors
//     Prepare variables for query
$email = mysqli_real_escape_string($link,$email);


//     Check email exists in users table
$sql = "SELECT * FROM tblUsers WHERE email = '$email'";


$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error accessing the database</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$count = mysqli_num_rows($result);

if ($count !=1) {
    echo '<div class="alert alert-danger">That email address does not exist on our database</div>';
    exit();
} 

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$userID = $row['userID'];
$validationKey = bin2hex(openssl_random_pseudo_bytes(16));
$time = time();
$status = 'pending';

$sql = "INSERT INTO tblForgotPassword (userID, validationKey, time, status) VALUES ('$userID', '$validationKey', '$time', '$status')";


$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error accessing the database</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "SELECT email FROM tblUsers WHERE userID='$userID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

$emailToSendTo = $row['email'];

// send email with link to resetpassword.php with userID and activation code
require_once('../../mailer/SMTP.php');
require_once('../../mailer/PHPMailer.php');
require_once('../../mailer/Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

$mail=new PHPMailer(true); // Passing `true` enables exceptions

try {
    //settings
    $mail->SMTPDebug=0; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host='send.one.com';
    $mail->SMTPAuth=true; // Enable SMTP authentication
    $mail->Username='mailbox@stevenstaxation.com'; // SMTP username
    $mail->Password='W1!!M41!80xobo!7!'; // SMTP password
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    $mail->setFrom('mailbox@stevenstaxation.com', 'TDH Manager');

    //recipient
    $mail->addAddress($emailToSendTo, $emailToSendTo);     // Add a recipient

    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='Reset your password';
    $mail->Body="<html><head></head><body><h3 style='color: blue'>Reset your Password.</h3><br><br>A request has been received to reset your password for access to TDH Manager.<br><br> Please click on the following link to reset your password.<br><br>https://127.0.0.1:8080/php/login//resetpassword.php?userID=" . $userID . "&key=$validationKey <br><br>This link will expire in 60 minutes.<br><br>If you did not make this request then please ignore this email.";
    
    $mail->AltBody= "Reset your Password.\n\n A request has been received to reset your password for access to TDH Manager.\n\n Please click on the following link to reset your password.\n\n This link will expire in 60 minutes \n\n http://tdhmanager.office-on-the.net/resetpassword.php?userID=" . $userID . "&key=$validationKey \n\nIf you did not make this request then please ignore this email.";

    $mail->send();

    echo "<div class='alert alert-success'>An email has been sent to $emailToSendTo.  Please click on the link in this email to reset your password</div>";  
} 
catch(Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: '.$mail->ErrorInfo;
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Password reset email sent to $emailToSendTo', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


?>
