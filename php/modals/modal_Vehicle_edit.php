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
                    <hr>
                    <div class='row'>
                        <div class='col-md-5 col-lg-4'>
                            <label for='editVehicleCameraYes' class='control-label'>Camera is required?</label>
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
                            <label for='editVehicleStatusInstalled' class='control-label'>Current Status</label>
                        </div>
                        <div class='col-md-7 col-lg-6' style='font-size:125%'>
                            <div class='form-check-inline'>
                                <input type='radio' class='form-check-input' id='editVehicleStatusInstalled' name='vehicleStatus'>
                                <label class='form-check-label' id='editVehicleStatusInstalledLabel' for='editVehicleStatusInstalled' style='margin-right: 25px'>Installed</label>
                            </div>
                            <div class='form-check-inline'>
                                <input type='radio' class='form-check-input' id='editVehicleStatusPending' name='vehicleStatus'>
                                <label class='form-check-label' id='editVehicleStatusPendingLabel' for='editVehicleStatusPending'>Pending</label>
                            </div>
                            <div class='form-check-inline'>
                                <input type='radio' class='form-check-input' id='editVehicleStatusNotApplicable' name='vehicleStatus'>
                                <label class='form-check-label' id='editVehicleStatusNotApplicableLabel' for='editVehicleStatusNotApplicable'>N/A</label>
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
                            <label for='editLTAlarmDate' class='control-label' id='labelEditLeftTurn' style='padding-top:9px;'>Left Turn Audible Alarm</label>
                        </div>
                        <div class='col-md-7 col-lg-6' style='font-size:125%'>
                            <div class='input-group' style='width:75%'>
                                <input type='date' class='form-control' id='editLTAlarmDate' style='margin-top:3px;'>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-5 col-lg-4'>
                            <label for='editSideScanDate' class='control-label' id='labelEditSideScan' style='padding-top:9px;'>Side Scan Sensor System</label>
                        </div>
                        <div class='col-md-7 col-lg-6' style='font-size:125%'>
                            <div class='input-group' style='width:75%'>
                                <input type='date' class='form-control' placeholder="Install/upcoming install date..." id='editSideScanDate' style='margin-top:3px;'>
                            </div>
                        </div>
                    </div>

                    <hr>
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
                    <hr>
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
                <button type="button" class="btn btn-success" onclick='editCurrentVehicle()'>Update</button>
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