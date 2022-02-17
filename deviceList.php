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

    $sql = "SELECT COUNT(tblDevice.ID), tblDevice.status, tblDeviceStatus.status, tblDeviceStatus.isActive FROM tblDevice INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.ID GROUP BY tblDevicestatus.ID ORDER BY tblDeviceStatus.isActive DESC, tblDeviceStatus.listPosition ASC";
    $result = mysqli_query($link, $sql);
    $returnString = $returnString . "
        <div id='DeviceStats' style='font-size:120%'>";

            $devicesString = '';
            $inactiveString = '';
            if ($devices_NUMBEROF!=0) {
                $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF;
                $devicesString .="<div id='activeDevices'><strong>Active Units</strong><br>";
                while ($row = mysqli_fetch_array($result)) {
                  if ($row['COUNT(tblDevice.ID)']!=0 && $row['isActive']=='1') {
                    $devicesString = $devicesString . $row['status']. " - " . $row['COUNT(tblDevice.ID)'];

                    if ($row['status']=='Installed') {
                      $devicesString = $devicesString . " [";
                      $sql = "SELECT deviceGroup, sum(devCount) FROM (SELECT tbldevice.devicedescriptionID, tbldevicedescription.description, tbldevicedescription.deviceGroup, COUNT(tblDevice.deviceDescriptionID) AS devCount FROM tbldevice
                      INNER JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tblDeviceDescription.ID 
                      INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.id
                      WHERE tbldevicestatus.status = 'Installed' GROUP BY tbldevice.deviceDescriptionID) AS innerDevice GROUP BY innerDevice.deviceGroup";

                      $UKresult = mysqli_query($link, $sql);
                      
                      while ($Install = mysqli_fetch_array($UKresult)) {
                        if ($Install['deviceGroup']==1 && $Install['sum(devCount)']!=0) { //AI-12
                          $devicesString .= $Install['sum(devCount)'] . " = AI-12, "; 
                        }  elseif ($Install['deviceGroup']==2 && $Install['sum(devCount)']!=0) { //CP2 group 
                          $devicesString .= $Install['sum(devCount)'] . " = CP2, ";  
                        }   elseif ($Install['deviceGroup']==3 && $Install['sum(devCount)']!=0) { //CP4 group 
                          $devicesString .= $Install['sum(devCount)'] . " = CP4, ";  
                        } elseif ($Install['deviceGroup']==5 && $Install['sum(devCount)']!=0)  { // KP1
                          $devicesString .= $Install['sum(devCount)'] . " = KP1, "; 
                        }                        
                          elseif ($Install['deviceGroup']==4 && $Install['sum(devCount)']!=0)  { // others
                          $devicesString .= $Install['sum(devCount)'] . " = Other, "; 
                        }
                      }
                      $devicesString = substr($devicesString,0, -2) . "]";
                    } 




                    if (strpos($row['status'],'UK Mobile')) {
                      $devicesString = $devicesString . " [";
                      $sql = "SELECT deviceGroup, sum(devCount) FROM (SELECT tbldevice.devicedescriptionID, tbldevicedescription.description, tbldevicedescription.deviceGroup, COUNT(tblDevice.deviceDescriptionID) AS devCount FROM tbldevice
                      INNER JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tblDeviceDescription.ID 
                      INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.id
                      WHERE tbldevicestatus.status LIKE '%UK Mobile%' GROUP BY tbldevice.deviceDescriptionID) AS innerDevice GROUP BY innerDevice.deviceGroup";

                      $UKresult = mysqli_query($link, $sql);
                      
                      while ($UKMI = mysqli_fetch_array($UKresult)) {
                        if ($UKMI['deviceGroup']==1 && $UKMI['sum(devCount)']!=0) { //AI-12
                          $devicesString .= $UKMI['sum(devCount)'] . " = AI-12, "; 
                        }  elseif ($UKMI['deviceGroup']==2 && $UKMI['sum(devCount)']!=0) { //CP2 group 
                          $devicesString .= $UKMI['sum(devCount)'] . " = CP2, ";  
                        }   elseif ($UKMI['deviceGroup']==3 && $UKMI['sum(devCount)']!=0) { //CP4 group 
                          $devicesString .= $UKMI['sum(devCount)'] . " = CP4, ";  
                        } elseif ($UKMI['deviceGroup']==5 && $UKMI['sum(devCount)']!=0)  { // KP1
                          $devicesString .= $UKMI['sum(devCount)'] . " = KP1, ";   
                        } elseif ($UKMI['deviceGroup']==4 && $UKMI['sum(devCount)']!=0)  { // others
                          $devicesString .= $UKMI['sum(devCount)'] . " = Other, "; 
                        }
                      }
                      $devicesString = substr($devicesString,0, -2) . "]";
                    } 
                    $devicesString .= "<br>";
                  }
                  if ($row['COUNT(tblDevice.ID)']!=0 && $row['isActive']=='0') {
                    $inactiveString = $inactiveString . $row['status']. " - " . $row['COUNT(tblDevice.ID)'] . "<br>";
                  }
                }
                $devicesString .="</div><div id='inactiveDevices'><strong>Inactive Units</strong><br>";
                $devicesString .= $inactiveString ."</div>";
              } 

            $returnString = $returnString . $devicesString;
            $returnString = $returnString . "
        </div><br>";

