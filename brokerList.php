<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "<div class='container-fluid'>
<div id='brokerList' style = 'margin: 50px 15px 20px;'><h4><strong>Current Brokers</strong></h4></div>";

$returnString .= "

<form id = 'brokerList'>
    <div id='editBrokerHide' style='display: none'></div>

    <div class='row'>
        <div class='col-lg-5 col-xl-4 settings-dialog' style='min-height:1000px;'>
            <h6><strong style='margin-top:5px;'>Select from list</strong></h6>";

            $sql = 'SELECT * FROM tblBroker ORDER BY brokerName ASC';
            $result = mysqli_query($link,$sql);
        
            $returnString .= "<select name='brokerNameSelection' id='brokerNameSelection' size='8' style='width:100%; min-height:900px;'>";
            while ($row = mysqli_fetch_array($result)) {
                $returnString .= "<option value='" . $row['ID'] . "'>" . $row['brokerName'] . "</option>";
            }
            $returnString .="</select>

            <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
                <btn class='btn btn-success btn-sm' style='margin: 0 10px' id='addNewBroker' type='button' data-toggle='modal' data-target='#modalAddNewBroker' data-caller='broker'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'>
                <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/>
                </svg> New Broker</btn>";

                if ($_SESSION['isAdmin']== '1') {
                    $returnString .= "<btn class='btn btn-danger btn-sm deleteBroker' style='margin: 0 10px' onclick='deleteBroker()' id='deleteBroker' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                    </svg> Delete </btn>";
                }
                $returnString .="
            </div>
        
            <div id='currentBrokerMessageBox'></div>
        </div>
        
        <div class = 'col-1'></div>
        
        <div class='col-lg-6 col-xl-7'>

            <div class='row'>
                <div class='col-12 settings-dialog' style='min-height:400px'>
                <h6><strong style='margin-top:10px;'>Selected Broker details</strong></h6>

                <div class='form-group' style='display: flex; align-items: center'>
                    <label class='control-label inline' for='brokerName' style='width:40%; padding-top:6px'>Name </label>
                    <div class='input-group'>
                        <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerName' name='editBrokerName' 
                        placeholder='broker name...' value=''>
                    </div>   
                </div>
            
                <div class='form-group' style='display: flex; align-items: center'>
                    <label class='control-label inline' for='editBrokerAddress1' style='width:40%; padding-top:6px'>Address </label>
                    <div class='input-group'>
                        <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress1' name='editBrokerAddress1' 
                        placeholder='address line 1...' value=''>
                    </div>   
                </div>

                <div class='form-group' style='display: flex; align-items: center'>
                    <label class='control-label inline' for='editBrokerAddress2' style='width:40%; padding-top:6px'>Address </label>
                    <div class='input-group'>
                        <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress2' name='editBrokerAddress2' 
                        placeholder='address line 2...' value=''>
                    </div>   
                </div>
            
                <div class='form-group' style='display: flex; align-items: center'>   
                    <label class='control-label inline' for='editBrokerAddress3' style='width:40%; padding-top:6px'>Town/City </label>
                    <div class='input-group'>
                        <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress3' name='editBrokerAddress3' 
                        placeholder='town/city...' value=''>
                    </div>   
                </div>
            
                <div class='form-group' style='display: flex; align-items: center'>            
                    <label class='control-label inline' for='editBrokerAddress4' style='width:40%; padding-top:6px'>County </label>
                    <div class='input-group'>
                        <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress4' name='editBrokerAddress4' 
                        placeholder='county...' value=''>
                    </div>   
                </div>
            
                <div class='form-group' style='display: flex; align-items: center'>        
                    <label class='control-label inline' for='editBrokerAddress5' style='width:40%; padding-top:6px'>Post Code </label>
                    <div class='input-group'>
                        <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress5' name='editBrokerAddress5' 
                        placeholder='post code...' value=''>
                    </div>          
                </div>
            
                <hr>
                <div id='editBrokerMessage'></div>
           
                    <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
                    <btn class='btn btn-success btn-sm updateEditBroker' style='margin: 0 10px' onclick='updateEditBroker()' id='updateEditBroker' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-left-circle-fill' viewBox='0 0 16 16'>
                    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-5.904 2.803a.5.5 0 1 0 .707-.707L6.707 6h2.768a.5.5 0 1 0 0-1H5.5a.5.5 0 0 0-.5.5v3.975a.5.5 0 0 0 1 0V6.707l4.096 4.096z'/>
                    </svg> Update </btn>";
            
                    $returnString .="
                </div>
                </div>
            </div>
            
            <div class='row'>
                <div class='col-12 settings-dialog' style='min-height:200px;'>
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
                                <th class='text-center align-middle'>Footage</th>
                                <th class='text-center align-middle'>Health Check</th>
                                <th class='text-center align-middle'>Edit</th>
                            </tr>
                        </thead>
        
                        <tbody id='brokerContactListHolder'></tbody>    
                    </table>
    
                    <div id='hiddenInfo' style='display: none'></div>

                    <btn class='btn btn-success btn-sm'  id='btnAddNewBroker' style='margin: 0 10px' type='button' data-toggle='modal' data-target='#modalAddNewBrokerContact' data-caller='broker'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16'
                    fill='currentColor' class='bi bi-person-lines-fill' viewBox='0 0 16 16'><path d='M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z' />
                    </svg> New Contact </btn>
                </div>
            </div>
           
        </div>
    </div>   
</form>

</div>

";

echo $returnString;

?>

                   

