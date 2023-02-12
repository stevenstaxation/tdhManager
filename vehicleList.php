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
// $returnString .= "<div id='vehicleFilter'>
//     <form id='vehicleForm' class='filterBox' style='display: none'>
//     <div id='vehicleFilters' class='settings-dialog' style='border-width: 1px; border-style: solid; padding: 5px; width:100%' onSubmit='return false;'>
//         <div class='form-group'>
//           <div class='row'>
//             <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
//               <label for='byCustomer'>Customer</label>
//                <div class='input-group'>
//                   <select style='font-size: 75%' id='getCustomerSelect' name='getCustomerSelect' class='custom-select getCustomerSelect'>";

// $sql = "SELECT ID, businessName FROM tblCustomer ORDER BY businessName ASC";
// $result = mysqli_query($link, $sql);

// $returnString .= "<option value= '0' selected='selected'>All customers</option>";

// while ($customerRow = mysqli_fetch_array($result)) {
//     if ($_POST['FilterCustomer'] == $customerRow['ID']) {
//         $returnString .= "<option value= '" . $customerRow['ID'] . "' selected='selected'>";
//     } else {
//         $returnString .= "<option value= '" . $customerRow['ID'] . "'>";
//     }
//     $returnString .= $customerRow['businessName'] . " </option>";
// }

// $returnString .= "
//                   </select>
//                  </div>
//             </div>
//             <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
//               <label for='byInsurer'>Insurer</label>
//                <div class='input-group'>
//                   <select style='font-size: 75%' id='getInsurerSelect' name='getInsurerSelect' class='custom-select getInsurerSelect'>";

// $sql = "SELECT ID, insurerName FROM tblInsurer ORDER BY insurerName ASC";
// $result = mysqli_query($link, $sql);

// $returnString .= "<option value= '0' selected='selected'>All insurers</option>";

// while ($insurerRow = mysqli_fetch_array($result)) {
//     if ($_POST['FilterInsurer'] == $insurerRow['ID']) {
//         $returnString .= "<option value= '" . $insurerRow['ID'] . "' selected='selected'>";
//     } else {
//         $returnString .= "<option value= '" . $insurerRow['ID'] . "'>";
//     }
//     $returnString .= $insurerRow['insurerName'] . " </option>";
// }

// $returnString .= "
//                   </select>
//                  </div>
//             </div>
//             <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 10px'>
//               <label for='VRNToLookup'>Search Term</label>
//               <div class='input-group'>
//                 <input type='text' style='font-size: 75%; padding: 5px;' id='VRNToLookup' value='" . $_POST['FilterVRN'] . "' />
//               </div>
//             </div>

//             <div class='col-sm-6 col-md-4 col-lg-3' style ='padding-left:15px; padding-top: 32px;'>
//               <btn type='button' class='btn btn-success' id='vehicleFilterClicked' style='border-radius: 5px;'>Apply Filter</button>
//             </div>
//           </div>
//         </div>";
$returnString .= "</form>
</div>";

// $sql = 'SELECT * FROM tblVehicle INNER JOIN tblDevice ON tblDevice.vehicleID = tblVehicle.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID';

$sql = 'SELECT * FROM tblVehicle LEFT JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID ORDER BY tblCustomer.businessName ASC, tblVehicle.regNumber ASC';

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
            $returnString .= "<td class='text-center align-middle'>TBC</td>";
        } else {
            $returnString .= "<td class='text-center align-middle' data-order=" . date('Y-m-d', $stringyDate) . ">" . date('d/m/Y', $stringyDate) . "</td>";
        }

        $returnString .= "
    <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showVehicleForEdit(\"" . $row[0] . "vehicle\")'><svg xmlns='http://www.w3.org/2000/svg' width='12px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg></btn></td>";

        if ($row['vehicleNotes'] && $row['vehicleNotes'] != "") {
            $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showVehicleNotes(\"" . $row[0] . "vehicle\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal-check' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z'/><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td></tr>";
        } else {
            $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showVehicleNotes(\"" . $row[0] . "vehicle\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal' viewBox='0 0 16 16'><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td></tr>";
        }

        $returnString .= "
    </tr>";
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
          {orderable: false, targets: [5,6] },
          {searchable: false, targets: [5,6] }
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
