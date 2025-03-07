<!-- ADD NEW CUSTOMER CONTACT DIALOG -->
<div class="modal" id="modalAddNewContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New customer contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getNewCustomerContact' class='getNewCustomerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='contactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='contactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='contactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='contactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='contactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='contactJobTitle' style='padding-top:8px;'><strong>Job Title</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='contactJobTitle' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <!-- <div class='row'>

                                <label class='form-check-label' for='contactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='contactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                                <label class='form-check-label' for='contactHealthCheck' style='padding-top:18px;'><strong>Health Checks</strong></label>
                                <input type='checkbox' class='form-check-input' value='checked' id='contactHealthCheck' style='margin: 15px 50px;padding: 10px 10px;'

                            </div> -->
                        <div class='row'>
                            <div class='col-4'>
                                <label class='form-check-label' for='contactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='contactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='form-check-label' for='contactHealthCheck' style='padding-top:18px;'><strong>Health Checks</strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='contactHealthCheck' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='form-check-label' for='contactReports' style='padding-top:18px;'><strong>Report Recipient</strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='contactReports' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>


                    </div>
                    <div id='contactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='updateCustomerContact' class="btn btn-success">Add Contact</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>