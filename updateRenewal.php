<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$renewalType = $_POST['renewalType'];
$renewalDate = $_POST['renewalDate'];
$customerID = $_SESSION['currentCustomer'];

$errors = "";

// rules
// Date must be in the future
$dateNow = new DateTime();
$renewDate = new DateTime($renewalDate);
$daysToRenewal = $dateNow->diff($renewDate)->format('%r%a');
if ($daysToRenewal<=-1) {
    $errors .= "Renewal date must be in the future";
}

if (empty($renewalType)) {
    $renewalType='0';
}


$renewalType = mysqli_real_escape_string($link,filter_var($renewalType, FILTER_SANITIZE_STRING));
$renewalDate = mysqli_real_escape_string($link,filter_var($renewalDate, FILTER_SANITIZE_STRING));


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$renewalType = mysqli_real_escape_string($link,filter_var($renewalType, FILTER_SANITIZE_STRING));
$renewalDate = mysqli_real_escape_string($link,filter_var($renewalDate, FILTER_SANITIZE_STRING));

$sql = "UPDATE tblCustomer SET renewalType=NULLIF('$renewalType',''), renewalDate = NULLIF('$renewalDate','') WHERE ID = '$customerID'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Renewal date amended', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);




echo "success";

?>
