
$('#modalAddNewBroker').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
});

//****************************************************************
// JUST BEFORE THE ADD SUPPLIER MODAL IS SHOWN, STORE THE CALLER IN
// ID = addBrokerCaller.  THIS WILL BE EITHER CUSTOMER SCREEN OR 
// PARTNERS >> SUPPLIERS MENU SELECTION
//****************************************************************
$(document).on('show.bs.modal', '#modalAddNewBroker', function (event) {
    var callerID = $(event.relatedTarget).data('caller');
    $('#addBrokerCaller').val(callerID);
    $(this).find('form').trigger('reset');
});

// ************************************************
// WHEN ADD CANCEL IN ADD SUPPLIER MODAL IS CLICKED
// ************************************************
// ***********************************************************************
// ADD NEW INSURER WHICH RUNS WHEN MODAL DIALOG ADD INSURER BUTTON CLICKED
// ***********************************************************************
function addNewBroker() {
    var dataToPost = {};
    dataToPost.BrokerName = document.getElementById('addBrokerName').value;
    dataToPost.BrokerAddress1 = document.getElementById('addBrokerAddress1').value;
    dataToPost.BrokerAddress2 = document.getElementById('addBrokerAddress2').value;
    dataToPost.BrokerAddress3 = document.getElementById('addBrokerAddress3').value;
    dataToPost.BrokerAddress4 = document.getElementById('addBrokerAddress4').value;
    dataToPost.BrokerAddress5 = document.getElementById('addBrokerAddress5').value;

    $.ajax({
        url: 'addNewBroker.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            if (data.includes('success')) {
                // var getIDs = parseInt(data.replace('success', ''), 10);
                var getIDs = data.replace('success', '');
                var getID = getIDs.split("/");
                var newID = getID[0];
                var newBrokerID = getID[1];

                $('#brokerMessage').show();
                if ($('#addBrokerCaller').val() == 'customer') {
                    $('#getClient').trigger('change');
                    showCustomers(newID);
                    $('#modalAddNewBroker').modal('hide');
                    var dataToPost = {};
                    dataToPost.selectedValue = newID;
                    $.ajax({
                        url: 'customers.php',
                        type: 'POST',
                        data: dataToPost,
                        success: function (data) {
                            $('#customerInfo').html(data);
                        },
                        error: function () {}
                    });
                } else {
                    $.ajax({
                        url: "brokerList.php",
                        type: "POST",
                        success: function (data) {
                            $('#devicesList').html(data);
                            $('#modalAddNewBroker').modal('hide');
                            $('#brokerNameSelection').val(newBrokerID);
                            $('#brokerNameSelection').trigger('change');
                        },
                        error: function () {}
                    });
                }

            } else {
                $('#brokerMessage').html(data);
                $('#brokerMessage').show();
            }
        },
        error: function () {}
    })
}


// ***********************************************
// POPULATE SUPPLIER DETAILS ON CHANGE OF 
// SELECTED SUPPLIER ON PARTNERS >> SUPPLIERS PAGE
// ***********************************************

$(document).on('change', '#brokerNameSelection', function (event) {
    var dataToPost = {};
    var e = document.getElementById('brokerNameSelection');
    if (e.selectedIndex != -1) {
        dataToPost.brokerNumber = e.options[e.selectedIndex].value;
        document.getElementById('editBrokerHide').value = dataToPost.brokerNumber;
        $('#btnAddNewBroker').show();
        $.ajax({
            url: 'getBrokerDetails.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                data = $.parseJSON(data);
                document.getElementById('editBrokerName').value = data['brokerName'];
                document.getElementById('editBrokerAddress1').value = data['brokerAddress1'];
                document.getElementById('editBrokerAddress2').value = data['brokerAddress2'];
                document.getElementById('editBrokerAddress3').value = data['brokerAddress3'];
                document.getElementById('editBrokerAddress4').value = data['brokerAddress4'];
                document.getElementById('editBrokerAddress5').value = data['brokerAddress5'];
                document.getElementById('brokerEditNumber').value = data['ID'];
                $('#brokerContactListHolder').html(data['brokerContactTable']);
            },
            error: function () {

            }
        });
    } else {
        $('#btnAddNewBroker').hide();
    }
});

