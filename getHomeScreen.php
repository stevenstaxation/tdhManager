<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$curDate = date('Y-m-d', strtotime('+3 days'));

$sql = "SELECT COUNT(*) as numJobs, businessName, date, bookingAddress, description, userName FROM(SELECT tblJobs.ID, tblJobs.status, tblJobs.date, tblJobs.notes, tblCustomer.businessName, tblVehicle.regNumber, tblJobType.description, tblJobs.bookingAddress, tblusers.userName FROM tblJobs INNER JOIN tblCustomer ON tblJobs.ownerID = tblCustomer.ID INNER JOIN tblJobType ON tblJobType.ID = tblJobs.jobType INNER JOIN tblVehicle ON tblVehicle.ID = tblJobs.VRN LEFT JOIN tblUsers ON tblusers.userID = tblJobs.engineerID WHERE (tblJobs.status='2' OR tblJobs.status='4') AND tblJobs.date <= '" . $curDate . "' AND tblJobs.isAlertable='1' ORDER BY date DESC) AS jobs
GROUP BY businessName, date, bookingAddress, description, userName ORDER BY date DESC, businessName ASC";

// $sql = "SELECT COUNT(*) as numJobs, businessName, date, bookingAddress, description FROM(SELECT tblJobs.ID, tblJobs.status, tblJobs.date, tblJobs.notes, tblCustomer.businessName, tblVehicle.regNumber, tblJobType.description, tblJobs.bookingAddress FROM tblJobs INNER JOIN tblCustomer ON tblJobs.ownerID = tblCustomer.ID INNER JOIN tblJobType ON tblJobType.ID = tblJobs.jobType INNER JOIN tblVehicle ON tblVehicle.ID = tblJobs.VRN  WHERE (tblJobs.status='2' OR tblJobs.status='4') AND tblJobs.date <= '" . $curDate . "' AND tblJobs.isAlertable='1' ORDER BY date DESC) AS jobs
// GROUP BY businessName, date, bookingAddress, description ORDER BY date DESC, businessName ASC";

// $sql = "SELECT ownerID, date, status, COUNT(*) AS upcomingJob FROM tblJobs GROUP BY ownerID, date, status";

$result = mysqli_query($link, $sql);

$returnString = "";

