<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobCustomer = $_POST['jobCustomer'];
$jobID = $_POST['jobID'];
$jobInfo = [];

$sql = "SELECT * FROM tblJobs WHERE ID='$jobID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);


echo (json_encode($row));


// VRNS
// $sql = "SELECT ID, regNumber FROM tblVehicle WHERE ownerID='" . $jobCustomer . "'";
// $result = mysqli_query($link, $sql);


// $jobCustomerVRN = [];
// $jobCustomerVRNID = [];

// while ($row = mysqli_fetch_assoc($result)) {
//     array_push($jobCustomerVRNID, $row['ID']);    
//     array_push($jobCustomerVRN, $row['regNumber']);
// }

// $jobInfo['VRN'] = $jobCustomerVRN;
// $jobInfo['VRNID'] = $jobCustomerVRNID;

// // GET SELECTED VRN
// $sql = "SELECT VRN FROM tblJobs WHERE ID= '" . $jobID . "'";
// $result = mysqli_query($link, $sql);
// $row = mysqli_fetch_assoc($result);

// $jobInfo['selectedVehicle'] = $row['VRN'];

// $sql = "SELECT * FROM tblJobs WHERE ID='" . $jobID . "'";
// $result = mysqli_query($link, $sql);
// $row = mysqli_fetch_assoc($result);

// $jobInfo['date'] = $row['date'];
// $jobInfo['jobType'] = $row['jobType'];
// $jobInfo['notes'] = $row['notes'];
// $jobInfo['status'] = $row['status'];


//  echo(json_encode($jobInfo));

?>
