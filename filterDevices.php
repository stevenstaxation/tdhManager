<?php
session_start();
include ('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$filterCustomer = false;
$filterType = false;
$filterOtherTerm = false;

$customerToFilter = $_POST['FilterCustomer'];
$TypeToFilter = $_POST['FilterType'];
$OtherTermToFilter = $_POST['FilterOtherTerm'];


if ($customerToFilter!=0 && $customerToFilter !=NULL) {
  $filterCustomer = true;
}
if ($TypeToFilter!=0 && $TypeToFilter !=NULL) {
  $filterType = true;
}
if ($OtherTermToFilter!='' && $OtherTermToFilter !=NULL) {
  $filterOtherTerm = true;
}

$OtherTermToFilter = mysqli_real_escape_string($link, $OtherTermToFilter);

$sqlFilter = " WHERE ";

if ($filterCustomer) {
  $sqlFilter .= "tblDevice.ownerID='$customerToFilter' AND ";
}
if ($filterType) {
  $sqlFilter .= "tblDevice.deviceDescriptionID='$TypeToFilter' AND ";
}
if ($filterOtherTerm) {
  $sqlFilter .= "(tblDevice.TDHNumber LIKE '%$OtherTermToFilter%' OR tblDevice.serialNumber LIKE '%$OtherTermToFilter%' ";
  $sqlFilter .= "OR tblDevice.serialNumber LIKE '%$OtherTermToFilter%' OR tblDevice.IMEI LIKE '%$OtherTermToFilter%' ";
  $sqlFilter .= "OR tblDevice.DRIDNumber LIKE '%$OtherTermToFilter%' OR tblDevice.SIMNumber LIKE '%$OtherTermToFilter%' ";
  $sqlFilter .= "OR tblDevice.SIMPhone LIKE '%$OtherTermToFilter%' OR tblDevice.config LIKE '%$OtherTermToFilter%' ";
  $sqlFilter .= "OR tblSIMStatus.SIMStatus LIKE '%$OtherTermToFilter%' OR tblVehicle.regNumber LIKE '%$OtherTermToFilter%' ";
  $sqlFilter .= "OR tblInstaller.installerName LIKE '%$OtherTermToFilter%')";
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

