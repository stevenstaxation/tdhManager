<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$installerNumber = $_POST['installerNumber'];
$sql = "SELECT installerName FROM tblInstaller WHERE ID='$installerNumber'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$installerName = $row['installerName'];

$sql = "SELECT tblDevice.ID FROM tblDevice WHERE installerID='$installerNumber'";
$result = mysqli_query($link, $sql);
$affectedRows =  mysqli_num_rows($result);
$returnString = "<div class='alert alert-danger'>";

// installer assigned to devices?
if ($affectedRows>0) {
    if ($affectedRows>1) {
        $returnString .= "$installerName is set as the installer for $affectedRows devices. Each device will have their installer reallocated as 'None selected'.<br>";
    } elseif (mysqli_num_rows($result)==1) {
        $returnString .= "$installerName is set as the installer for $affectedRows device.  The installer will be reallocated as 'None selected'.<br>";
    }
}

//installer has contacts attached?
$sql = "SELECT ID FROM tblInstallerContact WHERE installerID='$installerNumber'";
$result = mysqli_query($link, $sql);
$anyContacts =  mysqli_num_rows($result);
    if ($anyContacts>1) {
        $returnString .= "There are $anyContacts contacts attached to $installerName. These contacts will be lost if you continue with the deletion.";
    } elseif ($anyContacts==1) {
        $returnString .= "There is $anyContacts contacts attached to $installerName. The contact will be lost if you continue with the deletion.";
    }

if ($returnString !="<div class='alert alert-danger'>") {
    $returnString .= "<br><input type='radio' name='deleteOption' id='goAheadDeleteInstaller' style='margin: 10px'>Continue with delete
    <br><input type='radio' name='deleteOption' id='cancelDelete' style='margin: 10px' checked>Cancel
    <btn class='btn btn-danger btn-sm' style='margin-left: 50px' id='queryDeleteInstaller'>Go</btn>
    <div id='hiddenIDToDelete' style='display: none'>" . $installerNumber . "</div>";
    echo "<div class='alert alert-danger'>" . $returnString . "</div>";
    exit();
}







if ($affectedRows==0) {
    $sql = "DELETE FROM tblInstaller WHERE tblInstaller.ID = '$installerNumber'";
    $result = mysqli_query($link, $sql);
    echo "<div class='alert alert-success'>$installerName has been deleted.</div>";
    
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Installer $installerName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);
    
    exit();
}

$returnString .= "</div>";


echo $returnString;







?>