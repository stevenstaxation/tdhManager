<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sqlFILTER = $_POST['SQLFilter'] ?? 1;

$returnString = "
<div id='hiddenCustomerID' class='d-none'></div>
<div id='jobFilter d-none'> " . $sqlFILTER . "</div>

<div id='deviceLongList' class='listHeader'>
  <h4><strong>Job Requests</strong></h4>
  <div class='dt-buttons'>";
if ($_SESSION['isInstaller'] == '0' && $_SESSION['isEngineer'] == '0') {
    $returnString .= "
    <button class='dt-button' id='addJobRequest' onclick='addJobRequest(\"job\")' type='button'><span><i class='bi bi-plus-circle-fill h5'></i>  Add New Job</span></button>";
}
$returnString .= "
    <button class='dt-button' style='margin: 10px 10px;' id='showJobMap' onclick='showJobMap()'><span><i class='bi bi-geo-alt-fill h5'></i>Job Map</span></button>";


if ($_SESSION['isInstaller']=='0') {
  $returnString .= "
    <button class='dt-button' type='button' style='margin: 10px 10px;' id='editMultipleJobs'><span><i class='bi bi-files h5'></i>Edit Multiple Jobs</span></button>
    </div>
    <div class='dt-buttons'>";
} 

if ($sqlFILTER == 128) {
    $returnString .= "
  <button class='btn btn-success' id='toggleAllJobs' style='margin: 10px 10px;' disabled>Show All</button>";
} else {
    $returnString .= "
  <button class='btn btn-danger' id='toggleAllJobs' style='margin: 10px 10px;'>Show All</button>";
}

if (($sqlFILTER & 1) != 1) {
    $returnString .= "
    <button class='btn btn-success' id='togglePendingJobs' style='margin: 10px 10px;'>Hide Pending</button>";
} else {
    $returnString .= "
    <button class='btn btn-danger' id='togglePendingJobs' style='margin: 10px 10px;'>Show Pending</button>";
}
if (($sqlFILTER & 4) != 4) {
    $returnString .= "
    <button class='btn btn-success' id='toggleDatePassedJobs' style='margin: 10px 10px;'>Hide Date Passed</button>";
} else {
    $returnString .= "
    <button class='btn btn-danger' id='toggleDatePassedJobs' style='margin: 10px 10px;'>Show Date Passed</button>";
}
if (($sqlFILTER & 2) != 2) {
    $returnString .= "
    <button class='btn btn-success' id='toggleBookedJobs' style='margin: 10px 10px;'>Hide Booked</button>";
} else {
    $returnString .= "
    <button class='btn btn-danger' id='toggleBookedJobs' style='margin: 10px 10px;'>Show Booked</button>";
}
if (($sqlFILTER & 16) != 16) {
    $returnString .= "
    <button class='btn btn-success' id='toggleCompletedJobs' style='margin: 10px 10px;'>Hide Completed</button>";
} else {
    $returnString .= "
    <button class='btn btn-danger' id='toggleCompletedJobs' style='margin: 10px 10px;'>Show Completed</button>";
}
if (($sqlFILTER & 32) != 32) {
    $returnString .= "
    <button class='btn btn-success' id='toggleCancelledJobs' style='margin: 10px 10px;'>Hide Cancelled</button>";
} else {
    $returnString .= "
    <button class='btn btn-danger' id='toggleCancelledJobs' style='margin: 10px 10px;'>Show Cancelled</button>";
}
if (($sqlFILTER & 64) != 64) {
    $returnString .= "
    <button class='btn btn-success' id='toggleArchivedJobs' style='margin: 10px 10px;'>Hide Archived</button>";
} else {
    $returnString .= "
    <button class='btn btn-danger' id='toggleArchivedJobs' style='margin: 10px 10px;'>Show Archived</button>";
}

$returnString .= "</div>";

$returnString .= "


  <div class='container-fluid'>
  <div id='jobListFilter'>
    <form id='deviceForm' class='filterBox d-none'><div id='deviceFilters' class='settings-dialog' style='border-width: 1px; border-style: solid; padding: 5px; width:100%'>
      <div class='input-group'>
        <input type='text' style='padding: 5px;' id='byOther' value=''/>
      </div>
    </form>
  </div>
</div>
";

$sql = 'SELECT tblJobs.ID, tblJobs.ownerID,  tblJobs.date, tblJobs.dateAdded, tblJobs.PriorityIsUrgent, tblJobs.jobType, tblJobType.description, tblJobs.VRN, tblVehicle.regNumber, tblJobs.notes, tblCustomer.businessName, tblJobs.status, tblJobs.timePeriod, tblDeviceDescription.description as CameraType, tblusers.userName as EngineerName, tblUsers.colour as EngineerColour, tblJobs.bookingAddress, tblJobs.jobRate, tblJobs.customerRate

  FROM tblJobs LEFT JOIN tblVehicle ON tblJobs.VRN = tblVehicle.ID INNER JOIN tblJobType ON tblJobs.jobType = tblJobType.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblJobs.ownerID INNER JOIN tblDeviceDescription ON tblDeviceDescription.ID = tblJobs.cameratypeID LEFT JOIN tblusers ON tblusers.userID = tblJobs.engineerID';

