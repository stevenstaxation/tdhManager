
  <!-- dataToPost.installerName = document.getElementById('addInstallerName').value;
    dataToPost.installerAddress1 = document.getElementById('addInstallerAddress1').value;
    dataToPost.installerAddress2 = document.getElementById('addInstallerAddress2').value;
    dataToPost.installerAddress3 = document.getElementById('addInstallerAddress3').value;
    dataToPost.installerAddress4 = document.getElementById('addInstallerAddress4').value;
    dataToPost.installerAddress5  -->


<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$newInstallerName = $_POST['installerName'];
$newInstallerAddress1 = $_POST['installerAddress1'];
$newInstallerAddress2 = $_POST['installerAddress2'];
$newInstallerAddress3 = $_POST['installerAddress3'];
$newInstallerAddress4 = $_POST['installerAddress4'];
$newInstallerAddress5 = $_POST['installerAddress5'];



$errors = "";
// rules
// Must include installer name /


if (!$newInstallerName) {
    $errors .="You must include the Installer name<br>";
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

$newInstallerName = mysqli_real_escape_string($link,filter_var($newInstallerName, FILTER_SANITIZE_STRING));
$newInstallerAddress1 = mysqli_real_escape_string($link,filter_var($newInstallerAddress1, FILTER_SANITIZE_STRING));
$newInstallerAddress2 = mysqli_real_escape_string($link,filter_var($newInstallerAddress2, FILTER_SANITIZE_STRING));
$newInstallerAddress3 = mysqli_real_escape_string($link,filter_var($newInstallerAddress3, FILTER_SANITIZE_STRING));
$newInstallerAddress4 = mysqli_real_escape_string($link,filter_var($newInstallerAddress4, FILTER_SANITIZE_STRING));
$newInstallerAddress5 = mysqli_real_escape_string($link,filter_var($newInstallerAddress5, FILTER_SANITIZE_STRING));


$sql = "INSERT INTO tblInstaller (installerName, installerAddress1, installerAddress2, installerAddress3, installerAddress4, installerAddress5) VALUES ('$newInstallerName','$newInstallerAddress1', '$newInstallerAddress2', '$newInstallerAddress3', '$newInstallerAddress4', '$newInstallerAddress5')";

$result = mysqli_query($link, $sql);

$lastInstallerID = $link->insert_id;

    if (!$result) {
        echo '<div class="alert alert-danger">Error accessing the database</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


$lastID = $_SESSION['currentCustomer'];

  if (!$result) {
        echo '<div class="alert alert-danger">Error updating insurer</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit();
    }


    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Installer $newInstallerName was created', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);
    



    echo $lastID . "/" . $lastInstallerID . "success";

?>
