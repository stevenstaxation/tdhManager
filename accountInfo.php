<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$userID = $_POST['userID'];
//$sql = "SELECT * FROM `tblUsers` WHERE tblUsers.userID = '$userID'";
$sql = "SELECT * FROM tblUsers JOIN tblUserRecord ON tblUsers.userID = tblUserRecord.userID WHERE tblUsers.userID = '$userID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$count = mysqli_num_rows($result);

if ($count !== 1) {
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$row = mysqli_fetch_array($result);

$foreColor = 'text-dark';
// $darkmode = 'nodarkmode';
$returnString = "";


$returnString = $returnString . "<h3 style='margin-top:50px;' class='$foreColor'><strong>Profile Information</strong></h3>";


$returnString = $returnString . "<form id='profileForm'><div id='showAccountInfo' class='settings-dialog' style='margin-top:15px; margin-bottom: 100px; border-width: 1px; border-style: solid; border-radius: 8px; padding: 20px;'><h5><strong style='margin-top:10px;class='$foreColor'>Settings</strong></h5><div id='errorBox'></div>";


$returnString = $returnString .
    "<div class='row'>
    <div class='col-md-6'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='emailAddress'>
                <strong>Email Address </strong>
                <a style=color:red>*</style></a>
            </label>
            <div class='input-group'>
                <input class='form-control enabler' type='email' id='inputEmailAddress' name='inputEmailAddress' placeholder='enter your Data Hub email address...' value='" . $row['email'] . "'>
            </div>
        </div>
    </div>

    <div class='col-md-6'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='password'>
                <strong>Password </strong>
                <a style=color:red>*</style></a>
            </label>
            <div class='input-group'>
                <input class='form-control enabler' type='password' id='inputPassword' name='inputPassword' readonly='readonly' value='" . $row['password'] . "'>
                <div class='input-group-append'>";

$returnString = $returnString .
    "</div>
            </div>
        </div>
    </div>
</div>";

$returnString = $returnString .
    "<div class='row'>
    <div class='col-md-6'>
        <div class='form-group'>
            <label class='control-label $foreColor' style='padding-top:10px;' for='firstName'>
                <strong>First Name </strong>
                <a style=color:red>*</style></a>
            </label>
            <div class='input-group'>
                <input class='form-control' type='text' id='inputFirstName' name='inputFirstName' placeholder='enter your first name...' value='" . $row['firstName'] . "'>
            </div>
        </div>
    </div>
    <div class='col-md-6'>
        <div class='form-group'>
            <label class='control-label $foreColor' style='padding-top:10px;' for='lastName'>
                <strong>Last Name </strong>
                <a style=color:red>*</style></a>
            </label>
            <div class='input-group'>
                <input class='form-control' type='text' id='inputLastName' name='inputLastName' placeholder='enter your last name...' value='" . $row['lastName'] . "'>
            </div>
        </div>
    </div>
</div><hr>";

$returnString = $returnString .
    "<div class='row'>
    <div class='col-md-6'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='address1' style='padding-top: 10px;'>
                <strong>Home Address</strong>
            </label>
            <div class='input-group' style='padding-top: 2px;'>
                <input class='form-control' type='text' id='address1' name='address1' value='" . $row['addressLine1'] . "'>
            </div>
            <div class='input-group' style='padding-top: 2px;'>
                <input class='form-control' type='text' id='address2' name='address2' value='" . $row['addressLine2'] . "'>
            </div>
            <div class='input-group' style='padding-top: 2px;'>
                <input class='form-control' type='text' id='address3' name='address3' value='" . $row['addressLine3'] . "'>
            </div>
            <div class='input-group' style='padding-top: 2px;'>
                <input class='form-control' type='text' id='address4' name='address4' value='" . $row['addressLine4'] . "'>
                <input class='form-control' type='text' id='address5' name='address5' value='" . $row['addressLine5'] . "' placeholder='enter postcode'>
            </div>
        </div>
    </div>
    <div class='col-md-6'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='mobileNumber' style='padding-top: 10px;'>
                <strong>Mobile Telephone</strong>
            </label>
            <div class='input-group'>
                <input class='form-control' type='text' id='mobileNumber' name='mobileNumber' placeholder='enter your mobile number...' value='" . $row['mobileNo'] . "'>
            </div>
            <label class='control-label $foreColor' for='personalEmail' style='padding-top: 10px;'>
                <strong>Personal Email</strong>
            </label>
            <div class='input-group'>
                <input class='form-control' type='email' id='personalEmail' name='personalEmail' placeholder='enter your personal email address...' value='" . $row['personalEmail'] . "'>
            </div>
        </div>
    </div>
<div><hr>";

if ($row['genderIsMale'] == '1') {
    $genderColor1 = 'background-color: #3276B1; color: white';
    $genderColor2 = 'background-color: white; color: #3276B1';
} else {
    $genderColor1 = 'background-color: white; color: #3276B1';
    $genderColor2 = 'background-color: #3276B1; color: white';
}

$returnString = $returnString .
    "<div class='row'>
    <div class='col-md-4'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='dateOfBirth' style='padding-top: 10px;'>
                <strong>Date of Birth</strong>
            </label>
            <div class='input-group'>
                <input class='form-control dateType' type='date' id='dateOfBirth' name='dateOfBirth' placeholder='enter your date of birth...' value='" . $row['dateOfBirth'] . "'>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='NINO' style='padding-top: 10px;'>
                <strong>National Insurance No.</strong>
            </label>
            <div class='input-group'>
                <input class='form-control' type='text' id='NINO' name='NINO' placeholder='enter your national insurance no....' value='" . $row['NINO'] . "'>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='form-group'>
            <label for='gender_radio' style='padding-top: 10px;' class='control-label text-right $foreColor'>
                <strong>Gender</strong>
            </label>
            <div class='input-group'>
                <div id='gender_radio' class='btn-group'>
                    <a class='btn btn-primary gender_radio' style='$genderColor1' onclick=toggleGender('male')>Male</a>
                    <a class='btn btn-primary gender_radio' style='$genderColor2' onclick=toggleGender('female')>Female</a>
                </div>
                <input type='hidden' name='gender' id='genderHidden' value='male'>
            </div>
        </div>
    </div>
</div><hr>";

$returnString = $returnString .
    "<div class='row'>
    <div class='col-md-8'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='jobTitle' style='padding-top: 10px;'>
                <strong>Job Title</strong>
            </label>
            <div class='input-group'>
                <input class='form-control' type='text' id='jobTitle' name='jobTitle' placeholder='enter your job title...' value='" . $row['jobTitle'] . "'>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='startDate' style='padding-top: 10px;'>
                <strong>Start Date</strong>
            </label>
            <div class='input-group'>
                <input class='form-control dateType' type='date' id='startDate' name='startDate' placeholder='select date employment started...' value='" . $row['startDate'] . "'>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='emergencyName' style='padding-top: 10px;'>
                <strong>Emergency Contact</strong>
                <a style=color:red>*</style></a>
            </label>
            <div class='input-group'>
                <input class='form-control' type='text' id='emergencyName' name='emergencyName' placeholder='enter emergency contact name...' value='" . $row['emergencyContactName'] . "'>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='form-group'>
            <label class='control-label $foreColor' for='contactNo' style='padding-top: 10px;'>
                <strong>Contact Number</strong>
                <a style=color:red>*</style></a>
            </label>
            <div class='input-group'>
                <input class='form-control' type='text' id='contactNo' name='contactNo' placeholder='enter contact number...' value='" . $row['emergencyContactNumber'] . "'>
            </div>
        </div>
    </div>
<div><hr>";

$returnString = $returnString .
    "<div class='row'>
    <div class='col-md-1'></div>

    <div class='col-4 col-md-3'>
        <button type='button' id='updateUser' name='updateUser' class='btn btn-success btn-block' disabled='disabled' style='border-radius: 5px;'>Update</button>
    </div>
    <div class='col-4 col-md-3'>
        <button type='button' id='discardUser' name='discardUser' class='btn btn-danger btn-block' disabled='disabled' onclick='showMyAccount()' style='border-radius: 5px;'>Discard</button>
    </div>
    <div class='col-4 col-md-3'>
        <button type='button' id='closeUser' name='closeUser'class='btn btn-warning btn-block' style='border-radius: 5px;'>Close</button>
    </div>
</div></form>";

echo $returnString;
