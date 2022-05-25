<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$tableRates = json_decode($_POST['tableRates']);

$sql ='';
$errorFlag = false;
foreach ($tableRates as $tableRate) {
    $sql ="UPDATE tblJobRates SET rate = '".$tableRate[1]. "' WHERE ID='" . $tableRate[0] ."';";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        $errorFlag=true;
    }
}

if ($errorFlag) {
    echo "<div class='alert alert-danger'>Could not update database" . mysqli_error($link) . "</alert>";
} else {
    echo 'success';
}


?>