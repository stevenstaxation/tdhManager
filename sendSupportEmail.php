<?php
session_start();

$errorDate = $_POST['timeStamp'];
$errorMessage = $_POST['message'];

// send an email silently to lee@stevenstaxation.com with error details
require_once 'mailer/SMTP.php';
require_once 'mailer/PHPMailer.php';
require_once 'mailer/Exception.php';

use \PHPMailer\PHPMailer\Exception;
use \PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true); // Passing `true` enables exceptions
try {
    //settings
    $mail->SMTPDebug = 0; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'send.one.com';
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'mailbox@stevenstaxation.com'; // SMTP username
    $mail->Password = 'W1!!M41!80xobo!7!'; // SMTP password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('mailbox@stevenstaxation.com', 'TDH Manager Error');
    //recipient
    $mail->addAddress('lee@stevenstaxation.com', 'lee@stevenstaxation.com'); // Add a recipient
    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'TDH Manager - Error Message';
    $mail->Body = "Occurred at " . $errorDate . "<br><br>" . $errorMessage;
    $mail->AltBody = "Occurred at " . $errorDate . "<br><br>" . $errorMessage;
    $mail->send();
} catch (Exception $e) {
}
