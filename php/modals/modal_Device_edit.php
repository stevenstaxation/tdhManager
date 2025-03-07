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
                                    <input type='text' class='form-control' maxlength='20' placeholder="IMEI..." id='editIMEI' style='margin-top:3px;'>
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
                                    <input type='date' class='form-control hasToolTip' id='editSIMSuspensionDate' style='margin-top:18px;' data-placement="auto" title="<em>If empty, click the date field to set default of today's date</em>">
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
                            <div class='col-md-1'></div>
                            <div class='col-md-1'>
                                <label class='control-label' for='editDeviceBuyer' style='padding-top:15px;'><strong>Device buyer</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <select id='editDeviceBuyer' name='editDeviceBuyer' class='custom-select editDeviceBuyer' style='margin-top: 3px;'>
                                        <option value='0'>Customer</option>
                                        <option value='1'>Broker</option>
                                        <option value='2'>Insurer</option>
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
                                <label class='control-label' for='editDevicePurchaseDate' style='padding-top:15px;'><strong>Purchase Date</strong></label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='editDevicePurchaseDate' style='margin-top:3px;'>
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