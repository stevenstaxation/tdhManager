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
                                <p class='control-label' style='padding: 8px 25px;'>Other Kit</p>
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
                         
                            <div class='col-2'>
                                <label class='control-label' for='customerJobRate' style='padding-top: 8px;'>Customer Job Rate</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='number' class='form-control' id='customerJobRate' name='customerJobRate' min='0' step='0.01'>
                                </div>
                            </div>

                            <div class='col-2'>
                                <label class='control-label' for='jobRate' style='padding: 0 25px;'>Engineer Job Rate</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='number' class='form-control' id='jobRate' name='jobRate' min='0' step='0.01'>
                                    <input type='checkbox' style='margin: 15px' id='jobRateDefault' checked=checked>
                                    <p style='margin-top: 13px; margin-left:-12px;'>default</p>
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
                                <label class='control-label' for='bookingLocation' style='padding:10px 25px;'>Kit With</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group' id='bookingEquipmentWith'>
                                    <select id='bookingLocation' name='bookingLocation' class='custom-select'>
                                        <option value="0" disabled selected>Kit Location</option>
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
                                    <input type='text' class='form-control' id='jobContactPhone' name='jobContactPhone' placeholder='contact telephone...'>
                                </div>
                            </div>
                            <div class='col-2' style='display:inline-flex'>
                                <label class='control-label' for='jobDateBooked' style='padding:10px 25px;'>Date Booked For</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='date' class='form-control' name='jobDateBooked' id='jobDateBooked'> 
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-6'></div>
                            <div class='col-2' style='display:inline-flex'>
                                <label class='control-label' for='jobTimeBooked' style='padding:10px 25px;'>Time Booked</label>
                            </div>
                            <div class='col-4'>
                                <div class='input-group'>
                                    <input type='time' class='form-control' id='jobTimeBooked'> 
                                </div>
                                <div class='input-group mt-2' id='jobTimeBookedGroup'>
                                    <input type='radio' class='form-control' name='jobTimeBooked' id='jobTimeAllDay'>Day 
                                    <input type='radio' class='form-control' name='jobTimeBooked' id='jobTimeAM'>AM 
                                    <input type='radio' class='form-control' name='jobTimeBooked' id='jobTimePM'>PM 
                                </div>
                            </div>
                        </div>
                  
                    <div class='row'>
                        <div class='col-2'>
                            <label class='control-label' for='jobInstallAddress' style='padding-top: 8px;'>Install Address</label>
                        </div>
                        <div class='col-10'>
                            <div class='input-group'>
                                <textarea rows='3' cols='100' class='form-control' placeholder='Enter Installation Address' name='jobInstallAddress' id='jobInstallAddress' style='margin-top:3px;'></textarea>
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
                            <!-- <label class='control-label' style='padding-top:8px;'><strong>Old VRM (if applicable)</strong></label> -->
                            <p class='control-label' style='padding-top:8px;'><strong>New/Current VRM</strong></p>
                        </div>
                        <div class='col-4'>
                        </div>
                    </div>
                    <div class='row' id='VRNListForJob'>
                        <div class='col-4'>
                            <p class='control-label' for='addJobTypeVRN' style='padding-top:8px;'>Job No. 1</p>
                        </div>
                        <div class='col-4'>
                            <!-- <div class='input-group'>
                                    <select name='addJobTypeOldVRN' class='custom-select addJobTypeOldVRN'>
                                        <option value="0" disabled selected>select VRN</option>
                                    </select>
                                </div> -->
                            <div class='input-group'>
                                <select id='addJobTypeVRN' name='addJobTypeVRN' class='custom-select addJobTypeVRN'>
                                    <option value="0" disabled selected>select VRN</option>
                                </select>
                                <div class='input-group-append'>
                                    <span class='input-group-btn btn btn-outline-success btn-sm disabled addVRNButton' style='padding:7px;'><b>New</b></span>
                                </div>
                            </div>
                        </div>
                        <div class='col-4' style='font-family: Charles-Wright-Bold'>
                            <p style='width: 10%; margin: 0; background-color:#232F68; color: white; padding-top: 24px; padding-bottom: 7px;'><b style='padding: 0 3px'>&nbsp;GB&nbsp;</b></p>
                            <p class='jobRegistrationPlate newJobRegistrationPlate isARegNumber' style='width: 100%; margin: 0; margin-left:-4px; font-size: 32px; border: 1px solid black;'><b style='padding: 0 5px'>N/A</b></p>
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