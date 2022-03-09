<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updateDeviceID = $_POST['deviceIDToUpdate'];
$updateDeviceName = $_POST['deviceNameToUpdate'];

$errors='';


if (!$updateDeviceName || $updateDeviceName=='') {
    $errors .="Device name cannot be empty";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updateDeviceName = mysqli_real_escape_string($link,filter_var($updateDeviceName, FILTER_SANITIZE_STRING));

// get old device name
$sql = "SELECT description FROM tblDeviceDescription WHERE ID='$updateDeviceID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblDeviceDescription SET description = '$updateDeviceName' WHERE ID='$updateDeviceID'";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating insurer</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$description = "Device description " . $prev['description'] . " was changed to " . $updateDeviceName;

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    
    
    echo "success";



?>
