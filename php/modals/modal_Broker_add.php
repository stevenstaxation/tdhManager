<div class="modal" id="modalAddNewBroker" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Broker</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddBroker' class='getAddBroker form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='100' placeholder="Broker Name..." id='addBrokerName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='addBrokerAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='addBrokerAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='addBrokerAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='addBrokerAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addBrokerAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='14' placeholder="Post code..." id='addBrokerAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='brokerMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addBrokerHide' style='display: none'></div>
                <div id='brokerEditNumber' style='display: none'></div>
                <button type="button" id='addBrokerUpdate' onclick='addNewBroker()' class="btn btn-success">Add</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>