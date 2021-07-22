<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$userName = $_POST['userName'];

$userName = mysqli_real_escape_string($link, filter_var($userName, FILTER_SANITIZE_STRING));

$userSplitName = explode(" ",$userName);

if (array_key_exists(0, $userSplitName)) {
    $userFirstName = $userSplitName[0];
} else {
    $userFirstName = 'unknown ';
    $userName = 'unknown ' . $userName;
}

if (array_key_exists(1, $userSplitName)) {
    $userLastName = $userSplitName[1];
} else {
    $userLastName = 'unknown';
    $userName .= ' unknown';
}



$sql = "INSERT INTO tblUsers (userName, email, password, activation, darkmode, isAdmin) VALUES ('$userName', 'unknown@unknown.com', 'AAAAAAAABBBBBBBBCCCCCCCCDDDDDDDDEEEEEEEEFFFFFFFF0000000011111111', 'pending', '0', '0')";
$result = mysqli_query($link, $sql);
$lastID = $link->insert_id;

if (!$result) {
    echo '<div class="alert alert-danger">Error adding hostoric user</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}


$sql = "INSERT INTO tblUserRecord (userID, firstName, lastName) VALUES ('$lastID', '$userFirstName', '$userLastName')";
$result = mysqli_query($link, $sql);


$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('New historic user $userName added', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";


?>