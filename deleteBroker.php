<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$brokerID = $_POST['brokerID'];

$sql = "SELECT brokerName FROM tblBroker WHERE ID='$brokerID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$brokerName = $row['brokerName'];

// delete contacts
$sql = "DELETE FROM tblBrokerContact WHERE brokerID='$brokerID'";
$result = mysqli_query($link, $sql);

// reassign any customers
$sql = "UPDATE tblCustomer SET brokerID='0' WHERE brokerID='$brokerID'";
$result = mysqli_query($link, $sql);

// delete the broker
$sql = "DELETE FROM tblBroker WHERE ID = '$brokerID'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Broker $brokerName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);

echo "success";


?>

