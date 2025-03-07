<!-- EDIT FOOTAGE REQUEST -->
<div class="modal" id="modalEditFootage" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:75%'>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Footage Request</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
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
                                <label for='footageEditVRNListLabel' class='control-label' style='padding-top:8px;'>Vehicle Reg Number</label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group' id='footageEditVRNList'>
                                    <input type=text' style='display: none' id='footageEditVRNListLabel'>
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
                                    <label class='control-label' for='footageEditFileName' style='margin-top:7px;padding-top:10px;'>Footage File(s)</label>
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
                                            <table id='footageEditFileTableBody' class='table table-sm'>
                                                <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th style='width:5%'>Info</th>
                                                        <th style='width:5%'>Remove</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='footageEditFileTableBodyBlock'>

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
                                    <div id='footageEditRecipientsList' class='input-group'></div>
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
                                    <label for='footageEditCurrentStatusList' class='control-label' style='margin-top: 7px; padding-top:10px;'>Current Status</label>
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
