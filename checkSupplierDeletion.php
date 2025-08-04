<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$supplierNumber = $_POST['supplierNumber'];
$sql = "SELECT supplierName FROM tblSupplier WHERE ID='$supplierNumber'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$supplierName = $row['supplierName'];

$sql = "SELECT tblDevice.ID FROM tblDevice WHERE supplierID='$supplierNumber'";
$result = mysqli_query($link, $sql);
$affectedRows =  mysqli_num_rows($result);
$returnString = "<div class='alert alert-danger'>";

// supplier assigned to devices?
if ($affectedRows>0) {
    if ($affectedRows>1) {
        $returnString .= "$supplierName is set as the supplier for $affectedRows devices. Each device will have their supplier reallocated as 'None selected'.<br>";
    } elseif (mysqli_num_rows($result)==1) {
        $returnString .= "$supplierName is set as the supplier for $affectedRows device.  The supplier will be reallocated as 'None selected'.<br>";
    }
}

//supplier has contacts attached?
$sql = "SELECT ID FROM tblSupplierContact WHERE supplierID='$supplierNumber'";
$result = mysqli_query($link, $sql);
$anyContacts =  mysqli_num_rows($result);
    if ($anyContacts>1) {
        $returnString .= "There are $anyContacts contacts attached to $supplierName. These contacts will be lost if you continue with the deletion.";
    } elseif ($anyContacts==1) {
        $returnString .= "There is $anyContacts contact attached to $supplierName. The contact will be lost if you continue with the deletion.";
    }

if ($returnString !="<div class='alert alert-danger'>") {
    $returnString .= "<br><input type='radio' name='deleteOption' id='goAheadDeleteSupplier' style='margin: 10px'>Continue with delete
    <br><input type='radio' name='deleteOption' id='cancelDelete' style='margin: 10px' checked>Cancel
    <btn class='btn btn-danger btn-sm' style='margin-left: 50px' id='queryDeleteSupplier'>Go</btn>
    <div id='hiddenIDToDelete' class='d-none'>" . $supplierNumber . "</div>";
    echo "<div class='alert alert-danger'>" . $returnString . "</div>";
    exit();
}





if ($affectedRows==0) {
    $sql = "DELETE FROM tblSupplier WHERE tblSupplier.ID = '$supplierNumber'";
    $result = mysqli_query($link, $sql);
    echo "<div class='alert alert-success'>$supplierName has been deleted.</div>";
    
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Supplier $supplierName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);
    
    exit();
}

$returnString .= "</div>";


echo $returnString;







?>