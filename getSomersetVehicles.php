<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}
$sql = "SELECT ID FROM tblInsurer WHERE insurerName LIKE '%Somerset%'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

$somerset = $row['ID'];

$sql = "SELECT tblcustomer.businessname as BUS, tblvehicle.regNumber as REG, tbldevicedescription.description as DEV, tblvehicle.installDate as INST from tblvehicle
inner join tblcustomer on tblvehicle.ownerID = tblcustomer.id
inner join tbldevice on tblvehicle.ID = tbldevice.vehicleid
inner join tbldevicedescription on tbldevice.deviceDescriptionID = tbldevicedescription.id

WHERE tblcustomer.insurerID = '" . $somerset . "' AND tblvehicle.cameraRequired='1' ORDER BY BUS, REG, DEV, INST ASC";

$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $filename = "somerset-live-vehicles_" . date('Y-m-d') . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '";');
    $delimiter = ",";

    $f = fopen($filename, 'w');

    $fields = array('Fleet', 'Vehicles According to Data Hub Records', 'Camera Installed/Purchased/Invoiced For?', 'Purchase Date', 'New Business/MTA', 'Date Install Completed/Booked', 'Notes');
    fputcsv($f, $fields, $delimiter);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if (str_contains($row['DEV'],'CP2')) {
            $row['DEV'] = "CP2";
        }
        if (str_contains($row['DEV'],'CP4')) {
            $row['DEV'] = "CP4";
        }
        if (str_contains($row['DEV'],'CR-X')) {
            $row['DEV'] = "CR-X";
        }
        $lineData = array($row['BUS'], $row['REG'], $row['DEV'], "", "", $row['INST'], "");

        fputcsv($f, $lineData, $delimiter);
    }
    $lineData = array('Total Installed/Live', '', '', '','',mysqli_num_rows($result),'');
    fputcsv($f, $lineData, $delimiter);
    

    fclose($f);

    echo ($filename);

  
}
