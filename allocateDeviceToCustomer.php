<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$allocateToCustomer = $_POST['allocateCustomer'];
$allocateToVRN = $_POST['allocateVRN'];
$allocateDevice = $_POST['allocateDevice'];

if ($allocateToVRN == 0) {
    $allocateToVRN = null;
} 

$sql = "SELECT VCOReference FROM tblCustomer WHERE tblCustomer.ID = '$allocateToCustomer'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$VCOReference = $row['VCOReference'];

$sql = "UPDATE tblDevice SET ownerID='$allocateToCustomer', vehicleID=NULLIF('$allocateToVRN','') WHERE tblDevice.ID = '$allocateDevice'";

$result = mysqli_query($link, $sql); 

if (!$result) {
    
    echo 'Could not allocate device';
} else {
    echo 'success';
}




?>

