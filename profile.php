<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

// Define error messages
$missingEmail = "<p>You must include your email address.</p>";
$invalidCEmail = "<p>Your company email address appears to be invalid.</p>";
$missingPassword = "<p>Your pasword cannot be blank</p>";
$missingFirstName = "<p>You must include your first or preferred name.</p>";
$missingLastName = "<p>You must include your last or family name.</p>";
$invalidPostcode = "<p>Post code is not valid</p>";
$invalidMobile = "<p>Mobile phone number should only contain numbers.</p>";
$invalidPEmail = "<p>Your personal email address is invalid.</p>";
$invalidDOB = "<p>Your date of birth is invalid.</p>";
$tooOldDOB = "<p>Your date of birth makes you too old.</p>";
$tooYoungDOB = "<p>Your date of birth makes you too young.</p>";
$invalidNINO = "<p>Your NINO is invalid.</p>";
$invalidStartDate = "<p>Your employment start date is invalid.</p>";
$missingContactName = "<p>You must include an emergency contact name.</p>";
$missingContactNumber = "<p>You must include an emergency contact number.</p>";
$invalidContactNumber = "<p>You must enter a valid contact number.</p>";
// $invalidSortCode = "<p>Sort code appears to be invalid.</p>";
// $invalidAccountNo = "<p>Bank account number should only be numeric.</p>";
// $shortAccountNo = "<p>Bank account number must be at least 8 digits.</p>";

