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
        console.log(dataToPost);
        dataListToPost.push(dataToPost);
    });
    dataListToPost = dataListToPost.splice(1, 1000); // this will break if there are more than 999 Users


    $.ajax({
        url: 'updateUsers.php',
        data: {
            dataListToPost
        },
        type: 'POST',
        success: function (data) {
            if (data.includes('success')) {
                $('#userErrorBox').html('<div class="alert alert-success">Updated successfully</div>');
                $('#userErrorBox').delay(2500).hide(0);
                // $('#userErrorBox').show();
            } else {
                $('#userErrorBox').html(data);
                // $('#userErrorBox').show();
            }
        },
        error: function () {}

    });

});

// When user profile update button is pressed
$(document).on("click", '#updateUser', function () {
    var dataToPost = $('#profileForm').serializeArray();
    darkMode = $('#darkMode').val();
    gender = $('#genderHidden').val();
    dataToPost.push({
        name: 'darkMode',
        value: darkMode
    });
    dataToPost.push({
        name: 'gender',
        value: gender
    });

    // send to profile.php using AJAX
    // to check input and update
    $.ajax({
        url: "profile.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            if (data.includes('success')) {
                showMyAccount();
            } else {
                $('#errorBox').html(data);
            }
        },
        error: function () {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
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

$(document).on("click", '.gender_radio', function () {
    $('#updateUser').prop('disabled', false);
    $('#discardUser').prop('disabled', false);
    $('#closeUser').prop('disabled', true);
});

$(document).on("click", '.form-check-input', function () {
    $('#updateUser').prop('disabled', false);
    $('#discardUser').prop('disabled', false);
    $('#closeUser').prop('disabled', true);
});

$(document).on("click", '.date-type', function () {
    $('#updateUser').prop('disabled', false);
    $('#discardUser').prop('disabled', false);
    $('#closeUser').prop('disabled', true);
});
//