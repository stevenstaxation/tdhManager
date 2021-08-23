<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sql = "SELECT ID FROM tblCustomer WHERE tblCustomer.businessName = 'DHD'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);

echo $row['ID'];



?>
