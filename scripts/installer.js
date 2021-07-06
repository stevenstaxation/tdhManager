// ******************************
// SHOW PARTNERS >> INSTALLERS PAGE
// ******************************
$(document).on('click', '#showInstallers', function() {
    $.ajax({
        url: "installerList.php",
        type: "POST",
        success: function(data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#eventLog').html('');
            $('#homeScreen').html('');
            $('#devicesList').html(data);
            $('#installerNameSelection option:first').attr('selected', 'selected');
            $('#installerNameSelection').trigger('change');
            $('#vehicleList').html('');
        },
        error: function() {

        }
    })
});


// ***************************************************************************
// ADD NEW INSTALLER WHICH RUNS WHEN MODAL DIALOG ADD INSTALLER BUTTON CLICKED
// ***************************************************************************
function addNewInstaller() {
    // prevent default PHP processing
    "use strict";
    var dataToPost = {};
    dataToPost.installerName = document.getElementById('addInstallerName').value;
    dataToPost.installerAddress1 = document.getElementById('addInstallerAddress1').value;
    dataToPost.installerAddress2 = document.getElementById('addInstallerAddress2').value;
    dataToPost.installerAddress3 = document.getElementById('addInstallerAddress3').value;
    dataToPost.installerAddress4 = document.getElementById('addInstallerAddress4').value;
    dataToPost.installerAddress5 = document.getElementById('addInstallerAddress5').value;
     
    $.ajax({
        url: "addNewInstaller.php",
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            if (data.includes('success')) {
                var getIDs = data.replace('success', '');
                var getID = getIDs.split("/");
                var newID = getID[0];
                var newInstallerID = getID[1].trim();
                $('#installerMessage').show();
                $.ajax({
                    url: "installerList.php",
                    type: "POST",
                    success: function(data) {
                        $('#devicesList').html(data);
                        $('#modalAddNewInstaller').modal('hide');
                        $('#installerNameSelection').val(newInstallerID);
                        $('#installerNameSelection').trigger('change');
                    },
                    error: function() {}
                });
               
               
                $('#modalAddNewInstaller').modal('hide');
            } else {
                $('#installerMessage').html(data);
                $('#installerMessage').show();    
            }
        },
        error: function() {
            $('#installerMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
        }
    });
}


// ***********************************************
// UPDATE CHANGES FROM EDIT INSTALLER MODAL DIALOG
// ***********************************************
function updateEditInstaller() {
    var dataToPost = {};
    dataToPost.installerName = document.getElementById('editInstallerName').value;
    dataToPost.installerAddress1 = document.getElementById('editInstallerAddress1').value;
    dataToPost.installerAddress2 = document.getElementById('editInstallerAddress2').value;
    dataToPost.installerAddress3 = document.getElementById('editInstallerAddress3').value;
    dataToPost.installerAddress4 = document.getElementById('editInstallerAddress4').value;
    dataToPost.installerAddress5 = document.getElementById('editInstallerAddress5').value;
    dataToPost.installerID = document.getElementById('editInstallerHide').value;
    if (!dataToPost.installerID) {
        return
    }
    $.ajax({
        url: 'updateInstaller.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            $('#editInstallerMessage').css("display",  "block");
       
            if (data.includes('success')) {
                $('#editInstallerMessage').html('');
                $('#getClient').trigger('change');
                $('#installerNameSelection').trigger('change');
                // $('#modalEditInstaller').modal('hide');
                $('#editInstallerMessage').html("<div class='alert alert-success'>Updated successfully</div>");
                $('#editInstallerMessage').delay(3000).hide(0);
            } else {
                $('#editInstallerMessage').html(data);
                $('#editInstallerMessage').delay(3000).hide(0);
            }
        },
        error: function () {

        }
    });
}


// **********************************
// RESET NEW INSTALLER MODAL ON CLOSE
// **********************************
$('#modalAddNewInstaller').on('hidden.bs.modal', function() {  
    $(this).find('form').trigger('reset');
});

