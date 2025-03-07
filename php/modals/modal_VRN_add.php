<div class="modal" id="modalGetNewVRN" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:30%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Add new vehicle</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getNewVRN' class='getNewVRN form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-sm-4 col-md-4'>
                                <label class='control-label inline' for='newVRN' style='padding-top:8px;'><strong>Reg Number</strong></label>
                            </div>
                            <div class='col-sm-8 col-md-6'>
                                <div class='input-group' style='font-family: Charles-Wright-Bold'>
                                    <label for='newVRN' style='width: 20%; margin: 0; background-color:#232F68; color: white; padding-top: 14px; padding-bottom: 7px;'><b style='padding: 0 3px'>&nbsp;GB&nbsp;</b></label>
                                    <input class='form-control' type='text' name='newVRN' id='newVRN' style='text-transform: uppercase; margin: 0; background-color: #F5BD38!important; border: 0; color: #222222!important; font-size:20px; font-weight:900;'>
                                </div>
                            </div>
                            <div class='text-center' style='font-size: 11px; margin-top: 10px; margin-left: 38px;'>Leave blank for TBC</div>
                        </div>
                    </div>
                    <div id='newVRNMessage'></div>
                    <div id='addVRNforCustomer' style='display: hidden'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='addNewVRNToCustomer' class="btn btn-success">Add</button>
            </div>
        </div>
    </div>

</div>