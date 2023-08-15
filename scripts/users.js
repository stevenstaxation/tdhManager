$(document).on('click', '#updateUserList', function (event) {
    "use strict";
    event.preventDefault();
    var dataListToPost = [];
    var dataToPost = {};
    $('#userList tr').each(function () {
        dataToPost = {};
        dataToPost.userID = $(this).find('.userUpdateID').text();
        dataToPost.isAnAdmin = $(this).find('.isAdministrator').val();
        dataToPost.isActive = $(this).find('.isActivated').val();
        dataToPost.isInstaller = $(this).find('.isInstaller').val();
        dataToPost.isEngineer = $(this).find('.isEngineer').val();
        dataToPost.colour = $(this).find('.engineerColour').val();
        dataListToPost.push(dataToPost);
    });
    dataListToPost = dataListToPost.splice(1, 1000); // this will break if there are more than 999 Users


    $.ajax({
        url: '../php/users/updateUsers.php',
        data: {
            dataListToPost
        },
        type: 'POST',
        success: function (data) {
            if (data.includes('success')) {
                console.log('hello');
                $('#userErrorBox').html('<div class="alert alert-success">Updated successfully.  Changes will be effective after you have logged out and logged back in again.</div>');
                $('#userErrorBox').delay(2500).hide(0);
            } else {
                $('#userErrorBox').html(data);
            }
        },
        error: function () {
            $('#userErrorBox').html('<div class="alert alert-info">An error has occurred.  Error code is 0xF001, your adminsitrator has been notified and will investigate.</div>');
            sendSupportEmail('Error Code 0xF001 in AJAX call to updateUsers.php in users.js, line 20');
        }

    });

});

// When user profile update button is pressed
$(document).on("click", '#updateUser', function (event) {
    event.preventDefault();
    var dataToPost = $('#profileForm').serializeArray();
    darkMode = $('#darkMode').val();
    dataToPost.push({
        name: 'darkMode',
        value: darkMode
    });

    $.ajax({
        url: "../php/users/profile.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            console.log(data);
            if (data.includes('success')) {
                $('#errorBox').html('<div class="alert alert-success">Updated successfully</div>');
                setTimeout(function () {
                    $('#errorBox').html('');
                    showMyAccount();
                }, 4000);
            } else {
                $('#errorBox').html(data);
            }
        },
        error: function () {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, Error code is 0xF002, your adminsitrator has been notified and will investigate.</div>");
            sendSupportEmail('Error Code 0xF002 in AJAX call to profile.php in users.js, line 53');
        }
    });
});





// When close user profile button is pressed
$(document).on("click", '#closeUser', function () {
    location.reload(true);
});

// enable/disable relevant buttons in user profile form
$('#accountInfo').keyup(function () {
    $('#updateUser').prop('disabled', false);
    $('#discardUser').prop('disabled', false);
    $('#closeUser').prop('disabled', true);
});

$(document).on("click", '.form-check-input', function () {
    $('#updateUser').prop('disabled', false);
    $('#discardUser').prop('disabled', false);
    $('#closeUser').prop('disabled', true);
});

$(document).on("click", '#changePassword', function (event) {
    event.preventDefault;
    $('#modalChangePassword').modal('show');
});


$(document).on("click", '#updatePasswordButton', function (event) {
    event.preventDefault();
    var dataToPost = {};
    dataToPost.currentPassword = $('#theCurrentPassword').val();
    dataToPost.newPassword1 = $('#newPassword1').val();
    dataToPost.newPassword2 = $('#newPassword2').val();
    $.ajax({
        url: '../php/users/updatePassword.php',
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            if (data.includes('success')) {
                $('#changePasswordMessage').html('<div class="alert alert-success">Updated successfully.  Changes will take effect after you have logged out and back in again.</div>');
                setTimeout(function () {
                    showMyAccount();
                    $('#changePasswordMessage').html('');
                    $('#modalChangePassword').modal('hide');
                }, 3000);
               
            } else {
                $('#changePasswordMessage').html(data);
            }
        },
        error: function () {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, Error code is 0xF003, your administrator has been notified and will investigate.</div>");
            sendSupportEmail('Error Code 0xF003 in AJAX call to updatePassword.php in users.js, line 101');
        }

    })
});


function sendSupportEmail(message) {
    dataToPost = {};
    dataToPost.message = message;
    dataToPost.timeStamp = new Date();

    $.ajax({
        url: 'sendSupportEmail.php',
        type: 'POST',
        data: dataToPost,
        success: function () {
            return
        }
    });
}