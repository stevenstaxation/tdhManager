<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newFootageStatusName = $_POST['FootageStatusNameToAdd'];

$errors='';


if (!$newFootageStatusName || $newFootageStatusName=='') {
    $errors .="You must enter the footage status description";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newFootageStatusName = mysqli_real_escape_string($link,filter_var($newFootageStatusName, FILTER_SANITIZE_STRING));

$sql = "INSERT INTO tblFootageStatus (description) VALUES('$newFootageStatusName')";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating footage status description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Footage status description $newFootageStatusName was created', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";



?>
