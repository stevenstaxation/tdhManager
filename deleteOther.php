<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$otherID = $_POST['otherID'];

$sql = "SELECT otherName FROM tblOther WHERE ID='$otherID'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$otherName = $row['otherName'];

// delete contacts
$sql = "DELETE FROM tblOtherContact WHERE otherID='$otherID'";
$result = mysqli_query($link, $sql);


// delete the partner
$sql = "DELETE FROM tblOther WHERE ID = '$otherID'";



$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database  </div>' . $sql;

        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Partner $otherName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);

echo "success";


?>
