<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


if ($_FILES['file']['name']!='') {
    $test = explode(".", $_FILES['file']['name']);
    $extension = end($test);
    $name = 'regPic' . rand(100, 999999) . "." . $extension;
    $location = "uploads/" . $name;

    move_uploaded_file($_FILES['file']['tmp_name'], $location);

  echo $location;
}

   



?>