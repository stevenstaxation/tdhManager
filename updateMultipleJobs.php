<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobID = $_POST['jobs'];
$jobTypeID = $_POST['jobTypeID'];
$jobCameraID = $_POST['cameraTypeID'];
$jobBookedDate = $_POST['bookedDate'];
$jobBookedTime = $_POST['bookedTime'];
$jobAppendNote = $_POST['appendNote'];
$jobAppendNote = addslashes($jobAppendNote);
$jobEngineerID = $_POST['jobEngineerID'];
$changeAddress = $_POST['changeAddress'];
$timePeriod = $_POST['timePeriod'];

$updateJobType = ($jobTypeID != '0');
$updateCameraType = ($jobCameraID != '0');
$updateBookedDate = ($jobBookedDate != '');
$updateBookedTime = ($jobBookedTime != '');
$updateBookedPeriod = ($timePeriod > 0);
$updateAppendNote = ($jobAppendNote != '');
$updateAddress = ($changeAddress != '');
$updateEngineer = ($jobEngineerID != '0');

foreach ($jobID as $job) {
    $jobBookedDate = $_POST['bookedDate'];
    $updateBookedDate = ($jobBookedDate != '');

    $sqlGet = "SELECT date FROM tblJobs WHERE ID='" .$job ."'";
    $resGet = mysqli_query($link, $sqlGet);
    $resDate = mysqli_fetch_array($resGet);
    if (!$resDate['date']) {
        $resDate['date'] = "1970-01-01T00:00:00";
    }
    
    $sql = "UPDATE tblJobs SET ";


    if ($updateBookedDate && !$updateBookedTime) {
        $jobBookedDate = $jobBookedDate . "T" . substr($resDate['date'],-8);
    } elseif ($updateBookedDate && $updateBookedTime) {
        $jobBookedDate = $jobBookedDate . "T" . $jobBookedTime . ":00";
    } elseif (!$updateBookedDate && $updateBookedTime) {
        $jobBookedDate = substr($resDate['date'],0,10) . "T" . $jobBookedTime .":00";
        $updateBookedDate = true;
    } 

    if ($updateBookedPeriod) {
        $jobBookedDate = substr($resDate['date'],0,10) . "T00:00:00";
        $updateBookedDate = true;
    }

    if ($updateJobType) {
        $sql .= "jobType = '" . $jobTypeID . "',";
    }
    if ($updateCameraType) {
        $sql .= "cameraTypeID = '" . $jobCameraID . "',";
    }
    if ($updateAppendNote) {
        $sql .= "notes = CONCAT(notes,' ', '" . $jobAppendNote . "'),";
    }
    if ($updateAddress) {
        $sql .= "bookingAddress = '" . $changeAddress . "',";
    }
    if ($updateEngineer) {
        $sql .= "engineerID = '" . $jobEngineerID . "',";
    }
    
    $sql .= "timePeriod = '" . $timePeriod . "',";
   
    if ($updateBookedDate) {
        $sql .= "date = '" . $jobBookedDate . "',";
    }
    
    
    $sql = substr($sql, 0, strlen($sql) - 1);

    $sql .= " WHERE ID = '" . $job . "'";
    
    $result = mysqli_query($link, $sql);
}
