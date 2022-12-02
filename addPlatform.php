<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newPlatformName = $_POST['PlatformNameToAdd'];

$errors = '';

if (!$newPlatformName || $newPlatformName == '') {
    $errors .= "You must enter the platform description";
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newPlatformName = mysqli_real_escape_string($link, filter_var($newPlatformName, FILTER_SANITIZE_STRING));

$sql = "INSERT INTO tblPlatform (Name) VALUES('$newPlatformName')";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating platform description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Platform $newPlatformName was created', '" . $_SESSION['userID'] . "')";
$result = mysqli_query($link, $sql);

echo "success";
