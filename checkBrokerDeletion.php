<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$brokerNumber = $_POST['brokerNumber'];
$sql = "SELECT brokerName FROM tblBroker WHERE ID='$brokerNumber'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$brokerName = $row['brokerName'];

$sql = "SELECT tblCustomer.ID, tblCustomer.businessName, tblBroker.brokerName FROM tblCustomer INNER JOIN tblBroker ON tblBroker.ID=tblCustomer.brokerID WHERE brokerID='$brokerNumber'";
$result = mysqli_query($link, $sql);
$affectedRows =  mysqli_num_rows($result);
$returnString = "<div class='alert alert-danger'>";

// broker assigned to customners?
if ($affectedRows>0) {
    if ($affectedRows>1) {
        $returnString .= "There are $affectedRows customers who are assigned to $brokerName. Each customer will have their broker reallocated as 'None selected'";
    } elseif (mysqli_num_rows($result)==1) {
        $returnString .= "There is $affectedRows customer who is assigned to $brokerName.  The broker will be reallocated as 'None selected'<br>";
    }
}

//broker has contacts attached?
$sql = "SELECT ID FROM tblBrokerContact WHERE brokerID='$brokerNumber'";
$result = mysqli_query($link, $sql);
$anyContacts =  mysqli_num_rows($result);
    if ($anyContacts>1) {
        $returnString .= "There are $anyContacts contacts attached to $brokerName. These contacts will be lost if you continue with the deletion.";
    } elseif ($anyContacts==1) {
        $returnString .= "There is $anyContacts contacts attached to $brokerName. The contact will be lost if you continue with the deletion.";
    }

if ($returnString !="<div class='alert alert-danger'>") {
    $returnString .= "<br><input type='radio' name='deleteOption' id='goAheadDeleteBroker' style='margin: 10px'>Continue with delete
    <br><input type='radio' name='deleteOption' id='cancelDelete' style='margin: 10px' checked>Cancel
    <btn class='btn btn-danger btn-sm' style='margin-left: 50px' id='queryDeleteBroker'>Go</btn>
    <div id='hiddenIDToDelete' style='display: none'>" . $brokerNumber . "</div>";
    echo "<div class='alert alert-danger'>" . $returnString . "</div>";
    exit();
}







if ($affectedRows==0) {
    $sql = "DELETE FROM tblBroker WHERE tblBroker.ID = '$brokerNumber'";
    $result = mysqli_query($link, $sql);
    echo "<div class='alert alert-success'>$brokerName has been deleted.</div>";

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Broker $brokerName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);
    
    exit();
}

$returnString .= "</div>";


echo $returnString;







?>