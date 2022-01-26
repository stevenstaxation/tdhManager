<?php
session_start();
include('connect.php');
require('FPDF/fpdf.php');

if (isset($_SESSION['engineerID'])) {
    $engineerID = $_SESSION['engineerID'];
    unset($_SESSION['engineerID']);
} else {
    $_SESSION['engineerID'] = $_POST['engineerID'];
}
if (isset($_SESSION['dateBookedFrom'])) {
    $dateBookedFrom = $_SESSION['dateBookedFrom'];
    unset($_SESSION['dateBookedFrom']);
} else {
    $_SESSION['dateBookedFrom'] = $_POST['dateBookedFrom'];
}
if (isset($_SESSION['dateBookedTo'])) {
    $dateBookedTo = $_SESSION['dateBookedTo'];
    unset($_SESSION['dateBookedTo']);
} else {
    $_SESSION['dateBookedTo'] = $_POST['dateBookedTo'];
}
if (isset($_SESSION['dateAddedFrom'])) {
    $dateAddedFrom = $_SESSION['dateAddedFrom'];
    unset($_SESSION['dateAddedFrom']);
} else {
    $_SESSION['dateAddedFrom'] = $_POST['dateAddedFrom'];
}
if (isset($_SESSION['dateAddedTo'])) {
    $dateAddedTo = $_SESSION['dateAddedTo'];
    unset($_SESSION['dateAddedTo']);
} else {
    $_SESSION['dateAddedTo'] = $_POST['dateAddedTo'];
}
if (isset($_SESSION['statusComplete'])) {
    $statusComplete = $_SESSION['statusComplete'];
    unset($_SESSION['statusComplete']);
} else {
    $_SESSION['statusComplete'] = $_POST['statusComplete'];
}
if (isset($_SESSION['statusPending'])) {
    $statusPending = $_SESSION['statusPending'];
    unset($_SESSION['statusPending']);
} else {
    $_SESSION['statusPending'] = $_POST['statusPending'];
}
if (isset($_SESSION['statusBooked'])) {
    $statusBooked = $_SESSION['statusBooked'];
    unset($_SESSION['statusBooked']);
} else {
    $_SESSION['statusBooked'] = $_POST['statusBooked'];
}
if (isset($_SESSION['statusOverdue'])) {
    $statusOverdue = $_SESSION['statusOverdue'];
    unset($_SESSION['statusOverdue']);
} else {
    $_SESSION['statusOverdue'] = $_POST['statusOverdue'];
}
if (isset($_SESSION['statusApproval'])) {
    $statusApproval = $_SESSION['statusApproval'];
    unset($_SESSION['statusApproval']);
} else {
    $_SESSION['statusApproval'] = $_POST['statusApproval'];
}



$sql = 'SELECT tblJobs.ID, tblJobs.ownerID,  tblJobs.date, tblJobs.dateAdded, tblJobs.PriorityIsUrgent, tblJobs.jobType, tblJobType.description, tblJobs.VRN, tblVehicle.regNumber, tblJobs.notes, tblCustomer.businessName, tblJobs.status, tblDeviceDescription.description as CameraType, tblJobs.engineerID, tblUsers.userName FROM tblJobs INNER JOIN tblVehicle ON tblJobs.VRN = tblVehicle.ID INNER JOIN tblJobType ON tblJobs.jobType = tblJobType.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblJobs.ownerID INNER JOIN tblDeviceDescription ON tblDeviceDescription.ID  = tblJobs.cameratypeID INNER JOIN tblUsers ON tblJobs.engineerID=tblUsers.userID';
$whereClause = ' WHERE ';

if ($dateBookedFrom!='' && $dateBookedTo!='') {
    $whereClause .= "date BETWEEN '" . $dateBookedFrom . "' AND '" . $dateBookedTo . "'";
}
if ($dateAddedFrom!='' && $dateAddedTo!='') {
    if ($whereClause!=' WHERE ') {
        $whereClause .=' AND ';
    }
    $whereClause .= "dateAdded BETWEEN '". $dateAddedFrom ."' AND '" .$dateAddedTo ."'"; 
}

$engineerName = '';
if ($engineerID!=0) {
    if ($whereClause!=' WHERE ') {
        $whereClause .=' AND ';
    }  
    $whereClause .= "engineerID=" .$engineerID;
    if ($engineerID!=9999) {
        $getEngineerName = "SELECT tblUsers.userName FROM tblJobs INNER JOIN tblUsers ON tblJobs.engineerID=tblUsers.userID WHERE tblJobs.engineerID=" . $engineerID;
        $result = mysqli_query($link, $getEngineerName);
        $row = mysqli_fetch_array($result);
        $engineerName = $row['userName'];
    } else {
        $engineerName="Unregistered Engineer";
    }
} else {
    $engineerName = "All Engineers";
}

$jobStatus = '99';
if ($whereClause!=' WHERE ') {
    $whereClause .=' AND ';
}
$buildStatusClause = '';
if ($statusComplete=='true') {
    $buildStatusClause .= '(tblJobs.Status = 5';
}
if ($statusPending=='true') {
    if ($buildStatusClause!='') {
        $buildStatusClause .= ' OR tblJobs.Status = 0 OR tblJobs.Status = 1';
    } else {
        $buildStatusClause = '(tblJobs.Status = 0 OR tblJobs.Status = 1';
    }
}
if ($statusBooked=='true') {
    if ($buildStatusClause!='') {
        $buildStatusClause .= ' OR tblJobs.Status = 2';
    } else {
        $buildStatusClause = '(tblJobs.Status = 2';
    }
}
if ($statusOverdue=='true') {
    if ($buildStatusClause!='') {
        $buildStatusClause .= ' OR tblJobs.Status = 3';
    } else {
        $buildStatusClause = '(tblJobs.Status = 3';
    }
}
if ($statusApproval=='true') {
    if ($buildStatusClause!='') {
        $buildStatusClause .= ' OR tblJobs.Status = 4';
    } else {
        $buildStatusClause = '(tblJobs.Status = 4';
    }
}
if ($buildStatusClause!='') {
    $buildStatusClause .=')';
    $whereClause .= $buildStatusClause;
};

