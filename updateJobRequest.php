<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobID = $_POST['jobID'];
$LTAlarm = $_POST['LTAlarm'];
$SSSensor = $_POST['SideSensor'];
$TDHSignOff = $_POST['TDHSignOff'];
$cameraType = $_POST['cameraType'];
$customerID = $_POST['customerID'];
$jobCompleted = $_POST['jobCompleted'];
$jobContact =  mysqli_real_escape_string($link, $_POST['jobContact']);
$jobDateBooked = $_POST['jobDateBooked'];
$jobEmail =  mysqli_real_escape_string($link, $_POST['jobEmail']);
$jobEngineer = $_POST['jobEngineer'];
$jobInstallAddress = mysqli_real_escape_string($link, $_POST['jobInstallAddress']);
$jobLocation = $_POST['jobLocation'];
$jobNotes = mysqli_real_escape_string($link, $_POST['jobNotes']);
$jobNotes = addslashes($jobNotes);
$jobPhone =  mysqli_real_escape_string($link, $_POST['jobPhone']);
$jobPriority = $_POST['jobPriority'];
$jobRate =  mysqli_real_escape_string($link, $_POST['jobRate']);
$customerJobRate =  mysqli_real_escape_string($link, $_POST['jobCustomerRate']);
$jobInvoiced = $_POST['jobInvoiced'];
$monthlyInvoice = $_POST['monthlyInvoice'];
$invoiceApproved = $_POST['invoiceApproved'];

if ($jobInvoiced == "N/A") {
    $jobIsInvoiced = 2;
} else if ($jobInvoiced == "YES") {
    $jobIsInvoiced = 1;
} else {
    $jobIsInvoiced = 0;
}
if ($monthlyInvoice == "N/A") {
    $monthlyIsInvoiced = 2;
} else if ($monthlyInvoice == "YES") {
    $monthlyIsInvoiced = 1;
} else {
    $monthlyIsInvoiced = 0;
}
if ($invoiceApproved == "N/A") {
    $invoiceIsApproved = 2;
} else if ($invoiceApproved == "YES") {
    $invoiceIsApproved = 1;
} else {
    $invoiceIsApproved = 0;
}



$jobStatus = $_POST['jobStatus'];
$jobType = $_POST['jobType'];
$jobVRN = $_POST['jobVRN'];
$oldVRN = $_POST['oldVRN'];
if (isset($_POST['picReg'])) {
    $picRegistration = $_POST['picReg'];
} else {
    $picRegistration = NULL;
}

if (isset($_POST['picDevice'])) {
    $picDevice = $_POST['picDevice'];
} else {
    $picDevice = NULL;
}

if ($LTAlarm=='true') {$LTAlarm = 1;} else {$LTAlarm=0;};
if ($SSSensor=='true') {$SSSensor = 2;} else {$SSSensor=0;};


$otherKitFlag = 0 | $LTAlarm;
$otherKitFlag = $otherKitFlag | $SSSensor;

if ($jobCompleted=='true') {
    $jobComplete = 1;
} else {
    $jobComplete = 0;
}

if ($TDHSignOff=='true') {
    $jobTDHComplete = 1;
} else {
    $jobTDHComplete = 0;
}


$errors="";

if ($jobRate==null || $jobRate=='') {
    $errors .= "Engineer job rate is missing<br>";
}
if ($customerJobRate==null || $customerJobRate=='') {
    $errors .= "Customer job rate is missing<br>";
}
if ($jobContact==null || $jobContact=='') {
    $errors .= "Please enter a contact name<br>";
}
if (($jobEmail ==null || $jobEmail=='') && ($jobPhone ==null || $jobPhone=='') ) {
    $errors .= "You should enter a contact email or phone number<br>";
}
if ($jobInstallAddress==null || $jobInstallAddress=='' ) {
    $errors .= "Installation address must be entered<br>";
}

if ($errors !="") {
    echo "<div class='alert alert-danger>" . $errors . "</div>";
}

$sql = "SELECT regPicFilename, regPicDeviceDetails FROM tblJobs WHERE tblJobs.ID='$jobID'";
$result = mysqli_query($link, $sql);
$pics = mysqli_fetch_array($result);

if ($pics['regPicFilename'] != $picRegistration) {
    unlink ($pics['regPicFilename']);
}
if ($pics['regPicDeviceDetails'] != $picDevice) {
    unlink ($pics['regPicDeviceDetails']);
}


$sql = "UPDATE tblJobs SET ownerID='$customerID', date=NULLIF('$jobDateBooked',''), jobType='$jobType', VRN='$jobVRN', notes='$jobNotes', 
status='$jobStatus', cameratypeid='$cameraType', OtherKitFlag='$otherKitFlag', PriorityIsUrgent='$jobPriority', JobRate='$jobRate', customerRate = '$customerJobRate',
BookingContact='$jobContact', BookingEmail='$jobEmail', BookingTelephone='$jobPhone', BookingAddress='$jobInstallAddress', 
EquipmentLocationID='$jobLocation', EngineerID=NULLIF('$jobEngineer',''), JobCompleteFlag='$jobComplete', TDHSignOff='$jobTDHComplete', regPicFilename=NULLIF('$picRegistration',''), regPicDeviceDetails=NULLIF('$picDevice',''), oldVRN=NULLIF('$oldVRN',''), jobInvoiced = '$jobIsInvoiced', monthlyInvoice='$monthlyIsInvoiced', approvedPayment='$invoiceIsApproved'  WHERE tblJobs.ID='$jobID'";

$result = mysqli_query($link, $sql);

if ($result) {
    echo 'success';
} else {
    echo "Could not update database " . $sql;

}



?>
