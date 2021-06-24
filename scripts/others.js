// ******************************
// SHOW PARTNERS >> OTHRES PAGE
// ******************************
$(document).on('click', '#showOthers', function () {
    $.ajax({
        url: "otherList.php",
        type: "POST",
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#eventLog').html('');
            $('#homeScreen').html('');
            $('#devicesList').html(data);
            $('#otherNameSelection option:first').attr('selected', 'selected');
            $('#otherNameSelection').trigger('change');
            $('#vehicleList').html('');
        },
        error: function () {

        }
    })
});

$('#modalAddNewOther').on('shown.bs.modal', function () {
    $(this).find('form').trigger('reset');
   
});

$(document).on('show.bs.modal', '#modalAddNewOther', function (event) {
    $(this).find('form').trigger('reset');
});

// ************************************************
// WHEN ADD CANCEL IN ADD OTHER MODAL IS CLICKED
// ************************************************
function addNewOther() {
    // prevent default PHP processing
    "use strict";
    // event.preventDefault();
    var dataToPost = {};
    dataToPost.otherName = document.getElementById('addOtherName').value;
    dataToPost.otherAddress1 = document.getElementById('addOtherAddress1').value;
    dataToPost.otherAddress2 = document.getElementById('addOtherAddress2').value;
    dataToPost.otherAddress3 = document.getElementById('addOtherAddress3').value;
    dataToPost.otherAddress4 = document.getElementById('addOtherAddress4').value;
    dataToPost.otherAddress5 = document.getElementById('addOtherAddress5').value;
    dataToPost.otherService = document.getElementById('addOtherService').value;

    $.ajax({
        url: "addOther.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            if (data.includes('success')) {
                // var getIDs = parseInt(data.replace('success', ''), 10);
                var getIDs = data.replace('success', '');
                var getID = getIDs.split("/");
                // var newID = getID[0];
                var newOtherID = getID[1].trim();

                $('#otherMessage').show();
                                    $.ajax({
                        url: "otherList.php",
                        type: "POST",
                        success: function (data) {
                            $('#devicesList').html(data);
                            $('#modalAddNewOther').modal('hide');
                            $('#otherNameSelection').val(newOtherID);
                            $('#otherNameSelection').trigger('change');
                        },
                        error: function () {}
                    });
                
            } else {
                $('#otherMessage').html(data);
                $('#otherMessage').show();
            }
        },
        error: function () {}
    })
}

// ***********************************************
// POPULATE OTHER DETAILS ON CHANGE OF 
// SELECTED OTHERER ON PARTNERS >> OTHERS PAGE
// ***********************************************

$(document).on('change', '#otherNameSelection', function (event) {
    var dataToPost = {};
    var e = document.getElementById('otherNameSelection');
    if (e.selectedIndex != -1) {
        dataToPost.otherNumber = e.options[e.selectedIndex].value;
        document.getElementById('editOtherHide').value = dataToPost.otherNumber;
        $('#btnAddNewOtherContact').show();
        $.ajax({
            url: 'getOtherDetails.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                data = $.parseJSON(data);
                document.getElementById('editOtherName').value = data['otherName'];
                document.getElementById('editOtherAddress1').value = data['otherAddress1'];
                document.getElementById('editOtherAddress2').value = data['otherAddress2'];
                document.getElementById('editOtherAddress3').value = data['otherAddress3'];
                document.getElementById('editOtherAddress4').value = data['otherAddress4'];
                document.getElementById('editOtherAddress5').value = data['otherAddress5'];
                document.getElementById('otherEditNumber').value = data['ID'];
                $('#otherContactListHolder').html(data['otherContactTable']);
            },
            error: function () {

            }
        });
    } else {
        $('#btnAddNewOtherContact').hide();
    }
});

// ********************************
// SHOW OPTIONS ON DELETE REQUESTED
// ********************************

function deleteOther() {
    var dataToPost = {};
    var e = document.getElementById('otherNameSelection');
    if (e.selectedIndex==-1) {
        return;
    }
    dataToPost.otherNumber = e.options[e.selectedIndex].value;
    $.ajax({
        url: 'checkOtherDeletion.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes('deleted')) {
                $('#currentOtherMessageBox').html(data);
                               
                $.ajax({
                    url: "otherList.php",
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            $('#devicesList').html(data);
                            $('#otherNameSelection option:first').attr('selected', 'selected');
                            $('#otherNameSelection').trigger('change');
                            $('#modalAddNewOther').modal('hide');
                            
                        }, 3000);
                    },
                    error: function () {}
                });
                
                
            } else {
                $('#currentOtherMessageBox').html(data);
            }
        },
        error: function () {}
    });
}

$(document).on('click', '#queryDeleteOther', function () {
    var queryDelete = document.getElementById('goAheadDeleteOther').checked;
    if (queryDelete == false) {
        $('#currentOtherMessageBox').html('');
    } else {
        var dataToPost = {};
        dataToPost.otherID = ($('#hiddenIDToDelete').text());
        $.ajax({
            url: 'deleteOther.php',
            data: dataToPost,
            type: 'POST',
            timeout: 30000,
            success: function (data) {
                if (data.includes('success')) {
                    $('#currentOtherMessageBox').html("<div class='alert alert-success'>Partner deleted successfully</div>");

                    $.ajax({
                        url: "otherList.php",
                        type: "POST",
                        success: function (data) {
                            setTimeout(function () {
                                $('#devicesList').html(data);
                                $('#otherNameSelection option:first').attr('selected', 'selected');
                                $('#otherNameSelection').trigger('change');
                                $('#modalAddNewOther').modal('hide');
                            }, 3000);
                        },
                        error: function () {}
                    });
                } else {

                    $('#currentOtherMessageBox').html(data);
                    $('#currentOtherMessageBox').delay(3000).hide(0);
                }

            },
            error: function () {}
        });
    }
});