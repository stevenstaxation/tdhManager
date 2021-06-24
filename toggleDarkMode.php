<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$_SESSION['darkMode'] = !($_SESSION['darkMode']);




if ($_SESSION['darkMode']!=1) {
    // NORMAL MODE
        $_SESSION['navbarImage'] = "images/logo_swirl.png";
        $_SESSION['textColor'] = '#222222';
        $_SESSION['renewalColor'] = '#ffffff';
        $_SESSION['darkMode']=0;
} else {
//     // DARK MODE
        $_SESSION['navbarImage'] = "images/logo_swirl_black.png";
        $_SESSION['textColor'] = '#dddddd';
        $_SESSION['renewalColor'] = '#545454';
        $_SESSION['darkMode']=1;
}

// write user preference to database

$sql = "UPDATE tblUsers SET darkmode='" . $_SESSION['darkMode'] . "' WHERE userID = '" .$_SESSION['userID'] . "'";

$result = mysqli_query($link, $sql);

if ($result) {
     echo 'success';
}
?>

