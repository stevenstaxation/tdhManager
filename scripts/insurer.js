// ******************************
// SHOW PARTNERS >> INSURERS PAGE
// ******************************



// ***********************************************************************
// ADD NEW INSURER WHICH RUNS WHEN MODAL DIALOG ADD INSURER BUTTON CLICKED
// ***********************************************************************
function addNewInsurer() {
    var dataToPost = {};
    dataToPost.insurerName = document.getElementById('addInsurerName').value;
    dataToPost.InsurerAddress1 = document.getElementById('addInsurerAddress1').value;
    dataToPost.InsurerAddress2 = document.getElementById('addInsurerAddress2').value;
    dataToPost.InsurerAddress3 = document.getElementById('addInsurerAddress3').value;
    dataToPost.InsurerAddress4 = document.getElementById('addInsurerAddress4').value;
    dataToPost.InsurerAddress5 = document.getElementById('addInsurerAddress5').value;

    $.ajax({
        url: 'addNewInsurer.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            if (data.includes('success')) {
                // var getIDs = parseInt(data.replace('success', ''), 10);
                var getIDs = data.replace('success', '');
                var getID = getIDs.split("/");
                var newID = getID[0].trim();
                var newInsurerID = getID[1].trim();

                $('#insurerMessage').show();
                if ($('#addInsurerCaller').val() == 'customer') {
                    $('#getClient').trigger('change');
                    showCustomers(newID);
                    $('#modalAddNewInsurer').modal('hide');
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
                        url: "insurerList.php",
                        type: "POST",
                        success: function (data) {
                            $('#devicesList').html(data);
                            $('#modalAddNewInsurer').modal('hide');
                            $('#insurerNameSelection').val(newInsurerID);
                            $('#insurerNameSelection').trigger('change');
                        },
                        error: function () {}
                    });
                }

            } else {
                $('#insurerMessage').html(data);
                $('#insurerMessage').show();
            }
        },
        error: function () {}
    })
}


//****************************************************************
// JUST BEFORE THE ADD INSURER MODAL IS SHOWN, STORE THE CALLER IN
// ID = addInsurerCaller.  THIS WILL BE EITHER CUSTOMER SCREEN OR 
// PARTNERS >> INSURERS MENU SELECTION
//****************************************************************
$(document).on('show.bs.modal', '#modalAddNewInsurer', function (event) {
    var callerID = $(event.relatedTarget).data('caller');
    $('#addInsurerCaller').val(callerID);
    $(this).find('form').trigger('reset');
});



// *******************************************************
// POPULATE EDIT INSURER MODAL DIALOG WITH CURRENT DETAILS
// *******************************************************
function editInsurer() {
    var dataToPost = {};
    var e = document.getElementById('getInsurerSelect');
    dataToPost.insurerNumber = e.options[e.selectedIndex].value;
    if (dataToPost.insurerNumber == 0) {
        return;
    }

    $.ajax({
        url: 'editInsurer.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            var arr = data.split("^^^");
            document.getElementById('editInsurerName').value = arr[0];
            document.getElementById('editInsurerAddress1').value = arr[1];
            document.getElementById('editInsurerAddress2').value = arr[2];
            document.getElementById('editInsurerAddress3').value = arr[3];
            document.getElementById('editInsurerAddress4').value = arr[4];
            document.getElementById('editInsurerAddress5').value = arr[5];
            document.getElementById('editInsurerHide').value = arr[6];
            $('#modalEditInsurer').modal('show');
        },
        error: function () {

        }
    });
}

// *********************************************
// UPDATE CHANGES FROM EDIT INSURER MODAL DIALOG
// *********************************************
function updateEditInsurer() {
    var dataToPost = {};
    dataToPost.insurerName = document.getElementById('editInsurerName').value;
    dataToPost.insurerAddress1 = document.getElementById('editInsurerAddress1').value;
    dataToPost.insurerAddress2 = document.getElementById('editInsurerAddress2').value;
    dataToPost.insurerAddress3 = document.getElementById('editInsurerAddress3').value;
    dataToPost.insurerAddress4 = document.getElementById('editInsurerAddress4').value;
    dataToPost.insurerAddress5 = document.getElementById('editInsurerAddress5').value;
    dataToPost.insurerID = document.getElementById('editInsurerHide').value;
    if (!dataToPost.insurerID) {
        return
    }
    $.ajax({
        url: 'updateInsurer.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            $('#editInsurerMessage').css("display",  "block");
            if (data.includes('success')) {
                $('#editInsurerMessage').html('');
                $('#getClient').trigger('change');
                $('#insurerNameSelection').trigger('change');
                $('#modalEditInsurer').modal('hide');
                $('#editInsurerMessage').html("<div class='alert alert-success'>Updated successfully</div>");
                $('#editInsurerMessage').delay(3000).hide(0);
            } else {
                $('#editInsurerMessage').html(data);
                $('#editInsurerMessage').delay(3000).hide(0);
            }
        },
        error: function () {

        }
    });
}

