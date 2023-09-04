<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$contactFirstName = $_POST['firstName'];
$contactLastName = $_POST['lastName'];
$contactMobileNumber = $_POST['mobileNumber'];
$contactTelephone = $_POST['telephone'];
$contactEmail = $_POST['email'];
$contactDepartment = $_POST['department'];
$insurerID = $_POST['employeeOf'];
if($_POST['footageRec']=='true') {
    $contactFootage = 1;
} else {
    $contactFootage = 0;
}
if($_POST['reporting']=='true') {
    $reporting = 1;
} else {
    $reporting = 0;
}
$contactCustomer = $_POST['employeeOf'];
$errors = "";
// rules
// Must include first name /
// Must include a mobile, telephone or email /
// Max Length of first name and last name is 30/
// Mobile & Telephone must be all numeric (or spaces) and max length 14 /
// Email address max length is 100 /

if (!$contactFirstName) {
    $errors .="You must include at least the contact's first name<br>";
}

if (!$contactMobileNumber && !$contactTelephone && !$contactEmail) {
    $errors .="You must include a mobile number, a telephone number or an email address<br>";
}

if (strlen($contactFirstName)>30) {
    $contactFirstName = substr($contactFirstName,0,30);
}
if (strlen($contactLastName)>30) {
    $contactLastName = substr($contactLastName,0,30);
}

$contactMobileNumber = str_replace(" ", "", $contactMobileNumber);
$contactTelephone = str_replace(" ", "", $contactTelephone);

if (strlen($contactMobileNumber)>14) {
    $errors .= "Mobile number should not be longer than 14 characters<br>";
}
if (strlen($contactTelephone)>14) {
    $errors .= "Mobile number should not be longer than 14 characters<br>";
}
if (strlen($contactEmail)>100) {
    $errors .= "Email address should not be longer than 100 characters<br>";
}
if (strlen($contactDepartment)>50) {
    $errors .= "Department should not be longer than 50 characters<br>";
}

if (strlen($contactMobileNumber)!=0) {
    if (!is_numeric($contactMobileNumber)) {
        $errors .= "Mobile number should only contain numbers<br>";
    }
}

if (strlen($contactTelephone)!=0) {
    if (!is_numeric($contactTelephone)) {
        $errors .= "Telephone should only contain numbers<br>";
    }
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$contactFirstName = filter_var($contactFirstName, FILTER_SANITIZE_STRING);
$contactLastName = filter_var($contactLastName, FILTER_SANITIZE_STRING);
$contactMobileNumber = filter_var($contactMobileNumber, FILTER_SANITIZE_STRING);
$contactTelephone = filter_var($contactTelephone, FILTER_SANITIZE_STRING);
$contactEmail = filter_var($contactEmail, FILTER_SANITIZE_EMAIL);
$contactDepartment = filter_var($contactDepartment, FILTER_SANITIZE_STRING);

$contactFirstName = mysqli_real_escape_string($link,$contactFirstName);
$contactLastName = mysqli_real_escape_string($link,$contactLastName);
$contactMobileNumber = mysqli_real_escape_string($link,$contactMobileNumber);
$contactTelephone = mysqli_real_escape_string($link,$contactTelephone);
$contactEmail = mysqli_real_escape_string($link,$contactEmail);
$contactDepartment = mysqli_real_escape_string($link,$contactDepartment);

// before update
$sql = "SELECT * FROM tblBrokerContact WHERE ID = '$contactCustomer'";
$prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

// update
$sql = "UPDATE tblBrokerContact SET firstName='$contactFirstName', lastName='$contactLastName', mobileNo='$contactMobileNumber', telephone='$contactTelephone', email='$contactEmail', department='$contactDepartment', isFootageRecipient='$contactFootage', isReporting='$reporting' WHERE ID = '$contactCustomer'";
$result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

// after update
$sql = "SELECT * FROM tblBrokerContact WHERE ID = '$contactCustomer'";
$updated = mysqli_fetch_assoc(mysqli_query($link, $sql));

// get changes
$updatedColumns = array_diff_assoc($updated, $prev);

// parse changes
$description="Broker contact " . $contactFirstName . " " . $contactLastName . " was edited - " ;
foreach ($updatedColumns as $column=>$value) {
    $description .= $column . " was changed to " .$value .", ";
}
$description = substr($description,0,strlen($description)-2);

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('$description', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
      
echo "success";

?>
