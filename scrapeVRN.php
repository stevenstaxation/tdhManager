<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$vehicleVRN = str_replace(' ', '',$_POST['VRN']);
$VRNLookupURL = 'https://www.rapidcarcheck.co.uk/results?RegPlate=' . $vehicleVRN;

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


echo(json_encode($wraps));

?>
