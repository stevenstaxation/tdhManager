<!-- EDIT CUSTOMER NOTE -->
<div class="modal" id="modalEditCustomerNote" data-backdrop='static'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit customer note</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='editCustomerNote' class='editCustomerNote form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-3'>
                                <label class='control-label inline' for='noteEditDate' style='width: 40%; padding-top:8px;'><strong>Date</strong></label>
                            </div>
                            <div class='col-9'>
                                <div class='input-group'>
                                    <input class='form-control dateType' type='datetime' name='noteEditDate' id='noteEditDate' readonly='readonly' min='<?php echo date("Y-m-d\TH:i"); ?>' value='<?php echo date("Y-m-d\TH:i"); ?>'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-3'>
                                <label class='control-label inline' for='noteEditText' style='padding-top:8px;'><strong>Note Text</strong></label>
                            </div>
                            <div class='col-9'>
                                <div class='input-group'>
                                    <textarea rows='24' cols='60' class='form-control' placeholder='Enter note text (max 2,048 characters)...' id='noteEditText' style='margin-top:3px;'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='row' style='margin-top: 20px'>
                            <div class='col-3'>
                                <label for='noteUserNameInput' class='control-label inline' style='font-size: 75%; padding-top:8px;'><strong>Original note by</strong></label>
                            </div>
                            <div class='col-9'>
                                <p id='noteUserName'></p>
                                <input type='text' id='noteUserNameInput' style='display: none'>
                            </div>
                        </div>
                        <div class='row' style='margin-top: 20px;'>
                            <div class='col-4'>
                                <label class='control-label inline' for='isImportantEditNote' style='font-size: 75%; padding-top:8px;'><strong>Mark as important</strong></label>
                            </div>
                            <div class='col-2'>
                                <input type='checkbox' class='form-check-input' value='checked' id='isImportantEditNote' style='margin: 5px 0;padding: 10px 10px;'>
                            </div>
                            <div class='col-4'>
                                <label class='control-label inline' for='createEditAlert' style='font-size: 75%; padding-top:8px;'><strong>Create an alert</strong></label>
                            </div>
                            <div class='col-2'>
                                <input type='checkbox' class='form-check-input' value='checked' id='createEditAlert' style='margin: 5px 0;padding: 10px 10px;'>
                            </div>
                        </div>
                    </div>
                    <div id='noteEditMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div id='customerEditNumber' style='display: none'></div>
                <div id='noteEditNumber' style='display: none'></div>
                <div id='noteEditUser' style='display: none'></div>
                <button type="button" id='updateCustomerNoteEdit' onclick='updateNote()' class="btn btn-success">Update Note</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>