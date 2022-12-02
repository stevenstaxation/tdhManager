<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$jobID = $_POST['jobID'];
$jobNote = $_POST['jobNote'];
$jobNote = addslashes($jobNote);

$errors = "";


$sql = "UPDATE tblJobs SET notes='$jobNote' WHERE ID = '$jobID'";


$result = mysqli_query($link, $sql);

echo "success";


?>
