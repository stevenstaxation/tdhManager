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
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceBuyer' style='padding-top:15px;'><strong>Device bought by</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <select id='addDeviceBuyer' name='addDeviceBuyer' class='custom-select addDeviceBuyer' style='margin-top: 3px;'>
                                        <option selected='selected' value='0'>Customer</option>
                                        <option value='1'>Broker</option>
                                        <option value='2'>Insurer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDeviceInstallDate' style='padding-top:15px;'><strong>Original install Date</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='addDeviceInstallDate' style='margin-top:3px;'>
                                </div>
                            </div>
                            <div class='col-md-2'>
                                <label class='control-label' for='addDevicePurchaseDate' style='padding-top:15px;'><strong>Purchase Date</strong></label>
                            </div>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' id='addDevicePurchaseDate' style='margin-top:3px;' value='<?php echo date('Y-m-d'); ?>'>
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