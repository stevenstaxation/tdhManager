// ******************************
// SHOW PARTNERS >> SUPPLIERS PAGE
// ******************************
$(document).on('click', '#showSuppliers', function () {
    $.ajax({
        url: "supplierList.php",
        type: "POST",
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#eventLog').html('');
            $('#homeScreen').html('');
            $('#devicesList').html(data);
            $('#supplierNameSelection option:first').attr('selected', 'selected');
            $('#supplierNameSelection').trigger('change');
            $('#vehicleList').html('');
        },
        error: function () {

        }
    })
});



// $('#modalAddNewSupplier').on('hidden.bs.modal', function () {
//     $(this).find('form').trigger('reset');
//     console.log ('reset')
// });

$('#modalAddNewSupplier').on('shown.bs.modal', function () {
    $(this).find('form').trigger('reset');
   
});

//****************************************************************
// JUST BEFORE THE ADD SUPPLIER MODAL IS SHOWN, STORE THE CALLER IN
// ID = addSupplierCaller.  THIS WILL BE EITHER CUSTOMER SCREEN OR 
// PARTNERS >> SUPPLIERS MENU SELECTION
//****************************************************************
$(document).on('show.bs.modal', '#modalAddNewSupplier', function (event) {
    var callerID = $(event.relatedTarget).data('caller');
    $('#addSupplierCaller').val(callerID);
    $(this).find('form').trigger('reset');
});

// ************************************************
// WHEN ADD CANCEL IN ADD SUPPLIER MODAL IS CLICKED
// ************************************************
function addNewSupplier() {
    // prevent default PHP processing
    "use strict";
    // event.preventDefault();
    var dataToPost = {};
    dataToPost.supplierName = document.getElementById('addSupplierName').value;
    dataToPost.supplierAddress1 = document.getElementById('addSupplierAddress1').value;
    dataToPost.supplierAddress2 = document.getElementById('addSupplierAddress2').value;
    dataToPost.supplierAddress3 = document.getElementById('addSupplierAddress3').value;
    dataToPost.supplierAddress4 = document.getElementById('addSupplierAddress4').value;
    dataToPost.supplierAddress5 = document.getElementById('addSupplierAddress5').value;

    $.ajax({
        url: "addSupplier.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            if (data.includes('success')) {
                // var getIDs = parseInt(data.replace('success', ''), 10);
                var getIDs = data.replace('success', '');
                var getID = getIDs.split("/");
                var newID = getID[0];
                var newSupplierID = getID[1].trim();
                console.log(newSupplierID);
                
                $('#supplierMessage').show();
                    $.ajax({
                        url: "supplierList.php",
                        type: "POST",
                        success: function (data) {
                            $('#devicesList').html(data);
                            $('#modalAddNewSupplier').modal('hide');
                            $('#supplierNameSelection').val(newSupplierID);
                            $('#supplierNameSelection').trigger('change');
                        },
                        error: function () {}
                    });
                
            } else {
                $('#supplierMessage').html(data);
                $('#supplierMessage').show();
            }
        },
        error: function () {}
    })
}

// ***********************************************
// POPULATE SUPPLIER DETAILS ON CHANGE OF 
// SELECTED SUPPLIER ON PARTNERS >> SUPPLIERS PAGE
// ***********************************************

$(document).on('change', '#supplierNameSelection', function (event) {
    var dataToPost = {};
    var e = document.getElementById('supplierNameSelection');
    if (e.selectedIndex != -1) {
        dataToPost.supplierNumber = e.options[e.selectedIndex].value;
        document.getElementById('editSupplierHide').value = dataToPost.supplierNumber;
        $('#btnAddNewSupplier').show();
        $.ajax({
            url: 'getSupplierDetails.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                data = $.parseJSON(data);
                document.getElementById('editSupplierName').value = data['supplierName'];
                document.getElementById('editSupplierAddress1').value = data['supplierAddress1'];
                document.getElementById('editSupplierAddress2').value = data['supplierAddress2'];
                document.getElementById('editSupplierAddress3').value = data['supplierAddress3'];
                document.getElementById('editSupplierAddress4').value = data['supplierAddress4'];
                document.getElementById('editSupplierAddress5').value = data['supplierAddress5'];
                document.getElementById('supplierEditNumber').value = data['ID'];
                $('#supplierContactListHolder').html(data['supplierContactTable']);
            },
            error: function () {

            }
        });
    } else {
        $('#btnAddNewSupplier').hide();
    }
});



