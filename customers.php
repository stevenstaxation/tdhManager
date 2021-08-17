<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$foreColor = $_SESSION['textColor'];
// $darkmode = 'nodarkmode';
$tableColour='table-light';
$tableText =  $_SESSION['textColor'];
$notRenewable = $_SESSION['renewalColor'];
$returnString = "";
// if (isset($_POST['selectedValue'])) {
    $_SESSION['currentCustomer'] = $_POST['selectedValue'];  
// } 

$sql= "SELECT * FROM tblCustomer LEFT JOIN tblInsurer ON tblCustomer.insurerID = tblInsurer.ID LEFT JOIN tblBroker ON tblCustomer.brokerID = tblBroker.ID  LEFT JOIN tblRenewalType ON tblCustomer.renewalType = tblRenewalType.ID WHERE tblCustomer.ID='" . $_SESSION['currentCustomer'] . "'";

$result = mysqli_query($link, $sql);
 if (!$result) {
     exit();
 } 

if($result) {
    if (mysqli_num_rows($result)==0) {
        // $sql= "SELECT * FROM tblCustomer LEFT JOIN tblInsurer ON tblCustomer.insurerID = tblInsurer.ID LEFT JOIN tblBroker ON tblCustomer.brokerID = tblBroker.ID  LEFT JOIN tblRenewalType ON tblCustomer.renewalType = tblRenewalType.ID LIMIT 1";
        // $result = mysqli_query($link, $sql);
        // $getTop = mysqli_fetch_array($result);
        // $_SESSION['currentCustomer'] = $getTop['ID'];
        exit();
    }
} 

if (mysqli_num_rows($result)==0) {
    echo $returnString;
    exit();
}
// if there are no elements in $row then we just select the top record
if (mysqli_num_rows($result)==1) {
    $row = mysqli_fetch_array($result);
} else {
    $sql = "SELECT * FROM tblCustomer LEFT JOIN tblInsurer ON tblCustomer.insurerID = tblInsurer.ID LEFT JOIN tblBroker ON tblCustomer.brokerID = tblBroker.ID LEFT JOIN tblRenewalType ON tblCustomer.renewalType = tblRenewalType.ID ORDER BY businessNAME ASC LIMIT 1";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
}

