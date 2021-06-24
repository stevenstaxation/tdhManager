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

$sql = "UPDATE tblJobType SET description = '$updateJobTypeName' WHERE ID='$updateJobTypeID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating job type Description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Job type $updateJobTypeName was amended', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";



?>
