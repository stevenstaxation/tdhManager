<?php
session_start();
include('connect.php');
require_once('checkPostcode.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$installerName = $_POST['installerName'];
$installerAddress1 = $_POST['installerAddress1'];
$installerAddress2 = $_POST['installerAddress2'];
$installerAddress3 = $_POST['installerAddress3'];
$installerAddress4 = $_POST['installerAddress4'];
$installerAddress5 = $_POST['installerAddress5'];
$installerID = $_POST['installerID'];

$errors = "";

// rules
// Max lengths are taken care of in the HTML /
// Name and 4 address lines need no additional check /
// Address 5 must be a valid postcode or empty
// Empty is allowed for all but installer name

if (strlen($installerName)==0) {
    $errors .= "You must enter an installer name<br>";
}

if (!(checkPostcode($installerAddress5)) && $installerAddress5 != "") {
    $errors .= "Postcode is not valid<br>";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$installerName = mysqli_real_escape_string($link,filter_var($installerName, FILTER_SANITIZE_STRING));
$installerAddress1 = mysqli_real_escape_string($link,filter_var($installerAddress1, FILTER_SANITIZE_STRING));
$installerAddress2 = mysqli_real_escape_string($link,filter_var($installerAddress2, FILTER_SANITIZE_STRING));
$installerAddress3 = mysqli_real_escape_string($link,filter_var($installerAddress3, FILTER_SANITIZE_STRING));
$installerAddress4 = mysqli_real_escape_string($link,filter_var($installerAddress4, FILTER_SANITIZE_STRING));
$installerAddress5 = mysqli_real_escape_string($link,filter_var(strtoupper($installerAddress5), FILTER_SANITIZE_STRING));

// before update
$sql = "SELECT * FROM tblInstaller  WHERE ID = '$installerID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblInstaller SET installerName='$installerName', installerAddress1 = '$installerAddress1', installerAddress2 = '$installerAddress2', installerAddress3 = '$installerAddress3', installerAddress4 = '$installerAddress4', installerAddress5 = '$installerAddress5' WHERE ID = '$installerID'";
$result = mysqli_query($link, $sql);

// after update
$sql = "SELECT * FROM tblInstaller WHERE ID = '$installerID'";
$updated = mysqli_fetch_assoc(mysqli_query($link, $sql));

// get changes
$updatedColumns = array_diff_assoc($updated, $prev);

// parse changes
$description="Installer " . $installerName . " record was edited - " ;
foreach ($updatedColumns as $column=>$value) {
    $description .= $column . " was changed to " .$value .", ";
}
$description = substr($description,0,strlen($description)-2);


$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

echo "success";

?>
