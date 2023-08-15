<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$isAdmin = $_SESSION['isAdmin'];
$isInstaller = $_SESSION['isInstaller'];
$isEngineer = $_SESSION['isEngineer'];

$userType = array (
    'isAdmin' => $isAdmin,
    'isInstaller' => $isInstaller,
    'isEngineer' => $isEngineer
);

    echo (json_encode($userType));

?>