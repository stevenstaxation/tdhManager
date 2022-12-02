<?php
session_start();
include 'connect.php';

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
if ($devices_NUMBEROF != 0) {
    $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF;

    $devicesString .= "<div id='activeDevices'><strong>Active Units</strong><br>";
    while ($row = mysqli_fetch_array($result)) {
        if ($row['COUNT(tblDevice.ID)'] != 0 && $row['isActive'] == '1') {
            $devicesString = $devicesString . $row['status'] . " - " . $row['COUNT(tblDevice.ID)'];

            if ($row['status'] == 'Installed') {
                $devicesString = $devicesString . " [";
                $sql = "SELECT deviceGroup, sum(devCount) FROM (SELECT tbldevice.devicedescriptionID, tbldevicedescription.description, tbldevicedescription.deviceGroup, COUNT(tblDevice.deviceDescriptionID) AS devCount FROM tbldevice
                      INNER JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tblDeviceDescription.ID
                      INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.id
                      WHERE tbldevicestatus.status = 'Installed' GROUP BY tbldevice.deviceDescriptionID) AS innerDevice GROUP BY innerDevice.deviceGroup";

                $UKresult = mysqli_query($link, $sql);

                while ($Install = mysqli_fetch_array($UKresult)) {
                    if ($Install['deviceGroup'] == 1 && $Install['sum(devCount)'] != 0) { //AI-12
                        $devicesString .= $Install['sum(devCount)'] . " = AI-12, ";
                    } elseif ($Install['deviceGroup'] == 2 && $Install['sum(devCount)'] != 0) { //CP2 group
                        $devicesString .= $Install['sum(devCount)'] . " = CP2, ";
                    } elseif ($Install['deviceGroup'] == 3 && $Install['sum(devCount)'] != 0) { //CP4 group
                        $devicesString .= $Install['sum(devCount)'] . " = CP4, ";
                    } elseif ($Install['deviceGroup'] == 5 && $Install['sum(devCount)'] != 0) { // KP1
                        $devicesString .= $Install['sum(devCount)'] . " = KP1, ";
                    } elseif ($Install['deviceGroup'] == 4 && $Install['sum(devCount)'] != 0) { // others
                        $devicesString .= $Install['sum(devCount)'] . " = Other, ";
                    }
                }
                $devicesString = substr($devicesString, 0, -2) . "]";
            }

            if (strpos($row['status'], 'Hub')) {
                $devicesString = $devicesString . " [";
                $sql = "SELECT deviceGroup, sum(devCount) FROM (SELECT tbldevice.devicedescriptionID, tbldevicedescription.description, tbldevicedescription.deviceGroup, COUNT(tblDevice.deviceDescriptionID) AS devCount FROM tbldevice
                      INNER JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tblDeviceDescription.ID
                      INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.id
                      WHERE tbldevicestatus.status LIKE '%In Hub%' GROUP BY tbldevice.deviceDescriptionID) AS innerDevice GROUP BY innerDevice.deviceGroup";

                $UKresult = mysqli_query($link, $sql);

                while ($UKMI = mysqli_fetch_array($UKresult)) {
                    if ($UKMI['deviceGroup'] == 1 && $UKMI['sum(devCount)'] != 0) { //AI-12
                        $devicesString .= $UKMI['sum(devCount)'] . " = AI-12, ";
                    } elseif ($UKMI['deviceGroup'] == 2 && $UKMI['sum(devCount)'] != 0) { //CP2 group
                        $devicesString .= $UKMI['sum(devCount)'] . " = CP2, ";
                    } elseif ($UKMI['deviceGroup'] == 3 && $UKMI['sum(devCount)'] != 0) { //CP4 group
                        $devicesString .= $UKMI['sum(devCount)'] . " = CP4, ";
                    } elseif ($UKMI['deviceGroup'] == 5 && $UKMI['sum(devCount)'] != 0) { // KP1
                        $devicesString .= $UKMI['sum(devCount)'] . " = KP1, ";
                    } elseif ($UKMI['deviceGroup'] == 4 && $UKMI['sum(devCount)'] != 0) { // others
                        $devicesString .= $UKMI['sum(devCount)'] . " = Other, ";
                    }
                }
                $devicesString = substr($devicesString, 0, -2) . "]";
            }

            if (strpos($row['status'], 'UK Mobile')) {
                $devicesString = $devicesString . " [";
                $sql = "SELECT deviceGroup, sum(devCount) FROM (SELECT tbldevice.devicedescriptionID, tbldevicedescription.description, tbldevicedescription.deviceGroup, COUNT(tblDevice.deviceDescriptionID) AS devCount FROM tbldevice
                      INNER JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tblDeviceDescription.ID
                      INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.id
                      WHERE tbldevicestatus.status LIKE '%UK Mobile%' GROUP BY tbldevice.deviceDescriptionID) AS innerDevice GROUP BY innerDevice.deviceGroup";

                $UKresult = mysqli_query($link, $sql);

                while ($UKMI = mysqli_fetch_array($UKresult)) {
                    if ($UKMI['deviceGroup'] == 1 && $UKMI['sum(devCount)'] != 0) { //AI-12
                        $devicesString .= $UKMI['sum(devCount)'] . " = AI-12, ";
                    } elseif ($UKMI['deviceGroup'] == 2 && $UKMI['sum(devCount)'] != 0) { //CP2 group
                        $devicesString .= $UKMI['sum(devCount)'] . " = CP2, ";
                    } elseif ($UKMI['deviceGroup'] == 3 && $UKMI['sum(devCount)'] != 0) { //CP4 group
                        $devicesString .= $UKMI['sum(devCount)'] . " = CP4, ";
                    } elseif ($UKMI['deviceGroup'] == 5 && $UKMI['sum(devCount)'] != 0) { // KP1
                        $devicesString .= $UKMI['sum(devCount)'] . " = KP1, ";
                    } elseif ($UKMI['deviceGroup'] == 4 && $UKMI['sum(devCount)'] != 0) { // others
                        $devicesString .= $UKMI['sum(devCount)'] . " = Other, ";
                    }
                }
                $devicesString = substr($devicesString, 0, -2) . "]";
            }

            if (strpos($row['status'], 'Charlie')) {

                $devicesString = $devicesString . " [";
                $sql = "SELECT deviceGroup, sum(devCount) FROM (SELECT tbldevice.devicedescriptionID, tbldevicedescription.description, tbldevicedescription.deviceGroup, COUNT(tblDevice.deviceDescriptionID) AS devCount FROM tbldevice
                      INNER JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tblDeviceDescription.ID
                      INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.id
                      WHERE tbldevicestatus.status LIKE '%Charlie%' GROUP BY tbldevice.deviceDescriptionID) AS innerDevice GROUP BY innerDevice.deviceGroup";

                $UKresult = mysqli_query($link, $sql);

                while ($UKMI = mysqli_fetch_array($UKresult)) {
                    if ($UKMI['deviceGroup'] == 1 && $UKMI['sum(devCount)'] != 0) { //AI-12
                        $devicesString .= $UKMI['sum(devCount)'] . " = AI-12, ";
                    } elseif ($UKMI['deviceGroup'] == 2 && $UKMI['sum(devCount)'] != 0) { //CP2 group
                        $devicesString .= $UKMI['sum(devCount)'] . " = CP2, ";
                    } elseif ($UKMI['deviceGroup'] == 3 && $UKMI['sum(devCount)'] != 0) { //CP4 group
                        $devicesString .= $UKMI['sum(devCount)'] . " = CP4, ";
                    } elseif ($UKMI['deviceGroup'] == 5 && $UKMI['sum(devCount)'] != 0) { // KP1
                        $devicesString .= $UKMI['sum(devCount)'] . " = KP1, ";
                    } elseif ($UKMI['deviceGroup'] == 4 && $UKMI['sum(devCount)'] != 0) { // others
                        $devicesString .= $UKMI['sum(devCount)'] . " = Other, ";
                    }
                }
                $devicesString = substr($devicesString, 0, -2) . "]";
            }

            if (strpos($row['status'], 'Jimmy')) {

                $devicesString = $devicesString . " [";
                $sql = "SELECT deviceGroup, sum(devCount) FROM (SELECT tbldevice.devicedescriptionID, tbldevicedescription.description, tbldevicedescription.deviceGroup, COUNT(tblDevice.deviceDescriptionID) AS devCount FROM tbldevice
                      INNER JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tblDeviceDescription.ID
                      INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.id
                      WHERE tbldevicestatus.status LIKE '%Jimmy%' GROUP BY tbldevice.deviceDescriptionID) AS innerDevice GROUP BY innerDevice.deviceGroup";

                $UKresult = mysqli_query($link, $sql);

                while ($UKMI = mysqli_fetch_array($UKresult)) {
                    if ($UKMI['deviceGroup'] == 1 && $UKMI['sum(devCount)'] != 0) { //AI-12
                        $devicesString .= $UKMI['sum(devCount)'] . " = AI-12, ";
                    } elseif ($UKMI['deviceGroup'] == 2 && $UKMI['sum(devCount)'] != 0) { //CP2 group
                        $devicesString .= $UKMI['sum(devCount)'] . " = CP2, ";
                    } elseif ($UKMI['deviceGroup'] == 3 && $UKMI['sum(devCount)'] != 0) { //CP4 group
                        $devicesString .= $UKMI['sum(devCount)'] . " = CP4, ";
                    } elseif ($UKMI['deviceGroup'] == 5 && $UKMI['sum(devCount)'] != 0) { // KP1
                        $devicesString .= $UKMI['sum(devCount)'] . " = KP1, ";
                    } elseif ($UKMI['deviceGroup'] == 4 && $UKMI['sum(devCount)'] != 0) { // others
                        $devicesString .= $UKMI['sum(devCount)'] . " = Other, ";
                    }
                }
                $devicesString = substr($devicesString, 0, -2) . "]";
            }

            $devicesString .= "<br>";

        }
        if ($row['COUNT(tblDevice.ID)'] != 0 && $row['isActive'] == '0') {
            $inactiveString = $inactiveString . $row['status'] . " - " . $row['COUNT(tblDevice.ID)'] . "<br>";
        }
    }
    $devicesString .= "</div><div id='inactiveDevices'><strong>Inactive Units</strong><br>";
    $devicesString .= $inactiveString . "</div>";
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

