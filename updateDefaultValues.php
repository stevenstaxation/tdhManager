<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$defaultInstaller = $_POST['defaultInstaller'];
$defaultSupplier = $_POST['defaultSupplier'];

$sql = "UPDATE tblGlobals SET defaultInstaller ='$defaultInstaller', defaultSupplier = '$defaultSupplier' WHERE ID=1";

$result = mysqli_query($link, $sql);



?>