<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$sql = "SELECT tblSupplierContact.firstName, tblSupplierContact.lastName, tblSupplier.supplierName FROM tblSupplierContact INNER JOIN tblSupplier ON tblSupplier.ID = tblSupplierContact.supplierID WHERE tblSupplierContact.ID = '" . $_POST['contactNumber'] ."'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$supplierName = $row['supplierName'];
$contactName = $row['firstName']. " " . $row['lastName'];


$sql = "DELETE FROM tblSupplierContact WHERE tblSupplierContact.ID = '" . $_POST['contactNumber'] ."'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Contact $contactName was deleted from $supplierName', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql); 

echo "success";


?>
