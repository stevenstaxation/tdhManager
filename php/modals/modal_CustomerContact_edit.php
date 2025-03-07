<!-- EDIT CUSTOMER CONTACT DIALOG -->
<div class="modal" id="modalEditContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit customer contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditCustomerContact' class='getEditCustomerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='editContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='editContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='editContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='editContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='editContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editContactJobTitle' style='padding-top:8px;'><strong>Job Title</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='editContactJobTitle' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='form-check-label' for='editContactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='editContactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='form-check-label' for='editContactHealthCheck' style='padding-top:18px;'><strong>Health Checks</strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='editContactHealthCheck' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='form-check-label' for='editContactReports' style='padding-top:18px;'><strong>Report Recipient</strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='editContactReports' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='editContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='customerContactEditNumber' style='display: none'></div>
                <div id='contactCustomerEditNumber' style='display: none'></div>
                <button type="button" id='updateEditCustomerContact' onclick='updateCustomerContact()' class="btn btn-success">Update</button>
                <?php
                if ($_SESSION['isAdmin'] == '1') {
                    echo "<button type='button' onclick='deleteCustomerContact()' id='deleteCustomerContact' class='btn btn-danger'>Delete</button>";
                }
                ?>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>