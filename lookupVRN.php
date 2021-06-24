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

$VRNToLookup = filter_var($_POST['VRN'], FILTER_SANITIZE_STRING);
$VRNToLookup = str_replace(' ','', $VRNToLookup);
$VRNToLookup = strtoupper($VRNToLookup);

$errors = "";

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$VRNToLookup = mysqli_real_escape_string($link,$VRNToLookup);


$VRNLookupURL = 'https://www.rapidcarcheck.co.uk/results?RegPlate=' . $VRNToLookup;
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

if ($wraps['Make']=='Unknown' || $wraps['Make']=='') {
    $wraps['Make'] = 'Make not found';
}
if ($wraps['Model']=='Unknown' || $wraps['Model']=='') {
    $wraps['Model'] = 'Model not found';
}
if ($wraps['Year'] =='Unknown' || $wraps['Year'] =='') {
    $wraps['Year'] = 'Unknown year';
}


// VRN exists in database
    $returnArray = $VRNToLookup ."^^^";
    $returnArray .= $wraps['Make']."^^^";
    $returnArray .= $wraps['Model']."^^^";
    $returnArray .= $wraps['Colour'] . "(" . $wraps['Year'] . ")" ."^^^";
    $returnArray .= $row['businessName'] . "^^^";
    $returnArray .= $_SESSION['currentCustomer'] . "^^^";
    
   
echo $returnArray;


?>
