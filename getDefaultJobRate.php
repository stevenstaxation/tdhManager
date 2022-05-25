<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$deviceID = $_POST['camera'];
$jobTypeID = $_POST['jobType'];

$sql = "SELECT rate FROM tblJobRates WHERE deviceID='$deviceID' AND jobTypeID='$jobTypeID'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);

echo $row['rate'];


?>