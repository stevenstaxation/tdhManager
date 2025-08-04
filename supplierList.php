<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "<div class='container-fluid'>
<div id='supplierList' style = 'margin: 50px 15px 20px;'><h4><strong>Current Suppliers</strong></h4></div>";

$returnString .= "

<form id = 'supplierList'>
<div id='editSupplierHide' class='d-none'></div>
<div class='row'>
    <div class='col-lg-5 col-xl-4 settings-dialog'>
            <h6><strong style='margin-top:5px;'>Select from list</strong></h6>
       ";

        $sql = 'SELECT * FROM tblSupplier ORDER BY supplierName ASC';
        $result = mysqli_query($link,$sql);
        
        $returnString .= "<select name='supplierNameSelection' id='supplierNameSelection' size='8' style='width:100%'>";
        while ($row = mysqli_fetch_array($result)) {
            $returnString .= "<option value='" . $row['ID'] . "'>" . $row['supplierName'] . "</option>";
        }
        $returnString .="</select>

        <div class='btn-group d-flex' style ='margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm mx-2' id='addNewSupplier' type='button' data-toggle='modal' data-target='#modalAddNewSupplier' data-caller='supplier'><i class='bi bi-plus-circle-fill'></i> New Supplier</btn>";

                if ($_SESSION['isAdmin']== '1') {
                    $returnString .= "<btn class='btn btn-danger btn-sm deleteSupplier mx-2' onclick='deleteSupplier()' id='deleteSupplier' type='button'><i class='bi bi-trash-fill'></i> Delete </btn>";
                }
                $returnString .="
        </div>
        <div id='currentSupplierMessageBox'></div>
    </div>
        <div class = 'col-1'></div>
        <div class='col-lg-6 col-xl-7 settings-dialog'>
            <h6><strong style='margin-top:10px;'>Selected Supplier details</strong></h6>

            <div class='form-group insurerFormGroup'>
            <label class='control-label inline' for='supplierName'>Name </label>
            <div class='input-group'>
                <input maxlength='100' class='form-control' type='text' id='editSupplierName' name='editSupplierName' 
                placeholder='supplier name...' value=''>
            </div>   
        </div>
            <div class='form-group insurerFormGroup'>
                <label class='control-label inline' for='editSupplierAddress1'>Address </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editSupplierAddress1' name='editSupplierAddress1' 
                    placeholder='address line 1...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>
                <label class='control-label inline' for='editSupplierAddress2'>Address </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editSupplierAddress2' name='editSupplierAddress2' 
                    placeholder='address line 2...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>   
                <label class='control-label inline' for='editSupplierAddress3'>Town/City </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editSupplierAddress3' name='editSupplierAddress3' 
                    placeholder='town/city...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>            
                <label class='control-label inline' for='editSupplierAddress4'>County </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editSupplierAddress4' name='editSupplierAddress4' 
                    placeholder='county...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>        
                <label class='control-label inline' for='editSupplierAddress5'>Post Code </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editSupplierAddress5' name='editSupplierAddress5' 
                    placeholder='post code...' value=''>
                </div>          
            </div>
            <hr>
            <div id='editSupplierMessage'></div>
            <div class='row'>
            <div class='btn-group d-flex' style ='margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm updateEditSupplier mx-2' onclick='updateEditSupplier()' id='updateEditSupplier' type='button'><i class='bi bi-arrow-up-left-circle-fill'></i> Update </btn>";
            
            $returnString .="
        </div>
            </div>
    </div>
    
</div>
<div class='row'>
<div class='col-lg-6 col-xl-5'></div>

<div class='col-lg-12 col-xl-7 settings-dialog'>
    <h6><strong style='margin-top:10px;'>Contact details</strong></h6>
    <table class='table table-bordered table-sm'>
        <thead>
            <tr>
                <th class='align-middle pl-1'>First Name</th>
                <th class='align-middle pl-1'>Last Name</th> 
                <th class='align-middle pl-1'>Department</th>
                <th class='text-center align-middle'>Mobile</th>
                <th class='text-center align-middle'>Telephone</th>
                <th class='align-middle pl-1'>Email</th>

                <th class='text-center align-middle'>Edit</th>
            </tr>
        </thead>
        
        <tbody id='supplierContactListHolder'></tbody>
    
    
    </table>
    <div id='hiddenInfo' class='d-none'></div>

    <btn class='btn btn-success btn-sm' id='btnAddNewSupplier mx-2' type='button' data-toggle='modal' data-target='#modalAddNewSupplierContact' data-caller='supplier'><i class='bi bi-person-lines-fill'></i> New Contact </btn>

</div>


</div>


</form>
</div>
";

echo $returnString;

?>

                   

