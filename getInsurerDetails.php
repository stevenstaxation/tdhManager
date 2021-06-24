<?php
session_start();
include('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}
$insurerInfo = [];
$insurerID = $_POST['insurerNumber'];

$sql = "SELECT * FROM tblInsurer WHERE ID='$insurerID'";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);

$insurerInfo['ID'] = $insurerID;
$insurerInfo['insurerName'] = $row['insurerName'];
$insurerInfo['insurerAddress1'] = $row['insurerAddress1'];
$insurerInfo['insurerAddress2'] = $row['insurerAddress2'];
$insurerInfo['insurerAddress3'] = $row['insurerAddress3'];
$insurerInfo['insurerAddress4'] = $row['insurerAddress4'];
$insurerInfo['insurerAddress5'] = $row['insurerAddress5'];


// get contacts and put into a table

$sql = "SELECT * FROM tblInsurerContact WHERE insurerID='$insurerID'";
$result = mysqli_query($link, $sql);

$returnString = "";
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
$returnString .="<tr>";
$returnString .="<td class='align-middle' style='padding-left:3px;'>" . $row['firstName'] . "</td>";
$returnString .="<td class='align-middle' style='padding-left:3px;'>" . $row['lastName'] . "</td>";
$returnString .="<td class='align-middle' style='padding-left:3px;'>" . $row['jobTitle'] . "</td>";
$returnString .="<td class='text-center align-middle'>" . $row['mobileNo'] . "</td>";
$returnString .="<td class='text-center align-middle'>" . $row['telephone'] . "</td>";
$returnString .="<td class='align-middle' style='padding-left:3px;'>" . $row['email'] . "</td>";
$returnString .="<td class='align-middle' style='padding:0 3px;'><center><input type='checkbox' class='isFootageRequest' name='isFootageRequest' onclick='return false' " . ($row['isFootageRecipient'] == 1 ? 'checked' : '')." value='1'/>&nbsp;</center></td>";
$returnString .="<td class='align-middle' style='padding:0 3px;'><center><input type='checkbox' class='isHealthCheck' name='isHealthCheck' onclick='return false' " . ($row['isHealthCheck'] == 1 ? 'checked' : '')." value='1'/>&nbsp;</center></td>";
$returnString .="<td class='align-middle text-center'><btn class='btn btn-sm btn-warning' onclick='editInsurerContact(" .$row['ID'] . ")'><svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'><path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/></svg></btn></td>";
$returnString .="</tr>";
}

$insurerInfo['insurerContactTable'] = $returnString;



echo(json_encode($insurerInfo)); 



?>

