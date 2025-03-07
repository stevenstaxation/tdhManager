

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
                VRNHTML += `<option value = '${data['VRNID'][x]}'>${data['VRN'][x]}</option>`;
            }
                VRNHTML += "</select>";
            $('#footageVRNList').html(VRNHTML);

            var contactsHTML = "<table class='table table-sm table-scrollable'><thead><tr><th>Contact Name</th><th>Email Address</th><th>Type</th><th>Sent</th></tr></thead><tbody>";

            for (var x=0; x < data['customerContactsEmail'].length; x++) {
                contactsHTML += "<tr>";
                contactsHTML += `<td>${data['customerContactsFullName'][x]}</td>`;
                contactsHTML += `<td>${data['customerContactsEmail'][x]}</td>`;
                contactsHTML += "<td>Customer</td>";
                contactsHTML += "<td><input type='checkbox'></td>";
                contactsHTML += "</tr>";
            }
            for (var x=0; x < data['insurerContactsEmail'].length; x++) {
                contactsHTML += "<tr>";
                contactsHTML += `<td>${data['insurerContactsFullName'][x]}</td>`;
                contactsHTML += `<td>${data['insurerContactsEmail'][x]}</td>`;
                contactsHTML += "<td>Insurer</td>";
                contactsHTML += "<td><input type='checkbox'></td>";
                contactsHTML += "</tr>";
            }
            for (var x=0; x < data['brokerContactsEmail'].length; x++) {
                contactsHTML += "<tr>";
                contactsHTML += `<td>${data['brokerContactsFullName'][x]}</td>`;
                contactsHTML += `<td>${data['brokerContactsEmail'][x]}</td>`;
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


function showFullFootage(rowNumber) {
    var dataToPost = {};
    dataToPost.footageCustomer = $('#hiddenCustomerID').text();
    dataToPost.footageID = rowNumber;
    $.ajax({
        url: "getFootageDropDowns.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function(data) {
            data = $.parseJSON(data);

            var VRNHTML= "<select id='getFootageVRN' name='getFootageVRN' class='custom-select getFootageVRN'>";
            for (var x=0; x < data['VRN'].length; x++) {
                if (data['selectedVehicle'] == data['VRNID'][x]) {
                    VRNHTML += `<option value = '${data['VRNID'][x]}' selected>${data['VRN'][x]}</option>`;
                } else {
                    VRNHTML += `<option value = '${data['VRNID'][x]}'>${data['VRN'][x]}</option>`;
                }
            }
                VRNHTML += "</select>";
            $('#footageEditVRNList').html(VRNHTML);

            var filePathHTML = '';''
            for (x = 0; x < data['filePath'].length; x++) {
                filePathHTML += "<tr>";
                filePathHTML += `<td>${data['filePath'][x]}</td>`;
                filePathHTML += "<td><btn class= 'btn btn-success btn-sm' id='footageInfo'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info' viewBox='0 0 16 16'><path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg></btn></td>";
                filePathHTML += "<td><btn class= 'btn btn-danger btn-sm' id='footageRemove'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/></svg></btn></td>";
                filePathHTML += "</tr>";
            }
            $('#footageEditFileTableBody').append(filePathHTML);

            var contactsHTML = "<table class='table table-sm table-scrollable'><thead><tr><th>Contact Name</th><th>Email Address</th><th>Type</th><th>Sent</th></tr></thead><tbody>";

            for (var x=0; x < data['footageContactEmail'].length; x++) {
                contactsHTML += "<tr>";
                contactsHTML += `<td>${data['footageContactName'][x]}</td>`;
                contactsHTML += `<td>${data['footageContactEmail'][x]}</td>`;
                contactsHTML += `<td>${data['footageContactType'][x]}</td>`;
            if (data['footageContactSent'][x] == 1) {
                contactsHTML += "<td><input type='checkbox' checked></td>";
            } else {
                contactsHTML += "<td><input type='checkbox'></td>";
            }
                contactsHTML += "</tr>";
            }
           contactsHTML += "</tbody></table>"


        $('#footageEditRecipientsList').html(contactsHTML);

        },
        error: function() {

        }
    });

    dataToPost.footageID = rowNumber;
    $.ajax({
        url: "getCurrentFootage.php",
        timeout: 30000,
        data: dataToPost,
        datatype: "json",
        type: "POST",
        success: function(data) {
           data = $.parseJSON(data);
            document.getElementById('footageEditIncidentDate').value = data['incidentDate'].replace(' ','T');
            document.getElementById('footageEditCustomerID').value = data['businessName'];
            document.getElementById('footageEditClaimReference').value = data['claimRef'];
            document.getElementById('footageEditRequestDate').value = data['requestDateTime'].replace(' ','T');
            document.getElementById('footageEditRequestNotes').value = data['requestNotes'];
            if (data['responseDateTime']!=null) {
                data['responseDateTime'] = data['responseDateTime'].replace(' ','T');
            }
            document.getElementById('footageEditResponseDate').value = data['responseDateTime'];
            document.getElementById('footageEditTDHEmployee').value = data['userID'];
            document.getElementById('footageEditResponseNotes').value = data['responseText'];
            document.getElementById('footageEditCurrentStatusList').value = data['statusID'];
            document.getElementById('hiddenFootageID').value = rowNumber;
            document.getElementById('editFootageOwnerID').value = data['ID'];

            $('#modalEditFootage').modal('show');
        },
        error: function() {

        }
    })
}

