<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updateIssueID = $_POST['issueIDToUpdate'];
$updateIssueDate = $_POST['issueDate'];
$updateIssuePriority = $_POST['issuePriority'];
$updateIssueStatus = $_POST['issueStatus'];
$updateIssueDescription = $_POST['issueDescription'];

$updateIssueDescription = mysqli_real_escape_string($link, filter_var($updateIssueDescription, FILTER_SANITIZE_STRING));

$sql = "UPDATE tblIssue SET reportDate = '$updateIssueDate', priority = '$updateIssuePriority', status = '$updateIssueStatus', description = '$updateIssueDescription' WHERE ID='$updateIssueID'";

$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating issue</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


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
    $mail->Subject='TDH Manager - Update to Issue/Bug/Feature Request';
    $mail->Body="<html><head></head><body><h6>Issue no. " . $updateIssueID ." has been amended</h6></body></html>";
    $mail->AltBody= $issueDescription. "\n\nAmendment to Issue No. ". $updateIssueID . "</body></html>";
    $mail->send();
}
catch (Exception $e) {
    echo "<div class='alert alert-danger'>Message could not be sent.<br>Mailer Error: " .$mail->ErrorInfo . "</div>";   
}



























echo "success";



?>