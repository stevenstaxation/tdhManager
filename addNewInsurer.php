<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newInsurerName = $_POST['insurerName'];
$newInsurerAddress1 = $_POST['InsurerAddress1'];
$newInsurerAddress2 = $_POST['InsurerAddress2'];
$newInsurerAddress3 = $_POST['InsurerAddress3'];
$newInsurerAddress4 = $_POST['InsurerAddress4'];
$newInsurerAddress5 = $_POST['InsurerAddress5'];


$errors = "";

if (!$newInsurerName) {
    $errors .="You must include the Insurer name<br>";
}

if (!(checkPostcode($newInsurerAddress5)) && $newInsurerAddress5 != "") {
    $errors .= "Postcode is not valid<br>";
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newInsurerName = mysqli_real_escape_string($link,filter_var($newInsurerName, FILTER_SANITIZE_STRING));
$newInsurerAddress1 = mysqli_real_escape_string($link,filter_var($newInsurerAddress1, FILTER_SANITIZE_STRING));
$newInsurerAddress2 = mysqli_real_escape_string($link,filter_var($newInsurerAddress2, FILTER_SANITIZE_STRING));
$newInsurerAddress3 = mysqli_real_escape_string($link,filter_var($newInsurerAddress3, FILTER_SANITIZE_STRING));
$newInsurerAddress4 = mysqli_real_escape_string($link,filter_var($newInsurerAddress4, FILTER_SANITIZE_STRING));
$newInsurerAddress5 = mysqli_real_escape_string($link,filter_var(strtoupper($newInsurerAddress5), FILTER_SANITIZE_STRING));


$sql = "INSERT INTO tblInsurer (insurerName, insurerAddress1, insurerAddress2, insurerAddress3, insurerAddress4, insurerAddress5) VALUES ('$newInsurerName','$newInsurerAddress1', '$newInsurerAddress2', '$newInsurerAddress3', '$newInsurerAddress4', '$newInsurerAddress5')";
$result = mysqli_query($link, $sql);

$lastInsurerID = $link->insert_id;

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Insurer $newInsurerName was created', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


$lastID = $_SESSION['currentCustomer'];

  if (!$result) {
        echo '<div class="alert alert-danger">Error updating insurer</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }




echo $lastID . "/" . $lastInsurerID . "success";

?>
