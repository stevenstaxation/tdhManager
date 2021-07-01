<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$vehicleIDToDelete = $_POST['vehicleNumber'];

$sql = "SELECT ownerID, RegNumber FROM tblVehicle WHERE ID='$vehicleIDToDelete'";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);



$sql = "DELETE FROM tblVehicle WHERE ID='$vehicleIDToDelete'";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error deleting vehicle</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

   
$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Vehicle with VRN " . $row['RegNumber']." was deleted', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    

echo $row['ownerID'] . "success";




?>