<?php
session_start();
include ('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$filterCustomer = false;
$filterInsurer = false;
$filterVRN = false;
$filterTDHNumber = false;

$customerToFilter = $_POST['FilterCustomer'];
$insurerToFilter = $_POST['FilterInsurer'];
$VRNToFilter = $_POST['FilterVRN'];
// $TDHNumberToFilter = $_POST['FilterTDHNumber'];


if ($customerToFilter!=0 && $customerToFilter !=NULL) {
  $filterCustomer = true;
}
if ($insurerToFilter!=0 && $insurerToFilter !=NULL) {
  $filterInsurer = true;
}
if ($VRNToFilter!='' && $VRNToFilter !=NULL) {
  $filterVRN = true;
}
// if ($TDHNumberToFilter!='' && $TDHNumberToFilter !=NULL) {
//   $filterTDHNumber = true;
// }

$VRNToFilter = filter_var($VRNToFilter, FILTER_SANITIZE_STRING);
// $TDHNumberToFilter = filter_var($TDHNumberToFilter, FILTER_SANITIZE_STRING);

$VRNToFilter = mysqli_real_escape_string($link, $VRNToFilter);
// $TDHNumberToFilter = mysqli_real_escape_string($link, $TDHNumberToFilter);

$sqlFilter = " WHERE ";

if ($filterCustomer) {
  $sqlFilter .= "tblVehicle.ownerID='$customerToFilter' AND ";
}
if ($filterInsurer) {
  $sqlFilter .= "tblCustomer.insurerID='$insurerToFilter' AND ";
}
if ($filterVRN && $filterVRN!="") {
  $sqlFilter .= "(tblVehicle.regNumber LIKE '%$VRNToFilter%' OR tblVehicle.make LIKE '%$VRNToFilter%' OR tblVehicle.model LIKE '%$VRNToFilter%' OR tblVehicle.addDescription LIKE '%$VRNToFilter%')";
}

// no filter required
if ($sqlFilter == ' WHERE ') {
  $sqlFilter = '';
  echo $sqlFilter;
  exit();
}

// remove last AND if applicable
if (substr($sqlFilter,-5)==' AND ') {
    $sqlFilter = substr($sqlFilter,0,-5);
}



echo $sqlFilter;


?>


