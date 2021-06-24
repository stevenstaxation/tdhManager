<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$renewalTypeIDToDelete = $_POST['RenewalTypeIDToDelete'];

$sql = "SELECT Description FROM tblRenewalType WHERE ID='$renewalTypeIDToDelete'";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);


$sql = "DELETE FROM tblRenewalType WHERE ID='$renewalTypeIDToDelete'";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating renewal date description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Renewal type " . $row['description']." was deleted', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    

echo "success";



?>
