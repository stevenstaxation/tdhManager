
<!-- CHANGE PASSWORD MODAL -->
<div class="modal" id="modalChangePassword" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Change Password</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getCurrentPassword' class='getCurrentPassword form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-sm-4 col-md-4'>
                                <label class='control-label inline' for='theCurrentPassword' style='padding-top:8px;'><strong>Current Password</strong></label>
                            </div>
                            <div class='col-sm-8 col-md-6'>
                                <div class='input-group'>
                                    <input class='form-control' type='password' placeholder="Current Password..." autocomplete='current-password' name='theCurrentPassword' id='theCurrentPassword'>
                                </div>
                            </div>
                        </div>
                        <div class='row mt-4'>
                            <div class='col-sm-4 col-md-4'>
                                <label class='control-label inline' for='newPassword1' style='padding-top:8px;'><strong>New Password</strong></label>
                            </div>
                            <div class='col-sm-8 col-md-6'>
                                <div class='input-group'>
                                    <input class='form-control' type='password' placeholder="New Password..." autocomplete='off' name='newPassword1' id='newPassword1'>
                                </div>
                            </div>
                        </div>
                        <div class='row mt-1'>
                            <div class='col-sm-4 col-md-4'>
                                <label class='control-label inline' for='newPassword2' style='padding-top:8px;'><strong>Confirm Password</strong></label>
                            </div>
                            <div class='col-sm-8 col-md-6'>
                                <div class='input-group'>
                                    <input class='form-control' type='password' placeholder="Confirm Password..." autocomplete='off' name='newPassword2' id='newPassword2'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id='changePasswordMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='updatePasswordButton' class="btn btn-success">Update Password</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>

</div>
