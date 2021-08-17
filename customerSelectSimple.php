<?php
session_start();
include('connect.php');


$selectedCustomer = $_POST['selectedCustomer'];


$returnString = "<hr>
<div class='col-md-4'>
    <label class='control-label' for='selectVRN' style='padding-top:8px;'><strong>Optional VRN</strong></label>
</div>
<div class='col-md-8'>
    <div class='input-group'>
        <select id='selectVRN' name='selectVRN' class='custom-select selectVRN'>";

        $sql = "SELECT tblVehicle.ID, tblVehicle.regNumber FROM tblVehicle LEFT JOIN tblCustomer ON tblVehicle.ownerID = tblCustomer.ID WHERE tblCustomer.ID= '$selectedCustomer' ORDER BY regNumber ASC";
        $result = mysqli_query($link, $sql); 
        $returnString .="<option value ='0'>Do not allocate a VRN now</option>";
        while ($vehicleRow = mysqli_fetch_array($result)) {
            
            $returnString .= "<option value = " . $vehicleRow['ID'] . ">" . $vehicleRow['regNumber'] . "</option>";
        }

$returnString .= "
        </select        
    </div>
</div>";

echo $returnString;



?>

