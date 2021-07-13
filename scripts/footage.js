$(document).on("click", '#showFootageList', function () {
    var dataToPost = {};
    dataToPost.SQLFilter = '';
    $.ajax({
        url: "footageList.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#homeScreen').hide();
            $('#eventLog').html('');
            $('#devicesList').html(data);
            $('#vehicleList').html('');
        },
        error: function () {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
        }
    });
});

$(document).on('click', '#footageFilterClicked', function (event) {
    "use strict";
    event.preventDefault();
    var dataToPost = {};
    dataToPost.FilterCustomer = document.getElementById('getCustomerSelect').value;
    dataToPost.FilterType = document.getElementById('byDeviceType').value;
    dataToPost.FilterOtherTerm = document.getElementById('byOther').value;
    dataToPost.SQLFilter = '';
    $.ajax({
        url: 'filterFootage.php',
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            dataToPost.SQLFilter = data;
            $.ajax({
                url: "footageList.php",
                type: "POST",
                data: dataToPost,
                success: function (data) {
                    $('#devicesList').html(data);
                },
                error: function () {
                    $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
                }
            });
        },
        error: function () {

        }
    });
});

