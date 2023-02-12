<?php
session_start();
include('../../connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

// Define error messages
$missingEmail = "<p>You must include your email address.</p>";
$invalidCEmail = "<p>Your email address appears to be invalid.</p>";
$missingPassword = "<p>Your pasword cannot be blank</p>";
$missingFirstName = "<p>You must include your first or preferred name.</p>";
$missingLastName = "<p>You must include your last or family name.</p>";

// Get parameters passed from Javascript
$emailaddress = $_POST['inputEmailAddress'];
$password = $_POST['inputPassword'];
$firstname = $_POST['inputFirstName'];
$lastname = $_POST['inputLastName'];

$errors = "";
// Check email address exists and is valid
if (empty($emailaddress)) {
    $errors .= $missingEmail;
} else {
    $emailaddress = mysqli_real_escape_string($link,filter_var($emailaddress, FILTER_SANITIZE_EMAIL));

    if (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidCEmail;
    }
}

// Check password is not blank
if (empty($password)) {
    $errors .= $missingPassword;
} else {
    $password = mysqli_real_escape_string($link,filter_var($password, FILTER_UNSAFE_RAW));
}

// Check first name is not blank
if (empty($firstname)) {
    $errors .= $missingFirstName;
} else {
    $firstname = mysqli_real_escape_string($link,filter_var($firstname, FILTER_UNSAFE_RAW));
}

// Check last name is not blank
if (empty($lastname)) {
    $errors .= $missingLastName;
} else {
    $lastname = mysqli_real_escape_string($link,filter_var($lastname, FILTER_UNSAFE_RAW));
}


//These fields did not need any validation
//but they need to be escaped to resists injection attacks
// $address1 = mysqli_real_escape_string($link, filter_var($address1, FILTER_SANITIZE_STRING));
// $address2 = mysqli_real_escape_string($link, filter_var($address2, FILTER_SANITIZE_STRING));
// $address3 = mysqli_real_escape_string($link, filter_var($address3, FILTER_SANITIZE_STRING));
// $address4 = mysqli_real_escape_string($link, filter_var($address4, FILTER_SANITIZE_STRING));
// $jobTitle = mysqli_real_escape_string($link, filter_var($jobTitle, FILTER_SANITIZE_STRING));
// $bankName = mysqli_real_escape_string($link, filter_var($bankName, FILTER_SANITIZE_STRING));



// print any errors
if ($errors) {
    $resultMessage = "<div class='container alert alert-secondary'>" . $errors . "</div>";
    echo $resultMessage;
} else {
    $userID= $_SESSION['userID'];

//    $sql = "UPDATE tblUsers SET email='$emailaddress', password='$password', firstName='$firstname', lastname='$lastname', darkmode='$darkMode', mobileNo='$mobileNo', personalEmail='$personalEmail', addressLine1='$address1', addressLine2='$address2', addressLine3='$address3', addressLine4='$address4', addressLine5='$address5', genderIsMale='$gender', jobTitle='$jobTitle', dateOfBirth='$dateOfBirth', NINO='$NINO', startDate='$startDate', bankSortCode='$bankSort', bankAccountNo='$bankAccount', bankAccountName='$bankName', EmergencyContactName='$emergencyName', EmergencyContactNumber='$emergencyNumber' WHERE userID='$userID'";

    $sql = "UPDATE tblUsers SET userName='" . $firstname ." ". $lastname ."', email='$emailaddress', password='$password', darkmode='0' WHERE userID='$userID'";

    $result = mysqli_query($link, $sql);

     if (!$result) {
        echo '<div class="alert alert-danger">Cannot update the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

    // get user record before update
    $sql = "SELECT * FROM tblUserRecord WHERE userID='$userID'";
    $prev = mysqli_fetch_assoc(mysqli_query($link, $sql));

    // update user record
    $sql = "UPDATE tblUserRecord SET firstName='$firstname', lastName='$lastname' WHERE userID='$userID'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">Cannot update the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

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
