<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$contactNumber = $_POST['brokerNumber'];


$sql = "SELECT * FROM tblBroker WHERE ID = '" . $contactNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);




echo $row['brokerName'] . "^^^";
echo $row['addressLine1'] . "^^^";
echo $row['addressLine2'] . "^^^";
echo $row['addressLine3'] . "^^^";
echo $row['addressLine4'] . "^^^";
echo $row['addressLine5'] . "^^^";
echo $contactNumber . "^^^";

?>
