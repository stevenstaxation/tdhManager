<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$noteDate = $_POST['noteDateEdited'];
$noteText = $_POST['noteTextEdited'];
$noteImportant = $_POST['noteIsImportantEdited'];
$noteAlert = $_POST['noteIsAlertEdited'];
$noteCustomerNumber = $_POST['customerNumber'];
$noteNoteNumber = $_POST['noteNumber'];
$noteNoteUser = $_POST['noteUser'];

if($noteImportant=='true') {
    $noteImportant = 1;
} else {
    $noteImportant = 0;
}
if($noteAlert=='true') {
    $noteAlert = 1;
} else {
    $noteAlert = 0;
}

$errors = "";
$doNotUpdateDate = 'false';
// rules
// Date must be today or in the future - if it is in the past it will not be updated
// This means old dates can remain  but not be changed

// If date is in the future it must be 'alertable'

// Max note length is 512 characters

$dateNow = new DateTime('today');
$noteDayDiff = $dateNow->diff(new DateTime($noteDate))->format('%r%a');

if ($noteDayDiff<0) {
    $doNotUpdateDate = 'true';
}

if ($noteDayDiff<=0 && $noteAlert=='1') {
    $errors .= 'Cannot set an alert unless the note is in the future<br>';
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

if ($doNotUpdateDate=='true') {
    $sql = "UPDATE tblCustomerNote SET customerID = '$noteCustomerNumber', noteText = '$noteText', userID = '$noteNoteUser', isImportant = '$noteImportant', isAnAlert = '$noteAlert' WHERE tblCustomerNote.cnID = '$noteNoteNumber'";
} else {
    $sql = "UPDATE tblCustomerNote SET customerID = '$noteCustomerNumber', noteDate = '$noteDate', noteText = '$noteText', userID = '$noteNoteUser', isImportant = '$noteImportant', isAnAlert = '$noteAlert' WHERE tblCustomerNote.cnID = '$noteNoteNumber'";
}

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

echo "success";

?>
