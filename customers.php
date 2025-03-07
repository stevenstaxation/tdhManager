<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$foreColor = $_SESSION['textColor'];
$tableColour = 'table-light';
$tableText = $_SESSION['textColor'];
$notRenewable = $_SESSION['renewalColor'];
$returnString = "";
$_SESSION['currentCustomer'] = $_POST['selectedValue'];

$sql = "SELECT * FROM tblCustomer LEFT JOIN tblInsurer ON tblCustomer.insurerID = tblInsurer.ID LEFT JOIN tblBroker ON tblCustomer.brokerID = tblBroker.ID  LEFT JOIN tblRenewalType ON tblCustomer.renewalType = tblRenewalType.ID WHERE tblCustomer.ID='" . $_SESSION['currentCustomer'] . "'";

$result = mysqli_query($link, $sql);

if (!$result) {
    exit();
}

if ($result) {
    if (mysqli_num_rows($result) == 0) {
        exit();
    }
}

if (mysqli_num_rows($result) == 0) {
    echo $returnString;
    exit();
}

// if there are no elements in $row then we just select the top record
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
} else {
    $sql = "SELECT * FROM tblCustomer LEFT JOIN tblInsurer ON tblCustomer.insurerID = tblInsurer.ID LEFT JOIN tblBroker ON tblCustomer.brokerID = tblBroker.ID LEFT JOIN tblRenewalType ON tblCustomer.renewalType = tblRenewalType.ID ORDER BY businessNAME ASC LIMIT 1";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
}
$thisClientName = $row['businessName'];

