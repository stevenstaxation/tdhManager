<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$issueUser = $_SESSION['userName'];
$issueEmail = $_SESSION['userEmail'];
//get userID
$sql = "SELECT userID FROM tblUsers WHERE (userName='$issueUser' AND email='$issueEmail')";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

$issueUserID = $row['userID']; 
$issueDate = $_POST['issueDate'];
$issuePriority = $_POST['issuePriority'];
$issueDescription = $_POST['issueDescription'];
$issueFileName = $_POST['issueFilename'];

switch ($issuePriority) {
    case '5':
        $issuePriorityText = 'Critical';
        break;
    case '4':
        $issuePriorityText = 'High';
        break;
    case '3':
        $issuePriorityText = 'Medium';
        break;
    case '2':
        $issuePriorityText = 'Low';
        break;
    case '1':
        $issuePriorityText = 'Blue Sky';
        break;                                     
    default:
    $issuePriorityText = 'Unknown';
        break;
}

// Add issue to list
$issueDescription = mysqli_real_escape_string($link, filter_var($issueDescription, FILTER_SANITIZE_STRING));
$sql = "INSERT INTO tblIssue (userID, description, priority, reportDate, status) VALUES ('$issueUserID', '$issueDescription', '$issuePriority', '$issueDate', '2' )";
$result = mysqli_query($link, $sql);

// Email the issue and include screenshot
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
    if ($issueFileName) {
        $mail->addAttachment($issueFileName);
    }
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    $mail->setFrom('mailbox@stevenstaxation.com', 'TDH Manager');
    //recipient
    $mail->addAddress('lee@stevenstaxation.com', 'lee@stevenstaxation.com');     // Add a recipient
    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='TDH Manager - New Issue/Bug/Feature Request';
    $mail->Body="<html><head></head><body><h6>" . $issueDescription ."</h6><br><br>Priority: " .$issuePriorityText ."<br><br></body></html>";
    $mail->AltBody= $issueDescription. "\n\nPriority: ". $issuePriorityText . "</body></html>";
    $mail->send();
}
catch (Exception $e) {
    echo "<div class='alert alert-danger'>Message could not be sent.<br>Mailer Error: " .$mail->ErrorInfo . "</div>";   
}


// Delete sceenshot when emailed



?>