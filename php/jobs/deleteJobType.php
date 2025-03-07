<?php
session_start();
include('../../connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$jobTypeIDToDelete = $_POST['JobTypeIDToDelete'];

$sql = "SELECT * FROM tblJobs WHERE jobType='$jobTypeIDToDelete'";
$result = mysqli_query($link, $sql);
$total = mysqli_num_rows($result);

if ($total == 1) {
    $device = " job.";
} else {
    $device = " jobs.";
}

if ($total>0) {
    echo '<div class="alert alert-danger">Cannot delete this job type.<br>
    It is attached to ' . $total . $device .'</div>';
    exit();
}

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
