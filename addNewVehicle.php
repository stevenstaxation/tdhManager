<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$regNumber = $_POST['regNumber'];
$make = $_POST['make'];
$model = $_POST['model'];
$addDescription = $_POST['addDescription'];
$customerID = $_POST['allocateTo'];


// does the vehicle already exist?
$sql = "SELECT tblVehicle.regNumber, tblCustomer.businessName FROM tblVehicle INNER JOIN tblCustomer ON tblVehicle.ownerID=tblCustomer.ID WHERE regNumber='$regNumber'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result)!=0) {
    $row= mysqli_fetch_array($result);
    echo "<div class='alert alert-danger'>That registration already exists and is allocated to " . $row['businessName'] . "</div>";
    exit();
}

$sql = "INSERT INTO tblVehicle (make, model, addDescription, regNumber, ownerID) VALUES ('$make', '$model', '$addDescription', '$regNumber', '$customerID')";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error updating renewal type description</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('New vehicle $regNumber added', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


echo "success";


?>