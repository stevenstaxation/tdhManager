<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$contactNumber = $_POST['brokerNumber'];


$sql = "SELECT ID, brokerName, addressLine1, addressLine2, addressLine3, addressLine4, addressLine5
        FROM tblBroker WHERE ID = '" . $contactNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);



echo json_encode($row);


// echo $row['brokerName'] . "^^^";
// echo $row['addressLine1'] . "^^^";
// echo $row['addressLine2'] . "^^^";
// echo $row['addressLine3'] . "^^^";
// echo $row['addressLine4'] . "^^^";
// echo $row['addressLine5'] . "^^^";
// echo $contactNumber . "^^^";

?>
