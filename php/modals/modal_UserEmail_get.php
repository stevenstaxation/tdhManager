<!-- GET NEW USER EMAIL ADDRESS -->
<div class="modal" id="modalGetNewUserEmail" data-backdrop='static'>
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style='color:green'>Invite new user</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method='POST' id='getNewUserEmail' class='getNewUserEmail form-block'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-sm-4 col-md-4'>
                                <label class='control-label inline' for='newUserEmailAddress'><strong>Email invite</strong></label>
                            </div>
                            <div class='col-sm-8 col-md-6'>
                                <div class='input-group'>
                                    <input class='form-control' type='email' placeholder="Invitee email address..." name='newUserEmailAddress' id='newUserEmailAddress'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-12'>
                                <label for='userLogInStandard' class='control-label inline'><strong>User Type</strong></label>
                            </div>
                            <div class='col-lg-2 col-md-4 radioList'>
                                <input type='radio' class='form-check-input' id='userLogInStandard' name='userType'>Standard
                            </div>
                            <div class='col-lg-2 col-md-4 radioList'>
                                <input type='radio' class='form-check-input' id='userLogInAdmin' name='userType'>Admin
                            </div>
                            <div class='col-lg-2 col-md-4 radioList'>
                                <input type='radio' class='form-check-input' id='userLogInInstaller' name='userType'>Jobs Admin
                            </div>
                            <div class='col-lg-2 col-md-4 radioList'>
                                <input type='radio' class='form-check-input' id='userLogInEngineer' name='userType'>Engineer
                            </div>
                        </div>
                    </div>
                    <div id='newUserEmailMessage'></div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id='inviteNewUserEmail' class="btn btn-success">Send Invite</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>

</div>