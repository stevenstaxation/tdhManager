<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updateRenewalTypeID = $_POST['RenewalTypeIDToUpdate'];
$updateRenewalTypeName = $_POST['RenewalTypeNameToUpdate'];

$errors='';


if (!$updateRenewalTypeName || $updateRenewalTypeName=='') {
    $errors .="Renewal type description cannot be empty";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updateRenewalTypeName = mysqli_real_escape_string($link,filter_var($updateRenewalTypeName, FILTER_SANITIZE_STRING));

$sql = "UPDATE tblRenewalType SET Description = '$updateRenewalTypeName' WHERE ID='$updateRenewalTypeID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating renewal type Description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Renewal type $updateRenewalTypeName was amended', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";



?>
