<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}
$brokerInfo = [];

$brokerID = $_POST['brokerNumber'];

$sql = "SELECT * FROM tblBroker WHERE ID='$brokerID'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);

$brokerInfo['ID'] = $brokerID;
$brokerInfo['brokerName'] = $row['brokerName'];
$brokerInfo['brokerAddress1'] = $row['addressLine1'];
$brokerInfo['brokerAddress2'] = $row['addressLine2'];
$brokerInfo['brokerAddress3'] = $row['addressLine3'];
$brokerInfo['brokerAddress4'] = $row['addressLine4'];
$brokerInfo['brokerAddress5'] = $row['addressLine5'];


// get contacts and put into a table

$sql = "SELECT * FROM tblBrokerContact WHERE brokerID='$brokerID'";
$result = mysqli_query($link, $sql);

$returnString = "";
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
$returnString .="<tr>";
$returnString .="<td class='align-middle' style='padding-left:3px;'>" . $row['firstName'] . "</td>";
$returnString .="<td class='align-middle' style='padding-left:3px;'>" . $row['lastName'] . "</td>";
$returnString .="<td class='align-middle' style='padding-left:3px;'>" . $row['department'] . "</td>";
$returnString .="<td class='text-center align-middle'>" . $row['mobileNo'] . "</td>";
$returnString .="<td class='text-center align-middle'>" . $row['telephone'] . "</td>";
$returnString .="<td class='align-middle' style='padding-left:3px;'>" . $row['email'] . "</td>";
$returnString .="<td class='align-middle' style='padding:0 3px;'><center><input type='checkbox' class='isFootageRequest' name='isFootageRequest' onclick='return false' " . ($row['isFootageRecipient'] == 1 ? 'checked' : '')." value='1'/>&nbsp;</center></td>";
$returnString .="<td class='align-middle' style='padding:0 3px;'><center><input type='checkbox' class='isReporting' name='isReporting' onclick='return false' " . ($row['isReporting'] == 1 ? 'checked' : '')." value='1'/>&nbsp;</center></td>";
$returnString .="<td class='align-middle text-center'><btn class='btn btn-sm btn-warning' onclick='editBrokerContact(" .$row['ID'] . ")'><i class='bi bi-pencil-fill'></i></btn></td>";
$returnString .="</tr>";
}

$brokerInfo['brokerContactTable'] = $returnString;



echo(json_encode($brokerInfo)); 



?>

