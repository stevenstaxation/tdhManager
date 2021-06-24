<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$sql = "SELECT tblInstallerContact.firstName, tblInstallerContact.lastName, tblInstaller.installerName FROM tblInstallerContact INNER JOIN tblInstaller ON tblInstaller.ID = tblInstallerContact.installerID WHERE tblInstallerContact.ID = '" . $_POST['contactNumber'] ."'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$installerName = $row['installerName'];
$contactName = $row['firstName']. " " . $row['lastName'];


$sql = "DELETE FROM tblInstallerContact WHERE tblInstallerContact.ID = '" . $_POST['contactNumber'] ."'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Contact $contactName deleted from $installerName', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql); 

echo "success";


?>
