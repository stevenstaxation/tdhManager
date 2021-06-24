// LOG OUT
$('#logOut').on('click', function () {
    $.ajax({
        url: "logOut.php",
        type: "GET",
        success: function () {
            window.location.href = "index.php";
        },
        error: function () {
            window.location.href = "index.php";
        }
    });
});

// INVITE NEW USER

$(document).on('click', '#inviteNewUser', function (event) {
    event.preventDefault();
    $('#modalGetNewUserEmail').modal('show');
});

$(document).on('click', '#inviteNewUserEmail', function (event) {
    event.preventDefault();
    dataToPost = {};
    dataToPost.newUserEmail = $('#newUserEmailAddress').val();

    $.ajax({
        url: 'inviteNewUser.php',
        type: 'POST',
        data: dataToPost,
        success: function (data) {
            if (data.includes('An invitation email has been sent to')) {
                $('#modalGetNewUserEmail').modal('hide');
                $('#userErrorBox').html(data);
                $('#userErrorBox').delay(2500).hide(0);
            } else {
                $('#newUserEmailMessage').html(data);
            }
        },
        error: function () {

        }
    });
});

// TOGGLE DARK MODE
    $(document).on('click', '#companyLogo', function () {
        $.ajax({
            url: 'toggleDarkMode.php',
            type: 'POST',
            success: function (data) {
                if (data.includes('success')) {
                    setDarkMode();
                }
            }
        });
    });


$('#myAccount').on('click', function () {
    showMyAccount();
});