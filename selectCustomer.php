<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php"); 
}

$customerID = intval($_POST['customerID']);
$_SESSION['firstCustomer'] = '0';
$_SESSION['currentCustomer'] = '0';


$returnString = "
<div class='row form-group form form-inline' style='margin-top:50px'>
    <label class='col-4 col-md-3 control-label' style='margin-top:6px; text-align: left;' for='selectClient' id='customerSelection'>Select Customer</label>
        <div class='input-group' style='width:75%'>
            <select id='getClient' name='getClient' class='custom-select col-5 getClient'>";

                $sql = "SELECT * FROM tblCustomer ORDER BY businessName ASC";
                $result = mysqli_query($link,$sql);

                while ($row = mysqli_fetch_array($result)) {
                    if ($customerID == 0) {
                        $customerID = $row['ID'];
                        $_SESSION['firstCustomer'] = $customerID;
                    }
                    if ($customerID == $row['ID']) {
                        $returnString .= "<option value= ". $row['ID']. " selected> " . $row['businessName'] . "</option>";
                        $_SESSION['currentCustomer'] = $row['ID'];
                    } else {
                        $returnString .= "<option value= ". $row['ID']. "> " . $row['businessName'] . " </option>";
                    }
                }

$returnString .="
            </select>
            <div class='input-group-append'>
                <button class='btn btn-success updateCustomer' id='addNewCustomer' type='button' data-toggle='modal' data-target='#modalAddNewCustomer'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'>
                <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/>
                </svg> New </button>
            </div>    
        </div>
</div>
";

echo $returnString;


?>