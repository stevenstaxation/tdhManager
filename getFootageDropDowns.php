<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$footageCustomer = $_POST['footageCustomer'];
$footageID = $_POST['footageID'];
$footageInfo = [];

// VRNS
$sql = "SELECT ID, regNumber FROM tblVehicle WHERE ownerID='" . $footageCustomer . "'";
$result = mysqli_query($link, $sql);


$footageCustomerVRN = [];
$footageCustomerVRNID = [];

while ($row = mysqli_fetch_assoc($result)) {
    array_push($footageCustomerVRNID, $row['ID']);    
    array_push($footageCustomerVRN, $row['regNumber']);
}

$footageInfo['VRN'] = $footageCustomerVRN;
$footageInfo['VRNID'] = $footageCustomerVRNID;

// GET SELECTED VRN
$sql = "SELECT vehicleID FROM tblFootageRequest WHERE ID= '" . $footageID . "'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);

$footageInfo['selectedVehicle'] = $row['vehicleID'];


// CONTACTS
$footageContactName = [];
$footageContactEmail = [];
$footageContactType = [];
$footageContactSent = [];

$sql = "SELECT tblFootageRecipient.footageID, tblFootageRecipient.recipientType, tblFootageRecipient.recipientID, 
tblFootageRecipient.emailWasSent, tblCustomerContact.firstName, tblCustomerContact.lastName, tblCustomerContact.email  
FROM tblFootageRecipient INNER JOIN tblCustomerContact ON tblCustomerContact.ID = tblFootageRecipient.recipientID 
WHERE footageID= '" . $footageID . "' AND recipientType='1'";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {

    array_push($footageContactName, $row['firstName'] . " " . $row['lastName'] );
    array_push($footageContactEmail, $row['email']);
    array_push($footageContactType, 'Customer' );
    array_push($footageContactSent, $row['emailWasSent']);      
}

$sql = "SELECT tblFootageRecipient.footageID, tblFootageRecipient.recipientType, tblFootageRecipient.recipientID, 
tblFootageRecipient.emailWasSent, tblInsurerContact.firstName, tblInsurerContact.lastName, tblInsurerContact.email  
FROM tblFootageRecipient INNER JOIN tblInsurerContact ON tblInsurerContact.ID = tblFootageRecipient.recipientID 
WHERE footageID= '" . $footageID . "' AND recipientType='2'";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    array_push($footageContactName, $row['firstName'] . " " . $row['lastName'] );
    array_push($footageContactEmail, $row['email']);
    array_push($footageContactType, 'Insurer' );
    array_push($footageContactSent, $row['emailWasSent']);      
}

$sql = "SELECT tblFootageRecipient.footageID, tblFootageRecipient.recipientType, tblFootageRecipient.recipientID, 
tblFootageRecipient.emailWasSent, tblBrokerContact.firstName, tblBrokerContact.lastName, tblBrokerContact.email  
FROM tblFootageRecipient INNER JOIN tblBrokerContact ON tblBrokerContact.ID = tblFootageRecipient.recipientID 
WHERE footageID= '" . $footageID . "' AND recipientType='3'";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    array_push($footageContactName, $row['firstName'] . " " . $row['lastName'] );
    array_push($footageContactEmail, $row['email']);
    array_push($footageContactType, 'Broker' );
    array_push($footageContactSent, $row['emailWasSent']);      
}

$footageInfo['footageContactName'] = $footageContactName;
$footageInfo['footageContactEmail'] = $footageContactEmail;
$footageInfo['footageContactType'] = $footageContactType;
$footageInfo['footageContactSent'] = $footageContactSent;


// FOOTAGE FILES
$sql = "SELECT filePathName FROM tblFootageFiles WHERE requestID= '" . $footageID . "'";
$result = mysqli_query($link, $sql);

$footageCustomerFilePath = [];

while ($row = mysqli_fetch_assoc($result)) {
    array_push($footageCustomerFilePath, $row['filePathName']);    
}

$footageInfo['filePath'] = $footageCustomerFilePath;








 echo(json_encode($footageInfo));

?>
