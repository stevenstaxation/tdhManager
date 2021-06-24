<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$footageInfo = [];
$footageCustomer = $_POST['customerID'];

// if there are no devices you cannot add a footage request
$sql = "SELECT * FROM tblDevice WHERE ownerID='$footageCustomer'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result)==0) {
    echo (json_encode('nodevices'));
    exit();
}

// CUSTOMER NAME
$sql = "SELECT businessName FROM tblCustomer WHERE tblCustomer.ID='" . $footageCustomer . "'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$footageInfo['customerName'] = $row['businessName'];

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

// CONTACTS
$sql = "SELECT email, firstName, lastName FROM tblCustomerContact WHERE businessID = '" . $footageCustomer . "'";
$result = mysqli_query($link, $sql);

$footageCustomerContactEmail = [];
$footageCustomerContactFullName = [];

while ($row = mysqli_fetch_assoc($result)) {
   
    array_push($footageCustomerContactEmail, $row['email']);
    array_push($footageCustomerContactFullName, $row['firstName'] .  ' ' . $row['lastName']);
    
}

$footageInfo['customerContactsEmail'] = $footageCustomerContactEmail;
$footageInfo['customerContactsFullName'] = $footageCustomerContactFullName;


// INSURER CONTACTS
$sql = "SELECT email, firstName, lastName FROM tblInsurerContact WHERE insurerID = (SELECT tblCustomer.insurerID FROM tblCustomer WHERE tblCustomer.ID = '"  . $footageCustomer . "')";
$result = mysqli_query($link, $sql);

$footageInsurerContactEmail = [];
$footageInsurerContactFullName = [];

while ($row = mysqli_fetch_assoc($result)) {
    array_push($footageInsurerContactEmail, $row['email']);
    array_push($footageInsurerContactFullName, $row['firstName'] . ' ' . $row['lastName']);
}

$footageInfo['insurerContactsEmail'] = $footageInsurerContactEmail;
$footageInfo['insurerContactsFullName'] = $footageInsurerContactFullName;


// BROKER CONTACTS
$sql = "SELECT email, firstName, lastName FROM tblBrokerContact WHERE brokerID = (SELECT tblCustomer.brokerID FROM tblCustomer WHERE tblCustomer.ID = '"  . $footageCustomer . "')";
$result = mysqli_query($link, $sql);

$footageBrokerContactEmail = [];
$footageBrokerContactFullName = [];

while ($row = mysqli_fetch_assoc($result)) {
    array_push($footageBrokerContactEmail, $row['email']);
    array_push($footageBrokerContactFullName, $row['firstName'] . ' ' . $row['lastName']);
}

$footageInfo['brokerContactsEmail'] = $footageBrokerContactEmail;
$footageInfo['brokerContactsFullName'] = $footageBrokerContactFullName;









 echo(json_encode($footageInfo));

?>
