<div class="modal" id="modalAddNewInsurerContact" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New insurer contact</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getNewInsurerContact' class='getNewInsurerContact form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactFirstName' style='padding-top:8px;'>
                                    <strong>First Name</strong>
                                </label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter first name..." id='insurerContactFirstName'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactLastName' style='padding-top:8px;'>
                                    <strong>Last Name</strong>
                                </label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter last name..." id='insurerContactLastName' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactMobile' style='padding-top:8px;'>
                                    <strong>Mobile Number</strong>
                                </label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter mobile number..." id='insurerContactMobile'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactTelephone' style='padding-top:8px;'>
                                    <strong>Telephone</strong>
                                </label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter alternate telephone..." id='insurerContactTelephone' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactEmail' style='padding-top:8px;'>
                                    <strong>Email address</strong>
                                </label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter email address..." id='insurerContactEmail' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='insurerContactJobTitle' style='padding-top:8px;'>
                                    <strong>Job Title</strong>
                                </label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter job title..." id='insurerContactJobTitle' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='form-check-label' for='insurerContactFootageRequest' style='padding-top:18px;'>
                                    <strong>Footage Recipient</strong>
                                </label>
                            </div>
                            <div class='col-8'>
                                <input type='checkbox' class='form-check-input' value='checked' id='insurerContactFootageRequest' style='margin: 15px 50px;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='insurerContactMessage'></div>
                </form>
            </div>

            <div class="modal-footer">
                <div id='insurerEditNumber' style='display: none'></div>
                <div id='contactEditNumber' style='display: none'></div>
                <div id='addInsurerContactCaller' style='display: none'></div>
                <button type="button" id='updateInsurerContact' class="btn btn-success">Add Contact</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>