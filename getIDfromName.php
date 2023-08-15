<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}
$customerName = $_POST['customerName'];

$sql = "SELECT ID FROM tblcustomer WHERE tblcustomer.businessName='" . $customerName . "'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

echo $row['ID'];

?>