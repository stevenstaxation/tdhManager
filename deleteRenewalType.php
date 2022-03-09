<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$renewalTypeIDToDelete = $_POST['RenewalTypeIDToDelete'];

$sql = "SELECT * FROM tblCustomer WHERE renewalType='$renewalTypeIDToDelete'";
$result = mysqli_query($link, $sql);
$total = mysqli_num_rows($result);

if ($total == 1) {
    $device = " customer.";
} else {
    $device = " customers.";
}

if ($total>0) {
    echo '<div class="alert alert-danger">Cannot delete this renewal type.<br>
    It is attached to ' . $total . $device .'</div>';
    exit();
}

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
