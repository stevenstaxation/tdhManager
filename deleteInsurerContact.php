<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$sql = "SELECT tblInsurerContact.firstName, tblInsurerContact.lastName, tblInsurer.insurerName FROM tblInsurerContact INNER JOIN tblInsurer ON tblInsurer.ID = tblInsurerContact.insurerID WHERE tblInsurerContact.ID = '" . $_POST['contactNumber'] ."'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$insurerName = $row['insurerName'];
$contactName = $row['firstName']. " " . $row['lastName'];



$sql = "DELETE FROM tblInsurerContact WHERE tblInsurerContact.ID = '" . $_POST['contactNumber'] ."'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Contact $contactName was deleted from $insurerName', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql); 

echo "success";


?>
