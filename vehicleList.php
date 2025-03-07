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
if (!isset($_POST['FilterVRN'])) {
  $_POST['FilterVRN'] = '';
}
if (!isset($_POST['FilterTDHNumber'])) {
  $_POST['FilterTDHNumber'] = '';
}
$returnString = "<div class='container'><div id='alertLogList' class='listHeader'><h4><strong>Vehicles</strong></h4></div>";

$sql = "SELECT * FROM tblVehicle ORDER BY tblVehicle.regNumber ASC";
$deviceResult = mysqli_query($link, $sql);
$vehicles_NUMBEROF = mysqli_num_rows($deviceResult);

$sql = "SELECT COUNT(tblVehicle.ID), tblVehicle.vehicleStatus FROM tblVehicle GROUP BY tblVehicle.vehicleStatus";
$result = mysqli_query($link, $sql);

if ($vehicles_NUMBEROF != 0) {
  $vehiclesString = "Total Vehicles: " . $vehicles_NUMBEROF . " (";
  while ($row = mysqli_fetch_array($result)) {
    if ($row['COUNT(tblVehicle.ID)'] != 0) {
      switch ($row['vehicleStatus']) {
        case '0':
          $statusDescription = 'N/A';
          break;
        case '1':
          $statusDescription = 'Pending';
          break;
        case '2':
          $statusDescription = 'Installed';
          break;
        default:
          break;
      }
      $vehiclesString .= $row['COUNT(tblVehicle.ID)'] . " " . $statusDescription . ", ";
    }
  }

  $vehiclesString = substr($vehiclesString, 0, -2);
  $vehiclesString .= ")";
} else {
  $vehiclesString .= "Total Vehicles: " . $vehicles_NUMBEROF;
}

$returnString .= $vehiclesString;
$returnString .= "
    </div><br>";

$returnString .= "<div class='container'>";

$returnString .= "</form>
</div>";

// $sql = 'SELECT * FROM tblVehicle INNER JOIN tblDevice ON tblDevice.vehicleID = tblVehicle.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID';

$sql = 'SELECT *, tblVehicle.ID as VRNID FROM tblVehicle LEFT JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID ORDER BY tblCustomer.businessName ASC, tblVehicle.regNumber ASC';

if ($sqlFILTER) {
  $sql .= $sqlFILTER;
}

