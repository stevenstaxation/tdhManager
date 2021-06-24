<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$brokerID = $_GET['brokerID'];


$sql = "UPDATE tblCustomer SET brokerID='$brokerID' WHERE ID = '" .$_SESSION['currentCustomer'] . "'";

$result = mysqli_query($link, $sql);

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

echo $_SESSION['currentCustomer'];
echo "success";

?>