$hidePending = ($sqlFILTER & 1);
$hideBooked = ($sqlFILTER & 2);
$hideDatePassed = ($sqlFILTER & 4);
// $hideAll = ($sqlFILTER & 8);
$hideCompleted = ($sqlFILTER & 16);
$hideCancelled = ($sqlFILTER & 32);
$hideArchived = ($sqlFILTER & 64);

if (isset($sqlFILTER) && $sqlFILTER != -1) {
    $sql .= " WHERE (tblJobs.status <> '$hidePending' AND tblJobs.status <> '$hideBooked' AND tblJobs.status <> '$hideDatePassed' AND tblJobs.status <> '$hideCompleted' AND tblJobs.status <> '$hideCancelled' AND tblJobs.status <> '$hideArchived')";
}

$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) != 0) {

    $returnString .= "<div id = 'deviceSummary' class='w-auto ml-auto mr-auto' style='margin-top: 15px;'>
      <table id='jobListTable' class='table cell-border compact'>
      <thead>
      <tr>
        <th class='text-center align-middle' colspan='1' rowspan='2'>Date Added</th>
        <th class='text-left align-middle' colspan='1' rowspan='2'>Customer</th>
        <th class='text-center align-middle' colspan='1' rowspan='2'>Job Type</th>
        <th class='align-middle' colspan='1' rowspan='2'>Camera Type</th>
        <th class='text-center align-middle' colspan='1' rowspan='2'>Registration(s)</th>
        <th colspan='2' class='text-center'>Job Rate</th>
        <th class='align-middle' colspan='1' rowspan='2'>Engineer Assigned</th>
        <th class='align-middle' colspan='1' rowspan='2'>Address</th>
        <th class='text-center align-middle' colspan='1' rowspan='2'>Date/Time Booked</th>
        <th class='text-center align-middle' colspan='1' rowspan='2'>Status</th>
        <th class='text-center align-middle' colspan='1' rowspan='2'>Edit</th>
      </tr>
      <tr>
        <th class='text-center align-middle'>Customer Rate</th>
        <th class='text-center align-middle'>Engineer Rate</th>
      </tr>
      </thead>

      <tbody>";
    while ($row = mysqli_fetch_array($result)) {

        switch ($row['status']) {
            case 1:
                $rowBackground = "Pending";
                $rowColour = '#CCCC55';
                break;
            case 2:
                $bookedDate = strtotime($row['date']);
                $today = strtotime(date('Y-m-d H:i:s'));
                $diffInSeconds = $today - $bookedDate;

                if ($diffInSeconds < 0) {
                    $rowBackground = "Booked";
                    $rowColour = '#2255FF';
                } else {
                    $rowBackground = "Booked - Date Passed";
                    $rowColour = '#b60000';
                    $sql = "UPDATE tblJobs SET status='4'";
                    $sql .= " WHERE ID = '" . $row['ID'] . "'";
                    $update = mysqli_query($link, $sql);
                    break;
                }
                break;
            case 4:
                $rowBackground = "Booked - Date Passed";
                $rowColour = '#b60000';
                break;
            case 8:
                $rowBackground = "Awaiting Approval";
                $rowColour = '#1e90ff';
                break;
            case 16:
                $rowBackground = "Complete";
                $rowColour = '#55CC55';
                break;
            case 32:
                $rowBackground = "Cancelled";
                $rowColour = '#FF00FF';
                break;
            case 64:
                $rowBackground = "Archived";
                $rowColour = '#888888';
                break;
            default:
                $rowBackground = "UNKNOWN";
                $rowColour = '#B60000';
        }

        if ($row['PriorityIsUrgent'] == 2) {
            $jobPriority = "Urgent";
        } else {
            $jobPriority = "Standard";
        }

        $EngineerTextColour = intval(substr($row['EngineerColour'] ?? '', 1, 2), 16) * 0.299;
        $EngineerTextColour += intval(substr($row['EngineerColour'] ?? '', 3, 2), 16) * 0.587;
        $EngineerTextColour += intval(substr($row['EngineerColour'] ?? '', 5, 2), 16) * 0.114;
        if ($EngineerTextColour > 150) {
            $engineerColor = '#222222';
        } else {
            $engineerColor = '#EEEEEE';
        }

        $returnString .= "<tr class = ''>
    <td class='text-center align-middle' style='padding:0 3px;' data-order=" . date('Y-m-d', strtotime($row['dateAdded'])) . ">" . date('d/m/Y', strtotime($row['dateAdded'])) . "</td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['businessName'] . "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['description'] . "</td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['CameraType'] . "</td>

    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['regNumber'] . "</td>";

        if ($row['customerRate'] != 0) {
            $returnString .= "<td class='text-right align-middle' style='padding:0 10px;'>£" . number_format($row['customerRate'], 2, '.', ',') . "</td>";
        } else {
            $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>N/A</td>";
        }

        if ($row['jobRate'] != 0) {
            $returnString .= "<td class='text-right align-middle' style='padding:0 10px;'>£" . number_format($row['jobRate'], 2, '.', ',') . "</td>";
        } else {
            $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>N/A</td>";
        }
        if ($row['EngineerName'] == '') {
            $row['EngineerColour'] = '#CCCC55';
            $row['EngineerName'] = "No Engineer Assigned...";
            $returnString .= "
          <td class='text-center align-middle' style='font-size: 75%; padding:0 3px; color: " . $row['EngineerColour'] . "'>" . $row['EngineerName'] . "</td>";
        } else {
            $returnString .= "
          <td class='text-center align-middle' style='font-size: 85%; padding:0 3px; color: " . $row['EngineerColour'] . "'><b>" . $row['EngineerName'] . "</b></td>";
        }

        if ($row['bookingAddress'] == '') {
            $row['bookingAddress'] = "Awaiting confirmation...";
            $returnString .= "<td class='align-middle' style='padding:0 3px; color: #CCCC55'>" . $row['bookingAddress'] . "</td>";
        } else {
            $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $row['bookingAddress'] . "</td>";
        }

        if ($row['date']) {
          if (date('d/m/Y', strtotime($row['date'])) == '01/01/1970') {
            $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>TBD</td>";
          } else {
            if (date('H:i', strtotime($row['date']))!="00:00") {
              $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order=" . strtotime($row['date']) . ">" . date('d/m/Y (D) H:i', strtotime($row['date'])) . "</td>";
            } else {
              switch ($row['timePeriod']) {
                case 1:
                  $periodOfTime = " All Day";
                  break;
                case 2:
                  $periodOfTime = " Morning";
                  break;
                case 3:
                  $periodOfTime = " Afternoon";
                  break;
                default:
                  $periodOfTime = " Unknown";
              }
              $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order=" . strtotime($row['date']) . ">" . date('d/m/Y (D)', strtotime($row['date'])). $periodOfTime ."</td>";
            }
          }
        } else {
          $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>TBD</td>";
        }

        $returnString .= "
    <td class='text-center align-middle' style='font-size: 85%; color: " . $rowColour . "'><b>" . $rowBackground . "</b></td>";

        $returnString .= "<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0] . "editj\")'><i class='bi bi-pencil-fill h5'></i></btn></td>";

        $returnString .= "
    </tr>";

    }
    mysqli_free_result($result);
    unset($result);

    $returnString .= "</tbody>
  <tfoot>
    <tr>
      <th colspan='12'></th>
    </tr>
  </tfoot>

  </table>

</div>
<div id='hiddenJobID' class='d-none'></div>
<script>
 document.getElementById('byOther').addEventListener('keypress', function (event) {
       if (event.keyCode == 13) {
            event.preventDefault();
        }
    });

    $(document).ready(function() {
      var table = $('#jobListTable').DataTable({
        retrieve: true,
        columnDefs: [
          {orderable: false, targets: [11] },
          {searchable: false, targets: [11] }
        ],
        colReorder: true,
        order: [[5, 'asc']],
        processing: true,
        paging: true,
        pagingType: 'numbers',
        lengthMenu: [[5,10,25,50, 100, 250, 500, -1], [5,10,25,50, 100, 250, 500, 'All']],
        responsive: true,
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
                  .css('color', 'white')
                  .css('border-color', 'white');
          } else {
            $(row).css('background-color', 'rgba(255,255,255,1)')
                  .css('color', 'rgba(68,68,68,1)')
                  .css('border-color', 'rgba(68,68,68,1)');
        }
      }
    });

  });

    </script>
";
} else {
    $returnString .= "<p class='text-center'>No results found</p>";
}

echo $returnString;

?>

<!-- select: {
          style: 'multiple',
          items: 'column',
          selector: 'tr>td:nth-child(1), tr>td:nth-child(2), tr>td:nth-child(3), tr>td:nth-child(4), tr>td:nth-child(5), tr>td:nth-child(6), tr>td:nth-child(7), tr>td:nth-child(8),  tr>td:nth-child(9)'
        }, -->
