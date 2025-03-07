<?php
session_start();
include('../../connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$jobCustomerID = $_POST['jobCustomerName']; //
$jobType = $_POST['jobJobType']; //
$jobTypeString =  mysqli_real_escape_string($link, $_POST['jobTypeString']);
$jobCameraType = $_POST['jobCameraType'];
$jobQuantity = $_POST['jobQuantity'];
$jobOtherKitLT = $_POST['jobLT'];
$jobOtherKitSS = $_POST['jobSS'];
// $jobPriority = $_POST['jobPriority'];
$jobRate =  mysqli_real_escape_string($link, $_POST['jobRate']);
$jobCustomerRate =  mysqli_real_escape_string($link, $_POST['jobCustomerRate']);
$jobNotes =  mysqli_real_escape_string($link, $_POST['jobNotes']);
$jobContactName =  mysqli_real_escape_string($link, $_POST['jobContactName']);
$jobContactEmail =  mysqli_real_escape_string($link, $_POST['jobContactEmail']);
$jobContactPhone =  mysqli_real_escape_string($link, $_POST['jobContactPhone']);
$jobContactAddress =  mysqli_real_escape_string($link, $_POST['jobInstallAddress']);
$jobEquipmentLocation = $_POST['bookingLocation'];
$jobEngineer = $_POST['engineerAssigned'];

if($_POST['jobTimeBooked']) {
    $jobTime = $_POST['jobTimeBooked'] .":00";
} else {
    $jobTime = "00:00:00";
};
if ($_POST['jobDateBooked']) {
    $jobDate = $_POST['jobDateBooked'] . "T" . $jobTime;
} else {
    $jobDate = "";
}

$timePeriodName = $_POST['timePeriod'];
$timePeriod = 0;
    switch ($timePeriodName) {
        case "jobTimeAllDay": 
            $timePeriod = 1;
            break;
        case "jobTimeAM": 
            $timePeriod = 2;
            break;
        case "jobTimePM": 
            $timePeriod = 3;
            break;
        default:
            $timePeriod = 0;
    }


// $jobDate = new DateTime($_POST['jobDateBooked']); //
// $jobDate = $jobDate->format('d/m/Y');
$jobVRN = $_POST['VRN'];
// $jobOldVRN = $_POST['OldVRN'];



$errors = "";
$warning = "";

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

if ($jobQuantity<1 || $jobQuantity>50) {
    $errors .="Job quantity must be between 1 and 50<br>";
}
if ($jobRate =='' || $jobRate==null) {
    $errors .="The engineer job rate should be entered, if unknown enter 0.00<br>";
}
if ($jobCustomerRate =='' || $jobRate==null) {
    $errors .="The customer job rate should be entered, if unknown enter 0.00<br>";
}

if ($jobContactName=='' || $jobContactName==null) {
    $errors .="Contact name is missing<br>";
}
if ($jobContactEmail =='' && $jobContactPhone=='') {
    $errors .="You should enter at least one contact method, email or telephone - preferably both<br>";
}

if (($jobContactAddress =='' || $jobContactAddress==null) && ($jobDate!=null && $jobDate!='' && $jobDate!='01/01/1970')) {
    $errors .="A contact address should be included<br>";
}
if (!$jobEquipmentLocation>=1) {
    $errors .="Current location of equipment is missing<br>";
}
if ((!$jobEngineer>=1) && ($jobDate!=null && $jobDate!='' && $jobDate!='01/01/1970')){
    $errors .="Please select the assigned engineer<br>";
}
// if ($jobDate==null || $jobDate=='') {
//     $errors .="The date booked for the job is missing<br>";
// }

$ParsedJobString = strtoupper($jobTypeString);


    // if ($ParsedJobString=="DE-INSTALLATION" || $ParsedJobString=="DEINSTALLATION") {
    //     $ix = 1;
    //     foreach ($jobOldVRN as $key=>$VRN) {
    //         if ($VRN==0 || $VRN=null) {
    //             $_POST['NewVRN']= 'TBC ' . $ix . " (" . date('YmdGis') . ")";
    //             $_POST['customerID']=$jobCustomerID;
    //             include ('addNewRegistration.php');
    //             $jobOldVRN[$key]['value'] = intval($vrString);
    //         }
    //         $ix++;
    //     }     
    // } else {
        $ix = 1;
        foreach ($jobVRN as $key=>$VRN) {
            if ($VRN==0 || $VRN=null) {
                $_POST['NewVRN']= 'TBC ' . $ix  . " (" . date('YmdGis') . ")";
                $_POST['customerID']=$jobCustomerID;
                include ('addNewRegistration.php');
                $jobVRN[$key]['value'] = intval($vrString);
            }
            $ix++;
        }    
    // }


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
    // $oldVRN = $jobOldVRN[$ix];
    $time = date('Y-m-d');
    if ($VRNforJob=='' || $VRNforJob==0) {
        $VRNforJob="TBCx";
    }

    $now = date('U');
    if($jobDate!='') {
        $jobWhen = date('U', strtotime($jobDate));

        if ($now < $jobWhen) {
            $jobStatus = 2;
        } else {
            $jobStatus = 4;
        }
    } else {
        $jobStatus = 1;
    }

$jobDate = str_replace("T"," ",$jobDate);

    $sql = "INSERT INTO tblJobs (ownerID, date, jobType, VRN, notes, cameratypeid, Quantity, OtherKitFlag, PriorityIsUrgent, JobRate, customerRate, BookingContact, BookingEmail, BookingTelephone, BookingAddress, EquipmentLocationID, EngineerID, dateAdded, oldVRN, status, timePeriod) VALUES ('$jobCustomerID',NULLIF('$jobDate',''), '$jobType', '$VRNforJob', '$jobNotes', '$jobCameraType', '$jobQuantity', '$otherKitFlag', '1', '$jobRate', '$jobCustomerRate', '$jobContactName', '$jobContactEmail', '$jobContactPhone', nullif('$jobContactAddress',''), '$jobEquipmentLocation', nullif('$jobEngineer',''), '$time', NULL, '$jobStatus', '$timePeriod')";
 

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


echo $lastID . "success";

?>
