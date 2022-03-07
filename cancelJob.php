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



// set job to cancelled status
 $sql = "UPDATE tblJobs SET status='32' WHERE ID='" . $jobToCancel ."'";
 $result = mysqli_query($link, $sql);

// now duplicate the row
$sql = "SET SQL_SAFE_UPDATES = 0; ";
$result = mysqli_query($link, $sql);
$sql = "DROP TEMPORARY TABLE IF EXISTS temp1; ";
$result = mysqli_query($link, $sql);
$sql = "CREATE TEMPORARY TABLE temp1 SELECT * FROM tblJobs WHERE ID='" . $jobToCancel ."'; ";
$result = mysqli_query($link, $sql);
$sql = "ALTER TABLE temp1 CHANGE ID ID INT; ";
$result = mysqli_query($link, $sql);
$sql = "UPDATE temp1 SET ID = NULL; ";
$result = mysqli_query($link, $sql);
$sql = "INSERT INTO tblJobs SELECT * FROM temp1";
$result = mysqli_query($link, $sql);
$lastRecord = mysqli_insert_id($link);

$sql = "DROP TEMPORARY TABLE IF EXISTS temp1; ";
$result = mysqli_query($link, $sql);
$sql .= "SET SQL_SAFE_UPDATES = 1";
$result = mysqli_query($link, $sql);

$sql = "UPDATE tblJobs SET date=null WHERE ID='" . $lastRecord ."'";
$result = mysqli_query($link, $sql);
$sql = "UPDATE tblJobs SET notes = CONCAT(notes, '
PREVIOUS JOB CANCELLED
NEED TO CHARGE A CANCELLATION CHARGE TO CUSTOMER') WHERE ID='" . $lastRecord ."'";
$result = mysqli_query($link, $sql);
$sql = "UPDATE tblJobs SET status='1' WHERE ID='" . $lastRecord ."'";
$result = mysqli_query($link, $sql);


?>