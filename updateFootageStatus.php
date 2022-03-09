<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updateFootageStatusID = $_POST['FootageStatusIDToUpdate'];
$updateFootageStatusName = $_POST['FootageStatusNameToUpdate'];

$errors='';


if (!$updateFootageStatusName || $updateFootageStatusName=='') {
    $errors .="Footage status description cannot be empty";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updateFootageStatusName = mysqli_real_escape_string($link,filter_var($updateFootageStatusName, FILTER_SANITIZE_STRING));

// get old status name
$sql = "SELECT description FROM tblFootageStatus WHERE ID='$updateFootageStatusID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblFootageStatus SET description = '$updateFootageStatusName' WHERE ID='$updateFootageStatusID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating footage status Description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$description = "Footage status description " . $prev['description'] . " was changed to " . $updateFootageStatusName;

$sql = "INSERT INTO tblEventLog (description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";



?>