$returnString .= "
<div class='container'>
  <div id='deviceFilter' style='display: none'>
    <div class='input-group'>
      <input type='text' style='font-size:75%; padding: 5px;' id='byOther' value='" . $_POST['FilterOtherTerm'] . "'/>
    </div>
  </div>
</div>
";

  $sql = 'SELECT tblDevice.ID, tblDevice.ownerID, tblDevice.TDHNumber, tblDevice.serialNumber, tblDevice.IMEI, tblDevice.DRIDNumber, 
  tblDevice.SIMNumber, tblDevice.SIMPhone, tblDevice.SIMDeactivationDate, tblDevice.config, tblDevice.deviceNote, tblDeviceStatus.status, tblVehicle.regNumber, 
  tblCustomer.businessName, tblDeviceDescription.description, tblSIMStatus.SIMStatus, tblInstaller.installerName, tblDevice.installDate, tblDevice.scheduledDate
  
  FROM tblDevice LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID LEFT JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID 
  LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID =tblDeviceDescription.ID LEFT JOIN tblDeviceStatus ON tblDevice.status 
  = tblDeviceStatus.ID LEFT JOIN tblSIMStatus ON tblDevice.SIMStatus = tblSIMStatus.ID LEFT JOIN tblInstaller ON tblDevice.installerID = tblInstaller.ID
  ORDER BY tblCustomer.businessName ASC, tblVehicle.regNumber IS NOT TRUE, tblVehicle.regNumber ASC
  ';

    if ($sqlFILTER) {
      $sql .= $sqlFILTER;
    }

  $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result)!=0) {
      $returnString .="<div id = 'deviceSummary' class='m-4 w-2' style='margin-top: 15px;'>
      <table id='deviceListTable' class='table cell-border table-sm table-striped compact'>
      <thead>
        <tr>
          <!--<th class='text-center align-middle'><strong>No.</strong></th>-->
          <th class='align-middle'><strong>Owner</strong></th>
         
          <th class='text-center align-middle'>Reg Number</th>
          <th class='text-center align-middle'>Type</th>     
          <th class='text-center align-middle'>Serial</th>
          <th class='text-center align-middle'>IMEI</th>
          <th class='text-center align-middle'>DRID Number</th>
          <th class='text-center align-middle'>Status</th>
          <th class='text-center align-middle'>SIM Number</th>
          <th class='text-center align-middle'>SIM Phone</th>
          <th class='text-center align-middle'>Deactivation Date</th>
          <th class='text-center align-middle'>SIM Status</th>
          <th class='text-center align-middle'>Config</th>
          <th class='text-center align-middle'>Original installer</th>
          <th class='text-center align-middle'>Original install Date</th> 
          <th class='text-center align-middle'>Edit</th>
          <th class='text-center align-middle'>Notes</th>
          <th class='text-center align-middle'>Hide</th>

          </tr>
      </thead>
    
      <tbody>";

      // $ix = 1;
      $rowBackgroundClass = '';
      
      while ($row= mysqli_fetch_array($result)) {
        switch ($row['status']) {
          case 'Faulty':
          case 'Stolen':
          case 'Sold':
            $rowBackgroundClass= "faulty";
            break;
          case 'Inactive':
            $rowBackgroundClass= "inactive";        
            break;
          default:
            $rowBackgroundClass= "";
            break;
        }
      //   if ($row['status']=='Faulty') {
      //     $rowBackgroundClass= "faulty";
      // } elseif ($row['status']=='Inactive') {
      //     $rowBackgroundClass= "inactive";
      // } else {
      //     $rowBackgroundClass= "";
      // }

      $returnString .= "<tr class='" . $rowBackgroundClass . "'>
     
      <td class='align-middle' style='padding:0 3px'>" . $row['businessName'] . "</td>
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['regNumber']. "</td>
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['description']. "</td>  
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['serialNumber']. "</td>
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['IMEI']. "</td>
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['DRIDNumber']. "</td>
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['status']. "</td>
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['SIMNumber']. "</td>
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['SIMPhone']. "</td>";

      $simDate =  date('d/m/Y', strtotime($row['scheduledDate']));
      if ($simDate=='' || $simDate==null || $simDate=='01/01/1970') {
        $simDate = '';
        $returnString .="<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>" .$simDate . "</td>";
      } else {
        $returnString .="<td class='text-center align-middle' style='padding:0 3px;' data-order=" . date('Y-m-d', strtotime($row['scheduledDate'])) . ">" .$simDate . "</td>";
      }
      $returnString .="
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['SIMStatus']. "</td>
      <td class='align-middle' style='padding:0 3px;'>" . $row['config']. "</td>
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['installerName']. "</td>";

      $stringyDate = strtotime($row['installDate']);
      if(date('d/m/Y', $stringyDate)=='01/01/1970' || date('d/m/Y', $stringyDate)=='01/01/0001' || date('d/m/Y', $stringyDate)==NULL) {
        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>unknown</td>";
      } else {
        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order=" .date('Y-m-d', strtotime($row['installDate'])) .">" . date('d/m/Y', strtotime($row['installDate'])) . "</td>";
      }

       $returnString .="
       <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showFullDevice(\"" . $row['ID']."device\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
       <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
       </svg></btn></td>";

if ($row['deviceNote'] && $row['deviceNote']!="") {
     $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showDeviceNotes(\"" . $row['ID']."device\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal-check' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z'/><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
} else {
     $returnString .="<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showDeviceNotes(\"" . $row['ID']."device\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal' viewBox='0 0 16 16'><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
}

$hiddenVRN = $row['regNumber'];
if ($row['regNumber']=='') {
  $hiddenVRN = 'zzzzzzzzzz';
}
$returnString .="<td class='text-center align-middle'>" . $hiddenVRN . "</td></tr>";

// $ix++;
}

    } else {
      $returnString .="<p class='text-center'>No results found</p>";
    }
  $returnString .="</tbody>

  <tfoot>
    <tr>
     <!--<th class='text-center align-middle'><strong>No.</strong></th>-->
      <th class='align-middle'><strong>Owner</strong></th>
      
      <th class='text-center align-middle'>Reg Number</th>
      <th class='text-center align-middle'>Type</th>     
      <th class='text-center align-middle'>Serial</th>
      <th class='text-center align-middle'>IMEI</th>
      <th class='text-center align-middle'>DRID Number</th>
      <th class='text-center align-middle'>Status</th>
      <th class='text-center align-middle'>SIM Number</th>
      <th class='text-center align-middle'>SIM Phone</th>
      <th class='text-center align-middle'>Deactivation Date</th>
      <th class='text-center align-middle'>SIM Status</th>
      <th class='text-center align-middle'>Config</th>
      <th class='text-center align-middle'>Original installer</th>
      <th class='text-center align-middle'>Original install Date</th> 
      <th class='text-center align-middle'>Edit</th>
      <th class='text-center align-middle'>Notes</th>
      <th class='text-center align-middle'>Hide</th>
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
          {'visible': false, 'targets': [16] },
          {'orderable': false, 'targets': [14,15,16] },
          {'searchable': false, 'targets': [14,15,16] }
        ],
        order: [[0, 'asc'], [1,'asc']],
        processing: true,
        fixedHeader: true,
        pagingType: 'numbers',
        lengthMenu: [[50, 100, 250, 500, -1], [50, 100, 250, 500, 'All']],
        deferRender: true,
        responsive: true,
        dom: '<\"top\"lfip>rt<\"bottom\"><\"clear\">',
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
      initComplete: function () {
        count = 0;
        this.api().columns([0,1,2,3,4,5,6,7,8,9,10,11,12,13]).every( function () {
            var title = this.header();
            title = $(title).html().replace(/[\W]/g, '-');
            var column = this;
            var lineBreak = $('<br>')
            .appendTo( $(column.header()));
            var select = $('<select id=\"' + title + '\" class=\"select2\" style=\"width:100%\" ></select>')
                .appendTo( $(column.header()))
                .on( 'change', function () {
                  var data = $.map( $(this).select2('data'), function( value, key ) {
                    return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                             });       
                  if (data.length === 0) {
                    data = [\"\"];
                  }
                  var val = data.join('|');
                  column
                        .search( val ? val : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value=\"'+d+'\">'+d+'</option>' );
            } );
          
          //use column title as selector and placeholder
          $('#' + title).select2({
            multiple: true,
            closeOnSelect: false,
            placeholder: \"\"
          });
          
          //initially clear select otherwise first option is selected
          $('.select2').val(null).trigger('change');
        } );
    },
      });
  });
    </script>
";


echo $returnString;

?>
