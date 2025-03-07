<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}
$sql = "SELECT ID FROM tblCustomer WHERE businessName LIKE '%Barlow%'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

$barlows = $row['ID'];

$sql = "SELECT regNumber, installDate, vehicleNotes, vehicleStatus, cameraRequired FROM tblVehicle WHERE ownerID = " . $barlows;
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $filename = "barlow-vehicles_" . date('Y-m-d') . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '";');
    $delimiter = ",";

    $f = fopen($filename, 'w');
    // $f = fopen($filename, 'w');

    $fields = array('Registration No.', 'Install Date', 'Notes', 'Status', 'Camera Required');
    fputcsv($f, $fields, $delimiter);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $status = "";
        switch ($row['vehicleStatus']) {
            case 0:
                $status = "N/A";
                break;
            case 1:
                $status = "Pending";
                break;
            case 2:
                $status = "Installed";
                break;
            default:
                $status = "N/A";
        }
        $required = "No";
        if ($row['cameraRequired'] == 1) {$required = "Yes";}

        $lineData = array($row['regNumber'], $row['installDate'], $row['vehicleNotes'], $status, $required);

        fputcsv($f, $lineData, $delimiter);
    }

    fclose($f);

    echo($filename);
    // exit;
}
