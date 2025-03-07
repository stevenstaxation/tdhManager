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
                <form method='POST' id='getEditInsurerContact' class='getEditInsurerContact form-block'>
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
                            <div class='col-4'>
                                <label class='form-check-label' for='editInsurerContactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='editInsurerContactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>

                        <div id='editInsurerContactMessage'></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div id='editInsurerContactHide' style='display: none'></div>
                <button type="button" id='updateEditInsurerContact' class="btn btn-success">Update</button>
                <?php
                if ($_SESSION['isAdmin'] == '1') {
                    echo "<button type='button' onclick='deleteInsurerContact()' id='deleteInsurerContact' class='btn btn-danger'>Delete</button>";
                }
                ?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>