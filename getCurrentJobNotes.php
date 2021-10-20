<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobNumber = $_POST['jobID'];


$sql = "SELECT notes FROM tblJobs WHERE tblJobs.ID = '" . $jobNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);



 echo json_encode($row);

?>
