<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sqlFILTER = ($_POST['SQLFilter']);

if (!isset($_POST['FilterCustomer'])) {
  $_POST['FilterCustomer'] = '';
}
if (!isset($_POST['FilterVRN'])) {
  $_POST['FilterVRN'] = '';
}
if (!isset($_POST['FilterTDHNumber'])) {
  $_POST['FilterTDHNumber'] = '';
}
$returnString = "<div id='alertLogList' style = 'margin-top: 50px;margin-bottom: 20px;'><h4><strong>Vehicles</strong></h4></div>";

$returnString .= "<div class='container'>
<div id='vehicleFilter'>
    <form id='vehicleForm' class='filterBox'>
    <div id='vehicleFilters' class='settings-dialog' style='border-width: 1px; border-style: solid; padding: 5px; width:100%' onSubmit='return false;'>
        <div class='form-group'>
          <div class='row'>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
              <label for='byCustomer'>Customer</label>
               <div class='input-group'>
                  <select style='font-size: 75%' id='getCustomerSelect' name='getCustomerSelect' class='custom-select getCustomerSelect'>";

$sql = "SELECT ID, businessName FROM tblCustomer ORDER BY businessName ASC";
$result = mysqli_query($link, $sql);

$returnString .= "<option value= '0' selected='selected'>All customers</option>";

while ($customerRow = mysqli_fetch_array($result)) {
    if ($_POST['FilterCustomer'] == $customerRow['ID']) {
        $returnString .= "<option value= '" . $customerRow['ID'] . "' selected='selected'>";
    } else {
        $returnString .= "<option value= '" . $customerRow['ID'] . "'>";
    }
    $returnString .= $customerRow['businessName'] . " </option>";
}

$returnString .= "
                  </select>
                 </div>
            </div>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
              <label for='byInsurer'>Insurer</label>
               <div class='input-group'>
                  <select style='font-size: 75%' id='getInsurerSelect' name='getInsurerSelect' class='custom-select getInsurerSelect'>";

$sql = "SELECT ID, insurerName FROM tblInsurer ORDER BY insurerName ASC";
$result = mysqli_query($link, $sql);

$returnString .= "<option value= '0' selected='selected'>All insurers</option>";

while ($insurerRow = mysqli_fetch_array($result)) {
    if ($_POST['FilterInsurer'] == $insurerRow['ID']) {
        $returnString .= "<option value= '" . $insurerRow['ID'] . "' selected='selected'>";
    } else {
        $returnString .= "<option value= '" . $insurerRow['ID'] . "'>";
    }
    $returnString .= $insurerRow['insurerName'] . " </option>";
}

$returnString .= "
                  </select>
                 </div>
            </div>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 10px'>
              <label for='VRNToLookup'>Search Term</label>
              <div class='input-group'>
                <input type='text' style='font-size: 75%; padding: 5px;' id='VRNToLookup' value='" . $_POST['FilterVRN'] . "' />
              </div>
            </div>
           
            <div class='col-sm-6 col-md-4 col-lg-3' style ='padding-left:15px; padding-top: 32px;'>
              <btn type='button' class='btn btn-success' id='vehicleFilterClicked' style='border-radius: 5px;'>Apply Filter</button>
            </div>
          </div>
        </div>
    </form>
</div>




";

// $sql = 'SELECT * FROM tblVehicle INNER JOIN tblDevice ON tblDevice.vehicleID = tblVehicle.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID';

$sql = 'SELECT * FROM tblVehicle INNER JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID';

if ($sqlFILTER) {
    $sql .= $sqlFILTER;
}


$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result)!=0) {
$returnString .="<div id = 'vehicleSummary' style='margin-top: 15px;'>
<table class='table table-sm table-bordered table-hover w-auto ml-auto mr-auto' style='font-size: 75%'>
<thead>
  <tr>
  <th class='align-middle' style='padding-left: 3px;'>No.</th>
  <th class='align-middle' style='padding-left: 3px;'>Customer</th>
    <th class='text-center align-middle'>Reg Number</th>
    <th class='align-middle' style='padding-left: 3px;'>Make</th>
    <th class='align-middle' style='padding-left: 3px;'>Model</th>
    <th class='text-center align-middle'>Description</th>
    
    <th class='text-center align-middle' style='width:5%'>Edit</th>
  </tr>
</thead>

<tbody>";

$ix = 1;
while ($row = mysqli_fetch_array($result)) {

    $returnString .= "<tr>
    <td class='text-center align-middle' style='padding: 0 5px;'>" . $ix . "</td>
    <td class='align-middle' style='padding-left: 5px;'>" . $row['businessName'] . "</td>
    <td class='text-center align-middle'>" . $row['regNumber'] . "</td>
    <td class='align-middle' style='padding-left: 3px;'>" . $row['make'] . "</td>
    <td class='align-middle' style='padding-left: 3px;'>" . $row['model'] . "</td>
    <td class='text-center align-middle'>" . $row['addDescription'] . "</td>
   
    <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showVehicleForEdit(\"" . $row[0] . "vehicle\")'><svg xmlns='http://www.w3.org/2000/svg' width='12px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg></btn></td>
    </tr>";
    $ix++;
}
} else {
  $returnString .="<p class='text-center'>No results found</p>";
}

$returnString .= "</tbody>

  </table>

</div>
<script>
 document.getElementById('VRNToLookup').addEventListener('keypress', function (event) {
       if (event.keyCode == 13) {
            event.preventDefault();
        } 
    });
    </script>

";

echo $returnString;


?>