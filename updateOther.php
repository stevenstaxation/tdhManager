<?php
session_start();
include('connect.php');
require_once('checkPostcode.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$otherName = $_POST['otherName'];
$otherAddress1 = $_POST['otherAddress1'];
$otherAddress2 = $_POST['otherAddress2'];
$otherAddress3 = $_POST['otherAddress3'];
$otherAddress4 = $_POST['otherAddress4'];
$otherAddress5 = $_POST['otherAddress5'];
$otherService = $_POST['otherService'];
$otherID = $_POST['otherID'];

$errors = "";

// rules
// Max lengths are taken care of in the HTML /
// Name and 4 address lines need no additional check /
// Address 5 must be a valid postcode or empty
// Empty is allowed for all but supplier name

if (strlen($otherName)==0) {
    $errors .= "You must enter a partner name<br>";
}

if (!(checkPostcode($otherAddress5)) && $otherAddress5 != "") {
    $errors .= "Postcode is not valid<br>";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$otherName = mysqli_real_escape_string($link,filter_var($otherName, FILTER_SANITIZE_STRING));
$otherAddress1 = mysqli_real_escape_string($link,filter_var($otherAddress1, FILTER_SANITIZE_STRING));
$otherAddress2 = mysqli_real_escape_string($link,filter_var($otherAddress2, FILTER_SANITIZE_STRING));
$otherAddress3 = mysqli_real_escape_string($link,filter_var($otherAddress3, FILTER_SANITIZE_STRING));
$otherAddress4 = mysqli_real_escape_string($link,filter_var($otherAddress4, FILTER_SANITIZE_STRING));
$otherAddress5 = mysqli_real_escape_string($link,filter_var(strtoupper($otherAddress5), FILTER_SANITIZE_STRING));
$otherService = mysqli_real_escape_string($link,filter_var($otherService, FILTER_SANITIZE_STRING));


// before update
$sql = "SELECT * FROM tblOther WHERE ID = '$otherID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

//update
$sql = "UPDATE tblOther SET otherName='$otherName', otherAddress1 = '$otherAddress1', otherAddress2 = '$otherAddress2', otherAddress3 = '$otherAddress3', otherAddress4 = '$otherAddress4', otherAddress5 = '$otherAddress5', otherService = '$otherService' WHERE ID = '$otherID'";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo '<div class="alert alert-danger">Error accessing the database</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

// after update
$sql = "SELECT * FROM tblOther WHERE ID = '$otherID'";
$updated = mysqli_fetch_assoc(mysqli_query($link, $sql));

// get changes
$updatedColumns = array_diff_assoc($updated, $prev);

// parse changes
$description="Other partner " . $insurerName . " record was edited - " ;
foreach ($updatedColumns as $column=>$value) {
    $description .= $column . " was changed to " .$value .", ";
}
$description = substr($description,0,strlen($description)-2);

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);

echo "success";

?>
