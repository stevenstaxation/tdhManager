<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newCustomerName = $_POST['customerName'];
$newCustomerAddress1 = $_POST['customerAddress1'];
$newCustomerAddress2 = $_POST['customerAddress2'];
$newCustomerAddress3 = $_POST['customerAddress3'];
$newCustomerAddress4 = $_POST['customerAddress4'];
$newCustomerAddress5 = $_POST['customerAddress5'];
$newCustomerPhone = $_POST['customerTelephone'];
$newCustomerEmail = $_POST['customerEmail'];
$newCustomerRegNo = $_POST['customerCoRegNo'];
$newCustomerVATRegNo = $_POST['customerVATRegNo'];
$newCustomerInsurerID = $_POST['customerInsurerID'];
$newCustomerBrokerID = $_POST['customerBrokerID'];


$errors = "";
// rules
// Must include customer name max length is 100 /
// Everything else is optional
// Address lines 1 - 4 max length 50 /
// Address line 5 max length is 14 and will be validated as postcode /
// Telephone must be numeric (strip non numeric chars) max length 20 - done in HTML /
// Email must be valid and max length is 100 /
// Co Reg Number must be numeric and max length 14 (strip non numeric) - done in HTML /
// VAT Number max length is 14 and must be numeric and will be validated /

if (!$newCustomerName) {
    $errors .="You must include the business name<br>";
}
if (strlen($newCustomerName)>100) {
    $newCustomerName = substr($newCustomerName,0,100);
}
if (strlen($newCustomerAddress1)>50) {
    $newCustomerAddress1 = substr($newCustomerAddress1,0,50);
}
if (strlen($newCustomerAddress2)>50) {
    $newCustomerAddress2 = substr($newCustomerAddress2,0,50);
}
if (strlen($newCustomerAddress3)>50) {
    $newCustomerAddress3 = substr($newCustomerAddress3,0,50);
}
if (strlen($newCustomerAddress4)>50) {
    $newCustomerAddress4 = substr($newCustomerAddress4,0,50);
}

if (!(checkPostcode($newCustomerAddress5)) && $newCustomerAddress5 != "") {
    $errors .= "Postcode is not valid<br>";
}

if (strlen($newCustomerPhone)>20) {
    $newCustomerPhone = substr($newCustomerPhone,0,20);
}
if (strlen($newCustomerRegNo)>14) {
    $newCustomerRegNo = substr($newCustomerRegNo,0,20);
}


if (strlen($newCustomerEmail)>100) {
    $errors .= "Maximum length of email address is 100 characters<br>";
}

$VATIsValid=false;
if ($newCustomerVATRegNo) {
// check VAT Number
    $checksum = 0;
    for ($ix=0; $ix<7; $ix++) {
        $checksum +=substr($newCustomerVATRegNo, $ix,1) * (8-$ix);
    }
    $testCheck=$checksum;
    while ($testCheck>0) {
        $testCheck = $testCheck - 97;
    }
    if (substr($newCustomerVATRegNo,7,2) == -$testCheck) {
        $VATIsValid = true;
    }

    // is it a newer VAT number?
    if (!$VATIsValid) {
        $testCheck = $checksum + 55;
        while ($testCheck>0) {
            $testCheck = $testCheck - 97;
        }
        if (substr($newCustomerVATRegNo,7,2) == -$testCheck) {
            $VATIsValid = true;
        }
    }
} else {
  $VATIsValid = true;
}
if (!$VATIsValid) {
    $errors .= "VAT Number is not valid";
}

if (!is_numeric($newCustomerPhone)) {
    $newCustomerPhone = preg_replace('/[^0-9]/', "", $newCustomerPhone);
}
if (!is_numeric($newCustomerRegNo)) {
    $newCustomerRegNo = preg_replace('/[^0-9]/', "", $newCustomerRegNo);
}
if (!is_numeric($newCustomerVATRegNo)) {
    $newCustomerVATRegNo = preg_replace('/[^0-9]/', "", $newCustomerVATRegNo);
}

if (!filter_var($newCustomerEmail, FILTER_VALIDATE_EMAIL) && $newCustomerEmail!='') {
    $errors .= "Email address does not look to be valid<br>";
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newCustomerName = mysqli_real_escape_string($link,filter_var($newCustomerName, FILTER_SANITIZE_STRING));
$newCustomerAddress1 = mysqli_real_escape_string($link,filter_var($newCustomerAddress1, FILTER_SANITIZE_STRING));
$newCustomerAddress2 = mysqli_real_escape_string($link,filter_var($newCustomerAddress2, FILTER_SANITIZE_STRING));
$newCustomerAddress3 = mysqli_real_escape_string($link,filter_var($newCustomerAddress3, FILTER_SANITIZE_STRING));
$newCustomerAddress4 = mysqli_real_escape_string($link,filter_var($newCustomerAddress4, FILTER_SANITIZE_STRING));
$newCustomerAddress5 = mysqli_real_escape_string($link,filter_var($newCustomerAddress5, FILTER_SANITIZE_STRING));
$newCustomerPhone = mysqli_real_escape_string($link,filter_var($newCustomerPhone, FILTER_SANITIZE_STRING));
$newCustomerRegNo = mysqli_real_escape_string($link,filter_var($newCustomerRegNo, FILTER_SANITIZE_STRING));
$newCustomerVATRegNo = mysqli_real_escape_string($link,filter_var($newCustomerVATRegNo, FILTER_SANITIZE_STRING));
$newCustomerEmail = mysqli_real_escape_string($link,filter_var($newCustomerEmail, FILTER_SANITIZE_EMAIL));

 $sql = "INSERT INTO tblCustomer (businessName, custAddressLine1, custAddressLine2, custAddressLine3, custAddressLine4, custAddressLine5, businessPhone, businessEmail, companyRegNo, VATRegNo, insurerID, renewalType, renewalDate,  brokerID) VALUES ('$newCustomerName','$newCustomerAddress1', '$newCustomerAddress2', '$newCustomerAddress3', '$newCustomerAddress4', '$newCustomerAddress5', '$newCustomerPhone', '$newCustomerEmail', '$newCustomerRegNo', '$newCustomerVATRegNo', NULLIF('$newCustomerInsurerID',''),NULL, NULL, NULLIF('$newCustomerBrokerID',''))";

$result = mysqli_query($link, $sql);

$lastID = $link->insert_id;

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Customer/Fleet $newCustomerName was created', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo $lastID . "success";

?>