// ***********************************************
// UPDATE CHANGES FROM EDIT SUPPLIER MODAL DIALOG
// ***********************************************
function updateEditSupplier() {
    var dataToPost = {};
    dataToPost.supplierName = document.getElementById('editSupplierName').value;
    dataToPost.supplierAddress1 = document.getElementById('editSupplierAddress1').value;
    dataToPost.supplierAddress2 = document.getElementById('editSupplierAddress2').value;
    dataToPost.supplierAddress3 = document.getElementById('editSupplierAddress3').value;
    dataToPost.supplierAddress4 = document.getElementById('editSupplierAddress4').value;
    dataToPost.supplierAddress5 = document.getElementById('editSupplierAddress5').value;
    dataToPost.supplierID = document.getElementById('editSupplierHide').value;

    $.ajax({
        url: 'updateSupplier.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            $('#editSupplierMessage').css("display", "block");

            if (data.includes('success')) {
                $('#editSupplierMessage').html('');
                $('#getClient').trigger('change');
                $('#supplierNameSelection').trigger('change');
                $('#editSupplierMessage').html("<div class='alert alert-success'>Updated successfully</div>");
                $('#editSupplierMessage').delay(3000).hide(0);
            } else {
                $('#editSupplierMessage').html(data);
                $('#editSupplierMessage').delay(3000).hide(0);
            }
        },
        error: function () {

        }
    });
}

// **********************************
// RESET NEW INSTALLER MODAL ON CLOSE
// **********************************
$('#modalAddNewSupplier').on('hidden.bs.modal', function() {  
    $(this).find('form').trigger('reset');
});


// ********************************
// SHOW OPTIONS ON DELETE REQUESTED
// ********************************
// When delete is requested, check if supplier is assigned to any
// device(s).  If so do not allow deletion.

function deleteSupplier() {
    var dataToPost = {};
    var e = document.getElementById('supplierNameSelection');
    if (e.selectedIndex==-1) {
        return;
    }
    dataToPost.supplierNumber = e.options[e.selectedIndex].value;
    $.ajax({
        url: 'checkSupplierDeletion.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes('deleted')) {
                $('#currentSupplierMessageBox').html(data);

                $.ajax({
                    url: "supplierList.php",
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            $('#devicesList').html(data);
                            $('#supplierNameSelection option:first').attr('selected', 'selected');
                            $('#supplierNameSelection').trigger('change');
                            $('#modalAddNewSupplier').modal('hide');
                        }, 3000);
                    },
                    error: function () {}
                });
            } else {
                $('#currentSupplierMessageBox').html(data);
            }
        },
        error: function () {}
    });
}

$(document).on('click', '#queryDeleteSupplier', function () {
    var queryDelete = document.getElementById('goAheadDeleteSupplier').checked;
    if (queryDelete == false) {
        $('#currentSupplierMessageBox').html('');
    } else {
        var dataToPost = {};
        dataToPost.supplierID = ($('#hiddenIDToDelete').text());
        $.ajax({
            url: 'deleteSupplier.php',
            data: dataToPost,
            type: 'POST',
            timeout: 30000,
            success: function (data) {
                if (data.includes('success')) {
                    $('#currentSupplierMessageBox').html("<div class='alert alert-success'>Supplier deleted successfully</div>");

                    $.ajax({
                        url: "supplierList.php",
                        type: "POST",
                        success: function (data) {
                            setTimeout(function () {
                                $('#devicesList').html(data);
                                $('#supplierNameSelection option:first').attr('selected', 'selected');
                                $('#supplierNameSelection').trigger('change');
                                $('#modalAddNewSupplier').modal('hide');
                            }, 3000);
                        },
                        error: function () {}
                    });
                } else {

                    $('#currentSupplierMessageBox').html(data);
                    $('#currentSupplierMessageBox').delay(3000).hide(0);
                }

            },
            error: function () {}
        });
    }
});