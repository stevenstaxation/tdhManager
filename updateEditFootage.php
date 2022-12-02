<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$footageID = $_POST['footageID'];
$ownerID = $_POST['ownerID'];
$incidentDate = $_POST['incidentDate'];
$vehicleID = $_POST['vehicleID'];
$claimReference = $_POST['claimReference'];
$requestDate = $_POST['requestDate'];
$requestNotes = $_POST['requestNotes'];
$requestNotes = addslashes($requestNotes);
$responseDate = $_POST['responseDate'];
$allocatedTo = $_POST['allocatedTo'];
$responseNotes = $_POST['responseNotes'];
$responseNotes = addslashes($responseNotes);
$requestStatus = $_POST['requestStatus'];
$fileNames =$_POST['fileNames'];

$errors = "";

if ($incidentDate=='') {
    $errors .= "You must include the incident date and time";
}
if ($requestDate=='') {
    $errors .= "You must include the request date and time";
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}



$sql = "UPDATE tblFootageRequest SET ownerID='$ownerID', requestDateTime='$requestDate', incidentDate='$incidentDate', vehicleID='$vehicleID',
claimRef='$claimReference', responseDateTime=NULLIF('$responseDate',''), responseText='$responseNotes', userID='$allocatedTo', statusID='$requestStatus', requestNotes='$requestNotes' WHERE ID = '$footageID'";


$result = mysqli_query($link, $sql);


$sql = 'INSERT INTO tblFootageFiles (filePathName, requestID)) VALUES ($filePathName, $footageID)';



echo "success";


?>
