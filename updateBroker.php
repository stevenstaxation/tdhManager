<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


$brokerName = $_POST['brokerName'];
$brokerAddress1 = $_POST['brokerAddress1'];
$brokerAddress2 = $_POST['brokerAddress2'];
$brokerAddress3 = $_POST['brokerAddress3'];
$brokerAddress4 = $_POST['brokerAddress4'];
$brokerAddress5 = $_POST['brokerAddress5'];
$brokerID = $_POST['brokerID'];


$errors = "";

// rules
// Max lengths are taken care of in the HTML /
// Name and 4 address lines need no additional check /
// Address 5 must be a valid postcode or empty
// Empty is allowed for all but insurer name

if (strlen($brokerName)==0) {
    $errors .= "You must enter a broker name<br>";
}

if (!(checkPostcode($brokerAddress5)) && $brokerAddress5 != "") {
    $errors .= "Postcode is not valid<br>";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$brokerName = mysqli_real_escape_string($link,filter_var($brokerName, FILTER_SANITIZE_STRING));
$brokerAddress1 = mysqli_real_escape_string($link,filter_var($brokerAddress1, FILTER_SANITIZE_STRING));
$brokerAddress2 = mysqli_real_escape_string($link,filter_var($brokerAddress2, FILTER_SANITIZE_STRING));
$brokerAddress3 = mysqli_real_escape_string($link,filter_var($brokerAddress3, FILTER_SANITIZE_STRING));
$brokerAddress4 = mysqli_real_escape_string($link,filter_var($brokerAddress4, FILTER_SANITIZE_STRING));
$brokerAddress5 = mysqli_real_escape_string($link,filter_var(strtoupper($brokerAddress5), FILTER_SANITIZE_STRING));

$sql = "UPDATE tblBroker SET brokerName='$brokerName', addressLine1 = '$brokerAddress1', addressLine2 = '$brokerAddress2', addressLine3 = '$brokerAddress3', addressLine4 = '$brokerAddress4', addressLine5 = '$brokerAddress5' WHERE ID = '$brokerID'";

$result = mysqli_query($link, $sql);

$sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Broker $brokerName record was edited', '" . $_SESSION['userID']. "')";
$result = mysqli_query($link, $sql);


    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }

echo "success";

?>
