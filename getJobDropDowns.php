<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobCustomer = $_POST['jobCustomer'];
$jobID = $_POST['jobID'];
$jobInfo = [];

$sql = "SELECT * FROM tblJobs WHERE ID='$jobID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);


echo (json_encode($row));




?>
