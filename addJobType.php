<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newJobTypeName = $_POST['JobTypeNameToAdd'];

$errors='';


if (!$newJobTypeName || $newJobTypeName=='') {
    $errors .="You must enter the job type description";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newJobTypeName = mysqli_real_escape_string($link,filter_var($newJobTypeName, FILTER_SANITIZE_STRING));

$sql = "INSERT INTO tblJobType (description) VALUES('$newJobTypeName')";
$result = mysqli_query($link, $sql);

 if (!$result) {
        echo '<div class="alert alert-danger">Error updating job type description</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

echo "success";



?>
