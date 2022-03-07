$(document).ready(function () {

    $(document).on('click', '#updateInstallerContact', function (event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.firstName = document.getElementById('installerContactFirstName').value;
        dataToPost.lastName = document.getElementById('installerContactLastName').value;
        dataToPost.mobileNumber = document.getElementById('installerContactMobile').value;
        dataToPost.telephone = document.getElementById('installerContactTelephone').value;
        dataToPost.email = document.getElementById('installerContactEmail').value;
        dataToPost.department = document.getElementById('installerContactJobTitle').value;


        dataToPost.employeeOf = document.getElementById('installerEditNumber').value;


        $.ajax({
            url: "addInstallerContact.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {
                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#installerNameSelection').trigger('change');
                    $('#modalAddNewInstallerContact').modal('hide')
                } else {
                    $('#installerContactMessage').html(data);
                }
            },
            error: function () {
                $('#installerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });


    $(document).on('click', '#updateEditInstallerContact', function (event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.firstName = document.getElementById('editInstallerContactFirstName').value;
        dataToPost.lastName = document.getElementById('editInstallerContactLastName').value;
        dataToPost.mobileNumber = document.getElementById('editInstallerContactMobile').value;
        dataToPost.telephone = document.getElementById('editInstallerContactTelephone').value;
        dataToPost.email = document.getElementById('editInstallerContactEmail').value;
        dataToPost.jobTitle = document.getElementById('editInstallerContactJobTitle').value;
        dataToPost.employeeOf = document.getElementById('editInstallerContactHide').value;

        $.ajax({
            url: "updateInstallerContact.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {
                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#installerNameSelection').trigger('change');
                    $('#modalEditInstallerContact').modal('hide')
                } else {
                    $('#editInstallerContactMessage').html(data);
                }
            },
            error: function () {
                $('#installerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });

    $('#modalAddNewInstallerContact').on('shown.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $('#installerContactMessage').html('');
    });

});

function editInstallerContact(rowNumber) {
    var dataToPost = {};
    dataToPost.contactID = rowNumber;

    $.ajax({
        url: 'editInstallerContact.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            var arr = data.split("^^^");

            document.getElementById('editInstallerContactFirstName').value = arr[1];
            document.getElementById('editInstallerContactLastName').value = arr[2];
            document.getElementById('editInstallerContactMobile').value = arr[3];
            document.getElementById('editInstallerContactTelephone').value = arr[4];
            document.getElementById('editInstallerContactEmail').value = arr[5];
            document.getElementById('editInstallerContactJobTitle').value = arr[6];

            document.getElementById('editInstallerContactHide').value = arr[7];


            $('#modalEditInstallerContact').modal('show');
        },
        error: function () {

        }
    });
}

// **************************************************************** 
// DELETE INSTALLER CONTACT WHEN SELECTED FROM EDIT INSTALLER MODAL
// **************************************************************** 

function deleteInstallerContact() {
    var dataToPost = {};
    dataToPost.contactFirstName = document.getElementById('editInstallerContactFirstName').value;
    dataToPost.contactLastName = document.getElementById('editInstallerContactLastName').value;
    dataToPost.contactNumber = document.getElementById('editInstallerContactHide').value;

    swal ({
        title: "Confirm delete",
        text: "Are you sure you want to delete?",
        icon: "warning",
        buttons: ['Cancel', 'Yes - Delete'],
        dangerMode: true,
    }).then (function(isConfirm){
  
    if (isConfirm) {
        $.ajax({
            url: 'deleteInstallerContact.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                if (data.includes('success')) {
                    $('#editInstallerContactMessage').html('');
                    $('#getClient').trigger('change');
                    $('#installerNameSelection').trigger('change');
                    $('#modalEditInstallerContact').modal('hide');
                } else {
                    $('#editInstallerContactMessage').html(data);
                }
            },
            error: function () {}
        });
    } 
    });
}