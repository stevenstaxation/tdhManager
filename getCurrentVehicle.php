<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$vehicleNumber = $_POST['vehicleID'];


// $sql = "SELECT tblVehicle.make, tblVehicle.model, tblVehicle.addDescription, tblVehicle.regNumber, tblCustomer.businessName FROM tblVehicle INNER JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID WHERE tblVehicle.ID = '" . $vehicleNumber . "'";
$sql = "SELECT tblVehicle.regNumber, tblCustomer.businessName, tblVehicle.vehicleStatus, tblVehicle.installDate, tblVehicle.vehicleNotes, tblVehicle.cameraRequired, tblVehicle.LTAlarmDate, tblVehicle.SideScanDate FROM tblVehicle LEFT JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID WHERE tblVehicle.ID = '" . $vehicleNumber . "'";
$result = mysqli_query($link, $sql);


$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

echo json_encode($row);


?>
