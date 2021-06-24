<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newSIMStatusName = $_POST['SIMStatusNameToAdd'];

$errors='';


if (!$newSIMStatusName || $newSIMStatusName=='') {
    $errors .="You must enter the SIM status description";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newSIMStatusName = mysqli_real_escape_string($link,filter_var($newSIMStatusName, FILTER_SANITIZE_STRING));

$sql = "INSERT INTO tblSIMStatus (SIMStatus) VALUES('$newSIMStatusName')";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating SIM description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('SIM status description $newSIMStatusName was created', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    
echo "success";



?>
