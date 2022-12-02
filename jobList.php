<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sqlFILTER = $_POST['SQLFilter'] ?? 254;

$returnString = "
<div id='hiddenCustomerID' style='display: none'></div>
<div id='jobFilter' style='display: none'> " . $sqlFILTER . "</div>

<div id='deviceLongList' class='listHeader'>
  <h4><strong>Job Requests</strong></h4>
  <div class='dt-buttons'>";
if ($_SESSION['isInstaller'] == '0' && $_SESSION['isEngineer'] == '0') {
    $returnString .= "
    <button class='dt-button' id='addJobRequest' onclick='addJobRequest(\"job\")' type='button'><span><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/></svg> Add New Job</span></button>";
}
$returnString .= "
    <button class='dt-button' style='margin: 10px 10px;' id='showJobMap' onclick='showJobMap()'><span><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-geo-alt-fill' viewBox='0 0 16 16'><path d='M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z'/></svg>Job Map</span></button>";

// $returnString .= "
// <btn class='btn btn-secondary' style='margin: 10px 10px;' id='editMultipleJobs'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-files' viewBox='0 0 16 16'><path d='M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z'/></svg>Edit Multiple Jobs</btn>";
$returnString .= "
    <button class='dt-button' type='button' style='margin: 10px 10px;' id='editMultipleJobs'><span><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-files' viewBox='0 0 16 16'><path d='M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z'/></svg>Edit Multiple Jobs</span></button>

    </div>

    <div class='dt-buttons'>";
if (($sqlFILTER & 1) == 1) {
    $returnString .= "
    <button class='dt-button' id='togglePendingJobs' style='margin: 10px 10px;'>Show Pending</button>";
} else {
    $returnString .= "
    <button class='dt-button' id='togglePendingJobs' style='margin: 10px 10px;'>Hide Pending</button>";
}
if (($sqlFILTER & 4) == 4) {
    $returnString .= "
    <button class='dt-button' id='toggleDatePassedJobs' style='margin: 10px 10px;'>Show Date Passed</button>";
} else {
    $returnString .= "
    <button class='dt-button' id='toggleDatePassedJobs' style='margin: 10px 10px;'>Hide Date Passed</button>";
}
if (($sqlFILTER & 2) == 2) {
    $returnString .= "
    <button class='dt-button' id='toggleBookedJobs' style='margin: 10px 10px;'>Show Booked</button>";
} else {
    $returnString .= "
    <button class='dt-button' id='toggleBookedJobs' style='margin: 10px 10px;'>Hide Booked</button>";
}
if (($sqlFILTER & 16) == 16) {
    $returnString .= "
    <button class='dt-button' id='toggleCompletedJobs' style='margin: 10px 10px;'>Show Completed</button>";
} else {
    $returnString .= "
    <button class='dt-button' id='toggleCompletedJobs' style='margin: 10px 10px;'>Hide Completed</button>";
}
if (($sqlFILTER & 32) == 32) {
    $returnString .= "
    <button class='dt-button' id='toggleCancelledJobs' style='margin: 10px 10px;'>Show Cancelled</button>";
} else {
    $returnString .= "
    <button class='dt-button' id='toggleCancelledJobs' style='margin: 10px 10px;'>Hide Cancelled</button>";
}
if (($sqlFILTER & 64) == 64) {
    $returnString .= "
    <button class='dt-button' id='toggleArchivedJobs' style='margin: 10px 10px;'>Show Archived</button>";
} else {
    $returnString .= "
    <button class='dt-button' id='toggleArchivedJobs' style='margin: 10px 10px;'>Hide Archived</button>";
}

$returnString .= "</div>";

// if ($_SESSION['isInstaller']== '0' && $_SESSION['isEngineer']== '0') {
//   $returnString .="
//    <btn class='btn btn-danger' style='margin: 10px 10px;' id='PDFJobsList' data-toggle='modal' data-target='#modalGetJobReportParameters' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-pdf-fill' viewBox='0 0 16 16'><path d='M5.523 10.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.035 21.035 0 0 0 .5-1.05 11.96 11.96 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.888 3.888 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 4.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z'/><path fill-rule='evenodd' d='M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm.165 11.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.64 11.64 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.707 19.707 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z'/></svg>Export List as PDF</btn>";
//  }

$returnString .= "


  <div class='container-fluid'>
  <div id='jobListFilter'>
    <form id='deviceForm' class='filterBox' style='display: none'><div id='deviceFilters' class='settings-dialog' style='border-width: 1px; border-style: solid; padding: 5px; width:100%'>
      <div class='input-group'>
        <input type='text' style='padding: 5px;' id='byOther' value=''/>
      </div>
    </form>
  </div>
