<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newOtherName = $_POST['otherName'];
$newOtherAddress1 = $_POST['otherAddress1'];
$newOtherAddress2 = $_POST['otherAddress2'];
$newOtherAddress3 = $_POST['otherAddress3'];
$newOtherAddress4 = $_POST['otherAddress4'];
$newOtherAddress5 = $_POST['otherAddress5'];
$newOtherService = $_POST['otherService'];


$errors = "";
// rules
// Must include other name /


if (!$newOtherName) {
    $errors .="You must include the Partner's name<br>";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newOtherName = mysqli_real_escape_string($link,filter_var($newOtherName, FILTER_SANITIZE_STRING));
$newOtherAddress1 = mysqli_real_escape_string($link,filter_var($newOtherAddress1, FILTER_SANITIZE_STRING));
$newOtherAddress2 = mysqli_real_escape_string($link,filter_var($newOtherAddress2, FILTER_SANITIZE_STRING));
$newOtherAddress3 = mysqli_real_escape_string($link,filter_var($newOtherAddress3, FILTER_SANITIZE_STRING));
$newOtherAddress4 = mysqli_real_escape_string($link,filter_var($newOtherAddress4, FILTER_SANITIZE_STRING));
$newOtherAddress5 = mysqli_real_escape_string($link,filter_var($newOtherAddress5, FILTER_SANITIZE_STRING));
$newOtherService = mysqli_real_escape_string($link,filter_var($newOtherService, FILTER_SANITIZE_STRING));




$sql = "INSERT INTO tblOther (otherName, otherAddress1, otherAddress2, otherAddress3, otherAddress4, otherAddress5, otherService) VALUES ('$newOtherName','$newOtherAddress1', '$newOtherAddress2', '$newOtherAddress3', '$newOtherAddress4', '$newOtherAddress5', '$newOtherService')";

$result = mysqli_query($link, $sql);

$lastOtherID = $link->insert_id;

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }





$lastID = $_SESSION['currentCustomer'];

  if (!$result) {
        echo '<div class="alert alert-danger">Error updating supplier</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Other partner $newOtherName was created', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);


echo $lastID . "/" . $lastOtherID . "success";

?>

