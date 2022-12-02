<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updateHealthcheckTypeID = $_POST['HealthcheckTypeIDToUpdate'];
$updateHealthcheckTypeName = $_POST['HealthcheckTypeNameToUpdate'];

$errors='';


if (!$updateHealthcheckTypeName || $updateHealthcheckTypeName=='') {
    $errors .="Healthcheck description cannot be empty";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updateHealthcheckTypeName = mysqli_real_escape_string($link,filter_var($updateHealthcheckTypeName, FILTER_SANITIZE_STRING));

// get old status name
$sql = "SELECT Description FROM tblHealthStatus WHERE ID='$updateHealthcheckTypeID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblHealthStatus SET Description = '$updateHealthcheckTypeName' WHERE ID='$updateHealthcheckTypeID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating healthcheck status description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$description = "Healthcheck status description " . $prev['Description'] . " was changed to " . $updateHealthcheckTypeName;

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";



?>
