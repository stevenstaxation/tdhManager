<!-- ADD NEW CUSTOMER NOTE -->
<div class="modal" id="modalAddNewNote" data-backdrop='static'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New customer note</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getNewCustomerNote' class='getNewCustomerNote form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-sm-4 col-xl-3'>
                                <label class='control-label inline' for='noteDate' style='width: 40%; padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-sm-8 col-xl-9'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='datetime-local' name='noteDate' id='noteDate' min='<?php echo date("Y-m-d\TH:i"); ?>' value='<?php echo date("Y-m-d\TH:i"); ?>'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-4 col-xl-3'>
                                <label class='control-label inline' for='noteText' style='padding-top:8px;'><strong>Note Text</strong></label>
                            </div>
                            <div class='col-sm-8 col-xl-9'>
                                <div class='input-group'>
                                    <textarea rows='24' cols='64' class='form-control' placeholder='Enter note text (max 2,048 characters)...' id='noteText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='row' style='margin-top: 20px;'>
                            <div class='col-sm-4 col-xl-3'>
                                <label class='control-label inline' for='isImportantNote' style='font-size: 75%; padding-top:8px;'><strong>Mark as important</strong></label>
                            </div>
                            <div class='col-2'>
                                <input type='checkbox' class='form-check-input' value='checked' id='isImportantNote' style='margin: 5px 0;padding: 10px 10px;'>
                            </div>
                            <div class='col-sm-4 col-xl-3'>
                                <label class='control-label inline' for='createAlert' style='font-size: 75%; padding-top:8px;'><strong>Create an alert</strong></label>
                            </div>
                            <div class='col-2'>
                                <input type='checkbox' class='form-check-input' value='checked' id='createAlert' style='margin: 5px 0;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='noteMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='updateCustomerNote' class="btn btn-success">Add Note</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
