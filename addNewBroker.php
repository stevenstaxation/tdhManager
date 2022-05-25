<?php
session_start();
include('connect.php');
require_once ('checkPostcode.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


/**
 * Check contents of Add New Broker modal are valid when Add button is clickecd and add to tblBroker in database
 * @author Lee Stevens
 * @copyright The Data Analysis Hub Ltd
 * 
 */

$newBrokerName = $_POST['BrokerName'];
$newBrokerAddress1 = $_POST['BrokerAddress1'];
$newBrokerAddress2 = $_POST['BrokerAddress2'];
$newBrokerAddress3 = $_POST['BrokerAddress3'];
$newBrokerAddress4 = $_POST['BrokerAddress4'];
$newBrokerAddress5 = $_POST['BrokerAddress5'];

$errors = "";

if (!$newBrokerName) {
    $errors .="You must include the Broker name<br>";
}

if (!(checkPostcode($newBrokerAddress5)) && $newBrokerAddress5 != "") {
    $errors .= "Postcode is not valid<br>";
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newBrokerName = mysqli_real_escape_string($link,filter_var($newBrokerName, FILTER_SANITIZE_STRING));
$newBrokerAddress1 = mysqli_real_escape_string($link,filter_var($newBrokerAddress1, FILTER_SANITIZE_STRING));
$newBrokerAddress2 = mysqli_real_escape_string($link,filter_var($newBrokerAddress2, FILTER_SANITIZE_STRING));
$newBrokerAddress3 = mysqli_real_escape_string($link,filter_var($newBrokerAddress3, FILTER_SANITIZE_STRING));
$newBrokerAddress4 = mysqli_real_escape_string($link,filter_var($newBrokerAddress4, FILTER_SANITIZE_STRING));
$newBrokerAddress5 = mysqli_real_escape_string($link,filter_var(strtoupper($newBrokerAddress5), FILTER_SANITIZE_STRING));

$sql = "INSERT INTO tblBroker (brokerName, addressLine1, addressLine2, addressLine3, addressLine4, addressLine5) VALUES ('$newBrokerName','$newBrokerAddress1', '$newBrokerAddress2', '$newBrokerAddress3', '$newBrokerAddress4', '$newBrokerAddress5')";

$result = mysqli_query($link, $sql);

$lastBrokerID = $link->insert_id;

if (!$result) {
    echo '<div class="alert alert-danger">Error accessing the database</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}


// record in event log
$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Broker $newBrokerName was created', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);

// return customerID and new brokerID
$lastID = $_SESSION['currentCustomer'];
echo $lastID . "/" . $lastBrokerID. "success";

?>
