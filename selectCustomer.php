<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php"); 
}

$customerID = intval($_POST['customerID']);
$_SESSION['firstCustomer'] = '0';

if ($customerID ==0) {
    $customerID = $_SESSION['currentCustomer'];
}
// if (isset($_SESSION['currentCustomer'])==false) {
//     $_SESSION['currentCustomer'] = '0';
// }

$returnString = "
<div class='form-group form form-inline' style='margin-top:50px'>
    <label class='control-label' style='margin-top:6px;margin-right:10px;display: block;' for='getClient' id='customerSelection'>Select Customer</label>
     <div class='input-group'>
        <input type='hidden' value>";
            
   
            $returnString .="
   
    
            <select id='getClient' name='getClient' class='combobox form-control getClient' style='display: none;'><option></option>";

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


<script type='text/javascript'>
  $(document).ready(function(){
    $('.combobox').combobox();
  });
</script>

";

echo $returnString;


?>