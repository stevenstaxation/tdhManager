<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$customerRenewalType = $_POST['customerRenewalType'];
$customerRenewalDate = $_POST['customerRenewalDate'];
$customerNumber = $_SESSION['currentCustomer'];

$errors = "";



$sql = "UPDATE tblCustomer SET renewalType='$customerRenewalType', renewalDate = NULLIF('$customerRenewalDate','') WHERE ID = '$customerNumber'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Customer $customerName was updated', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    


echo $customerNumber . "success";

?>


