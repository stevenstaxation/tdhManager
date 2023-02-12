<?php
session_start();
include('connect.php');

// Check user's input
// Possible errors include
$missingEmail = '<p>Please enter your email address.</p>';
$invalidEmail = '<p>You must enter a valid email address to register.</p>';
$missingLogInType = '<p>You must select the type of user.</p>';
$errors = "";

// Email address
if (empty($_POST['newUserEmail'])) {
    $errors .= $missingEmail;
} else {
    $userEmail = filter_var($_POST['newUserEmail'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}

$logInMask = 0;
if ($_POST['userTypeAdmin']=='on') {
    $logInMask = 1;
} else if ($_POST['userTypeStandard']=='on') {
    $logInMask = 2;
} else if ($_POST['userTypeInstaller']=='on') {
    $logInMask = 3;
} else if ($_POST['userTypeEngineer']=='on') {
    $logInMask = 4;
}
if ($logInMask == 0) {
    $errors .= $missingLogInType;
}
// Are there any errors?
if ($errors) {
    $resultMessage = "<div class='alart alert-danger' style='border-radius: 7px; padding: 4px 7px;margin-bottom: 10px;'>" . $errors . "</div";
    echo $resultMessage;
    exit();
}

// No errors
$userEmail = mysqli_real_escape_string($link, $userEmail);

// does email already exist?
$sql = "SELECT * FROM tblUsers WHERE email = '$userEmail'";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo '<div class="alert alert-danger">TDH Manager database is not currently available.</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}
if(mysqli_num_rows($result)) {
    echo '<div class="alert alert-danger">' .$userEmail .  ' has already been registered.</div>';
    exit();
}

// create a unique activation
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
$sql = "INSERT INTO tblInvites (email, activationKey, logInType) VALUES ('$userEmail', '$activationKey', '$logInMask')";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Could not update the database.</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}


// send user an email with a registration link
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
    $mail->Host='send.one.com';
    $mail->SMTPAuth=true; // Enable SMTP authentication
    $mail->Username='mailbox@stevenstaxation.com'; // SMTP username
    $mail->Password='W1!!M41!80xobo!7!'; // SMTP password
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    $mail->setFrom('mailbox@stevenstaxation.com', 'TDH Manager');
    //recipient
    $mail->addAddress($userEmail, $userEmail);     // Add a recipient
    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='TDH Manager - Invitation to Register';
    $mail->Body="<html><head></head><body><h2 style='color: blue'>TDH Manager.</h2><br><br>You have been invited to register a user account for TDH Manager.  Click on the link below to register your account<br><br> http://tdhmanager.office-on-the.net/signup.php?email=" . urlencode($userEmail) . "&activationKey=$activationKey</body></html>";
    $mail->AltBody= "You have been invited to register a user account for TDH Manager.\n\nClick on the link below to register your account.\n\n http://tdhmanager.office-on-the.net/signup.php?email=" . urlencode($userEmail) . "&activationKey=$activationKey</body></html>";
    $mail->send();
    
    echo "<div class='alert alert-success'>An invitation email has been sent to $userEmail.</div>";
}
catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: '.$mail->ErrorInfo;   
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('New user invited - $userEmail', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);

?>