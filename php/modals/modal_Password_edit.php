
<!-- CHANGE PASSWORD MODAL -->
<div class="modal" id="modalChangePassword" data-backdrop='static'>
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Change Password</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form class='form-block' id='getPasswords'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='oldPassword' style='padding-top:8px;'><strong>Current Password</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter old  password..." id='oldPassword' autocomplete='current-password'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='control-label' for='newPassword'><strong>New Password</strong></label>
                            </div>
                            <div class='col-8'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' placeholder="Enter new password..." id='newPassword' autocomplete='new-password'>
                                </div>
                            </div>
                            <label class='control-label' for='newPassword2' style='padding-top:10px;'><strong>Confirm Password</strong></label>
                            <div class='input-group'>
                                <input type='text' class='form-control' placeholder="Re-enter new password..." id='newPassword2' autocomplete='new-password'>
                            </div>
                        </div>
                    </div>
                    <div id='PasswordMessage'></div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='updatePassword' onclick='updatePassword();' class="btn btn-success">Update</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>