echo $returnString;

?>


<div id = 'deviceSummary' class='m-4 w-2' style='margin-top: 15px;'>
      <table id='deviceListTable' class='table cell-border table-sm display compact' style='width: 100%'>
        <thead>
            <tr>
                <th class='align-middle'><strong>Owner</strong></th>
                <th class='text-center align-middle'>Reg Number</th>
                <th class='text-center align-middle'>Type</th>
                <th class='text-center align-middle'>Platform</th>
                <th class='text-center align-middle'>Serial</th>
                <th class='text-center align-middle'>IMEI</th>
                <th class='text-center align-middle'>DRID Number</th>
                <th class='text-center align-middle'>Config</th>
                <th class='text-center align-middle'>Status</th>
                <th class='text-center align-middle'>SIM Number</th>
                <th class='text-center align-middle'>SIM Phone</th>
                <th class='text-center align-middle'>Deactivation Date</th>
                <th class='text-center align-middle'>SIM Status</th>
                <th class='text-center align-middle'>Original installer</th>    
                <th class='text-center align-middle'>Original install Date</th>
                <th class='text-center align-middle'>Edit</th>
                <th class='text-center align-middle'>Notes</th>
                <th class='text-center align-middle' style='display: none'>Hide</th>
                <th class='text-center align-middle' style='display: none'>Hide Notes</th>
                <th class='text-center align-middle' style='display: none'>updatePlatform</th>
                <th class='text-center align-middle' style='display: none'>updateConfig</th>
                <th class='text-center align-middle' style='display: none'>updateVCO</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class='align-middle'><strong>Owner</strong></th>
                <th class='text-center align-middle'>Reg Number</th>
                <th class='text-center align-middle'>Type</th>
                <th class='text-center align-middle'>Platform</th>
                <th class='text-center align-middle'>Serial</th>
                <th class='text-center align-middle'>IMEI</th>
                <th class='text-center align-middle'>DRID Number</th>
                <th class='text-center align-middle'>Config</th>
                <th class='text-center align-middle'>Status</th>
                <th class='text-center align-middle'>SIM Number</th>
                <th class='text-center align-middle'>SIM Phone</th>
                <th class='text-center align-middle'>Deactivation Date</th>
                <th class='text-center align-middle'>SIM Status</th>
                <th class='text-center align-middle'>Original installer</th>
                <th class='text-center align-middle'>Original install Date</th>
                <th class='text-center align-middle'>Edit</th>
                <th class='text-center align-middle'>Notes</th>
                <th class='text-center align-middle' style='display: none'>Hide</th>
                <th class='text-center align-middle' style='display: none'>Hide Notes</th>
                <th class='text-center align-middle' style='display: none'>updatePlatform</th>
                <th class='text-center align-middle' style='display: none'>updateConfig</th>
                <th class='text-center align-middle' style='display: none'>updateVCO</th>
            </tr>
        </tfoot>
    </table>
