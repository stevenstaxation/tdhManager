<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$sql = "SELECT ownerID FROM tblJobs WHERE ID = " . $_POST['jobID'];
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);

echo $row['ownerID'];


?>

