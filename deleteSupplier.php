<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$supplierID = $_POST['supplierID'];

$sql = "SELECT supplierName FROM tblSupplier WHERE ID='$supplierID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$supplierName = $row['supplierName'];

// delete contacts
$sql = "DELETE FROM tblSupplierContact WHERE supplierID='$supplierID'";
$result = mysqli_query($link, $sql);

// reassign any devices
$sql = "UPDATE tblDevice SET supplierID='0' WHERE supplierID='$supplierID'";
$result = mysqli_query($link, $sql);

// delete the supplier
$sql = "DELETE FROM tblSupplier WHERE ID = '$supplierID'";



$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database  </div>' . $sql;

        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Supplier $supplierName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);

echo "success";


?>

