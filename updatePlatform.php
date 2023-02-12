<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updatePlatformID = $_POST['PlatformIDToUpdate'];
$updatePlatformName = $_POST['PlatformNameToUpdate'];

$errors = '';

if (!$updatePlatformName || $updatePlatformName == '') {
    $errors .= "Platform name cannot be empty";
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updatePlatformName = mysqli_real_escape_string($link, filter_var($updatePlatformName, FILTER_SANITIZE_STRING));

// get old status name
$sql = "SELECT Name FROM tblPlatform WHERE ID='$updatePlatformID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblPlatform SET Name = '$updatePlatformName' WHERE ID='$updatePlatformID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating platform description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$description = "Platform description " . $prev['Name'] . " was changed to " . $updatePlatformName;

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID'] . "')";
$result = mysqli_query($link, $sql);

echo "success";


?>