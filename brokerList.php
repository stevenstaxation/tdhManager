<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

  $sql = 'SELECT * FROM tblBroker ORDER BY brokerName ASC';
            $result = mysqli_query($link,$sql);
?>

<div class='container-fluid'>
    <div id='brokerList' style = 'margin: 50px 15px 20px;'><h4><strong>Current Brokers</strong></h4></div>
    <form id = 'brokerList'>
        <div id='editBrokerHide' class='d-none'></div>
        <div class='row'>
            <div class='col-lg-5 col-xl-4 settings-dialog' style='min-height:1000px;'>
                <h6><strong style='margin-top:5px;'>Select from list</strong></h6>
                <select name='brokerNameSelection' id='brokerNameSelection' size='8' style='width:100%; min-height:900px;'>
                <?php
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['ID'] . "'>" . $row['brokerName'] . "</option>";
                    }
                    ?>
                </select>

                <div class='btn-group d-flex' style ='margin: 10px 20px;'>
                    <btn class='btn btn-success btn-sm' style='margin: 0 10px' id='addNewBroker' type='button' data-toggle='modal' data-target='#modalAddNewBroker' data-caller='broker'><i class='bi bi-plus-circle-fill'></i> New Broker</btn>
        
                    <!-- include a delete button if the user is an Admin -->
                    <?php
                    if ($_SESSION['isAdmin']== '1') {
                        echo "<btn class='btn btn-danger btn-sm deleteBroker' style='margin: 0 10px' onclick='deleteBroker()' id='deleteBroker' type='button'><i class='bi bi-trash-fill'></i> Delete </btn>";
                    }
                    ?>
                </div>
                <div id='currentBrokerMessageBox'></div>
            </div>
    
            <div class = 'col-1'></div>
    
            <div class='col-lg-6 col-xl-7'>

                <div class='row'>
                    <div class='col-12 settings-dialog' style='min-height:400px'>
                        <h6><strong style='margin-top:10px;'>Selected Broker details</strong></h6>

                        <div class='form-group d-flex' style='align-items: center'>
                            <label class='control-label inline' for='brokerName' style='width:40%; padding-top:6px'>Name </label>
                            <div class='input-group'>
                                <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerName' name='editBrokerName' placeholder='broker name...' value=''>
                            </div>   
                        </div>
        
                        <div class='form-group d-flex' style='align-items: center'>
                            <label class='control-label inline' for='editBrokerAddress1' style='width:40%; padding-top:6px'>Address </label>
                            <div class='input-group'>
                                <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress1' name='editBrokerAddress1' 
                                placeholder='address line 1...' value=''>
                            </div>   
                        </div>

                        <div class='form-group d-flex' style='align-items: center'>
                            <label class='control-label inline' for='editBrokerAddress2' style='width:40%; padding-top:6px'>Address </label>
                            <div class='input-group'>
                                <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress2' name='editBrokerAddress2' 
                                placeholder='address line 2...' value=''>
                            </div>   
                        </div>
        
                        <div class='form-group d-flex' style='align-items: center'>   
                            <label class='control-label inline' for='editBrokerAddress3' style='width:40%; padding-top:6px'>Town/City </label>
                            <div class='input-group'>
                                <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress3' name='editBrokerAddress3' 
                                placeholder='town/city...' value=''>
                            </div>   
                        </div>
        
                        <div class='form-group d-flex' style='align-items: center'>            
                            <label class='control-label inline' for='editBrokerAddress4' style='width:40%; padding-top:6px'>County </label>
                            <div class='input-group'>
                                <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress4' name='editBrokerAddress4' 
                                placeholder='county...' value=''>
                            </div>   
                        </div>
        
                        <div class='form-group d-flex' style='align-items: center'>        
                            <label class='control-label inline' for='editBrokerAddress5' style='width:40%; padding-top:6px'>Post Code </label>
                            <div class='input-group'>
                                <input style='font-size: 80%' maxlength='100' class='form-control' type='text' id='editBrokerAddress5' name='editBrokerAddress5' 
                                placeholder='post code...' value=''>
                            </div>          
                        </div>
        
                        <hr>
                        <div id='editBrokerMessage'></div>
        
                        <div class='btn-group d-flex' style ='margin: 10px 20px;'>
                            <btn class='btn btn-success btn-sm updateEditBroker' style='margin: 0 10px' onclick='updateEditBroker()' id='updateEditBroker' type='button'><i class='bi bi-arrow-up-left-circle-fill'></i> Update </btn>
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
                                    <th class='text-center align-middle'>Reports</th>
                                    <th class='text-center align-middle'>Edit</th>
                                </tr>
                            </thead>
    
                            <tbody id='brokerContactListHolder'></tbody>    
                        </table>

                        <div id='hiddenInfo' class='d-none'></div>

                        <btn class='btn btn-success btn-sm'  id='btnAddNewBroker' style='margin: 0 10px' type='button' data-toggle='modal' data-target='#modalAddNewBrokerContact' data-caller='broker'><i class='bi bi-person-lines-fill'></i> New Contact </btn>
                    </div>
                </div>
            </div>
        </div>   
    </form>
</div>



                   

