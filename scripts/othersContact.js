$(document).ready(function() {

    $(document).on('click', '#updateOtherContact', function (event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.firstName = document.getElementById('otherContactFirstName').value;
        dataToPost.lastName = document.getElementById('otherContactLastName').value;
        dataToPost.mobileNumber = document.getElementById('otherContactMobile').value;
        dataToPost.telephone = document.getElementById('otherContactTelephone').value;
        dataToPost.email = document.getElementById('otherContactEmail').value;
        dataToPost.department = document.getElementById('otherContactDepartment').value;

        dataToPost.employeeOf = document.getElementById('otherEditNumber').value;


        $.ajax({
            url: "addOtherContact.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {
                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#otherNameSelection').trigger('change');
                    $('#modalAddNewOtherContact').modal('hide');
                 } else {
                    $('#otherContactMessage').html(data);
                }
            },
            error: function () {
                $('#otherContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });



    $(document).on('click', '#updateEditOtherContact', function (event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.firstName = document.getElementById('editOtherContactFirstName').value;
        dataToPost.lastName = document.getElementById('editOtherContactLastName').value;
        dataToPost.mobileNumber = document.getElementById('editOtherContactMobile').value;
        dataToPost.telephone = document.getElementById('editOtherContactTelephone').value;
        dataToPost.email = document.getElementById('editOtherContactEmail').value;
        dataToPost.department = document.getElementById('editOtherContactDepartment').value;
        dataToPost.employeeOf = document.getElementById('editOtherContactHide').value;

        $.ajax({
            url: "updateOtherContact.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {
                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#otherNameSelection').trigger('change');
                    $('#modalEditOtherContact').modal('hide')
                } else {
                    $('#editOtherContactMessage').html(data);
                }
            },
            error: function () {
                $('#otherContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });

    $('#modalAddNewOtherContact').on('shown.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $('#otherContactMessage').html('');
    });


});


function editOtherContact(rowNumber) {
    var dataToPost = {};
    dataToPost.contactID = rowNumber;
    $.ajax({
        url: 'editOtherContact.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            var arr = data.split("^^^");
            document.getElementById('editOtherContactFirstName').value = arr[1];
            document.getElementById('editOtherContactLastName').value = arr[2];
            document.getElementById('editOtherContactMobile').value = arr[3];
            document.getElementById('editOtherContactTelephone').value = arr[4];
            document.getElementById('editOtherContactEmail').value = arr[5];
            document.getElementById('editOtherContactDepartment').value = arr[6];
           
            document.getElementById('editOtherContactHide').value = arr[7];


            $('#modalEditOtherContact').modal('show');
        },
        error: function() {

        }
    });
}

// **************************************************************** 
// DELETE INSTALLER CONTACT WHEN SELECTED FROM EDIT INSTALLER MODAL
// **************************************************************** 

function deleteOtherContact() {
    var dataToPost = {};
    dataToPost.contactFirstName = document.getElementById('editOtherContactFirstName').value;
    dataToPost.contactLastName = document.getElementById('editOtherContactLastName').value;
    dataToPost.contactNumber = document.getElementById('editOtherContactHide').value;

    var proceed = confirm("Are you sure you want to delete the contact " + dataToPost.contactFirstName + " " + dataToPost.contactLastName + "?  This cannot be undone once you click OK");
    if (proceed) {
        $.ajax({
            url: 'deleteOtherContact.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if (data.includes('success')) {
                    $('#editOtherContactMessage').html('');
                    $('#getClient').trigger('change');
                    $('#otherNameSelection').trigger('change');
                    $('#modalEditOtherContact').modal('hide');
                } else {
                    $('#editOtherContactMessage').html(data);
                }
            },
            error: function() {}
        });
    }
}