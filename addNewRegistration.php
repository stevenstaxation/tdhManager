<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$regNumber = $_POST['NewVRN'];
$customerID = $_POST['customerID'];

if ($regNumber == '') { 
    $regNumber = 'TBC';
} 

$errors="";

if ($customerID==0 || $customerID==null) {
    $errros = "You need to select a customer first";
}

// does the vehicle already exist?
if ($regNumber!='TBC') {
    $sql = "SELECT tblVehicle.regNumber, tblCustomer.businessName FROM tblVehicle LEFT JOIN tblCustomer ON tblCustomer.ID=tblVehicle.ownerID WHERE regNumber='$regNumber'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result)!=0) {
        $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo "<div class='alert alert-danger'>That registration already exists and is allocated to " . $row['businessName'] . "</div>";
        exit();
    }
}

if ($errors) {
    echo "<div class='alert alert-danger'>" .$errors . "</div>";
    exit();
}

$sql = "INSERT INTO tblVehicle (regNumber, ownerID) VALUES ( '$regNumber', '$customerID')";

$result = mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error adding vehicle</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$vehicleID = mysqli_insert_id($link);

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('New vehicle $regNumber added', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


$vrString = $vehicleID;

echo $vrString . "success";
?>

