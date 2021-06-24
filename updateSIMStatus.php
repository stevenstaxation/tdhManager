<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$updateSIMStatusID = $_POST['SIMStatusIDToUpdate'];
$updateSIMStatusName = $_POST['SIMStatusNameToUpdate'];

$errors='';


if (!$updateSIMStatusName || $updateSIMStatusName=='') {
    $errors .="SIM Status description cannot be empty";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$updateSIMStatusName = mysqli_real_escape_string($link,filter_var($updateSIMStatusName, FILTER_SANITIZE_STRING));

$sql = "UPDATE tblSIMStatus SET SIMStatus = '$updateSIMStatusName' WHERE ID='$updateSIMStatusID'";



$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating SIM Description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Status $updateSIMStatusName was amended', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);


echo "success";



?>
