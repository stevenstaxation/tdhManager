<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sql = 'SELECT ID, businessName FROM tblCustomer';
$result = mysqli_query($link, $sql);

while ($customerRow = mysqli_fetch_array($result)) {
    if ($customerRow['businessName'] != "DHD" && $customerRow['businessName'] != "DHINSTALL") {
        echo "<option value = " . $customerRow['ID'] . ">" . $customerRow['businessName'] . "</option>";
    }
}
?>