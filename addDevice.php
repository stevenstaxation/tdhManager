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

$sql = "INSERT INTO tblDeviceDescription (description) VALUES('$newDeviceName')";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating device description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

echo "success";



?>