if (mysqli_num_rows($result) > 0) {

    $returnString = "

<div id='overdueRequest' class='container' style='margin-top: 50px;'>
<h4 class='reminderScreen' style='margin-top:100px;'>OVERDUE JOBS AND JOBS BOOKED WITHIN THE NEXT 3 DAYS (";

    $returnString .=  strtoupper(date('l jS F Y', strtotime('+3 days'))) . ")</h4>";



    $returnString .= "
<table class='table table-bordered homeTable'>
    <thead>
        <tr>
            <th class='text-center align-middle' style='padding:0 3px;'>Due Date</th>
            <th class='align-middle' style='padding:0 3px;'>Customer</th>
            <th class='text-center align-middle' style='padding:0 3px;'>Time</th>
            <th class='text-center align-middle' style='padding:0 3px;'>Engineer</th>
            <th class='align-middle' style='padding:0 3px;'>Address</th>
            <th class='align-middle' style='padding:0 3px;'>Description</th>         
            <th class='align-middle text-center dismissable'>Info</th>
        </tr>
    </thead>
    <tbody>
   ";

    $theJobs = [];

    while ($overdue = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $returnString .= "
       <td class='text-center align-middle'>" . date('d/m/Y', strtotime($overdue['date'])) . "</td>
       <td class='align-middle' style='padding:0 3px;'>" . $overdue['businessName'] . "</td>
       <td class='text-center align-middle'>" . date('h:i a', strtotime($overdue['date'])) . "</td>
       <td class='align-middle' style='padding: 0 3px;'>" . $overdue['userName'] . "</td>
       <td class='align-middle' style='padding: 0 3px;'>" . $overdue['bookingAddress'] . "</td>
       <td class='align-middle' style='padding:0 3px;'>" . $overdue['numJobs'] . " x " . $overdue['description'] .  "</td>
       <td class='align-middle text-center'>
        <button class='btn bg-transparent'>
            <i class='bi bi-info-circle-fill h5'></i>
        </button>
       </td>
       </tr>";
    }

    $returnString .= "</tbody>

</table>

";
} else {
    $returnString = "<div id='overdueRequest' class='container' style='margin-top: 50px;'>
    <h4 class='reminderScreen' style='margin-top:100px;'>JOBS DUE IN THE NEXT THREE DAYS OR OVERDUE</h4>";
    $returnString .= "<p>There are no outstanding jobs which are due in the next three days or that are overdue</p>";
}


$sql = "SELECT tblJobs.date, tblJobs.notes, tblCustomer.businessName, tblVehicle.regNumber, tblJobType.description FROM tblJobs INNER JOIN tblCustomer ON tblJobs.ownerID = tblCustomer.ID INNER JOIN tblJobType ON tblJobType.ID = tblJobs.jobType INNER JOIN tblVehicle ON tblVehicle.ID = tblJobs.VRN  WHERE tblJobs.status='1' AND tblJobs.date >= DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND tblJobs.date <= DATE_ADD(NOW(), INTERVAL 30 DAY) ORDER BY date ASC";
$result = mysqli_query($link, $sql);

// if (mysqli_num_rows($result)>0) {

// $returnString .="
// <h4 class='reminderScreen' style='margin-top:50px;'>JOBS COMING UP (NEXT 30 DAYS)</h4>

// <table class='table table-bordered homeTable'>
//     <thead>
//         <tr>
//             <th class='text-center align-middle' style='padding:0 3px;'>Due Date</th>
//             <th class='align-middle' style='padding:0 3px;'>Customer</th>
//             <th class='text-center align-middle' style='padding:0 3px;'>VRN</th>
//             <th class='text-center align-middle' style='padding:0 3px;'>Type</th>
//             <th class='align-middle' style='padding:0 3px;'>Description</th>
//         </tr>
//     </thead>
//     <tbody>
//    ";

//    while ($overdue = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//        $returnString .= "<tr>
//        <td class='text-center align-middle'>" . date('d/m/Y', strtotime($overdue['date'])) . "</td>
//        <td class='align-middle' style='padding:0 3px;'>" . $overdue['businessName'] . "</td>
//        <td class='text-center align-middle'>" . $overdue['regNumber'] . "</td>
//        <td class='text-center align-middle'>" . $overdue['description'] . "</td>
//        <td class='align-middle' style='padding:0 3px;'>" . $overdue['notes']. "</td>
//        </tr>";
//    }

// $returnString .="</tbody>

// </table>";
// } else {
//     $returnString .="<h4 class='reminderScreen' style='margin-top:50px;'>JOBS COMING UP (NEXT 30 DAYS)</h4>";
//     $returnString .="<p>There are no open jobs coming up within the next 30 days</p>";
// }

$interval = new DateInterval('P30D');
$dateNow = new dateTime();
$dateNow->add($interval);

$sql = "SELECT * FROM tblCustomerNote INNER JOIN tblUsers ON tblCustomerNote.userID = tblUsers.userID INNER JOIN tblCustomer ON tblCustomer.ID = tblCustomerNote.customerID WHERE (noteDate <= '" . $dateNow->format('Y-m-d H:i') . "' AND isAnAlert='1')";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $returnString .= "
<h4 class='reminderScreen' style='margin-top:50px;'>CUSTOMER REMINDERS (NEXT 30 DAYS)</h4>
<table class='table table-bordered homeTable'>
<thead>
    <tr>
        <th class='text-center align-middle'>Date</th>
        <th class='align-middle' style='padding:0 3px;'>Customer</th>
        <th class='align-middle' style='padding:0 3px;'>Note Text</th>
        <th class='text-center align-middle'>User</th>
    </tr>
</thead>
<tbody>";

    while ($alertNotes = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $returnString .= "
    <tr>
        <td class='text-center align-middle'>" . date('d/m/Y', strtotime($alertNotes['noteDate'])) . "</td>
        <td class='align-middle' style='padding:0 3px;'>" . $alertNotes['businessName'] . "</td>
        <td class='align-middle' style='padding:0 3px;'>" . $alertNotes['noteText'] . "</td>
        <td class='text-center align-middle'>" . $alertNotes['userName'] . "</td>
   </tr>";
    }

    $returnString .= "</tbody>

</table>";
} else {
    $returnString .= "<h4 class='reminderScreen' style='margin-top:50px;'>CUSTOMER REMINDERS (NEXT 30 DAYS)</h4>";
    $returnString .= "<p>There are no reminders for the next 30 days</p>";
}

$returnString .= "</div>";

echo $returnString;
