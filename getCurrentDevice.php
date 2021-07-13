<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$deviceNumber = $_POST['deviceID'];


$sql = "SELECT * FROM tblDevice LEFT JOIN tblVehicle ON tblVehicle.ID = tblDevice.vehicleID LEFT JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID WHERE tblDevice.ID = '" . $deviceNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);



 echo json_encode($row);

 // echo var_dump ($row);

?>