function editCurrentFootage() {
    var dataToPost = {};
    dataToPost.footageID = document.getElementById('hiddenFootageID').value;
    dataToPost.ownerID = document.getElementById('editFootageOwnerID').value;
    dataToPost.incidentDate = document.getElementById('footageEditIncidentDate').value;
    dataToPost.vehicleID = document.getElementById('getFootageVRN').value;
    dataToPost.claimReference = document.getElementById('footageEditClaimReference').value;
    dataToPost.requestDate = document.getElementById('footageEditRequestDate').value;
    dataToPost.requestNotes = document.getElementById('footageEditRequestNotes').value;
    dataToPost.responseDate = document.getElementById('footageEditResponseDate').value;
    dataToPost.allocatedTo = document.getElementById('footageEditTDHEmployee').value;
    dataToPost.responseNotes = document.getElementById('footageEditResponseNotes').value;
    dataToPost.requestStatus = document.getElementById('footageEditCurrentStatusList').value;

    $.ajax({
        url: 'updateEditFootage.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function(data) {
            if (data.includes("success")) {
                $('#editFootageMessage').html('');
                $('#getClient').trigger('change');
                $('#modalEditFootage').modal('hide');

                $.ajax({
                    url: 'getAlerts.php',
                    type: 'GET',
                    success: function(data) {
                        var arr = data.split('^^^');

                        if ((arr[0] + arr[1]) != 0) {
                            $('#renewalTotal').html(+arr[0] + +arr[1]);
                            $('#renewalTotalWrapper').show();
                        } else {
                            $('#renewalTotalWrapper').hide();
                        }
                        if (arr[3] != 0) {
                            $('#installTotal').html(arr[3]);
                            $('#installTotalWrapper').show();
                        } else {
                            $('#installTotalWrapper').hide();
                        }
                        if (arr[2] != 0) {
                            $('#alertTotal').html(arr[2]);
                            $('#alertTotalWrapper').show();
                        } else {
                            $('#alertTotalWrapper').hide();
                        }
                    }
                });
            } else {
                $('#editFootageMessage').html(data);
            }
        },
        error: function() {

        }
    });

    // get file names from table, then pass them to PHP to add to table
    var fileNames = [];
    var table = $("#footageEditFileTableBodyBlock");
    table.find('tr').each(function(i) {
        var tds = $(this).find('td');
        fileName = tds.eq(0).text();
        fileNames.push(fileName);
    })

    var dataToPost = {};
    dataToPost.fileNames = fileNames;
    dataToPost.requestID = document.getElementById('hiddenFootageID').value;
    $.ajax ({
        url: "updateUploads.php",
        type: "POST",
        data: dataToPost,
        success: function(data) {
            // console.log(data);
        }
    });
}

function addNewFootage() {
    var dataToPost = {};
    dataToPost = $('#getAddNewFootage').serializeArray();

    var FileList = [];
    $('#footageFileTableBody tr').each(function() {
        $(this).find('td').each(function () {
            FileList.push($(this).text());
        });
    });
    var ContactList = [];
    $('#footageRecipientsList tr').each(function() {
        $(this).find('td').each(function () {
            if ($(this).find('input[type="checkbox"]').is(':checked')) {
                ContactList.push("checked");
            } else {
                ContactList.push($(this).text());
            }
        });
    });

    dataToPost.push({
        name: 'fileList',
        value: FileList
    });
    dataToPost.push({
        name: 'contactList',
        value: ContactList
    });

    $.ajax ({
        url: "addNewFootageRequest.php",
        timeout: 30000,
        type: "POST",
        data: dataToPost,
        success: function(data) {
            if (data.includes('success')) {
                var newID = parseInt(data.replace("success",''),10);
                $('#getClient').trigger('change');
                showCustomers(newID);
                $('#modalAddNewFootage').modal('hide');
                var dataToPost = {};
                dataToPost.selectedValue = newID;

                $.ajax({
                    url: 'customers.php',
                    type: 'POST',
                    data: dataToPost,
                    success: function(data) {
                        $('#customerInfo').html(data);
                    },
                    error: function() {}
                });
            } else {
                $('#addFootageMessage').html(data);
            }
        },
        error: function() {

        }
    });
}


