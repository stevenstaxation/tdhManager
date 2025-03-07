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
                                <input type='text' class='form-control' maxlength='14' placeholder="VRN..." id='addVehicleRegNumber' style='font-family: Charles-Wright-Bold; margin-top:1px; background-color:#f5bd38; color: black; font-size: 24px;'>
                                <!-- <button type='button' class='btn btn-sm btn-info' id='findVehicleRegNumber'>Find</button> -->
                            </div>
                        </div>

                        <!-- width: 70%; margin: 0; margin-left:-4px;  border: 1px solid black;' -->
                        <!-- <div class='col-md-5 col-lg-4'></div>
                            <div class='col-md-7 vol-lg-6'>
                                <div class="progress" id='lookUpProgress' style='width:85%; height: 15px; visibility: hidden;'>
                                    <div class="progress-bar progress-bar-animated progress-bar-striped bg-info" style='width:100%' role="progressbar">searching...</div>
                                </div>
                            </div>
                        </div> -->

                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-md-5 col-lg-4'>
                            <label for='vehicleCameraYes' class='control-label'>Camera is required?</label>
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
                            <p class='control-label'>Current Status</p>
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
                            <p class='control-label' style='padding-top:9px;'><strong>Description</strong></p>
                        </div>
                        <div class='col-md-7 col-lg-6' style='font-size:125%'>
                            <p class='control-label' style='padding-top:9px;'><strong>Install Date (if applicable)</strong></p>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-5 col-lg-4'>
                            <label for='LTAlarmInstalldate' class='control-label' style='padding-top:9px;'>Left Turn Audible Alarm</label>
                        </div>
                        <div class='col-md-7 col-lg-6' style='font-size:125%'>
                            <div class='input-group' style='width:75%'>
                                <input type='date' class='form-control' id='LTAlarmInstalldate' style='margin-top:3px;'>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-5 col-lg-4'>
                            <label for='SideScanInstalldate' class='control-label' style='padding-top:9px;'>Side Scan Sensor System</label>
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
                                <input type='text' class='form-control' readonly='readonly' id='addVehicleAllocateTo' style='margin-top:1px;' <?php $sql = "SELECT businessName FROM tblCustomer WHERE ID='" . $_SESSION['currentCustomer'] . "'";
                                                                                                                                                $result = mysqli_query($link, $sql);
                                                                                                                                                $row = mysqli_fetch_array($result);
                                                                                                                                                echo " value= '" . $row['businessName'] . "'>";
                                                                                                                                                ?> </div>
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