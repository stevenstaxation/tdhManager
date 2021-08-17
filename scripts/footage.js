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

function populateFootageBox() {
    var dataToPost = {};
    dataToPost.customerID = $('#hiddenCustomerID').text();
    $.ajax({
        url: 'getFootageInfo.php',
        timeout: 30000,
        data: dataToPost,
        // datatype: "json",
        type: "POST",
        success: function(data) {
            data = $.parseJSON(data);


            if (data=='nodevices') {
                swal ("Cannot add footage request','There are no devices registered for this client', 'info'");
            } else {

            $('#footageCustomerID').val(data['customerName']);
            var VRNHTML= "<select id='getFootageVRN' name='getFootageVRN' class='custom-select getFootageVRN'>";
            for (var x=0; x < data['VRN'].length; x++) {
                VRNHTML += "<option value = '" + data['VRNID'][x] + "'>" + data['VRN'][x] + "</option>";
            }
                VRNHTML += "</select>";
            $('#footageVRNList').html(VRNHTML);

            var contactsHTML = "<table class='table table-sm table-scrollable'><thead><tr><th>Contact Name</th><th>Email Address</th><th>Type</th><th>Sent</th></tr></thead><tbody>";

            for (var x=0; x < data['customerContactsEmail'].length; x++) {
                contactsHTML += "<tr>";
                contactsHTML += "<td>" + data['customerContactsFullName'][x] + "</td>";
                contactsHTML += "<td>" + data['customerContactsEmail'][x] + "</td>";
                contactsHTML += "<td>Customer</td>";
                contactsHTML += "<td><input type='checkbox'></td>";
                contactsHTML += "</tr>";
            }
            for (var x=0; x < data['insurerContactsEmail'].length; x++) {
                contactsHTML += "<tr>";
                contactsHTML += "<td>" + data['insurerContactsFullName'][x] + "</td>";
                contactsHTML += "<td>" + data['insurerContactsEmail'][x] + "</td>";
                contactsHTML += "<td>Insurer</td>";
                contactsHTML += "<td><input type='checkbox'></td>";
                contactsHTML += "</tr>";
            }
            for (var x=0; x < data['brokerContactsEmail'].length; x++) {
                contactsHTML += "<tr>";
                contactsHTML += "<td>" + data['brokerContactsFullName'][x] + "</td>";
                contactsHTML += "<td>" + data['brokerContactsEmail'][x] + "</td>";
                contactsHTML += "<td>Broker</td>";
                contactsHTML += "<td><input type='checkbox'></td>";
                contactsHTML += "</tr>";
            }

                contactsHTML += "</tbody></table>"


            $('#footageRecipientsList').html(contactsHTML);

            $('#modalAddNewFootage').modal('show');
            }
        },
        error: function() {
        }
    });
}