</div>
";

$sql = 'SELECT tblJobs.ID, tblJobs.ownerID,  tblJobs.date, tblJobs.dateAdded, tblJobs.PriorityIsUrgent, tblJobs.jobType, tblJobType.description, tblJobs.VRN, tblVehicle.regNumber, tblJobs.notes, tblCustomer.businessName, tblJobs.status, tblDeviceDescription.description as CameraType, tblusers.userName as EngineerName, tblUsers.colour as EngineerColour, tblJobs.bookingAddress, tblJobs.jobRate, tblJobs.customerRate

  FROM tblJobs LEFT JOIN tblVehicle ON tblJobs.VRN = tblVehicle.ID INNER JOIN tblJobType ON tblJobs.jobType = tblJobType.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblJobs.ownerID INNER JOIN tblDeviceDescription ON tblDeviceDescription.ID = tblJobs.cameratypeID LEFT JOIN tblusers ON tblusers.userID = tblJobs.engineerID';

$hidePending = ($sqlFILTER & 1);
$hideBooked = ($sqlFILTER & 2);
$hideDatePassed = ($sqlFILTER & 4);
$hideAwaitApproval = ($sqlFILTER & 8);
$hideCompleted = ($sqlFILTER & 16);
$hideCancelled = ($sqlFILTER & 32);
$hideArchived = ($sqlFILTER & 64);

if (isset($sqlFILTER) && $sqlFILTER != -1) {
    $sql .= " WHERE (tblJobs.status <> '$hidePending' AND tblJobs.status <> '$hideBooked' AND tblJobs.status <> '$hideDatePassed' AND tblJobs.status <> '$hideAwaitApproval' AND tblJobs.status <> '$hideCompleted' AND tblJobs.status <> '$hideCancelled' AND tblJobs.status <> '$hideArchived')";
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
                $rowBackground = "No Longer Required";
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

        $EngineerTextColour = intval(substr($row['EngineerColour'], 1, 2), 16) * 0.299;
        $EngineerTextColour += intval(substr($row['EngineerColour'], 3, 2), 16) * 0.587;
        $EngineerTextColour += intval(substr($row['EngineerColour'], 5, 2), 16) * 0.114;
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
        if ($row['EngineerName']=='') {
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

        if (date('d/m/Y', strtotime($row['date'])) == '01/01/1970') {
            $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>TBD</td>";
        } else {
            $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order=" . strtotime($row['date']) . ">" . date('d/m/Y (D) H:i', strtotime($row['date'])) . "</td>";
        }

        $returnString .= "
    <td class='text-center align-middle' style='font-size: 85%; color: " . $rowColour . "'><b>" . $rowBackground . "</b></td>";
        // <td class='align-middle' style='padding:0 3px;'>" . $row['notes'] . "</td>";

        // if ($row['status']==1) {
        $returnString .= "<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0] . "editj\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
      <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
      </svg></btn></td>";
  
//     } else {
        //       $returnString .= "<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0]."viewj\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
        //   <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
        // </svg></btn></td>";
        // }

// if ($row['notes'] && $row['notes']!="") {
        //   $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showJobNotes(\"" . $row[0]."job\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal-check' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z'/><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
        // } else {
        //   $returnString .="<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showJobNotes(\"" . $row[0]."job\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal' viewBox='0 0 16 16'><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
        // }
        $returnString .= "
    </tr>";

    }
    mysqli_free_result($result);
    unset($result);

    // <tr>
    //   <th class='text-center align-middle'>Date Added</th>
    //   <th class='text-left align-middle'>Customer</th>
    //   <th class='text-center align-middle'>Job Type</th>
    //   <th class='align-middle'>Camera Type</th>
    //   <th class='text-center align-middle'>Registration</th>
    //   <th class='text-right align-middle'>Customer Rate</th>
    //   <th class='text-right align-middle'>Engineer Rate</th>

    //   <th class='text-center align-middle'>Engineer Assigned</th>
    //   <th class='text-center align-middle'>Address</th>
    //   <th class='text-center align-middle'>Date/Time Booked</th>
    //   <th class='text-center align-middle'>Status</th>

    //   <th class='text-center align-middle'>Edit</th>

    // </tr>

    $returnString .= "</tbody>
  <tfoot>
    <tr>
      <th colspan='12'></th>
    </tr>
  </tfoot>

  </table>

</div>
<div id='hiddenJobID' style='display: none'></div>
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
