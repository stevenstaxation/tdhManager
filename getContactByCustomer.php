<?php
session_start();
include('connect.php');

$selectedCustomer = $_POST['customerSelected'];

$returnString = "";

$sql = "SELECT firstName, lastName, mobileNo, telephone, email FROM tblCustomerContact WHERE businessID = '" . $selectedCustomer. "' LIMIT 1";
$result = mysqli_query($link,$sql);
$contactRow = mysqli_fetch_array($result);


echo (json_encode($contactRow));

?>