// *********************************************************************************
// JUST BEFORE THE ADD INSTALLER MODAL IS SHOWN, STORE THE CALLER IN
// ID = addInstallerCaller.  THIS WILL ONLY BE PARTNERS >> INSTALLERS 
// MENU SELECTION, BUT IT IS SET UP TO BE ABLE TO ADD FROM CUSTOMERS (A LA INSURERS)
// *********************************************************************************
$(document).on('show.bs.modal', '#modalAddNewInstaller', function (event) {
    var callerID = $(event.relatedTarget).data('caller');
    $('#addInstallerCaller').val(callerID);
    $(this).find('form').trigger('reset');
});


// *********************************************
// POPULATE INSTALLER DETAILS ON CHANGE OF 
// SELECTED INSTALLER ON PARTNERS >> INSTALLERS PAGE
// *********************************************

$(document).on('change', '#installerNameSelection', function(event) {
    var dataToPost = {};
    var e = document.getElementById('installerNameSelection');
    if (e.selectedIndex!=-1) {
        dataToPost.installerNumber = e.options[e.selectedIndex].value;
        document.getElementById('editInstallerHide').value = dataToPost.installerNumber;
        $('#btnAddNewInstallerContact').show();
        $.ajax({
            url: 'getInstallerDetails.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                data = $.parseJSON(data);
                document.getElementById('editInstallerName').value = data['installerName'];
                document.getElementById('editInstallerAddress1').value = data['installerAddress1'];
                document.getElementById('editInstallerAddress2').value = data['installerAddress2'];
                document.getElementById('editInstallerAddress3').value = data['installerAddress3'];
                document.getElementById('editInstallerAddress4').value = data['installerAddress4'];
                document.getElementById('editInstallerAddress5').value = data['installerAddress5'];
                document.getElementById('installerEditNumber').value = data['ID'];
                $('#installerContactListHolder').html(data['installerContactTable']);
            },
            error: function() {
            }
        });
    } else {
        $('#btnAddNewInstallerContact').hide();
    }
});


// ********************************
// SHOW OPTIONS ON DELETE REQUESTED
// ********************************
// When delete is requested, check if installer is assigned to any
// device(s).  If so do not allow deletion.

function deleteInstaller() {
    var dataToPost = {};
    var e = document.getElementById('installerNameSelection');
    if (e.selectedIndex==-1) {
        return;
    }
    dataToPost.installerNumber = e.options[e.selectedIndex].value;
    $.ajax({
        url: 'checkInstallerDeletion.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes('deleted')) {
                $('#currentInstallerMessageBox').html(data);

                $.ajax({
                    url: "installerList.php",
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            $('#devicesList').html(data);
                            $('#installerNameSelection option:first').attr('selected', 'selected');
                            $('#installerNameSelection').trigger('change');
                            $('#modalAddNewInstaller').modal('hide');
                        }, 3000);
                    },
                    error: function () {}
                });
            } else {
                $('#currentInstallerMessageBox').html(data);
                }
        },
        error: function () {}
    });
}

$(document).on('click', '#queryDeleteInstaller', function () {
    var queryDelete = document.getElementById('goAheadDeleteInstaller').checked;
    if (queryDelete == false) {
        $('#currentInstallerMessageBox').html('');
    } else {
        var dataToPost = {};
        dataToPost.installerID = ($('#hiddenIDToDelete').text());
        $.ajax({
            url: 'deleteInstaller.php',
            data: dataToPost,
            type: 'POST',
            timeout: 30000,
            success: function (data) {
                if (data.includes('success')) {
                    $('#currentInstallerMessageBox').html("<div class='alert alert-success'>Installer deleted successfully</div>");

                    $.ajax({
                        url: "installerList.php",
                        type: "POST",
                        success: function (data) {
                            setTimeout(function () {
                                $('#devicesList').html(data);
                                $('#installerNameSelection option:first').attr('selected', 'selected');
                                $('#installerNameSelection').trigger('change');
                                $('#modalAddNewInstaller').modal('hide');
                            }, 3000);
                        },
                        error: function () {}
                    });
                } else {
    
                    $('#currentInstallerMessageBox').html(data);
                    $('#currentInstallerMessageBox').delay(3000).hide(0);
                }

            },
            error: function () {}
        });
    }
});














