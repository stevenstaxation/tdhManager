<?php
session_start();
include ('connect.php');

$owner = $_POST['ownerID'];

$sql = "SELECT VCOReference FROM tblCustomer WHERE ID='$owner'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

echo $row['VCOReference'];



?>




                                   
                                   