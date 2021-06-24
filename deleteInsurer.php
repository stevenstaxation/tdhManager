<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$insurerID = $_POST['insurerID'];

$sql = "SELECT insurerName FROM tblInsurer WHERE ID='$insurerID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$insurerName = $row['insurerName'];

// delete contacts
$sql = "DELETE FROM tblInsurerContact WHERE insurerID='$insurerID'";
$result = mysqli_query($link, $sql);

// reassign any customers
$sql = "UPDATE tblCustomer SET insurerID='0' WHERE insurerID='$insurerID'";
$result = mysqli_query($link, $sql);

// delete the insurer
$sql = "DELETE FROM tblInsurer WHERE ID = '$insurerID'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Insurer $insurerName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);

echo "success";


?>