if ($whereClause != " WHERE ") {
    $sql .= $whereClause;
}

$sql .= ' ORDER BY tblJobs.dateAdded ASC';

$result = mysqli_query($link, $sql);

class PDF extends FPDF {

    function Header()
    {
       
        $this->Image('images/logo_swirl.png',260,6,20);
        $this->SetFont('Arial','B',13);
        $this->Cell(30,3,'The Data Analysis Hub Ltd',0,1,'L');
        $this->Cell(30,10,'Outstanding Jobs List as at ' . date('d M Y'),0,1,'L');
       
        // $this->Line(10,27,285,27);
        $this->Cell(0,5,'',"B",1);
        // Line break
        $this->Ln(5);
    }

    function Footer() {
         $this->SetY(-15);
         $this->SetFont('Arial','',7);
         $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'R');
    }
}


$pdf = new PDF();
$pdf->AddPage("L","A4");
$pdf->SetAutoPageBreak(true);

$pdf->SetFont('Arial', 'B', 9);
if ($dateAddedFrom!='' && $dateAddedTo!='') {
    $pdf->Cell(50,3, "Added Date: " . date('d M Y', strtotime($dateAddedFrom)) . " to " . date('d M Y', strtotime($dateAddedTo)),0,1);
}
if ($dateBookedFrom!='' && $dateBookedTo!='') {
    $pdf->Cell(50,6, "Booked Date: " . date('d M Y', strtotime($dateBookedFrom)) . " to " . date('d M Y', strtotime($dateBookedTo)),0,1);
}
$pdf->Cell(50,6, "ENGINEER: " . $engineerName,0,1);


$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(20,8,"Date Added",0,0);
$pdf->Cell(50,8,"Customer",0,0);
$pdf->Cell(20,8,"Job Type",0,0);
$pdf->Cell(30,8,"Camera Type",0,0);
$pdf->Cell(20,8,"Registration",0,0);
$pdf->Cell(20,8,"Dated Booked",0,0);
$pdf->Cell(15,8,"Priority",0,0);
$pdf->Cell(30,8,"Status",0,0);
$pdf->Cell(0,8,"Notes",0,1);

$pdf->SetFont('Arial', '', 7);
$statusCounter = array(0,0,0,0,0,0);

while ($row = mysqli_fetch_array($result)) {
    // some housekeeping to tidy up data
    $priority = 'Standard';
    $status = "Pending";
    $cameraType = $row['CameraType'];
    $dateBooked = 'TBD';

    if ($row['PriorityIsUrgent']==2) {
        $priority = "Urgent";
    }
    switch ($row['status']) {
        case 0:
            $status = "Pending";   
            break;
        case 1:
            $status = "Pending";   
            break;
        case 2:
            $status = "Booked";   
            break;
        case 3:
            $status = "Booked - Date passed";   
            break;
        case 4:
            $status = "Awaiting approval";   
            break;
        case 5:
            $status = "Complete";   
            break;                          
        default:
    }
    $statusCounter[$row['status']] ++;
    
    $cameraType = str_replace("Near-Side", "NS", $cameraType);
    $cameraType = str_replace("Off-Side", "OS", $cameraType);
    $cameraType = str_replace("Forward", "Fwd", $cameraType);
    $cameraType = str_replace("Monitor", "Mon", $cameraType);
    $cameraType = str_replace("Internal", "Int", $cameraType);
    
    if ($row['date']!= "1970-01-01" && $row['date']!='') {
        $dateBooked = date('d/m/Y', strtotime($row['date']));
    } 

    $pdf->Cell(20,4,date('d/m/Y', strtotime($row['dateAdded'])),0,0);
    $pdf->Cell(50,4,$row['businessName'],0,0);
    $pdf->Cell(20,4,$row['description'],0,0);
    $pdf->Cell(30,4,$cameraType,0,0);
    $pdf->Cell(20,4,$row['regNumber'],0,0);
    $pdf->Cell(20,4,$dateBooked,0,0);
    $pdf->Cell(15,4,$priority,0,0);
    $pdf->Cell(30,4,$status,0,0);
    $pdf->Cell(0,4,$row['notes'],0,1);
}
    $pdf->cell(0,5,'',"B",1);
    
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(20,6, "Total number of jobs in this report is " . mysqli_num_rows($result),0,1);
    $pdf->SetFont('Arial','',8);
    if (($statusCounter[0] + $statusCounter[1])!=0) {
        $pdf->Cell(20,4, "Pending " . ($statusCounter[0] + $statusCounter[1]),0,1);
    }
    if (($statusCounter[2])!=0) {
        $pdf->Cell(20,4, "Booked " . $statusCounter[2],0,1);
    }
    if (($statusCounter[3])!=0) {
        $pdf->Cell(20,4, "Booked - date passed " . $statusCounter[3],0,1);
    }
    if (($statusCounter[4])!=0) {
        $pdf->Cell(20,4, "Awaiting Approval " . $statusCounter[4],0,1);
    }
    if (($statusCounter[5])!=0) {
        $pdf->Cell(20,4, "Completed " . $statusCounter[5],0,1);
    }


    //$pdf->Output('D', 'Outstanding Jobs '. date('Y-m-d H-i-s') . '.pdf');
     $pdf->Output('I');
?>