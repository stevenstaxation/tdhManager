<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$footageNumber = $_POST['footageID'];


$sql = "SELECT * FROM tblFootageRequest INNER JOIN tblVehicle ON tblVehicle.ID = tblFootageRequest.vehicleID INNER JOIN tblCustomer ON tblCustomer.ID = tblFootageRequest.ownerID WHERE tblFootageRequest.ID = '" . $footageNumber . "'";
$result = mysqli_query($link, $sql);


$row = mysqli_fetch_array($result, MYSQLI_ASSOC);



 echo json_encode($row);


?>
