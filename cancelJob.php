<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobToCancel = $_POST['jobID'];



$sql = "SELECT status FROM tblJobs WHERE ID='" . $jobToCancel ."'";
$result =  mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

// can't delete as job is awaiting approval / completed
if (intval($row['status'])>=8) {
    echo 'complete' . $row['status'];
    exit();
}




$sql = "UPDATE tblJobs SET status='32' WHERE ID='" . $jobToCancel ."'";

$result = mysqli_query($link, $sql);


?>