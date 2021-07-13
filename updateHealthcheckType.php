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
    $errors .="Job type description cannot be empty";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updateHealthcheckTypeName = mysqli_real_escape_string($link,filter_var($updateHealthcheckTypeName, FILTER_SANITIZE_STRING));

$sql = "UPDATE tblHealthStatus SET Description = '$updateHealthcheckTypeName' WHERE ID='$updateHealthcheckTypeID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating healthcheck status description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Healthcheck status $updateHealthcheckTypeName was amended', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";



?>
