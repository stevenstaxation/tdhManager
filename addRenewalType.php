<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newRenewalTypeName = $_POST['RenewalTypeNameToAdd'];

$errors='';


if (!$newRenewalTypeName || $newRenewalTypeName=='') {
    $errors .="You must enter the renewal type description";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newRenewalTypeName = mysqli_real_escape_string($link,filter_var($newRenewalTypeName, FILTER_SANITIZE_STRING));

$sql = "INSERT INTO tblRenewalType (Description) VALUES('$newRenewalTypeName')";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating renewal type description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Renewal type $newRenewalTypeName was created', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
        

echo "success";



?>