if ($row['businessName'] != 'DHINSTALL') {


$dateNow = new DateTime();
$dateNow = new DateTime();
$renewalDate = new DateTime($row['renewalDate']);
$daysToRenewal = $dateNow->diff($renewalDate)->format('%r%a');

if ($daysToRenewal <= 30) { $renewalColour='#FF7777' ; } elseif ($daysToRenewal <=60) { 
    $renewalColour='orange' ; 
}
else { 
    $renewalColour=$notRenewable; 
}


$returnString = "
<div id='hiddenCustomerID' style='display: none;'>" . $row[0] . "</div>
<div class='row' style='font-size:100%;'>
    <div class='col-lg-6 col-xl-4'>
        <form id='customerForm'>
            <div class='scrollBox' style='max-height: 75vh; overflow: auto;'>
                <div id='showAccountInfo' class='settings-dialog'>
                    <h6><strong style='margin-top:10px;'>BUSINESS DETAILS</strong></h6>
                    <div id='errorBox'></div>
                    <div class='form-group' style='display: flex; align-items: center'>
                        <label class='control-label inline' for='customerName' style='width:40%; padding-top:6px'>Name</label>
                        <div class='input-group'>
                            <input style='font-size: 80%' maxlength='100' oninput='makeDirty(" . '"customerName"'. ")'
                                class='form-control enabler' type='text' id='customerName' name='customerName'
                                placeholder='enter customer name...' value='" . $row['businessName'] . "'>
                        </div>
                    </div>
                    <hr>
                    <div class='form-group' style='display: flex; align-items: center'>
                    <label class='control-label inline' for='custPhone' style='width:40%; padding-top:6px'>Telephone</label>
                    <div class='input-group'>
                        <input style='font-size: 80%' maxlength='20' onkeypress='return onlyNumberKey(event)' oninput='makeDirty(" . '"custPhone"'
                            . ")' class='form-control enabler' type='text' id='custPhone' name='custPhone' placeholder='Telephone...' value ='"
                            . $row['businessPhone'] . "'>
                    </div>
                </div>
                <div class='form-group' style='display: flex; align-items: right'>
                    <label class='control-label inline' for='custEmail' style='width:40%; padding-top:10px'>Email</label>
                    <div class='input-group'>
                        <input style='font-size: 80%' oninput='makeDirty(" . '"custEmail"'
                            . ")' class='form-control enabler' type='text' id='custEmail' name='custEmail' placeholder='Business Email address...' value ='"
                            . $row['businessEmail']
                            . "'>
                    </div>
                </div>
                                 <hr>
                    <div class='form-group' style='display: flex; align-items: center'>
                        <label class='control-label inline' for='addressLookup' style='width:40%; padding-top:6px'>Lookup</label>
                        <div class='input-group'>
                            <input style='font-size: 80%' maxlength='50' class='form-control enabler' type='text' id='addressLookup' name='addressLookup' placeholder='Name or number...' value =''>
                            <input style='font-size: 80%' maxlength='50' class='form-control enabler' type='text' id='addressLookup2' name='addressLookup2' placeholder='Postcode...' value =''>
                            <btn class='btn btn-info btn-sm' style='margin-left:1px;border-radius:3px; id='findAddress' type='button' onclick='lookupAddress()'> Find </btn>
                            </div>
                    </div>

                    <div class='form-group' style='display: flex; align-items: center'>
                        <label class='control-label inline' for='custAddressLine1' style='width:40%; padding-top:6px'>Address</label>
                        <div class='input-group'>
                            <input style='font-size: 80%' maxlength='50' oninput='makeDirty(" . '"custAddressLine1"' . ")' class='form-control enabler' type='text' id='custAddressLine1' name='custAddressLine1' placeholder='Address line 1...' value ='" . $row['custAddressLine1'] . "'>
                        </div>
                    </div>
                    <div class='form-group' style='display: flex; align-items: center'>
                        <label class='control-label inline' for='custAddressLine2' style='width:40%; padding-top:6px'>Address</label>
                        <div class='input-group'>
                            <input style='font-size: 80%' maxlength='50' oninput='makeDirty(" . '"custAddressLine2"'
                                . ")' class='form-control enabler' type='text' id='custAddressLine2' name='custAddressLine2' placeholder='Address line 2...' value ='"
                                . $row['custAddressLine2'] . "'>
                        </div>
                    </div>
                    <div class='form-group' style='display: flex; align-items: center'>
                        <label class='control-label inline' for='custAddressLine3' style='width:40%; padding-top:6px'>Town/City</label>
                        <div class='input-group'>
                            <input style='font-size: 80%' maxlength='50' oninput='makeDirty(" . '"custAddressLine3"'
                                . ")' class='form-control enabler' type='text' id='custAddressLine3' name='custAddressLine3' placeholder='Town or city...' value ='"
                                . $row['custAddressLine3'] . "'>
                        </div>
                    </div>
                    <div class='form-group' style='display: flex; align-items: center'>
                        <label class='control-label inline' for='custAddressLine4' style='width:40%; padding-top:6px'>County</label>
                        <div class='input-group'>
                            <input style='font-size: 80%' maxlength='50' oninput='makeDirty(" . '"custAddressLine4"'
                                . ")' class='form-control enabler' type='text' id='custAddressLine4' name='custAddressLine4' placeholder='County...' value ='"
                                . $row['custAddressLine4'] . "'>
                        </div>
                    </div>
                    <div class='form-group' style='display: flex; align-items: center'>
                        <label class='control-label inline' for='custAddressLine5' style='width:40%; padding-top:6px'>Post Code</label>
                        <div class='input-group'>
                            <input style='font-size: 80%' maxlength='14' oninput='makeDirty(" . '"custAddressLine5"'
                                . ")' class='form-control enabler' type='text' id='custAddressLine5' name='custAddressLine5' placeholder='Postcode...' value ='"
                                . $row['custAddressLine5']
                                . "'>
                        </div>
                    </div>
                    <hr>
                   
                   ";

                   $theRenewalType = $row['renewalType'];
                   $theRenewalDate = $row['renewalDate'];
                    // <div class='form-group' style='display: flex; align-items: right'>
                    //     <label class='control-label inline' for='custRegNumber' style='width:40%; padding-top:10px'>Reg'd No.</label>
                    //     <div class='input-group'>
                    //         <input style='font-size: 80%' maxlength='14' onkeypress='return onlyNumberKey(event)' oninput='makeDirty("
                    //             . '"custRegNumber"'
                    //             . ")' class='form-control enabler' type='text' id='custRegNumber' name='custRegNumber' placeholder='Company Registered Number...' value ='"
                    //             . $row['companyRegNo']
                    //             . "'>
                    //     </div>
                    // </div>
                    // <div class='form-group' style='display: flex; align-items: right'>
                    //     <label class='control-label inline' for='custVATNumber' style='width:40%; margin-top:10px'>VAT No.</label>
                    //     <div class='input-group'>
                    //         <input style='font-size: 80%' maxlength='14' onkeypress='return onlyNumberKey(event)' oninput='makeDirty("
                    //             . '"custVATNumber"'
                    //             . ")' class='form-control enabler' type='text' id='custVATNumber' name='custVATNumber' placeholder='VAT Registered Number...' value ='"
                    //             . $row['VATRegNo'] . "'>
                    //     </div>
                    // </div>

                    $returnString .="<div class='btn-group' style ='display: flex; margin: 10px 20px;'>
                        <btn class='btn btn-success btn-sm updateCustomer' style='margin: 0 10px' onclick='updateCustomer()' id='updateCustomer' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-left-circle-fill' viewBox='0 0 16 16'>
                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-5.904 2.803a.5.5 0 1 0 .707-.707L6.707 6h2.768a.5.5 0 1 0 0-1H5.5a.5.5 0 0 0-.5.5v3.975a.5.5 0 0 0 1 0V6.707l4.096 4.096z'/>
                        </svg> Update </btn>";

                        if ($_SESSION['isAdmin']== '1') {
                            $returnString .= "<btn class='btn btn-danger btn-sm deleteCustomer' style='margin: 0 10px' onclick='deleteCustomer()' id='deleteCustomer' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                            <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                          </svg> Archive </btn>";
                        }
                 
                        $returnString .="<btn class='btn btn-primary btn-sm' style='margin: 0 10px'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                        <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                        </svg> Search </btn>
                    </div>
                    <div id='customerUpdateMessage'></div>
                </div>
                </div>
        </form>";
     
        $dateNow = new DateTime();
        $renewalDate = new DateTime($row['renewalDate']);
        $daysToRenewal = $dateNow->diff($renewalDate)->format('%r%a');

        if ($daysToRenewal <= 30) { $renewalColour='#FF7777' ; } elseif ($daysToRenewal <=60) { 
            $renewalColour='orange' ; 
        }
        else { 
            $renewalColour=$notRenewable; 
        }
        $returnString=$returnString. "
        <form id='contactsForm'>
        <div id='showAccountInfo' class='settings-dialog'>
            <h6><strong style='margin-top:10px;'>BUSINESS CONTACTS</strong></h6>
            <div id='errorBox'></div>
            <div class='scrollBox' style='max-height: 20vh; overflow: auto; font-size: 80%;'>
                <table id='customerContactTable' class='table table-sm table-bordered table-hover' style='table-layout: fixed;'>
                    <thead>
                        <tr>
                            <th class='align-middle' style='padding:0 3px;'>Name</th>
                            <th class='align-middle' style='padding:0 3px;'>Email</th>
                            <th class='text-center align-middle' style='padding:0 3px;'>Mobile</th>
                            <th class='text-center align-middle' style='padding:0 3px;'>Phone</th>
                            <th class='align-middle text-center' style='width:8%; padding: 0 3px;'>Ftg</th>
                            <th class='align-middle text-center' style='width:8%; padding: 0 3px;'>H/C</th>
                        </tr>
                    </thead>
                    <tbody>";

                        $sql = "SELECT * FROM tblCustomerContact WHERE businessID = '" . $_SESSION['currentCustomer'] . "' ORDER BY lastName, firstName ASC";
                        $result = mysqli_query($link, $sql);

                        while ($contact=mysqli_fetch_array($result)) {
                            $returnString .= "<tr class='clickable-row' value='" .$contact['ID'] . "' ondblclick='editContact(" . $contact['ID'] . ")'><td class='align-middle' style='padding:0 3px;'>" . $contact['firstName'] ." " . $contact['lastName']. "</td>";
                            $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $contact['email'] ."</td>";
                            $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>" . $contact['mobileNo'] ."</td>";
                            $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>" . $contact['telephone'] ."</td>";
                            $returnString .= "<td class='align-middle' style='padding:0 3px;'><center><input type='checkbox' class='isFootageRequest' name='isFootageRequest' onclick='return false' " . ($contact['isFootageRecipient'] == 1 ? 'checked' : '')." value='1'/>&nbsp;</center></td>";
                            $returnString .= "<td class='align-middle' style='padding:0 3px;'><center><input type='checkbox' class='isHealthCheck' name='isHealthCheck' onclick='return false' " . ($contact['isHealthCheck'] == 1 ? 'checked' : '')." value='1'/>&nbsp;</center></td>";
                            $returnString .= "</tr>";
                        }

                        $returnString .= "
                    </tbody>
                </table>
            </div>
            <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
                 <btn class='btn btn-success btn-sm' style='margin: 0 10px' id='addNewContact' type='button' data-toggle='modal' data-target='#modalAddNewContact'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'>
                <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/>
                </svg> New Contact</btn>

                <btn class='btn btn-primary btn-sm' style='margin: 0 10px'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                </svg> Search </btn>
            </div>
        </div>
    </form>

            <form id='insurerForm'>
                <div id='showAccountInfo' class='settings-dialog'>
                    <h6><strong style='margin-top:10px;'>INSURER</strong></h6>
                    <div id='errorBox'></div>
                    <div class='form-group' style='display: flex; align-items: center'>
                        <label class='control-label inline' for='insurerName' style='width:40%; padding-top:6px'>Name</label>
                        <div class='input-group'>
                            <select  style='font-size: 80%' id='getInsurerSelect' name='getInsurerSelect' class='custom-select getInsurerSelect'>" ;
                                $sql="SELECT * FROM tblInsurer ORDER BY insurerName ASC" ; 
                                $result=mysqli_query($link,$sql); 
                                $returnString .="
                            <option value= '0' selected='selected'>None Selected</option>" ; 
                            while ($insurerRow=mysqli_fetch_array($result)) { 
                                if ($row['insurerID']==$insurerRow['ID']) { 
                                    $returnString .="
                                    <option value= " . $insurerRow['ID']. " selected='selected'>" ; } else {
                                    $returnString .="
                                    <option value= " . $insurerRow['ID'].">";
                                }
                                $returnString .= $insurerRow['insurerName']. " </option>";
                            }

                                $returnString .="
                            </select>

                            <btn class='btn btn-primary btn-sm' id='editInsurerModal' type='button' onclick='editInsurer()'> More </btn>
                            <btn class='btn btn-success btn-sm' id='addInsurerModal' type='button' data-toggle='modal' data-target='#modalAddNewInsurer' data-caller='customer'> Add </btn>
                        </div>
                    </div>
                    <hr>
                   
                    <div class='form-group style='display: flex' style='font-size: 70%'>
                        <p style='font-size: 143%'><strong>Contacts</strong></p>
                        <div class='scrollBox' style='max-height: 20vh; overflow: auto;'>
                            <table class='table table-sm table-bordered table-hover' style='table-layout: fixed;'>
                                <thead>
                                    <tr>
                                        <th class='align-middle' style='padding: 0 3px;'>Name</th>
                                        <th class='align-middle' style='padding: 0 3px;'>Email</th>
                                        <th class='text-center align-middle'>Mobile</th>
                                        <th class='text-center align-middle'>Phone</th>
                                        <th class='text-center align-middle' style='width:8%; padding: 0 3px;'>Ftg</th>
                                        <th class='text-center align-middle' style='width:8%; padding: 0 3px;'>H/C</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>";

                                $sql="SELECT * FROM tblInsurerContact WHERE insurerID = '" . $row['insurerID'] . "' ORDER BY lastName, firstName ASC" ; $result=mysqli_query($link, $sql); 
                                while ($contact=mysqli_fetch_array($result)) { 
                                    $returnString .="<tr class='clickable-row' value='" .$contact['ID'] . "' ondblclick='editInsurerContact(" . $contact['ID'] . ")'><td class='align-middle' style='padding:0 3px;'>" . $contact['firstName'] ." " . $contact['lastName']. " </td>"; 
                                    $returnString .="<td class='align-middle' style='padding:0 3px;'>" . $contact['email']."</td>"; 
                                    $returnString .="<td class='text-center align-middle'>" . $contact['mobileNo'] ."</td>"; 
                                    $returnString .="<td class='text-center align-middle'>" . $contact['telephone'] ."</td>"; 
                                    $returnString .="<td class='align-middle'><center><input type='checkbox' class='isFootageRequest' onclick='return false;' name='isFootageRequest' " . ($contact['isFootageRecipient']==1 ? 'checked' : '' )." value='1' />&nbsp;</center></td>";
                                    $returnString .="<td class='align-middle'><center><input type='checkbox' class='isHealthCheck' onclick='return false;' name='isHealthCheck' " . ($contact['isHealthCheck']==1 ? 'checked' : '' )." value='1' />&nbsp;</center></td>";
                                    $returnString .= "</tr>";
                                }

                                $returnString .= "
                                </tbody>
                            </table>
                            <div id='hiddenInfo' style='display: none'>" . $row['insurerID'] . "</div>
                            <div id='insurerEditNumber' style='display: none'>" . $row['insurerID'] . "</div>
                        </div>
                        <div class='btn-group' style='display: flex; margin: 10px 20px;'>
                            <btn class='btn btn-success btn-sm' style='margin: 0 10px' type='button' data-toggle='modal' data-target='#modalAddNewInsurerContact' data-caller='customer'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16'
                            fill='currentColor' class='bi bi-person-lines-fill' viewBox='0 0 16 16'><path d='M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z' />
                            </svg> New Contact </btn>

                            <btn class='btn btn-primary btn-sm' style='margin: 0 10px'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                            class='bi bi-arrow-up-left-circle-fill' viewBox='0 0 16 16'>
                            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-5.904 2.803a.5.5 0 1 0 .707-.707L6.707 6h2.768a.5.5 0 1 0 0-1H5.5a.5.5 0 0 0-.5.5v3.975a.5.5 0 0 0 1 0V6.707l4.096 4.096z' />
                            </svg> Search </btn>
                        </div>
                        <div id='renewalUpdateMessage'></div>
                    </div>
                </div>
            </form>
     
    <form id='brokerForm'>
        <div id='showAccountInfo' class='settings-dialog'>
            <h6><strong style='margin-top:10px;'>BROKER</strong></h6>
            <div id='errorBox'></div>
            <div class='form-group' style='display: flex; align-items: center'>
                <label class='control-label inline' for='brokerName' style='width:40%; padding-top:6px'>Name</label>
                <div class='input-group'>
                    <select style='font-size: 80%' id='getBrokerSelect' name='getBrokerSelect' class='custom-select getBrokerSelect'>";

                    $sql = "SELECT * FROM tblBroker ORDER BY brokerName ASC";
                    $result = mysqli_query($link,$sql);
                    $returnString .= "<option value= 0 selected='selected'>None Selected</option>";

                    while ($brokerRow = mysqli_fetch_array($result)) {
                        if ($row['brokerID']==$brokerRow['ID']) {
                            $returnString .= "<option value= ". $brokerRow['ID']. " selected='selected'>";
                        } else {
                            $returnString .= "<option value= ". $brokerRow['ID'].">";
                        }
                        $returnString .= $brokerRow['brokerName']. " </option>";
                    }

                    $returnString .="
                    </select>
                    <div class='input-group-append'>
                        <btn class='btn btn-primary btn-sm' id='editBrokerModal' type='button' onclick='editBroker()'> More </btn>
                        <btn class='btn btn-success btn-sm' id='addBrokerModal' type='button' data-toggle='modal' data-target='#modalAddNewBroker'> Add </btn>
                    </div>
                </div>
            </div>
            <hr>
           <div class='form-group style='display: flex' style='font-size: 70%'>
                <p style='font-size: 143%'><strong>Contacts</strong></p>
                <div class='scrollBox' style='max-height: 20vh; overflow: auto;'>
                    <table class='table table-sm table-bordered table-hover' style='table-layout: fixed'>
                        <thead>
                            <tr>
                                <th class='align-middle' style='padding:0 3px;'>Name</th>
                                <th class='align-middle' style='padding:0 3px;'>Email</th>
                                <th class='align-middle text-center' style='padding:0 3px;'>Mobile</th>
                                <th class='align-middle text-center' style='padding:0 3px;'>Phone</th>
                                <th class='text-center' style='width:8%; padding: 0 3px;'>Ftg</th>
                                <th class='text-center' style='width:8%; padding: 0 3px;'>H/C</th>
                            </tr>
                        </thead>
                        <tbody>";

                            $sql = "SELECT * FROM tblBrokerContact WHERE brokerID = '" . $row['brokerID'] . "' ORDER BY lastName, firstName ASC";

                            $result = mysqli_query($link, $sql);

                            while ($contact=mysqli_fetch_array($result)) {
                                $returnString .= "<tr class='clickable-row' value='" .$contact['ID'] . "' ondblclick='editBrokerContact(" . $contact['ID'] . ")'><td class='align-middle' style='padding:0 3px;'>" . $contact['firstName'] ." " . $contact['lastName']. "</td>";
                                $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $contact['email'] ."</td>";
                                $returnString .= "<td class='align-middle text-center' style='padding:0 3px;'>" . $contact['mobileNo'] ."</td>";
                                $returnString .= "<td class='align-middle text-center' style='padding:0 3px;'>" . $contact['telephone'] ."</td>";
                                $returnString .= "<td class='align-middle'><center><input type='checkbox' class='isFootageRequest' name='isFootageRequest' onclick='return false;' " . ($contact['isFootageRecipient'] == 1 ? 'checked' : '')." value='1'/>&nbsp;</center></td>";
                                $returnString .= "<td class='align-middle'><center><input type='checkbox' class='isHealthCheck' name='isHealthCheck' onclick='return false;' " . ($contact['isHealthCheck'] == 1 ? 'checked' : '')." value='1'/>&nbsp;</center></td>";
                                $returnString .= "</tr>";
                            }

                            $returnString .= "
                        </tbody>
                    </table>
                    <div id='brokerHiddenInfo' style='display: none'>" . $row['brokerID'] . "</div>
                </div>
                <btn class='btn btn-success btn-sm' style='margin: 0 10px' type='button' data-toggle='modal' data-target='#modalAddNewBrokerContact'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-lines-fill' viewBox='0 0 16 16'>
                <path d='M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z'/>
                </svg> New Contact </btn>
            </div>
        </div>
    </form>

 
    
    
    
       
</div>

<div class='col-lg-6 col-xl-4'>
<form id='deviceForm'>
<div id='showAccountInfo' class='settings-dialog customerTable'>
    <h6><strong style='margin-top:10px;'>DEVICES</strong></h6>
    <div id='errorBox'></div>";

    $sql = "SELECT * FROM tblDevice WHERE tblDevice.ownerID='". $_SESSION['currentCustomer'] ."'";
    $result = mysqli_query($link, $sql);
    $devices_NUMBEROF = mysqli_num_rows($result);

    $sql = "SELECT COUNT(tblDevice.ID), tblDevice.status, tblDeviceStatus.status FROM tblDevice INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.ID WHERE tblDevice.ownerID='" . $_SESSION['currentCustomer'] ."' GROUP BY tblDevicestatus.ID";
    $result = mysqli_query($link, $sql);
    $returnString = $returnString . "
        <div id='DeviceStats' style='font-size:120%'>";

            $devicesString = '';
            if ($devices_NUMBEROF!=0) {
                $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF ." (";
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['COUNT(tblDevice.ID)']!=0) {
                        $devicesString = $devicesString . $row['COUNT(tblDevice.ID)'] . " " . $row['status'] . ", ";
                    }
                }
                $devicesString = substr($devicesString,0, -2);
                $devicesString = $devicesString . ")";
            } else {
                $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF;
            }

            $returnString = $returnString . $devicesString;
            $returnString = $returnString . "
        </div><br>";

        $returnString .= "
        <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
            <table id='devicesTable' style='table-layout:fixed;' class='table cell-border compact'>";

            // <table class='table table-sm table-bordered table-hover' id='devicesTable' style='table-layout: fixed;'>
            $returnString .="    <thead>
                    <tr>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>No</th>
                        <th class='text-center align-middle'>VRN</th>
                        <th class='text-center align-middle'>Device</th>
                        <th class='text-center align-middle'>Serial</th>
                        <th class='text-center align-middle'>DRID</th>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>Edit</th>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>Notes</th>
                        <th class='text-center align-middle'>Hide</th>
                    </tr>
                </thead>
                <tbody>";

                    // $sql = "SELECT *, tblDeviceStatus.description FROM tblDevice LEFT JOIN tblDevice.status = tblDeviceStatus.ID LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID = tbldeviceDescription.ID WHERE tblDevice.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblVehicle.regNumber ASC";
                   
                    $sql = "SELECT * FROM tblDevice LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID = tbldeviceDescription.ID WHERE tblDevice.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblVehicle.regNumber ASC";
                    $deviceResult = mysqli_query($link, $sql);
                    $ix= 1;
                    $rowBackgroundClass = '';
                    while ($row=mysqli_fetch_array($deviceResult)) {
                       
                        if ($row['status']=='3') {
                            $rowBackgroundClass= "faulty";
                        } elseif ($row['status']=='8') {
                            $rowBackgroundClass= "inactive";
                        } else {
                            $rowBackgroundClass= "";
                        }
                        $returnString = $returnString . "<tr class='" . $rowBackgroundClass . "'><td class='align-middle text-center' style='padding: 0 3px;'>" . $ix ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['regNumber'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['description'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['serialNumber'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['DRIDNumber'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center'><btn class='btn btn-sm btn-warning' onclick='showFullDevice(\"" . $row[0]."customer\")'><svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                        <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
                      </svg></btn></td>";

                        if ($row['deviceNote'] && $row['deviceNote']!="") {
                            $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showDeviceNotes(\"" . $row[0]."customer\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal-check' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z'/><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
                        } else {
                            $returnString .="<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showDeviceNotes(\"" . $row[0]."customer\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal' viewBox='0 0 16 16'><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
                        }
                        
                        $hiddenVRN = $row['regNumber'];
                        if ($hiddenVRN=='' || $hiddenVRN=NULL) {
                            $hiddenVRN='zzzzzzzzzz';
                        }
                        $returnString .="<td class='text-center align-middle'>" . $hiddenVRN . "</td>";

                        $returnString = $returnString . "</tr>";
                        $ix++;
                    }

                    $returnString = $returnString. "
                </tbody>
            </table>
        </div>
        <div class='btn-group' style='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm' style='margin: 0 10px' id='addDevice' type='button' data-toggle='modal' data-target='#modalAddNewDevice'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16'
            fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'>
            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z' />
            </svg> New Device </btn>
        </div>
</div>
</form>
<script>
$(document).ready(function() {
    $('#devicesTable').DataTable({
      columnDefs: [
        {visible: false, targets: [7] },
        {orderable: false, targets: [5,6] },
        {searchable: false, targets: [5,6] }
      ],
      order: [[7, 'asc']],
      processing: true,
      paging: false,
      dom: '<\"top\"iflp>rt<\"bottom\"><\"clear\">',
      rowCallback: function(row, data, dataIndex) {
        if ($('body').hasClass('dark')) {
          $(row).css('background-color', 'rgba(68,68,68,1)')
                .css('color', 'white');
        } else {
          $(row).css('background-color', 'rgba(255,255,255,1)')
                .css('color', 'rgba(68,68,68,1)');
        }
        if ($(row).hasClass('faulty')) {
            $(row).css('background-color', 'rgba(255,32,32,0.75)')
            .css('color', 'rgba(255,255,255,0.75)');
        }
        if ($(row).hasClass('inactive')) {
            $(row).css('background-color', 'rgba(255,176,0,0.75)')
            .css('color', 'rgba(0,0,0,0.75)');
        }
    }
    });
});

document.getElementById('hiddenDeviceSelector').value = 'dhinstall';

</script>


<form id='vehicleForm'>
<div id='showAccountInfo' class='settings-dialog customerTable'>";

$sql = "SELECT * FROM tblVehicle WHERE tblVehicle.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblVehicle.regNumber ASC";
$deviceResult = mysqli_query($link, $sql);
$vehicles_NUMBEROF = mysqli_num_rows($deviceResult);
$vehiclesString = '';
$returnString .="<h6><strong style='margin-top:10px;'>VEHICLES</strong></h6> 
<div id='DeviceStats' style='font-size:120%'>";

$sql="SELECT COUNT(tblVehicle.ID), tblVehicle.vehicleStatus FROM tblVehicle WHERE tblVehicle.ownerID='" . $_SESSION['currentCustomer'] ."' GROUP BY tblVehicle.vehicleStatus";
$result = mysqli_query($link, $sql);

    if ($vehicles_NUMBEROF!=0) {
        $vehiclesString = "Total Vehicles: " . $vehicles_NUMBEROF . " (";
        while ($row = mysqli_fetch_array($result)) {
            if ($row['COUNT(tblVehicle.ID)']!=0) {
                switch ($row['vehicleStatus']) {
                    case '0':
                        $statusDescription='N/A';
                        break;
                    case '1':
                        $statusDescription='Pending';
                        break;
                    case '2':
                        $statusDescription='Installed';
                        break;    
                    default:
                        break;
                }
                $vehiclesString .= $row['COUNT(tblVehicle.ID)'] . " " . $statusDescription . ", ";
            }
        }

        $vehiclesString = substr($vehiclesString,0,-2);
        $vehiclesString .= ")";
    } else {
        $vehiclesString .= "Total Vehicles: " . $vehicles_NUMBEROF;
    }
    
    $returnString .= $vehiclesString;
    $returnString .= "
    </div><br> 
    <div id='errorBox'></div>
     <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
            <table class='table cell-border compact' id='vehiclesTable' style='table-layout: fixed;'>
                <thead>
                    <tr>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>No</th>
                        <th class='text-center align-middle'>VRN</th>
                        <th class='text-center align-middle'>Camera Required</th>
                        <th class='text-center align-middle'>Status</th>
                        <th class='text-center align-middle'>Install Date</th>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>Edit</th>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>Notes</th>
                    </tr>
                </thead>
                <tbody>";

                   $ix = 1;
                    while ($row=mysqli_fetch_array($deviceResult)) {
                        $returnString = $returnString . "<tr><td class='align-middle text-center' style='padding: 0 3px;'>" . $ix ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['regNumber'] ."</td>";
                        
                        if ($row['cameraRequired']=='1') {
                            $returnString .="<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='yesIcon' src='images/green_tick_16.png'/><span style='display:none;'>green_tick</span></td>";
                          } else {
                            $returnString .="<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='noIcon' src='images/red_cross_16.png'/><span style='display:none;'>red_cross</span></td>";
                        }
                        if ($row['vehicleStatus']=='2') {
                            $returnString .="<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='yesIcon' src='images/green_tick_16.png'/><span style='display:none;'>green_tick</span></td>";
                          } else if ($row['vehicleStatus']=='1') {
                            $returnString .="<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='pendingIcon' src='images/blue_ellipsis_16.png'/><span style='display:none;'>blue_ellipsis</span></td>";
                          } else {
                            $returnString .="<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='noIcon' src='images/red_cross_16.png'/><span style='display:none;'>red_cross</span></td>";
                          }

                          $stringyDate = strtotime($row['installDate']);
                           if (date('d/m/Y', $stringyDate)=='01/01/1970' || date('d/m/Y', $stringyDate)=='01/01/0001' || date('d/m/Y', $stringyDate)==NULL) {
                            $returnString .="<td class='text-center align-middle'>unknown</td>";   
                          } else {
                            $returnString .="<td class='text-center align-middle'>" . date('d/m/Y', $stringyDate) . "</td>";   
                          }
                        $returnString = $returnString . "<td class='align-middle text-center'><btn class='btn btn-sm btn-warning' onclick='showVehicleForEdit(\"" . $row[0] . "customer\")'><svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                        <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
                      </svg></btn></td>";
                        
                      if ($row['vehicleNotes'] && $row['vehicleNotes']!="") {
                        $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showVehicleNotes(\"" . $row[0]."customer\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal-check' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z'/><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td></tr>";
                      } else {
                        $returnString .="<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showVehicleNotes(\"" . $row[0]."customer\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' height='8px' fill='currentColor' class='bi bi-journal' viewBox='0 0 16 16'><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td></tr>";
                      }

                        $returnString = $returnString . "</tr>";
                        $ix++;
                    }

                    $returnString = $returnString. "
                </tbody>
            </table>
        </div>
        <div class='btn-group' style='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm' style='margin: 0 10px' id='addVehicle' type='button' data-toggle='modal' data-target='#modalAddVehicle'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16'
            fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'>
            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z' />
            </svg> New Vehicle </btn>
        </div>
        </div>
    </form>

    <script>
    $(document).ready(function() {
    $('#vehiclesTable').DataTable({
      columnDefs: [
        {orderable: false, targets: [5] },
        {searchable: false, targets: [5] }
      ],
      order: [[0, 'asc']],
      processing: true,
      paging: false,
      dom: '<\"top\"iflp>rt<\"bottom\"><\"clear\">',
      rowCallback: function(row, data, dataIndex) {
        if ($('body').hasClass('dark')) {
          $(row).css('background-color', 'rgba(68,68,68,1)')
                .css('color', 'white');
        } else {
          $(row).css('background-color', 'rgba(255,255,255,1)')
                .css('color', 'rgba(68,68,68,1)');
      }
    }
    });
});
</script>   

    


     
       
</div>

<div class='col-lg-6 col-xl-4' style='font-size: 80%'>

   
    

    <form id='jobForm'>
        <div id='showAccountInfo'  class='settings-dialog'>
            <h6><strong style='margin-top:10px;'>JOB REQUESTS</strong></h6>
            <div id='errorBox'></div>
            <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
                <h6 class='bg-danger' style='margin: 0; padding: 1px 3px;'><strong>Outstanding</strong></h6>
                    <table class='table table-sm table-bordered table-hover' id='jobTable' style='table-layout: fixed'>
                        <thead>
                            <tr>
                                <th class='text-center align-middle'>Date</th>
                                <th class='text-center align-middle'>Type</th>
                                <th class='text-center align-middle'>VRN</th>
                                <th class='text-left align-middle' style='padding: 0 3px;'>Notes</th>
                                <th class='text-center align-middle' style='width:8%; padding: 0 3px;'>Edit</th>
                            </tr>
                        </thead>
                        <tbody>";

                        $sql = "SELECT * FROM tblJobs INNER JOIN tblVehicle ON tblJobs.VRN = tblVehicle.ID INNER JOIN tblJobType ON tblJobType.ID = tblJobs.jobType WHERE (tblJobs.ownerID='" . $_SESSION['currentCustomer'] . "' AND tblJobs.status='1') ORDER BY tblJobs.date DESC";
                        $deviceResult = mysqli_query($link, $sql);

                        while ($row=mysqli_fetch_array($deviceResult)) {
                            $dateOfJob = new DateTime($row['date']);
                            $dateOfJob = $dateOfJob->format('d/m/Y');
                           
                            $returnString = $returnString . "<tr><td class='text-center align-middle'>" . $dateOfJob ."</td>";
                            $returnString = $returnString . "<td class='text-center align-middle'>" . $row['description'] ."</td>";
                            $returnString = $returnString . "<td class='text-center align-middle'>" . $row['regNumber'] ."</td>";
                            $returnString = $returnString . "<td class='align-middle' style='padding:0 3px;'>" . $row['notes'] ."</td>";
                            $returnString = $returnString . "<td class='align-middle text-center'>
                            <btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0]."edit\")'><svg xmlns='http://www.w3.org/2000/svg' width='16' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                            <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
                          </svg></btn></td>"; 
                            $returnString = $returnString . "</tr>";
                        }

                        $returnString = $returnString. "
                        </tbody>
                    </table>

                    <h6 class='bg-success' style='margin: 0; padding: 1px 3px;'><strong>Completed</strong></h6>
                        <table class='table table-sm table-bordered table-hover' id='jobTable' style='table-layout: fixed'>
                            <thead>
                                <tr>
                                    <th class='text-center align-middle'>Date</th>
                                    <th class='text-center align-middle'>Type</th>
                                    <th class='text-center align-middle'>VRN</th>
                                    <th class='text-left align-middle' style='padding: 0 3px;'>Notes</th>
                                    <th class='text-center align-middle' style='width:8%; padding: 0 3px;'>View</th>
                                </tr>
                            </thead>
                            <tbody>";

                            $sql = "SELECT * FROM tblJobs INNER JOIN tblVehicle ON tblJobs.VRN = tblVehicle.ID INNER JOIN tblJobType ON tblJobType.ID = tblJobs.jobType WHERE (tblJobs.ownerID='" . $_SESSION['currentCustomer'] . "' AND tblJobs.status<>'1') ORDER BY tblJobs.date DESC";
                            $deviceResult = mysqli_query($link, $sql);

                            while ($row=mysqli_fetch_array($deviceResult)) {
                    
                                $dateOfJob = new DateTime($row['date']);
                                $dateOfJob = $dateOfJob->format('d/m/Y');
                                //  $lineColour = $row['colour'];
                                // $returnString = $returnString . "<tr class='table-$lineColour'><td class='text-center align-middle'>" . $dateOfJob ."</td>";
                                $returnString = $returnString . "<tr><td class='text-center align-middle'>" . $dateOfJob ."</td>";
                                $returnString = $returnString . "<td class='text-center align-middle'>" . $row['description'] ."</td>";
                                $returnString = $returnString . "<td class='text-center align-middle'>" . $row['regNumber'] ."</td>";
                                $returnString = $returnString . "<td class='align-middle' style='padding:0 3px;'>" . $row['notes'] ."</td>";
                                $returnString = $returnString . "<td class='text-center align-middle'>
                                    <btn class='btn btn-sm btn-primary' style='margin: 0 10px;' onclick='showFullJob(\"" . $row[0]."view\")'><svg xmlns='http://www.w3.org/2000/svg' width='16' fill='currentColor' class='bi bi-binoculars-fill' viewBox='0 0 16 16'><path d='M4.5 1A1.5 1.5 0 0 0 3 2.5V3h4v-.5A1.5 1.5 0 0 0 5.5 1h-1zM7 4v1h2V4h4v.882a.5.5 0 0 0 .276.447l.895.447A1.5 1.5 0 0 1 15 7.118V13H9v-1.5a.5.5 0 0 1 .146-.354l.854-.853V9.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v.793l.854.853A.5.5 0 0 1 7 11.5V13H1V7.118a1.5 1.5 0 0 1 .83-1.342l.894-.447A.5.5 0 0 0 3 4.882V4h4zM1 14v.5A1.5 1.5 0 0 0 2.5 16h3A1.5 1.5 0 0 0 7 14.5V14H1zm8 0v.5a1.5 1.5 0 0 0 1.5 1.5h3a1.5 1.5 0 0 0 1.5-1.5V14H9zm4-11H9v-.5A1.5 1.5 0 0 1 10.5 1h1A1.5 1.5 0 0 1 13 2.5V3z'/></svg>
                                    </btn>
                                    </td>"; 
                                $returnString = $returnString . "</tr>";
                            }

                            $returnString = $returnString. "
                            </tbody>
                        </table>
            </div>
            <div id='hiddenJobID' style='display: none'></div>
            <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm' style='margin: 0 10px' id='addJobRequest' data-toggle='modal' data-target='#modalAddNewJobRequest' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/>
            </svg> New Request </btn>
            <btn class='btn btn-primary btn-sm' style='margin: 0 10px'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
            </svg> Search </btn>

        </div>
 
    </form>

</div>


<form id='footageForm'>
<div id='showAccountInfo'  class='settings-dialog'>
    <h6><strong style='margin-top:10px;'>FOOTAGE REQUESTS</strong></h6>
    <div id='errorBox'></div>
    <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
        <table class='table table-sm table-bordered table-hover' id='footageTable' style='table-layout: fixed'>
            <thead>
                <tr>
                    <th class='text-center align-middle'>Date</th>
                    <th class='text-center align-middle'>VRN</th>
                    <th class='text-center align-middle' style='padding: 0 3px;'>Claim Ref</th>
                    <th class='text-center align-middle'>Status</th>
                    <th class='text-center align-middle' style='width:8%; padding: 0 3px;'>Edit</th>
                </tr>
            </thead>
            <tbody>";

                $sql = "SELECT * FROM tblFootageRequest INNER JOIN tblVehicle ON tblFootageRequest.vehicleID = tblVehicle.ID INNER JOIN tblFootageStatus ON tblFootageStatus.ID = tblFootageRequest.statusID WHERE tblFootageRequest.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblFootageRequest.incidentDate ASC";
                $deviceResult = mysqli_query($link, $sql);

                while ($row=mysqli_fetch_array($deviceResult)) {
                
                    $dateOfNote = new DateTime($row['incidentDate']);
                    $dateOfNote = $dateOfNote->format('d/m/Y');
                    $lineColour = $row['colour'];
                    $returnString = $returnString . "<tr class='table-$lineColour'><td class='text-center align-middle'>" . $dateOfNote ."</td>";
                    $returnString = $returnString . "<td class='text-center align-middle'>" . $row['regNumber'] ."</td>";
                    $returnString = $returnString . "<td class='text-center align-middle' style='padding:0 3px;'>" . $row['claimRef'] ."</td>";
                    $returnString = $returnString . "<td class='text-center align-middle' style='padding:0 3px;'>" . $row['description'] ."</td>";
                    $returnString = $returnString . "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showFullFootage(" . $row['0']. ")'><svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                    <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
                  </svg></btn></td>"; 
                    $returnString = $returnString . "</tr>";
                }

                $returnString = $returnString. "
            </tbody>
        </table>
    </div>

    <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
        <btn class='btn btn-success btn-sm' style='margin: 0 10px' id='addFootageRequest' type='button' onclick='populateFootageBox()'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/>
        </svg> New Request </btn>
        <btn class='btn btn-primary btn-sm' style='margin: 0 10px'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
        <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
        </svg> Search </btn>
    </div>
</div>
</form>


<form id='notesForm'>
<div id='showAccountInfo' class='settings-dialog'>
    <h6><strong style='margin-top:10px;'>CUSTOMER NOTES</strong></h6>
    <div id='errorBox'></div>
    <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
        <table class='table table-sm table-bordered table-hover' id='customerNotesTable' style='table-layout: fixed;'>
            <thead>
                <tr>
                    <th style='padding:0 3px;'>Date</th>
                    <th style='padding:0 3px;'>Note</th>
                    <th style='padding:0 3px;'>User</th>
                </tr>
            </thead>
            <tbody>";

                $sql = "SELECT * FROM tblCustomerNote INNER JOIN tblUsers ON tblUsers.userID = tblCustomerNote.userID WHERE customerID = '" . $_SESSION['currentCustomer'] . "' ORDER BY noteDate DESC";
                $result = mysqli_query($link, $sql);

                while ($contact=mysqli_fetch_array($result)) {
                    if ($contact['isImportant']=='1') {
                        $returnString .= "<tr class='table-danger' ondblclick='editNote(" .$contact['cnID'] . ")'>";
                    } else {
                        $returnString .= "<tr value='" .$contact['cnID'] . "' ondblclick='editNote(" .$contact['cnID'] . ")'>";
                    }
                    $dateOfNote = new DateTime($contact['noteDate']);
                    $dateOfNote = $dateOfNote->format('d/m/Y');

                    $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $dateOfNote . "</td>";
                    $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $contact['noteText'] ."</td>";
                    $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $contact['userName'] ."</td>";
                    $returnString .= "</tr>";
                }

                    $returnString .= "
            </tbody>
        </table>
    </div>
    <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
        <btn class='btn btn-success btn-sm' style='margin: 0 10px' id='addCustomerNote' type='button' data-toggle='modal' data-target='#modalAddNewNote'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle-fill' viewBox='0 0 16 16'>
        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z'/>
        </svg> New Note</btn>

        <btn class='btn btn-primary btn-sm' style='margin: 0 10px'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
        <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
        </svg> Search </btn>
    </div>
</div>
</form>

<form id='renewalForm'>
    <div id='showAccountInfo' class='settings-dialog'>
        <h6><strong style='margin-top:10px;'>RENEWAL DETAILS</strong></h6>
        <div id='errorBox'></div>
        <div class='form-group' style='display: flex; align-items: center'>
        <label class='control-label inline' for='renewalType' style='width:40%; padding-top:6px'>Renewal type</label>
        <div class='input-group'>
            <select style='font-size: 100%' id='getRenewalTypeSelect' name='getRenewalTypeSelect' onchange='makeDirty(" . '"getRenewalTypeSelect"' .")' class='custom-select getRenewalTypeSelect enabler'>" ;
            $sql="SELECT * FROM tblRenewalType ORDER BY Description ASC" ; 
            $result=mysqli_query($link,$sql); 
            $returnString .="
            <option value= '0' selected='selected'>None Selected</option>" ; 
            while ($renewalRow=mysqli_fetch_array($result)) { 
                if ($theRenewalType==$renewalRow['ID']) { 
                    $returnString .="
                    <option value= " . $renewalRow['ID']. " selected='selected'>" ; } else {
                    $returnString .="
                    <option value= " . $renewalRow['ID'].">";
                }
                $returnString .= $renewalRow['Description']. " </option>";
            }
            $returnString .="
            </select>                  
        </div>
    </div>
    <div class='form-group' style='display: flex; align-items: center'>
        <label id='renewalDateLabel' class='control-label inline' for='renewalDate' style='width:40%; padding-top:6px'>Renewal date</label>
        <div class='input-group'>
           
            <input style='font-size: 100%;' class='form-control dateType enabler dateColour' type='date' id='renewalDate' name='renewalDate' onblur='updateRenewalDate(event);' placeholder='Policy renewal date...' value='" . $theRenewalDate . "'>
            <span class='input-group-append showRenewalStatus'>
            </span>
        </div>
    </div>
    <hr>
    <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
    <btn class='btn btn-success btn-sm updateCustomer' style='margin: 0 10px; float: right' onclick='updateCustomerRenewal()' id='updateCustomerRenewal' type='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-left-circle-fill' viewBox='0 0 16 16'>
    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-5.904 2.803a.5.5 0 1 0 .707-.707L6.707 6h2.768a.5.5 0 1 0 0-1H5.5a.5.5 0 0 0-.5.5v3.975a.5.5 0 0 0 1 0V6.707l4.096 4.096z'/>
    </svg> Update Renewal</btn>
   
    </div>


</form>

</div>

";

} else {

    // DH INSTALL
    
    
$returnString = "<div id='deviceLongList' class='listHeader'><h4><strong>Unassigned Devices</strong></h4></div>";

$sql = "SELECT *, tblCustomer.businessName FROM tblDevice JOIN tblCustomer ON tblDevice.ownerID = tblCustomer.ID WHERE tblCustomer.businessName='DHINSTALL'";
    $result = mysqli_query($link, $sql);
    $devices_NUMBEROF = mysqli_num_rows($result);

    $sql = "SELECT COUNT(tblDevice.ID), tblDevice.status, tblDeviceStatus.status, tblCustomer.businessName FROM tblDevice INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID WHERE tblCustomer.businessName='DHINSTALL' GROUP BY tblDevicestatus.ID";
    $result = mysqli_query($link, $sql);
    $returnString = $returnString . "
        <div id='DeviceStats' style='font-size:120%'>";

            $devicesString = '';
            if ($devices_NUMBEROF!=0) {
                $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF ." (";
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['COUNT(tblDevice.ID)']!=0) {
                        $devicesString = $devicesString . $row['COUNT(tblDevice.ID)'] . " " . $row['status'] . ", ";
                    }
                }
                $devicesString = substr($devicesString,0, -2);
                $devicesString = $devicesString . ")";
            } else {
                $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF;
            }

            $returnString = $returnString . $devicesString;
            $returnString = $returnString . "
        </div><br>";

$returnString .= "
<div class='container'>
  <div id='deviceFilter' style='display: none'>
    <div class='input-group'>
      <input type='text' style='font-size:75%; padding: 5px;' id='byOther' value=''/>
    </div>
  </div>
</div>
";

  $sql = "SELECT tblDevice.ID, tblDevice.ownerID, tblDevice.TDHNumber, tblDevice.serialNumber, tblDevice.IMEI, tblDevice.DRIDNumber, 
  tblDevice.SIMNumber, tblDevice.SIMPhone, tblDevice.config, tblDevice.deviceNote, tblDeviceStatus.status, tblVehicle.regNumber, 
  tblCustomer.businessName, tblDeviceDescription.description, tblSIMStatus.SIMStatus, tblInstaller.installerName, tblDevice.installDate  
  
  FROM tblDevice LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID LEFT JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID 
  LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID =tblDeviceDescription.ID LEFT JOIN tblDeviceStatus ON tblDevice.status 
  = tblDeviceStatus.ID LEFT JOIN tblSIMStatus ON tblDevice.SIMStatus = tblSIMStatus.ID LEFT JOIN tblInstaller ON tblDevice.installerID = tblInstaller.ID 
  WHERE tblCustomer.businessName = 'DHINSTALL' ORDER BY tblCustomer.businessName ASC, tblVehicle.regNumber ASC
  ";


  $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result)!=0) {
      $returnString .="<div id = 'deviceSummary' class='m-4 w-2' style='margin-top: 15px;'>
      <table id='deviceListTable' class='table cell-border compact'>
      <thead>
        <tr>
          <th class='text-center align-middle'><strong>No.</strong></th>

          <th class='text-center align-middle'>TDH Number</th>
          <th class='text-center align-middle'>Reg Number</th>
          <th class='text-center align-middle'>Type</th>     
          <th class='text-center align-middle'>Serial</th>
          <th class='text-center align-middle'>IMEI</th>
          <th class='text-center align-middle'>DRID Number</th>
          <th class='text-center align-middle'>Status</th>
          <th class='text-center align-middle'>SIM Number</th>
          <th class='text-center align-middle'>SIM Status</th>
          <th class='text-center align-middle'>Config</th>
          <th class='text-center align-middle'>Original installer</th>
          <th class='text-center align-middle'>Original install Date</th> 
          <th class='text-center align-middle'>Edit</th>
          <th class='text-center align-middle'>Notes</th>
          <th class='text-center align-middle'>Allocate</th>
        </tr>
      </thead>
    
      <tbody>";

      $ix = 1;
      $rowBackgroundClass = '';
      
      while ($row= mysqli_fetch_array($result)) {
        
        if ($row['status']=='Faulty') {
          $rowBackgroundClass= "faulty";
      } elseif ($row['status']=='Inactive') {
          $rowBackgroundClass= "inactive";
      } else {
          $rowBackgroundClass= "";
      }

        $returnString .= "<tr class='" . $rowBackgroundClass . "'>
        <td class='text-center align-middle' style='padding:0 3px'>" . $ix . "</td>

        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['TDHNumber']. "</td>
        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['regNumber']. "</td>
        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['description']. "</td>  
        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['serialNumber']. "</td>
        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['IMEI']. "</td>
        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['DRIDNumber']. "</td>
        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['status']. "</td>
        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['SIMNumber']. "</td>
        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['SIMStatus']. "</td>
        <td class='align-middle' style='padding:0 3px;'>" . $row['config']. "</td>
        <td class='text-center align-middle' style='padding:0 3px;'>" . $row['installerName']. "</td>";

      $stringyDate = strtotime($row['installDate']);
      if(date('d/m/Y', $stringyDate)=='01/01/1970' || date('d/m/Y', $stringyDate)=='01/01/0001' || date('d/m/Y', $stringyDate)==NULL) {
        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>unknown</td>";
      } else {
        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-sort='" .$row['installDate'] ."'>" . date('d/m/Y', strtotime($row['installDate'])) . "</td>";
      }


        $returnString .="
        <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showFullDevice(\"" . $row['ID']."device\")'><svg xmlns='http://www.w3.org/2000/svg' width='8px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
        <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
        </svg></btn></td>";

        if ($row['deviceNote'] && $row['deviceNote']!="") {
            $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showDeviceNotes(\"" . $row['ID']."device\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' height='16px' fill='currentColor' class='bi bi-journal-check' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z'/><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
        } else {
            $returnString .="<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showDeviceNotes(\"" . $row['ID']."device\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' height='16px' fill='currentColor' class='bi bi-journal' viewBox='0 0 16 16'><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg></btn></td>";
        }

        $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-success' onclick='allocateDevice(\"" . $row['ID']."DHI\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' height='16px' fill='currentColor' class='bi bi-bezier' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5v-1zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z'/><path d='M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5v-1zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z'/>
        </svg></btn></td>";

        $returnString .="</tr>";

        $ix++;
    }

    // } else {
    //   $returnString .="<p class='text-center'>No results found</p>";
    // }
  $returnString .="</tbody>

  <tfoot>
    <tr>
      <th class='text-center align-middle'><strong>No.</strong></th>

      <th class='text-center align-middle'>TDH Number</th>
      <th class='text-center align-middle'>Reg Number</th>
      <th class='text-center align-middle'>Type</th>     
      <th class='text-center align-middle'>Serial</th>
      <th class='text-center align-middle'>IMEI</th>
      <th class='text-center align-middle'>DRID Number</th>
      <th class='text-center align-middle'>Status</th>
      <th class='text-center align-middle'>SIM Number</th>
      <th class='text-center align-middle'>SIM Status</th>
      <th class='text-center align-middle'>Config</th>
      <th class='text-center align-middle'>Original installer</th>
      <th class='text-center align-middle'>Original install Date</th> 
      <th class='text-center align-middle'>Edit</th>
      <th class='text-center align-middle'>Notes</th>
      <th class='text-center align-middle'>Allocate</th>
    </tr>
  </tfoot>

  </table>

</div>
<script>
 document.getElementById('byOther').addEventListener('keypress', function (event) {
       if (event.keyCode == 13) {
            event.preventDefault();
        } 
    });

    $(document).ready(function() {
      $('#deviceListTable').DataTable({
        columnDefs: [
          {orderable: false, targets: [13,14] },
          {searchable: false, targets: [13,14] }
        ],
        processing: true,
        paging: false,
        responsive: true,
        dom: '<\"top\"iflp>rt<\"bottom\"><\"clear\">',
        rowCallback: function(row, data, dataIndex) {
          if ($('body').hasClass('dark')) {
            $(row).css('background-color', 'rgba(68,68,68,1)')
                  .css('color', 'white');
          } else {
            $(row).css('background-color', 'rgba(255,255,255,1)')
                  .css('color', 'rgba(68,68,68,1)');
        }
        if ($(row).hasClass('faulty')) {
          $(row).css('background-color', 'rgba(255,32,32,0.75)')
                  .css('color', 'rgba(255,255,255,0.75)');
        }
        if ($(row).hasClass('inactive')) {
          $(row).css('background-color', 'rgba(255,176,0,0.75)')
          .css('color', 'rgb(0,0,0,0.75)');
      }
      },
        initComplete: function() {
          this.api().columns([1,2,3,4,5,6,7,8,9,10,11,12,12]).every (function() {
            var column = this;
            var select = $('<br><select><option value=\"\"></option></select>')
            .appendTo($(column.header()))
            .on('change', function() {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              column
                .search(val ? '^'+val+'$' : '', true, false)
                .draw();
            });
  
            column.data().unique().sort().each(function (d,j) {
              select.append('<option value=\"'+d+'\">'+d+'</option>')
            });
          });
        }
      });
  });
    </script>
";

} 


}

echo $returnString;
?>