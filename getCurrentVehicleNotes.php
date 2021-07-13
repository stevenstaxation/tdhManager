<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$vehicleNumber = $_POST['vehicleID'];


$sql = "SELECT * FROM tblVehicle WHERE tblVehicle.ID = '" . $vehicleNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);


echo json_encode($row);

?>
