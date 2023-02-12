<?php
session_start();
include '../../connect.php';
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$userID = $_SESSION['userID'];
$currentPassword = $_POST['currentPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$errors = '';

// is current password correct?
if(empty($_POST['currentPassword'])) {
    $errors .= "You must enter your current password.<br>";
} else {
    $currentPassword = filter_var($_POST['currentPassword'], FILTER_UNSAFE_RAW);
}

// is new password entered and secure enough?
if (empty($_POST['newPassword1'])) {
    $errors .= "You must enter a new password.<br>";
} elseif (!(strlen($_POST['newPassword1'])>=8 and preg_match('/[A-Z]/', $_POST['newPassword1']) and preg_match('/[0-9]/', $_POST['newPassword1']))) {
    $errors .= "New password does not meet security requirements.<br>";        
} else {
    $newPassword1 = filter_var($_POST['newPassword1'], FILTER_UNSAFE_RAW);
    if (empty($_POST['newPassword2'])) {
        $errors .= "You must confirm your new password.<br>";
    } else {
        $newPassword2 = filter_var($_POST['newPassword2'], FILTER_UNSAFE_RAW);
        if ($newPassword1 !== $newPassword2) {
            $errors .= "New password and confirmation do not match.<br>";
        }
    }
}   
// is current password correct?
$currentPassword = mysqli_real_escape_string($link, $currentPassword);
$currentPassword = hash('sha256', $currentPassword);
$sql = "SELECT * FROM tblUsers WHERE userID='$userID' AND password='$currentPassword'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result)!=1) {
    $errors .="Current password is incorrect.<br>";
}


if ($errors) {
    $resultMessage = "<div class='alart alert-danger' style='border-radius: 7px; padding: 4px 7px;margin-bottom: 10px;'>" . $errors . "</div";
    echo $resultMessage;
    exit();
}

$newPassword1 = mysqli_real_escape_string($link, $newPassword1);
$newPassword1 = hash('sha256', $newPassword1);

$sql = "UPDATE tblUsers SET password = '" . $newPassword1 . "' WHERE userID = '" . $userID . "'";

$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating password</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Password changed', '" . $_SESSION['userID'] . "')";
$result = mysqli_query($link, $sql);

echo "success";


?>