<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$firstName = $_POST['contactFirstName'];
$lastName = $_POST['contactLastName'];
$mobile = $_POST['contactMobile'];
$telephone = $_POST['contactTelephone'];
$email = $_POST['contactEmail'];
$jobTitle = $_POST['contactJobTitle'];
$footageRecipient = $_POST['contactFootageRecipient'];
$healthCheck = $_POST['contactHealthCheck'];
$customerNumber = $_POST['customerNumber'];
$contactNumber = $_POST['contactNumber'];


if($footageRecipient=='true') {
    $footageRecipient = 1;
} else {
    $footageRecipient = 0;
}
if($healthCheck=='true') {
    $healthCheck = 1;
} else {
    $healthCheck = 0;
}
$errors = "";


if (!$firstName) {
    $errors .="You must include at least the contact's first name<br>";
}

if (!$mobile && !$telephone && !$email) {
    $errors .="You must include a mobile number, a telephone number or an email address<br>";
}

if (strlen($firstName)>30) {
    $firstName = substr($firstName,0,30);
}
if (strlen($lastName)>30) {
    $lastName = substr($contactLastName,0,30);
}

$mobile = str_replace(" ", "", $mobile);
$telephone = str_replace(" ", "", $telephone);

if (strlen($mobile)>20) {
    $errors .= "Mobile number should not be longer than 20 characters<br>";
}
if (!is_numeric($mobile)) {
    $mobile = preg_replace('/[^0-9]/', "", $mobile);
}

if (strlen($telephone)>20) {
    $errors .= "Mobile number should not be longer than 20 characters<br>";
}
if (!is_numeric($telephone)) {
    $telephone = preg_replace('/[^0-9]/', "", $telephone);
}

if (strlen($email)>100) {
    $errors .= "Email address should not be longer than 100 characters<br>";
}
if (strlen($jobTitle)>50) {
    $errors .= "Job title should not be longer than 50 characters<br>";
}


$firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
$lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
$mobile = filter_var($mobile, FILTER_SANITIZE_STRING);
$telephone = filter_var($telephone, FILTER_SANITIZE_STRING);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$jobTitle = filter_var($jobTitle, FILTER_SANITIZE_STRING);

if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email!='') {
    $errors .= "Email address does not look to be valid<br>";
}

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
$lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
$mobile = filter_var($mobile, FILTER_SANITIZE_STRING);
$telephone = filter_var($telephone, FILTER_SANITIZE_STRING);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$jobTitle = filter_var($jobTitle, FILTER_SANITIZE_STRING);

$firstName = mysqli_real_escape_string($link,$firstName);
$lastName = mysqli_real_escape_string($link,$lastName);
$mobile = mysqli_real_escape_string($link,$mobile);
$telephone = mysqli_real_escape_string($link,$telephone);
$email = mysqli_real_escape_string($link,$email);
$jobTitle = mysqli_real_escape_string($link,$jobTitle);

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$sql = "UPDATE tblCustomerContact SET businessID = '$customerNumber', firstName='$firstName', lastName='$lastName', mobileNo='$mobile', telephone='$telephone', email='$email', jobTitle='$jobTitle', isFootageRecipient='$footageRecipient', isHealthCheck='$healthCheck' WHERE tblCustomerContact.ID = '$contactNumber'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Customer contact $firstName $lastName was edited', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);
      

echo "success";

?>
