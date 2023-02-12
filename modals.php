
<!-- GET NEW USER EMAIL ADDRESS -->
<div class="modal" id="modalGetNewUserEmail" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:50%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Invite new user</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getNewUserEmail' class='getNewUserEmail form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-sm-4 col-md-4'>
                                <label class='control-label inline' for='newUserEmailAddress' style='padding-top:8px;'><strong>Email invite</strong></label>
                            </div>
                            <div class='col-sm-8 col-md-6'>
                                <div class='input-group'>
                                    <input class='form-control' type='email' placeholder="Invitee email address..." name='newUserEmailAddress' id='newUserEmailAddress'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-3'>
                                <label class='control-label inline' for='newUserLogInType' style='padding-top:16px;'><strong>User Type</strong></label>
                            </div>
                            <div class='col-2' style='margin-top:16px'>
                                <input type='radio' class='form-check-input' id='userLogInStandard' name='userType'>Standard
                            </div>
                            <div class='col-2' style='margin-top:16px'>
                                <input type='radio' class='form-check-input' id='userLogInAdmin' name='userType'>Admin
                            </div>
                            <div class='col-2' style='margin-top:16px'>
                                <input type='radio' class='form-check-input' id='userLogInInstaller' name='userType'>Installer
                            </div>
                            <div class='col-2' style='margin-top:16px'>
                                <input type='radio' class='form-check-input' id='userLogInEngineer' name='userType'>Engineer
                            </div>
                        </div>
                    </div>
                    <div id='newUserEmailMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='inviteNewUserEmail' class="btn btn-success">Send Invite</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>

</div>





<!-- SHOW ALERTS LIST -->
<div class="modal" id="modalShowAlerts" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:75%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title"><strong>Outstanding Alerts</strong></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%;max-height: 50vh; overflow: auto'>
                <form method='POST' id='showAlerts' class='showAlerts form-block'>
                    <div class='form-group'>
                        <div class='rowAlert'>
                        </div>
                    </div>
                    <div id='alertListMessage'></div>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- CHANGE PASSWORD MODAL -->
<div class="modal" id="modalChangePassword" data-backdrop='static'>
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Change Password</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form class='form-block' id='getPasswords'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='oldPassword' style='padding-top:8px;'><strong>Current Password</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter old  password..." id='oldPassword' autocomplete='current-password'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='newPassword'><strong>New Password</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter new password..." id='newPassword' autocomplete='new-password'>
                                </div>
                            </div>
                            <label class='control-label' for='newPassword2' style='padding-top:10px;'><strong>Confirm Password</strong></label>
                            <div class='input-group'>
                                <input type='text' class='form-control' placeholder="Re-enter new password..." id='newPassword2' autocomplete='new-password'>
                            </div>
                        </div>
                    </div>
                    <div id='PasswordMessage'></div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='updatePassword' onclick='updatePassword();' class="btn btn-success">Update</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ----------------------------------------END OF PASSWORD DIALOGS---------------------------------------- -->




<!-- ---------------------------------------- DEVICE DIALOGS ---------------------------------------------- -->
<!-- ADD NEW DEVICE DIALOG -->
<div class="modal" id="modalAddNewDevice" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:75%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Allocate New Device</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddNewDevice' class='getAddNewDevice form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceDescription' style='padding-top:8px;'><strong>Device</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='addDeviceDescription' name='addDeviceDescription' class='custom-select addDeviceDescription'>
                                        <?php
$sql = "SELECT * FROM tblDeviceDescription ORDER BY description ASC";
$result = mysqli_query($link, $sql);

