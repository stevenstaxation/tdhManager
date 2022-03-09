<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$SIMStatusIDToDelete = $_POST['SIMStatusIDToDelete'];

$sql = "SELECT * FROM tblDevice WHERE SIMStatus='$SIMStatusIDToDelete'";
$result = mysqli_query($link, $sql);
$total = mysqli_num_rows($result);

if ($total == 1) {
    $device = " device.";
} else {
    $device = " devices.";
}

if ($total>0) {
    echo '<div class="alert alert-danger">Cannot delete this SIM status description.<br>
    It is attached to ' . $total . $device .'</div>';
    exit();
}

$sql = "SELECT SIMStatus FROM tblSIMStatus WHERE ID='$SIMStatusIDToDelete'";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);


$sql = "DELETE FROM tblSIMStatus WHERE ID='$SIMStatusIDToDelete'";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating SIM Status Description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('SIM status " . $row['SIMStatus']." was deleted', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    

echo "success";



?>
