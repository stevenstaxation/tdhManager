<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$regNumber = $_POST['regNumber'];
$make = $_POST['make'];
$model = $_POST['model'];
$addDescription = $_POST['addDescription'];
$vehicleID = $_POST['vehicleID'];

$errors = "";

if ($regNumber == '' || $regNumber == NULL) {
  $errors = 'You must include a VRN to identify the vehicle';
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}





$sql = "UPDATE tblVehicle SET make='$make', model='$model', addDescription='$addDescription',
regNumber='$regNumber' WHERE ID = '$vehicleID'";


$result = mysqli_query($link, $sql);

echo "success";


?>
