<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$sql = "SELECT tblOtherContact.firstName, tblOtherContact.lastName, tblOther.otherName FROM tblOtherContact INNER JOIN tblOther ON tblOther.ID = tblOtherContact.otherID WHERE tblOtherContact.ID = '" . $_POST['contactNumber'] ."'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$otherName = $row['otherName'];
$contactName = $row['firstName']. " " . $row['lastName'];


$sql = "DELETE FROM tblOtherContact WHERE tblOtherContact.ID = '" . $_POST['contactNumber'] ."'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Partner $contactName was deleted from $otherName', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql); 

echo "success";


?>
