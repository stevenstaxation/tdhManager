<!-- OTHER PARTNER DIALOGS -->
<!-- ADD OTHER DIALOG -->
<div class="modal" id="modalAddNewOther" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Other Partner</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getAddOther' class='getAddOther form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherName' style='padding-top:8px;'><strong>Name</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Other Name..." id='addOtherName'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress1' style='padding-top:10px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 1..." id='addOtherAddress1' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress2' style='padding-top:12px;'><strong>Address</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Address line 2..." id='addOtherAddress2' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress3' style='padding-top:14px;'><strong>Town/City</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Town/City..." id='addOtherAddress3' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress4' style='padding-top:16px;'><strong>County</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="County..." id='addOtherAddress4' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherAddress5' style='padding-top:18px;'><strong>Post Code</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Post Code..." id='addOtherAddress5' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='addOtherService' style='padding-top:20px;'><strong>Description/Service</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' maxlength='50' placeholder="Description/Service..." id='addOtherService' style='margin-top:3px;'>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                    <div id='otherMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='addOtherHide' style='display: none'></div>
                <div id='otherEditNumber' style='display: none'></div>
                <div id='contactEditOtherNumber' style='display: none'></div>
                <div id='addOtherContactCaller' style='display: none'></div>
                <button type="button" id='addOtherUpdate' onclick='addNewOther()' class="btn btn-success">Add</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
