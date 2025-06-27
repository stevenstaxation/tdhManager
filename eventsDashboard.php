<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "<div id='eventsList' class='listHeader'><h4><strong>Device Events</strong></h4></div>";




echo $returnString;