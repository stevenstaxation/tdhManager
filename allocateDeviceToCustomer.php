<?php
session_start();
include('connect.php');


$allocateToCustomer = $_POST['allocateCustomer'];
$allocateToVRN = $_POST['allocateVRN'];
$allocateDevice = $_POST['allocateDevice'];

if ($allocateToVRN == 0) {
    $allocateToVRN = null;
} 

$sql = "UPDATE tblDevice SET ownerID='$allocateToCustomer', vehicleID=NULLIF('$allocateToVRN','') WHERE tblDevice.ID = '$allocateDevice'";

$result = mysqli_query($link, $sql); 

if (!$result) {
    
    echo 'Could not allocate device';
} else {
    echo 'success';
}




?>

