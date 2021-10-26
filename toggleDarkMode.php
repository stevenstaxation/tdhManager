<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


if ($_SESSION['darkMode']==1) {
    $_SESSION['darkMode']=0;
} else {
    $_SESSION['darkMode']=1;
}

//  $_SESSION['darkMode'] = !($_SESSION['darkMode']);



// if ($_SESSION['darkMode']!=1) {
//     // NORMAL MODE
//       //  $_SESSION['navbarImage'] = "images/logo_swirl.png";
//         $_SESSION['textColor'] = '#222222';
//         $_SESSION['renewalColor'] = '#ffffff';
//  } else {
//     // DARK MODE
//       //  $_SESSION['navbarImage'] = "images/logo_swirl_black.png";
//         $_SESSION['textColor'] = '#dddddd';
//         $_SESSION['renewalColor'] = '#545454';
//  }

// write user preference to database

$sql = "UPDATE tblUsers SET darkMode='" . $_SESSION['darkMode'] . "' WHERE userID = '" .$_SESSION['userID'] . "'";

$result = mysqli_query($link, $sql);

if ($result) {
     echo 'success' . $_SESSION['darkMode'];
}
?>

