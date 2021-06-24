<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$installerID = $_POST['installerID'];

$sql = "SELECT installerName FROM tblInstaller WHERE ID='$installerID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$installerName = $row['installerName'];

// delete contacts
$sql = "DELETE FROM tblInstallerContact WHERE installerID='$installerID'";
$result = mysqli_query($link, $sql);

// reassign any devices
$sql = "UPDATE tblDevice SET installerID='0' WHERE installerID='$installerID'";
$result = mysqli_query($link, $sql);

// delete the installer
$sql = "DELETE FROM tblInstaller WHERE ID = '$installerID'";



$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database  </div>' . $sql;

        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Installer $installerName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);

echo "success";


?>

