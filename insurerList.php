<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "<div class='container-fluid'>
<div id='insurerList' style = 'margin: 50px 15px 20px;'><h4><strong>Current Insurers</strong></h4></div>";

$returnString .= "

<form id = 'insurerList'>
<div id='editInsurerHide' style='display: none'></div>
<div class='row'>
    <div class='col-lg-5 col-xl-4 settings-dialog'>
            <h6><strong style='margin-top:5px;'>Select from list</strong></h6>
       ";

        $sql = 'SELECT * FROM tblInsurer ORDER BY insurerName ASC';
        $result = mysqli_query($link,$sql);
        
        $returnString .= "<select name='insurerNameSelection' id='insurerNameSelection' size='8' style='width:100%'>";
        while ($row = mysqli_fetch_array($result)) {
           $returnString .= "<option value='" . $row['ID'] . "'>" . $row['insurerName'] . "</option>";
        }
        $returnString .="</select>

            <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm mx-2' id='addNewInsurer' type='button' data-toggle='modal' data-target='#modalAddNewInsurer' data-caller='insurer'><i class='bi bi-plus-circle-fill' viewBox='0 0 16 16'></i> New Insurer</btn>";

                if ($_SESSION['isAdmin']== '1') {
                    $returnString .= "<btn class='btn btn-danger btn-sm deleteInsurer mx-2' onclick='deleteInsurer()' id='deleteInsurer' type='button'><i class='bi bi-trash-fill' viewBox='0 0 16 16'></i> Delete </btn>";
                }
                $returnString .="
            </div>
            <div id='currentInsurerMessageBox'></div>
        </div>
        <div class = 'col-1'></div>
        <div class='col-lg-6 col-xl-7 settings-dialog'>
            <h6><strong>Selected Insurer details</strong></h6>

            <div class='form-group insurerFormGroup'>
            <label class='control-label inline' for='editInsurerName'>Name </label>
            <div class='input-group'>
                <input maxlength='100' class='form-control' type='text' id='editInsurerName' name='editInsurerName' 
                placeholder='insurer name...' value=''>
            </div>   
        </div>
            <div class='form-group insurerFormGroup'>
                <label class='control-label inline' for='editInsurerAddress1'>Address </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInsurerAddress1' name='editInsurerAddress1' 
                    placeholder='address line 1...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>
                <label class='control-label inline' for='editInsurerAddress2'>Address </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInsurerAddress2' name='editInsurerAddress2' 
                    placeholder='address line 2...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>   
                <label class='control-label inline' for='editInsurerAddress3'>Town/City </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInsurerAddress3' name='editInsurerAddress3' 
                    placeholder='town/city...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>            
                <label class='control-label inline' for='editInsurerAddress4'>County </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInsurerAddress4' name='editInsurerAddress4' 
                    placeholder='county...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>        
                <label class='control-label inline' for='editInsurerAddress5'>Post Code </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInsurerAddress5' name='editInsurerAddress5' 
                    placeholder='post code...' value=''>
                </div>          
            </div>
            <hr>
            <div id='editInsurerMessage'></div>
            <div class='row'>
            <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm updateEditInsurer mx-2' onclick='updateEditInsurer()' id='updateEditInsurer' type='button'><i class='bi bi-arrow-up-left-circle-fill'></i>
             Update </btn>";
     
            $returnString .="
        </div>
            </div>
    </div>
    
</div>
<div class='row'>
<div class='col-lg-6 col-xl-5'></div>

<div class='col-lg-12 col-xl-7 settings-dialog'>
    <h6><strong>Contact details</strong></h6>
    <table class='table table-bordered table-sm'>
        <thead>
            <tr>
                <th class='align-middle pl-1'>First Name</th>
                <th class='align-middle pl-1'>Last Name</th> 
                <th class='align-middle pl-1'>Job Title</th>
                <th class='text-center align-middle'>Mobile</th>
                <th class='text-center align-middle'>Telephone</th>
                <th class='align-middle pl-1'>Email</th>
                <th class='text-center align-middle'>Footage</th>
                <th class='text-center align-middle'>Health Check</th>
                <th class='text-center align-middle'>Edit</th>
            </tr>
        </thead>
        <tbody id='insurerContactListHolder'></tbody>
    
    
    </table>
    <div id='hiddenInfo' style='display: none'></div>
        
    <btn class='btn btn-success btn-sm mx-2' id='btnAddNewContact' type='button' data-toggle='modal' data-target='#modalAddNewInsurerContact' data-caller='insurer'><i class='bi bi-person-lines-fill' viewBox='0 0 16 16'></i> New Contact </btn>

</div>


</div>


</form>
</div>
";

echo $returnString;

?>

                   

