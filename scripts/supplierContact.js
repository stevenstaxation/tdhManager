$(document).ready(function() {

    $(document).on('click', '#updateSupplierContact', function (event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.firstName = document.getElementById('supplierContactFirstName').value;
        dataToPost.lastName = document.getElementById('supplierContactLastName').value;
        dataToPost.mobileNumber = document.getElementById('supplierContactMobile').value;
        dataToPost.telephone = document.getElementById('supplierContactTelephone').value;
        dataToPost.email = document.getElementById('supplierContactEmail').value;
        dataToPost.department = document.getElementById('supplierContactDepartment').value;

        dataToPost.employeeOf = document.getElementById('supplierEditNumber').value;


        $.ajax({
            url: "addSupplierContact.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {

                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#supplierNameSelection').trigger('change');
                    $('#modalAddNewSupplierContact').modal('hide');
                 } else {
                    $('#supplierContactMessage').html(data);
                }
            },
            error: function () {
                $('#supplierContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });



    $(document).on('click', '#updateEditSupplierContact', function (event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.firstName = document.getElementById('editSupplierContactFirstName').value;
        dataToPost.lastName = document.getElementById('editSupplierContactLastName').value;
        dataToPost.mobileNumber = document.getElementById('editSupplierContactMobile').value;
        dataToPost.telephone = document.getElementById('editSupplierContactTelephone').value;
        dataToPost.email = document.getElementById('editSupplierContactEmail').value;
        dataToPost.department = document.getElementById('editSupplierContactDepartment').value;
        dataToPost.employeeOf = document.getElementById('editSupplierContactHide').value;

        $.ajax({
            url: "updateSupplierContact.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {
                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#supplierNameSelection').trigger('change');
                    $('#modalEditSupplierContact').modal('hide')
                } else {
                    $('#editSupplierContactMessage').html(data);
                }
            },
            error: function () {
                $('#supplierContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });

    $('#modalAddNewSupplierContact').on('shown.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $('#supplierContactMessage').html('');
    });


});


function editSupplierContact(rowNumber) {
    var dataToPost = {};
    dataToPost.contactID = rowNumber;

    $.ajax({
        url: 'editSupplierContact.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            var arr = data.split("^^^");

            document.getElementById('editSupplierContactFirstName').value = arr[1];
            document.getElementById('editSupplierContactLastName').value = arr[2];
            document.getElementById('editSupplierContactMobile').value = arr[3];
            document.getElementById('editSupplierContactTelephone').value = arr[4];
            document.getElementById('editSupplierContactEmail').value = arr[5];
            document.getElementById('editSupplierContactDepartment').value = arr[6];
           
            document.getElementById('editSupplierContactHide').value = arr[7];


            $('#modalEditSupplierContact').modal('show');
        },
        error: function() {

        }
    });
}

// **************************************************************** 
// DELETE INSTALLER CONTACT WHEN SELECTED FROM EDIT INSTALLER MODAL
// **************************************************************** 

function deleteSupplierContact() {
    var dataToPost = {};
    dataToPost.contactFirstName = document.getElementById('editSupplierContactFirstName').value;
    dataToPost.contactLastName = document.getElementById('editSupplierContactLastName').value;
    dataToPost.contactNumber = document.getElementById('editSupplierContactHide').value;

    swal ({
        title: "Confirm delete",
        text: "Are you sure you want to delete?",
        icon: "warning",
        buttons: ['Cancel', 'Yes - Delete'],
        dangerMode: true,
    }).then (function(isConfirm){
  
    if (isConfirm) {
        $.ajax({
            url: 'deleteSupplierContact.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if (data.includes('success')) {
                    $('#editSupplierContactMessage').html('');
                    $('#getClient').trigger('change');
                    $('#supplierNameSelection').trigger('change');
                    $('#modalEditSupplierContact').modal('hide');
                } else {
                    $('#editSupplierContactMessage').html(data);
                }
            },
            error: function() {}
        });
    }
    });
}