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
if (!isset($_POST['FilterType'])) {
  $_POST['FilterType'] = '';
}
if (!isset($_POST['FilterOtherTerm'])) {
  $_POST['FilterOtherTerm'] = '';
}

$returnString = "<div id='deviceLongList' style = 'margin-top: 50px;margin-bottom: 20px;'><h4><strong>Devices</strong></h4></div>";

$returnString .= "<div class='container'>
<div id='deviceFilter'>
    <form id='deviceForm' class='filterBox'>
    <div id='deviceFilters' class='settings-dialog' style='border-width: 1px; border-style: solid; padding: 5px; width:100%' onSubmit='return false;'>
        <div class='form-group'>
          <div class='row'>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
              <label for='byCustomer'>Customer</label>
               <div class='input-group'>
                  <select style='font-size: 75%' id='getCustomerSelect' name='getCustomerSelect' class='custom-select getCustomerSelect'>";

                  $sql = "SELECT ID, businessName FROM tblCustomer ORDER BY businessName ASC";
                  $result = mysqli_query($link,$sql);

                  $returnString .= "<option value= '0' selected='selected'>All customers</option>";

                  while ($customerRow = mysqli_fetch_array($result)) {
                    if ($_POST['FilterCustomer']== $customerRow['ID']) {
                      $returnString .= "<option value= '". $customerRow['ID']."' selected='selected'>";
                    } else {
                      $returnString .= "<option value= '". $customerRow['ID']."'>";
                    }
                      $returnString .= $customerRow['businessName']. " </option>";
                  }

                  $returnString .="
                  </select>
                 </div>
            </div>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
              <label for='byDeviceType'>Type</label>
               <div class='input-group'>
                  <select style='font-size: 75%' id='byDeviceType' name='byDeviceType' class='custom-select byDeviceType'>";

                  $sql = "SELECT * FROM tblDeviceDescription ORDER BY description ASC";
                  $result = mysqli_query($link,$sql);

                  $returnString .= "<option value= '0' selected='selected'>All devices</option>";

                  while ($deviceRow = mysqli_fetch_array($result)) {
                    if ($_POST['FilterType']== $deviceRow['ID']) {
                      $returnString .= "<option value= '". $deviceRow['ID']."' selected='selected'>";
                    } else {
                      $returnString .= "<option value= '". $deviceRow['ID']."'>";
                    }
                      $returnString .= $deviceRow['description']. " </option>";
                  }

                  $returnString .="
                  </select>
                 </div>
            </div>

            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px;'>
              <label for='byOther'>Other Search Term</label>
              <div class='input-group'>
                <input type='text' style='font-size:75%; padding: 5px;' id='byOther' value='" . $_POST['FilterOtherTerm'] . "'/>
              </div>
            </div>


            <div class='col-sm-6 col-md-4 col-lg-3' style ='padding-left:15px; padding-top: 32px;'>
              <btn type='button' class='btn btn-sm btn-success' id='deviceFilterClicked' style='border-radius: 5px;'>Apply Filter/Search</button>
            </div>
          </div>
        </div>
    </form>
  </div>
  </div>
</div>


";

  $sql = 'SELECT tblDevice.ID, tblDevice.ownerID, tblDevice.TDHNumber, tblDevice.serialNumber, tblDevice.IMEI, tblDevice.DRIDNumber, 
  tblDevice.SIMNumber, tblDevice.SIMPhone, tblDevice.config, tblDeviceStatus.status, tblVehicle.regNumber, 
  tblCustomer.businessName, tblDeviceDescription.description, tblSIMStatus.SIMStatus, tblInstaller.installerName, tblDevice.installDate  
  
  FROM tblDevice INNER JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID 
  INNER JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID =tblDeviceDescription.ID INNER JOIN tblDeviceStatus ON tblDevice.status 
  = tblDeviceStatus.ID INNER JOIN tblSIMStatus ON tblDevice.SIMStatus = tblSIMStatus.ID INNER JOIN tblInstaller ON tblDevice.installerID = tblInstaller.ID';

    if ($sqlFILTER) {
      $sql .= $sqlFILTER;
    }

  $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result)!=0) {
      $returnString .="<div id = 'deviceSummary' style='margin-top: 15px;'>
      <table class='table table-sm table-bordered table-hover w-auto ml-auto mr-auto' style='font-size: 75%'>
      <thead>
        <tr>
          <th class='align-middle' style='padding:0 3px;'><strong>No.</strong></th>
          <th class='align-middle' style='padding:0 3px;'><strong>Owner</strong></th>
          <th class='text-center align-middle' style='padding:0 3px;'>TDH Number</th>
          <th class='text-center align-middle' style='padding:0 3px;'>Reg Number</th>
          <th class='text-center align-middle' style='padding:0 3px;'>Type</th>     
          <th class='text-center align-middle' style='padding:0 3px;'>Serial</th>
          <th class='text-center align-middle' style='padding:0 3px;'>IMEI</th>
          <th class='text-center align-middle' style='padding:0 3px;'>DRID Number</th>
          <th class='text-center align-middle' style='padding:0 3px;'>Status</th>
          <th class='text-center align-middle' style='padding:0 3px;'>SIM Number</th>
          <th class='text-center align-middle' style='padding:0 3px;'>SIM Status</th>
          <th class='align-middle' style='padding:0 3px;'>Config</th>
          <th class='text-center align-middle' style='padding:0 3px;'>Installer</th>
          <th class='text-center align-middle' style='padding:0 3px;'>Install Date</th> 
          <th class='text-center align-middle' style='padding: 0 3px;'>Edit</th>
          <th class='text-center align-middle' style='padding: 0 3px;'>Notes</th>
        </tr>
      </thead>
    
      <tbody>";

      $ix = 1;
  while ($row= mysqli_fetch_array($result)) {

    $returnString .= "<tr>
    <td class='text-center align-middle' style='padding:0 3px'>" . $ix . "</td>
    <td class='align-middle' style='padding:0 3px'>" . $row['businessName'] . "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['TDHNumber']. "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['regNumber']. "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['description']. "</td>  
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['serialNumber']. "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['IMEI']. "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['DRIDNumber']. "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['status']. "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['SIMNumber']. "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['SIMStatus']. "</td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['config']. "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['installerName']. "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . date('d-m-Y', strtotime($row['installDate'])) . "</td>
    <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showFullDevice(\"" . $row['ID']."device\")'><svg xmlns='http://www.w3.org/2000/svg' width='12px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg></btn></td>
<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showDeviceNotes(\"" . $row['ID']."device\")'><svg xmlns='http://www.w3.org/2000/svg' width='12px' fill='currentColor' class='bi bi-card-text' viewBox='0 0 16 16'>
<path d='M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z'/>
<path d='M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z'/>
</svg></btn></td>
    </tr>";
    $ix++;
  }
    } else {
      $returnString .="<p class='text-center'>No results found</p>";
    }
  $returnString .="</tbody>

  </table>

</div>
<script>
 document.getElementById('byOther').addEventListener('keypress', function (event) {
       if (event.keyCode == 13) {
            event.preventDefault();
        } 
    });
    </script>
";


echo $returnString;

?>
