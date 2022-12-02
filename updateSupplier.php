<?php
session_start();
include('connect.php');
require_once('checkPostcode.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$supplierName = $_POST['supplierName'];
$supplierAddress1 = $_POST['supplierAddress1'];
$supplierAddress2 = $_POST['supplierAddress2'];
$supplierAddress3 = $_POST['supplierAddress3'];
$supplierAddress4 = $_POST['supplierAddress4'];
$supplierAddress5 = $_POST['supplierAddress5'];
$supplierID = $_POST['supplierID'];

$errors = "";

// rules
// Max lengths are taken care of in the HTML /
// Name and 4 address lines need no additional check /
// Address 5 must be a valid postcode or empty
// Empty is allowed for all but supplier name

if (strlen($supplierName)==0) {
    $errors .= "You must enter a supplier name<br>";
}

if (!(checkPostcode($supplierAddress5)) && $supplierAddress5 != "") {
    $errors .= "Postcode is not valid<br>";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$supplierName = mysqli_real_escape_string($link,filter_var($supplierName, FILTER_SANITIZE_STRING));
$supplierAddress1 = mysqli_real_escape_string($link,filter_var($supplierAddress1, FILTER_SANITIZE_STRING));
$supplierAddress2 = mysqli_real_escape_string($link,filter_var($supplierAddress2, FILTER_SANITIZE_STRING));
$supplierAddress3 = mysqli_real_escape_string($link,filter_var($supplierAddress3, FILTER_SANITIZE_STRING));
$supplierAddress4 = mysqli_real_escape_string($link,filter_var($supplierAddress4, FILTER_SANITIZE_STRING));
$supplierAddress5 = mysqli_real_escape_string($link,filter_var(strtoupper($supplierAddress5), FILTER_SANITIZE_STRING));

// before update
$sql = "SELECT * FROM tblSupplier WHERE ID = '$supplierID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblSupplier SET supplierName='$supplierName', supplierAddress1 = '$supplierAddress1', supplierAddress2 = '$supplierAddress2', supplierAddress3 = '$supplierAddress3', supplierAddress4 = '$supplierAddress4', supplierAddress5 = '$supplierAddress5' WHERE ID = '$supplierID'";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo '<div class="alert alert-danger">Error accessing the database</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

// after update
$sql = "SELECT * FROM tblSupplier WHERE ID = '$supplierID'";
$updated = mysqli_fetch_assoc(mysqli_query($link, $sql));

// get changes
$updatedColumns = array_diff_assoc($updated, $prev);

// parse changes
$description="Supplier " . $supplierName . " record was edited - " ;
foreach ($updatedColumns as $column=>$value) {
    $description .= $column . " was changed to " .$value .", ";
}
$description = substr($description,0,strlen($description)-2);

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);

   

echo "success";

?>
