<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$issueNumber = $_POST['issueID'];


$sql = "SELECT * FROM tblIssue WHERE tblIssue.ID = '" . $issueNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);



 echo json_encode($row);


?>
