<!-- EDIT DEVICE NOTES DIALOG -->
<div class="modal" id="modalEditDeviceNotes" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:66%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Device Notes</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditDeviceNotes' class='getEditDeviceNotes form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='input-group'>
                                    <textarea rows='10' cols='40' class='form-control' placeholder='Enter note text (max 1,024 characters)...' id='editDeviceNotesText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div id='editDeviceNotesMessage'></div>
                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='hiddenDeviceNotesID' style='display: none'></div>
                <div id='editDeviceNotesID' style='display: none'></div>
                <div id='editDeviceNotesCustomerID' style='display: none'></div>
                <button type="button" id='editCurrentDeviceNotes' onclick='editCurrentDeviceNotes()' class="btn btn-success">Update</button>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>

</div>