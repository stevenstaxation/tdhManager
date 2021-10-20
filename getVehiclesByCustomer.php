<?php
session_start();
include('connect.php');

$selectedCustomer = $_POST['customerSelected'];

$returnString = "";

$sql = "SELECT ID,regNumber FROM tblVehicle WHERE tblVehicle.ownerID = '" . $selectedCustomer. "' ORDER BY regNumber ASC";
$result = mysqli_query($link,$sql);

while ($VRNRow = mysqli_fetch_array($result)) {
    $returnString .=  "<option value = '" . $VRNRow['ID'] . "'>" . $VRNRow['regNumber'] . "</option>";
  
}

echo $returnString;

?>
