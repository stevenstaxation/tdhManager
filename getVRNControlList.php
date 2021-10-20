<?php
session_start();
include ('connect.php');

$quantity = $_POST['Quantity'];
$returnString= '';
$ix = 1;

while ($ix <= $quantity) {

    $returnString .= "
    <div class='col-4'>
        <label class='control-label' for='addJobTypeVRN' style='padding-top:8px;'>Job No. " . $ix ."</label>
    </div>
    <div class='col-4'>
        <div class='input-group'>
            <select name='addJobTypeOldVRN' class='custom-select addJobTypeOldVRN'>
                <option value='0' disabled selected>select VRN</option>
            </select>
        </div>
    </div>
    <div class='col-4'>
    <div class='input-group'>
        <select name='addJobTypeVRN' class='custom-select addJobTypeVRN'>
            <option value='0' disabled selected>select VRN</option>

        </select>
        <div class='input-group-append'>
            <span class='input-group-btn btn btn-outline-success btn-sm disabled addVRNButton' style='padding:7px;'><b>New</b></span>
        </div>
    </div>
    </div>";
    $ix++;


} 

echo $returnString;



?>




                                   
                                   