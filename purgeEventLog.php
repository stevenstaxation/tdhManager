<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$today = date('Y-m-d G:i');
$oldDate = -$_POST['daysToAdd'] . " days";
$dateAdd = date('Y-m-d G:i', strtotime($oldDate));

$sql = "DELETE FROM tblEventLog WHERE TimeStamp < '$dateAdd'";
$result = mysqli_query($link, $sql);


?>