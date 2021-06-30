<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$APIData = $_POST['APIData'];

$returnString = "
<div class='row'>
    <div class='col-2'></div>
    <div class='col-3'><p style='text-align: right; margin-top: 6px'><strong>Registration Number</strong></p></div>
    <div class='col-4'>
     <p style='text-align: center;'>
        <span style='font-family: UKNumberPlate;border: 2px solid; background-color: #F2CF53; padding: 3px 6px; font-size:30px'>" .$APIData['Response']['DataItems']['VehicleRegistration']['Vrm'] . "</span>
     </p>   
    </div>
</div>

<hr>

<div class='row' style='margin-top:10px;'>
    <div class='col-4'>
        <p><strong>Make: </strong>" .$APIData['Response']['DataItems']['ClassificationDetails']['Dvla']['Make'] . "</p>
    </div>
    <div class='col-4'>
        <p><strong>Model: </strong>" .$APIData['Response']['DataItems']['ClassificationDetails']['Dvla']['Model'] . "</p>
    </div>
    <div class='col-4'>
        <p><strong>Colour: </strong>" .$APIData['Response']['DataItems']['VehicleRegistration']['Colour'] . "</p>
    </div>

</div>";

$driverPosition =  $APIData['Response']['DataItems']['TechnicalDetails']['General']['DriverPosition'];

if ($driverPosition=='R') {
    $driverPosition = "RIGHT HAND DRIVE";
} elseif ($driverPosition=='L') {
    $driverPosition = "LEFT HAND DRIVE";
} else {
    $driverPosition = "UNKNOWN";
}

$returnString .="

<div class='row'>
    <div class='col-4'>
       <p><strong>Drive: </strong>" .$driverPosition. "</p> 
    </div>
    <div class='col-4'>
        <p><strong>First Reg: </strong>" .date('d/m/Y', strtotime($APIData['Response']['DataItems']['VehicleRegistration']['DateFirstRegistered'])). "</p> 
    </div>
    <div class='col-4'>
        <p><strong>Previous Keepers: </strong>" . $APIData['Response']['DataItems']['VehicleHistory']['NumberOfPreviousKeepers']. "</p> 
    </div>
    
</div>

<div class='row'>
    <div class='col-4'>
        <p><strong>Fuel Type: </strong>" .$APIData['Response']['DataItems']['VehicleRegistration']['FuelType'] . "</p>
    </div>
    <div class='col-4'>
        <p><strong>Engine Size: </strong>" .$APIData['Response']['DataItems']['VehicleRegistration']['EngineCapacity'] . "cc</p>
    </div>
    <div class='col-4'>
        <p><strong>CO<sub>2</sub> emissions: </strong>" .$APIData['Response']['DataItems']['VehicleRegistration']['Co2Emissions'] . "g km<sup>-1</sup></p>
    </div>

</div>
<hr>";
$numberOfDoors = $APIData['Response']['DataItems']['SmmtDetails']['NumberOfDoors'];
if (!$numberOfDoors || $numberOfDoors==0) {
    $numberOfDoors = $APIData['Response']['DataItems']['TechnicalDetails']['Dimensions']['NumberOfDoors'];
}


$returnString .= "
<div class='row'>
    <div class='col-4'>
       <p><strong>Doors: </strong>" .$numberOfDoors. "</p> 
    </div>
    <div class='col-4'>
        <p><strong>Seats: </strong>" . $APIData['Response']['DataItems']['TechnicalDetails']['Dimensions']['NumberOfSeats']. "</p> 
    </div>
    <div class='col-4'>
        <p><strong>Door Plan: </strong>" .$APIData['Response']['DataItems']['VehicleRegistration']['DoorPlanLiteral'] . "</p> 
    </div>
</div>
<hr>

<div class='row'>
    <div class='col-4'>
       <p><strong>Power: </strong>" .$APIData['Response']['DataItems']['TechnicalDetails']['Performance']['Power']['Bhp']. "bhp</p> 
    </div>
    <div class='col-4'>
        <p><strong>Torque: </strong>" . $APIData['Response']['DataItems']['TechnicalDetails']['Performance']['Torque']['Nm']. "Nm</p> 
    </div>
    <div class='col-4'>
        <p><strong>Max Speed: </strong>" .$APIData['Response']['DataItems']['TechnicalDetails']['Performance']['MaxSpeed']['Mph'] . "mph</p> 
    </div>
</div>
<hr>

<button type='button' class='btn btn-danger d-print-none' style='float:right' data-dismiss='modal'>Close</btn>
<button type='button' class='btn btn-primary no-print' onclick='printVRNLookup()'>Print</button>

";




echo $returnString;



?>