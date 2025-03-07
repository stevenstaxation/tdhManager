<div class="modal" id="modalEditVehicleNotes" data-backdrop='static'>
    <div class="modal-dialog" style='max-width:66%'>
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Vehicle Notes</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style='font-size: 75%'>
                <form method='POST' id='getEditVehicleNotes' class='getEditVehicleNotes form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='input-group'>
                                    <textarea rows='10' cols='40' class='form-control' placeholder='Enter note text (max 1,024 characters)...' id='editVehicleNotesText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div id='editVehicleNotesMessage'></div>
                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='hiddenVehicleNotesID' style='display: none'></div>
                <div id='editVehicleNotesID' style='display: none'></div>
                <div id='editVehicleCustomerID' style='display: none'></div>
                <button type="button" id='editCurrentVehicleNotes' onclick='editCurrentVehicleNotes()' class="btn btn-success">Update</button>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>

</div>