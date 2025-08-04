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

$returnString = "<div id='deviceLongList' class='listHeader'><h4><strong>Devices</strong></h4></div>";

$sql = "SELECT * FROM tblDevice";
    $result = mysqli_query($link, $sql);
    $devices_NUMBEROF = mysqli_num_rows($result);

    $sql = "SELECT COUNT(tblDevice.ID), tblDevice.status, tblDeviceStatus.status FROM tblDevice INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.ID GROUP BY tblDevicestatus.ID";
    $result = mysqli_query($link, $sql);
    $returnString = $returnString . "
        <div id='DeviceStats' style='font-size:120%'>";

            $devicesString = '';
            if ($devices_NUMBEROF!=0) {
                $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF ." (";
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['COUNT(tblDevice.ID)']!=0) {
                        $devicesString = $devicesString . $row['COUNT(tblDevice.ID)'] . " " . $row['status'] . ", ";
                    }
                }
                $devicesString = substr($devicesString,0, -2);
                $devicesString = $devicesString . ")";
            } else {
                $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF;
            }

            $returnString = $returnString . $devicesString;
            $returnString = $returnString . "
        </div><br>";

$returnString .= "
<div class='container'>
  <div id='deviceFilter d-none'>
    <div class='input-group'>
      <input type='text' style='font-size:75%; padding: 5px;' id='byOther' value='" . $_POST['FilterOtherTerm'] . "'/>
    </div>
  </div>
