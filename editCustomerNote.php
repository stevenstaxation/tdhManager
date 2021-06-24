<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$noteNumber = $_POST['noteID'];


$sql = "SELECT * FROM tblCustomerNote WHERE cnID = '" . $noteNumber . "'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);

echo $row['noteDate'] . "^^^";
echo $row['noteText'] . "^^^";
echo $row['isImportant'] . "^^^";
echo $row['isAnAlert'] . "^^^";
echo $row['customerID'] . "^^^";
echo $row['cnID'] . "^^^";
echo $row['userID'] . "^^^";



?>
