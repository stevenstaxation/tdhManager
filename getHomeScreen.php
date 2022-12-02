<?php
session_start();
include('connect.php');

 if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
     header("Location: index.php");
 }

$sql = "SELECT tblJobs.date, tblJobs.notes, tblCustomer.businessName, tblVehicle.regNumber, tblJobType.description FROM tblJobs INNER JOIN tblCustomer ON tblJobs.ownerID = tblCustomer.ID INNER JOIN tblJobType ON tblJobType.ID = tblJobs.jobType INNER JOIN tblVehicle ON tblVehicle.ID = tblJobs.VRN  WHERE tblJobs.status='1' AND tblJobs.date <= CURDATE() ORDER BY date DESC";
$result = mysqli_query($link,$sql);

$returnString="";

if (mysqli_num_rows($result)>0) {

$returnString = "

<div id='overdueRequest' class='container' style='margin-top: 50px;'>
<h4 class='reminderScreen' style='margin-top:100px;'>JOBS DUE TODAY AND OVERDUE</h4>";



$returnString .="
<table class='table table-bordered homeTable'>
    <thead>
        <tr>
            <th class='text-center align-middle' style='padding:0 3px;'>Due Date</th>
            <th class='align-middle' style='padding:0 3px;'>Customer</th>
            <th class='text-center align-middle' style='padding:0 3px;'>VRN</th>
            <th class='text-center align-middle' style='padding:0 3px;'>Type</th>
            <th class='align-middle' style='padding:0 3px;'>Description</th>
        </tr>
    </thead>
    <tbody>
   ";
   
   while ($overdue = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
       $returnString .= "<tr>
       <td class='text-center align-middle'>" . date('d/m/Y', strtotime($overdue['date'])) . "</td>
       <td class='align-middle' style='padding:0 3px;'>" . $overdue['businessName'] . "</td>
       <td class='text-center align-middle'>" . $overdue['regNumber'] . "</td>
       <td class='text-center align-middle'>" . $overdue['description'] . "</td>
       <td class='align-middle' style='padding:0 3px;'>" . $overdue['notes']. "</td>
       </tr>";
   }
    
$returnString .="</tbody>

</table>

";
} else {
    $returnString = "<div id='overdueRequest' class='container' style='margin-top: 50px;'>
    <h4 class='reminderScreen' style='margin-top:100px;'>JOBS DUE TODAY AND OVERDUE</h4>";
    $returnString .= "<p>There are no outstanding jobs which are due today or overdue</p>";
}


$sql = "SELECT tblJobs.date, tblJobs.notes, tblCustomer.businessName, tblVehicle.regNumber, tblJobType.description FROM tblJobs INNER JOIN tblCustomer ON tblJobs.ownerID = tblCustomer.ID INNER JOIN tblJobType ON tblJobType.ID = tblJobs.jobType INNER JOIN tblVehicle ON tblVehicle.ID = tblJobs.VRN  WHERE tblJobs.status='1' AND tblJobs.date >= DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND tblJobs.date <= DATE_ADD(NOW(), INTERVAL 30 DAY) ORDER BY date ASC";
$result = mysqli_query($link,$sql);

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

$sql = "SELECT * FROM tblCustomerNote INNER JOIN tblUsers ON tblCustomerNote.userID = tblUsers.userID INNER JOIN tblCustomer ON tblCustomer.ID = tblCustomerNote.customerID WHERE (noteDate <= '" . $dateNow->format('Y-m-d H:i') ."' AND isAnAlert='1')";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result)>0) {
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
 
$returnString .="</tbody>

</table>";
} else {
    $returnString .="<h4 class='reminderScreen' style='margin-top:50px;'>CUSTOMER REMINDERS (NEXT 30 DAYS)</h4>";
    $returnString .="<p>There are no reminders for the next 30 days</p>";
}

$returnString .="</div>";

echo $returnString;

?>

