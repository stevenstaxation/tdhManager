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
if (isset($_POST['selectedValue'])) {
    $_SESSION['currentCustomer'] = $_POST['selectedValue'];
}


$sql= "SELECT * FROM tblCustomer LEFT JOIN tblInsurer ON tblCustomer.insurerID = tblInsurer.ID LEFT JOIN tblBroker ON tblCustomer.brokerID = tblBroker.ID  LEFT JOIN tblRenewalType ON tblCustomer.renewalType = tblRenewalType.ID WHERE tblCustomer.ID='" . $_SESSION['currentCustomer'] . "'";

$result = mysqli_query($link, $sql);

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
<div class='row' style='font-size:80%;'>
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
<div id='showAccountInfo' class='settings-dialog'>
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

        $returnString = $returnString. "
        <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
            <table class='table table-sm table-bordered table-hover' id='devicesTable' style='table-layout: fixed;'>
                <thead>
                    <tr>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>No</th>
                        <th class='text-center align-middle'>VRN</th>
                        <th class='text-center align-middle'>Device</th>
                        <th class='text-center align-middle'>Serial</th>
                        <th class='text-center align-middle'>DRID</th>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>Edit</th>
                    </tr>
                </thead>
                <tbody>";

                    $sql = "SELECT * FROM tblDevice INNER JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID INNER JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID = tbldeviceDescription.ID WHERE tblDevice.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblVehicle.regNumber ASC";
                    $deviceResult = mysqli_query($link, $sql);
                    $ix= 1;
                    while ($row=mysqli_fetch_array($deviceResult)) {
                        $returnString = $returnString . "<tr><td class='align-middle text-center' style='padding: 0 3px;'>" . $ix ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['regNumber'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['description'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['serialNumber'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['DRIDNumber'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center'><btn class='btn btn-sm btn-warning' onclick='showFullDevice(\"" . $row[0]."customer\")'><svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                        <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
                      </svg></btn></td>";
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
            <btn class='btn btn-primary btn-sm' style='margin: 0 10px'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
            </svg> Search </btn>
        </div>
</div>
</form>

<form id='vehicleForm'>
<div id='showAccountInfo' class='settings-dialog'>";

$sql = "SELECT * FROM tblVehicle WHERE tblVehicle.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblVehicle.regNumber ASC";
$deviceResult = mysqli_query($link, $sql);
$vehicles_NUMBEROF = mysqli_num_rows($deviceResult);
$returnString .="
    <h6><strong style='margin-top:10px;'>VEHICLES</strong></h6> 
    <div id='DeviceStats' style='font-size:120%'>Total Vehicles: " . $vehicles_NUMBEROF . "</div> 
    <div id='errorBox'></div>
     <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
            <table class='table table-sm table-bordered table-hover' id='vehiclesTable' style='table-layout: fixed;'>
                <thead>
                    <tr>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>No</th>
                        <th class='text-center align-middle'>VRN</th>
                        <th class='text-center align-middle'>Make</th>
                        <th class='text-center align-middle'>Model</th>
                        <th class='text-center align-middle'>Description</th>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>Edit</th>
                    </tr>
                </thead>
                <tbody>";

                   $ix = 1;
                    while ($row=mysqli_fetch_array($deviceResult)) {
                        $returnString = $returnString . "<tr><td class='align-middle text-center' style='padding: 0 3px;'>" . $ix ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['regNumber'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['make'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['model'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center' style='padding: 0 3px;'>" . $row['addDescription'] ."</td>";
                        $returnString = $returnString . "<td class='align-middle text-center'><btn class='btn btn-sm btn-warning' onclick='showVehicleForEdit(\"" . $row[0] . "customer\")'><svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                        <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
                      </svg></btn></td>";
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
            <btn class='btn btn-primary btn-sm' style='margin: 0 10px'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z' />
            </svg> Search </btn>
        </div>
        </div>
    </form>


    


     
       
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
            <select  style='font-size: 80%' id='getRenewalTypeSelect' name='getRenewalTypeSelect' onchange='makeDirty(" . '"getRenewalTypeSelect"' .")' class='custom-select getRenewalTypeSelect enabler'>" ;
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
            <input style='font-size: 80%; background-color:" . $renewalColour ."' oninput='makeDirty(" . '"renewalDate"'
            . ")' class='form-control dateType enabler' type='date' id='renewalDate' name='renewalDate' onblur='updateRenewalDate(event);' placeholder='Policy renewal date...' value='" . $theRenewalDate . "'>
        </div>
    </div>
    <hr>
    <small style='color: red';>**FOR NOW** To confirm RENEWAL DATE click 'UPDATE' in Business Details section</small>
    </div>


</form>

</div>

 


    

      



";


echo $returnString;
?>