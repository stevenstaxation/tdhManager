<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobID = $_POST['jobID'];
$jobStatus = $_POST['jobStatus'];

if ($jobStatus == 'allowUpdate') {

    $sql = "UPDATE tblJobs SET status = '1' WHERE ID = '$jobID'";

} else {
    $jobDate = $_POST['jobDate'];
    $jobType = $_POST['jobType'];
    $jobVRN = $_POST['jobVRN'];
    $jobNotes = $_POST['jobNotes'];
    if ($jobStatus == 'updateOnly') {
        $sql = "UPDATE tblJobs SET date = '$jobDate', jobType='$jobType', VRN='$jobVRN', notes='$jobNotes' WHERE ID='$jobID'";
    } else if ($jobStatus == 'allowEdit') {
        $sql = "UPDATE tblJobs SET date = '$jobDate', jobType='$jobType', VRN='$jobVRN', notes='$jobNotes', status='0' WHERE ID='$jobID'";
    }
}

$result = mysqli_query($link, $sql);

echo $jobStatus;


?>