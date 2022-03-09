<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$footageStatusIDToDelete = $_POST['FootageStatusIDToDelete'];

$sql = "SELECT * FROM tblFootageRequest WHERE statusID='$footageStatusIDToDelete'";
$result = mysqli_query($link, $sql);
$total = mysqli_num_rows($result);

if ($total == 1) {
    $device = " footage request.";
} else {
    $device = " footage requests.";
}

if ($total>0) {
    echo '<div class="alert alert-danger">Cannot delete this footage status description.<br>
    It is attached to ' . $total . $device .'</div>';
    exit();
}

$sql = "SELECT description FROM tblFootageStatus WHERE ID='$footageStatusIDToDelete'";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);


$sql = "DELETE FROM tblFootageStatus WHERE ID='$footageStatusIDToDelete'";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating Footage Status Description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Footage status " . $row['description']." was deleted', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    
echo "success";

?>
