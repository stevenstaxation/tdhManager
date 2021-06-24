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
  $sqlFilter .= "tblFootageRequest.ownerID='$customerToFilter' AND ";
}
if ($filterType) {
  $sqlFilter .= "tblFootageRequest.vehicleID='$TypeToFilter' AND ";
}
if ($filterOtherTerm) {
  $sqlFilter .= "(tblFootageRequest.claimRef LIKE '%$OtherTermToFilter%' OR tblFootageRequest.responseText LIKE '%$OtherTermToFilter%' ";
  $sqlFilter .= "OR tblFootageRequest.requestDateTime LIKE '%$OtherTermToFilter%' OR tblFootageRequest.incidentDate LIKE '%$OtherTermToFilter%' ";
  $sqlFilter .= "OR tblFootageRequest.responseDateTime LIKE '%$OtherTermToFilter%' OR tblFootageRequest.requestNotes LIKE '%$OtherTermToFilter%' ";
  $sqlFilter .= "OR tblFootageStatus.description LIKE '%$OtherTermToFilter%')";
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

