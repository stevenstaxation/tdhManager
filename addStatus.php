<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newStatusName = $_POST['statusNameToAdd'];

$errors='';


if (!$newStatusName || $newStatusName=='') {
    $errors .="You must enter the status description";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newStatusName = mysqli_real_escape_string($link,filter_var($newStatusName, FILTER_SANITIZE_STRING));

$sql = "INSERT INTO tblDeviceStatus (status) VALUES('$newStatusName')";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating device description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Device status description $newStatusName was created', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);

echo "success";



?>
