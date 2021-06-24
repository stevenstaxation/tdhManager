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

$sql = "UPDATE tblDeviceStatus SET status = '$updateStatusName' WHERE ID='$updateStatusID'";



$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating device status description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Status $updateStatusName was amended', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);



echo "success";



?>
