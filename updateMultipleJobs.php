<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobID = $_POST['jobs'];
$jobTypeID = $_POST['jobTypeID'];
$jobCameraID = $_POST['cameraTypeID'];
$jobBookedDate = $_POST['bookedDate'];
$jobAppendNote = $_POST['appendNote'];
$jobEngineerID = $_POST['jobEngineerID'];

$updateJobType = ($jobTypeID !='0');
$updateCameraType = ($jobCameraID !='0');
$updateBookedDate = ($jobBookedDate !='');
$updateAppendNote = ($jobAppendNote !='');
$updateEngineer = ($jobEngineerID !='0');


foreach($jobID as $job) {
    $sql = "UPDATE tblJobs SET ";

    if ($updateJobType) {
        $sql .="jobType = '" . $jobTypeID ."',";
    }
    if ($updateCameraType) {
        $sql .="cameraTypeID = '" . $jobCameraID ."',";
    }
    if ($updateBookedDate) {
        $sql .="date = '" . $jobBookedDate ."',";
    }
    if ($updateAppendNote) {
        $sql .="notes = CONCAT(notes,' ', '" . $jobAppendNote ."'),";
    }
    if ($updateEngineer) {
        $sql .="engineerID = '" . $jobEngineerID ."',";
    }

    $sql = substr($sql,0,strlen($sql)-1);

    $sql .= " WHERE ID = '" . $job ."'";

   $result = mysqli_query($link, $sql);
}





?>