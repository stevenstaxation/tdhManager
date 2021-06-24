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

$sql = "UPDATE tblFootageStatus SET description = '$updateFootageStatusName' WHERE ID='$updateFootageStatusID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating footage status Description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Status $updateFootageStatusName was amended', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";



?>
