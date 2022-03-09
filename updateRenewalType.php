<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updateRenewalTypeID = $_POST['RenewalTypeIDToUpdate'];
$updateRenewalTypeName = $_POST['RenewalTypeNameToUpdate'];

$errors='';


if (!$updateRenewalTypeName || $updateRenewalTypeName=='') {
    $errors .="Renewal type description cannot be empty";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updateRenewalTypeName = mysqli_real_escape_string($link,filter_var($updateRenewalTypeName, FILTER_SANITIZE_STRING));

// get old status name
$sql = "SELECT Description FROM tblRenewalType WHERE ID='$updateRenewalTypeID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblRenewalType SET Description = '$updateRenewalTypeName' WHERE ID='$updateRenewalTypeID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating renewal type Description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$description = "Renewal type description " . $prev['Description'] . " was changed to " . $updateRenewalTypeName;

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";



?>
