<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$contactNumber = $_POST['contactID'];


$sql = "SELECT * FROM tblBrokerContact WHERE ID = '" . $contactNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);




echo $row['insurerID'] . "^^^";
echo $row['firstName'] . "^^^";
echo $row['lastName'] . "^^^";
echo $row['mobileNo'] . "^^^";
echo $row['telephone'] . "^^^";
echo $row['email'] . "^^^";
echo $row['department'] . "^^^";
echo $row['isFootageRecipient'] . "^^^";
echo $row['isHealthCheck'] . "^^^";
echo $contactNumber . "^^^";

?>
