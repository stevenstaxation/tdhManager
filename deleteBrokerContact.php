<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sql = "SELECT tblBrokerContact.firstName, tblBrokerContact.lastName, tblBroker.brokerName FROM tblBrokerContact INNER JOIN tblBroker ON tblBroker.ID = tblBrokerContact.brokerID WHERE tblBrokerContact.ID = '" . $_POST['contactNumber'] ."'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$brokerName = $row['brokerName'];
$contactName = $row['firstName']. " " . $row['lastName'];

$sql = "DELETE FROM tblBrokerContact WHERE tblBrokerContact.ID = '" . $_POST['contactNumber'] ."'";
$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Broker contact $contactName was deleted from $brokerName', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql); 

echo "success";


?>
