<!-- EDIT BROKER DIALOG -->
<div class="modal" id="modalEditBroker" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Broker</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditBroker' class='getEditBroker form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='100' placeholder="Broker Name..." id='editBrokerName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress1' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='editBrokerAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress2' style='padding-top:8px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='editBrokerAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress3' style='padding-top:8px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='editBrokerAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress4' style='padding-top:8px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='editBrokerAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='editBrokerAddress5' style='padding-top:8px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='14' placeholder="Post code..." id='editBrokerAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='editBrokerMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='editBrokerHide' style='display: none'></div>
                <button type="button" id='editBrokerUpdate' onclick='updateEditBroker()' class="btn btn-success">Update</button> <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>