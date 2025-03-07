<?php
session_start();
include('connect.php');

$dismissID = $_POST['dismissID'];
$sql = "UPDATE tblJobs SET isAlertable='0' WHERE tblJobs.ID = '" . $dismissID ."'";

$result = mysqli_query($link, $sql);

?>