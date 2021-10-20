<?php
session_start();
include('connect.php');

// Define error messages
$missingEmail = "<p><strong>You need to enter your email address to log in.</strong></p>";
$missingPassword = "<p><strong>You need to enter your password</strong></p>";

$userName = $_POST['userName'];
$password = $_POST['password'];
$check_mail = false;
$errors = "";

// Get email and password and check for errors
// check email and username
if (empty($userName)) {
    $errors .= $missingEmail;
} else {
        $userName = filter_var($userName, FILTER_SANITIZE_EMAIL);
        }

// check password
if(empty($_POST['password'])) {
        $errors .= $missingPassword;
    } else {
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    }


// print any errors
if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
} else {
    $userName = mysqli_real_escape_string($link, $userName);
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);
    $sql = "SELECT * FROM tblUsers WHERE (email='$userName' AND password='$password' AND activation='activated')";

    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing yon database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $count = mysqli_num_rows($result);

    if ($count !== 1) {
    // If they don't match print an error
        $sql = "INSERT INTO tblEventLog (Description) VALUES ('Incorrect email or password')";
        $result = mysqli_query($link, $sql);
        echo '<div class="alert alert-danger">Incorrect email or password</div>';
    } else {
        // log the user in and set session variables
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['userEmail'] = $row['email'];
        $_SESSION['userName'] = $row['userName'];
        $_SESSION['darkMode'] = $row['darkmode'];
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['isAdmin'] = $row['isAdmin'];
        $_SESSION['isInstaller'] = $row['isInstaller'];
        $_SESSION['isEngineer'] = $row['isEngineer'];
        
       
        $_SESSION['Alerts'] = getAlerts($link);

        $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Successful log in', '" . $row['userID']. "')";
        $result = mysqli_query($link, $sql);
        echo 'success';

    }

}



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

    $sql = "SELECT * FROM tblCustomerNote INNER JOIN tblUsers ON tblCustomerNote.userID = tblUsers.userID INNER JOIN tblCustomer ON tblCustomerNote.customerID = tblCustomer.ID WHERE (noteDate <= '" . $dateNow->format('Y-m-d H:i') ."' AND isAnAlert='1')";

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

    $sql = "SELECT * FROM tblDevice INNER JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID INNER JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID WHERE (installDate >= '" . $dateNow->format('Y-m-d') ."')";

    $result = mysqli_query($link, $sql);

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
