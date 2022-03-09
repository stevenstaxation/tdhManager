<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newDeviceName = $_POST['deviceNameToAdd'];

$errors='';


if (!$newDeviceName || $newDeviceName=='') {
    $errors .="You must enter the device name";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newDeviceName = mysqli_real_escape_string($link,filter_var($newDeviceName, FILTER_SANITIZE_STRING));

if (substr($newDeviceName,0,2)=='AI') {
    $deviceGroup = 1;
} elseif (substr($newDeviceName,0,3)=='CP2') {
    $deviceGroup = 2;
} elseif (substr($newDeviceName,0,3)=='CP4') {
    $deviceGroup = 3;
} elseif (substr($newDeviceName,0,3)=='KP1') {
    $deviceGroup = 5;
} else {
    $deviceGroup = 4;
}


$sql = "INSERT INTO tblDeviceDescription (description, deviceGroup) VALUES('$newDeviceName', '$deviceGroup')";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating device description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Device description $newDeviceName was created', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);

echo "success";



?>
