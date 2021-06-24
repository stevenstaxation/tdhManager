<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$VRNToLookup = filter_var($_POST['VRN'], FILTER_SANITIZE_STRING);

$errors = "";

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$VRNToLookup = mysqli_real_escape_string($link,$VRNToLookup);

// is the VRN already in the database?
$sql = "SELECT * FROM tblVehicle WHERE regNumber = '$VRNToLookup'";

$result = mysqli_query($link, $sql);

if ($result) {
    // VRN exists in database
    $row = mysqli_fetch_array($result);
    $returnArray['ID'] = $row['ID'];
    $returnArray['make'] = $row['make'];
    $returnArray['model'] = $row['model'];
    $returnArray['description'] = $row['addDescription'];
    $returnArray['ownerID'] = $row['ownerID'];
}


echo $returnArray;


?>
