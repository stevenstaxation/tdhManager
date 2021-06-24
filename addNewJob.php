<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobDate = $_POST['jobDate'];
$jobDetails = $_POST['jobDetails'];
$jobType = $_POST['jobType'];
$jobVRN = $_POST['jobVRN'];
$jobCustomerID = $_SESSION['currentCustomer'];


$errors = "";

if (!$jobDate) {
    $errors .="You must include the Job Date<br>";
}

if (!$jobDetails) {
    $errors .= "You should enter a description of the job<br>";
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$jobDetails = mysqli_real_escape_string($link,filter_var($jobDetails, FILTER_SANITIZE_STRING));

$sql = "INSERT INTO tblJobs (ownerID, date, jobType, VRN, notes, status) VALUES ('$jobCustomerID','$jobDate', '$jobType', '$jobVRN', '$jobDetails', '1')";

$result = mysqli_query($link, $sql);

// $lastID = $link->insert_id;

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('New Job added', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$lastID = $_SESSION['currentCustomer'];

  if (!$result) {
        echo '<div class="alert alert-danger">Error updating insurer</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

echo $lastID . "success";

?>
