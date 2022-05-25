$(document).on('click', '#updateInsurerContact', function(event) {
    // prevent default PHP processing
    "use strict";
    event.preventDefault();
    // collect user inputs
    var dataToPost = {};
    dataToPost.firstName = document.getElementById('insurerContactFirstName').value;
    dataToPost.lastName = document.getElementById('insurerContactLastName').value;
    dataToPost.mobileNumber = document.getElementById('insurerContactMobile').value;
    dataToPost.telephone = document.getElementById('insurerContactTelephone').value;
    dataToPost.email = document.getElementById('insurerContactEmail').value;
    dataToPost.jobTitle = document.getElementById('insurerContactJobTitle').value;
    dataToPost.footageRec = document.getElementById('insurerContactFootageRequest').checked;
    dataToPost.healthCheck = document.getElementById('insurerContactHealthCheck').checked;
    
    dataToPost.employeeOf = document.getElementById('insurerEditNumber').value;
   

    $.ajax({
        url: "addInsurerContact.php",
        type: "POST",
        data: dataToPost,
        success: function(data) {
            if (data.includes('success')) {
                $('#getClient').trigger('change');
                $('#insurerNameSelection').trigger('change');
                $('#modalAddNewInsurerContact').modal('hide')
            } else {
                $('#insurerContactMessage').html(data);
            }
        },
        error: function() {
            $('#insurerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
        }
    });
});

$(document).on('click', '#updateEditInsurerContact', function(event) {
    // prevent default PHP processing
    "use strict";
    event.preventDefault();
    // collect user inputs
    var dataToPost = {};
    dataToPost.firstName = document.getElementById('editInsurerContactFirstName').value;
    dataToPost.lastName = document.getElementById('editInsurerContactLastName').value;
    dataToPost.mobileNumber = document.getElementById('editInsurerContactMobile').value;
    dataToPost.telephone = document.getElementById('editInsurerContactTelephone').value;
    dataToPost.email = document.getElementById('editInsurerContactEmail').value;
    dataToPost.jobTitle = document.getElementById('editInsurerContactJobTitle').value;
    dataToPost.footageRec = document.getElementById('editInsurerContactFootageRequest').checked;
    dataToPost.healthCheck = document.getElementById('editInsurerContactHealthCheck').checked;
    dataToPost.employeeOf = document.getElementById('editInsurerContactHide').value;

    $.ajax({
        url: "updateInsurerContact.php",
        type: "POST",
        data: dataToPost,
        success: function(data) {
            if (data.includes('success')) {
                $('#getClient').trigger('change');
                $('#insurerNameSelection').trigger('change');
                $('#modalEditInsurerContact').modal('hide')
            } else {
                $('#editInsurerContactMessage').html(data);
            }
        },
        error: function() {
            $('#insurerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
        }
    });
});


$(document).on('show.bs.modal', '#modalAddNewInsurerContact' , function(event) {
    var callerID = $(event.relatedTarget).data('caller');
    $('#addInsureContactCaller').val(callerID);
});

 $(document).on('show.bs.modal', '#modalEditInsurerContact' , function(event) {
     $('#editInsurerContactMessage').html('');
 });



function editInsurerContact(rowNumber) {
    var dataToPost = {};
    dataToPost.contactID = rowNumber;

    $.ajax({
        url: 'editInsurerContact.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            var arr = data.split("^^^");

            document.getElementById('editInsurerContactFirstName').value = arr[1];
            document.getElementById('editInsurerContactLastName').value = arr[2];
            document.getElementById('editInsurerContactMobile').value = arr[3];
            document.getElementById('editInsurerContactTelephone').value = arr[4];
            document.getElementById('editInsurerContactEmail').value = arr[5];
            document.getElementById('editInsurerContactJobTitle').value = arr[6];
            if (arr[7] == 1) {
                document.getElementById('editInsurerContactFootageRequest').checked = true;
            } else {
                document.getElementById('editInsurerContactFootageRequest').checked = false;
            }
            if (arr[8] == 1) {
                document.getElementById('editInsurerContactHealthCheck').checked = true;
            } else {
                document.getElementById('editInsurerContactHealthCheck').checked = false;
            }
                            document.getElementById('insurerEditNumber').value  = arr[0];
            document.getElementById('editInsurerContactHide').value = arr[9];


            $('#modalEditInsurerContact').modal('show');
        },
        error: function() {

        }
    });
}


function deleteInsurerContact() {
    var dataToPost = {};
    dataToPost.contactFirstName = document.getElementById('editInsurerContactFirstName').value;
    dataToPost.contactLastName = document.getElementById('editInsurerContactLastName').value;
    dataToPost.contactNumber = document.getElementById('editInsurerContactHide').value;

   
    new swal ({
        title: "Confirm delete",
        text: "Are you sure you want to delete?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: 'Yes - Delete',
        denyButtonText: 'Cancel',
    }).then ((result) =>{
  
    if (result.isConfirmed) {
        $.ajax({
            url: 'deleteInsurerContact.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if (data.includes('success')) {
                    $('#editInsurerContactMessage').html('');
                    $('#getClient').trigger('change');
                    $('#insurerNameSelection').trigger('change');
                    $('#modalEditInsurerContact').modal('hide');
                } else {
                    $('#editInsurerContactMessage').html(data);
                }
            },
            error: function() {}
        });
    }
});

}
