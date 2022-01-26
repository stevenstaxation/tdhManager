<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$regNumber = $_POST['regNumber'];
$vehicleID = $_POST['vehicleID'];
$required = $_POST['required'];
$vehicleStatus = $_POST['vehicleStatus'];
$installDate = $_POST['installDate'];
$vehicleNotes = $_POST['vehicleNotes'];
$LTAlarmDate = $_POST['LTAlarmDate']; 
$SideScanDate = $_POST['SideScanDate']; 
$errors = "";

if ($regNumber == '' || $regNumber == NULL) {
  $errors .= 'You must include a VRN to identify the vehicle';
}

$regNumber = strtoupper($regNumber);
$regNumber = str_replace(' ','',$regNumber);

if ($required=='true') {
  $required = '1';
} else {
  $required = '0';
}

// if ($required=='1' && $vehicleStatus>0) {
//   if (!$installDate) {
//     $errors .="You should enter an installation date";
//   }
// }

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}





$sql = "UPDATE tblVehicle SET cameraRequired='$required', vehicleNotes='$vehicleNotes', installDate=NULLIF('$installDate',''), vehicleStatus='$vehicleStatus',
regNumber='$regNumber', LTAlarmDate=NULLIF('$LTAlarmDate',''), SideScanDate=NULLIF('$SideScanDate','') WHERE ID = '$vehicleID'";


$result = mysqli_query($link, $sql);

  $sql = "SELECT ownerID FROM tblVehicle WHERE ID = '$vehicleID'";
  $getOwnerQuery = mysqli_query($link, $sql);
  $getOwner = mysqli_fetch_array($getOwnerQuery);

  echo "success" . $getOwner['ownerID'];

?>
