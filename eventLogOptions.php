<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sql = 'SELECT TimeStamp FROM tblEventLog ORDER BY TimeStamp ASC LIMIT 1';
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

if (isset($_POST['startDate'])) {
    $startDate = $_POST['startDate'];
} else {
    $startDate = substr($row['TimeStamp'],0,10);
}
if (isset($_POST['endDate'])) {
    $endDate = $_POST['endDate'];
} else {
    $endDate = date('Y-m-d');
}

$returnString = "<div id='alertLogList' style = 'margin-top: 50px;margin-bottom: 20px;'><h3><strong>Event Log</strong></h3></div>";

$returnString .= "
<div id='eventFilter'>
    <form id='profileForm'>
    <div id='eventFilters' class='settings-dialog ml-auto mr-auto' style='padding: 5px; width:70%'>
        <div class='form-group'>
            <div class='row' style='margin-top: 8px;'>
                <div class='col-lg-5'>
                    <label class='control-label inline' for='filterStartDate' style='width:40%; padding-top:6px; margin-left:20px;'>from date</label>
                </div>
                <div class='col-lg-5'>
                    <div class='input-group'>
                        <input style='font-size: 80%; margin-right: 20px;' class='form-control inline' type='date' id='filterStartDate' name='filterStartDate' value= '$startDate' onblur='updateStartDate(event)'>
                    </div>
                </div>
            </div>
            <div class='row' style='margin-top: 8px;'>    
                <div class='col-lg-5'>
                    <label class='control-label inline' for='filterToDate' style='width:40%; padding-top:6px; margin-left:20px;'>to date</label>
                </div>
                <div class='col-lg-5'>
                    <div class='input-group'>
                        <input style='font-size: 80%; margin-right: 20px;' class='form-control inline' type='date' id='filterToDate' name='filterToDate' value= '$endDate' onblur='updateEndDate(event)'>
                    </div>
                </div>
            </div>
            <div class='row'>    
            <div class='col-5'></div>
            <div class='col-7 col-sm-6' style='margin-top: 15px;'>  

                <div class='btn-group'>
                    <btn class='btn btn-success' id='filterEventLog' style='margin: 0 10px;'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-funnel-fill' viewBox='0 0 16 16'>
                        <path d='M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z'/>
                  </svg> Filter</btn>

                    <btn class='btn btn-primary' id='printEventLog' style='margin: 0 10px;' onclick='printDiv()'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-printer-fill' viewBox='0 0 16 16'>
                        <path d='M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z'/>
                        <path d='M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z'/>
                    </svg> Print</btn>

                </div>
            </div>
        </div>
    </div>
    </form>
</div>";



    

    $sql = "SELECT * FROM tblEventLog JOIN tblUsers ON tblEventLog.UserID = tblUsers.userID WHERE DATE(TimeStamp) BETWEEN '$startDate' AND '$endDate' ORDER by TimeStamp DESC";

    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result)>0) {
        $returnString .= "
        <div id='filteredEventList'>
        <table class='table table-sm table-bordered w-auto ml-auto mr-auto' style='font-size:70%;margin-top: 20px; table-layout: fixed;'>
            <thead>
                <th class='align-middle text-center'>Date</th>
                <th class='align-middle text-center'>Time</th>
                <th class='align-middle text-left' style='padding: 0 6px;'>Description</th>
                <th class='align-middle text-center'>User</th>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_array($result)) {
        $returnString .= "
        <tr>
        <td class='align-middle text-center' style='padding:0 6px;'>" . date('d/m/Y',strtotime($row['TimeStamp'])) . "</td>
        <td class='align-middle text-center' style='padding:0 6px;'>" . date('H:i:s', strtotime($row['TimeStamp'])) . "</td>
        <td class='align-middle text-left' style='padding:0 6px; mr-auto'>" . $row['Description'] . "</td>
        <td class='align-middle text-center' style='padding:0 6px;'>" . $row['userName'] . "</td>
        </tr>";
    }
   
$returnString .= "</tbody>
                </table>
                </div>";

            } else {
                $returnString .= "<div id='filteredEventList'><p class='text-center'>No results found</p></div>"; 
            }

echo $returnString;
