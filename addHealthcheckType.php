<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newHealthcheckTypeName = $_POST['HealthcheckTypeNameToAdd'];

$errors='';


if (!$newHealthcheckTypeName || $newHealthcheckTypeName=='') {
    $errors .="You must enter the status description";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newHealthcheckTypeName = mysqli_real_escape_string($link,filter_var($newHealthcheckTypeName, FILTER_SANITIZE_STRING));

$sql = "INSERT INTO tblHealthStatus (description) VALUES('$newHealthcheckTypeName')";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating healthcheck status description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

echo "success";



?>