// ***********************************************
// UPDATE CHANGES FROM EDIT SUPPLIER MODAL DIALOG
// ***********************************************
function updateEditBroker() {
    var dataToPost = {};
    dataToPost.brokerName = document.getElementById('editBrokerName').value;
    dataToPost.brokerAddress1 = document.getElementById('editBrokerAddress1').value;
    dataToPost.brokerAddress2 = document.getElementById('editBrokerAddress2').value;
    dataToPost.brokerAddress3 = document.getElementById('editBrokerAddress3').value;
    dataToPost.brokerAddress4 = document.getElementById('editBrokerAddress4').value;
    dataToPost.brokerAddress5 = document.getElementById('editBrokerAddress5').value;
    dataToPost.brokerID = document.getElementById('editBrokerHide').value;
    if (!dataToPost.brokerID) {
        return
    }
    $.ajax({
        url: 'updateBroker.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            $('#editBrokerMessage').css("display", "block");

            if (data.includes('success')) {
                $('#editBrokerMessage').html('');
                $('#getClient').trigger('change');
                $('#brokerNameSelection').trigger('change');
                $('#editBrokerMessage').html("<div class='alert alert-success'>Updated successfully</div>");
                $('#editBrokerMessage').delay(3000).hide(0);
            } else {
                $('#editBrokerMessage').html(data);
                $('#editBrokerMessage').delay(3000).hide(0);
            }
        },
        error: function () {

        }
    });
}


// ********************************
// SHOW OPTIONS ON DELETE REQUESTED
// ********************************
// When delete is requested, check if broker is assigned to any
// device(s).  If so do not allow deletion.

function deleteBroker() {
    var dataToPost = {};
    var e = document.getElementById('brokerNameSelection');
    dataToPost.brokerNumber = e.options[e.selectedIndex].value;
    $.ajax({
        url: 'checkBrokerDeletion.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes('deleted')) {
                $('#currentBrokerMessageBox').html(data);

                $.ajax({
                    url: "brokerList.php",
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            $('#devicesList').html(data);
                            $('#brokerNameSelection option:first').attr('selected', 'selected');
                            $('#brokerNameSelection').trigger('change');
                        }, 3000);
                    },
                    error: function () {}
                });
            } else {
                $('#currentBrokerMessageBox').html(data);
            }
        },
        error: function () {}
    });
}

$(document).on('click', '#queryDeleteBroker', function () {
    var queryDelete = document.getElementById('goAheadDeleteBroker').checked;
    if (queryDelete == false) {
        $('#currentBrokerMessageBox').html('');
    } else {
        var dataToPost = {};
        dataToPost.brokerID = ($('#hiddenIDToDelete').text());
        $.ajax({
            url: 'deleteBroker.php',
            data: dataToPost,
            type: 'POST',
            timeout: 30000,
            success: function (data) {
                if (data.includes('success')) {
                    $('#currentBrokerMessageBox').html("<div class='alert alert-success'>Broker deleted successfully</div>");

                    $.ajax({
                        url: "brokerList.php",
                        type: "POST",
                        success: function (data) {
                            setTimeout(function () {
                                $('#devicesList').html(data);
                                $('#brokerNameSelection option:first').attr('selected', 'selected');
                                $('#brokerNameSelection').trigger('change');
                            }, 3000);
                        },
                        error: function () {}
                    });
                } else {

                    $('#currentBrokerMessageBox').html(data);
                    $('#currentBrokerMessageBox').delay(3000).hide(0);
                }

            },
            error: function () {}
        });
    }
});

$('body').on('change', '#getBrokerSelect', function () {
    var dataToPost = {};
    dataToPost.brokerID = this.value;
    $.ajax({
        url: "updateBrokerSelect.php",
        type: "GET",
        data: dataToPost,
        success: function (data) {}
    });

    $('#getClient').trigger('change');
});




function editBroker() {
    var dataToPost = {};
    var e = document.getElementById('getBrokerSelect');
    dataToPost.brokerNumber = e.options[e.selectedIndex].value;
    if (dataToPost.brokerNumber == 0) {
        return;0
    }
    
    $.ajax({
        url: 'editBroker.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            var arr = data.split("^^^");
            document.getElementById('editBrokerName').value = arr[0];
            document.getElementById('editBrokerAddress1').value = arr[1];
            document.getElementById('editBrokerAddress2').value = arr[2];
            document.getElementById('editBrokerAddress3').value = arr[3];
            document.getElementById('editBrokerAddress4').value = arr[4];
            document.getElementById('editBrokerAddress5').value = arr[5];
            document.getElementById('editBrokerHide').value = arr[6];
            $('#modalEditBroker').modal('show');
        },
        error: function () {}
    });
}