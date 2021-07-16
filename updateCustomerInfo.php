<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$customerName = $_POST['customerName'];
$customerAddress1 = $_POST['customerAddr1'];
$customerAddress2 = $_POST['customerAddr2'];
$customerAddress3 = $_POST['customerAddr3'];
$customerAddress4 = $_POST['customerAddr4'];
$customerAddress5 = $_POST['customerAddr5'];
$customerPhone  = $_POST['customerPhone'];
$customerEmail = $_POST['customerEmail'];
// $customerRenewalType = $_POST['customerRenewalType'];
// $customerRenewalDate = $_POST['customerRenewalDate'];
// $customerRegNo = $_POST['customerRegNo'];
// $customerVATNo = $_POST['customerVATNo'];
$customerNumber = $_SESSION['currentCustomer'];

$errors = "";

// rules
// Max lengths are taken care of in the HTML /
// Name and 4 address lines need no additional check /
// Address 5 must be a valid postcode /
// Telephone should only be numeric done in HTML /
// Email should be a valid email address /
// RegNumber should only be numeric, done in HTML /
// VATNumber should be numeric and will be validated /
// Empty is allowed for all but company name /

if (strlen($customerName)==0) {
    $errors .= "You must enter a customer name<br>";
}

if (!(checkPostcode($customerAddress5)) && $customerAddress5 != "") {
    $errors .= "Postcode is not valid<br>";
}

if (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL) && $customerEmail!='') {
    $errors .= "Email address does not look to be valid<br>";
}

// check VAT Number
// if ($customerVATNo !='') {
//     $checksum = 0;
//     for ($ix=0; $ix<7; $ix++) {
//         $checksum += substr($customerVATNo, $ix,1) * (8-$ix);
//     }

//     $testCheck = $checksum;
//     $VATIsValid = false;

//     while ($testCheck>0) {
//         $testCheck = $testCheck - 97;
//     }

//     if (substr($customerVATNo,7,2) == -$testCheck) {
//         $VATIsValid = true;
//     }

//     // is it a newer VAT number?
//     if (!$VATIsValid) {
//         $testCheck = $checksum + 55;
//         while ($testCheck>0) {
//             $testCheck = $testCheck - 97;
//         }

//         if (substr($customerVATNo,7,2) == -$testCheck) {
//             $VATIsValid = true;
//         }
//     }

//     if (!$VATIsValid) {
//         $errors .= "VAT Number is not valid";
//     }
// }

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$customerName = mysqli_real_escape_string($link,filter_var($customerName, FILTER_SANITIZE_STRING));
$customerAddress1 = mysqli_real_escape_string($link,filter_var($customerAddress1, FILTER_SANITIZE_STRING));
$customerAddress2 = mysqli_real_escape_string($link,filter_var($customerAddress2, FILTER_SANITIZE_STRING));
$customerAddress3 = mysqli_real_escape_string($link,filter_var($customerAddress3, FILTER_SANITIZE_STRING));
$customerAddress4 = mysqli_real_escape_string($link,filter_var($customerAddress4, FILTER_SANITIZE_STRING));
$customerAddress5 = mysqli_real_escape_string($link,filter_var($customerAddress5, FILTER_SANITIZE_STRING));
$customerPhone = mysqli_real_escape_string($link,filter_var($customerPhone, FILTER_SANITIZE_STRING));
// $customerRegNo = mysqli_real_escape_string($link,filter_var($customerRegNo, FILTER_SANITIZE_STRING));
// $customerVATNo = mysqli_real_escape_string($link,filter_var($customerVATNo, FILTER_SANITIZE_STRING));
$customerEmail = mysqli_real_escape_string($link,filter_var($customerEmail, FILTER_SANITIZE_EMAIL));

$sql = "UPDATE tblCustomer SET businessName='$customerName', custAddressLine1 = '$customerAddress1', custAddressLine2 = '$customerAddress2', custAddressLine3 = '$customerAddress3', custAddressLine4 = '$customerAddress4', custAddressLine5 = '$customerAddress5', businessPhone='$customerPhone', businessEmail='$customerEmail' WHERE ID = '$customerNumber'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Customer $customerName was updated', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);
    


echo $customerNumber . "success";

?>