while ($deviceRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $deviceRow['ID'] . ">" . $deviceRow['description'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addTDHNumber' style='padding-top:9px;'><strong>TDH Number</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="TDH Number..." id='addTDHNumber' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addSerial' style='padding-top:10px;'><strong>Serial Number</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Serial Number..." id='addSerial' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addIMEI' style='padding-top:11px;'><strong>IMEI</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='20' placeholder="IMEI..." id='addIMEI' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDRIDNumber' style='padding-top:11px;'><strong>DRID</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="DRID..." id='addDRIDNumber' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addSIMNumber' style='padding-top:12px;'><strong>SIM Serial</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="SIM Serial..." id='addSIMNumber' style='margin-top:3px;' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addSIMPhone' style='padding-top:12px;'><strong>SIM Phone</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='20' placeholder="SIM Phone..." id='addSIMPhone' style='margin-top:3px;' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addSIMStatus' style='padding-top:13px;'><strong>SIM Status</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='addSIMStatus' name='addSIMStatus' class='custom-select addSIMStatus' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT * FROM tblSIMStatus ORDER BY SIMStatus ASC";
$result = mysqli_query($link, $sql);

while ($SIMRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['SIMStatus'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addSIMDate' style='padding-top:13px;'><strong>SIM Deactivate</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='addSIMDate' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addOwnerID' style='padding-top:13px;'><strong>Allocated to</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' readonly='readonly' id='addOwnerID' style='margin-top:3px;text-align: left' value=''>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addVRN' style='padding-top:13px;'><strong>Vehicle Reg</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="VRN..." id='addVRN' style='margin-top:3px;'>
                                    <div class='input-group-append'></div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addConfigFile' style='padding-top:14px;'><strong>Config file</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='512' placeholder="Config description (max 512 chars)..." id='addConfigFile' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceStatus' style='padding-top:14px;'><strong>Current Status</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='addDeviceStatus' name='addDeviceStatus' class='custom-select addDeviceStatus' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT * FROM tblDeviceStatus ORDER BY ID ASC";
$result = mysqli_query($link, $sql);
while ($SIMRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['status'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceInstaller' style='padding-top:15px;'><strong>Original installer</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='addDeviceInstaller' name='addDeviceInstaller' class='custom-select addDeviceInstaller' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT defaultInstaller FROM tblGlobals LIMIT 1";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$DEFAULT_INSTALLER = $row['defaultInstaller'];

$sql = "SELECT * FROM tblInstaller ORDER BY installerName ASC";
$result = mysqli_query($link, $sql);
while ($SIMRow = mysqli_fetch_array($result)) {
    if ($SIMRow['ID'] == $DEFAULT_INSTALLER) {
        echo "<option selected='selected' value = " . $SIMRow['ID'] . ">" . $SIMRow['installerName'] . "</option>";
    } else {
        echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['installerName'] . "</option>";
    }
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceInstalldate' style='padding-top:15px;'><strong>Original install Date</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='addDeviceInstallDate' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceInstallReference' style='padding-top:15px; display: none;'><strong>Installer Ref</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Installer reference..." id='addDeviceInstallReference' style='margin-top:3px; display: none;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceSupplierList' style='padding-top:15px;'><strong>Supplier</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='addDeviceSupplierList' name='addDeviceSupplierList' class='custom-select addDeviceSupplierList' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT defaultSupplier FROM tblGlobals LIMIT 1";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$DEFAULT_SUPPLIER = $row['defaultSupplier'];

$sql = "SELECT * FROM tblSupplier ORDER BY supplierName ASC";
$result = mysqli_query($link, $sql);
while ($SIMRow = mysqli_fetch_array($result)) {
    if ($SIMRow['ID'] == $DEFAULT_SUPPLIER) {
        echo "<option value = " . $SIMRow['ID'] . " selected>" . $SIMRow['supplierName'] . "</option>";
    } else {
        echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['supplierName'] . "</option>";
    }
}
?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class='col-md-2'>
                                <label class='control-label' for='addDeviceSupplierInvoice' style='padding-top:15px;'><strong>Order No</strong></label>
                            </div> -->
                            <!-- <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Order number..." id='addDeviceSupplierInvoice' style='margin-top:3px;'>
                                </div>
                            </div> -->
                        </div>
                        <div class='row'>
                        <!-- <div class='col-md-2'>
                                <label class='control-label' for='addDevicePurchaseDate' style='padding-top:15px;'><strong>Purchase Date</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='addDevicePurchaseDate' style='margin-top:3px;'>
                                </div>
                            </div> -->

                        </div>
                        <div class='row' style='margin-top: 15px;'></div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceNoteText' style='padding-top:16px;'><strong>Notes</strong></label>
                            </div>
                            <div class='col-md-0'>
                                <div class='input-group'>
                                    <textarea rows='3' cols='60' class='form-control' placeholder='Enter note text (max 512 characters)...' id='addDeviceNoteText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='addDeviceMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addDeviceID' style='display: none'></div>
                <div id='addDeviceCustomerID' style='display: none'></div>
                <button type="button" id='addNewDevice' onclick='addNewDevice()' class="btn btn-success">Allocate</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- EDIT DEVICE DIALOG -->
<div class="modal" id="modalEditDevice" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:99%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Device</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditDevice' class='getEditDevice form-block'>
                    <div class='form-group'>
                        <h6>Device Details</h6>
                        <div class='row'>
                            <div class='col-md-1'>
                                <label class='control-label' for='editDeviceDescription' style='padding-top:8px;'><strong>Model</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <select id='editDeviceDescription' name='editDeviceDescription' class='custom-select editDeviceDescription'>
                                        <?php
$sql = "SELECT * FROM tblDeviceDescription ORDER BY description ASC";
$result = mysqli_query($link, $sql);

while ($deviceRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $deviceRow['ID'] . ">" . $deviceRow['description'] . "</option>";
}
?>
                                    </select>

                                </div>
                            </div>
                            <div class='col-md-1'></div>
                            <div class='col-md-1'>
                                <label class='control-label' for='editDeviceSupplier' style='padding-top:15px;'><strong>Platform</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <select id='editDeviceSupplier' name='editDeviceSupplier' class='custom-select editDeviceSupplier' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT * FROM tblSupplier ORDER BY supplierName ASC";
$result = mysqli_query($link, $sql);
while ($SIMRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['supplierName'] . "</option>";
}
?>
                                    </select>

                                </div>
                            </div>

                            <div class='col-md-2 form-check-inline' style='margin-left:30px;'>
                                <label class='form-check-label' for='platformUpdated' style='padding-top:18px;'><strong>Platform is updated</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='platformUpdated' style='margin: 15px 30px;padding: 10px 10px;'>
                           </div>
                        </div>
                        <div class='row'>
                            <!-- TDH Number no longer required
                            This remains but is not displayed until the relevant Javascript / PHP has been amended -->
                            <div class='col-md-2' style='display:none'>
                                <label class='control-label' for='editTDHNumber' style='padding-top:9px;'><strong>TDH Number</strong></label>
                            </div>
                            <div class='col-md-4' style='display:none'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="TDH Number..." id='editTDHNumber' style='margin-top:3px;'>
                                </div>
                            </div>
                            <!-- See note above -->

                            <div class='col-md-1'>
                                <label class='control-label' for='editSerial' style='padding-top:10px;'><strong>Serial Number</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Serial Number..." id='editSerial' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-1'></div>
                            <div class='col-md-1'>
                                <label class='control-label' for='editIMEI' style='padding-top:11px;'><strong>IMEI</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control hasToolTip' maxlength='20' placeholder="IMEI..." id='editIMEI' style='margin-top:3px;' data-placement="auto" title="<em>IMEI should be 15 digits in length, otherwise leave empty.</em>">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                           <div class='col-md-1'>
                               <label class='control-label' for='editDRIDNumber' style='padding-top:11px;'><strong>DRID</strong></label>
                           </div>
                           <div class='col-md-3'>
                               <div class='input-group'>
                                   <input type='text' class='form-control' maxlength='50' placeholder="DRID..." id='editDRIDNumber' style='margin-top:3px;'>
                               </div>
                           </div>
                           <div class='col-md-1'></div>
                           <div class='col-md-1'>
                                <label class='control-label' for='editConfigFile' style='padding-top:14px;'><strong>Config file</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='512' placeholder="Config description (max 512 chars)..." id='editConfigFile' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2 form-check-inline' style='margin-left:30px;'>
                                <label class='form-check-label' for='configUpdated' style='padding-top:18px;'><strong>Config is updated</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='configUpdated' style='margin: 15px 43px;padding: 10px 10px;'>
                           </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                <label class='control-label' for='editDeviceStatus' style='padding-top:14px;'><strong>Device Status</strong></label>
                            </div>

                       </div>

                        <hr>
                        <h6>SIM Details</h6>


                        <div class='row'>
                            <div class='col-md-1'>
                                <label class='control-label' for='editSIMNumber' style='padding-top:12px;'><strong>SIM Serial</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="SIM Serial..." id='editSIMNumber' style='margin-top:3px;' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                            <div class='col-md-1'></div>
                            <div class='col-md-1'>
                                <label class='control-label' for='editSIMPhone' style='padding-top:12px;'><strong>SIM Phone</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='20' placeholder="SIM Phone..." id='editSIMPhone' style='margin-top:3px;' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                            <div class='col-md-2 form-check-inline' style='margin-left:30px;'>
                                <label class='form-check-label' id='labelVCOReference' for='vcoUpdated' style='padding-top: 12px;'><strong>VCO Reference:</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='vcoUpdated' style='margin: 10px 18px;padding: 10px 10px;'><strong>updated</strong>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                <label class='control-label' for='editSIMScheduleDate' style='padding-top:13px;'><strong>Scheduled Date for deactivation (if applicable)</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='date' class='form-control hasToolTip' id='editSIMScheduleDate' style='margin-top:18px;' data-placement="auto" title="<em>If empty, click the date field to set default of 31 days from today</em>">
                                </div>
                            </div>
                            <div class='col-md-1'></div>
                            <div class='col-md-1'>
                                <label class='control-label' for='editSIMSuspensionDate' style='padding-top:13px;'><strong>Date of Suspension (if applicable)</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='date' class='form-control hasToolTip' id='editSIMSuspensionDate' style='margin-top:18px;' data-placement="auto" title="<em>If empty, click the date field to set default of today's date</em>" >
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                <label class='control-label' for='editSIMStatus' style='padding-top:13px;'><strong>SIM Status</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <select id='editSIMStatus' name='editSIMStatus' class='custom-select editSIMStatus' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT * FROM tblSIMStatus ORDER BY SIMStatus ASC";
$result = mysqli_query($link, $sql);

while ($SIMRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['SIMStatus'] . "</option>";
}
?>
                                    </select>

                                </div>
                            </div>
                            <div class='col-md-1'></div>
                             <div class='col-md-1' style='display: none'>
                                <label class='control-label' for='editSIMDate' style='padding-top:13px;'><strong>SIM Deactivate</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group' style='display: none'>
                                    <input type='date' class='form-control hasToolTip' id='editSIMDate' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>

                            <h6>Install History</h6>
                        <div class='row'>
                             <div class='col-md-1'>
                                <label class='control-label' for='editOwnerID' style='padding-top:13px;'><strong>Allocated to</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <select id='editOwnerID' name='editOwnerID' class='custom-select editOwnerID' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT * FROM tblCustomer ORDER BY businessName ASC";
$result = mysqli_query($link, $sql);

// echo "<option value= '0' selected='selected'>DHINSTALL</option>";
while ($SIMRow = mysqli_fetch_array($result)) {
    echo "<option value = '" . $SIMRow['ID'] . "'>" . $SIMRow['businessName'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-1'></div>
                            <div class='col-md-1'>
                                <label class='control-label' for='editVRN' style='padding-top:13px;'><strong>Vehicle Reg</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="VRN..." id='editVRN' style='margin-top:3px;'>
                                    <div class='input-group-append'>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>

                        </div>
                        <div class='row'>

                            <div class='col-md-1'>
                                <label class='control-label' for='editDeviceStatus' style='padding-top:14px;'><strong>Current Status</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <select id='editDeviceStatus' name='editDeviceStatus' class='custom-select editDeviceStatus' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT * FROM tblDeviceStatus ORDER BY ID ASC";
$result = mysqli_query($link, $sql);
while ($SIMRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['status'] . "</option>";
}
?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class='row'>
                            <div class='col-md-1'>
                                <label class='control-label' for='editDeviceInstaller' style='padding-top:15px;'><strong>Installer</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <select id='editDeviceInstaller' name='editDeviceInstaller' class='custom-select editDeviceInstaller' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT * FROM tblInstaller ORDER BY installerName ASC";
$result = mysqli_query($link, $sql);
while ($SIMRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['installerName'] . "</option>";
}
?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                <label class='control-label' for='editDeviceInstallDate' style='padding-top:15px;'><strong>Original install Date</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='date' class='form-control hasToolTip' id='editDeviceInstallDate' style='margin-top:3px;' data-placement="auto" title="<em>If empty, click the date field to set default of today's date</em>">
                                </div>
                            </div>
                            <div class='col-md-1'></div>
                            <div class='col-md-1'>
                                <label class='control-label' for='editDeviceInstallReference' style='padding-top:15px; display: none;'><strong>Installer Ref</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Installer reference..." id='editDeviceInstallReference' style='margin-top:3px; display: none;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <!-- <div class='col-md-2'>
                                <label class='control-label' for='editDeviceSupplier' style='padding-top:15px;'><strong>Supplier</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='editDeviceSupplier' name='editDeviceSupplier' class='custom-select editDeviceSupplier' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT * FROM tblSupplier ORDER BY supplierName ASC";
$result = mysqli_query($link, $sql);
while ($SIMRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['supplierName'] . "</option>";
}
?>
                                    </select>

                                </div>
                            </div> -->
                            <!-- <div class='col-md-1'>
                                <label class='control-label' for='editDeviceSupplierInvoice' style='padding-top:15px;'><strong>Order No</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Order number..." id='editDeviceSupplierInvoice' style='margin-top:3px;'>
                                </div>
                            </div> -->
                        </div>
                        <div class='row'>
                        <!-- <div class='col-md-1'>
                                <label class='control-label' for='editDevicePurchaseDate' style='padding-top:15px;'><strong>Purchase Date</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='editDevicePurchaseDate' style='margin-top:3px;'>
                                </div>
                            </div> -->

                        </div>
                        <div class='row' style='margin-top:15px;'></div>
                        <div class='row'>
                            <div class='col-md-1'>
                                <label class='control-label' for='editDeviceNoteText' style='padding-top:16px;'><strong>Notes</strong></label>
                            </div>
                            <div class='col-md-10'>
                                <div class='input-group'>
                                    <textarea rows='3' cols='60' class='form-control' placeholder='Enter note text (max 1,024 characters)...' id='editDeviceNoteText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div id='editDeviceMessage'></div>
                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='hiddenDeviceID' style='display: none'></div>
                <div id='editDeviceID' style='display: none'></div>
                <div id='editDeviceCustomerID' style='display: none'></div>
                <button type="button" id='editCurrentDevice' onclick='editCurrentDevice()' class="btn btn-success">Update</button>
                <?php
if ($_SESSION['isAdmin'] == '1') {
    echo "<button type='button' onclick='deletePhysicalDevice()' id='deletePhysicalDevice' class='btn btn-danger'>Delete</button>";
}
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>

</div>

<!-- EDIT DEVICE NOTES DIALOG -->
<div class="modal" id="modalEditDeviceNotes" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:66%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Device Notes</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditDeviceNotes' class='getEditDeviceNotes form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='input-group'>
                                    <textarea rows='10' cols='40' class='form-control' placeholder='Enter note text (max 1,024 characters)...' id='editDeviceNotesText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div id='editDeviceNotesMessage'></div>
                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='hiddenDeviceNotesID' style='display: none'></div>
                <div id='editDeviceNotesID' style='display: none'></div>
                <div id='editDeviceNotesCustomerID' style='display: none'></div>
                <button type="button" id='editCurrentDeviceNotes' onclick='editCurrentDeviceNotes()' class="btn btn-success">Update</button>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>

</div>
<!-- ----------------------------------------END OF DEVICE DIALOGS---------------------------------------- -->
<div class="modal" id="modalEditVehicleNotes" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:66%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Vehicle Notes</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditVehicleNotes' class='getEditVehicleNotes form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='input-group'>
                                    <textarea rows='10' cols='40' class='form-control' placeholder='Enter note text (max 1,024 characters)...' id='editVehicleNotesText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div id='editVehicleNotesMessage'></div>
                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='hiddenVehicleNotesID' style='display: none'></div>
                <div id='editVehicleNotesID' style='display: none'></div>
                <div id='editVehicleCustomerID' style='display: none'></div>
                <button type="button" id='editCurrentVehicleNotes' onclick='editCurrentVehicleNotes()' class="btn btn-success">Update</button>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>

</div>




<!-- ---------------------------------------- BROKER DIALOGS ---------------------------------------------- -->
<!-- ADD BROKER DIALOG -->
<div class="modal" id="modalAddNewBroker" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Broker</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddBroker' class='getAddBroker form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='100' placeholder="Broker Name..." id='addBrokerName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='addBrokerAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='addBrokerAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='addBrokerAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='addBrokerAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='14' placeholder="Post code..." id='addBrokerAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='brokerMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addBrokerHide' style='display: none'></div>
                <div id='brokerEditNumber' style='display: none'></div>
                <button type="button" id='addBrokerUpdate' onclick='addNewBroker()' class="btn btn-success">Add</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT BROKER DIALOG -->
<div class="modal" id="modalEditBroker" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Broker</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditBroker' class='getEditBroker form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='100' placeholder="Broker Name..." id='editBrokerName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='editBrokerAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='editBrokerAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='editBrokerAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='editBrokerAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='14' placeholder="Post code..." id='editBrokerAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='editBrokerMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editBrokerHide' style='display: none'></div>
                <button type="button" id='editBrokerUpdate' onclick='updateEditBroker()' class="btn btn-success">Update</button> <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- BROKER CONTACT DIALOGS -->
<!-- ADD NEW BROKER CONTACT DIALOG -->
<div class="modal" id="modalAddNewBrokerContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New broker contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getNewBrokerContact' class='getNewBrokerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='brokerContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='brokerContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='brokerContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='brokerContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='brokerContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactDepartment' style='padding-top:8px;'><strong>Department</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='brokerContactDepartment' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='form-check-inline'>
                                <label class='form-check-label' for='brokerContactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='brokerContactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                                <label class='form-check-label' for='brokerContactHealthCheck' style='padding-top:18px;'><strong>Health Checks</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='brokerContactHealthCheck' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='brokerContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='updateBrokerContact' class="btn btn-success">Add Contact</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT BROKER CONTACT DIALOG -->
<div class="modal" id="modalEditBrokerContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit broker contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditBrokerContact' class='getEditBrokerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='editBrokerContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='editBrokerContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='editBrokerContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='editBrokerContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='editBrokerContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerContactDepartment' style='padding-top:8px;'><strong>Department</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter department..." id='editBrokerContactDepartment' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='form-check-inline'>
                                <label class='form-check-label' for='editBrokerContactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='editBrokerContactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                                <label class='form-check-label' for='editBrokerContactHealthCheck' style='padding-top:18px;'><strong>Health Checks</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='editBrokerContactHealthCheck' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='editBrokerContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editBrokerContactHide' style='display: none'></div>
                <button type="button" id='updateEditBrokerContact' class="btn btn-success">Update</button>
                <?php
if ($_SESSION['isAdmin'] == '1') {
    echo "<button type='button' onclick='deleteBrokerContact()' id='deleteBrokerContact' class='btn btn-danger'>Delete</button>";
}
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ----------------------------------------END OF BROKER DIALOGS---------------------------------------- -->





<!-- ---------------------------------------- INSURER DIALOGS ---------------------------------------------- -->
<!-- ADD INSURER DIALOG -->
<div class="modal" id="modalAddNewInsurer" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Insurer</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddInsurer' class='getAddInsurer form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInsurerName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='100' placeholder="Insurer Name..." id='addInsurerName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInsurerAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='addInsurerAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInsurerAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='addInsurerAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInsurerAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='addInsurerAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInsurerAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='addInsurerAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInsurerAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='14' placeholder="Post code..." id='addInsurerAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='insurerMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addInsurerHide' style='display: none'></div>
                <div id='addInsurerCaller' style='display: none'></div>
                <button type="button" id='addInsurerUpdate' onclick='addNewInsurer()' class="btn btn-success">Add</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT INSURER DIALOG -->
<div class="modal" id="modalEditInsurer" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Insurer</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditInsurer' class='getEditInsurer form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='100' placeholder="Insurer Name..." id='editInsurerName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='editInsurerAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='editInsurerAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='editInsurerAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='editInsurerAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='14' placeholder="Post code..." id='editInsurerAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='editInsurerMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editInsurerHide' style='display: none'></div>
                <button type="button" id='editInsurerUpdate' onclick='updateEditInsurer()' class="btn btn-success">Update</button> <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- INSURER CONTACT DIALOGS -->
<!-- ADD NEW INSURER CONTACT DIALOG -->
<div class="modal" id="modalAddNewInsurerContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New insurer contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getNewInsurerContact' class='getNewInsurerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='insurerContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='insurerContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='insurerContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='insurerContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='insurerContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactJobTitle' style='padding-top:8px;'><strong>Job Title</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='insurerContactJobTitle' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='form-check-inline'>
                                <label class='form-check-label' for='insurerContactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='insurerContactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                                <label class='form-check-label' for='insurerContactHealthCheck' style='padding-top:18px;'><strong>Health Checks</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='insurerContactHealthCheck' style='margin: 15px 50px;padding: 10px 10px;'>



                            </div>
                        </div>
                    </div>
                    <div id='insurerContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='insurerEditNumber' style='display: none'></div>
                <div id='contactEditNumber' style='display: none'></div>
                <div id='addInsurerContactCaller' style='display: none'></div>
                <button type="button" id='updateInsurerContact' class="btn btn-success">Add Contact</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT INSURER CONTACT DIALOG -->
<div class="modal" id="modalEditInsurerContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit insurer contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditInsurerContact' class='getEditInsurerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='editInsurerContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='editInsurerContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='editInsurerContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='editInsurerContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='editInsurerContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInsurerContactJobTitle' style='padding-top:8px;'><strong>Job Title</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='editInsurerContactJobTitle' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='form-check-inline'>
                                <label class='form-check-label' for='editInsurerContactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='editInsurerContactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                                <label class='form-check-label' for='editInsurerContactHealthCheck' style='padding-top:18px;'><strong>Health Checks</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='editInsurerContactHealthCheck' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='editInsurerContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editInsurerContactHide' style='display: none'></div>
                <button type="button" id='updateEditInsurerContact' class="btn btn-success">Update</button>
                <?php
if ($_SESSION['isAdmin'] == '1') {
    echo "<button type='button' onclick='deleteInsurerContact()' id='deleteInsurerContact' class='btn btn-danger'>Delete</button>";
}
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ----------------------------------------END OF INSURER DIALOGS---------------------------------------- -->


<!-- ---------------------------------------- INSTALLER DIALOGS -------------------------------------------- -->
<!-- EDIT INSTALLER CONTACT DIALOG -->
<div class="modal" id="modalEditInstallerContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit installer contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditInstallerContact' class='getEditInstallerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInstallerContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='editInstallerContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInstallerContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='editInstallerContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInstallerContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='editInstallerContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInstallerContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='editInstallerContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInstallerContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='editInstallerContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editInstallerContactJobTitle' style='padding-top:8px;'><strong>Department</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter department..." id='editInstallerContactJobTitle' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id='editInstallerContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editInstallerContactHide' style='display: none'></div>
                <button type="button" id='updateEditInstallerContact' class="btn btn-success">Update</button>
                <?php
if ($_SESSION['isAdmin'] == '1') {
    echo "<button type='button' onclick='deleteInstallerContact()' id='deleteInstallerContact' class='btn btn-danger'>Delete</button>";
}
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- ---------------------------------------- CUSTOMER DIALOGS ---------------------------------------------- -->
<!-- ADD NEW CUSTOMER CONTACT DIALOG -->
<div class="modal" id="modalAddNewContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New customer contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getNewCustomerContact' class='getNewCustomerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='contactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='contactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='contactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='contactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='contactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactJobTitle' style='padding-top:8px;'><strong>Job Title</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='contactJobTitle' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='form-check-inline'>
                                <label class='form-check-label' for='contactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='contactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                                <label class='form-check-label' for='contactHealthCheck' style='padding-top:18px;'><strong>Health Checks</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='contactHealthCheck' style='margin: 15px 50px;padding: 10px 10px;'>

                            </div>
                        </div>
                    </div>
                    <div id='contactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='updateCustomerContact' class="btn btn-success">Add Contact</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT CUSTOMER CONTACT DIALOG -->
<div class="modal" id="modalEditContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit customer contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditCustomerContact' class='getEditCustomerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='editContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='editContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='editContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='editContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='editContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactJobTitle' style='padding-top:8px;'><strong>Job Title</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='editContactJobTitle' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='form-check-inline'>
                                <label class='form-check-label' for='editContactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='editContactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                                <label class='form-check-label' for='editContactHealthCheck' style='padding-top:18px;'><strong>Health Checks</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='editContactHealthCheck' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='editContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='customerContactEditNumber' style='display: none'></div>
                <div id='contactCustomerEditNumber' style='display: none'></div>
                <button type="button" id='updateEditCustomerContact' onclick='updateCustomerContact()' class="btn btn-success">Update</button>
                <?php
if ($_SESSION['isAdmin'] == '1') {
    echo "<button type='button' onclick='deleteCustomerContact()' id='deleteCustomerContact' class='btn btn-danger'>Delete</button>";
}
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD NEW CUSTOMER -->
<div class="modal" id="modalAddNewCustomer" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add new customer</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='addNewCustomer' class='addNewCustomer form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='newCustomerName' style='width: 40%; padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Business name..." name='newCustomerName' id='newCustomerName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Address line 1..." name='customerAddress1' id='customerAddress1'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Address line 2..." name='customerAddress2' id='customerAddress2'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Town/City..." name='customerAddress3' id='customerAddress3'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="County..." name='customerAddress4' id='customerAddress4'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Post code..." name='customerAddress5' id='customerAddress5'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerPhone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Telephone..." name='customerPhone' id='customerPhone' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerEmail' style='padding-top:8px;'><strong>Email</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Email address..." name='customerEmail' id='customerEmail'>
                                </div>
                            </div>
                        </div>
                        <!-- <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerRegNo' style='padding-top:8px;'><strong>Registered No.</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="Company Reg No..." name='customerRegNo' id='customerRegNo' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerVATNo' style='padding-top:8px;'><strong>VAT Reg No.</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='text' placeholder="VAT Registration No..." name='customerVATNo' id='customerVATNo' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                        </div> -->
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerInsurer' style='padding-top:8px;'><strong>Insurer</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select style='font-size: 80%' id='getInsurer' name='getInsurer' class='custom-select getInsurer'>
                                        <?php
$sql = "SELECT * FROM tblInsurer ORDER BY insurerName ASC";
$result = mysqli_query($link, $sql);

while ($insurerRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $insurerRow['ID'] . ">" . $insurerRow['insurerName'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='customerBroker' style='padding-top:8px;'><strong>Broker</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select style='font-size: 80%' id='getBroker' name='getBroker' class='custom-select getBroker'>
                                        <?php
$sql = "SELECT * FROM tblBroker ORDER BY brokerName ASC";
$result = mysqli_query($link, $sql);

while ($brokerRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $brokerRow['ID'] . ">" . $brokerRow['brokerName'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='customerMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='newCustomerIDNumber' style='display: none'></div>
                <button type="button" id='addNewCustomerButton' onclick='addCustomer()' class="btn btn-success">Add Customer</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- CUSTOMER NOTE DIALOGS -->
<!-- ADD NEW CUSTOMER NOTE -->
<div class="modal" id="modalAddNewNote" data-backdrop='static'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New customer note</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getNewCustomerNote' class='getNewCustomerNote form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-sm-4 col-xl-3'>
                                <label class='control-label inline' for='noteDate' style='width: 40%; padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-sm-8 col-xl-9'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='datetime-local' name='noteDate' id='noteDate' min='<?php echo date("Y-m-d\TH:i"); ?>' value='<?php echo date("Y-m-d\TH:i"); ?>'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-4 col-xl-3'>
                                <label class='control-label inline' for='noteText' style='padding-top:8px;'><strong>Note Text</strong></label>
                            </div>
                            <div class='col-sm-8 col-xl-9'>
                                <div class='input-group'>
                                    <textarea rows='24' cols='64' class='form-control' placeholder='Enter note text (max 2,048 characters)...' id='noteText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='row' style='margin-top: 20px;'>
                            <div class='col-sm-4 col-xl-3'>
                                <label class='control-label inline' for='isImportantNote' style='font-size: 75%; padding-top:8px;'><strong>Mark as important</strong></label>
                            </div>
                            <div class='col-2'>
                                <input type='checkbox' class='form-check-input' value='checked' id='isImportantNote' style='margin: 5px 0;padding: 10px 10px;'>
                            </div>
                            <div class='col-sm-4 col-xl-3'>
                                <label class='control-label inline' for='createAlert' style='font-size: 75%; padding-top:8px;'><strong>Create an alert</strong></label>
                            </div>
                            <div class='col-2'>
                                <input type='checkbox' class='form-check-input' value='checked' id='createAlert' style='margin: 5px 0;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='noteMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='updateCustomerNote' class="btn btn-success">Add Note</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT CUSTOMER NOTE -->
<div class="modal" id="modalEditCustomerNote" data-backdrop='static'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit customer note</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='editCustomerNote' class='editCustomerNote form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-3'>
                                <label class='control-label inline' for='noteEditDate' style='width: 40%; padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-9'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='datetime' name='noteEditDate' id='noteEditDate' readonly='readonly' min='<?php echo date("Y-m-d\TH:i"); ?>' value='<?php echo date("Y-m-d\TH:i"); ?>'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-3'>
                                <label class='control-label inline' for='noteEditText' style='padding-top:8px;'><strong>Note Text</strong></label>
                            </div>
                            <div class='col-9'>
                                <div class='input-group'>
                                    <textarea rows='24' cols='60' class='form-control' placeholder='Enter note text (max 2,048 characters)...' id='noteEditText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='row' style='margin-top: 20px'>
                            <div class='col-3'>
                                <label class='control-label inline' for='noteUserName' style='font-size: 75%; padding-top:8px;'><strong>Original note by</strong></label>
                            </div>
                            <div class='col-9'>
                                <p id='noteUserName'></p>
                            </div>
                        </div>
                        <div class='row' style='margin-top: 20px;'>
                            <div class='col-4'>
                                <label class='control-label inline' for='isImportantEditNote' style='font-size: 75%; padding-top:8px;'><strong>Mark as important</strong></label>
                            </div>
                            <div class='col-2'>
                                <input type='checkbox' class='form-check-input' value='checked' id='isImportantEditNote' style='margin: 5px 0;padding: 10px 10px;'>
                            </div>
                            <div class='col-4'>
                                <label class='control-label inline' for='createEditAlert' style='font-size: 75%; padding-top:8px;'><strong>Create an alert</strong></label>
                            </div>
                            <div class='col-2'>
                                <input type='checkbox' class='form-check-input' value='checked' id='createEditAlert' style='margin: 5px 0;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='noteEditMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='customerEditNumber' style='display: none'></div>
                <div id='noteEditNumber' style='display: none'></div>
                <div id='noteEditUser' style='display: none'></div>
                <button type="button" id='updateCustomerNoteEdit' onclick='updateNote()' class="btn btn-success">Update Note</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ----------------------------------------END OF CUSTOMER DIALOGS---------------------------------------- -->



<!-- ---------------------------------------- FOOTAGE DIALOGS ---------------------------------------------- -->
<!-- ADD FOOTAGE REQUEST -->
<div class="modal" id="modalAddNewFootage" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:75%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New Footage Request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddNewFootage' class='getAddNewFootage form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <h6><strong>Incident</strong></h6>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageIncidentDate' style='padding-top:9px;'>Incident Date</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='footageIncidentDate' name='footageIncidentDate'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='footageVRNList' style='padding-top:8px;'>Vehicle Reg Number</label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group' id='footageVRNList'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageCustomerID' style='margin-top: 5px;padding-top:9px;'>Customer</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' readonly='readonly' name='footageCustomerID' id='footageCustomerID' style='margin-top:5px;' value=''>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='footageClaimReference' style='padding-top:8px;margin-top: 5px;'>Claim reference</label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' id='footageClaimReference' name='footageClaimReference' style='margin-top:5px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <h6><strong>Footage</strong></h6>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageRequestDate' style='padding-top:8px;'>Request Date and Time</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='datetime-local' class='form-control' name='footageRequestDate' id='footageRequestDate'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageRequestNotes' style='padding-top:10px;'>Notes</label>
                            </div>
                            <div class='col-md-9'>
                                <textarea rows='3' cols='60' class='form-control' placeholder='Enter note text (max 512 characters)...' name='footageRequestNotes' id='footageRequestNotes' style='margin-top:3px;'></textarea>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageRequestFile' style='margin-top:7px;padding-top:10px;'>Footage File(s)</label>
                            </div>
                            <div class='col-md-2'>
                                <span class="btn btn-primary btn-sm btn-file-input" style='margin-top: 6px'>
                                    Select File(s) <input type="file" id='footageFileName' onclick='fileExplorer("Add")' accept='.mdt, .MDT, .mp4, .MP4, .avi, .AVI, .pdf, .PDF'>
                                </span>

                                    <!-- <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" style='margin-top: 6px;' id="footageMoreInfo" type="">More Info</button>
                                    </div> -->
                                </div>


                            <div class='col-md-7'>
                                <div class="input-group mb-3">
                                    <div id='footageFileTable' style='margin-top: 6px; width: 100%'>
                                       <table id = 'footageFileTableBody' class='table table-sm'>
                                            <thead>
                                                <tr>
                                                    <th>File Name</th>
                                                    <th style='width:5%'>Info</th>
                                                    <th style='width:5%'>Remove</th></tr>
                                            </thead>
                                            <tbody id = 'footageFileTableBodyBlock'>

                                            </tbody>
                                       </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                        <h6><strong>Recipients</strong></h6>
                            <div class='col-md-12'>
                                <div id='footageRecipientsList' class='input-group'>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                        <h6><strong>Response</strong></h6>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageResponseDate' style='padding-top:13px;'>Response Date</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='datetime-local' class='form-control' id='footageResponseDate' name='footageResponseDate' style='margin-top:3px;text-align: left' value=''>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='footageTDHEmployee' style='padding-top:13px;'>TDH Allocated</label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                   <select id='footageTDHEmployee' name='footageTDHEmployee' class='custom-select footageTDHEmployee' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT tblUserRecord.firstName, tblUserRecord.lastName, tblUsers.userID, tblUsers.email, tblUsers.userName FROM tblUserRecord INNER JOIN tblUsers ON tblUserRecord.userID = tblUsers.userID ORDER BY tblUserRecord.lastName ASC";
$result = mysqli_query($link, $sql);

while ($userRow = mysqli_fetch_array($result)) {
    $fullName = $userRow['firstName'] . ' ' . $userRow['lastName'];
    if (trim($fullName) == '') {
        $fullName = $userRow['userName'];
        if ($fullName == '') {
            $fullName = $userRow['email'];
        }
    }
    if ($userRow['userName'] == $_SESSION['userName']) {
        echo "<option value = " . $userRow['userID'] . " selected>" . $fullName . "</option>";
    } else {
        echo "<option value = " . $userRow['userID'] . ">" . $fullName . "</option>";
    }
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageResponseNotes' style='margin-top: 4px; padding-top:10px;'>Response Notes</label>
                            </div>
                            <div class='col-md-9'>
                                <textarea rows='3' cols='60' class='form-control' placeholder='Enter note text (max 512 characters)...' name='footageResponseNotes' id='footageResponseNotes' style='margin-top:8px;'></textarea>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageCurrentStatus' style='margin-top: 7px; padding-top:10px;'>Current Status</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group' id='footageCurrentStatusList' style='margin-top: 9px;'>
                                    <select id='footageCurrentStatus' name='footageCurrentStatus' class='custom-select getCurrentStatus'>
                                        <?php
$sql = "SELECT * FROM tblFootageStatus ORDER BY description ASC";
$result = mysqli_query($link, $sql);

while ($statusRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $statusRow['ID'] . ">" . $statusRow['description'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id='addFootageMessage' style='margin: 5px;'></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">

                <div id='addFootageID' style='display: none'></div>
                <div id='addFootageCustomerID' style='display: none'></div>
                <button type="button" id='addNewFootage' onclick='addNewFootage()' class="btn btn-success">Add Request</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT FOOTAGE REQUEST -->
<div class="modal" id="modalEditFootage" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:75%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Footage Request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditFootage' class='getEditFootage form-block'>
                <div class='form-group'>
                    <div class='row'>
                        <h6><strong>Incident</strong></h6>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageEditIncidentDate' style='padding-top:9px;'>Incident Date</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='datetime-local' class='form-control' id='footageEditIncidentDate' name='footageEditIncidentDate'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='footageEditVRNList' style='padding-top:8px;'>Vehicle Reg Number</label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group' id='footageEditVRNList'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageEditCustomerID' style='margin-top: 5px;padding-top:9px;'>Customer</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' readonly='readonly' name='footageEditCustomerID' id='footageEditCustomerID' style='margin-top:5px;' value=''>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='footageEditClaimReference' style='padding-top:8px;margin-top: 5px;'>Claim reference</label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' id='footageEditClaimReference' name='footageEditClaimReference' style='margin-top:5px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <h6><strong>Footage</strong></h6>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageEditRequestDate' style='padding-top:8px;'>Request Date and Time</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='datetime-local' class='form-control' name='footageEditRequestDate' id='footageEditRequestDate'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageEditRequestNotes' style='padding-top:10px;'>Notes</label>
                            </div>
                            <div class='col-md-9'>
                                <textarea rows='3' cols='60' class='form-control' placeholder='Enter note text (max 512 characters)...' name='footageEditRequestNotes' id='footageEditRequestNotes' style='margin-top:3px;'></textarea>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageRequestFile' style='margin-top:7px;padding-top:10px;'>Footage File(s)</label>
                            </div>
                            <div class='col-md-2'>
                                <div class="input-group mb-3">
                                <span class="btn btn-primary btn-sm btn-file-input" style='margin-top: 6px'>
                                    Add File(s) <input type="file" id='footageEditFileName' onclick='fileExplorer("Edit")' accept='.mdt, .MDT, .mp4, .MP4, .avi, .AVI, .pdf, .PDF'>
                                </span>
                                    <!-- <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" style='margin-top: 6px;' id="footageMoreInfo" type="">More Info</button>
                                    </div>     -->
                                </div>
                            </div>
                            <div class='col-md-7'>
                                <div class="input-group mb-3">
                                    <div id='footageEditFileTable' style='margin-top: 6px; width: 100%'>
                                       <table id = 'footageEditFileTableBody' class='table table-sm'>
                                            <thead>
                                                <tr>
                                                    <th>File Name</th>
                                                    <th style='width:5%'>Info</th>
                                                    <th style='width:5%'>Remove</th></tr>
                                            </thead>
                                            <tbody id = 'footageEditFileTableBodyBlock'>

                                            </tbody>
                                       </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                        <h6><strong>Recipients</strong></h6>
                            <div class='col-md-12'>
                                <div id='footageEditRecipientsList' class='input-group'>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                        <h6><strong>Response</strong></h6>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageEditResponseDate' style='padding-top:13px;'>Response Date</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='datetime-local' class='form-control' id='footageEditResponseDate' name='footageEditResponseDate' style='margin-top:3px;text-align: left' value=''>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='footageEditTDHEmployee' style='padding-top:13px;'>TDH Allocated</label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                   <select id='footageEditTDHEmployee' name='footageEditTDHEmployee' class='custom-select footageEditTDHEmployee' style='margin-top:3px;'>
                                        <?php
$sql = "SELECT tblUserRecord.firstName, tblUserRecord.lastName, tblUsers.userID, tblUsers.email, tblUsers.userName, tblUsers.activation FROM tblUserRecord INNER JOIN tblUsers ON tblUserRecord.userID = tblUsers.userID ORDER BY tblUserRecord.lastName ASC";
$result = mysqli_query($link, $sql);

while ($userRow = mysqli_fetch_array($result)) {
    if ($userRow['activation'] == 'activated') {
        $fullName = $userRow['firstName'] . ' ' . $userRow['lastName'];
        if (trim($fullName) == '') {
            $fullName = $userRow['userName'];
            if ($fullName == '') {
                $fullName = $userRow['email'];
            }
        }
        echo "<option value = " . $userRow['userID'] . ">" . $fullName . "</option>";
    }
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageEditResponseNotes' style='margin-top: 4px; padding-top:10px;'>Response Notes</label>
                            </div>
                            <div class='col-md-9'>
                                <textarea rows='3' cols='60' class='form-control' placeholder='Enter note text (max 512 characters)...' name='footageEditResponseNotes' id='footageEditResponseNotes' style='margin-top:8px;'></textarea>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='control-label' for='footageEditCurrentStatus' style='margin-top: 7px; padding-top:10px;'>Current Status</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group' id='footageEditCurrentStatus' style='margin-top: 9px;'>
                                    <select id='footageEditCurrentStatusList' name='footageEditCurrentStatusList' class='custom-select getEditCurrentStatus'>
                                        <?php
$sql = "SELECT * FROM tblFootageStatus ORDER BY description ASC";
$result = mysqli_query($link, $sql);

while ($statusRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $statusRow['ID'] . ">" . $statusRow['description'] . "</option>";
}
?>
                                     </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id='editFootageMessage' style='margin: 5px;'></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">

                <div id='hiddenFootageID' style='display: none'></div>
                <div id='editFootageOwnerID' style='display: none'></div>
                <button type="button" id='addEditFootage' onclick='editCurrentFootage()' class="btn btn-success">Update</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ----------------------------------------END OF FOOTAGE DIALOGS---------------------------------------- -->





<!-- ---------------------------------------- VEHICLE DIALOGS ---------------------------------------------- -->
<!-- ADD VEHICLE DIALOG -->
<div class="modal" id="modalAddVehicle" role="dialog" data-backdrop="static">
    <div class="modal-dialog" style='max-width:45%'>
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddVehicle' class='getAddVehicle form-block'>
                    <div class='row'>
                        <div class='col-md-5 col-lg-4'>
                            <label class='control-label' for='addVehicleRegNumber' style='padding-top:9px;'>Registration Number</label>
                        </div>
                        <div class='col-md-7 col-lg-6'>
                            <div class='input-group'>
                                <input type='text' class='form-control' maxlength='14' placeholder="VRN..." id='addVehicleRegNumber' style='margin-top:1px;'>
                                <!-- <button type='button' class='btn btn-sm btn-info' id='findVehicleRegNumber'>Find</button> -->
                            </div>
                        </div>
                    <!-- <div class='col-md-5 col-lg-4'></div>
                            <div class='col-md-7 vol-lg-6'>
                                <div class="progress" id='lookUpProgress' style='width:85%; height: 15px; visibility: hidden;'>
                                    <div class="progress-bar progress-bar-animated progress-bar-striped bg-info" style='width:100%' role="progressbar">searching...</div>
                                </div>
                            </div>
                        </div> -->

                  </div>
                <hr/>
                <div class='row'>
                    <div class='col-md-5 col-lg-4'>
                        <label class='control-label'>Camera is required?</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input' id='vehicleCameraYes' name='cameraRequired' checked>
                            <label class='form-check-label' for='vehicleCameraYes' style='margin-right: 60px'>Yes</label>
                        </div>
                        <div class='form-check-inline'>
                        <input type='radio' class='form-check-input' id='vehicleCameraNo' name='cameraRequired'>
                            <label class='form-check-label' for='vehicleCameraNo'>No</label>
                        </div>
                    </div>
                </div>

                <div class='row' style='margin-top:15px'>
                    <div class='col-md-5 col-lg-4'>
                        <label class='control-label'>Current Status</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input' id='vehicleStatusInstalled' name='vehicleStatus' checked>
                            <label class='form-check-label' for='vehicleStatusInstalled' style='margin-right: 25px'>Installed</label>
                        </div>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input' id='vehicleStatusPending' name='vehicleStatus'>
                            <label class='form-check-label' for='vehicleStatusPending'>Pending</label>
                        </div>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input' id='vehicleStatusNotApplicable' name='vehicleStatus'>
                            <label class='form-check-label' for='vehicleStatusNotApplicable'>N/A</label>
                        </div>
                    </div>
                </div>

                <div class='row' style='margin-top:15px'>
                    <div class='col-md-5 col-lg-4'>
                        <label id='vehicleInstallDateLabel' for='vehicleInstalldate' class='control-label' style='padding-top:9px;'>Installation Date</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='input-group' style='width:75%'>
                            <input type='date' class='form-control' id='vehicleInstalldate' style='margin-top:3px;'>
                        </div>
                    </div>
                </div>
                <hr>
                <h6><strong>Other Kit</strong></h6>
                <div class='row'>
                    <div class='col-md-5 col-lg-4' style='font-size:125%'>
                        <label class='control-label' style='padding-top:9px;'><strong>Description</strong></label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <label class='control-label' style='padding-top:9px;'><strong>Install Date (if applicable)</strong></label>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-5 col-lg-4'>
                    <label class='control-label' style='padding-top:9px;'>Left Turn Audible Alarm</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='input-group' style='width:75%'>
                            <input type='date' class='form-control' id='LTAlarmInstalldate' style='margin-top:3px;'>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-5 col-lg-4'>
                    <label class='control-label' style='padding-top:9px;'>Side Scan Sensor System</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='input-group' style='width:75%'>
                            <input type='date' class='form-control' id='SideScanInstalldate' style='margin-top:3px;'>
                        </div>
                    </div>
                </div>

                <hr>
                <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addVehicleNotes' style='padding-top:8px;'><strong>Vehicle Notes</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                       <textarea rows='8' cols='100' class='form-control' placeholder='Enter note text (max 1,024 characters)...' name='addVehicleNotes' id='addVehicleNotes' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                <hr>
                <div class='row' style='display: none'>
                  <div class='col-md-5 col-lg-4'>
                      <label class='control-label' for='addVehicleAllocateTo' style='padding-top:9px;'><strong>Allocated to</strong></label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' readonly='readonly' id='addVehicleAllocateTo' style='margin-top:1px;'
                            <?php $sql = "SELECT businessName FROM tblCustomer WHERE ID='" . $_SESSION['currentCustomer'] . "'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
echo " value= '" . $row['businessName'] . "'>";
?>
                      </div>
                  </div>
                </div>
            </form>
          </div>
            <div class="modal-footer">
              <div id='hiddenVehicleID' style='display: none'></div>
              <div id='addVehicleErrorBox'></div>
                <button type="button" class="btn btn-success" onclick='addNewVehicle()'>Add</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT VEHICLE DIALOG -->
<div class="modal" id="modalVehicleShow" role="dialog" data-backdrop="static">
    <div class="modal-dialog" style='max-width:45%'>
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style='font-size: 75%'>
              <form method='POST' id='getEditVehicle' class='getEditVehicle form-block'>
                <div class='row'>
                  <div class='col-md-5 col-lg-4'>
                      <label class='control-label' for='editVehicleRegNumber' style='padding-top:9px;'>Registration Number</label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' maxlength='14' placeholder="VRN..." id='editVehicleRegNumber' style='margin-top:1px;'>
                      </div>
                  </div>

                </div>
                <hr/>
                <div class='row'>
                <div class='col-md-5 col-lg-4'>
                        <label class='control-label'>Camera is required?</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input' id='editVehicleCameraYes' name='cameraRequired'>
                            <label class='form-check-label' for='editVehicleCameraYes' style='margin-right: 60px'>Yes</label>
                        </div>
                        <div class='form-check-inline'>
                        <input type='radio' class='form-check-input' id='editVehicleCameraNo' name='cameraRequired'>
                            <label class='form-check-label' for='editVehicleCameraNo'>No</label>
                        </div>
                    </div>
                </div>

                <div class='row' style='margin-top:15px'>
                    <div class='col-md-5 col-lg-4'>
                        <label class='control-label'>Current Status</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input' id='editVehicleStatusInstalled' name='vehicleStatus'>
                            <label class='form-check-label' for='editVehicleStatusInstalled' style='margin-right: 25px'>Installed</label>
                        </div>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input' id='editVehicleStatusPending' name='vehicleStatus'>
                            <label class='form-check-label' for='editVehicleStatusPending'>Pending</label>
                        </div>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input' id='editVehicleStatusNotApplicable' name='vehicleStatus'>
                            <label class='form-check-label' for='editVehicleStatusNotApplicable'>N/A</label>
                        </div>
                    </div>
                </div>

                <div class='row' style='margin-top:15px'>
                <div class='col-md-5 col-lg-4'>
                        <label id='vehicleEditInstallDateLabel' for='editVehicleInstalldate' class='control-label' style='padding-top:9px;'>Installation Date</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='input-group' style='width:75%'>
                            <input type='date' class='form-control' id='editVehicleInstalldate' style='margin-top:3px;'>
                        </div>
                    </div>
                </div>
                <hr/>

                <h6><strong>Other Kit</strong></h6>
                <div class='row'>
                    <div class='col-md-5 col-lg-4' style='font-size:125%'>
                        <label class='control-label' style='padding-top:9px;'><strong>Description</strong></label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <label class='control-label' style='padding-top:9px;'><strong>Install Date (if applicable)</strong></label>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-5 col-lg-4'>
                    <label class='control-label' id='labelEditLeftTurn' style='padding-top:9px;'>Left Turn Audible Alarm</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='input-group' style='width:75%'>
                            <input type='date' class='form-control' id='editLTAlarmDate' style='margin-top:3px;'>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-5 col-lg-4'>
                    <label class='control-label' id='labelEditSideScan' style='padding-top:9px;'>Side Scan Sensor System</label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='input-group' style='width:75%'>
                            <input type='date' class='form-control' placeholder="Install/upcoming install date..." id='editSideScanDate' style='margin-top:3px;'>
                        </div>
                    </div>
                </div>

                <hr/>
                <div class='row'>
                    <div class='col-4'>
                        <label class='control-label' for='editVehicleNotes' style='padding-top:8px;'><strong>Vehicle Notes</strong></label>
                    </div>
                    <div class='col-8'>
                        <div class='input-group'>
                            <textarea rows='8' cols='100' class='form-control' placeholder='Enter note text (max 1,024 characters)...' name='editVehicleNotes' id='editVehicleNotes' style='margin-top:3px;'></textarea>
                        </div>
                    </div>
                </div>
                <hr />
                <div class='row'>
                  <div class='col-md-5 col-lg-4'>
                      <label class='control-label' for='vehicleAllocateTo' style='padding-top:9px;'><strong>Allocated to</strong></label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' readonly='readonly' id='vehicleAllocateTo' style='margin-top:1px;'>
                      </div>
                  </div>
                </div>
            </form>
          </div>
            <div class="modal-footer">
              <div id='hiddenEditVehicleID' style='display: none'></div>
              <div id='editVehicleErrorBox'></div>
                <button type="button" class="btn btn-success"  onclick='editCurrentVehicle()'>Update</button>
                <?php
if ($_SESSION['isAdmin'] == '1') {
    echo "<button type='button' onclick='deleteVehicle()' id='deleteVehicle' class='btn btn-danger'>Delete</button>";
}
?>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--
---------------------------------------- END OF VEHICLE DIALOGS ----------------------------------------------
---------------------------------------- JOB REQUEST DIALOGS -------------------------------------------------
-->
<!-- ADD JOB REQUEST DIALOG -->
<div class="modal" id="modalAddNewJobRequest" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:50%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add New Job</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" style='font-size: 75%'>
                <h6><strong>Job Details</strong></h6>
                <form method='POST' id='getAddJob' class='getAddJob form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='jobCustomerName' style='padding-top:8px;'>Customer</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='selectCustomerName'>
                                    <select id='jobCustomerName' name='jobCustomerName' class='custom-select'>
                                        <option value = '0' disabled selected>Select customer from list</option>
                                        <?php
$sql = 'SELECT ID, businessName FROM tblCustomer';
$result = mysqli_query($link, $sql);

while ($customerRow = mysqli_fetch_array($result)) {
    if ($customerRow['businessName'] != "DHD" && $customerRow['businessName'] != "DHINSTALL") {
        echo "<option value = " . $customerRow['ID'] . ">" . $customerRow['businessName'] . "</option>";
    }
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='jobJobType' style='padding: 8px 25px;'>Job Type</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='addJobType'>
                                    <select id='jobJobType' name='jobJobType' class='custom-select'>
                                        <option value='0' disabled selected>Select job type</option>
                                        <?php
$sql = "SELECT * FROM tblJobType";
$result = mysqli_query($link, $sql);
while ($jobRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $jobRow['ID'] . ">" . $jobRow['description'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='jobCameraType' style='padding-top:8px;'>Device Model</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='addJobCameraType'>
                                    <select id='jobCameraType' name='jobCameraType' class='custom-select'>
                                        <option value='0' disabled selected>Select camera type</option>
                                        <?php
$sql = "SELECT * FROM tblDeviceDescription";
$result = mysqli_query($link, $sql);
while ($deviceRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $deviceRow['ID'] . ">" . $deviceRow['description'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='jobOtherKit' style='padding: 8px 25px;'>Other Kit</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='addJobOtherKit'>
                                    <div class="multiselect">
                                        <div class="selectBox" onclick="showCheckboxes()">
                                            <select class='custom-select'>
                                                <option>Select other kit options</option>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxes">
                                            <label for="LT">
                                            <input type="checkbox" id="LT" name="LT" /> Left Turn Audible Alarm </label>
                                            <label for="SS">
                                            <input type="checkbox" id="SS" name="SS" /> Side Scan Sensor System </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class='row'>
                            <!-- <div class='col-2'>
                                <label class='control-label' for='jobPriority' style='padding-top: 8px;'>Priority</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='jobJobPriority'>
                                    <select id='jobPriority' name='jobPriority' class='custom-select'>
                                        <option value = '1'>Standard</option>
                                        <option value = '2'>Urgent</option>
                                    </select>
                                </div>
                            </div>

                            <div class='col-2'>
                                <label class='control-label' for='jobAttachments' style='padding: 8px 25px;'>Attachments</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                     <input type='date' class='form-control' id='jobAttachments'>
                                </div>
                            </div> -->

                            <div class='col-2'>
                                <label class='control-label' for='customerJobRate' style='padding-top: 8px;'>Customer Job Rate</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='number' class='form-control' id='customerJobRate' name='customerJobRate' min ='0' step='0.01'>
                                </div>
                            </div>

                            <div class='col-2'>
                                <label class='control-label' for='jobRate' style='padding: 0 25px;'>Engineer Job Rate</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='number' class='form-control' id='jobRate' name='jobRate' min ='0' step='0.01'>
                                    <input type='checkbox' style='margin: 15px' id='jobRateDefault' checked=checked><p style='margin-top: 13px; margin-left:-12px;'>default</p>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='jobNotes' style='padding-top:8px;'>Notes</label>
                            </div>
                            <div class='col-10'>
                                <div class='input-group'>
                                       <textarea rows='4' cols='100' class='form-control' placeholder='Enter note text (max 1,024 characters)...' name='jobNotes' id='jobNotes' style='margin-top:3px; margin-bottom: 8px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                        <div class='col-2'>
                                <label class='control-label' for='jobQuantity' style='padding-top: 8px;'>Quantity</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='number' class='form-control' id='jobQuantity' name='jobQuantity' min='1' max='50' value='1'>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <h6><strong>Booking Details</strong></h6>

                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='jobContactName' style='padding-top:10px;'>Contact Name</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' id='jobContactName' name='jobContactName' placeholder='contact name...'>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='bookingEquipmentWith' style='padding:10px 25px;'>Kit With</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='bookingEquipmentWith'>
                                    <select id='bookingLocation' name='bookingLocation' class='custom-select'>
                                        <option value = "0" disabled selected>Kit Location</option>
                                        <option value = "1">UK Mobile Installations Ltd</option>
                                        <option value = "2">Engineer</option>
                                        <option value = "3">Customer</option>
                                        <option value = "4">Not required</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='jobContactEmail' style='padding-top:10px;'>Contact Email</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' id='jobContactEmail' name='jobContactEmail' placeholder='contact email...'>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='engineerAssigned' style='padding:10px 25px;'>Engineer Assigned</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='bookingEngineerAssigned'>
                                    <select id='engineerAssigned' name='engineerAssigned' class='custom-select'>
                                        <option value='0' disabled selected>Select engineer</option>
                                        <?php
$sql = "SELECT userID, userName, activation, isInstaller, isEngineer FROM tblUsers WHERE activation='activated' AND isEngineer=1";
$result = mysqli_query($link, $sql);
while ($engineerRow = mysqli_fetch_array($result)) {
    echo "<option value = '" . $engineerRow['userID'] . "'>" . $engineerRow['userName'] . "</option>";
}
?>
                                        <!-- <option value='9999' class='otherOptionSelection'>Unregistered Engineer</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='jobContactPhone' style='padding-top:10px;'>Contact Telephone</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' id='jobContactPhone' name='jobContactPhone' placeholder='contact telephone...'>                                    </div>
                                </div>
                            <div class='col-2' style='display:inline-flex'>
                                <label class='control-label' for='jobDateBooked' style='padding:10px 25px;'>Date/Time Booked For</label>
                            </div>

                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='datetime-local' class='form-control' name = 'jobDateBooked' id='jobDateBooked'>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='jobInstallAddress'  style='padding-top: 8px;'>Install Address</label>
                            </div>
                            <div class='col-10'>
                                <div class='input-group'>
                                    <textarea rows='3' cols='100' class='form-control' placeholder='Enter Installation Address' name='jobInstallAddress' id='jobInstallAddress' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>

                        <div class='row' style='padding-top: 8px;'>
                            <div class='col-4'>
                                <label class='control-label' style='padding-top:8px;'><h6><strong>Vehicle Details</strong></h6></label>
                            </div>
                            <div class='col-4'>
                               <label class='control-label' style='padding-top:8px;'><strong>Old VRM (if applicable)</strong></label>
                            </div>
                            <div class='col-4'>
                               <label class='control-label' style='padding-top:8px;'><strong>New/Current VRM</strong></label>
                            </div>

                        </div>
                        <div class='row' id='VRNListForJob'>
                            <div class='col-4'>
                                <label class='control-label' for='addJobTypeVRN' style='padding-top:8px;'>Job No. 1</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <select name='addJobTypeOldVRN' class='custom-select addJobTypeOldVRN'>
                                        <option value="0" disabled selected>select VRN</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <select id='addJobTypeVRN' name='addJobTypeVRN' class='custom-select addJobTypeVRN'>
                                        <option value="0" disabled selected>select VRN</option>
                                    </select>
                                    <div class='input-group-append'>
                                        <span class='input-group-btn btn btn-outline-success btn-sm disabled addVRNButton' style='padding:7px;'><b>New</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                <div id='jobRequestMessage'></div>
                <div id='jobVRNErrorCount' style='visibility: none'></div>
            </div>


            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addJobHide' style='display: none'></div>
                <div id='jobCustomerHide'></div>
                <div class='mr-auto' id='jobStatus'>
                    <h6>STATUS: <span style='color: #FFF035;'>NEW JOB SETUP</span></h6>
                </div>
                <button type="button" id='addJobUpdate' onclick='addNewJob()' class="btn btn-success">Add</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

<!-- EDIT JOB REQUEST DIALOG -->
<div class="modal" id="modalEditNewJobRequest" data-backdrop='static' >
    <div class="modal-dialog" style='max-width:50%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Outstanding Job</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" style='font-size: 75%'>
                <h6><strong>Job Details</strong></h6>
                <form method='POST' id='getEditJob' class='getEditJob form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='editJobCustomerName' style='padding-top:8px;'>Customer</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='selectEdiCustomerName'>
                                    <select id='editJobCustomerName' name='editJobCustomerName' class='custom-select'>
                                        <option value = '0' disabled selected>Select customer from list</option>
                                        <?php
$sql = 'SELECT ID, businessName FROM tblCustomer';
$result = mysqli_query($link, $sql);

while ($customerRow = mysqli_fetch_array($result)) {
    if ($customerRow['businessName'] != "DHD" && $customerRow['businessName'] != "DHINSTALL") {
        echo "<option value = " . $customerRow['ID'] . ">" . $customerRow['businessName'] . "</option>";
    }
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='jobJobType' style='padding: 8px 25px;'>Job Type</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='editJobJobType'> <!--  was editJobType -->
                                    <select id='editJobType' name='jobJobType' class='custom-select'>

                                        <?php
$sql = "SELECT * FROM tblJobType";
$result = mysqli_query($link, $sql);
while ($jobRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $jobRow['ID'] . ">" . $jobRow['description'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='jobCameraType' style='padding-top:8px;'>Device Model</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='jobEditCameraType'>
                                    <select id='editJobCameraType' name='jobCameraType' class='custom-select'>
                                        <option value='0' disabled selected>Select camera type</option>
                                        <?php
$sql = "SELECT * FROM tblDeviceDescription";
$result = mysqli_query($link, $sql);
while ($deviceRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $deviceRow['ID'] . ">" . $deviceRow['description'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='editJobOtherKit' style='padding:8px 25px;'>Other Kit</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='editJobOtherKit'>
                                    <div class="multiselect">
                                        <div id="editCheckboxes" style='margin-top: 3px;'>
                                            <label for="editLT">
                                            <input type="checkbox" id="editLT" name="LT" /> Left Turn Audible Alarm </label>
                                            <label for="editSS">
                                            <input type="checkbox" id="editSS" name="SS" /> Side Scan Sensor System </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <!-- <div class='col-2'>
                                <label class='control-label' for='jobJobPriority' style='padding-top: 8px;'>Priority</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='jobEditJobPriority'>
                                    <select id='editJobPriority' name='jobPriority' class='custom-select'>
                                        <option value = '1'>Standard</option>
                                        <option value = '2'>Urgent</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='jobAttachments' style='padding:8px 25px;'>Attachments</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                     <input type='date' class='form-control' id='jobAttachments'>
                                </div>
                            </div>    -->
                            <?php
if ($_SESSION['isInstaller'] == '0' && $_SESSION['isEngineer'] == '0') {
    echo "
                                <div class='col-2'>
                                    <label class='control-label' for='editCustomerJobRate' style='margin-top: 18px;'>Customer Job Rate</label>
                                </div>
                                <div class='col-4'>
                                    <div class='input-group'>
                                        <input type='number' class='form-control' id='editCustomerJobRate' name='jobCustomerRate' min ='0' step='0.01' style='margin-top: 8px;'>
                                    </div>
                                </div>

                                <div class='col-2'>
                                    <label class='control-label' for='editJobRate'  style='padding:8px 25px;'>Engineer Job Rate</label>
                                </div>
                                <div class='col-4'>
                                    <div class='input-group'>
                                        <input type='number' class='form-control' id='editJobRate' name='jobRate' min ='0' step='0.01' style='margin-top: 8px;'>
                                        <input type='checkbox' style='margin: 15px' id='jobRateDefault' checked=checked><p style='margin-top: 13px; margin-left:-12px;'>default</p>
                                    </div>
                                </div>
";
}
?>


                        </div>


                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='jobInvoicedSwitchLabel' style='padding-top:18px;'>Job invoiced</label>
                            </div>
                            <div class='col-1'>
                                <label id='jobInvoicedSwitchLabel'class="switch">
                                    <input id='jobInvoicedSwitch' type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class='col-1'>
                                <div id='jobIsInvoiced'></div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='jobMonthlySwitchLabel' style='padding-top:18px;'>Monthly invoice updated</label>
                            </div>
                            <div class='col-1'>
                                <label id='jobMonthlySwitchLabel'class="switch">
                                    <input id='monthlyInvoiceSwitch' type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class='col-1'>
                                <div id='monthlyUpdated'></div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='jobApprovedSwitchLabel' style='padding-top:18px;'>Approved for payment</label>
                            </div>
                            <div class='col-1'>
                                <label id='jobApprovedSwitchLabel'class="switch">
                                    <input id='approvedSwitch' type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class='col-1'>
                                <div id='approvedPayment'></div>
                            </div>

                        </div>

                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='editJobNotes' style='padding-top:18px;'>Notes</label>
                            </div>
                            <div class='col-10'>
                                <div class='input-group'>
                                       <textarea rows='4' cols='100' class='form-control' placeholder='Enter note text (max 1,024 characters)...' name='jobNotes' id='editJobNotes' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>


                        <hr>

                        <h6><strong>Booking Details</strong></h6>


                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='editJobContactName' style='padding-top:10px;'>Contact Name</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' id='editJobContactName' name='jobContactName' placeholder='contact name...'>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='bookingEquipmentWith' style='padding:10px 25px;'>Kit With</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='bookingEditEquipmentWith'>
                                    <select id='editBookingLocation' name='bookingLocation' class='custom-select'>
                                        <option value = "1">UK Mobile Installations Ltd</option>
                                        <option value = "2">Engineer</option>
                                        <option value = "3">Customer</option>
                                        <option value = "4">Not required</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='editJobContactEmail' style='padding-top:10px;'>Contact Email</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' id='editJobContactEmail' name='jobContactEmail' placeholder='contact email...'>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='editEngineerAssigned' style='padding:10px 25px;'>Engineer Assigned</label>
                            </div>
                            <div class='col-4'>
                                <select id='editEngineerAssigned' name='engineerAssigned' class='custom-select' style='background: 0'>
                                    <option value='0' disabled selected>Select engineer</option>
                                        <?php
$sql = "SELECT userID, userName, activation, isInstaller, isEngineer, colour FROM tblUsers WHERE activation='activated' AND isEngineer=1";
$result = mysqli_query($link, $sql);
while ($engineerRow = mysqli_fetch_array($result)) {

    echo "<option value = '" . $engineerRow['userID'] . "' style='background: " . $engineerRow['colour'] . "'>" . $engineerRow['userName'] . "</option>";
}
?>

                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='editJobContactPhone' style='padding-top:10px;'>Contact Telephone</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' id='editJobContactPhone' name='jobContactPhone' placeholder='contact telephone...'>
                                </div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='editJobDateBooked' style='padding:10px 25px;'>Date Booked For</label>
                            </div>
                            <div class='col-4'>
                                <input type='datetime-local' class='form-control' name = 'editJobDateBooked' id='editJobDateBooked'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='editJobInstallAddress'  style='padding-top: 10px;'>Install Address</label>
                            </div>
                            <div class='col-10'>
                                <div class='input-group'>
                                    <textarea rows='4' cols='100' class='form-control' placeholder='Enter Installation Address' name='jobInstallAddress' id='editJobInstallAddress' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='row' style='padding-top: 8px;'>
                            <div class='col-4'>
                                <label class='control-label' style='padding-top:8px;'><h6><strong>Vehicle Details</strong></h6></label>
                            </div>
                            <div class='col-4'>
                                <label class='control-label' style='padding-top:8px;'><strong>Old VRM (if applicable)</strong></label>
                            </div>
                            <div class='col-4'>
                                <label class='control-label' style='padding-top:8px;'><strong>New/Current VRM</strong></label>
                            </div>
                        </div>
                         <div class='row' id='VRNEditListForJob'>
                            <div class='col-4'>
                                <label class='control-label' for='editJobOldVRN' style='padding-top:8px;'>This job</label>
                            </div>
                            <div class='col-4'>
                                <select name='editJobOldVRN' id = 'editJobOldVRN' class='custom-select addJobTypeOldVRN'></select>
                            </div>
                            <div class='col-4'>
                                <select name='editJobVRN' id = 'editJobVRN' class='custom-select addJobTypeVRN'></select>
                            </div>
                        </div>
                        <div class='row' style='padding-top: 8px;'>
                        </div>
                        <div class='row'>
                        </div>
                        <div class='row'>
                        </div>
                    </div>

                    <hr>
                    <div id='jobCompletionSection'>
                        <h6><strong>Job Completion</strong></h6>
                        <div class='row'>
                            <div class='col-3'>
                                <label class='control-label' for='picRegistrationText' style='padding-top:6px;'>Picture of Vehicle Registration</label>
                            </div>
                            <div class='col-3'>
                                <div class='file-upload'>
                                   <input type='file' id='uploadRegPic' hidden/>
                                    <label for='uploadRegPic' id='uploadFileButton'>Upload</label>
                                </div>
                            </div>
                            <div class='col-3'>
                                <label class='control-label' for='picCameraText' style='padding-top:6px;'>Picture of Device Details</label>
                            </div>
                            <div class='col-3'>
                                <div class='file-upload2'>
                                    <input type='file' id='uploadDevicePic' hidden/>
                                   <label for='uploadDevicePic' id='uploadDeviceButton'>Upload</label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-1'></div>
                            <div class='col-5'>
                                <div class='mr-auto ml-auto' id='regPicContent' style='margin-top:10px'></div>
                            </div>
                            <div class='col-5'>
                                <div class='mr-auto ml-auto' id='devicePicContent' style='margin-top:10px'></div>
                            </div>
                        </div>

                        <div class='row' style='margin-top:15px;'>
                            <div class='col-3'>
                                <label class='form-check-label' for='editJobCompleted' style='font-size:125%'>Job Completed</label>
                            </div>
                            <div class='col-2'>
                                <div class='form-check form-switch'>
                                    <input class='form-check-input' type='checkbox' id='editJobCompleted' style='margin-left: 40px; font-size:125%'>
                                </div>
                            </div>

                            <?php
if ($_SESSION['isInstaller'] == '0' && $_SESSION['isEngineer'] == '0') {
    echo "
                            <div class='col-3 offset-1'>
                                <label class='form-check-label' for='editHubCompleted' style='font-size:125%'>Data Hub Sign Off</label>
                            </div>
                            <div class='col-2'>
                                <div class='form-check form-switch'>
                                    <input class='form-check-input' type='checkbox' id='editHubCompleted' style='margin-left: 10px; font-size:125%'>
                                </div>
                            </div>
                                        ";
}
?>
                        </div>

                    </div>
                </form>
                <div id='editJobMessage'></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addEditJobHide' style='display: none'></div>
                <div id='jobEditCustomerHide'></div>
                <div class='mr-auto' id='jobCurrentStatus'>
                    <h6>STATUS: <span style='color: #FFAA00;'></span></h6>
                </div>
                <button type="button" id='downloadImages' class="btn btn-info" style='display: none'>Download Images</button>
                <button type="button" id='editJobUpdate' onclick='editCurrentJob()' class="btn btn-success">Update Job</button>
                <?php
if ($_SESSION['isInstaller'] == '0' && $_SESSION['isEngineer'] == '0') {
    echo "<button type='button' id='cancelJobUpdate' onclick='cancelCurrentJob()' class='btn btn-secondary'>Cancel Job</button>";
    echo "<button type='button' id='deleteJobUpdate' onclick='deleteCurrentJob()' class='btn btn-danger'>Delete Job</button>";
}
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Discard</button>
            </div>
        </div>
    </div>
</div>

<!-- ----------------------------------- END OF JOB REQUEST DIALOGS ---------------------------------------- -->

<!-- ---------------------------------------- INSTALLER DIALOGS ---------------------------------------------- -->
<!-- ADD INSTALLER DIALOG -->
<div class="modal" id="modalAddNewInstaller" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Installer</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddInstaller' class='getAddInstaller form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInstallerName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Installer Name..." id='addInstallerName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInstallerAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='addInstallerAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInstallerAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='addInstallerAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInstallerAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='addInstallerAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInstallerAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='addInstallerAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addInstallerAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Post Code..." id='addInstallerAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                    <div id='installerMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addInstallerHide' style='display: none'></div>
                <button type="button" id='addInstallerUpdate' onclick='addNewInstaller()' class="btn btn-success">Add</button>
                <?php
//  if ($_SESSION['isAdmin']== '1') {
//     echo "<button type='button' onclick='deleteInstaller()' id='deleteInstaller' class='btn btn-danger'>Delete</button>";
// }
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD NEW INSTALLER CONTACT DIALOG -->
<div class="modal" id="modalAddNewInstallerContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New installer contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getNewInstallerContact' class='getNewInstallerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='installerContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='installerContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='installerContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='installerContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='installerContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='installerContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='installerContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='installerContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='installerContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='installerContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='installerContactJobTitle' style='padding-top:8px;'><strong>Department</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter department..." id='installerContactJobTitle' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id='installerContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='installerEditNumber' style='display: none'></div>
                <div id='contactEditInstallerNumber' style='display: none'></div>
                <div id='addInstallerContactCaller' style='display: none'></div>
                <button type="button" id='updateInstallerContact' class="btn btn-success">Add Contact</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



<!-- ---------------------------------------- SUPPLIER DIALOGS ---------------------------------------------- -->
<!-- ADD SUPPLIER DIALOG -->
<div class="modal" id="modalAddNewSupplier" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Supplier</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddSupplier' class='getAddSupplier form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addSupplierName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Supplier Name..." id='addSupplierName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addSupplierAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='addSupplierAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addSupplierAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='addSupplierAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addSupplierAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='addSupplierAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addSupplierAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='addSupplierAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addSupplierAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Post Code..." id='addSupplierAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                    <div id='supplierMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addSupplierHide' style='display: none'></div>
                <button type="button" id='addSupplierUpdate' onclick='addNewSupplier()' class="btn btn-success">Add</button>
                <?php
//  if ($_SESSION['isAdmin']== '1') {
//     echo "<button type='button' onclick='deleteSupplier()' id='deleteSupplier' class='btn btn-danger'>Delete</button>";
// }
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD NEW SUPPLIER CONTACT DIALOG -->
<div class="modal" id="modalAddNewSupplierContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New supplier contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getNewSupplierContact' class='getNewSupplierContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='supplierContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='supplierContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='supplierContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='supplierContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='supplierContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='supplierContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='supplierContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='supplierContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='supplierContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='supplierContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='supplierContactDepartment' style='padding-top:8px;'><strong>Department</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='supplierContactDepartment' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id='supplierContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='supplierEditNumber' style='display: none'></div>
                <div id='contactEditSupplierNumber' style='display: none'></div>
                <div id='addSupplierContactCaller' style='display: none'></div>
                <button type="button" id='updateSupplierContact' class="btn btn-success">Add Contact</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT SUPPLIER CONTACT DIALOG -->
<div class="modal" id="modalEditSupplierContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit supplier contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditSupplierContact' class='getEditSupplierContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editSupplierContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='editSupplierContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editSupplierContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='editSupplierContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editSupplierContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='editSupplierContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editSupplierContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='editSupplierContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editSupplierContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='editSupplierContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editSupplierContactDepartment' style='padding-top:8px;'><strong>Department</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter department..." id='editSupplierContactDepartment' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id='editSupplierContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editSupplierContactHide' style='display: none'></div>
                <button type="button" id='updateEditSupplierContact' class="btn btn-success">Update</button>
                <?php
if ($_SESSION['isAdmin'] == '1') {
    echo "<button type='button' onclick='deleteSupplierContact()' id='deleteSupplierContact' class='btn btn-danger'>Delete</button>";
}
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- OTHER PARTNER DIALOGS -->
<!-- ADD OTHER DIALOG -->
<div class="modal" id="modalAddNewOther" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Other Partner</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddOther' class='getAddOther form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Other Name..." id='addOtherName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress1' style='padding-top:10px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='addOtherAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress2' style='padding-top:12px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='addOtherAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress3' style='padding-top:14px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='addOtherAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress4' style='padding-top:16px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='addOtherAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress5' style='padding-top:18px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Post Code..." id='addOtherAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherService' style='padding-top:20px;'><strong>Description/Service</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Description/Service..." id='addOtherService' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                    <div id='otherMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addOtherHide' style='display: none'></div>
                <div id='otherEditNumber' style='display: none'></div>
                <div id='contactEditOtherNumber' style='display: none'></div>
                <div id='addOtherContactCaller' style='display: none'></div>
                <button type="button" id='addOtherUpdate' onclick='addNewOther()' class="btn btn-success">Add</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD NEW PARTNER CONTACT DIALOG -->
<div class="modal" id="modalAddNewOtherContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New partner contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getNewOtherContact' class='getNewOtherContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='otherContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='otherContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='otherContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='otherContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='otherContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='otherContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='otherContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='otherContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='otherContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='otherContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='otherContactDepartment' style='padding-top:8px;'><strong>Department</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='otherContactDepartment' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id='otherContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='otherNewNumber' style='display: none'></div>
                <div id='contactEditPartnerNumber' style='display: none'></div>
                <div id='addOtherContactPartnerCaller' style='display: none'></div>
                <button type="button" id='updateOtherContact' class="btn btn-success">Add Contact</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- EDIT OTHER CONTACT DIALOG -->
<div class="modal" id="modalEditOtherContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit partner contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditOtherContact' class='getEditOtherContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editOtherContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='editOtherContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editOtherContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='editOtherContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editOtherContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='editOtherContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editOtherContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='editOtherContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editOtherContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='editOtherContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editOtherContactDepartment' style='padding-top:8px;'><strong>Department</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter department..." id='editOtherContactDepartment' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id='editOtherContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editOtherContactHide' style='display: none'></div>
                <button type="button" id='updateEditOtherContact' class="btn btn-success">Update</button>
                <?php
if ($_SESSION['isAdmin'] == '1') {
    echo "<button type='button' onclick='deleteOtherContact()' id='deleteOtherContact' class='btn btn-danger'>Delete</button>";
}
?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- GET VRN TO LOOKUP -->
<div class="modal" id="modalGetVRNLookup" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:50%'>
        <div class="modal-content">
            <div class='modal-header'>
                <h5 class="modal-title">Vehicle Details Search</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getVRNToLookup' class='getVRNToLookup form-block' onSubmit='return false;'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-3'>
                                <label class='control-label' for='VTNToFind' style='padding-top:8px;'><strong>VRN</strong></label>
                            </div>
                            <div class='col-7'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter registration..." id='VRNToFind'>
                                </div>
                            </div>
                            <div class='col-2'>
                                <button type="button" id='lookupVRNByAPI' style='float:right' class="btn btn-success">Find</button>
                            </div>
                        </div>
                    </div>
                    <div id='VRNToFindMessage'></div>
                </form>
                <div id='VehicleLookupInfo' style='font-size: 14px;'></div>
            </div>
        </div>
    </div>
</div>

<!-- ---------------------------------------- ISSUE REQUEST DIALOGS ---------------------------------------------- -->
<!-- ADD ISSUE DIALOG -->
<div class="modal" id="modalAddIssue" data-backdrop='static' >
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add new issue, bug or feature request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddIssue' class='getAddIssue form-block' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addIssueDate' style='padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='addIssueDate' value="<?php echo date('Y-m-d'); ?>" />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addIssuePriority' style='padding-top:8px;'><strong>Priority</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select id='addIssuePriority' name='addIssuePriority' class='custom-select' style='margin-top:3px;'>
                                        <option value = '1'>Blue Sky</option>
                                        <option value = '2' selected>Low</option>
                                        <option value = '3'>Medium</option>
                                        <option value = '4'>High</option>
                                        <option value = '5'>Critical</option>
                                     </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addIssueDescription' style='padding-top:8px;'><strong>Description/Notes</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <textarea rows='8' cols='100' class='form-control' placeholder='Enter note text (max 1,024 characters)...' name='addIssueDescription' id='addIssueDescription' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>

                            <div class='col-4'>
                                <label for='file'><strong>Upload Screenshot </strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='file' id='file' name='file' accept='image/*'>
                                <span id='uploaded_image'></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div id='issueRequestMessage'></div>
            </div>


            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addIssueHide' style='display: none'></div>
                <button type="button" id='addIssueUpdate' onclick='addNewIssue()' class="btn btn-success">Add</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

<!-- EDIT ISSUE DIALOG -->
<div class="modal" id="modalEditIssue" data-backdrop='static' >
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit issue, bug or feature request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditIssue' class='getEditIssue form-block' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editIssueDate' style='padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='editIssueDate' value="<?php echo date('Y-m-d'); ?>" />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editIssuePriority' style='padding-top:8px;'><strong>Priority</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select id='editIssuePriority' name='editIssuePriority' class='custom-select' style='margin-top:3px;'>
                                        <option value = '1'>Blue Sky</option>
                                        <option value = '2'>Low</option>
                                        <option value = '3'>Medium</option>
                                        <option value = '4'>High</option>
                                        <option value = '5'>Critical</option>
                                     </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editIssueStatus' style='padding-top:8px;'><strong>Status</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select id='editIssueStatus' name='editIssueStatus' class='custom-select' style='margin-top:3px;'>
                                        <option value = '1'>Not Possible</option>
                                        <option value = '2'>Not Started</option>
                                        <option value = '3'>In Progress</option>
                                        <option value = '4'>For Review</option>
                                        <option value = '5'>Completed</option>
                                        <option value = '6'>For Correction</option>
                                        <option value = '7'>More Info/Cannot Replicate</option>
                                     </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editIssueDescription' style='padding-top:8px;'><strong>Description/Notes</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <textarea rows='8' cols='100' class='form-control' name='editIssueDescription' id='editIssueDescription' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class='row'>

                            <div class='col-4'>
                                <label for='fileIssue'><strong>Upload Screenshot </strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='file' id='fileIssue' name='file' accept='image/*'>
                                <span id='uploaded_imageIssue'></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div id='issueEditRequestMessage'></div>
            </div>


            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editIssueHide' style='display: none'></div>
                <button type="button" id='editIssueUpdate' onclick='editIssue()' class="btn btn-success">Update</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- GET CUSTOMER AND VRN TO ALLOCATE DIALOG -->
<div class="modal" id="modalGetCustomerAndVRN" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Allocate to customer</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class='form-group'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <label class='control-label' for='selectCustomer' style='padding-top:8px;'><strong>Select Customer</strong></label>
                            </div>
                            <div class='col-md-8'>
                                <div class='input-group'>
                                    <select id='selectCustomer' name='selectCustomer' class='custom-select selectCustomer'>
                                        <?php
$sql = "SELECT ID, businessName FROM tblCustomer ORDER BY businessName ASC";
$result = mysqli_query($link, $sql);

while ($deviceRow = mysqli_fetch_array($result)) {
    echo "<option value = " . $deviceRow['ID'] . ">" . $deviceRow['businessName'] . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id='optionalVRN' class='row'>


                        </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='hiddenAllocateID' style='display: none'></div>
                <button type="button" id='allocateDeviceToCustomer' onclick='allocateDeviceToCustomer()' class="btn btn-success">Allocate</button>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- EDIT DEVICE NOTES DIALOG -->
<div class="modal" id="modalEditJobNotes" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:66%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Job Notes</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditJobNotes' class='getEditJobNotes form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='input-group'>
                                    <textarea rows='10' cols='40' class='form-control' placeholder='Enter note text (max 1,024 characters)...' id='editJobNotesText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div id='editJobNotesMessage'></div>
                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='hiddenJobNotesID' style='display: none'></div>
                <div id='editJobNotesID' style='display: none'></div>
                <div id='editJobCustomerID' style='display: none'></div>
                <button type="button" id='editCurrentJobNotes' onclick='editCurrentJobNotes()' class="btn btn-success">Update</button>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalGetNewVRN" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:30%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Add new vehicle</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getNewVRN' class='getNewVRN form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-sm-4 col-md-4'>
                                <label class='control-label inline' for='newVRN' style='padding-top:8px;'><strong>Reg Number</strong></label>
                            </div>
                            <div class='col-sm-8 col-md-6'>
                                <div class='input-group'>
                                    <input class='form-control' type='text' name='newVRN' id='newVRN' style='text-transform: uppercase; background-color: #FFDD00; border: 0; color: #4444FF; font-size:20px; font-weight:900;'>
                                </div>
                            </div>
                            <div class='text-center' style='font-size: 11px; margin-top: 10px; margin-left: 38px;'>Leave blank for TBC</div>
                        </div>
                    </div>
                    <div id='newVRNMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='addNewVRNToCustomer' class="btn btn-success">Add</button>
            </div>
        </div>
    </div>

</div>


<div class="modal" id="modalGetJobReportParameters" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:40%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Select Report Parameters</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getJobReportNewVRN' class='getNewVRN form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-lg-4'>
                                <label class='control-label-inline' style='padding-top:8px;' for='getEngineer'>Select Engineer</label>
                            </div>
                            <div class='col-lg-8'>
                                <select id='getEngineer' name='getEngineer' class='custom-select'>
                                    <option value='0' selected>All engineers</option>
                                        <?php
$sql = "SELECT userID, userName, activation, isInstaller, isEngineer FROM tblUsers WHERE activation='activated' AND isEngineer=1";
$result = mysqli_query($link, $sql);
while ($engineerRow = mysqli_fetch_array($result)) {
    echo "<option value = '" . $engineerRow['userID'] . "'>" . $engineerRow['userName'] . "</option>";
}
?>
                                    <option value='9999' class='otherOptionSelection'>Unregistered Engineer</option>
                                </select>
                            </div>
                        </div><hr>
                            <div class='row' style='padding-top: 8px; text-align: center'>
                                <div class='col-lg-4'></div><div class='col-lg-4'>from</div><div class='col-lg-4'>to</div>
                            </div>
                            <div class='row'>
                            <div class='col-lg-4'>
                                <label class='control-label-inline' style='padding-top:8px;' for='dateAdded'>Date Added Range</label>
                            </div>
                            <div class = 'col-lg-4'>
                                <input type='date' class='form-control' name = 'dateAddedFrom' id='dateAddedFrom'>
                            </div>
                            <div class = 'col-lg-4'>
                                <input type='date' class='form-control' name = 'dateAddedTo' id='dateAddedTo'  value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-4'>
                                <label class='control-label-inline' style='padding-top:8px;' for='dateBooked'>Date Booked Range</label>
                            </div>
                            <div class = 'col-lg-4'>
                                <input type='date' class='form-control' name = 'dateBookedFrom' id='dateBookedFrom'>
                            </div>
                            <div class = 'col-lg-4'>
                                <input type='date' class='form-control' name = 'dateBookedTo' id='dateBookedTo' value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div><hr>
                        <div class='row'>
                            <div class='col-lg-3'>
                                <label class='control-label-inline' style='padding-top:8px;' for='getStatus'>Job Status</label>
                            </div>
                            <div class='col-lg-3'>
                                <label for ='includeComplete'>
                                <input type='checkbox' class='form-check-input' name='includeComplete' id='includeComplete'/>Completed</label>
                            </div>
                            <div class='col-lg-3'>
                                <label for ='includePending'>
                                <input type='checkbox' class='form-check-input' name='includePending' id='includePending' checked/>Pending</label>
                            </div>
                            <div class='col-lg-3'>
                                <label for ='includeBooked'>
                                <input type='checkbox' class='form-check-input' name='includeBooked' id='includeBooked' checked/>Booked</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-3'></div>
                            <div class='col-lg-5'>
                                <label for ='includeOverdue'>
                                <input type='checkbox' class='form-check-input' name='includeOverdue' id='includeOverdue' checked/>Booked - Date Passed</label>
                            </div>
                            <div class='col-lg-4'>
                                <label for ='includeApproval'>
                                <input type='checkbox' class='form-check-input' name='includeApproval' id='includeApproval' checked/>Awaiting Approval</label>
                            </div>
                        </div>
                    </div>
                    <div id='reportParamsMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='sendReportParameters' onclick='printPDFJobsList()' class="btn btn-success">Show</button>
            </div>
        </div>
    </div>

</div>


<div class="modal" id="modalShowJobRates" data-backdrop='static'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Default Job Rates</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getJobRates' class='getJobRates form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-lg-12' style='max-height: 70vh; overflow: auto;'>
                                <table id='tableJobRates' class='table table-sm table-scrollable'>

                                    <thead>
                                        <tr><th>Device</th>
                                            <?php
$headerList = array();
$sql = 'SELECT * FROM tblJobType';
$result = mysqli_query($link, $sql);
while ($rowHeader = mysqli_fetch_array($result)) {
    echo "<th class='text-center' id='" . $rowHeader['ID'] . "'>" . $rowHeader['description'] . "</th>";
    $headerList[] = $rowHeader['ID'];
}
?>

                                        </tr>
                                    </thead>

                                    <tbody>

                                            <?php
$sql = "SELECT * FROM tblDeviceDescription";
$result = mysqli_query($link, $sql);
while ($rowRow = mysqli_fetch_array($result)) {
    echo "<tr><td class='align-middle'>" . $rowRow['description'] . "</td>";

    foreach ($headerList as $headerItem) {
        $sql = "SELECT * FROM tblJobRates WHERE deviceID='" . $rowRow['ID'] . "' AND jobTypeID='" . $headerItem . "'";
        $rowResult = mysqli_query($link, $sql);
        $rowItem = mysqli_fetch_array($rowResult);
        if ($rowItem['ID'] ?? '') {
            echo "<td><input class='number2decimal' id='" . $rowItem['ID'] . "' type='text' style ='text-align: right' value='" . number_format($rowItem['rate'] ?? 0, 2, '.', ',') . "'></td>";
        } else {
            echo "<td><input class='number2decimal'  type='text' style ='text-align: right' value='" . number_format($rowItem['rate'] ?? 0, 2, '.', ',') . "'></td>";
        }
    }
    unset($headerItem);
    echo "</tr>";
}

?>


                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div id='jobRatesMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='updateJobRates' onclick='updateJobRates()' class="btn btn-success">Update</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalEditMultipleJobs" data-backdrop='static'>
    <div class="modal-dialog modal-xl"  style='max-width: 90% !important;'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Edit Multiple Jobs</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='editMultiJobs' class='editMultiJobs' class='form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-lg-12' style='max-height: 60vh;overflow: auto;''>
                                <table id='multipleJobs' class='table cell-border compact table-scrollable'>

                                    <thead>
                                        <tr>
                                            <th class='align-middle' style='width: 17%;'>Customer</th>
                                            <th class='align-middle text-center' style='width: 8%;'>Job Type</th>
                                            <th class='align-middle' style='width: 12%;'>Camera Type</th>
                                            <th class='align-middle text-center' style='width: 5%;'>Registration</th>
                                            <th class='align-middle text-center' style='width: 11%;'>Date/Time Booked</th>
                                            <th class='align-middle text-center' style='width: 8%;'>Engineer</th>
                                            <th class='align-middle text-center' style='width: 13%;'>Address</th>
                                            <th class='align-middle' style='width: 25%;'>Notes</th>
                                            <th class='align-middle text-center' style='width: 1%;'>Select</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                            <?php
$sql = "SELECT tblJobs.ID,
                                                               tblCustomer.businessName,
                                                               tblJobType.description AS jobType,
                                                               tblDeviceDescription.description AS CameraType,
                                                               tblVehicle.regNumber,
                                                               tblJobs.date,
                                                               tblJobs.Notes,
                                                               tblJobs.bookingAddress,
                                                               tblUsers.userName AS engineerName
                                                        FROM tblJobs
                                                        INNER JOIN tblCustomer ON tblCustomer.ID = tblJobs.ownerID
                                                        INNER JOIN tblJobType ON  tblJobType.ID = tblJobs.jobType
                                                        INNER JOIN tblDeviceDescription ON tblDeviceDescription.ID = tblJobs.cameraTypeID
                                                        LEFT JOIN tblVehicle ON  tblVehicle.ID = tblJobs.VRN
                                                        INNER JOIN tblUsers ON  tblUsers.userID = tblJobs.engineerID";

$result = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($result)) {
    echo "<tr value='" . $Row['ID'] . "'><td class='align-middle' style='width: 17%;'>" . $Row['businessName'] . "</td>";
    echo "<td class='align-middle text-center' style='width: 8%;'>" . $Row['jobType'] . "</td>";
    echo "<td class='align-middle' style='width: 12%;'>" . $Row['CameraType'] . "</td>";
    echo "<td class='align-middle text-center' style='width: 5%;'>" . $Row['regNumber'] . "</td>";

    if (date('d/m/Y', strtotime($Row['date'] ?? '')) == '01/01/1970') {
        echo "<td class='align-middle text-center' style='width: 11%;' data-order='0/0/0'>TBD</td>";
    } else {
        echo "<td class='align-middle text-center' style='width: 11%;' data-order=" . strtotime($Row['date'] ?? '') . ">" . date('d/m/y (D) H:i', strtotime($Row['date'] ?? '')) . "</td>";
    }
    echo "<td class='align-middle text-center' style='width: 8%;'>" . $Row['engineerName'] . "</td>";
    echo "<td class='align-middle' style='width: 8%;'>" . $Row['bookingAddress'] . "</td>";
    echo "<td class='align-middle' style='width: 38%;'>" . $Row['Notes'] . "</td>";
    echo "<td class='align-middle text-center' style='width: 1%;'><input class='selectCheckBox' type='checkbox'></td>";
    echo "</tr>";
}
?>
                                    </tbody>
                                </table>
                            </div>
                            <script>
                            $(document).ready(function() {
                                $('#multipleJobs').DataTable({
                                    colReorder: true,
                                    order: [[4, 'asc']],
                                    processing: true,
                                    paging: false,
                                    responsive: true,
                                    stateSave: true,
                                    dom: '<\"top\"iflp>rt<\"bottom\"><\"clear\">',
                                    rowCallback: function(row, data, dataIndex) {
                                        if ($('body').hasClass('dark')) {
                                            $(row).css('background-color', 'rgba(68,68,68,1)')
                                            .css('color', 'white')
                                            .css('border-color', 'white');
                                        } else {
                                            $(row).css('background-color', 'rgba(255,255,255,1)')
                                            .css('color', 'rgba(68,68,68,1)')
                                            .css('border-color', 'rgba(68,68,68,1)');
                                        }
                                    }
                                });
                            });
                            </script>

                        </div>
                        <div class='form-group' style='margin-top: 15px; margin-bottom :15px; border: 1px solid #dedede; border-radius:5px;'>
                            <div class='row' style='margin-top: 10px; margin-left: 6px;'>
                                <div class='col-2'>
                                    <label for = 'changeJobType' style='margin-top: 6px;'>Job Type</label>
                                </div>
                                <div class='col-3'>
                                    <!-- <div class='input-group'>
                                        <select id='changeJobType' name='changeJobType' class='custom-select'>
                                            <option value='0' selected>Do not change...</option>
                                            <?php
// $sql="SELECT userID, userName, isEngineer, activation FROM tblUsers WHERE activation='activated' AND isEngineer=1";
// $result = mysqli_query($link, $sql);
// while ($engineerRow = mysqli_fetch_array($result)) {
//     echo "<option value = '" . $engineerRow['userID'] . "'>" . $engineerRow['userName'] . "</option>";
// }
?>
                                            <option value='9999'>Unregistered Engineer</option>
                                        </select>
                                    </div> -->
                                    <div class='input-group'>
                                        <select id='changeJobType' name='changeJobType' class='custom-select'>
                                            <option value='0' selected>Do not change...</option>
                                            <?php
$sql = "SELECT ID, description FROM tblJobType";
$result = mysqli_query($link, $sql);
while ($jobTypeRow = mysqli_fetch_array($result)) {
    echo "<option value = '" . $jobTypeRow['ID'] . "'>" . $jobTypeRow['description'] . "</option>";
}
?>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-1'></div>
                                <div class='col-2'>
                                    <label for = 'changeDeviceType' style='margin-top: 6px;'>Device Type</label>
                                </div>
                                <div class='col-3'>
                                    <div class='input-group'>
                                        <select id='changeDeviceType' name='changeDeviceType' class='custom-select'>
                                            <option value='0' selected>Do not change...</option>
                                            <?php
$sql = "SELECT ID, description FROM tblDeviceDescription";
$result = mysqli_query($link, $sql);
while ($deviceRow = mysqli_fetch_array($result)) {
    echo "<option value = '" . $deviceRow['ID'] . "'>" . $deviceRow['description'] . "</option>";
}
?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class='row' style='margin-top: 10px; margin-left: 6px;'>
                                <div class='col-2'>
                                    <label for = 'newBookedDate' style='margin-top: 6px;'>Date Booked</label>
                                </div>
                                <div class='col-3'>
                                    <div class='input-group'>
                                        <input class='form-control dateType' type='datetime-local' placeholder="Do not change..." name='newBookedDate' id='newBookedDate'>
                                    </div>
                                </div>
                                <div class='col-1'></div>
                                <div class='col-2'>
                                    <label for = 'multipleUpdateDeviceAddress' style='margin-top: 6px;'>Change Address</label>
                                </div>
                                <div class='col-3'>
                                    <div class='input-group'>
                                        <textarea rows='1' cols='512' class='form-control' placeholder='Leave blank for no change...' id='multipleUpdateDeviceAddress' style='margin-top:3px;'></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class='row' style='margin-top: 10px; margin-left: 6px;'>
                                <div class='col-2'>
                                    <label for = 'changeEngineerType' style='margin-top: 6px;'>Engineer</label>
                                </div>
                                <div class='col-3' style='margin-bottom: 15px;'>
                                    <div class='input-group'>
                                        <select id='changeEngineerType' name='changeEngineerType' class='custom-select'>
                                            <option value='0' selected>Do not change...</option>
                                            <?php
$sql = "SELECT userID, userName, isEngineer, activation FROM tblUsers WHERE activation='activated' AND isEngineer=1";
$result = mysqli_query($link, $sql);
while ($engineerRow = mysqli_fetch_array($result)) {
    echo "<option value = '" . $engineerRow['userID'] . "'>" . $engineerRow['userName'] . "</option>";
}
?>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-1'></div>
                                <div class='col-2'>
                                    <label for = 'multipleUpdateDeviceNote' style='margin-top: 6px;'>Append Note</label>
                                </div>
                                <div class='col-3'>
                                    <div class='input-group'>
                                        <textarea rows='1' cols='512' class='form-control' placeholder='Leave blank for no change...' id='multipleUpdateDeviceNote' style='margin-top:3px;'></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div class='mr-auto' id='multipleJobsMessage'></div>
                <button type="button" id='updateMultipleJobs' onclick='updateMultipleJobs()' class="btn btn-success" disabled=disabled>Update</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



