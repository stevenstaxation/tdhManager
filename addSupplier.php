<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newSupplierName = $_POST['supplierName'];
$newSupplierAddress1 = $_POST['supplierAddress1'];
$newSupplierAddress2 = $_POST['supplierAddress2'];
$newSupplierAddress3 = $_POST['supplierAddress3'];
$newSupplierAddress4 = $_POST['supplierAddress4'];
$newSupplierAddress5 = $_POST['supplierAddress5'];


$errors = "";
// rules
// Must include supplier name /


if (!$newSupplierName) {
    $errors .="You must include the Supplier name<br>";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newSupplierName = mysqli_real_escape_string($link,filter_var($newSupplierName, FILTER_SANITIZE_STRING));
$newSupplierAddress1 = mysqli_real_escape_string($link,filter_var($newSupplierAddress1, FILTER_SANITIZE_STRING));
$newSupplierAddress2 = mysqli_real_escape_string($link,filter_var($newSupplierAddress2, FILTER_SANITIZE_STRING));
$newSupplierAddress3 = mysqli_real_escape_string($link,filter_var($newSupplierAddress3, FILTER_SANITIZE_STRING));
$newSupplierAddress4 = mysqli_real_escape_string($link,filter_var($newSupplierAddress4, FILTER_SANITIZE_STRING));
$newSupplierAddress5 = mysqli_real_escape_string($link,filter_var($newSupplierAddress5, FILTER_SANITIZE_STRING));




$sql = "INSERT INTO tblSupplier (supplierName, supplierAddress1, supplierAddress2, supplierAddress3, supplierAddress4, supplierAddress5) VALUES ('$newSupplierName','$newSupplierAddress1', '$newSupplierAddress2', '$newSupplierAddress3', '$newSupplierAddress4', '$newSupplierAddress5')";

$result = mysqli_query($link, $sql);

$lastSupplierID = $link->insert_id;

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


$lastID = $_SESSION['currentCustomer'];

  if (!$result) {
        echo '<div class="alert alert-danger">Error updating supplier</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Supplier $newSupplierName was created', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);

    echo $lastID . "/" . $lastSupplierID . "success";
?>






