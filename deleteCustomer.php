<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$customerNumber = $_SESSION['currentCustomer'];

$errors = "";

// get devices allocated to customer
// get vehicles allocated to customer
// return them to function deleteCustomer as arraylist of ID's
// to be inserted into Modal dialog to ask user whether to archive, delete or deallcoate device or vehicle
// removing a device should remove the vehicle attached to it too?
?>