$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) != 0) {
  $returnString .= "<div id = 'vehicleSummary' class='w-auto ml-auto mr-auto' style='margin-top: 15px;'>
<table id='vehicleListTable' class='table cell-border table-sm compact'>
<thead>
  <tr class='text-center align-middle'>

    <th class='text-left' style='padding-left: 8px;'>Customer</th>
    <th>Reg Number</th>
    <th>Camera Required</th>
    <th>Status</th>
    <th>Install Date</th>
    <th>Date Added</th>
    <th style='width:5%'>Edit</th>
    <th style='width:5%'>Notes</th>
  
  </tr>
</thead>

<tbody>";

  // $ix = 1;
  while ($row = mysqli_fetch_array($result)) {
    $returnString .= "<tr>

    <td class='align-middle' style='padding-left: 10px;'>" . $row['businessName'] . "</td>
    <td class='text-center align-middle'>" . $row['regNumber'] . "</td>";
    if ($row['cameraRequired'] == '1') {
      $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img src='images/green_tick_16.png'/><span style='display:none;'>green_tick</span></td>";
    } else {
      $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img src='images/red_cross_16.png'/><span style='display:none;'>red_cross</span></td>";
    }
    if ($row['vehicleStatus'] == '2') {
      $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img src='images/green_tick_16.png'/><span style='display:none;'>green_tick</span></td>";
    } else if ($row['vehicleStatus'] == '1') {
      $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img src='images/blue_ellipsis_16.png'/><span style='display:none;'>blue_ellipsis</span></td>";
    } else {
      $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img src='images/red_cross_16.png'/><span style='display:none;'>red_cross</span></td>";
    }

    $stringyDate = strtotime($row['installDate'] ?? '');
    if (date('d/m/Y', $stringyDate) == '01/01/1970' || date('d/m/Y', $stringyDate) == '01/01/0001' || date('d/m/Y', $stringyDate) == null) {
      $sql = "SELECT tblJobs.ID,tblJobs.date,tblJobs.VRN,tblJobs.status from tblJobs WHERE tblJobs.VRN = '" . $row['VRNID'] . "' AND tblJobs.status<=2 LIMIT 1";
      $jobresult = mysqli_query($link, $sql);
      if (mysqli_num_rows($jobresult) == 0) {
        $returnString .= "<td class='text-center align-middle'>TBC</td>";
      } else {
        $jobrow = mysqli_fetch_array($jobresult);
        $jobdate = strtotime($jobrow['date'] ?? '');
        if (date("d/m/Y", $jobdate) == "01/01/1970" || date("d/m/Y", $jobdate) == "01/01/0001" || date("d/m/Y", $jobdate) == null) {
          $returnString .= "<td class='text-center align-middle' style='color:yellow'>TBD</td>";
        } else {
          $returnString .= "<td class='text-center align-middle' style='color:yellow'>" . date("d/m/Y", $jobdate) . "</td>";
        }
      }
    } else {
      $returnString .= "<td class='text-center align-middle' data-order=" . date('Y-m-d', $stringyDate) . ">" . date('d/m/Y', $stringyDate) . "</td>";
    }

    $stringyDate = strtotime($row['dateAdded'] ?? '');
    // if camera is required, status is pending and a job is booked - show booked date in orange
    // if camera is required, status is pending and a job is NOT booked - show added date in red
    // if camera is required and status is installed, show date added
    // if camera is required and status is N/A, show date added in green (for now)

    // if camera is not required, show date as N/A
    if ($row['cameraRequired'] != 1) {
      $returnString .= "<td class='text-center align-middle'>N/A</td>";
    } else {
      // if (date('d/m/Y', $stringyDate) == '01/01/1970' || date('d/m/Y', $stringyDate) == '01/01/0001' || date('d/m/Y', $stringyDate) == null) {
      $stringyDate2 = date('d/m/Y', $stringyDate);
      if ($stringyDate2 == '01/01/1970' || $stringyDate2 == '01/01/0001' || $stringyDate2 == null) {
        $stringyDate2 = "none recorded";
      }

      if ($row['vehicleStatus'] == 2) {
        $returnString .= "<td class='text-center align-middle' data-order=" . date('Y-m-d', $stringyDate) . ">" . $stringyDate2 . "</td>";
      } elseif ($row['vehicleStatus'] == 0) {
        $returnString .= "<td class='text-center align-middle' style='color: green' data-order=" . date('Y-m-d', $stringyDate) . ">" . $stringyDate2 . "</td>";
      } elseif ($row['vehicleStatus'] == 1) {
        // date added not recorded, but if a job is booked, show the booked date 
        $sql = "SELECT tblJobs.ID,tblJobs.date,tblJobs.VRN,tblJobs.status from tblJobs WHERE tblJobs.VRN = '" . $row['VRNID'] . "' LIMIT 1";
        $jobresult = mysqli_query($link, $sql);
        if (mysqli_num_rows($jobresult) == 0) {  // job not booked
          $returnString .= "<td class='text-center align-middle' style='color: red' data-order=" . date('Y-m-d', $stringyDate) . ">" . $stringyDate2 . "</td>";
        } else {
          $jobrow = mysqli_fetch_array($jobresult);
          $jobdate = strtotime($jobrow['date'] ?? $stringyDate);
          if (date('d/m/Y', $jobdate) == '01/01/1970' || date('d/m/Y', $jobdate) == '01/01/0001' || date('d/m/Y', $jobdate) == null) {
            $jobdate = "none recorded";
          }
          if ($jobdate == 'none recorded') {
            $returnString .= "<td class='text-center align-middle' style='color: orange' data-order=0>" . $jobdate  . "</td>";
          } else {
            $returnString .= "<td class='text-center align-middle' style='color: orange' data-order=" . date('Y-m-d', $jobdate) . ">" .  date('d/m/Y', $jobdate) . "</td>";
          }
        }
      } else {
        $returnString .= "<td class='text-center align-middle'>Dunno</td>";
      }
    }

    $returnString .= "
    <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showVehicleForEdit(\"" . $row[0] . "vehicle\")'><i class='bi bi-pencil-fill h5'></i></btn></td>";

    if ($row['vehicleNotes'] && $row['vehicleNotes'] != "") {
      $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showVehicleNotes(\"" . $row[0] . "vehicle\")'><i class='bi bi-journal-check h5'></i></btn></td>";
    } else {
      $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showVehicleNotes(\"" . $row[0] . "vehicle\")'><i class='bi bi-journal h5'></i></btn></td>";
    }

    $returnString .= "</tr>";
    // $ix++;
  }
} else {
  $returnString .= "<p class='text-center'>No results found</p>";
}

$returnString .= "</tbody>
<tfoot>
  <tr class='text-center align-middle'>
    <th class='text-left' style='padding-left: 8px;'>Customer</th>
    <th>Reg Number</th>
    <th>Camera Required</th>
    <th>Status</th>
    <th>Install Date</th>
    <th>Date Added</th>
    <th style='width:5%'>Edit</th>
    <th style='width:5%'>Notes</th>
  </tr>
</tfoot>

</table>

</div>
</div>
<script>


    $(document).ready(function() {
      $('#vehicleListTable').DataTable({
        retrieve: true,
        columnDefs: [
          {orderable: false, targets: [6,7] },
          {searchable: false, targets: [6,7] },       
        ],
        processing: true,
        responsive: true,
        fixedHeader: true,
        pagingType: 'numbers',
        lengthMenu: [[50, 100, 250, 500, -1], [50, 100, 250, 500, 'All']],
        deferRender: true,
        stateSave: true,
        select: {
          style: 'os',
          items: 'cell'
        },
        dom: '<\"top\"lf>rt<\"bottom\"ipB><\"clear\">',
        buttons: [
          'colvis',
          'spacer',
          { extend: 'csv',
            header: false,
            exportOptions: {
              columns: ':visible',
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

";

echo $returnString;
