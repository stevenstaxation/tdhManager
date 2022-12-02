<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$platformIDToDelete = $_POST['PlatformIDToDelete'];

$sql = "SELECT * FROM tblDevice WHERE platformID='$platformIDToDelete'";
$result = mysqli_query($link, $sql);
$total = mysqli_num_rows($result);

if ($total == 1) {
    $device = " device record.";
} else {
    $device = " device records.";
}

if ($total > 0) {
    echo '<div class="alert alert-danger">Cannot delete this platform description.<br>
    It is attached to ' . $total . $device . '</div>';
    exit();
}

$sql = "SELECT Name FROM tblPlatform WHERE ID='$platformIDToDelete'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

$sql = "DELETE FROM tblPlatform WHERE ID='$platformIDToDelete'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error deleting platform</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Platform " . $row['Name'] . " was deleted', '" . $_SESSION['userID'] . "')";
$result = mysqli_query($link, $sql);

echo "success";
