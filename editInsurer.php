<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$contactNumber = $_POST['insurerNumber'];


$sql = "SELECT * FROM tblInsurer WHERE ID = '" . $contactNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);




echo $row['insurerName'] . "^^^";
echo $row['insurerAddress1'] . "^^^";
echo $row['insurerAddress2'] . "^^^";
echo $row['insurerAddress3'] . "^^^";
echo $row['insurerAddress4'] . "^^^";
echo $row['insurerAddress5'] . "^^^";
echo $contactNumber . "^^^";

?>
