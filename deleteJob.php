<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobID = $_POST['jobID'];


$sql = "SELECT tblJobs.ID, tblCustomer.businessName, tblJobType.description, tblVehicle.regNumber, tblJobs.regPicFilename, tblJobs.regPicDeviceDetails, tblJobs.dateAdded FROM tblJobs INNER JOIN tblCustomer ON tblJobs.ownerID = tblCustomer.ID
INNER JOIN tblJobType ON tblJobs.jobType = tblJobType.ID INNER JOIN tblVehicle ON tblJobs.VRN = tblVehicle.ID WHERE tblJobs.ID='$jobID'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);

echo($sql);


if (!isset($row['regPicFilename'])) {
    unlink($row['regPicFilename']);
}

if ($row['regPicDeviceDetails']!= NULL) {
    unlink ($row['regPicDeviceDetails']);    
}


$sql = "DELETE FROM tblJobs WHERE ID='$jobID'";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error deleting job </div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('" . $row['description'] . " job for " . $row['businessName'] . " (" . $row['regNumber'] .") added on " . date('d/m/Y', strtotime($row['dateAdded'])) . " was deleted' , '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    

if ($result) {
    echo 'success';
}



?>

