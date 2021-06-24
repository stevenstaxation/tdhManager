<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobTypeIDToDelete = $_POST['JobTypeIDToDelete'];

$sql = "SELECT description FROM tblJobType WHERE ID='$jobTypeIDToDelete'";
$result = mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);


$sql = "DELETE FROM tblJobType WHERE ID='$jobTypeIDToDelete'";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating job type description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Job type " . $row['description']." was deleted', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    

echo "success";



?>