</div>

    <script>
$(document).ready(function () {
    $('#deviceListTable').DataTable({
        'stateSave': true,
        'processing': true,
        'serverSide': true,
        'order': [[0, 'asc'], [1,'asc']],
        'pagingType': 'numbers',
        'lengthMenu': [[5,10,25,50, 100, 250, 500, -1], [5,10,25,50, 100, 250, 500, 'All']],
        'fixedHeader': true,
        'deferRender': true,
        'responsive': true,
        'orderClasses': false,
        'ajax': {
            url: 'fetch.php',
            type: "POST"
        },
        'columnDefs': [
            {'orderable': false, 'targets': [15,16,17,18,19,20,21]},
            {'searchable': false, 'targets': [15,16,17,19,20,21]},
            {'targets': [17,18,19,20,21], className: 'noVis'},
            {'targets': [17,18,19,20,21], className: 'never'}
        ],
        'dom': '<\"top\"Blfp>rt<\"bottom\"lfip><\"clear\">',
        'buttons': [
            { extend: 'colvis',
              columns: ':not(.noVis)'
            },
            'spacer',
          { extend: 'csv',
            header: false,
            exportOptions: {
              columns: ':visible'
            },
          },
          { extend: 'excel',
            header: false,
            exportOptions: {
              columns: ':visible',
            },
          },
          'spacer',
          { extend: 'pdf',
            header: false,
            orientation: 'landscape',
            exportOptions: {
              columns: ':visible',
            },
          },
        ],
        rowCallback: function(row, data, dataIndex) {
          if ($('body').hasClass('dark')) {
            $(row).css('background-color', 'rgba(68,68,68,1)')
                  .css('color', 'white');
          } else {
            $(row).css('background-color', 'rgba(255,255,255,1)')
                  .css('color', 'rgba(68,68,68,1)');
        }
    }
    });
});
    </script>
    
  
</body>

</html>

