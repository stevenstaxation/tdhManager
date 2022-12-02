<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$vehicleID = $_POST['vehicleID'];
$vehicleNote = $_POST['vehicleNote'];
$vehicleNote = addslashes($vehicleNote);

$errors = "";


$sql = "UPDATE tblVehicle SET vehicleNotes='$vehicleNote' WHERE ID = '$vehicleID'";


$result = mysqli_query($link, $sql);

echo "success";


?>