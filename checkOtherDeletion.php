<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$otherNumber = $_POST['otherNumber'];
    
    $sql = "SELECT * FROM tblOther WHERE tblOther.ID = '$otherNumber'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $otherName = $row['otherName']; 
    $returnString = "<div class='alert alert-danger'>";
    
// Partner has contacts attached?
$sql = "SELECT ID FROM tblOtherContact WHERE otherID='$otherNumber'";
$result = mysqli_query($link, $sql);
$anyContacts =  mysqli_num_rows($result);
    if ($anyContacts>1) {
        $returnString .= "There are $anyContacts contacts attached to $otherName. These contacts will be lost if you continue with the deletion.";
    } elseif ($anyContacts==1) {
        $returnString .= "There is $anyContacts contact attached to $otherName. The contact will be lost if you continue with the deletion.";
    }

if ($returnString !="<div class='alert alert-danger'>") {
    $returnString .= "<br><input type='radio' name='deleteOption' id='goAheadDeleteOther' style='margin: 10px'>Continue with delete
    <br><input type='radio' name='deleteOption' id='cancelDelete' style='margin: 10px' checked>Cancel
    <btn class='btn btn-danger btn-sm' style='margin-left: 50px' id='queryDeleteOther'>Go</btn>
    <div id='hiddenIDToDelete' class='d-none'>" . $otherNumber . "</div>";
    echo "<div class='alert alert-danger'>" . $returnString . "</div>";
    exit();
}
     
    
    
    $sql = "DELETE FROM tblOther WHERE tblOther.ID = '$otherNumber'";
    $result = mysqli_query($link, $sql);
 
    echo "<div class='alert alert-success'>$otherName has been deleted.</div>";

    $sql = "INSERT INTO tblEventLog (Description, UserID) VALUES ('Partner $otherName was deleted', '" . $_SESSION['userID']. "')";
    $result = mysqli_query($link, $sql);
    
    exit();


?>
