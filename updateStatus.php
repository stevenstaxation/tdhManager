<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updateStatusID = $_POST['statusIDToUpdate'];
$updateStatusName = $_POST['statusNameToUpdate'];

$errors='';


if (!$updateStatusName || $updateStatusName=='') {
    $errors .="Status description cannot be empty";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updateStatusName = mysqli_real_escape_string($link,filter_var($updateStatusName, FILTER_SANITIZE_STRING));

// get old status name
$sql = "SELECT status FROM tblDeviceStatus WHERE ID='$updateStatusID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblDeviceStatus SET status = '$updateStatusName' WHERE ID='$updateStatusID'";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating device status description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$description = "Status description " . $prev['status'] . " was changed to " . $updateStatusName;

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";

?>
