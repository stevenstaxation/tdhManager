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
                                <label for='footageVRNListInput' class='control-label' style='padding-top:8px;'>Vehicle Reg Number</label>
                            </div>
                            <div class='col-md-3'>
                                <div class='input-group' id='footageVRNList'>
                                    <input type='text' id='footageVRNListInput' style='display: hidden'>
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
                                <label class='control-label' for='footageFileName' style='margin-top:7px;padding-top:10px;'>Footage File(s)</label>
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
                                        <table id='footageFileTableBody' class='table table-sm'>
                                            <thead>
                                                <tr>
                                                    <th>File Name</th>
                                                    <th style='width:5%'>Info</th>
                                                    <th style='width:5%'>Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody id='footageFileTableBodyBlock'>

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