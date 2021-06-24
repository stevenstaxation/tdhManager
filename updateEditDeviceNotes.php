<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$deviceID = $_POST['deviceID'];
$deviceNote = $_POST['deviceNote'];

$errors = "";


$sql = "UPDATE tblDevice SET deviceNote='$deviceNote' WHERE ID = '$deviceID'";


$result = mysqli_query($link, $sql);

echo "success";


?>
