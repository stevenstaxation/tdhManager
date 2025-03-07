<?php
session_start();
include '../../connect.php';
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$regNumber = $_POST['regNumber'];
// $make = $_POST['make'];
// $model = $_POST['model'];
// $addDescription = $_POST['addDescription'];
$cameraRequired = $_POST['required'];
if ($cameraRequired == 'true') {
    $cameraRequired = 1;
} else {
    $cameraRequired = 0;
}
$installationStatus = $_POST['installation'];
$installationDate = $_POST['installationDate'];
$vehicleNotes = $_POST['vehicleNotes'];
$LTAlarmDate = $_POST['LTAlarmDate'];
$SideSensorDate = $_POST['SSSensorDate'];

$customerID = $_SESSION['currentCustomer'];
$dateAdded = date("Y-m-d");

$errors = "";

// must include reg number
if (!$regNumber || $regNumber == '') {
    $errors .= "<p>You should enter the vehicle registration number</p>";
}

// VRN should have no spaces and be upper case
$regNumber = strtoupper($regNumber);
$regNumber = str_replace(" ", '', $regNumber);

// does the vehicle already exist?
if ($regNumber != 'TBC' && $regNumber != '') {
    $sql = "SELECT tblVehicle.regNumber, tblCustomer.businessName FROM tblVehicle LEFT JOIN tblCustomer ON tblCustomer.ID=tblVehicle.ownerID WHERE regNumber='$regNumber'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo "<div class='alert alert-danger'>That registration already exists and is allocated to " . $row['businessName'] . "</div>";
        exit();
    }
}

// if installation is not applicable or camera required = no, we do not need an install date
// if ($installationStatus !='not applicable' && $cameraRequired) {
//     if (!$installationDate) {
//         $errors .="<p>You should enter the install date</p>";
//     }
// }

if ($errors) {
    echo "<div class='alert alert-danger'>" . $errors . "</div>";
    exit();
}

if ($installationStatus == 'installed') {
    $vehicleStatus = 2;
} else if ($installationStatus == 'pending') {
    $vehicleStatus = 1;
} else {
    $vehicleStatus = 0;
}

$sql = "INSERT INTO tblVehicle (regNumber, ownerID, vehicleStatus, installDate, vehicleNotes, cameraRequired, LTAlarmDate, SideScanDate, dateAdded) VALUES ( '$regNumber', '$customerID', '$vehicleStatus', NULLIF('$installationDate',''), '$vehicleNotes', '$cameraRequired', NULLIF('$LTAlarmDate',''), NULLIF('$SideSensorDate',''), '$dateAdded')";

$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error adding vehicle</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('New vehicle $regNumber added', '" . $_SESSION['userID'] . "')";
$result = mysqli_query($link, $sql);

echo "success";
