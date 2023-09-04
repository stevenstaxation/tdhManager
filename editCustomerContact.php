<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$contactNumber = $_POST['contactID'];


$sql = "SELECT * FROM tblCustomerContact WHERE ID = '" . $contactNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);

echo $row['businessID'] . "^^^";
echo $row['firstName'] . "^^^";
echo $row['lastName'] . "^^^";
echo $row['mobileNo'] . "^^^";
echo $row['telephone'] . "^^^";
echo $row['email'] . "^^^";
echo $row['jobTitle'] . "^^^";
echo $row['isFootageRecipient'] . "^^^";
echo $row['isHealthCheck'] . "^^^";
echo $row['isReporting'] . "^^^";
echo $contactNumber . "^^^";


?>
