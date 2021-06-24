<?php
session_start();
//include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

function WriteToEventLog($timeStamp, $eventDescription, $userID) {

$sql = "INSERT INTO tblEventLog (TimeStamp, Description, UserID) VALUES ('$timeStamp', '$eventDescription', '$userID')";
$result = mysqli_query($link, $sql);

}



?>
