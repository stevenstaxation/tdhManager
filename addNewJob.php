<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$jobCustomerID = $_POST['jobCustomerName']; //
$jobType = $_POST['jobJobType']; //
$jobCameraType = $_POST['jobCameraType'];
$jobQuantity = $_POST['jobQuantity'];
$jobOtherKitLT = $_POST['jobLT'];
$jobOtherKitSS = $_POST['jobSS'];
$jobPriority = $_POST['jobPriority'];
$jobRate = $_POST['jobRate'];
$jobNotes = $_POST['jobNotes'];
$jobContactName = $_POST['jobContactName'];
$jobContactEmail = $_POST['jobContactEmail'];
$jobContactPhone = $_POST['jobContactPhone'];
$jobContactAddress = $_POST['jobInstallAddress'];
$jobEquipmentLocation = $_POST['bookingLocation'];
$jobEngineer = $_POST['engineerAssigned'];
$jobDate = $_POST['jobDateBooked'];
// $jobDate = new DateTime($_POST['jobDateBooked']); //
// $jobDate = $jobDate->format('d/m/Y');
$jobVRN = $_POST['VRN'];
$jobOldVRN = $_POST['OldVRN'];


$errors = "";

// must select customer
if (!$jobCustomerID >=1) {
    $errors .="You must select the customer<br>";
}

if (!$jobType >=1) {
    $errors .="You must select a job type<br>";
}

if (!$jobCameraType >=1) {
    $errors .="You must choose the device type<br>";
}

if ($jobQuantity<1 || $jobQuantity>9) {
    $errors .="Job quantity must be between 1 and 9<br>";
}
if ($jobRate =='' || $jobRate==null) {
    $errors .="The job rate should be entered, if unknown enter 0.00<br>";
}

if ($jobContactName=='' || $jobContactName==null) {
    $errors .="Contact name is missing<br>";
}
if ($jobContactEmail =='' && $jobContactPhone=='') {
    $errors .="You should enter at least one contact method, email or telephone - preferably both<br>";
}
if ($jobContactAddress =='' || $jobContactAddress==null) {
    $errors .="A contact address should be included<br>";
}
if (!$jobEquipmentLocation>=1) {
    $errors .="Current location of equipment is missing<br>";
}
if (!$jobEngineer>=1) {
    $errors .="Please select the assigned engineer<br>";
}
// if ($jobDate==null || $jobDate=='') {
//     $errors .="The date booked for the job is missing<br>";
// }
$ix = 1;
foreach ($jobVRN as $VRN) {
    if ($VRN==0 || $VRN=null) {
        $errors .= "Vehicle registration number " .$ix ." is missing<br>";
    }
    $ix++;
}

$otherKitFlag = 0;
if ($jobOtherKitLT == 'on') {
    $otherKitFlag = $otherKitFlag | 1;
}
if ($jobOtherKitSS == 'on') {
    $otherKitFlag = $otherKitFlag | 2;
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$ix = 0;
foreach ($jobVRN as $VRNforJob) {
    $oldVRN = $jobOldVRN[$ix];
    $time = date('Y-m-d');
    $sql = "INSERT INTO tblJobs (ownerID, date, jobType, VRN, notes, cameratypeid, Quantity, OtherKitFlag, PriorityIsUrgent, JobRate, BookingContact, BookingEmail, BookingTelephone, BookingAddress, EquipmentLocationID, EngineerID, dateAdded, oldVRN) VALUES ('$jobCustomerID',NULLIF('$jobDate',''), '$jobType', '$VRNforJob', '$jobNotes', '$jobCameraType', '$jobQuantity', '$otherKitFlag', '$jobPriority', '$jobRate', '$jobContactName', '$jobContactEmail', '$jobContactPhone', '$jobContactAddress', '$jobEquipmentLocation', '$jobEngineer', '$time', NULLIF('$oldVRN',''))";
    $result = mysqli_query($link, $sql);
    $ix++;
}



$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('New Job added', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$lastID = $_SESSION['currentCustomer'];

//   if (!$result) {
//         echo '<div class="alert alert-danger">Error updating insurer</div>';
//         echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
//         exit();
//     }

echo $lastID . "success";

?>
