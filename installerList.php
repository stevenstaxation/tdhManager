<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "<div class='container-fluid'>
<div id='installerList' style = 'margin: 50px 15px 20px;'><h4><strong>Current Installers</strong></h4></div>";

$returnString .= "

<form id = 'installerList'>
<div id='editInstallerHide' style='display: none'></div>
<div class='row'>
    <div class='col-lg-5 col-xl-4 settings-dialog'>
            <h6><strong style='margin-top:5px;'>Select from list</strong></h6>
       ";

        $sql = 'SELECT * FROM tblInstaller ORDER BY installerName ASC';
        $result = mysqli_query($link,$sql);
        
        $returnString .= "<select name='installerNameSelection' id='installerNameSelection' size='8' style='width:100%'>";
        while ($row = mysqli_fetch_array($result)) {
            $returnString .= "<option value='" . $row['ID'] . "'>" . $row['installerName'] . "</option>";
        }
        $returnString .="</select>

        <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm mx-2' id='addNewInstaller' type='button' data-toggle='modal' data-target='#modalAddNewInstaller' data-caller='installer'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'>
            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/>
            </svg> New Installer</btn>";

                if ($_SESSION['isAdmin']== '1') {
                    $returnString .= "<btn class='btn btn-danger btn-sm deleteInstaller' style='margin: 0 10px' onclick='deleteInstaller()' id='deleteInstaller' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                    </svg> Delete </btn>";
                }
                $returnString .="
        </div>
        <div id='currentInstallerMessageBox'></div>
    </div>
        <div class = 'col-1'></div>
        <div class='col-lg-6 col-xl-7 settings-dialog'>
            <h6><strong style='margin-top:10px;'>Selected Installer details</strong></h6>

            <div class='form-group insurerFormGroup'>
            <label class='control-label inline' for='installerName'>Name </label>
            <div class='input-group'>
                <input maxlength='100' class='form-control' type='text' id='editInstallerName' name='editInstallerName' 
                placeholder='installer name...' value=''>
            </div>   
        </div>
            <div class='form-group insurerFormGroup'>
                <label class='control-label inline' for='editInstallerAddress1'>Address </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInstallerAddress1' name='editInstallerAddress1' 
                    placeholder='address line 1...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>
                <label class='control-label inline' for='editInstallerAddress2'>Address </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInstallerAddress2' name='editInstallerAddress2' 
                    placeholder='address line 2...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>
                <label class='control-label inline' for='editInstallerAddress3'>Town/City </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInstallerAddress3' name='editInstallerAddress3' 
                    placeholder='town/city...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>            
                <label class='control-label inline' for='editInstallerAddress4'>County </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInstallerAddress4' name='editInstallerAddress4' 
                    placeholder='county...' value=''>
                </div>   
            </div>
            <div class='form-group insurerFormGroup'>        
                <label class='control-label inline' for='editInstallerAddress5'>Post Code </label>
                <div class='input-group'>
                    <input maxlength='100' class='form-control' type='text' id='editInstallerAddress5' name='editInstallerAddress5' 
                    placeholder='post code...' value=''>
                </div>          
            </div>
            <hr>
            <div id='editInstallerMessage'></div>
            <div class='row'>
            <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm updateEditInstaller mx-2' onclick='updateEditInstaller()' id='updateEditInstaller' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-left-circle-fill' viewBox='0 0 16 16'>
            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-5.904 2.803a.5.5 0 1 0 .707-.707L6.707 6h2.768a.5.5 0 1 0 0-1H5.5a.5.5 0 0 0-.5.5v3.975a.5.5 0 0 0 1 0V6.707l4.096 4.096z'/>
            </svg> Update </btn>";
            
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
        
        <tbody id='installerContactListHolder'></tbody>
    
    
    </table>
    <div id='hiddenInfo' style='display: none'></div>

    <btn class='btn btn-success btn-sm' id='btnAddNewInstallerContact mx-2' type='button' data-toggle='modal' data-target='#modalAddNewInstallerContact' data-caller='installer'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16'
    fill='currentColor' class='bi bi-person-lines-fill' viewBox='0 0 16 16'><path d='M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z' />
    </svg> New Contact </btn>

</div>


</div>


</form>
</div>
";

echo $returnString;

?>

                   

