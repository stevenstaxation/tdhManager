<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updateJobTypeID = $_POST['JobTypeIDToUpdate'];
$updateJobTypeName = $_POST['JobTypeNameToUpdate'];

$errors='';


if (!$updateJobTypeName || $updateJobTypeName=='') {
    $errors .="Job type description cannot be empty";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updateJobTypeName = mysqli_real_escape_string($link,filter_var($updateJobTypeName, FILTER_SANITIZE_STRING));

// get old status name
$sql = "SELECT description FROM tblJobType WHERE ID='$updateJobTypeID'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblJobType SET description = '$updateJobTypeName' WHERE ID='$updateJobTypeID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating job type Description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$description = "Job type description " . $prev['description'] . " was changed to " . $updateJobTypeName;

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";



?>
