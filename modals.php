





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
                        <div class='rowAlert' id='alertTable'>
                        </div>
                    </div>
                    <div id='alertListMessage'></div>
                </form>  
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
                <div id='editOtherContactHide' class='d-none'></div>
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
                                <label class='control-label' for='VRNToFind' style='padding-top:8px;'><strong>VRN</strong></label>
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
<div class="modal" id="modalAddIssue" data-backdrop='static'>
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
                                        <option value='1'>Blue Sky</option>
                                        <option value='2' selected>Low</option>
                                        <option value='3'>Medium</option>
                                        <option value='4'>High</option>
                                        <option value='5'>Critical</option>
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
                <div id='addIssueHide' class='d-none'></div>
                <button type="button" id='addIssueUpdate' onclick='addNewIssue()' class="btn btn-success">Add</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

<!-- EDIT ISSUE DIALOG -->
<div class="modal" id="modalEditIssue" data-backdrop='static'>
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
                                        <option value='1'>Blue Sky</option>
                                        <option value='2'>Low</option>
                                        <option value='3'>Medium</option>
                                        <option value='4'>High</option>
                                        <option value='5'>Critical</option>
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
                                        <option value='1'>Not Possible</option>
                                        <option value='2'>Not Started</option>
                                        <option value='3'>In Progress</option>
                                        <option value='4'>For Review</option>
                                        <option value='5'>Completed</option>
                                        <option value='6'>For Correction</option>
                                        <option value='7'>More Info/Cannot Replicate</option>
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
                <div id='editIssueHide'  class='d-none'></div>
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
                <div id='hiddenAllocateID'  class='d-none'></div>
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
                <div id='hiddenJobNotesID'  class='d-none'></div>
                <div id='editJobNotesID'  class='d-none'></div>
                <div id='editJobCustomerID'  class='d-none'></div>
                <button type="button" id='editCurrentJobNotes' onclick='editCurrentJobNotes()' class="btn btn-success">Update</button>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
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
                        </div>
                        <hr>
                        <div class='row' style='padding-top: 8px; text-align: center'>
                            <div class='col-lg-4'></div>
                            <div class='col-lg-4'>from</div>
                            <div class='col-lg-4'>to</div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-4'>
                                <label class='control-label-inline' style='padding-top:8px;' for='dateAddedFrom'>Date Added Range</label>
                            </div>
                            <div class='col-lg-4'>
                                <input type='date' class='form-control' name='dateAddedFrom' id='dateAddedFrom'>
                            </div>
                            <div class='col-lg-4'>
                                <input type='date' class='form-control' name='dateAddedTo' id='dateAddedTo' value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-4'>
                                <label class='control-label-inline' style='padding-top:8px;' for='dateBookedFrom'>Date Booked Range</label>
                            </div>
                            <div class='col-lg-4'>
                                <input type='date' class='form-control' name='dateBookedFrom' id='dateBookedFrom'>
                            </div>
                            <div class='col-lg-4'>
                                <input type='date' class='form-control' name='dateBookedTo' id='dateBookedTo' value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-lg-3'>
                                <p class='control-label-inline' style='padding-top:8px;'>Job Status</p>
                            </div>
                            <div class='col-lg-3'>
                                <label for='includeComplete'>
                                    <input type='checkbox' class='form-check-input' name='includeComplete' id='includeComplete' />Completed</label>
                            </div>
                            <div class='col-lg-3'>
                                <label for='includePending'>
                                    <input type='checkbox' class='form-check-input' name='includePending' id='includePending' checked />Pending</label>
                            </div>
                            <div class='col-lg-3'>
                                <label for='includeBooked'>
                                    <input type='checkbox' class='form-check-input' name='includeBooked' id='includeBooked' checked />Booked</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-3'></div>
                            <div class='col-lg-5'>
                                <label for='includeOverdue'>
                                    <input type='checkbox' class='form-check-input' name='includeOverdue' id='includeOverdue' checked />Booked - Date Passed</label>
                            </div>
                            <div class='col-lg-4'>
                                <label for='includeApproval'>
                                    <input type='checkbox' class='form-check-input' name='includeApproval' id='includeApproval' checked />Awaiting Approval</label>
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
                                        <tr>
                                            <th>Device</th>
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
    <div class="modal-dialog modal-xl" style='max-width: 90% !important;'>
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
                            <div class='col-lg-12' style='max-height: 60vh;overflow: auto;'>
                                <table id="multipleJobs" class=' table cell-border compact table-scrollable'>

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
                                                               tblJobs.timePeriod,
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

                                            if ($Row["date"]) {         
                                                if (date('d/m/Y', strtotime($Row['date'] ?? '')) == '01/01/1970') {
                                                    echo"<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>TBD</td>";
                                                } else {
                                                    if (date('H:i', strtotime($Row['date']))!="00:00") {
                                                       echo "<td class='text-center align-middle' style='padding:0 3px;' data-order=" . strtotime($Row['date']) . ">" . date('d/m/Y (D) H:i', strtotime($Row['date'])) . "</td>";
                                                    } else {
                                                        switch ($Row['timePeriod']) {
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
                                                       echo "<td class='text-center align-middle' style='padding:0 3px;' data-order=" . strtotime($Row['date']) . ">" . date('d/m/Y (D)', strtotime($Row['date'])). $periodOfTime ."</td>";
                                                    }
                                                }
                                            } else {
                                                echo "<td class='text-center align-middle' style='padding:0 3px;' data-order='0/0/0'>TBD</td>";
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
                                        order: [
                                            [4, 'asc']
                                        ],
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
                                    <label for='changeJobType' style='margin-top: 6px;'>Job Type</label>
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
                                    <label for='changeDeviceType' style='margin-top: 6px;'>Device Type</label>
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
                                <div class='col-5'>
                                    <div class='row'>        
                                        <div class='col-5'>
                                            <label for='newBookedDate' style='margin-top: 6px;'>Date Booked</label>
                                        </div>
                                        <div class='col-7'>
                                            <div class='input-group'>
                                                <input class='form-control dateType' type='date' placeholder="Do not change..." name='newBookedDate' id='newBookedDate'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-5'>
                                            <label for='newBookedDate' style='margin-top: 6px;'>Time Booked</label>
                                        </div>
                                        <div class='col-7'>
                                            <div class='input-group'>
                                                <input class='form-control dateType' type='time' placeholder="Do not change..." name='newBookedTime' id='bulkJobTimeBooked'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-5'></div>
                                        <div class='col-7'>
                                            <div class='input-group mt-2' id='bulkJobTimeBookedGroup'>
                                                <input type='radio' class='form-control' name='bulkJobTimeBooked' id='bulkJobTimeAllDay'>Day 
                                                <input type='radio' class='form-control' name='bulkJobTimeBooked' id='bulkJobTimeAM'>AM 
                                                <input type='radio' class='form-control' name='bulkJobTimeBooked' id='bulkJobTimePM'>PM 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-1'></div>
                                <div class='col-2'>
                                    <label for='multipleUpdateDeviceAddress' style='margin-top: 6px;'>Change Address</label>
                                </div>
                                <div class='col-3'>
                                    <div class='input-group'>
                                        <textarea rows='4' cols='512' class='form-control' placeholder='Leave blank for no change...' id='multipleUpdateDeviceAddress' style='margin-top:3px;'></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class='row' style='margin-top: 10px; margin-left: 6px;'>
                                
                            </div>

                            <div class='row' style='margin-top: 10px; margin-left: 6px;'>
                                <div class='col-2'>
                                    <label for='changeEngineerType' style='margin-top: 6px;'>Engineer</label>
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
                                    <label for='multipleUpdateDeviceNote' style='margin-top: 6px;'>Append Note</label>
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