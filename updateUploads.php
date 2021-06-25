<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


if (!file_exists('uploads')) {
    mkdir('uploads', 0777);
}

$requestID = $_POST['requestID'];
$fileNames = $_POST['fileNames'];

$sqlfill = "";

foreach ($fileNames as $fileName) {
    $sql = "INSERT INTO tblFootageFiles (filePathName, requestID) VALUES ('$fileName', '$requestID')";
    $result = mysqli_query($link, $sql);
    $sqlfill .= $sql . "  ";
}

if ($result) {
    echo "success";
}

?>