// ***********************************************
// UPDATE THE CUSTOMER RECORD ON CHANGE OF INSURER
// ***********************************************
$('body').on('change', '#getInsurerSelect', function () {
    var dataToPost = {};
    dataToPost.insurerID = this.value;
    $.ajax({
        url: "updateInsurerSelect.php",
        type: "GET",
        data: dataToPost,
        success: function (data) {}
    });

    $('#getClient').trigger('change');
});

// *********************************************
// POPULATE INSURER DETAILS ON CHANGE OF 
// SELECTED INSURER ON PARTNERS >> INSURERS PAGE
// *********************************************

$(document).on('change', '#insurerNameSelection', function (event) {
    var dataToPost = {};
    var e = document.getElementById('insurerNameSelection');
    if (e.selectedIndex !=-1) {
        dataToPost.insurerNumber = e.options[e.selectedIndex].value;
        document.getElementById('editInsurerHide').value = dataToPost.insurerNumber;   
        $('#btnAddNewContact').show();
        $.ajax({
            url: 'getInsurerDetails.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                data = $.parseJSON(data);
                document.getElementById('editInsurerName').value = data['insurerName'];
                document.getElementById('editInsurerAddress1').value = data['insurerAddress1'];
                document.getElementById('editInsurerAddress2').value = data['insurerAddress2'];
                document.getElementById('editInsurerAddress3').value = data['insurerAddress3'];
                document.getElementById('editInsurerAddress4').value = data['insurerAddress4'];
                document.getElementById('editInsurerAddress5').value = data['insurerAddress5'];
                document.getElementById('insurerEditNumber').value = data['ID'];
                $('#insurerContactListHolder').html(data['insurerContactTable']);
            },
            error: function () {
            }
        });
    } else {
        $('#btnAddNewContact').hide();
    }
});


// ********************************
// SHOW OPTIONS ON DELETE REQUESTED
// ********************************
// When delete is requested, check if insurer is assigned to any
// customer(s).  If so give user the option to set to 'change insurer'
// for these customers first or set all to 'none selected'

function deleteInsurer() {
    var dataToPost = {};
    var e = document.getElementById('insurerNameSelection');
    if (e.selectedIndex==-1) {
        return;
    }

    swal ({
        title: "Confirm delete",
        text: "Are you sure you want to delete?",
        icon: "warning",
        buttons: ['Cancel', 'Yes - Delete'],
        dangerMode: true,
    }).then (function(isConfirm){
  
    if (isConfirm) {
        dataToPost.insurerNumber = e.options[e.selectedIndex].value;
        $.ajax({
            url: 'checkInsurerDeletion.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                if (data.includes('deleted')) {
                    $('#currentInsurerMessageBox').html(data);
                
                    $.ajax({
                        url: "insurerList.php",
                        type: "POST",
                        success: function (data) {
                            setTimeout(function () {
                                $('#devicesList').html(data);
                                $('#insurerNameSelection option:first').attr('selected', 'selected');
                                $('#insurerNameSelection').trigger('change');
                                $('#modalAddNewInsurer').modal('hide');        
                            }, 3000);
                        },
                        error: function () {}
                    });
                } else {
                    $('#currentInsurerMessageBox').html(data);
                }
            },
            error: function () {}
        });
    }
    });
}

$(document).on('click', '#queryDeleteInsurer', function () {
    var queryDelete = document.getElementById('goAheadDeleteInsurer').checked;
 
    if (queryDelete == false) {
        $('#currentInsurerMessageBox').html('');
    } else {   
        var dataToPost = {};
        dataToPost.insurerID = ($('#hiddenIDToDelete').text());
           
        $.ajax({
            url: 'deleteInsurer.php',
            data: dataToPost,
            type: 'POST',
            timeout: 30000,
            success: function (data) {
                if (data.includes('success')) {
                    $('#currentInsurerMessageBox').html("<div class='alert alert-success'>Insurer deleted successfully</div>");
                
                    $.ajax({
                        url: "insurerList.php",
                        type: "POST",
                        success: function (data) {
                            setTimeout(function () {
                                $('#devicesList').html(data);
                                $('#insurerNameSelection option:first').attr('selected', 'selected');
                                $('#insurerNameSelection').trigger('change');
                                $('#modalAddNewInsurer').modal('hide');
                            }, 3000);
                        },
                        error: function () {}
                    });              
                } else {
                    $('#currentInsurerMessageBox').html(data);
                    $('#currentInsurerMessageBox').delay(3000).hide(0);
                }       
            },
            error: function () {}
        });
    }
});
