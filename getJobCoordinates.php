<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$engineerID = $_POST['engineerID'];

$sql = "SELECT tblJobs.bookingAddress, tblJobs.date, tblJobs.engineerID, tblUsers.userName, tblJobs.jobCompleteFlag, tblJobs.notes, 
tblJobs.status, tblJobs.ownerID, tbljobType.description, tblCustomer.businessName FROM tblJobs INNER JOIN tbljobType ON tblJobs.jobType = tbljobType.ID
INNER JOIN tblCustomer ON tblJobs.ownerID = tblCustomer.ID LEFT JOIN tblUsers ON tblJobs.engineerID = tblUsers.userID WHERE ";
 
 if ($engineerID>0) {
    $sql .=" tblJobs.engineerID = '$engineerID' AND ";
 }

 $sql .="tblJobs.Date BETWEEN '" . $startDate . " 00:00:00' AND '" . $endDate ." 23:59:59'"; 

 $sql .= " AND status <>'5'";
$result = mysqli_query($link, $sql);

$jobs = [];


while($row = mysqli_fetch_array($result)) {
    $job = [];
    $job['date'] = $row['date'];
    $job['businessName'] = $row['businessName'];
    $job['engineerID'] = $row['engineerID'];
    $job['userName'] = $row['userName'];
    $job['description'] = $row['description'];
    $job['jobCompleteFlag'] = $row['jobCompleteFlag'];
    $job['status'] = $row['status'];
    $job['bookingAddress'] = $row['bookingAddress'];
    $job['notes'] = $row['notes'];
    
    
    $pattern = "/((GIR 0AA)|((([A-PR-UWYZ][0-9][0-9]?)|(([A-PR-UWYZ][A-HK-Y][0-9][0-9]?)|(([A-PR-UWYZ][0-9][A-HJKSTUW])|([A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY])))) [0-9][ABD-HJLNP-UW-Z]{2}))/i";
    preg_match($pattern, $job['bookingAddress'], $matches);
    if ($matches) {
        $postcode = $matches[0]; 
    } else {
        $pattern = "/((GIR 0AA)|((([A-PR-UWYZ][0-9][0-9]?)|(([A-PR-UWYZ][A-HK-Y][0-9][0-9]?)|(([A-PR-UWYZ][0-9][A-HJKSTUW])|([A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY]))))[0-9][ABD-HJLNP-UW-Z]{2}))/i";
        preg_match($pattern, $job['bookingAddress'], $matches);
        if ($matches) {
            $postcode = $matches[0];
        } else {
            $postcode='B928AT';
        }   
    }



    $sql = "SELECT * FROM postcodelatlng WHERE postcode = '$postcode' OR postcodeTrunc='$postcode' LIMIT 1";
    $result2 = mysqli_query($link, $sql);
    
    $row2 = mysqli_fetch_array($result2);
    if ($row2) {
        $job['latitude'] = $row2['latitude'];
        $job['longitude'] = $row2['longitude'];
    } else {
        $job['latitude'] = 52.4322625;
        $job['longitude'] = -1.7960350;
    }
    $jobs[]= $job;

}

echo (json_encode($jobs));


?>




