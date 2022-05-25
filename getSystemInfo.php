<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

     
$OSplatform = $_SERVER['HTTP_SEC_CH_UA_PLATFORM'];

$sql = "SELECT COUNT(*) FROM tblCustomer";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);
$customers = $row[0];

$sql = "SELECT COUNT(*) FROM tblDevice";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);
$devices = $row[0];

$sql = "SELECT COUNT(*) FROM tblVehicle";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);
$vehicles = $row[0];

$sql = "SELECT COUNT(*) FROM tblJobs WHERE status <=8";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);
$jobsOpen = $row[0];

$sql = "SELECT COUNT(*) FROM tblJobs WHERE status =16";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);
$jobsComplete = $row[0];

$sql = "SELECT COUNT(*) FROM tblFootageRequest";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);
$footages = $row[0];

$sql = "SELECT COUNT(*) FROM tblHealthcheck";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);
$healthchecks = $row[0];


$sysInfo = [$OSplatform, $customers, $devices, $vehicles, $jobsOpen, $jobsComplete, $footages, $healthchecks];

print json_encode($sysInfo);


?>