$emailaddress = $_POST['inputEmailAddress'];
$password = $_POST['inputPassword'];
$firstname = $_POST['inputFirstName'];
$lastname = $_POST['inputLastName'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$address3 = $_POST['address3'];
$address4 = $_POST['address4'];
$address5 = $_POST['address5'];
$mobileNo = $_POST['mobileNumber'];
$personalEmail = $_POST['personalEmail'];
$dateOfBirth = $_POST['dateOfBirth'];
$NINO = $_POST['NINO'];
$gender = $_POST['gender'];
$jobTitle = $_POST['jobTitle'];
$startDate = $_POST['startDate'];
$emergencyName = $_POST['emergencyName'];
$emergencyNumber = $_POST['contactNo'];
// $bankName = $_POST['bankName'];
// $bankSort = $_POST['bankSort'];
// $bankAccount = $_POST['bankAccount'];
//$darkMode = $_POST['darkMode'];

//if ($darkMode=='on') {
//    $darkMode = 1;
//} else {
//    $darkMode = 0;
//}
if ($gender=='male' || $gender=='1') {
    $gender = 1;
} else {
    $gender = 0;
}

$errors = "";
//Check email address exists and is valid
if (empty($emailaddress)) {
    $errors .= $missingEmail;
} else {
    $emailaddress = mysqli_real_escape_string($link,filter_var($emailaddress, FILTER_SANITIZE_EMAIL));

    if (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidCEmail;
    }
}
//Check password is not blank
if (empty($password)) {
    $errors .= $missingPassword;
} else {
    $password = mysqli_real_escape_string($link,filter_var($password, FILTER_SANITIZE_STRING));
}
//Check first name is not blank
if (empty($firstname)) {
    $errors .= $missingFirstName;
} else {
    $firstname = mysqli_real_escape_string($link,filter_var($firstname, FILTER_SANITIZE_STRING));
}
//Check last name is not blank
if (empty($lastname)) {
    $errors .= $missingLastName;
} else {
    $lastname = mysqli_real_escape_string($link,filter_var($lastname, FILTER_SANITIZE_STRING));
}

//First four address fields require no validation or checks
//Fifth field should be in postcode format but empty is allowed
if (!empty($address5)) {
    $valid = postcodeCheck($address5);
    if ($valid) {
        $address5 = mysqli_real_escape_string($link, $valid);
    } else {
        $errors .= $invalidPostcode;
    }
}
//Mobile number must be numeric only
//Remove spaces, tabs etc too
if ($mobileNo) {
$mobileNo = preg_replace('/\s+/', '', $mobileNo);
if (!is_numeric($mobileNo)) {
    $errors .= $invalidMobile;
} else {
    $mobileNo = mysqli_real_escape_string($link,filter_var($mobileNo, FILTER_SANITIZE_STRING));
}
}
//If personal email address exists check it is valid
if (!empty($personalEmail))  {
    $personalEmail = mysqli_real_escape_string($link,filter_var($personalEmail, FILTER_SANITIZE_EMAIL));

    if (!filter_var($personalEmail, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidPEmail;
    }
}
// Ensure DOB is a valid date
if ($dateOfBirth) {
if (!validateDate($dateOfBirth)) {
    $errors .= $invalidDOB;
} else {
        //Max age 99, Min age 16
        $age = date_diff(date_create($dateOfBirth), date_create('now'))->y;
        if ($age >99) {
            $errors .= $tooOldDOB;
        } elseif ($age <16) {
            $errors .= $tooYoungDOB;
        }
        $dateOfBirth = mysqli_real_escape_string($link,filter_var($dateOfBirth, FILTER_SANITIZE_STRING));
    }
}

if ($NINO) {
//Ensure NINO is valid
// Format is 2 letters 6 numbers and one letter, e.g. QQ123456A
// The final letter must be A, B, C or D
// The characters D, F, I, Q, U and V cannot be either of the first two characters
// The character O cannot be the second character
// Prefixes BG, GB, KN, NK, NT, TN and ZZ are not valid
$regex = "^(?!BG)(?!GB)(?!NK)(?!KN)(?!TN)(?!NT)(?!ZZ)";
$regex = "/^(?!BG)(?!GB)(?!NK)(?!KN)(?!TN)(?!NT)(?!ZZ)[A-CEGHJ-PR-TW-Z]{1}[A-CEGHJ-NPR-TW-Z]{1}[0-9]{6}[A-D]{0,1}$/i";

if (preg_match($regex, $NINO)==0) {
    $errors .= $invalidNINO;
}
}

// Ensure start date is valid, must be after 23/10/2014 and before today
if ($startDate) {
if (!validateDate($startDate)) {
    $errors .= $invalidStartDate;
} else {
        //Max date is today,  min date is 23/10/2014
         if (date_create($startDate)< date_create('2014-10-23') || date_create($startDate) > date_create('now')) {
             $errors .= $invalidStartDate;
         }
}
}


// Emergency contact name must exist
if (!$emergencyName) {
    $errors .= $missingContactName;
} else {
    $emergencyName = mysqli_real_escape_string($link,filter_var($emergencyName, FILTER_SANITIZE_STRING));
}

// Emergency number must exists and be numeric
if (!$emergencyNumber) {
    $errors .= $missingContactNumber;
} else {
    $emergencyNumber = preg_replace('/\s+/', '', $emergencyNumber);
    if (!is_numeric($emergencyNumber)) {
        $errors .= $invalidContactNumber;
    }
}

//Sort code is XXXXXX or XX-XX-XX only and cannot be all zeroes
// if ($bankSort) {
// $regex="/^(?!(?:0{6}|00-00-00))(?:\d{6}|\d\d-\d\d-\d\d)$/";
// if (preg_match($regex, $bankSort)==0) {
//     $errors .= $invalidSortCode;
// }
// }

//Account number should be numeric and at least 8 digits
// if ($bankAccount) {
//  $bankAccount = preg_replace('/\s+/', '', $bankAccount);
//     if (!is_numeric($bankAccount)) {
//         $errors .= $invalidAccountNo;
//     } elseif (strlen($bankAccount)<8) {
//         $errors .= $shortAccountNo;
//     }
// }

//These fields did not need any validation
//but they need to be escaped to resists injection attacks
$address1 = mysqli_real_escape_string($link, filter_var($address1, FILTER_SANITIZE_STRING));
$address2 = mysqli_real_escape_string($link, filter_var($address2, FILTER_SANITIZE_STRING));
$address3 = mysqli_real_escape_string($link, filter_var($address3, FILTER_SANITIZE_STRING));
$address4 = mysqli_real_escape_string($link, filter_var($address4, FILTER_SANITIZE_STRING));
$jobTitle = mysqli_real_escape_string($link, filter_var($jobTitle, FILTER_SANITIZE_STRING));
// $bankName = mysqli_real_escape_string($link, filter_var($bankName, FILTER_SANITIZE_STRING));



// print any errors
if ($errors) {
    $resultMessage = "<div class='container alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
} else {
    $userID= $_SESSION['userID'];

//    $sql = "UPDATE tblUsers SET email='$emailaddress', password='$password', firstName='$firstname', lastname='$lastname', darkmode='$darkMode', mobileNo='$mobileNo', personalEmail='$personalEmail', addressLine1='$address1', addressLine2='$address2', addressLine3='$address3', addressLine4='$address4', addressLine5='$address5', genderIsMale='$gender', jobTitle='$jobTitle', dateOfBirth='$dateOfBirth', NINO='$NINO', startDate='$startDate', bankSortCode='$bankSort', bankAccountNo='$bankAccount', bankAccountName='$bankName', EmergencyContactName='$emergencyName', EmergencyContactNumber='$emergencyNumber' WHERE userID='$userID'";

    $sql = "UPDATE tblUsers SET email='$emailaddress', password='$password', darkmode='0' WHERE userID='$userID'";

    $result = mysqli_query($link, $sql);

     if (!$result) {
        echo '<div class="alert alert-danger">Cannot update the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    $sql = "UPDATE tblUserRecord SET firstName='$firstname', lastName='$lastname', mobileNo=NULLIF('$mobileNo',''), personalEmail=NULLIF('$personalEmail',''), addressLine1=NULLIF('$address1',''), addressLine2=NULLIF('$address2',''), addressLine3=NULLIF('$address3',''), addressLine4=NULLIF('$address4',''), addressLine5 = NULLIF('$address5',''), genderIsMale='$gender', jobTitle=NULLIF('$jobTitle',''), dateOfBirth=NULLIF('$dateOfBirth',''), NINO=NULLIF('$NINO',''),startDate=NULLIF('$startDate',''), bankSortCode=NULLIF('$bankSort',''), bankAccountNo=NULLIF('$bankAccount',''), bankAccountName=NULLIF('$bankName',''), emergencyContactName='$emergencyName', emergencyContactNumber='$emergencyNumber' WHERE userID='$userID'";

    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Cannot update the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('User profile updated', '" . $userID . "')";  
    $result = mysqli_query($link, $sql);


    echo 'success';
}



function postcodeCheck($postCodeToCheck) {
    $alpha1 = "[abcdefghijklmnoprstuwyz]";
    $alpha2 = "[abcdefghklmnopqrstuvwxy]";
    $alpha3 = "[abcdefghjkstuw]";
    $alpha4 = "[abehmnprvwxy]";
    $alpha5 = "[abdefghjlnpqrstuwxyz]";

    //Expression for postcodes: AN NAA, ANN NAA, AAN NAA, and AANN NAA with a space
    $pcexp[0] = '^(' . $alpha1 . '{1}' . $alpha2 . '{0,1}[0-9]{1,2})([[:space:]]{0,})([0-9]{1}' . $alpha5 . '{2})?$';

    // Expression for postcodes: ANA NAA
    $pcexp[1] = '^(' . $alpha1 . '{1}[0-9]{1}' . $alpha3 . '{1})([[:space:]]{0,})([0-9]{1}' . $alpha5 . '{2})?$';

    // Expression for postcodes: AANA NAA
    $pcexp[2] = '^(' . $alpha1 . '{1}' . $alpha2 . '[0-9]{1}' . $alpha4 . ')([[:space:]]{0,})([0-9]{1}' . $alpha5 . '{2})?$';

    // Exception for the special postcode GIR 0AA
    $pcexp[3] = '^(gir)([[:space:]]{0,})?(0aa)?$';

    // Standard BFPO numbers
    $pcexp[4] = '^(bfpo)([[:space:]]{0,})([0-9]{1,4})$';

    // c/o BFPO numbers
    $pcexp[5] = '^(bfpo)([[:space:]]{0,})(c\/o([[:space:]]{0,})[0-9]{1,3})$';

    // Overseas Territories
    $pcexp[6] = '^([a-z]{4})([[:space:]]{0,})(1zz)$';

    // Anquilla
    $pcexp[7] = '^(ai\-2640)$';

    $postcode = strtolower($postCodeToCheck);
    $valid = FALSE;

    // Check the string against the six types of postcodes
    foreach ($pcexp as $regexp) {
        if (preg_match('/' . $regexp . '/i', $postcode, $matches)) {
            // Load new postcode back into the form element
            $postcode = strtoupper($matches[1]);
            if (isset($matches[3])) {
                $postcode .= ' ' . strtoupper($matches[3]);
            }

            // Take account of the special BFPO c/o format
            $postcode = preg_replace('/C\/O/', 'c/o ', $postcode);

            $valid = TRUE;
            break;
        }
    }

   return $valid ? $postcode : FALSE;
}

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
?>
