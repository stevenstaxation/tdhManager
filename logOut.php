<?php
session_start();
include('connect.php');



$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Successful LOG OUT'," . $_SESSION['userID'] .")";



$result = mysqli_query($link, $sql);

unset($_SESSION['userEmail']);

header("Location: index.php");

?>
