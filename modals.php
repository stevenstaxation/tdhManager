
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
                <form method='POST' id='getNewUserEmail' class='getNewUserEmail' class='form-block'>
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
            <div class="modal-body" style='font-size: 75%;max-height: 50vh; overflow: auto' ;>
                <form method='POST' id='showAlerts' class='showAlerts' class='form-block'>
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
                <form method='POST' id='getAddNewDevice' class='getAddNewDevice' class='form-block'>
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
                                            $result = mysqli_query($link,$sql);

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
                                            $result = mysqli_query($link,$sql);

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
                                    <input type='date' class='form-control' placeholder="SIM deactivation date..." id='addSIMDate' style='margin-top:3px;'>
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
                                    <input type='text' class='form-control' maxlength='50' placeholder="Config file used..." id='addConfigFile' style='margin-top:3px;'>
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
                                             $result = mysqli_query($link,$sql);
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
                                <label class='control-label' for='addDeviceInstaller' style='padding-top:15px;'><strong>Installer</strong></label>
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
                                            $result = mysqli_query($link,$sql);
                                            while ($SIMRow = mysqli_fetch_array($result)) {
                                                if ($SIMRow['ID']==$DEFAULT_INSTALLER) {
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
                                <label class='control-label' for='addDeviceInstalldate' style='padding-top:15px;'><strong>Install Date</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' placeholder="Installation date..." id='addDeviceInstallDate' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceInstallReference' style='padding-top:15px;'><strong>Installer Ref</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Installer reference..." id='addDeviceInstallReference' style='margin-top:3px;'>
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
                                            $result = mysqli_query($link,$sql);
                                            while ($SIMRow = mysqli_fetch_array($result)) {
                                                if ($SIMRow['ID']==$DEFAULT_SUPPLIER) {
                                                 echo "<option value = " . $SIMRow['ID'] . " selected>" . $SIMRow['supplierName'] . "</option>";
                                                } else {
                                                 echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['supplierName'] . "</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceSupplierInvoice' style='padding-top:15px;'><strong>Order No</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Order number..." id='addDeviceSupplierInvoice' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                        <div class='col-md-2'>
                                <label class='control-label' for='addDevicePurchaseDate' style='padding-top:15px;'><strong>Purchase Date</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='addDevicePurchaseDate' style='margin-top:3px;'>
                                </div>
                            </div>

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
    <div class="modal-dialog" style='max-width:66%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Device</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditDevice' class='getEditDevice' class='form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='editDeviceDescription' style='padding-top:8px;'><strong>Device</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='editDeviceDescription' name='editDeviceDescription' class='custom-select editDeviceDescription'>
                                        <?php
                                    $sql = "SELECT * FROM tblDeviceDescription ORDER BY description ASC";
                                    $result = mysqli_query($link,$sql);

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
                                <label class='control-label' for='editTDHNumber' style='padding-top:9px;'><strong>TDH Number</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="TDH Number..." id='editTDHNumber' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='editSerial' style='padding-top:10px;'><strong>Serial Number</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Serial Number..." id='editSerial' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='editIMEI' style='padding-top:11px;'><strong>IMEI</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='20' placeholder="IMEI..." id='editIMEI' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='editDRIDNumber' style='padding-top:11px;'><strong>DRID</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="DRID..." id='editDRIDNumber' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='editSIMNumber' style='padding-top:12px;'><strong>SIM Serial</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="SIM Serial..." id='editSIMNumber' style='margin-top:3px;' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='editSIMPhone' style='padding-top:12px;'><strong>SIM Phone</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='20' placeholder="SIM Phone..." id='editSIMPhone' style='margin-top:3px;' onkeypress='return onlyNumberKey(event)'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='editSIMStatus' style='padding-top:13px;'><strong>SIM Status</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='editSIMStatus' name='editSIMStatus' class='custom-select editSIMStatus' style='margin-top:3px;'>
                                        <?php
                                    $sql = "SELECT * FROM tblSIMStatus ORDER BY SIMStatus ASC";
                                    $result = mysqli_query($link,$sql);

                                    while ($SIMRow = mysqli_fetch_array($result)) {
                                        echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['SIMStatus'] . "</option>";
                                    }
                               ?>
                                    </select>

                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='editSIMDate' style='padding-top:13px;'><strong>SIM Deactivate</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' placeholder="SIM deactivation date..." id='editSIMDate' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='editOwnerID' style='padding-top:13px;'><strong>Allocated to</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='editOwnerID' name='editOwnerID' class='custom-select editOwnerID' style='margin-top:3px;'>
                                        <?php
                                    $sql = "SELECT * FROM tblCustomer ORDER BY businessName ASC";
                                    $result = mysqli_query($link,$sql);

                                    echo "<option value= '0' selected='selected'>DHINSTALL</option>";
                                    while ($SIMRow = mysqli_fetch_array($result)) {
                                        echo "<option value = '" . $SIMRow['ID'] . "'>" . $SIMRow['businessName'] . "</option>";
                                    }
                               ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='editVRN' style='padding-top:13px;'><strong>Vehicle Reg</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="VRN..." id='editVRN' style='margin-top:3px;'>
                                    <div class='input-group-append'>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <!-- <div class='col-md-6'></div>
                            <div class='col-md-2'>
                                <label class='control-label' for='editVehicleDescription' style='padding-top:14px;'><strong>Description</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' readonly='readonly' id='editVehicleDescription' style='margin-top:3px; font-size: 88%'>
                                </div>
                            </div> -->
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='editConfigFile' style='padding-top:14px;'><strong>Config file</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Config file used..." id='editConfigFile' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='editDeviceStatus' style='padding-top:14px;'><strong>Current Status</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='editDeviceStatus' name='editDeviceStatus' class='custom-select editDeviceStatus' style='margin-top:3px;'>
                                        <?php
                                    $sql = "SELECT * FROM tblDeviceStatus ORDER BY ID ASC";
                                    $result = mysqli_query($link,$sql);
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
                                <label class='control-label' for='editDeviceInstaller' style='padding-top:15px;'><strong>Installer</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='editDeviceInstaller' name='editDeviceInstaller' class='custom-select editDeviceInstaller' style='margin-top:3px;'>
                                        <?php
                                    $sql = "SELECT * FROM tblInstaller ORDER BY installerName ASC";
                                    $result = mysqli_query($link,$sql);
                                    while ($SIMRow = mysqli_fetch_array($result)) {
                                        echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['installerName'] . "</option>";
                                    }
                               ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='editDeviceInstallDate' style='padding-top:15px;'><strong>Install Date</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' placeholder="Installation date..." id='editDeviceInstallDate' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='editDeviceInstallReference' style='padding-top:15px;'><strong>Installer Ref</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Installer reference..." id='editDeviceInstallReference' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='editDeviceSupplier' style='padding-top:15px;'><strong>Supplier</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='editDeviceSupplier' name='editDeviceSupplier' class='custom-select editDeviceSupplier' style='margin-top:3px;'>
                                        <?php
                                    $sql = "SELECT * FROM tblSupplier ORDER BY supplierName ASC";
                                    $result = mysqli_query($link,$sql);
                                    while ($SIMRow = mysqli_fetch_array($result)) {
                                        echo "<option value = " . $SIMRow['ID'] . ">" . $SIMRow['supplierName'] . "</option>";
                                    }
                               ?>
                                    </select>

                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='editDeviceSupplierInvoice' style='padding-top:15px;'><strong>Order No</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Order number..." id='editDeviceSupplierInvoice' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                        <div class='col-md-2'>
                                <label class='control-label' for='editDevicePurchaseDate' style='padding-top:15px;'><strong>Purchase Date</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='editDevicePurchaseDate' style='margin-top:3px;'>
                                </div>
                            </div>

                        </div>
                        <div class='row' style='margin-top:15px;'></div>
                        <div class='row'>
                            <div class='col-md-2'>
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
                    if ($_SESSION['isAdmin']== '1') {
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
                <form method='POST' id='getEditDeviceNotes' class='getEditDeviceNotes' class='form-block'>
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
                <div id='editDeviceCustomerID' style='display: none'></div>
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
                <form method='POST' id='getEditVehicleNotes' class='getEditVehicleNotes' class='form-block'>
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
                <form method='POST' id='getAddBroker' class='getAddBroker' class='form-block'>
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
                <form method='POST' id='getEditBroker' class='getEditBroker' class='form-block'>
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
                <form method='POST' id='getNewBrokerContact' class='getNewBrokerContact' class='form-block'>
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
                <form method='POST' id='getEditBrokerContact' class='getEditBrokerContact' class='form-block'>
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
                    if ($_SESSION['isAdmin']== '1') {
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
                <form method='POST' id='getAddInsurer' class='getAddInsurer' class='form-block'>
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
                <form method='POST' id='getEditInsurer' class='getEditInsurer' class='form-block'>
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
                <form method='POST' id='getNewInsurerContact' class='getNewInsurerContact' class='form-block'>
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
                <form method='POST' id='getEditInsurerContact' class='getEditInsurerContact' class='form-block'>
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
                    if ($_SESSION['isAdmin']== '1') {
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
                <form method='POST' id='getEditInstallerContact' class='getEditInstallerContact' class='form-block'>
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
                    if ($_SESSION['isAdmin']== '1') {
                        echo "<button type='button' onclick='deleteInstallerContact()' id='deleteInstallerContact' class='btn btn-danger'>Delete</button>";
                    }
                ?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
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
                <form method='POST' id='getNewCustomerContact' class='getNewCustomerContact' class='form-block'>
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
                <form method='POST' id='getEditCustomerContact' class='getEditCustomerContact' class='form-block'>
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
                <div id='contactEditNumber' style='display: none'></div>
                <button type="button" id='updateEditCustomerContact' onclick='updateCustomerContact()' class="btn btn-success">Update</button>
                <?php
                    if ($_SESSION['isAdmin']== '1') {
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
                <form method='POST' id='addNewCustomer' class='addNewCustomer' class='form-block'>
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
                                            $result = mysqli_query($link,$sql);

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
                                            $result = mysqli_query($link,$sql);

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
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New customer note</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getNewCustomerNote' class='getNewCustomerNote' class='form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='noteDate' style='width: 40%; padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='datetime-local' placeholder="Enter date..." name='noteDate' id='noteDate' min='<?php echo date("Y-m-d\TH:i");?>' value='<?php echo date("Y-m-d\TH:i");?>'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='noteText' style='padding-top:8px;'><strong>Note Text</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <textarea rows='5' cols='60' class='form-control' placeholder='Enter note text (max 512 characters)...' id='noteText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='row' style='margin-top: 20px;'>
                            <div class='col-4'>
                                <label class='control-label inline' for='isImportantNote' style='font-size: 75%; padding-top:8px;'><strong>Mark as important</strong></label>
                            </div>
                            <div class='col-2'>
                                <input type='checkbox' class='form-check-input' value='checked' id='isImportantNote' style='margin: 5px 0;padding: 10px 10px;'>
                            </div>
                            <div class='col-4'>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit customer note</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='editCustomerNote' class='editCustomerNote' class='form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='noteEditDate' style='width: 40%; padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='datetime' placeholder="Enter date..." name='noteEditDate' id='noteEditDate' readonly='readonly' min='<?php echo date("Y-m-d\TH:i");?>' value='<?php echo date("Y-m-d\TH:i");?>'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label inline' for='noteEditText' style='padding-top:8px;'><strong>Note Text</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <textarea rows='5' cols='60' class='form-control' placeholder='Enter note text (max 512 characters)...' id='noteEditText' style='margin-top:3px;'></textarea>
                                </div>
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
                <form method='POST' id='getAddNewFootage' class='getAddNewFootage' class='form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <h6><strong>Incident</strong></h6> 
                            <div class='col-md-3'>
                                <label class='control-label' for='footageIncidentDate' style='padding-top:9px;'>Incident Date and Time</label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='datetime-local' class='form-control' id='footageIncidentDate' name='footageIncidentDate'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='footageVRNList' style='padding-top:8px;'>Vehicle Reg Number</label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group' id='footageVRNList' name='footageVRNList'>
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
                                <div id='footageRecipientsList' name='footageRecipientsList' class='input-group'>
                                   
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
                                            $result = mysqli_query($link,$sql);

                                            while ($userRow = mysqli_fetch_array($result)) {
                                                $fullName = $userRow['firstName'] . ' ' . $userRow['lastName'];
                                                if (trim($fullName)=='') {
                                                    $fullName = $userRow['userName'];
                                                    if ($fullName=='') {
                                                        $fullName = $userRow['email'];
                                                    }
                                                }
                                                echo "<option value = " . $userRow['userID'] . ">" . $fullName . "</option>";
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
                                <div class='input-group' id='footageCurrentStatus' style='margin-top: 9px;'>
                                    <select id='footageCurrentStatus' name='footageCurrentStatus' class='custom-select getCurrentStatus'>
                                        <?php
                                            $sql = "SELECT * FROM tblFootageStatus ORDER BY description ASC";
                                            $result = mysqli_query($link,$sql);

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
                <form method='POST' id='getEditFootage' class='getEditFootage' class='form-block'>
                <div class='form-group'>
                    <div class='row'>
                        <h6><strong>Incident</strong></h6> 
                            <div class='col-md-3'>
                                <label class='control-label' for='footageEditIncidentDate' style='padding-top:9px;'>Incident Date and Time</label>
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
                                <div class='input-group' id='footageEditVRNList' name='footageEditVRNList'>
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
                                <div id='footageEditRecipientsList' name='footageEditRecipientsList' class='input-group'>
                                   
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
                                            $result = mysqli_query($link,$sql);

                                            while ($userRow = mysqli_fetch_array($result)) {
                                                if ($userRow['activation']=='activated') {
                                                $fullName = $userRow['firstName'] . ' ' . $userRow['lastName'];
                                                if (trim($fullName)=='') {
                                                    $fullName = $userRow['userName'];
                                                    if ($fullName=='') {
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
                                            $result = mysqli_query($link,$sql);

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
                <form method='POST' id='getAddVehicle' class='getAddVehicle' class='form-block'>
                    <div class='row'>
                        <div class='col-md-5 col-lg-4'>
                            <label class='control-label' for='addVehicleRegNumber' style='padding-top:9px;'><strong>Registration Number</strong></label>
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
                           <p/>   
                  </div>               
                <hr>
                <div class='row'>
                    <div class='col-md-5 col-lg-4'>
                        <label class='control-label'><strong>Camera is required?</strong></label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input'id='vehicleCameraYes' name='cameraRequired' checked>
                            <label class='form-check-label' for='vehicleCameraYes' style='margin-right: 60px'>Yes</label>
                        </div>
                        <div class='form-check-inline'>
                        <input type='radio' class='form-check-input'id='vehicleCameraNo' name='cameraRequired'>
                            <label class='form-check-label' for='vehicleCameraNo'>No</label>
                        </div>
                    </div>                          
                </div>

                <div class='row' style='margin-top:15px'>
                    <div class='col-md-5 col-lg-4'>
                        <label class='control-label'><strong>Current Status</strong></label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input'id='vehicleStatusInstalled' name='vehicleStatus' checked>
                            <label class='form-check-label' for='vehicleStatusInstalled' style='margin-right: 25px'>Installed</label>
                        </div>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input'id='vehicleStatusPending' name='vehicleStatus'>
                            <label class='form-check-label' for='vehicleStatusPending'>Pending</label>
                        </div>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input'id='vehicleStatusNotApplicable' name='vehicleStatus'>
                            <label class='form-check-label' for='vehicleStatusNotApplicable'>N/A</label>
                        </div>
                    </div>                          
                </div>

                <div class='row' style='margin-top:15px'>
                    <div class='col-md-5 col-lg-4'>
                        <label id='vehicleInstallDateLabel' for='vehicleInstalldate' class='control-label' style='padding-top:9px;'><strong>Installation Date</strong></label>
                    </div>   
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>                    
                        <div class='input-group' style='width:75%'>
                            <input type='date' class='form-control' placeholder="Install/upcoming install date..." id='vehicleInstalldate' style='margin-top:3px;'>
                        </div>
                    </div>
                </div>
                
                <!-- <div class='row'>
                  <div class='col-md-5 col-lg-4'>
                      <label class='control-label' for='addVehicleMake' style='padding-top:9px;'><strong>Make</strong></label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' maxlength='50' placeholder="Make..." id='addVehicleMake' style='margin-top:1px;'>
                      </div>
                  </div>
                </div> -->
                <!-- <div class='row'>
                  <div class='col-md-5 col-lg-4'>
                      <label class='control-label' for='addVehicleModel' style='padding-top:9px;'><strong>Model</strong></label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' maxlength='100' placeholder="Model..." id='addVehicleModel' style='margin-top:1px;'>
                      </div>
                  </div>
                </div> -->
                <!-- <div class='row'>
                  <div class='col-md-5 col-lg-4'>
                      <label class='control-label' for='addVehicleAddDescription' style='padding-top:9px;'><strong>Description</strong></label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' maxlength='100' placeholder="Description..." id='addVehicleAddDescription' style='margin-top:1px;'>
                      </div>
                  </div>
                </div> -->
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
                            <!-- <?php $sql = "SELECT businessName FROM tblCustomer WHERE ID='" . $_SESSION['currentCustomer'] ."'";
                                $result = mysqli_query($link, $sql);
                                $row = mysqli_fetch_array($result); 
                                echo " value= '" . $row['businessName'] . "'>";
                            ?> -->
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
                      <label class='control-label' for='editVehicleRegNumber' style='padding-top:9px;'><strong>Registration Number</strong></label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' maxlength='14' placeholder="VRN..." id='editVehicleRegNumber' style='margin-top:1px;'>
                      </div>
                  </div>
                </div>
                <hr />
                <div class='row'>
                <div class='col-md-5 col-lg-4'>
                        <label class='control-label'><strong>Camera is required?</strong></label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input'id='editVehicleCameraYes' name='cameraRequired'>
                            <label class='form-check-label' for='editVehicleCameraYes' style='margin-right: 60px'>Yes</label>
                        </div>
                        <div class='form-check-inline'>
                        <input type='radio' class='form-check-input'id='editVehicleCameraNo' name='cameraRequired'>
                            <label class='form-check-label' for='editVehicleCameraNo'>No</label>
                        </div>
                    </div>    
                  <!-- <div class='col-md-5 col-lg-4'>
                      <label class='control-label' for='editVehicleMake' style='padding-top:9px;'><strong>Make</strong></label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' maxlength='50' placeholder="Make..." id='editVehicleMake' style='margin-top:1px;'>
                      </div>
                  </div> -->
                </div>
                <div class='row'>
                <div class='col-md-5 col-lg-4'>
                        <label class='control-label'><strong>Current Status</strong></label>
                    </div>
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input'id='editVehicleStatusInstalled' name='vehicleStatus'>
                            <label class='form-check-label' for='editVehicleStatusInstalled' style='margin-right: 25px'>Installed</label>
                        </div>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input'id='editVehicleStatusPending' name='vehicleStatus'>
                            <label class='form-check-label' for='editVehicleStatusPending'>Pending</label>
                        </div>
                        <div class='form-check-inline'>
                            <input type='radio' class='form-check-input'id='editVehicleStatusNotApplicable' name='vehicleStatus'>
                            <label class='form-check-label' for='editVehicleStatusNotApplicable'>N/A</label>
                        </div>
                    </div>                  
                  <!-- <div class='col-md-5 col-lg-4'>
                      <label class='control-label' for='editVehicleModel' style='padding-top:9px;'><strong>Model</strong></label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' maxlength='100' placeholder="Model..." id='editVehicleModel' style='margin-top:1px;'>
                      </div>
                  </div> -->
                </div>
                <div class='row'>
                <div class='col-md-5 col-lg-4'>
                        <label id='vehicleInstallDateLabel' for='editVehicleInstalldate' class='control-label' style='padding-top:9px;'><strong>Installation Date</strong></label>
                    </div>   
                    <div class='col-md-7 col-lg-6' style='font-size:125%'>                    
                        <div class='input-group' style='width:75%'>
                            <input type='date' class='form-control' placeholder="Install/upcoming install date..." id='editVehicleInstalldate' style='margin-top:3px;'>
                        </div>
                    </div>
                  <!-- <div class='col-md-5 col-lg-4'>
                      <label class='control-label' for='editVehicleAddDescription' style='padding-top:9px;'><strong>Description</strong></label>
                  </div>
                  <div class='col-md-7 col-lg-6'>
                      <div class='input-group'>
                          <input type='text' class='form-control' maxlength='100' placeholder="Description..." id='editVehicleAddDescription' style='margin-top:1px;'>
                      </div>
                  </div> -->
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
              <div id='hiddenVehicleID' style='display: none'></div>
              <div id='editVehicleErrorBox'></div>
                <button type="button" class="btn btn-success"  onclick='editCurrentVehicle()'>Update</button>
                <?php
                    if ($_SESSION['isAdmin']== '1') {
                        echo "<button type='button' onclick='deleteVehicle()' id='deleteVehicle' class='btn btn-danger'>Delete</button>";
                    }
                ?>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- ---------------------------------------- END OF VEHICLE DIALOGS ---------------------------------------------- -->

<!-- ---------------------------------------- JOB REQUEST DIALOGS ---------------------------------------------- -->
<!-- ADD JOB REQUEST DIALOG -->
<div class="modal" id="modalAddNewJobRequest" data-backdrop='static' >
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add New Job</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
           
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddJob' class='getAddJob form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addJobDate' style='padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='addJobDate'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addJobTypeType' style='padding-top:8px;'><strong>Job Type</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select id='addJobTypeType' name='addJobTypeType' class='custom-select addJobTypeType' style='margin-top:3px;'>
                                    <?php
                                        $sql = "SELECT * FROM tblJobType ORDER BY description ASC";
                                        $result = mysqli_query($link,$sql);
                                        while ($jobRow = mysqli_fetch_array($result)) {
                                            echo "<option value = '" . $jobRow['ID'] . "'>" . $jobRow['description'] . "</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addJobTypeVRN' style='padding-top:8px;'><strong>VRN</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select id='addJobTypeVRN' name='addJobTypeVRN' class='custom-select addJobTypeVRN' style='margin-top:3px;'>
                                    <?php
                                        $sql = "SELECT ID,regNumber FROM tblVehicle WHERE tblVehicle.ownerID = '" . $_SESSION['currentCustomer']. "' ORDER BY regNumber ASC";
                                        $result = mysqli_query($link,$sql);

                                        while ($VRNRow = mysqli_fetch_array($result)) {
                                            echo "<option value = '" . $VRNRow['ID'] . "'>" . $VRNRow['regNumber'] . "</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addJobNotes' style='padding-top:8px;'><strong><?php echo $sql?></strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                       <textarea rows='8' cols='100' class='form-control' placeholder='Enter note text (max 1,024 characters)...' name='addJobNotes' id='addJobNotes' style='margin-top:3px;'></textarea>                      
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id='jobRequestMessage'></div>
            </div>


            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addJobHide' style='display: none'></div>
                <div id='jobCustomerHide'></div>
                <button type="button" id='addJobUpdate' onclick='addNewJob()' class="btn btn-success">Add</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT JOB REQUEST DIALOG -->
<div class="modal" id="modalEditNewJobRequest" data-backdrop='static' >
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Existing Job</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
           
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditJob' class='getEditJob form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editJobDate' style='padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='editJobDate'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editJobTypeType' style='padding-top:8px;'><strong>Job Type</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select id='editJobTypeType' name='editJobTypeType' class='custom-select editJobTypeType' style='margin-top:3px;'>
                                    <?php
                                        $sql = "SELECT * FROM tblJobType ORDER BY description ASC";
                                        $result = mysqli_query($link,$sql);
                                        while ($jobRow = mysqli_fetch_array($result)) {
                                            echo "<option value = " . $jobRow['ID'] . ">" . $jobRow['description'] . "</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editJobTypeVRN' style='padding-top:8px;'><strong>VRN</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <select id='editJobTypeVRN' name='editJobTypeVRN' class='custom-select editJobTypeVRN' style='margin-top:3px;'>
                                    <?php
                                        $sql = "SELECT ID,regNumber FROM tblVehicle WHERE tblVehicle.ownerID = '" . $_SESSION['currentCustomer']."' ORDER BY regNumber ASC";
                                        $result = mysqli_query($link,$sql);
                                        while ($VRNRow = mysqli_fetch_array($result)) {
                                            echo "<option value = " . $VRNRow['ID'] . ">" . $VRNRow['regNumber'] . "</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editJobNotes' style='padding-top:8px;'><strong>Job Details</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                       <textarea rows='8' cols='100' class='form-control' placeholder='Enter note text (max 1,024 characters)...' name='editJobNotes' id='editJobNotes' style='margin-top:3px;'></textarea>                      
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id='jobRequestEditMessage'></div>
            </div>


            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editJobHide' style='display: none'></div>
                <button type="button" id='editJobComplete' onclick='editJobComplete(1)' class="btn btn-info">Mark as Complete</button>
                <button type="button" id='editJobUpdate' onclick='editJobComplete(2)' class="btn btn-success">Update</button>
                <button type="button" id='editJobCancel' class="btn btn-warning" data-dismiss="modal">Cancel</button>
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
                <form method='POST' id='getAddInstaller' class='getAddInstaller' class='form-block'>
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
                <form method='POST' id='getNewInstallerContact' class='getNewInstallerContact' class='form-block'>
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
                <div id='contactEditNumber' style='display: none'></div>
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
                <form method='POST' id='getAddSupplier' class='getAddSupplier' class='form-block'>
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
                <form method='POST' id='getNewSupplierContact' class='getNewSupplierContact' class='form-block'>
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
                <div id='contactEditNumber' style='display: none'></div>
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
                <form method='POST' id='getEditSupplierContact' class='getEditSupplierContact' class='form-block'>
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
                    if ($_SESSION['isAdmin']== '1') {
                        echo "<button type='button' onclick='deleteSupplierContact()' id='deleteSupplierContact' class='btn btn-danger'>Delete</button>";
                    }
                ?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
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
                <form method='POST' id='getAddOther' class='getAddOther' class='form-block'>
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
                <div id='contactEditNumber' style='display: none'></div>
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
                <form method='POST' id='getNewOtherContact' class='getNewOtherContact' class='form-block'>
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
                <div id='otherEditNumber' style='display: none'></div>
                <div id='contactEditNumber' style='display: none'></div>
                <div id='addOtherContactCaller' style='display: none'></div>
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
                <form method='POST' id='getEditOtherContact' class='getEditOtherContact' class='form-block'>
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
                    if ($_SESSION['isAdmin']== '1') {
                        echo "<button type='button' onclick='deleteOtherContact()' id='deleteOtherContact' class='btn btn-danger'>Delete</button>";
                    }
                ?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
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
                <form method='POST' id='getVRNToLookup' class='getVRNToLookup' class='form-block' onSubmit='return false;'>
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