<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$deviceNumber = $_POST['deviceID'];


$sql = "SELECT deviceNote FROM tblDevice WHERE tblDevice.ID = '" . $deviceNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);



 echo json_encode($row);

?>
