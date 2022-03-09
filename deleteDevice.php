<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$deviceIDToDelete = $_POST['deviceIDToDelete'];

// cannot delete if the device status is linked to any devices
// if $deviceIDToDelete is found in tblDevice.deviceDescriptionID
// then cannot delete device description
$sql = "SELECT * FROM tblDevice WHERE deviceDescriptionID='$deviceIDToDelete'";
$result = mysqli_query($link, $sql);
$total = mysqli_num_rows($result);

if ($total == 1) {
    $device = " device.";
} else {
    $device = " devices.";
}

if ($total>0) {
    echo '<div class="alert alert-danger">Cannot delete this device description.<br>
    It is attached to ' . $total . $device .'</div>';
    exit();
}


$sql = "SELECT description FROM tblDeviceDescription WHERE ID='$deviceIDToDelete'";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);



$sql = "DELETE FROM tblDeviceDescription WHERE ID='$deviceIDToDelete'";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating Device Description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Device description " . $row['description']." was deleted', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    

echo "success";



?>
