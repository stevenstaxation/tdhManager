<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$insurerNumber = $_POST['insurerNumber'];
$sql = "SELECT insurerName FROM tblInsurer WHERE ID='$insurerNumber'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$insurerName = $row['insurerName'];

$sql = "SELECT tblCustomer.ID, tblCustomer.businessName, tblInsurer.insurerName FROM tblCustomer INNER JOIN tblInsurer ON tblInsurer.ID=tblCustomer.insurerID WHERE insurerID='$insurerNumber'";
$result = mysqli_query($link, $sql);
$affectedRows =  mysqli_num_rows($result);
$returnString = "<div class='alert alert-danger'>";

// insurer assigned to customners?
if ($affectedRows>0) {
    if ($affectedRows>1) {
        $returnString .= "There are $affectedRows customers who are assigned to $insurerName. Each customer will have their insurer reallocated as 'None selected'";
    } elseif (mysqli_num_rows($result)==1) {
        $returnString .= "There is $affectedRows customer who is assigned to $insurerName.  The insurer will be reallocated as 'None selected'<br>";
    }
}

//insurer has contacts attached?
$sql = "SELECT ID FROM tblInsurerContact WHERE insurerID='$insurerNumber'";
$result = mysqli_query($link, $sql);
$anyContacts =  mysqli_num_rows($result);
    if ($anyContacts>1) {
        $returnString .= "There are $anyContacts contacts attached to $insurerName. These contacts will be lost if you continue with the deletion.";
    } elseif ($anyContacts==1) {
        $returnString .= "There is $anyContacts contacts attached to $insurerName. The contact will be lost if you continue with the deletion.";
    }

if ($returnString !="<div class='alert alert-danger'>") {
    $returnString .= "<br><input type='radio' name='deleteOption' id='goAheadDeleteInsurer' style='margin: 10px'>Continue with delete
    <br><input type='radio' name='deleteOption' id='cancelDelete' style='margin: 10px' checked>Cancel
    <btn class='btn btn-danger btn-sm' style='margin-left: 50px' id='queryDeleteInsurer'>Go</btn>
    <div id='hiddenIDToDelete' class='d-none'>" . $insurerNumber . "</div>";
    echo "<div class='alert alert-danger'>" . $returnString . "</div>";
    exit();
}


if ($affectedRows==0) {
    $sql = "DELETE FROM tblInsurer WHERE tblInsurer.ID = '$insurerNumber'";
    $result = mysqli_query($link, $sql);
    echo "<div class='alert alert-success'>$insurerName has been deleted.</div>";

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Insurer $insurerName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);
    
    exit();
}

$returnString .= "</div>";


echo $returnString;







?>