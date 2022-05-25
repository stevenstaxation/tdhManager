$(document).ready(function () {

    $(document).on('click', '#updateBrokerContact', function (event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.firstName = document.getElementById('brokerContactFirstName').value;
        dataToPost.lastName = document.getElementById('brokerContactLastName').value;
        dataToPost.mobileNumber = document.getElementById('brokerContactMobile').value;
        dataToPost.telephone = document.getElementById('brokerContactTelephone').value;
        dataToPost.email = document.getElementById('brokerContactEmail').value;
        dataToPost.department = document.getElementById('brokerContactDepartment').value;
        dataToPost.footageRec = document.getElementById('brokerContactFootageRequest').checked;
        dataToPost.healthCheck = document.getElementById('brokerContactHealthCheck').checked;
        dataToPost.employeeOf = document.getElementById('brokerEditNumber').value;


        $.ajax({
            url: "addBrokerContact.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {
                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#brokerNameSelection').trigger('change');
                    $('#modalAddNewBrokerContact').modal('hide')
                } else {
                    $('#brokerContactMessage').html(data);
                }
            },
            error: function () {
                $('#brokerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });


    $(document).on('click', '#updateEditBrokerContact', function (event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.firstName = document.getElementById('editBrokerContactFirstName').value;
        dataToPost.lastName = document.getElementById('editBrokerContactLastName').value;
        dataToPost.mobileNumber = document.getElementById('editBrokerContactMobile').value;
        dataToPost.telephone = document.getElementById('editBrokerContactTelephone').value;
        dataToPost.email = document.getElementById('editBrokerContactEmail').value;
        dataToPost.department = document.getElementById('editBrokerContactDepartment').value;
        dataToPost.footageRec = document.getElementById('editBrokerContactFootageRequest').checked;
        dataToPost.healthCheck = document.getElementById('editBrokerContactHealthCheck').checked;
        dataToPost.employeeOf = document.getElementById('editBrokerContactHide').value;

        $.ajax({
            url: "updateBrokerContact.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {
                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#brokerNameSelection').trigger('change');
                    $('#modalEditBrokerContact').modal('hide')
                } else {
                    $('#editBrokerContactMessage').html(data);
                }
            },
            error: function () {
                $('#brokerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });

    $('#modalAddNewBrokerContact').on('shown.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $('#brokerContactMessage').html('');
    });

});

function editBrokerContact(rowNumber) {
    var dataToPost = {};
    dataToPost.contactID = rowNumber;

    $.ajax({
        url: 'editBrokerContact.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            var arr = data.split("^^^");

            document.getElementById('editBrokerContactFirstName').value = arr[1];
            document.getElementById('editBrokerContactLastName').value = arr[2];
            document.getElementById('editBrokerContactMobile').value = arr[3];
            document.getElementById('editBrokerContactTelephone').value = arr[4];
            document.getElementById('editBrokerContactEmail').value = arr[5];
            document.getElementById('editBrokerContactDepartment').value = arr[6];

            if (arr[7] == 1) {
                document.getElementById('editBrokerContactFootageRequest').checked = true;
            } else {
                document.getElementById('editBrokerContactFootageRequest').checked = false;
            }
            if (arr[8] == 1) {
                document.getElementById('editBrokerContactHealthCheck').checked = true;
            } else {
                document.getElementById('editBrokerContactHealthCheck').checked = false;
            }
            document.getElementById('brokerEditNumber').value = arr[0];
            document.getElementById('editBrokerContactHide').value = arr[9];


            $('#modalEditBrokerContact').modal('show');
        },
        error: function () {

        }
    });
}

// **************************************************************** 
// DELETE INSTALLER CONTACT WHEN SELECTED FROM EDIT INSTALLER MODAL
// **************************************************************** 

function deleteBrokerContact() {
    var dataToPost = {};
    dataToPost.contactFirstName = document.getElementById('editBrokerContactFirstName').value;
    dataToPost.contactLastName = document.getElementById('editBrokerContactLastName').value;
    dataToPost.contactNumber = document.getElementById('editBrokerContactHide').value;

    new swal ({
        title: "Confirm delete",
        text: "Are you sure you want to delete?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: 'Yes - Delete',
        denyButtonText: 'Cancel',
    }).then ((result) => {
  
    if (result.isConfirmed) {
        $.ajax({
            url: 'deleteBrokerContact.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                if (data.includes('success')) {
                    $('#editBrokerContactMessage').html('');
                    $('#getClient').trigger('change');
                    $('#brokerNameSelection').trigger('change');
                    $('#modalEditBrokerContact').modal('hide');
                } else {
                    $('#editBrokerContactMessage').html(data);
                }
            },
            error: function () {}
        });
    }
    });
}
