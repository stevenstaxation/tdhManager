<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sql = "SELECT businessName FROM tblCustomer WHERE ID='" . $_SESSION['currentCustomer'] ."'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

    $returnArray = $row['businessName'];
    $returnArray .= "***" . $_SESSION['currentCustomer'];
    
   
echo $returnArray;


?>
