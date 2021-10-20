<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$usersToUpdate = $_POST['dataListToPost'];
$affectedRecords = 0;

foreach ($usersToUpdate as $userToUpdate) {

  if ($userToUpdate['isActive'] == '1') {
    $activationFlag = 'activated';
  } else {
    $activationFlag = 'disabled';
  }

  if ($userToUpdate['isAnAdmin'] != '1') {
    $adminFlag = '0';
  } else {
    $adminFlag = '1';
  }
  if ($userToUpdate['isInstaller'] != '1') {
    $installerFlag = '0';
  } else {
    $installerFlag = '1';
  }
  if ($userToUpdate['isEngineer'] != '1') {
    $engineerFlag = '0';
  } else {
    $engineerFlag = '1';
  }

  // if this is the best way to do it then SQL is crap!
  $sql = "SELECT isAdmin, isInstaller, isEngineer, activation, email FROM tblUsers WHERE userID = '" . $userToUpdate['userID'] . "'";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_array($result);

  $oldAdmin = $row['isAdmin'];
  $oldActive = $row['activation'];
  $oldInstaller = $row['isInstaller'];
  $oldEngineer = $row['isEngineer'];
  $userUpdating = $row['email'];

$sql = "UPDATE tblUsers SET isAdmin='" . $adminFlag ."',isInstaller='" . $installerFlag ."',isEngineer='" . $engineerFlag ."', activation='" . $activationFlag ."' WHERE userID='" . $userToUpdate['userID'] . "'";
$result = mysqli_query($link, $sql);
if (!result) {echo "Update users error";}

$sql = "SELECT isAdmin, isInstaller, isEngineer, activation, email FROM tblUsers WHERE userID = '" . $userToUpdate['userID'] . "'";
$result = mysqli_query($link, $sql);
if (!result) {echo "Select users error";}

$row = mysqli_fetch_array($result);

$newAdmin = $row['isAdmin'];
$newActive = $row['activation'];
$newInstaller = $row['isInstaller'];
$newEngineer = $row['isEngineer'];


// var_dump ($userUpdating);
// var_dump ($oldAdmin);
// var_dump ($oldActive);
// var_dump ($newAdmin);
// var_dump ($newActive);



if ($oldAdmin != $newAdmin) {
  if ($newAdmin=="1") {
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('User made an administrator - $userUpdating', '" . $_SESSION['userID']. "')";
  } else {
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('User no longer an administrator - $userUpdating', '" . $_SESSION['userID']. "')";
  } 
  $result = mysqli_query($link, $sql);
}
if ($oldActive != $newActive) {
  if ($newActive=="activated") {
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('User account activated - $userUpdating', '" . $_SESSION['userID']. "')";
  } else {
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('User account deactivated - $userUpdating', '" . $_SESSION['userID']. "')";
  } 
  $result = mysqli_query($link, $sql);
}
if ($oldInstaller != $newInstaller) {
  if ($newInstaller=="1") {
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('User made an installer - $userUpdating', '" . $_SESSION['userID']. "')";
  } else {
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('User no longer an installer - $userUpdating', '" . $_SESSION['userID']. "')";
  } 
  $result = mysqli_query($link, $sql);
}
if ($oldEngineer != $newEngineer) {
  if ($newEngineer=="1") {
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('User made an engineer - $userUpdating', '" . $_SESSION['userID']. "')";
  } else {
    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('User no longer an engineer - $userUpdating', '" . $_SESSION['userID']. "')";
  } 
  $result = mysqli_query($link, $sql);
}



}


echo 'success';


?>