</div>
";

  $sql = "SELECT tblDevice.ID, tblDevice.ownerID, tblDevice.TDHNumber, tblDevice.serialNumber, tblDevice.IMEI, tblDevice.DRIDNumber, 
  tblDevice.SIMNumber, tblDevice.SIMPhone, tblDevice.config, tblDevice.deviceNote, tblDeviceStatus.status, tblVehicle.regNumber, 
  tblCustomer.businessName, tblDeviceDescription.description, tblSIMStatus.SIMStatus, tblInstaller.installerName, tblDevice.installDate  
  
  FROM tblDevice LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID LEFT JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID 
  LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID =tblDeviceDescription.ID LEFT JOIN tblDeviceStatus ON tblDevice.status 
  = tblDeviceStatus.ID LEFT JOIN tblSIMStatus ON tblDevice.SIMStatus = tblSIMStatus.ID LEFT JOIN tblInstaller ON tblDevice.installerID = tblInstaller.ID 
  WHERE tblCustomer.businessName = 'DHINSTALL' ORDER BY tblCustomer.businessName ASC, tblVehicle.regNumber ASC
  ";

    if ($sqlFILTER) {
      $sql .= $sqlFILTER;
    }

  $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result)!=0) {
      $returnString .="<div id = 'deviceSummary' class='m-4 w-2' style='margin-top: 15px;'>
      <table id='deviceListTable' class='table cell-border compact'>
      <thead>
        <tr>
          <th class='text-center align-middle'><strong>No.</strong></th>

          <th class='text-center align-middle'>TDH Number</th>
          <th class='text-center align-middle'>Reg Number</th>
          <th class='text-center align-middle'>Type</th>     
          <th class='text-center align-middle'>Serial</th>
          <th class='text-center align-middle'>IMEI</th>
          <th class='text-center align-middle'>DRID Number</th>
          <th class='text-center align-middle'>Status</th>
          <th class='text-center align-middle'>SIM Number</th>
          <th class='text-center align-middle'>SIM Status</th>
          <th class='text-center align-middle'>Config</th>
          <th class='text-center align-middle'>Original installer</th>
          <th class='text-center align-middle'>Original install Date</th> 
          <th class='text-center align-middle'>Edit</th>
          <th class='text-center align-middle'>Notes</th>
        </tr>
      </thead>
    
      <tbody>";

      $ix = 1;
      $rowBackgroundClass = '';
      
      while ($row= mysqli_fetch_array($result)) {
        
        if ($row['status']=='Faulty') {
          $rowBackgroundClass= "faulty";
      } elseif ($row['status']=='Inactive') {
          $rowBackgroundClass= "inactive";
      } else {
          $rowBackgroundClass= "";
      }

    $returnString .= "<tr class='" . $rowBackgroundClass . "'>
    <td class='text-center align-middle' style='padding:0 3px'>" . $ix . "</td>

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
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['installerName']. "</td>";

      $stringyDate = strtotime($row['installDate']);
      if(date('d/m/Y', $stringyDate)=='01/01/1970' || date('d/m/Y', $stringyDate)=='01/01/0001' || date('d/m/Y', $stringyDate)==NULL) {
        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>unknown</td>";
      } else {
        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-sort='" .$row['installDate'] ."'>" . date('d/m/Y', strtotime($row['installDate'])) . "</td>";
      }


    $returnString .="
    <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showFullDevice(\"" . $row['ID']."device\")'><i class='bi bi-pencil-fill h5'></i></btn></td>";

if ($row['deviceNote'] && $row['deviceNote']!="") {
    $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showDeviceNotes(\"" . $row['ID']."device\")'><i class='bi bi-journal-check h5'></i></btn></td></tr>";
} else {
    $returnString .="<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showDeviceNotes(\"" . $row['ID']."device\")'><i class='bi bi-journal h5'></i></btn></td></tr>";
}
 
$ix++;
}

    } else {
      $returnString .="<p class='text-center'>No results found</p>";
    }
  $returnString .="</tbody>

  <tfoot>
    <tr>
      <th class='text-center align-middle'><strong>No.</strong></th>

      <th class='text-center align-middle'>TDH Number</th>
      <th class='text-center align-middle'>Reg Number</th>
      <th class='text-center align-middle'>Type</th>     
      <th class='text-center align-middle'>Serial</th>
      <th class='text-center align-middle'>IMEI</th>
      <th class='text-center align-middle'>DRID Number</th>
      <th class='text-center align-middle'>Status</th>
      <th class='text-center align-middle'>SIM Number</th>
      <th class='text-center align-middle'>SIM Status</th>
      <th class='text-center align-middle'>Config</th>
      <th class='text-center align-middle'>Original installer</th>
      <th class='text-center align-middle'>Original install Date</th> 
      <th class='text-center align-middle'>Edit</th>
      <th class='text-center align-middle'>Notes</th>
    </tr>
  </tfoot>

  </table>

</div>
<script>
 document.getElementById('byOther').addEventListener('keypress', function (event) {
       if (event.keyCode == 13) {
            event.preventDefault();
        } 
    });

    $(document).ready(function() {
      $('#deviceListTable').DataTable({
        columnDefs: [
          {orderable: false, targets: [13,14] },
          {searchable: false, targets: [13,14] }
        ],
        processing: true,
        paging: false,
        responsive: true,
        dom: '<\"top\"iflp>rt<\"bottom\"><\"clear\">',
        rowCallback: function(row, data, dataIndex) {
          if ($('body').hasClass('dark')) {
            $(row).css('background-color', 'rgba(68,68,68,1)')
                  .css('color', 'white');
          } else {
            $(row).css('background-color', 'rgba(255,255,255,1)')
                  .css('color', 'rgba(68,68,68,1)');
        }
        if ($(row).hasClass('faulty')) {
          $(row).css('background-color', 'rgba(255,32,32,0.75)')
                  .css('color', 'rgba(255,255,255,0.75)');
        }
        if ($(row).hasClass('inactive')) {
          $(row).css('background-color', 'rgba(255,176,0,0.75)')
          .css('color', 'rgb(0,0,0,0.75)');
      }
      },
        initComplete: function() {
          this.api().columns([1,2,3,4,5,6,7,8,9,10,11,12,12]).every (function() {
            var column = this;
            var select = $('<br><select><option value=\"\"></option></select>')
            .appendTo($(column.header()))
            .on('change', function() {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              column
                .search(val ? '^'+val+'$' : '', true, false)
                .draw();
            });
  
            column.data().unique().sort().each(function (d,j) {
              select.append('<option value=\"'+d+'\">'+d+'</option>')
            });
          });
        }
      });
  });
    </script>
";


echo $returnString;

?>
