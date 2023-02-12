 <?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}



$_SESSION['Alerts'] = getAlerts($link);

//$xCount = 0;
//foreach ($_SESSION['Alerts'] as $alert) {
//    if ($alert['alertType']>=3) {
//        $xCount ++;
//    }
//}
//if ($xCount!=0) {
//    echo $xCount;
//}

$xCount = [];

$totalCount = '';
if (!empty($_SESSION['Alerts'])) {
    foreach ($_SESSION['Alerts'] as $alert) {
        $xCount[$alert['alertType']] ++;
    }
}
if (!empty($xCount)) {
    $totalCount = $xCount[1] . "^^^" . $xCount[2] . "^^^" . $xCount[3] . "^^^" . $xCount[4];
} else {
    $totalCount = 0 . "^^^" . 0 . "^^^" . 0 . "^^^" . 0;
}

echo $totalCount;


function getAlerts($link) {
$sql = 'SELECT * FROM tblCustomer';
$result = mysqli_query($link, $sql);
    $alerts=[];
    $dateNow = new dateTime();

    while ($alertRows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

      if (!$alertRows['renewalDate']) {
        $daysToRenewal = -1;
      } else {
        $renewalDate = new DateTime($alertRows['renewalDate']);
        $daysToRenewal = $dateNow->diff($renewalDate)->format('%r%a');
      }
        // renewals due within 30 or fewer days
        if ($daysToRenewal<=30 && $daysToRenewal>=0) {
            $alert['date'] = $renewalDate->format('Y-m-d H:i');
            $alert['alertType'] = 1;
            $alert['days'] = $daysToRenewal;
            $alert['customerID'] = $alertRows['ID'];
            $alert['text'] = $alertRows['businessName'] . " is due ";
            switch (intval($alert['days'])) {
                case 0:
                    $alert['text'] .= "today";
                    break;
                case 1:
                    $alert['text'] .= "tomorrow";
                    break;
                default:
                    $alert['text'] .= "in " . $alert['days'] . " days";
            }
            $alert['owner'] = '-';
            $alert['userID'] = 0;
            $alert['noteID'] = 0;
            array_push($alerts,$alert);
        }
        // renewals due within 31-60 days
        if ($daysToRenewal<=60 && $daysToRenewal>30) {
            $alert['date'] = $renewalDate->format('Y-m-d H:i');
            $alert['alertType'] = 2;
            $alert['days'] = $daysToRenewal;
            $alert['customerID'] = $alertRows['ID'];
            $alert['text'] = $alertRows['businessName'] . " is due in " . $alert['days'] . " days";
            $alert['owner'] = '-';
            $alert['userID'] = 0;
            $alert['noteID'] = 0;
            array_push($alerts,$alert);
        }
    }

    $interval = new DateInterval('P30D');
    $dateNow->add($interval);

    $sql = "SELECT * FROM tblCustomerNote INNER JOIN tblUsers ON tblCustomerNote.userID = tblUsers.userID INNER JOIN tblCustomer ON tblCustomer.ID = tblCustomerNote.customerID WHERE (noteDate <= '" . $dateNow->format('Y-m-d H:i') ."' AND isAnAlert='1')";

    $result = mysqli_query($link, $sql);

    while ($noteRows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $alert['date'] = $noteRows['noteDate'];
        $alert['alertType'] = 3;
        $alertDate = new DateTime($noteRows['noteDate']);
        $alert['days'] = $dateNow->diff($alertDate)->format('%r%a');
        $alert['customerID'] = $noteRows['customerID'];
        $alert['customername'] = $noteRows['businessName'];
        $alert['text'] = $noteRows['noteText'];
        $alert['owner'] = $noteRows['userName'];
        $alert['userID'] = $noteRows['userID'];
        $alert['noteID'] = $noteRows['cnID'];
        array_push($alerts,$alert);
    }

    $dateNow = new dateTime();
    $sql = "SELECT * FROM tblDevice INNER JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID INNER JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID WHERE (tblDevice.installDate >= '" . $dateNow->format('Y-m-d') ."')";

    $result = mysqli_query($link, $sql);
    if (!$result) {
        return '';
    }

    while ($noteRows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $alert['date'] = $noteRows['installDate'];
        $alert['alertType'] = 4;
        $alert['text'] = "Install for " .$noteRows['businessName'] ."(" .$noteRows['regNumber'] . " ) is booked for " . date('d/m/Y', strtotime($noteRows['installDate'])) ;
        $alert['owner'] = "-";
        $alert['userID'] = 0;
        $alert['noteID'] = 0;
        array_push($alerts,$alert);
    }

    sort($alerts);
    return $alerts;
}

?>
