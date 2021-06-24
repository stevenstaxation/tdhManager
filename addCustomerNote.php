<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}
//$currentCustomer = $_POST['employeeOf'];

$noteDate = $_POST['noteDate'];
$noteText = $_POST['noteText'];
$noteIsImportant = $_POST['isImportant'];
$noteIsAlertable = $_POST['isAlertable'];
if($noteIsImportant=='true') {
    $noteIsImportant = 1;
} else {
    $noteIsImportant = 0;
}
if($noteIsAlertable=='true') {
    $noteIsAlertable = 1;
} else {
    $noteIsAlertable = 0;
}


$errors = "";
// rules
// Date must be today or in the future.
// If date is in the future it must be 'alertable'
// Note text cannot be empty
// Max note length is 512 characters
$dateNow = new DateTime('today');
$noteDayDiff = $dateNow->diff(new DateTime($noteDate))->format('%r%a');
// if noteDayDiff is negative it is in the past, zero = today and positive is in the future
if ($noteDayDiff<0) {
    $errors .= 'Note date cannot be in the past<br>';
}

if ($noteText =='') {
    $errors .= 'Note text cannot be empty';
}

if ($noteDayDiff<=0 && $noteIsAlertable=='1') {
    $errors .= 'Cannot set an alert unless the note is in the future<br>';
}

if ($noteDayDiff>0) {
    $noteIsAlertable = 1;
}

if (strlen($noteText)>512) {
    $noteText = substr($noteText,0,512);
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$noteText = filter_var($noteText, FILTER_SANITIZE_STRING);
$noteText = mysqli_real_escape_string($link,$noteText);

$sql = "INSERT INTO tblCustomerNote (customerID, noteDate, noteText, userID, isImportant, isAnAlert) VALUES ('" . $_SESSION['currentCustomer'] ."','$noteDate', '$noteText', '" . $_SESSION['userID'] . "', '$noteIsImportant', '$noteIsAlertable')";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


echo "success";
?>
