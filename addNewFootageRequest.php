<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$incidentDateTime = $_POST['footageIncidentDate'];
$incidentVRNID = $_POST['getFootageVRN'];
$incidentCustomerID = $_POST['footageCustomerID'];
$incidentClaimReference = $_POST['footageClaimReference'];
$footageDateTime = $_POST['footageRequestDate'];
$footageNotes = $_POST['footageRequestNotes'];
$responseDateTime = $_POST['footageResponseDate'];
$responseEmployee = $_POST['footageTDHEmployee'];
$responseNotes = $_POST['footageResponseNotes'];
$responseStatus = $_POST['footageCurrentStatus'];
$ListOfFiles = explode(',', $_POST['fileList']);
$ListOfContacts = explode(',', $_POST['contactList']);

$errors = "";

if (!$incidentDateTime) {
    $errors = "Incident date and time is missing<br>";
}
if (!$footageDateTime) {
    $errors .= "Date and time of footage request is missing<br>";
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$incidentClaimReference = mysqli_real_escape_string($link,filter_var($incidentClaimReference, FILTER_SANITIZE_STRING));
$footageNotes = mysqli_real_escape_string($link,filter_var($footageNotes, FILTER_SANITIZE_STRING));
$responseNotes = mysqli_real_escape_string($link,filter_var($responseNotes, FILTER_SANITIZE_STRING));

// get the customer ID
$sql = "SELECT ID FROM tblCustomer WHERE businessName='$incidentCustomerID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$customerID = $row['ID'];

$sql = "INSERT INTO tblFootageRequest (ownerID, requestDateTime, incidentDate, vehicleID, claimRef, responseDateTime, responseText, userID, statusID, requestNotes)
  VALUES ('$customerID', '$footageDateTime','$incidentDateTime', '$incidentVRNID', NULLIF('$incidentClaimReference',''), NULLIF('$responseDateTime',''), '$responseNotes','$responseEmployee', '$responseStatus','$footageNotes')";

$result = mysqli_query($link, $sql);
if (!$result) {
    echo '<div class="alert alert-danger">Error accessing the database 1</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}
$footageID = mysqli_insert_id($link);

$lastID = $customerID;

// now insert the files
foreach($ListOfFiles as $fileName) {
    if ($fileName!='') {
        $blob = "uploads/" . $fileName;
        $sql = "INSERT INTO tblFootageFiles (filePathName, requestID, footageFilePath) VALUES ('$fileName', '$footageID','$blob')";
        $result = mysqli_query($link, $sql);
    }
}
if (!$result) {
    echo '<div class="alert alert-danger">Error accessing the database 2</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

// now insert the recipients
for ($x = 0; $x < count($ListOfContacts); $x=$x+4) {
    $contactName = explode(" ", $ListOfContacts[$x]);
    $contactEmail = $ListOfContacts[$x+1];
    $contactType = $ListOfContacts[$x+2];
    $contactSent = $ListOfContacts[$x+3];
    
    if ($contactSent=='checked') {
        $contactSent = 1;
    } else {
        $contactSent = 0;
    }

    //get the contact ID by type
    if ($contactType=='Customer') {
        $sql = "SELECT ID FROM tblCustomerContact WHERE firstName='$contactName[0]' && lastName='$contactName[1]' && email= '$contactEmail'";
        $result=mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $sql = "INSERT INTO tblFootageRecipient (footageID, recipientType, recipientID, emailWasSent) VALUES ('$footageID', '1', '" . $row['ID'] ."', '$contactSent')";
        $result=mysqli_query($link, $sql);
    } elseif ($contactType=='Insurer') {
        $sql = "SELECT ID FROM tblInsurerContact WHERE firstName='$contactName[0]' && lastName='$contactName[1]' && email= '$contactEmail'";
        $result=mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $sql = "INSERT INTO tblFootageRecipient (footageID, recipientType, recipientID, emailWasSent) VALUES ('$footageID', '2', '" . $row['ID'] ."', '$contactSent')";
        $result=mysqli_query($link, $sql);
    } elseif ($contactType=='Broker') {
        $sql = "SELECT ID FROM tblBrokerContact WHERE firstName='$contactName[0]' && lastName='$contactName[1]' && email= '$contactEmail'";
        $result=mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $sql = "INSERT INTO tblFootageRecipient (footageID, recipientType, recipientID, emailWasSent) VALUES ('$footageID', '3', '" . $row['ID'] ."', '$contactSent')";
        $result=mysqli_query($link, $sql);
    }
}


echo $lastID . "success";

?>
