<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "<div class='container-fluid'>
<div id='otherList' style = 'margin: 50px 15px 20px;'><h4><strong>Other Partners</strong></h4></div>";

$returnString .= "

<form id = 'otherList'>
<div id='editOtherHide' style='display: none'></div>
<div class='row'>
    <div class='col-lg-5 col-xl-4 settings-dialog'>
            <h6><strong style='margin-top:5px;'>Select from list</strong></h6>
       ";

        $sql = 'SELECT * FROM tblOther ORDER BY otherName ASC';
        $result = mysqli_query($link,$sql);
  
        $returnString .= "<select name='otherNameSelection' id='otherNameSelection' size='8' style='width:100%'>";
        while ($row = mysqli_fetch_array($result)) {
            $returnString .= "<option value='" . $row['ID'] . "'>" . $row['otherName'] . "</option>";
        }
        $returnString .="</select>

        <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm' style='margin: 0 10px' id='addNewOther' type='button' data-toggle='modal' data-target='#modalAddNewOther' data-caller='other'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'>
            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/>
            </svg> New Partner</btn>";

                if ($_SESSION['isAdmin']== '1') {
                    $returnString .= "<btn class='btn btn-danger btn-sm deleteOther' style='margin: 0 10px' onclick='deleteOther()' id='deleteOther' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                    </svg> Delete </btn>";
                }
                $returnString .="
        </div>
        <div id='currentOtherMessageBox'></div>
    </div>
        <div class = 'col-1'></div>
        <div class='col-lg-6 col-xl-7 settings-dialog'>
            <h6><strong style='margin-top:10px;'>Selected Partner details</strong></h6>

            <div class='form-group' style='display: flex; align-items: center'>
            <label class='control-label inline' for='otherName' style='width:40%; padding-top:6px'>Name </label>
            <div class='input-group'>
                <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editOtherName' name='editOtherName' 
                placeholder='partner name...' value=''>
            </div>   
        </div>
            <div class='form-group' style='display: flex; align-items: center'>
                <label class='control-label inline' for='editOtherAddress1' style='width:40%; padding-top:6px'>Address </label>
                <div class='input-group'>
                    <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editOtherAddress1' name='editOtherAddress1' 
                    placeholder='address line 1...' value=''>
                </div>   
            </div>
            <div class='form-group' style='display: flex; align-items: center'>
                <label class='control-label inline' for='editOtherAddress2' style='width:40%; padding-top:6px'>Address </label>
                <div class='input-group'>
                    <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editOtherAddress2' name='editOtherAddress2' 
                    placeholder='address line 2...' value=''>
                </div>   
            </div>
            <div class='form-group' style='display: flex; align-items: center'>   
                <label class='control-label inline' for='editOtherAddress3' style='width:40%; padding-top:6px'>Town/City </label>
                <div class='input-group'>
                    <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editOtherAddress3' name='editOtherAddress3' 
                    placeholder='town/city...' value=''>
                </div>   
            </div>
            <div class='form-group' style='display: flex; align-items: center'>            
                <label class='control-label inline' for='editOtherAddress4' style='width:40%; padding-top:6px'>County </label>
                <div class='input-group'>
                    <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editOtherAddress4' name='editOtherAddress4' 
                    placeholder='county...' value=''>
                </div>   
            </div>
            <div class='form-group' style='display: flex; align-items: center'>        
                <label class='control-label inline' for='editOtherAddress5' style='width:40%; padding-top:6px'>Post Code </label>
                <div class='input-group'>
                    <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editOtherAddress5' name='editOtherAddress5' 
                    placeholder='post code...' value=''>
                </div>          
            </div>
            <hr>
            <div class='form-group' style='display: flex; align-items: center'>        
            <label class='control-label inline' for='editOtherService' style='width:40%; padding-top:6px'>Description/Service </label>
            <div class='input-group'>
                <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editOtherService' name='editOtherService' 
                placeholder='description/service provided...' value=''>
            </div>          
            </div>
            <hr>
            <div id='editOtherMessage'></div>
            <div class='row'>
            <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm updateEditOther' style='margin: 0 10px' onclick='updateEditOther()' id='updateEditOther' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-left-circle-fill' viewBox='0 0 16 16'>
            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-5.904 2.803a.5.5 0 1 0 .707-.707L6.707 6h2.768a.5.5 0 1 0 0-1H5.5a.5.5 0 0 0-.5.5v3.975a.5.5 0 0 0 1 0V6.707l4.096 4.096z'/>
            </svg> Update </btn>";
            
            $returnString .="<btn class='btn btn-primary btn-sm' style='margin: 0 10px'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
            </svg> Search </btn>
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
                <th class='align-middle' style='padding-left:3px;'>First Name</th>
                <th class='align-middle' style='padding-left:3px;'>Last Name</th> 
                <th class='align-middle' style='padding-left:3px;'>Department</th>
                <th class='text-center align-middle'>Mobile</th>
                <th class='text-center align-middle'>Telephone</th>
                <th class='align-middle' style='padding-left:3px;'>Email</th>

                <th class='text-center align-middle'>Edit</th>
            </tr>
        </thead>
        
        <tbody id='otherContactListHolder'></tbody>
    
    
    </table>
    <div id='hiddenInfo' style='display: none'></div>

    <btn class='btn btn-success btn-sm' id='btnAddNewOtherContact' style='margin: 0 10px' type='button' data-toggle='modal' data-target='#modalAddNewOtherContact' data-caller='other'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16'
    fill='currentColor' class='bi bi-person-lines-fill' viewBox='0 0 16 16'><path d='M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z' />
    </svg> New Contact </btn>

</div>


</div>


</form>
</div>
";

echo $returnString;

?>

                   

