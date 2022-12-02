<?php
session_start();
include('connect.php');
require_once('checkPostcode.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$insurerName = $_POST['insurerName'];
$insurerAddress1 = $_POST['insurerAddress1'];
$insurerAddress2 = $_POST['insurerAddress2'];
$insurerAddress3 = $_POST['insurerAddress3'];
$insurerAddress4 = $_POST['insurerAddress4'];
$insurerAddress5 = $_POST['insurerAddress5'];
$insurerID = $_POST['insurerID'];

$errors = "";

// rules
// Max lengths are taken care of in the HTML /
// Name and 4 address lines need no additional check /
// Address 5 must be a valid postcode or empty
// Empty is allowed for all but insurer name

if (strlen($insurerName)==0) {
    $errors .= "You must enter an insurer name<br>";
}

if (!(checkPostcode($insurerAddress5)) && $insurerAddress5 != "") {
    $errors .= "Postcode is not valid<br>";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$insurerName = mysqli_real_escape_string($link,filter_var($insurerName, FILTER_SANITIZE_STRING));
$insurerAddress1 = mysqli_real_escape_string($link,filter_var($insurerAddress1, FILTER_SANITIZE_STRING));
$insurerAddress2 = mysqli_real_escape_string($link,filter_var($insurerAddress2, FILTER_SANITIZE_STRING));
$insurerAddress3 = mysqli_real_escape_string($link,filter_var($insurerAddress3, FILTER_SANITIZE_STRING));
$insurerAddress4 = mysqli_real_escape_string($link,filter_var($insurerAddress4, FILTER_SANITIZE_STRING));
$insurerAddress5 = mysqli_real_escape_string($link,filter_var(strtoupper($insurerAddress5), FILTER_SANITIZE_STRING));

// before update
$sql = "SELECT * FROM tblInsurer WHERE ID = '$insurerID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblInsurer SET insurerName='$insurerName', insurerAddress1 = '$insurerAddress1', insurerAddress2 = '$insurerAddress2', insurerAddress3 = '$insurerAddress3', insurerAddress4 = '$insurerAddress4', insurerAddress5 = '$insurerAddress5' WHERE ID = '$insurerID'";
$result = mysqli_query($link, $sql);

// after update
$sql = "SELECT * FROM tblInsurer WHERE ID = '$insurerID'";
$updated = mysqli_fetch_assoc(mysqli_query($link, $sql));

// get changes
$updatedColumns = array_diff_assoc($updated, $prev);

// parse changes
$description="Insurer " . $insurerName . " record was edited - " ;
foreach ($updatedColumns as $column=>$value) {
    $description .= $column . " was changed to " .$value .", ";
}
$description = substr($description,0,strlen($description)-2);


$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('" .$description ."', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);

echo "success";

?>