if ($row['businessName'] != 'DHINSTALL' && $row['businessName'] != 'DHD') {
    $dateNow = new DateTime();
    $dateNow = new DateTime();
    $renewalDate = new DateTime($row['renewalDate'] ?? '');
    $daysToRenewal = $dateNow->diff($renewalDate)->format('%r%a');

    if ($daysToRenewal <= 30) {
        $renewalColour = '#B60000';
    } elseif ($daysToRenewal <= 60) {
        $renewalColour = 'orange';
    } else {
        $renewalColour = $notRenewable;
    }

    $returnString = "
<div id='hiddenCustomerID' style='display: none'>" . $row[0] . "</div>
<div id='hiddenCustomerName' style='display: none'>" . $thisClientName . "</div>

<div class='row' style='font-size:100%;'>
    <div class='col-lg-6 col-xl-4'>
        <form id='nameForm'>
            <div id='showAccountInfo' class='settings-dialog'>
                <div class='form-group' style='display: flex; align-items: center; font-size: 24px'>
                    <label class='control-label inline' for='customerName' style='width:40%; padding-top:7px'><strong>Name</strong></label>
                    <div class='input-group'>
                        <input style='maxlength=100; font-weight: bold; font-size: 24px;' oninput='makeDirty(" . '"customerName"' . ")'
                        class='form-control enabler' type='text' id='customerName' name='customerName'
                        placeholder='enter customer name...' value='" . $row['businessName'] . "'>
                    </div>
                </div>
                <div class='form-group' style='display: flex; align-items: center; font-size: 12px'>
                    <label class='control-label inline' for='VCOReference' style='width:40%; padding-top:7px'><strong>VCO Reference</strong></label>
                    <div class='input-group'>
                        <input style='font-weight: bold; font-size: 12px;' maxlength=10
                        class='form-control enabler' type='text' id='VCOReference' name='VCOReference'
                        placeholder='Vodafone reference...' value='" . $row['VCOReference'] . "'>
                    </div>
                </div>
                
                <div class='btn-group' style ='display: flex; margin: 2px 2px;'>
                    <btn class='btn btn-success btn-sm updateCustomer profileButton' onclick='updateCustomer()' id='updateCustomer' type='button'><i class='bi bi-arrow-up-left-circle-fill h5'></i> Update Name/VCO Reference </btn>
                </div>
            </div>

        </form>
        <form id='customerForm'>
        <div id='toggleAddress' style='float: right;' class='btn btn-sm collapsible' type='button'>address</div>
                <div class='scrollBox canCollapse' style='max-height: 75vh;'>
                <div id='showAccountInfo' class='settings-dialog'>
                    <div class='form-group' style='display: flex; align-items: center'>
                        <h6><strong style='margin-top:10px;'>ADDRESS</strong></h6>
                        <div id='errorBox'></div>
                        <hr>
                    </div>

                    <div class='form-group' style='display: flex; align-items: center'>
                        <label class='control-label inline' for='addressLookup' style='width:40%; padding-top:6px'>Lookup</label>
                            <div class='input-group'>
                               <input style='font-size: 80%' maxlength='50' class='form-control enabler' type='text'
                                   id='addressLookup' name='addressLookup' placeholder='Name or number...' value=''>
                               <input style='font-size: 80%' maxlength='50' class='form-control enabler' type='text'
                                   id='addressLookup2' name='addressLookup2' placeholder='Postcode...' value=''>
                               <btn class='btn btn-info btn-sm' style='margin-left:1px;border-radius:3px; id='
                                   findAddress' type='button' onclick='lookupAddress()'> Find </btn>
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
                   <script>
                    var coll = document.getElementsByClassName('collapsible');
                    var i;

                    for (i = 0; i < coll.length; i++) {
                        coll[i].addEventListener('click', function() {
                            this.classList.toggle('active');
                            var content = this.nextElementSibling;
                            if (content.style.display === 'block') {
                                content.style.display = 'none';
                                $('#toggleAddress').html('address');
                            } else {
                                content.style.display = 'block';
                                $('#toggleAddress').html('hide');
                            }
                        });
                    }

                   </script>
                   ";

    $theRenewalType = $row['renewalType'];
    $theRenewalDate = $row['renewalDate'];

    $returnString .= "<div class='btn-group' style ='display: flex; margin: 10px 20px;'>
                        <btn class='btn btn-success btn-sm updateCustomer profileButton' onclick='updateCustomer()' id='updateCustomer' type='button'><i class='bi bi-arrow-up-left-circle-fill h5'></i> Update </btn>";

    $returnString .= "
                    </div>
                    <div id='customerUpdateMessage'></div>
                </div>
                </div>
        </form>";

    $dateNow = new DateTime();
    $renewalDate = new DateTime($row['renewalDate'] ?? '');
    $daysToRenewal = $dateNow->diff($renewalDate)->format('%r%a');

    if ($daysToRenewal <= 30) {
        $renewalColour = '#B60000';
    } elseif ($daysToRenewal <= 60) {
        $renewalColour = 'orange';
    } else {
        $renewalColour = $notRenewable;
    }
    $returnString = $returnString . "
        <form id='notesForm'>
<div id='showAccountInfo' class='settings-dialog customerTable'>
    <h6><strong style='margin-top:10px;'>CUSTOMER NOTES</strong></h6>
    <div id='errorBox'></div>
    <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
        <table class='table table-sm table-bordered table-hover' id='customerNotesTable' style='table-layout: fixed;'>
            <thead>
                <tr>
                    <th style='padding:0 3px; width: 20%'>Date</th>
                    <th style='padding:0 3px;'>Note</th>

                </tr>
            </thead>
            <tbody>";

    $sql = "SELECT * FROM tblCustomerNote INNER JOIN tblUsers ON tblUsers.userID = tblCustomerNote.userID WHERE customerID = '" . $_SESSION['currentCustomer'] . "' ORDER BY noteDate DESC";
    $result = mysqli_query($link, $sql);

    while ($contact = mysqli_fetch_array($result)) {
        if ($contact['isImportant'] == '1') {
            $returnString .= "<tr class='table-danger' ondblclick='editNote(" . $contact['cnID'] . ")'>";
        } else {
            $returnString .= "<tr value='" . $contact['cnID'] . "' ondblclick='editNote(" . $contact['cnID'] . ")'>";
        }
        $dateOfNote = new DateTime($contact['noteDate']);
        $dateOfNote = $dateOfNote->format('d/m/Y');

        $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $dateOfNote . "</td>";
        $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $contact['noteText'] . "</td>";

        $returnString .= "</tr>";
    }

    $returnString .= "
            </tbody>
        </table>
    </div>
    <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
        <btn class='btn btn-success btn-sm profileButton' id='addCustomerNote' type='button' data-toggle='modal' data-target='#modalAddNewNote'><i class='bi bi-plus-circle-fill h5'></i> New Note</btn>
    </div>
</div>
</form>
<script>
    $(document).ready(function() {
        $('#customerNotesTable').DataTable({
            retrieve: true,
            stateSave: true,
            order: [0, 'asc'],
            processiong: true,
            fixedHeader: true,
            paging: false,
            deferRender: true,
            responsive: true,
            select: {
                style: 'os',
                items: 'cell'
              },
            dom: '<\"top\"fi>rt<\"bottom\"><\"clear\">',
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



<form id='renewalForm'>
    <div id='showAccountInfo' class='settings-dialog'>
        <h6><strong style='margin-top:10px;'>RENEWAL DETAILS</strong></h6>
        <div id='errorBox'></div>
        <div class='form-group' style='display: flex; align-items: center'>
        <p class='control-label inline' style='width:40%; padding-top:10px'>Renewal type</p>
        <div class='input-group'>
            <select style='font-size: 100%' id='getRenewalTypeSelect' name='getRenewalTypeSelect' onchange='makeDirty(" . '"getRenewalTypeSelect"' . ")' class='custom-select getRenewalTypeSelect enabler'>";
    $sql = "SELECT * FROM tblRenewalType ORDER BY Description ASC";
    $result = mysqli_query($link, $sql);
    $returnString .= "
            <option value= '0' selected='selected'>None Selected</option>";
    while ($renewalRow = mysqli_fetch_array($result)) {
        if ($theRenewalType == $renewalRow['ID']) {
            $returnString .= "
                    <option value= " . $renewalRow['ID'] . " selected='selected'>";
        } else {
            $returnString .= "
                    <option value= " . $renewalRow['ID'] . ">";
        }
        $returnString .= $renewalRow['Description'] . " </option>";
    }
    $returnString .= "
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
    <btn class='btn btn-success btn-sm updateCustomer profileButton' style='float: right' onclick='updateCustomerRenewal()' id='updateCustomerRenewal' type='button'><i class='bi bi-arrow-up-left-circle-fill h5'></i> Update Renewal</btn>

    </div>
    </div>


</form>










</div>

<div class='col-lg-6 col-xl-4'>

<form id='contactsForm'>
        <div id='showAccountInfo' class='settings-dialog customerTable'>
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
                            <th class='align-middle text-center mx-1' style='width:8%;'>Ftg</th>
                            <th class='align-middle text-center mx-1' style='width:8%;'>H/C</th>
                            <th class='align-middle text-center mx-1' style='width:8%;'>Rpt</th>
                        </tr>
                    </thead>
                    <tbody>";

    $sql = "SELECT * FROM tblCustomerContact WHERE businessID = '" . $_SESSION['currentCustomer'] . "' ORDER BY lastName, firstName ASC";
    $result = mysqli_query($link, $sql);

    while ($contact = mysqli_fetch_array($result)) {
        $returnString .= "<tr class='clickable-row' value='" . $contact['ID'] . "' ondblclick='editContact(" . $contact['ID'] . ")'><td class='align-middle' style='padding:0 3px;'>" . $contact['firstName'] . " " . $contact['lastName'] . "</td>";
        $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $contact['email'] . "</td>";
        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>" . $contact['mobileNo'] . "</td>";
        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>" . $contact['telephone'] . "</td>";
        $returnString .= "<td class='align-middle' style='padding:0 3px;'><center><input type='checkbox' class='isFootageRequest' name='isFootageRequest' onclick='return false' " . ($contact['isFootageRecipient'] == 1 ? 'checked' : '') . " value='1'/>&nbsp;</center></td>";
        $returnString .= "<td class='align-middle' style='padding:0 3px;'><center><input type='checkbox' class='isHealthCheck' name='isHealthCheck' onclick='return false' " . ($contact['isHealthCheck'] == 1 ? 'checked' : '') . " value='1'/>&nbsp;</center></td>";
        $returnString .= "<td class='align-middle' style='padding:0 3px;'><center><input type='checkbox' class='isReporting' name='isReporting' onclick='return false' " . ($contact['isReporting'] == 1 ? 'checked' : '') . " value='1'/>&nbsp;</center></td>";
        $returnString .= "</tr>";
    }

    $returnString .= "
                    </tbody>
                </table>
            </div>
            <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
                 <btn class='btn btn-success btn-sm profileButton' id='addNewContact' type='button' data-toggle='modal' data-target='#modalAddNewContact'><i class='bi bi-plus-circle-fill h5'></i> New Contact</btn>

            </div>
        </div>
    </form>
    <script>
    $(document).ready(function() {
        $('#customerContactTable').DataTable({
            retrieve: true,
            stateSave: true,
            order: [0, 'asc'],
            processiong: true,
            fixedHeader: true,
            paging: false,
            deferRender: true,
            responsive: true,
            select: {
                style: 'os',
                items: 'cell'
              },
            dom: '<\"top\"fi>rt<\"bottom\"><\"clear\">',
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


            <form id='insurerForm' class='customerTable'>
                <div id='showAccountInfo' class='settings-dialog'>
                    <h6><strong style='margin-top:10px;'>INSURER</strong></h6>
                    <div id='errorBox'></div>
                    <div class='form-group' style='display: flex; align-items: center'>
                        <p class='control-label inline' style='width:40%; padding-top:10px'>Name</p>
                        <div class='input-group'>
                            <select  style='font-size: 80%' id='getInsurerSelect' name='getInsurerSelect' class='custom-select getInsurerSelect'>";
    $sql = "SELECT * FROM tblInsurer ORDER BY insurerName ASC";
    $result = mysqli_query($link, $sql);
    $returnString .= "
                            <option value= '0' selected='selected'>None Selected</option>";
    while ($insurerRow = mysqli_fetch_array($result)) {
        if ($row['insurerID'] == $insurerRow['ID']) {
            $returnString .= "
                                    <option value= " . $insurerRow['ID'] . " selected='selected'>";
        } else {
            $returnString .= "
                                    <option value= " . $insurerRow['ID'] . ">";
        }
        $returnString .= $insurerRow['insurerName'] . " </option>";
    }

    $returnString .= "
                            </select>

                            <btn class='btn btn-primary btn-sm' id='editInsurerModal' type='button' onclick='editInsurer()'> More </btn>
                            <btn class='btn btn-success btn-sm' id='addInsurerModal' type='button' data-toggle='modal' data-target='#modalAddNewInsurer' data-caller='customer'> Add </btn>
                        </div>
                    </div>
                    <hr>

                    <div class='form-group'>
                        <p><strong>Contacts</strong></p>
                        <div class='scrollBox' style='max-height: 20vh; overflow: auto;'>
                            <table class='table table-sm table-bordered table-hover' id='insurerContactTable' style='table-layout: fixed;'>
                                <thead>
                                    <tr>
                                        <th class='align-middle mx-1'>Name</th>
                                        <th class='align-middle mx-1'>Email</th>
                                        <th class='text-center align-middle'>Mobile</th>
                                        <th class='text-center align-middle'>Phone</th>
                                        <th class='text-center align-middle mx-1' style='width:8%;'>Ftg</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>";

    $sql = "SELECT * FROM tblInsurerContact WHERE insurerID = '" . $row['insurerID'] . "' ORDER BY lastName, firstName ASC";
    $result = mysqli_query($link, $sql);
    while ($contact = mysqli_fetch_array($result)) {
        $returnString .= "<tr class='clickable-row' value='" . $contact['ID'] . "' ondblclick='editInsurerContact(" . $contact['ID'] . ")'><td class='align-middle' style='padding:0 3px;'>" . $contact['firstName'] . " " . $contact['lastName'] . " </td>";
        $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $contact['email'] . "</td>";
        $returnString .= "<td class='text-center align-middle'>" . $contact['mobileNo'] . "</td>";
        $returnString .= "<td class='text-center align-middle'>" . $contact['telephone'] . "</td>";
        $returnString .= "<td class='align-middle'><center><input type='checkbox' class='isFootageRequest' onclick='return false;' name='isFootageRequest' " . ($contact['isFootageRecipient'] == 1 ? 'checked' : '') . " value='1' />&nbsp;</center></td>";
        // $returnString .= "<td class='align-middle'><center><input type='checkbox' class='isHealthCheck' onclick='return false;' name='isHealthCheck' " . ($contact['isHealthCheck'] == 1 ? 'checked' : '') . " value='1' />&nbsp;</center></td>";
        $returnString .= "</tr>";
    }

    $returnString .= "
                                </tbody>
                            </table>
                            <div id='hiddenInfo' style='display: none'>" . $row['insurerID'] . "</div>
                            <div id='insurerEditNumber' style='display: none'>" . $row['insurerID'] . "</div>
                        </div>
                        <div class='btn-group' style='display: flex; margin: 10px 20px;'>
                            <btn class='btn btn-success btn-sm profileButton' type='button' data-toggle='modal' data-target='#modalAddNewInsurerContact' data-caller='customer'><i class='bi bi-person-lines-fill h5'></i> New Contact </btn>


                        </div>
                        <div id='renewalUpdateMessage'></div>
                    </div>
                </div>
                <script>
                $(document).ready(function() {
                    $('#insurerContactTable').DataTable({
                        retrieve: true,
                        stateSave: true,
                        order: [0, 'asc'],
                        processiong: true,
                        fixedHeader: true,
                        paging: false,
                        deferRender: true,
                        responsive: true,
                        select: {
                            style: 'os',
                            items: 'cell'
                          },
                        dom: '<\"top\"fi>rt<\"bottom\"><\"clear\">',
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
            </form>


    <form id='brokerForm'>
        <div id='showAccountInfo' class='settings-dialog'>
            <h6><strong style='margin-top:10px;'>BROKER</strong></h6>
            <div id='errorBox'></div>
            <div class='form-group' style='display: flex; align-items: center'>
                <p class='control-label inline' for='brokerName' style='width:40%; padding-top:10px'>Name</p>
                <div class='input-group'>
                    <select style='font-size: 80%' id='getBrokerSelect' name='getBrokerSelect' class='custom-select getBrokerSelect'>";

    $sql = "SELECT * FROM tblBroker ORDER BY brokerName ASC";
    $result = mysqli_query($link, $sql);
    $returnString .= "<option value = 0 selected='selected'>None Selected</option>";

    while ($brokerRow = mysqli_fetch_array($result)) {
        if ($row['brokerID'] == $brokerRow['ID']) {
            $returnString .= "<option value= " . $brokerRow['ID'] . " selected='selected'>";
        } else {
            $returnString .= "<option value= " . $brokerRow['ID'] . ">";
        }
        $returnString .= $brokerRow['brokerName'] . " </option>";
    }

    $returnString .= "
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
                                <th class='align-middle mx-1'>Name</th>
                                <th class='align-middle mx-1'>Email</th>
                                <th class='align-middle text-center mx-1'>Mobile</th>
                                <th class='align-middle text-center mx-1'>Phone</th>
                                <th class='text-center mx-1' style='width:8%;'>Ftg</th>
                                <th class='text-center mx-1' style='width:8%;'>Rpt</th>
                            </tr>
                        </thead>
                        <tbody>";

    $sql = "SELECT * FROM tblBrokerContact WHERE brokerID = '" . $row['brokerID'] . "' ORDER BY lastName, firstName ASC";

    $result = mysqli_query($link, $sql);

    while ($contact = mysqli_fetch_array($result)) {
        $returnString .= "<tr class='clickable-row' value='" . $contact['ID'] . "' ondblclick='editBrokerContact(" . $contact['ID'] . ")'><td class='align-middle' style='padding:0 3px;'>" . $contact['firstName'] . " " . $contact['lastName'] . "</td>";
        $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $contact['email'] . "</td>";
        $returnString .= "<td class='align-middle text-center' style='padding:0 3px;'>" . $contact['mobileNo'] . "</td>";
        $returnString .= "<td class='align-middle text-center' style='padding:0 3px;'>" . $contact['telephone'] . "</td>";
        $returnString .= "<td class='align-middle'><center><input type='checkbox' class='isFootageRequest' name='isFootageRequest' onclick='return false;' " . ($contact['isFootageRecipient'] == 1 ? 'checked' : '') . " value='1'/>&nbsp;</center></td>";
        $returnString .= "<td class='align-middle'><center><input type='checkbox' class='isHealthCheck' name='isHealthCheck' onclick='return false;' " . ($contact['isReporting'] == 1 ? 'checked' : '') . " value='1'/>&nbsp;</center></td>";
        $returnString .= "</tr>";
    }

    $returnString .= "
                        </tbody>
                    </table>
                    <div id='brokerHiddenInfo' style='display: none'>" . $row['brokerID'] . "</div>
                </div>
                <div class='btn-group' style='display: flex; margin: 10px 20px;'>
                    <btn id='addBrokerContactButton' class='btn btn-success btn-sm profileButton' type='button' data-toggle='modal' data-target='#modalAddNewBrokerContact'><i class='bi bi-person-lines-fill h5'></i> New Contact </btn>
                </div>
            </div>
            </div>
        </div>
    </form>



<div class='col-lg-6 col-xl-4' style='font-size: 80%'>

";

    $returnString = $returnString . "
<form id='footageForm'>
<div id='showAccountInfo'  class='settings-dialog customerTable'>
    <h6><strong style='margin-top:10px;'>FOOTAGE REQUESTS</strong></h6>
    <div id='errorBox'></div>
    <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
        <table class='table table-sm table-bordered table-hover' id='footageTable' style='table-layout: fixed'>
            <thead>
                <tr>
                    <th class='text-center align-middle'>Date</th>
                    <th class='text-center align-middle'>VRN</th>
                    <th class='text-center align-middle mx-1'>Claim Ref</th>
                    <th class='text-center align-middle'>Status</th>
                    <th class='text-center align-middle mx-1' style='width:8%;'>Edit</th>
                </tr>
            </thead>
            <tbody>";

    $sql = "SELECT * FROM tblFootageRequest INNER JOIN tblVehicle ON tblFootageRequest.vehicleID = tblVehicle.ID INNER JOIN tblFootageStatus ON tblFootageStatus.ID = tblFootageRequest.statusID WHERE tblFootageRequest.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblFootageRequest.incidentDate ASC";
    $deviceResult = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_array($deviceResult)) {

        $dateOfNote = new DateTime($row['incidentDate']);
        $dateOfNote = $dateOfNote->format('d/m/Y');
        $lineColour = $row['colour'];
        $returnString = $returnString . "<tr class='table-$lineColour'><td class='text-center align-middle'>" . $dateOfNote . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle'>" . $row['regNumber'] . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle' style='padding:0 3px;'>" . $row['claimRef'] . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle' style='padding:0 3px;'>" . $row['description'] . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showFullFootage(" . $row['0'] . ")'><i class='bi bi-pencil-fill h5'></i></btn></td>";
        $returnString = $returnString . "</tr>";
    }

    $returnString = $returnString . "
            </tbody>
        </table>
    </div>

    <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
        <btn class='btn btn-success btn-sm profileButton' id='addFootageRequest' type='button' onclick='populateFootageBox()'><i class='bi bi-plus-circle-fill h5'></i> New Request </btn>
    </div>
</div>
</form>
<script>
    $(document).ready(function() {
        $('#footageTable').DataTable({
            retrieve: true,
            stateSave: true,
            order: [0, 'asc'],
            processiong: true,
            fixedHeader: true,
            paging: false,
            deferRender: true,
            responsive: true,
            select: {
                style: 'os',
                items: 'cell'
              },
            dom: '<\"top\"fi>rt<\"bottom\"><\"clear\">',
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

<div class='col-12' style='font-size: 80%'>
    <form id='jobForm'>
          <div id='showAccountInfo' class='settings-dialog customerTable'>
            <h6><strong style='margin-top:10px;'>JOB REQUESTS</strong></h6>
            <div id='errorBox'></div>
            <div id='JobStats'>";

    $sql = "SELECT * FROM tblJobs WHERE tblJobs.ownerID='" . $_SESSION['currentCustomer'] . "'";
    $result = mysqli_query($link, $sql);
    $jobs_NUMBEROF = mysqli_num_rows($result);

    $sql = "SELECT COUNT(tblJobs.ID) AS JobCount, tblJobs.status FROM tblJobs WHERE tblJobs.ownerID='" . $_SESSION['currentCustomer'] . "' GROUP BY tblJobs.status";
    $jobResult = mysqli_query($link, $sql);

    $jobsString = "";
    if ($jobs_NUMBEROF != 0) {
        $jobsString = $jobsString . "Total Jobs: " . $jobs_NUMBEROF . " (";
        while ($row = mysqli_fetch_array($jobResult)) {
            if ($row['JobCount'] != 0) {
                $jobsString .= $row[0] . " ";
                switch ($row['status']) {
                    case 1:
                        $jobsString .= " pending, ";
                        break;
                    case 2:
                        $jobsString .= " booked, ";
                        break;
                    case 4:
                        $jobsString .= " date passed, ";
                        break;
                    case 8:
                        $jobsString .= " awaiting approval, ";
                        break;
                    case 16:
                        $jobsString .= " completed, ";
                        break;
                    case 32:
                        $jobsString .= " cancelled, ";
                        break;
                    case 64:
                        $jobsString .= " archived, ";
                        break;
                }
            }
        }
        $jobsString = substr($jobsString, 0, -2);
        $jobsString .= ")";
    } else {
        $jobsString = $jobsString . "Total Jobs: " . $jobs_NUMBEROF;
    }
    $returnString .= $jobsString . "
            </div>
            <br>";

    $returnString .= "
            <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>";

    $sql = "SELECT tblJobs.ID, tblJobs.timePeriod, tblJobs.ownerID,  tblJobs.date, tblJobs.dateAdded, tblJobs.PriorityIsUrgent, tblJobs.jobType, tblJobType.description, tblJobs.VRN, tblVehicle.regNumber, tblJobs.notes, tblCustomer.businessName, tblJobs.status, tblDeviceDescription.description as CameraType, tblusers.userName as EngineerName, tblUsers.colour as EngineerColour, tblJobs.bookingAddress, tblJobs.jobRate, tblJobs.customerRate
                FROM tblJobs LEFT JOIN tblVehicle ON tblJobs.VRN = tblVehicle.ID INNER JOIN tblJobType ON tblJobs.jobType = tblJobType.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblJobs.ownerID INNER JOIN tblDeviceDescription ON tblDeviceDescription.ID = tblJobs.cameratypeID LEFT JOIN tblusers ON tblusers.userID = tblJobs.engineerID WHERE tblJobs.ownerID = '" . $_SESSION['currentCustomer'] . "'";
    $jobResult = mysqli_query($link, $sql);

    if (mysqli_num_rows($jobResult) != 0) {
        $returnString .= "<table id='jobsTable' style='table-layout:fixed' class='table cell-border table-sm compact'>
                    <thead>
                        <tr>
                            <th class='text-center align-middle' colspan='1' rowspan='2'>Date Added</th>

                            <th class='text-center align-middle' colspan='1' rowspan='2'>Job Type</th>
                            <th class='align-middle' colspan='1' rowspan='2'>Camera Type</th>
                            <th class='text-center align-middle' colspan='1' rowspan='2'>Registration(s)</th>
                            <th colspan='2' class='text-center'>Job Rate</th>
                            <th class='align-middle' colspan='1' rowspan='2'>Engineer Assigned</th>
                            <th class='align-middle' colspan='1' rowspan='2'>Address</th>
                            <th class='text-center align-middle' colspan='1' rowspan='2'>Date/Time Booked</th>
                            <th class='text-center align-middle' colspan='1' rowspan='2'>Status</th>
                            <th class='text-center align-middle' colspan='1' rowspan='2'>Edit</th>
                        </tr>
                        <tr>
                            <th class='text-center align-middle'>Customer Rate</th>
                            <th class='text-center align-middle'>Engineer Rate</th>
                        </tr>
                  </thead>
                  <tbody>";

        while ($row = mysqli_fetch_array($jobResult)) {
            switch ($row['status']) {
                case 1:
                    $rowBackground = "Pending";
                    $rowColour = '#CCCC55';
                    break;
                case 2:
                    $bookedDate = strtotime($row['date']);
                    $today = strtotime(date('Y-m-d H:i:s'));
                    $diffInSeconds = $today - $bookedDate;

                    if ($diffInSeconds < 0) {
                        $rowBackground = "Booked";
                        $rowColour = '#2255FF';
                    } else {
                        $rowBackground = "Booked - Date Passed";
                        $rowColour = '#b60000';
                        $sql = "UPDATE tblJobs SET status='4'";
                        $sql .= " WHERE ID = '" . $row['ID'] . "'";
                        $update = mysqli_query($link, $sql);
                        break;
                    }
                    break;
                case 4:
                    $rowBackground = "Booked - Date Passed";
                    $rowColour = '#b60000';
                    break;
                case 8:
                    $rowBackground = "Awaiting Approval";
                    $rowColour = '#1e90ff';
                    break;
                case 16:
                    $rowBackground = "Complete";
                    $rowColour = '#55CC55';
                    break;
                case 32:
                    $rowBackground = "Cancelled";
                    $rowColour = '#FF00FF';
                    break;
                case 64:
                    $rowBackground = "Archived";
                    $rowColour = '#888888';
                    break;
                default:
                    $rowBackground = "UNKNOWN";
                    $rowColour = '#B60000';
            }
            if ($row['PriorityIsUrgent'] == 2) {
                $jobPriority = "Urgent";
            } else {
                $jobPriority = "Standard";
            }

            $EngineerTextColour = intval(substr($row['EngineerColour'] ?? '', 1, 2), 16) * 0.299;
            $EngineerTextColour += intval(substr($row['EngineerColour'] ?? '', 3, 2), 16) * 0.587;
            $EngineerTextColour += intval(substr($row['EngineerColour'] ?? '', 5, 2), 16) * 0.114;
            if ($EngineerTextColour > 150) {
                $engineerColor = '#222222';
            } else {
                $engineerColor = '#EEEEEE';
            }

            $returnString .= "
                        <tr class = ''>
                            <td class='text-center align-middle' style='padding:0 3px;' data-order=" . date('Y-m-d', strtotime($row['dateAdded'])) . ">" . date('d/m/Y', strtotime($row['dateAdded'])) . "</td>

                            <td class='text-center align-middle' style='padding:0 3px;'>" . $row['description'] . "</td>
                            <td class='align-middle' style='padding:0 3px;'>" . $row['CameraType'] . "</td>
                            <td class='text-center align-middle' style='padding:0 3px;'>" . $row['regNumber'] . "</td>";

            if ($row['customerRate'] != 0) {
                $returnString .= "<td class='text-right align-middle' style='padding:0 10px;'>£" . number_format($row['customerRate'], 2, '.', ',') . "</td>";
            } else {
                $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>N/A</td>";
            }

            if ($row['jobRate'] != 0) {
                $returnString .= "<td class='text-right align-middle' style='padding:0 10px;'>£" . number_format($row['jobRate'], 2, '.', ',') . "</td>";
            } else {
                $returnString .= "<td class='text-center align-middle' style='padding:0 3px;'>N/A</td>";
            }
            if ($row['EngineerName'] == '') {
                $row['EngineerColour'] = '#CCCC55';
                $row['EngineerName'] = "No Engineer Assigned...";
                $returnString .= "
                                <td class='text-center align-middle' style='font-size: 75%; padding:0 3px; color: " . $row['EngineerColour'] . "'>" . $row['EngineerName'] . "</td>";
            } else {
                $returnString .= "
                                <td class='text-center align-middle' style='font-size: 85%; padding:0 3px; color: " . $row['EngineerColour'] . "'><b>" . $row['EngineerName'] . "</b></td>";
            }
            if ($row['bookingAddress'] == '') {
                $row['bookingAddress'] = "Awaiting confirmation...";
                $returnString .= "<td class='align-middle' style='padding:0 3px; color: #CCCC55'>" . $row['bookingAddress'] . "</td>";
            } else {
                $returnString .= "<td class='align-middle' style='padding:0 3px;'>" . $row['bookingAddress'] . "</td>";
            }

            if ($row["date"]) {         
                if (date('d/m/Y', strtotime($row['date'] ?? '')) == '01/01/1970') {
                    $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>TBD</td>";
                } else {
                    if (date('H:i', strtotime($row['date']))!="00:00") {
                        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order=" . strtotime($row['date']) . ">" . date('d/m/Y (D) H:i', strtotime($row['date'])) . "</td>";
                    } else {
                        switch ($row['timePeriod']) {
                            case 1:
                            $periodOfTime = " All Day";
                            break;
                            case 2:
                            $periodOfTime = " Morning";
                            break;
                            case 3:
                            $periodOfTime = " Afternoon";
                            break;
                            default:
                            $periodOfTime = " Unknown";
                        }
                        $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order=" . strtotime($row['date']) . ">" . date('d/m/Y (D)', strtotime($row['date'])). $periodOfTime ."</td>";
                    }
                }
            } else {
                $returnString .= "<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>TBD</td>";
            }
            $returnString .= "
                            <td class='text-center align-middle' style='font-size: 85%; color: " . $rowColour . "'><b>" . $rowBackground . "</b></td>";

            $returnString .= "<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0] . "edit\")'><i class='bi bi-pencil-fill h5'></i></btn></td>";

            $returnString .= "
                        </tr>";
        }

        $returnString .= "
                    </tbody>
                    </table>";
    } else {
        $returnString .= "<p class='text-center'>No results found</p>";
    }

    $returnString .= "

            </div>

            <div class='btn-group' style ='display: flex; margin: 10px 20px;'>
                <btn class='btn btn-success btn-sm profileButton' id='addJobRequest' onclick='addJobRequest(\"customer\")' type='button'><i class='bi bi-plus-circle-fill'></i> New Request </btn>
            </div>
</div>
        </div>
        </div>
        </form>

            <div id='hiddenJobID' style='display: none'></div>


            <script>

               $(document).ready(function() {
                 var table = $('#jobsTable').DataTable({
                   retrieve: true,
                   stateSave: true,
                   columnDefs: [
                     {orderable: false, targets: [9] },
                     {searchable: false, targets: [9] }
                   ],
                   order: [[4, 'asc']],
                   processing: true,
                   paging: false,
                   fixedHeader: true,
                   deferRender: true,
                   responsive: true,
                   select: {
                     style: 'os',
                     items: 'cell'
                   },
                   dom: '<\"top\"lfip>rt<\"bottom\"><\"clear\">',
                   rowCallback: function(row, data, dataIndex) {
                     if ($('body').hasClass('dark')) {
                       $(row).css('background-color', 'rgba(68,68,68,1)')
                             .css('color', 'white')
                     } else {
                       $(row).css('background-color', 'rgba(255,255,255,1)')
                             .css('color', 'rgba(68,68,68,1)')
                   }
                 }
               });

             });

               </script>


            </div>
        </form>
    </div>






















<div class='col-12' style='font-size: 80%'>

<form id='deviceForm'>
<div id='showAccountInfo' class='settings-dialog customerTable'>
    <h6><strong style='margin-top:10px;'>DEVICES
    </strong></h6>
    <div id='errorBox'></div>";

    $sql = "SELECT * FROM tblDevice WHERE tblDevice.ownerID='" . $_SESSION['currentCustomer'] . "'";
    $result = mysqli_query($link, $sql);
    $devices_NUMBEROF = mysqli_num_rows($result);

    $sql = "SELECT COUNT(tblDevice.ID), tblDevice.status, tblDeviceStatus.status FROM tblDevice INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.ID WHERE tblDevice.ownerID='" . $_SESSION['currentCustomer'] . "' GROUP BY tblDevicestatus.ID";

    $result = mysqli_query($link, $sql);
    $returnString = $returnString . "
        <div id='DeviceStats' style='font-size:120%'>";

    $devicesString = '';
    if ($devices_NUMBEROF != 0) {
        $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF . " (";
        while ($row = mysqli_fetch_array($result)) {
            if ($row['COUNT(tblDevice.ID)'] != 0) {
                $devicesString = $devicesString . $row['COUNT(tblDevice.ID)'] . " " . $row['status'] . ", ";
            }
        }
        $devicesString = substr($devicesString, 0, -2);
        $devicesString = $devicesString . ")";
    } else {
        $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF;
    }

    $returnString = $returnString . $devicesString;
    $returnString = $returnString . "
        </div><br>";

    $returnString .= "
        <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
            <table id='devicesTable' style='table-layout:fixed;' class='table cell-border table-sm compact'>";

    // <table class='table table-sm table-bordered table-hover' id='devicesTable' style='table-layout: fixed;'>
    $returnString .= "    <thead>
                    <tr>
                    <th class='text-center align-middle'>Reg Number</th>
                    <th class='text-center align-middle'>Type</th>
                    <th class='text-center align-middle'>Platform</th>
                    <th class='text-center align-middle'>Serial</th>
                    <th class='text-center align-middle'>IMEI</th>
                    <th class='text-center align-middle'>DRID Number</th>
                    <th class='text-center align-middle'>Config</th>
                    <th class='text-center align-middle'>Status</th>
                    <th class='text-center align-middle'>SIM Number</th>
                    <th class='text-center align-middle'>SIM Phone</th>
                    <th class='text-center align-middle'>Deactivation Date</th>
                    <th class='text-center align-middle'>SIM Status</th>

                    <th class='text-center align-middle'>Original installer</th>
                    <th class='text-center align-middle'>Original install Date</th>
                    <th class='text-center align-middle'>Edit</th>
                    <th class='text-center align-middle'>Notes</th>
                    <th class='text-center align-middle' style='display: none'>Hide</th>
                    <th class='text-center align-middle' style='display: none'>Hide Notes</th>
                    <th class='text-center align-middle' style='display: none'>updatePlatform</th>
                    <th class='text-center align-middle' style='display: none'>updateConfig</th>
                    <th class='text-center align-middle' style='display: none'>updateVCO</th>


                    </tr>
                </thead>
                <tbody>";

    // $sql = "SELECT *, tblDeviceStatus.description FROM tblDevice LEFT JOIN tblDevice.status = tblDeviceStatus.ID LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID = tbldeviceDescription.ID WHERE tblDevice.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblVehicle.regNumber ASC";

    // $sql = "SELECT * FROM tblDevice LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID = tbldeviceDescription.ID WHERE tblDevice.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblVehicle.regNumber ASC";

    $sql = "SELECT tblDevice.ID, tblDevice.ownerID, tblDevice.TDHNumber, tblDevice.serialNumber, tblDevice.IMEI, tblDevice.DRIDNumber, tblSupplier.supplierName,
            tblDevice.SIMNumber, tblDevice.SIMPhone, tblDevice.SIMDeactivationDate, tblDevice.config, tblDevice.deviceNote, tblDeviceStatus.status, tblVehicle.regNumber,
            tblCustomer.businessName, tblDeviceDescription.description, tblSIMStatus.SIMStatus, tblInstaller.installerName, tblDevice.installDate, tblDevice.scheduledDate,  tblDevice.platformUpdated, tblDevice.configUpdated, tblDevice.vcoUpdated

            FROM tblDevice
            LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID
            LEFT JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID
            LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID =tblDeviceDescription.ID
            LEFT JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.ID
            LEFT JOIN tblSIMStatus ON tblDevice.SIMStatus = tblSIMStatus.ID
            LEFT JOIN tblInstaller ON tblDevice.installerID = tblInstaller.ID
            LEFT JOIN tblSupplier ON tblDevice.supplierID = tblSupplier.ID
            WHERE tblDevice.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblCustomer.businessName ASC, tblVehicle.regNumber IS NOT TRUE, tblVehicle.regNumber ASC";

    $deviceResult = mysqli_query($link, $sql);
    // $ix= 1;
    $rowBackgroundClass = '';
    while ($row = mysqli_fetch_array($deviceResult)) {

        $returnString = $returnString . "<tr>";
        // $returnString = $returnString . "<td class='text-center align-middle' style='padding:0 3px;'>" . $row['TDHNumber']. "</td>";
        $returnString = $returnString . "<td class='align-middle text-center mx-1'>" . $row['regNumber'] . "</td>";
        $returnString = $returnString . "<td class='align-middle text-center mx-1'>" . $row['description'] . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle mx-1'>" . $row['supplierName'] . "</td>";
        $returnString = $returnString . "<td class='align-middle text-center mx-1'>" . $row['serialNumber'] . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle mx-1'>" . $row['IMEI'] . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle mx-1'>" . $row['DRIDNumber'] . "</td>";
        $returnString = $returnString . "<td class='align-middle mx-1'>" . $row['config'] . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle mx-1'>" . $row['status'] . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle mx-1'>" . $row['SIMNumber'] . "</td>";
        $returnString = $returnString . "<td class='text-center align-middle mx-1'>" . $row['SIMPhone'] . "</td>";

        $simDate = date('d/m/Y', strtotime($row['scheduledDate'] ?? ''));
        if ($simDate == '' || $simDate == null || $simDate == '01/01/1970') {
            $simDate = '';
            $returnString .= "<td class='text-center align-middle mx-1' data-order='0/0/0'>" . $simDate . "</td>";
        } else {
            $returnString .= "<td class='text-center align-middle mx-1' data-order=" . date('Y-m-d', strtotime($row['scheduledDate'])) . ">" . $simDate . "</td>";
        }
        $returnString = $returnString . "<td class='text-center align-middle mx-1'>" . $row['SIMStatus'] . "</td>";

        $returnString = $returnString . "<td class='text-center align-middle mx-1'>" . $row['installerName'] . "</td>";

        $stringyDate = strtotime($row['installDate'] ?? '');
        if (date('d/m/Y', $stringyDate) == '01/01/1970' || date('d/m/Y', $stringyDate) == '01/01/0001' || date('d/m/Y', $stringyDate) == null) {
            $returnString .= "<td class='text-center align-middle mx-1' data-order='0/0/0'>unknown</td>";
        } else {
            $returnString .= "<td class='text-center align-middle mx-1' data-order='" . date('Y-m-d', strtotime($row['installDate'])) . "'>" . date('d/m/Y', strtotime($row['installDate'])) . "</td>";
        }

        $returnString = $returnString . "<td class='align-middle text-center'><btn class='btn btn-sm btn-warning' onclick='showFullDevice(\"" . $row[0] . "customer\")'><i class='bi bi-pencil-fill h5'></i></btn></td>";

        if ($row['deviceNote'] && $row['deviceNote'] != "") {
            $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showDeviceNotes(\"" . $row[0] . "customer\")'><i class='bi bi-journal-check h5'></i></btn></td>";
        } else {
            $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showDeviceNotes(\"" . $row[0] . "customer\")'><i class='bi bi-journal h5'></i></btn></td>";
        }

        $hiddenVRN = $row['regNumber'];
        if ($hiddenVRN == '' || $hiddenVRN = null) {
            $hiddenVRN = 'zzzzzzzzzz';
        }
        $returnString .= "<td class='text-center align-middle' style='display: none'>" . $hiddenVRN . "</td>";
        $returnString .= "<td class='text-center align-middle' style='display: none'>" . $row['deviceNote'] . "</td>";
        $returnString .= "<td class='text-center align-middle' style='display: none'>" . $row['platformUpdated'] . "</td>";
        $returnString .= "<td class='text-center align-middle' style='display: none'>" . $row['configUpdated'] . "</td>";
        $returnString .= "<td class='text-center align-middle' style='display: none'>" . $row['vcoUpdated'] . "</td>";
        $returnString = $returnString . "</tr>";
        // $ix++;
    }

    $returnString = $returnString . "
                </tbody>
            </table>
        </div>
        <div class='btn-group' style='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm profileButton' id='addDevice' type='button' data-toggle='modal' data-target='#modalAddNewDevice'><i class='bi bi-plus-circle-fill h5'></i> New Device </btn>
        </div>
</div>
</form>
<script>
var alertColour = '#FFAA44';
if ($('body').hasClass('dark')) {
    alertColour = '#fff035';
}

$(document).ready(function() {

    $('#devicesTable').DataTable({
        retrieve: true,
        stateSave: true,

        columnDefs: [
            {'targets': 2, 'createdCell': function (td,cellData, rowData, row, col) {

                if (rowData[18]!=1 && rowData[7].includes('Installed') && rowData[11]=='Active') {

                    $(td).css('color', alertColour);
                }
                }
                },
                {'targets': 6, 'createdCell': function (td,cellData, rowData, row, col) {

                    if (rowData[6]=='' || rowData[6]==null) {
                        $(td).html('No config assigned');
                    }
                    if ((rowData[19]!=1) && (rowData[0]!='DHD' && rowData[0]!='DHINSTALL' && rowData[7].includes('Installed') && rowData[11]=='Active'))  {
                        $(td).css('color', alertColour);
                    }
                    }
            },
                {'targets': 9, 'createdCell': function (td,cellData, rowData, row, col) {

                if (rowData[9]=='' || rowData[9]==null) {
                    $(td).html('No SIM Phone assigned');
                }
                    if ((rowData[20]!=1) && (rowData[0]!='DHD' && rowData[0]!='DHINSTALL' && rowData[7].includes('Installed') && rowData[11]=='Active')) {
                        $(td).css('color', alertColour);
                }
                }
        },
        {targets: [16,17,18,19,20], className: 'never' },
        {orderable: false, targets: [14,15,16,17,18,19,20] },
        {searchable: false, targets: [14,15,16,17,18,19,20] }
      ],
      order: [[0, 'asc'], [1, 'asc']],
      processing: true,
      paging: false,
      fixedHeader: true,
      deferRender: true,
      responsive: true,
      select: {
        style: 'os',
        items: 'cell'
      },
      dom: '<\"top\"lfip>rt<\"bottom\"><\"clear\">',
      rowCallback: function(row, data, dataIndex) {
        if ($('body').hasClass('dark')) {
          $(row).css('background-color', 'rgba(68,68,68,1)')
                .css('color', 'white');
        } else {
          $(row).css('background-color', 'white')
                .css('color', 'rgba(68,68,68,1)');
        }

    }
    });
});

document.getElementById('hiddenDeviceSelector').value = 'dhinstall';

</script>

</div>
<div class='container'>
<form id='vehicleForm'>
<div id='showAccountInfo' class='settings-dialog customerTable'>";

    $sql = "SELECT * FROM tblVehicle WHERE tblVehicle.ownerID='" . $_SESSION['currentCustomer'] . "' ORDER BY tblVehicle.regNumber ASC";
    $deviceResult = mysqli_query($link, $sql);
    $vehicles_NUMBEROF = mysqli_num_rows($deviceResult);
    $vehiclesString = '';
    $returnString .= "<h6><strong style='margin-top:10px;'>VEHICLES</strong></h6>
<div id='DeviceStats' style='font-size:120%'>";

    $sql = "SELECT COUNT(tblVehicle.ID), tblVehicle.vehicleStatus FROM tblVehicle WHERE tblVehicle.ownerID='" . $_SESSION['currentCustomer'] . "' GROUP BY tblVehicle.vehicleStatus";
    $result = mysqli_query($link, $sql);

    if ($vehicles_NUMBEROF != 0) {
        $vehiclesString = "Total Vehicles: " . $vehicles_NUMBEROF . " (";
        while ($row = mysqli_fetch_array($result)) {
            if ($row['COUNT(tblVehicle.ID)'] != 0) {
                switch ($row['vehicleStatus']) {
                    case '0':
                        $statusDescription = 'N/A';
                        break;
                    case '1':
                        $statusDescription = 'Pending';
                        break;
                    case '2':
                        $statusDescription = 'Installed';
                        break;
                    default:
                        break;
                }
                $vehiclesString .= $row['COUNT(tblVehicle.ID)'] . " " . $statusDescription . ", ";
            }
        }

        $vehiclesString = substr($vehiclesString, 0, -2);
        $vehiclesString .= ")";
    } else {
        $vehiclesString .= "Total Vehicles: " . $vehicles_NUMBEROF;
    }

    $returnString .= $vehiclesString;
    $returnString .= "
    </div><br>
    <div id='errorBox'></div>
     <div class='scrollBox' style='max-height: 30vh; overflow: auto;'>
            <table class='table cell-border table-sm table-striped compact' id='vehiclesTable' style='table-layout: fixed;'>
                <thead>
                    <tr>

                        <th class='text-center align-middle'>VRN</th>
                        <th class='text-center align-middle'>Camera Required</th>
                        <th class='text-center align-middle'>Status</th>
                        <th class='text-center align-middle'>Install Date</th>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>Edit</th>
                        <th class='text-center align-middle' style='width:8%; padding 0 3px;'>Notes</th>
                    </tr>
                </thead>
                <tbody>";

    //    $ix = 1;
    while ($row = mysqli_fetch_array($deviceResult)) {
        $returnString = $returnString . "<tr>";
        $returnString = $returnString . "<td class='align-middle text-center mx-1'>" . $row['regNumber'] . "</td>";

        if ($row['cameraRequired'] == '1') {
            $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='yesIcon' src='images/green_tick_16.png'/><span style='display:none;'>green_tick</span></td>";
        } else {
            $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='noIcon' src='images/red_cross_16.png'/><span style='display:none;'>red_cross</span></td>";
        }
        if ($row['vehicleStatus'] == '2') {
            $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='yesIcon' src='images/green_tick_16.png'/><span style='display:none;'>green_tick</span></td>";
        } else if ($row['vehicleStatus'] == '1') {
            $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='pendingIcon' src='images/blue_ellipsis_16.png'/><span style='display:none;'>blue_ellipsis</span></td>";
        } else {
            $returnString .= "<td class='text-center align-middle' style='padding-left: 5px;width: 6%'><img class='noIcon' src='images/red_cross_16.png'/><span style='display:none;'>red_cross</span></td>";
        }

        $stringyDate = strtotime($row['installDate'] ?? '');

        if (date('d/m/Y', $stringyDate) == '01/01/1970' || date('d/m/Y', $stringyDate) == '01/01/0001' || date('d/m/Y', $stringyDate) == null) {
            $returnString .= "<td class='text-center align-middle' data-order='0/0/0'>TBC</td>";
        } else {
            $returnString .= "<td class='text-center align-middle' data-order=" . date('Y-m-d', $stringyDate) . ">" . date('d/m/Y', $stringyDate) . "</td>";
        }

        $returnString = $returnString . "<td class='align-middle text-center'><btn class='btn btn-sm btn-warning' onclick='showVehicleForEdit(\"" . $row[0] . "customer\")'><i class='bi bi-pencil-fill h5'></i></btn></td>";

        if ($row['vehicleNotes'] && $row['vehicleNotes'] != "") {
            $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showVehicleNotes(\"" . $row[0] . "customer\")'><i class='bi bi-journal-check h5'></i></btn></td></tr>";
        } else {
            $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showVehicleNotes(\"" . $row[0] . "customer\")'><i class='bi bi-journal'></i></btn></td></tr>";
        }

        $returnString = $returnString . "</tr>";
        // $ix++;
    }

    $returnString = $returnString . "
                </tbody>
            </table>
        </div>
        <div class='btn-group' style='display: flex; margin: 10px 20px;'>
            <btn class='btn btn-success btn-sm profileButton' id='addVehicle' type='button' data-toggle='modal' data-target='#modalAddVehicle'><i class='bi bi-plus-circle-fill h5'></i> New Vehicle </btn>
        </div>
        </div>
    </form>
</div>
    <script>
    $(document).ready(function() {
    $('#vehiclesTable').DataTable({
      retrieve: true,
      columnDefs: [
        {orderable: false, targets: [4, 5] },
        {searchable: false, targets: [4, 5] }
      ],
      order: [[0, 'asc']],
      processing: true,
      paging: false,
      select: {
        style: 'os',
        items: 'cell'
      },
      dom: '<\"top\"lfip>rt<\"bottom\"><\"clear\">',
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

";
} else {

    // DH INSTALL

    $returnString = "
<div id='deviceLongList' class='listHeader'><h4><strong>Unassigned Devices</strong></h4></div>";

    $sql = "SELECT *, tblCustomer.businessName FROM tblDevice JOIN tblCustomer ON tblDevice.ownerID = tblCustomer.ID WHERE tblCustomer.businessName='$thisClientName'";
    $result = mysqli_query($link, $sql);
    $devices_NUMBEROF = mysqli_num_rows($result);

    $sql = "SELECT COUNT(tblDevice.ID), tblDevice.status, tblDeviceStatus.status, tblCustomer.businessName FROM tblDevice INNER JOIN tblDeviceStatus ON tblDevice.status = tblDeviceStatus.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID WHERE tblCustomer.businessName='$thisClientName' GROUP BY tblDevicestatus.ID";
    $result = mysqli_query($link, $sql);
    $returnString = $returnString . "
        <div id='DeviceStats' style='font-size:120%'>";

    $devicesString = '';
    if ($devices_NUMBEROF != 0) {
        $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF . " (";
        while ($row = mysqli_fetch_array($result)) {
            if ($row['COUNT(tblDevice.ID)'] != 0) {
                $devicesString = $devicesString . $row['COUNT(tblDevice.ID)'] . " " . $row['status'] . ", ";
            }
        }
        $devicesString = substr($devicesString, 0, -2);
        $devicesString = $devicesString . ")";
    } else {
        $devicesString = $devicesString . "Total Devices: " . $devices_NUMBEROF;
    }

    $returnString = $returnString . $devicesString;
    $returnString = $returnString . "
        </div>
        <div id='hiddenCustomerName' style='display: none'>" . $thisClientName . "</div>
        <br>";

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
  tblDevice.SIMNumber, tblDevice.SIMPhone, tblDevice.SIMDeactivationDate, tblDevice.config, tblDevice.deviceNote, tblDeviceStatus.status, tblVehicle.regNumber,
  tblCustomer.businessName, tblDeviceDescription.description, tblSIMStatus.SIMStatus, tblInstaller.installerName, tblDevice.installDate

  FROM tblDevice LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID LEFT JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID
  LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID =tblDeviceDescription.ID LEFT JOIN tblDeviceStatus ON tblDevice.status
  = tblDeviceStatus.ID LEFT JOIN tblSIMStatus ON tblDevice.SIMStatus = tblSIMStatus.ID LEFT JOIN tblInstaller ON tblDevice.installerID = tblInstaller.ID
  WHERE tblCustomer.businessName = '$thisClientName' ORDER BY tblCustomer.businessName ASC, tblVehicle.regNumber ASC
  ";

    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) != 0) {
        $returnString .= "<div id = 'deviceSummary' class='m-4 w-2' style='margin-top: 15px;'>
      <table id='deviceListTable' class='table cell-border compact'>
      <thead>
        <tr>

          <th class='text-center align-middle'>Reg Number</th>
          <th class='text-center align-middle'>Type</th>
          <th class='text-center align-middle'>Serial</th>
          <th class='text-center align-middle'>IMEI</th>
          <th class='text-center align-middle'>DRID Number</th>
          <th class='text-center align-middle'>Config</th>
          <th class='text-center align-middle'>Status</th>
          <th class='text-center align-middle'>SIM Number</th>

          <th class='text-center align-middle'>SIM Phone</th>
          <th class='text-center align-middle'>Deactivation Date</th>
          <th class='text-center align-middle'>SIM Status</th>

          <th class='text-center align-middle'>Original installer</th>
          <th class='text-center align-middle'>Original install Date</th>
          <th class='text-center align-middle'>Edit</th>
          <th class='text-center align-middle'>Notes</th>
          <th class='text-center align-middle'>Allocate</th>
        </tr>
      </thead>

      <tbody>";

        $rowBackgroundClass = '';

        while ($row = mysqli_fetch_array($result)) {
            switch ($row['status']) {
                case 'Faulty':
                case 'Stolen':
                case 'Sold':
                    $rowBackgroundClass = "faulty";
                    break;
                case 'Inactive':
                    $rowBackgroundClass = "inactive";
                    break;
                default:
                    $rowBackgroundClass = "";
                    break;
            }
   

            $returnString .= "<tr class='" . $rowBackgroundClass . "'>
        <td class='text-center align-middle mx-1'>" . $row['regNumber'] . "</td>
        <td class='text-center align-middle mx-1'>" . $row['description'] . "</td>
        <td class='text-center align-middle mx-1'>" . $row['serialNumber'] . "</td>
        <td class='text-center align-middle mx-1'>" . $row['IMEI'] . "</td>
        <td class='text-center align-middle mx-1'>" . $row['DRIDNumber'] . "</td>
        <td class='align-middle mx-1'>" . $row['config'] . "</td>
        <td class='text-center align-middle mx-1'>" . $row['status'] . "</td>
        <td class='text-center align-middle mx-1'>" . $row['SIMNumber'] . "</td>
        <td class='text-center align-middle mx-1'>" . $row['SIMPhone'] . "</td>";

            if ($row['SIMDeactivationDate'] != '') {
                $simDate = date('d/m/Y', strtotime($row['SIMDeactivationDate']));
            } else {
                $simDate = strtotime(0);
            }
            if ($simDate == '' || $simDate == null || $simDate == '01/01/1970') {
                $simDate = '';
                $returnString .= "<td class='text-center align-middle mx-1' data-order='0/0/0'>" . $simDate . "</td>";
            } else {
                $returnString .= "<td class='text-center align-middle mx-1' data-order='" . strtotime($row['SIMDeactivationDate']) . "'>" . $simDate . "</td>";
            }

            $returnString .= "
        <td class='text-center align-middle mx-1'>" . $row['SIMStatus'] . "</td>

        <td class='text-center align-middle mx-1'>" . $row['installerName'] . "</td>";

            if ($row['installDate'] != '') {
                $stringyDate = strtotime($row['installDate']);
            } else {
                $stringyDate = strtotime(0);
            }
            if (date('d/m/Y', $stringyDate) == '01/01/1970' || date('d/m/Y', $stringyDate) == '01/01/0001' || date('d/m/Y', $stringyDate) == null) {
                $returnString .= "<td class='text-center align-middle mx-1' data-order='0/0/0'>unknown</td>";
            } else {
                $returnString .= "<td class='text-center align-middle mx-1' data-order='" . strtotime($row['installDate']) . "'>" . date('d/m/Y', strtotime($row['installDate'])) . "</td>";
            }

            $returnString .= "
        <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showFullDevice(\"" . $row['ID'] . "DHI\")'><i class='bi bi-pencil-fill h5'></i></btn></td>";

            if ($row['deviceNote'] && $row['deviceNote'] != "") {
                $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showDeviceNotes(\"" . $row['ID'] . "DHI\")'><i class='bi bi-journal-check h5'></i></btn></td>";
            } else {
                $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showDeviceNotes(\"" . $row['ID'] . "DHI\")'><i class='bi bi-journal h5'></i></btn></td>";
            }

            $returnString .= "<td class='text-center align-middle'><btn class='btn btn-sm btn-success' onclick='allocateDevice(\"" . $row['ID'] . "DHI\")'><i class='bi bi-bezier h5'></i></btn></td>";

            $returnString .= "</tr>";
        }

        // } else {
        //   $returnString .="<p class='text-center'>No results found</p>";
        // }
        $returnString .= "</tbody>

  <tfoot>
    <tr>
      <th class='text-center align-middle'>Reg Number</th>
      <th class='text-center align-middle'>Type</th>
      <th class='text-center align-middle'>Serial</th>
      <th class='text-center align-middle'>IMEI</th>
      <th class='text-center align-middle'>DRID Number</th>
      <th class='text-center align-middle'>Config</th>
      <th class='text-center align-middle'>Status</th>
      <th class='text-center align-middle'>SIM Number</th>
      <th class='text-center align-middle'>SIM Status</th>
      <th class='text-center align-middle'>SIM Phone</th>
      <th class='text-center align-middle'>Deactivation Date</th>

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
        retrieve: true,
        columnDefs: [
          {orderable: false, targets: [13,14,15] },
          {searchable: false, targets: [13,14,15] }
        ],
        order: [[0, 'asc'], [1,'asc']],
        processing: true,
        fixedHeader: true,
        pagingType: 'numbers',
        lengthMenu: [[50, 100, 250, 500, -1], [50, 100, 250, 500, 'All']],
        deferRender: true,
        responsive: true,
        select: {
            style: 'os',
            items: 'cell'
          },
        dom: '<\"top\"lfip>rt<\"bottom\"><\"clear\">',
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
";
    }
}

echo $returnString;
