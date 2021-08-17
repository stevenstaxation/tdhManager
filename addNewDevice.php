<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$deviceTypeID = $_POST['deviceID'];
$deviceTDHNumber = $_POST['TDHNumber'];
$deviceSerialNumber = $_POST['serialNumber'];
$deviceIMEI = $_POST['IMEI'];
$deviceDRID = $_POST['DRID'];
$deviceSIMNumber = $_POST['SIMNumber'];
$deviceSIMPhone = $_POST['SIMPhone'];
$deviceSIMStatusID = $_POST['SIMStatus'];
$deviceSIMDeactDate = $_POST['SIMDeactDate'];
$deviceOwnerID = $_POST['ownerID'];
$deviceVRN = str_replace(" ","",$_POST['VRN']);
$deviceConfigFile = $_POST['configFile'];
$deviceCurrentStatus = $_POST['currentStatus'];
$deviceInstallerID = $_POST['installerID'];
$deviceInstallDate = $_POST['installDate'];
$deviceInstallerRef = $_POST['installerRef'];
$deviceSupplierID = $_POST['supplierID'];
$deviceSupplierRef = $_POST['supplierRef'];
$devicePurchaseDate = $_POST['purchaseDate'];
$deviceNotes = $_POST['notesText'];


$errors = "";

if ($deviceIMEI) {
    if (strlen($deviceIMEI)!=15) {
        $errors .= 'IMEI should be 15 digits long';
    }
}


if (!$deviceSIMDeactDate || $deviceSIMDeactDate='') {
    $deviceSIMDeactDate = NULL;
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$deviceTDHNumber = mysqli_real_escape_string($link,filter_var($deviceTDHNumber, FILTER_SANITIZE_STRING));
$deviceSerialNumber = mysqli_real_escape_string($link,filter_var($deviceSerialNumber, FILTER_SANITIZE_STRING));
$deviceIMEI = mysqli_real_escape_string($link,filter_var($deviceIMEI, FILTER_SANITIZE_STRING));
$deviceDRID = mysqli_real_escape_string($link,filter_var($deviceDRID, FILTER_SANITIZE_STRING));
$deviceSIMNumber = mysqli_real_escape_string($link,filter_var($deviceSIMNumber, FILTER_SANITIZE_STRING));
$deviceSIMPhone = mysqli_real_escape_string($link,filter_var($deviceSIMPhone, FILTER_SANITIZE_STRING));
$deviceVRN = mysqli_real_escape_string($link,filter_var(strtoupper($deviceVRN), FILTER_SANITIZE_STRING));
$deviceConfigFile = mysqli_real_escape_string($link,filter_var($deviceConfigFile, FILTER_SANITIZE_STRING));
$deviceInstallerRef = mysqli_real_escape_string($link,filter_var($deviceInstallerRef, FILTER_SANITIZE_STRING));
$deviceSupplierRef = mysqli_real_escape_string($link,filter_var($deviceSupplierRef, FILTER_SANITIZE_STRING));
$deviceNotes = mysqli_real_escape_string($link,filter_var($deviceNotes, FILTER_SANITIZE_STRING));


// get the customer ID
$sql = "SELECT ID FROM tblCustomer WHERE businessName='$deviceOwnerID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$customerID = $row['ID'];


// insert a new vehicle first (or check if it already exists)
// look up vehicle info with screen scrape?
$sql = "SELECT * FROM tblVehicle WHERE regNumber = '$deviceVRN'";
$result = mysqli_query($link, $sql);
$deviceVehicleID = 0;

if (mysqli_num_rows($result)!=0) {
    // vehicle already exists
    $row = mysqli_fetch_array($result);
    $deviceVehicleID = $row['ID'];
} else {
    // new vehicle so we need to add it to the database
    
    $sql = "INSERT INTO tblVehicle (regNumber, ownerID, vehicleStatus) VALUES ('$deviceVRN', '$customerID','2')";

    $result = mysqli_query($link, $sql);

    $deviceVehicleID = $link->insert_id;

}


$sql = "INSERT INTO tblDevice (ownerID, isCamera, deviceDescriptionID, TDHNumber, serialNumber, IMEI, DRIDNumber, SIMNumber, SIMPhone, SIMStatus, SIMDeactivationDate,
  config, cameraUsedFor, vehicleID, status, installerID, installDate, assocOrderNumber, supplierID, supplierInvoice, purchaseDate, deviceNote)
  VALUES ('$customerID', '1','$deviceTypeID', NULLIF('$deviceTDHNumber',''), '$deviceSerialNumber', '$deviceIMEI', '$deviceDRID','$deviceSIMNumber', '$deviceSIMPhone','$deviceSIMStatusID',
  NULLIF('$deviceSIMDeactDate', ''),'$deviceConfigFile','$customerID', '$deviceVehicleID', '$deviceCurrentStatus', NULLIF('$deviceInstallerID',''), NULLIF('$deviceInstallDate',''),
  '$deviceInstallerRef', NULLIF('$deviceSupplierID',''), '$deviceSupplierRef', NULLIF('$devicePurchaseDate',''), '$deviceNotes')";

$result = mysqli_query($link, $sql);

$lastID = $customerID;

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "UPDATE tblVehicle SET installDate = NULLIF('$deviceInstallDate','') WHERE ID='$deviceVehicleID'";
$result = mysqli_query($link, $sql);



echo $lastID . "success";

?>
