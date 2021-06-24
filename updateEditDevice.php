<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$deviceID = $_POST['deviceID'];
$deviceOwnerID = $_POST['ownerID'];
$deviceDescriptionID = $_POST['deviceDescriptionID'];
$deviceTDHNumber = $_POST['TDHNumber'];
$deviceSerialNumber = $_POST['serialNumber'];
$deviceIMEI = $_POST['IMEI'];
$deviceDRIDNumber = $_POST['DRIDNumber'];
$deviceSIMNumber = $_POST['SIMNumber'];
$deviceSIMPhone = $_POST['SIMPhone'];
$deviceSIMStatus = $_POST['SIMStatus'];
$deviceSIMDeactDate = $_POST['SIMDeactivationDate'];
$deviceConfig = $_POST['config'];
$deviceRegNumber = str_replace(' ', '',$_POST['regNumber']);
$deviceRegNumber = strtoupper($deviceRegNumber);
$deviceStatus = $_POST['status'];
$deviceInstallerID = $_POST['installerID'];
$deviceInstallDate = $_POST['installDate'];
$deviceInstallerReference = $_POST['assocOrderNumber'];
$deviceSupplierID = $_POST['supplierID'];
$deviceSupplierInvoice = $_POST['supplierInvoice'];
$deviceNote = $_POST['deviceNote'];
$devicePurchaseDate = $_POST['purchaseDate'];
$deviceVehicleID = '';

$errors = "";

if ($deviceIMEI) {
    if (strlen($deviceIMEI)!=15) {
        $errors .= 'IMEI should be 15 digits long';
    }
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}


// is this a new vehicle - if so get the details and add a new vehicle
// if not a new vehicle then get vehicle ID
$sql = "SELECT * FROM tblVehicle WHERE regNumber='$deviceRegNumber'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if ($count==1) { // vehicle exists
    $row = mysqli_fetch_array($result);
    $deviceVehicleID = $row['ID'];
} else {
    $VRNLookupURL = 'https://www.rapidcarcheck.co.uk/results?RegPlate=' . $deviceRegNumber;
    $dom = file_get_html($VRNLookupURL);

    $wraps = [];
    $wraps['Make'] = "Unknown";
    $wraps['Model'] = '';
    $wraps['Colour'] = '';
    $wraps['Year'] = '';
    $wraps['other'] = '';

    foreach($dom->find(".wpb_wrapper") as $rTitle) {
        if (strpos($rTitle->plaintext, "Make: ")!==false) {
            $wraps['Make'] = substr($rTitle->plaintext,8);
        }
        if (strpos($rTitle->plaintext, "Model: ")!==false) {
            $wraps['Model'] = substr($rTitle->plaintext,9);
        }
        if (strpos($rTitle->plaintext, "Colour: ")!==false) {
            $wraps['Colour'] = substr($rTitle->plaintext,10);
        }
        if (strpos($rTitle->plaintext, "Year: ")!==false) {
            $wraps['Year'] = substr($rTitle->plaintext,8);
        }
    }

    if ($wraps['Year']<>'') {
        $wraps['other'] = $wraps['Colour'] . " ( " . $wraps['Year'] . ")";
    } else {
        $wraps['other'] = $wraps['Colour'];
    }

    $sql = "INSERT INTO tblVehicle (make, model, addDescription, regNumber, ownerID) VALUES ('" . $wraps['Make'] ."', '" . $wraps['Model']. "', '" .$wraps['other'] . "', '" . $deviceRegNumber . "', '" . $deviceOwnerID . "')";

    $result = mysqli_query($link, $sql);

    $deviceVehicleID = $link->insert_id;
}


$sql = "UPDATE tblDevice SET ownerID='$deviceOwnerID', isCamera='1', deviceDescriptionID='$deviceDescriptionID', TDHNumber='$deviceTDHNumber',
serialNumber='$deviceSerialNumber', IMEI='$deviceIMEI', DRIDNumber='$deviceDRIDNumber', SIMNumber='$deviceSIMNumber', SIMPhone='$deviceSIMPhone', SIMStatus='$deviceSIMStatus',
SIMDeactivationDate=NULLIF('$deviceSIMDeactDate',''), config='$deviceConfig', cameraUsedFor='$deviceOwnerID', vehicleID='$deviceVehicleID', status='$deviceStatus', installerID=NULLIF('$deviceInstallerID',''),
installDate=NULLIF('$deviceInstallDate',''), assocOrderNumber='$deviceInstallerReference', supplierID=NULLIF('$deviceSupplierID',''), supplierInvoice='$deviceSupplierInvoice', purchaseDate=NULLIF('$devicePurchaseDate',''), deviceNote='$deviceNote' WHERE ID = '$deviceID'";


$result = mysqli_query($link, $sql);

echo $sql . "success";


?>
