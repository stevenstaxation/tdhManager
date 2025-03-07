<!-- EDIT JOB REQUEST DIALOG -->
<div class="modal" id="modalEditNewJobRequest" data-backdrop='static'>
    <div class="modal-dialog modal-lg">
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
                                        <option value='0' disabled selected>Select customer from list</option>
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
                                <div class='input-group' id='editJobJobType'> 
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
                                <label for='editLT' class='control-label' style='padding:8px 25px;'>Other Kit</label>
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
                                <label class='control-label' for='jobInvoicedSwitch' style='padding-top:18px;'>Job invoiced</label>
                            </div>
                            <div class='col-1'>
                                <label id='jobInvoicedSwitchLabel' class="switch">
                                    <input id='jobInvoicedSwitch' type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class='col-1'>
                                <div id='jobIsInvoiced'></div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='monthlyInvoiceSwitch' style='padding-top:18px;'>Monthly invoice updated</label>
                            </div>
                            <div class='col-1'>
                                <label id='jobMonthlySwitchLabel' class="switch">
                                    <input id='monthlyInvoiceSwitch' type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class='col-1'>
                                <div id='monthlyUpdated'></div>
                            </div>
                            <div class='col-2'>
                                <label class='control-label' for='approvedSwitch' style='padding-top:18px;'>Approved for payment</label>
                            </div>
                            <div class='col-1'>
                                <label id='jobApprovedSwitchLabel' class="switch">
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
                                <label class='control-label' for='editBookingLocation' style='padding:10px 25px;'>Kit With</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='bookingEditEquipmentWith'>
                                    <select id='editBookingLocation' name='bookingLocation' class='custom-select'>
                                        <!-- <option value = "1">UK Mobile Installations Ltd</option> -->
                                        <option value="2">Engineer</option>
                                        <option value="3">Customer</option>
                                        <option value="4">Not required</option>
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
                                <select id='editEngineerAssigned' name='engineerAssigned' class='custom-select'>
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
                                <label class='control-label' for='editJobDateBooked' style='padding:10px 25px;'>Date Booked</label>
                            </div>
                            <div class='col-4'>
                                <input type='date' class='form-control' name='editJobDateBooked' id='editJobDateBooked'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-6'></div>
                            <div class='col-2' style='display:inline-flex'>
                                <label class='control-label' for='editJobTimeBooked' style='padding:10px 25px;'>Time Booked</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='time' class='form-control' id='editJobTimeBooked'> 
                                </div>
                                <div class='input-group mt-2' id='jobTimeBookedGroup'>
                                    <input type='radio' class='form-control' name='editJobTimeBooked' id='editJobTimeAllDay'>Day 
                                    <input type='radio' class='form-control' name='editJobTimeBooked' id='editJobTimeAM'>AM 
                                    <input type='radio' class='form-control' name='editJobTimeBooked' id='editJobTimePM'>PM 
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-2'>
                                <label class='control-label' for='editJobInstallAddress' style='padding-top: 10px;'>Install Address</label>
                            </div>
                            <div class='col-10'>
                                <div class='input-group'>
                                    <textarea rows='4' cols='100' class='form-control' placeholder='Enter Installation Address' name='jobInstallAddress' id='editJobInstallAddress' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='row' style='padding-top: 8px;'>
                            <div class='col-4'>
                                <p class='control-label' style='padding-top:8px;'>
                                <h6><strong>Vehicle Details</strong></h6>
                                </p>
                            </div>
                            <div class='col-4'>
                                <p class='control-label' style='padding-top:8px;'><strong>Vehicle Registration Mark</strong></p>
                            </div>
                            <div class='col-4'>

                            </div>
                        </div>
                        <div class='row' id='VRNEditListForJob'>
                            <div class='col-4'>
                                <label class='control-label' for='editJobVRN' style='padding-top:8px;'>This job</label>
                            </div>
                            <div class='col-4'>
                                <select name='editJobVRN' id='editJobVRN' class='custom-select addJobTypeVRN'></select>
                            </div>
                            <div class='col-4' style='font-family: Charles-Wright-Bold'>
                                <p style='width: 10%; margin: 0; background-color:#232F68; color: white; padding-top: 24px; padding-bottom: 7px; border: 1px solid black; float: left;'><b style='padding: 0 3px'>&nbsp;GB&nbsp;</b></p>
                                <p class='jobRegistrationPlate' style='width: 85%; margin: 0; margin-left:-4px; background-color:#f5bd38; color: black; font-size: 32px; border: 1px solid black;float: left;'><b style='padding: 0 5px;'></b></p>
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
                                <p class='control-label' style='padding-top:6px;'>Picture of Vehicle Registration</p>
                            </div>
                            <div class='col-3'>
                                <div class='file-upload'>
                                    <input type='file' id='uploadRegPic' hidden />
                                    <label for='uploadRegPic' id='uploadFileButton'>Upload</label>
                                </div>
                            </div>
                            <div class='col-3'>
                                <p class='control-label' style='padding-top:6px;'>Picture of Device Details</p>
                            </div>
                            <div class='col-3'>
                                <div class='file-upload2'>
                                    <input type='file' id='uploadDevicePic' hidden />
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
