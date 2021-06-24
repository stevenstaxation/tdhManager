<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$deviceIDToDelete = $_POST['deviceIDToDelete'];

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
