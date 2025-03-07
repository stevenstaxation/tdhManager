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
            <select name='addJobTypeVRN' class='custom-select addJobTypeVRN'>
                <option value='0' disabled selected>select VRN</option>
            </select>
            <div class='input-group-append'>
                <span class='input-group-btn btn btn-outline-success btn-sm disabled addVRNButton' style='padding:7px;'><b>New</b></span>
            </div>
        </div>
    </div>
    <div class='col-4'></div>
   ";
    $ix++;


} 

echo $returnString;



?>
 <!-- <div class='col-4' style='font-family: Charles-Wright-Bold'>
        <label style='width=100%; margin: 0; background-color:#232F68; color: white; padding-top: 24px; padding-bottom: 7px;'><b style='padding: 0 3px'>&nbsp;GB&nbsp;</b></label>
        <label class='jobRegistrationPlate' style='width=100%; margin: 0; margin-left:-4px; background-color:#f5bd38; color: dark-gray; font-size: 32px; border: 1px solid gray;'><b style='padding: 0 5px'><b></b></label>
    </div>
 -->
<!-- <div class='col-4'>
        <div class='input-group'>
            <select name='addJobTypeOldVRN' class='custom-select addJobTypeOldVRN'>
                <option value='0' disabled selected>select VRN</option>
            </select>
        </div>
    </div> -->

                                   
                                   