<div class="modal" id="modalAddNewBrokerContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New broker contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getNewBrokerContact' class='getNewBrokerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactFirstName' style='padding-top:8px;'><strong>First Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='brokerContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactLastName' style='padding-top:8px;'><strong>Last Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='brokerContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactMobile' style='padding-top:8px;'><strong>Mobile Number</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='brokerContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactTelephone' style='padding-top:8px;'><strong>Telephone</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='brokerContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactEmail' style='padding-top:8px;'><strong>Email address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='brokerContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='brokerContactDepartment' style='padding-top:8px;'><strong>Department</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='brokerContactDepartment' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='form-check-label' for='brokerContactFootageRequest' style='padding-top:18px;'><strong>Footage Recipient</strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='brokerContactFootageRequest' style='margin: 15px 50px'>
                            </div>
                            <div class='col-4'>
                                <label class='form-check-label' for='brokerContactReporting' style='padding-top:18px;'><strong>Report Recipient</strong></label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='brokerContactReporting' style='margin: 15px 50px'>
                            </div>
                        </div>
                    </div>
                    <div id='brokerContactMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='brokerEditNumberC' style='display: none'></div>
                <button type="button" id='updateBrokerContact' class="btn btn-success">Add Contact</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>