$(document).on('click', '#vehicleFilterClicked', function (event) {
    "use strict";
    event.preventDefault();
    var dataToPost = {};
    dataToPost.FilterVRN = document.getElementById('VRNToLookup').value;
    dataToPost.FilterCustomer = document.getElementById('getCustomerSelect').value;
    dataToPost.FilterInsurer = document.getElementById('getInsurerSelect').value;

    $.ajax({
        url: 'filterVehicles.php',
        data: dataToPost,
        type: "POST",
        success: function (data) {
            dataToPost.SQLFilter = data;

            $.ajax({
                url: "vehicleList.php",
                type: "POST",
                data: dataToPost,
                success: function (data) {
                    $('#vehicleList').html(data);
                },
                error: function () {
                    $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact TDH Manager Support.</div>");
                }
            });
        },
        error: function () {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact TDH Manager Support.</div>");
        }
    });
});

$(document).on('click', '#editVehicleInstalldate', function (event) {
    event.preventDefault();
    if (!document.getElementById('editVehicleInstalldate').value) {
        let thisDay = new Date();
        thisDay = thisDay.toISOString().substring(0, 10);
        document.getElementById('editVehicleInstalldate').value = thisDay;
    }
});





$('#modalAddVehicle').on('hidden.bs.modal', function (event) {
    $(this).find('form').trigger('reset');
    $('#addVehicleErrorBox').html('');
});

$(document).on("input", "#vehicleStatusPending", function () {
    if ($("#vehicleStatusPending").is(':checked')) {
        $('#vehicleInstallDateLabel').html("Upcoming install date");
        document.getElementById('vehicleInstalldate').disabled = false;
    }
});
$(document).on("input", "#vehicleStatusInstalled", function () {
    if ($("#vehicleStatusInstalled").is(':checked')) {
        $('#vehicleInstallDateLabel').html("Installation date");
        // if (document.getElementById('vehicleInstalldate').value == '') {
        //      let thisDay = new Date();
        //      thisDay = thisDay.toISOString().substring(0, 10);
        //      document.getElementById('vehicleInstalldate').value = thisDay;
        //      document.getElementById('vehicleInstalldate').disabled = false;
        // }
    }
});

$(document).on("input", "#vehicleStatusNotApplicable", function () {
    if ($("#vehicleStatusNotApplicable").is(':checked')) {
        $('#vehicleInstallDateLabel').html("Date not required");

      
    }
});

$(document).on("input", "#editVehicleStatusPending", function () {
    if ($("#editVehicleStatusPending").is(':checked')) {
        $('#vehicleEditInstallDateLabel').html("Upcoming install date");
     
    }
});
$(document).on("input", "#editVehicleStatusInstalled", function () {
    if ($("#editVehicleStatusInstalled").is(':checked')) {
        $('#vehicleEditInstallDateLabel').html("Installation date");
  
        }
});

$(document).on("input", "#editVehicleStatusNotApplicable", function () {
    if ($("#editVehicleStatusNotApplicable").is(':checked')) {
        $('#vehicleEditInstallDateLabel').html("Date not required");
 
    }
});


$(document).on('blur', '#editVRN', function (event) {
    // prevent default PHP processing
    // document.getElementById('editVehicleDescription').value = 'searching...';
    // var dataToPost = {};
    // dataToPost.VRN = $('#editVRN').val();
    // $.ajax({
    //     url: 'scrapeVRN.php',
    //     timeout: 30000,
    //     dataType: 'json',
    //     data: dataToPost,
    //     type: "POST",
    //     success: function(data) {
    //         var parseableData = (data);

    //         document.getElementById('editVehicleDescription').value = parseableData['Make'] + parseableData['Model'] + parseableData['other'];
    //     },
    //     error: function() {

    //     }
    // });
});

$(document).on('click', '#findVehicleRegNumber', function (event) {
    event.preventDefault();
    var dataToPost = {};
    dataToPost.VRN = document.getElementById('addVehicleRegNumber').value;
    document.getElementById('lookUpProgress').style.visibility = "visible";
    $.ajax({
        url: 'lookupVRN.php',
        // url: 'VRNLookup.php',
        timeout: 15000,
        type: "POST",
        data: dataToPost,
        datatype: "json",
        success: function (data) {
            // var vehicleInfo = $.parseJSON(data);

            // document.getElementById('addVehicleRegNumber').value = dataToPost.VRN;
            // document.getElementById('addVehicleMake').value = vehicleInfo["Response"]["DataItems"]["VehicleRegistration"]["Make"];
            // document.getElementById('addVehicleModel').value = vehicleInfo["Response"]["DataItems"]["VehicleRegistration"]["Model"];
            // document.getElementById('addVehicleAddDescription').value = vehicleInfo["Response"]["DataItems"]["VehicleRegistration"]["Colour"];
            // if (vehicleInfo["Response"]["DataItems"]["VehicleRegistration"]["YearOfManufacture"]!=0) {
            //     document.getElementById('addVehicleAddDescription').value += " (" + vehicleInfo["Response"]["DataItems"]["VehicleRegistration"]["YearOfManufacture"] + ")";
            // }
            // document.getElementById('lookUpProgress').style.visibility = "hidden";

            //  $.ajax({
            //     url: "VRNAllocate.php",
            //     success: function(alloc) {
            //     var arralloc = alloc.split("***");
            //     document.getElementById('addVehicleAllocateTo').value = arralloc[0];
            //     document.getElementById('hiddenVehicleID').value = arralloc[1];
            //     }

            //  })

            var arr = data.split('^^^');

            document.getElementById('addVehicleRegNumber').value = arr[0];
            //  document.getElementById('addVehicleMake').value = arr[1];
            //  document.getElementById('addVehicleModel').value = arr[2];
            //  document.getElementById('addVehicleAddDescription').value = arr[3];
            document.getElementById('addVehicleAllocateTo').value = arr[4];
            document.getElementById('hiddenVehicleID').value = arr[5];
            //  document.getElementById('lookUpProgress').style.visibility = "hidden";

        },
        error: function () {

        }
    });
});

function addNewVehicle() {
    var dataToPost = {};
    dataToPost.regNumber = document.getElementById('addVehicleRegNumber').value;
    dataToPost.required = $('#vehicleCameraYes').is(':checked');

    if ($('#vehicleStatusInstalled').is(':checked')) {
        dataToPost.installation = 'installed';
    } else if ($('#vehicleStatusPending').is(':checked')) {
        dataToPost.installation = 'pending';
    } else {
        dataToPost.installation = 'not applicable'
    }
    dataToPost.installationDate = $('#vehicleInstalldate').val();
    dataToPost.vehicleNotes = document.getElementById('addVehicleNotes').value;
    dataToPost.LTAlarmDate = $('#LTAlarmInstalldate').val();
    dataToPost.SSSensorDate = $('#SideScanInstalldate').val();
    // dataToPost.allocateTo = document.getElementById('hiddenVehicleID').value;

    // dataToPost.make = document.getElementById('addVehicleMake').value;
    // dataToPost.model = document.getElementById('addVehicleModel').value;
    // dataToPost.addDescription = document.getElementById('addVehicleAddDescription').value;

    $.ajax({
        url: '../php/vehicles/addNewVehicle.php',
        type: "POST",
        data: dataToPost,
        success: function (data) {
            if (data.includes('success')) {
                $('#modalAddVehicle').modal('hide');
                $('#getClient').trigger('change');
            } else {
                $('#addVehicleErrorBox').html(data);
           }
        },
        error: function (err) {
            console.log(err);
        }
    });
}


function showVehicleForEdit(rowNumber) {
    if (rowNumber.includes("customer")) {
        document.getElementById('hiddenVehicleSelector').value = 'customer';
        rowNumber = rowNumber.replace("customer", '');
    } else {
        document.getElementById('hiddenVehicleSelector').value = 'vehicle';
        rowNumber = rowNumber.replace("vehicle", '');
    }

    var dataToPost = {};
    dataToPost.vehicleID = rowNumber;
    $.ajax({
        url: 'getCurrentVehicle.php',
        timeout: 30000,
        data: dataToPost,
        datatype: "json",
        type: "POST",
        success: function (data) {
            data = $.parseJSON(data);

            document.getElementById('editVehicleRegNumber').value = data['regNumber'];
            //    document.getElementById('editVehicleMake').value = data['make'];
            //    document.getElementById('editVehicleModel').value = data['model'];
            //    document.getElementById('editVehicleAddDescription').value = data['addDescription'];
            document.getElementById('vehicleAllocateTo').value = data['businessName'];

            document.getElementById('hiddenVehicleID').value = rowNumber;

            $('#editVehicleCameraNo').prop('checked', true);
            if (data['cameraRequired'] == '1') {
                $('#editVehicleCameraYes').prop('checked', true);
            }

            if (data['vehicleStatus'] == '2') {
                $('#editVehicleStatusInstalled').prop('checked', true);
                $('#vehicleEditInstallDateLabel').html("Installation date");
             
            } else if (data['vehicleStatus'] == '1') {
                $('#editVehicleStatusPending').prop('checked', true);
                $('#vehicleEditInstallDateLabel').html("Upcoming install date");
            
            } else {
                $('#editVehicleStatusNotApplicable').prop('checked', true);
                $('#vehicleEditInstallDateLabel').html("Date not required");
               
            }

            $('#editVehicleInstalldate').val(data['installDate']);
            $('#editLTAlarmDate').val(data['LTAlarmDate']);
            $('#editSideScanDate').val(data['SideScanDate']);

            $('#editVehicleNotes').html(data['vehicleNotes']);

            $('#modalVehicleShow').modal('show');

            if (data['LTAlarmDate']) {
                $('#labelEditLeftTurn').css('color', 'limegreen');
                $('#editLTAlarmDate').css('color', 'limegreen');
            } else {
                $('#labelEditLeftTurn').css('color', '#888888');
                $('#editLTAlarmDate').css('color', '#888888');
            }
            if (data['SideScanDate']) {
                $('#labelEditSideScan').css('color', 'limegreen');
                $('#editSideScanDate').css('color', 'limegreen');
            } else {
                $('#labelEditSideScan').css('color', '#888888');
                $('#editSideScanDate').css('color', '#888888');
            }

           
            
        },
        error: function () {

        }
    });
}

$(document).on("change", '#editLTAlarmDate', function () {
    var thisDate = new Date($('#editLTAlarmDate').val());

    if (thisDate != 'Invalid Date') {
        $('#labelEditLeftTurn').css('color', 'limegreen');
        $('#editLTAlarmDate').css('color', 'limegreen');
    } else {
        $('#labelEditLeftTurn').css('color', '#888888');
        $('#editLTAlarmDate').css('color', '#888888');
    }
});
$(document).on("change", '#editSideScanDate', function () {
    var thisDate = new Date($('#editSideScanDate').val());

    if (thisDate != 'Invalid Date') {
        $('#labelEditSideScan').css('color', 'limegreen');
        $('#editSideScanDate').css('color', 'limegreen');
    } else {
        $('#labelEditSideScan').css('color', '#888888');
        $('#editSideScanDate').css('color', '#888888');
    }
});

function editCurrentVehicle() {
    var dataToPost = {};
    dataToPost.regNumber = document.getElementById('editVehicleRegNumber').value;
    //   dataToPost.make = document.getElementById('editVehicleMake').value;
    //   dataToPost.model = document.getElementById('editVehicleModel').value;
    //   dataToPost.addDescription = document.getElementById('editVehicleAddDescription').value;
    dataToPost.vehicleID = document.getElementById('hiddenVehicleID').value;
    dataToPost.required = $('#editVehicleCameraYes').is(':checked');

    if ($('#editVehicleStatusInstalled').is(':checked')) {
        dataToPost.vehicleStatus = 2;
    } else if ($('#editVehicleStatusPending').is(':checked')) {
        dataToPost.vehicleStatus = 1;
    } else {
        dataToPost.vehicleStatus = 0;
    }

    dataToPost.installDate = document.getElementById('editVehicleInstalldate').value;
    dataToPost.LTAlarmDate = document.getElementById('editLTAlarmDate').value;
    dataToPost.SideScanDate = document.getElementById('editSideScanDate').value;

    dataToPost.vehicleNotes = document.getElementById('editVehicleNotes').value;

    $.ajax({
        url: 'updateCurrentVehicle.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes('success')) {
                $('#modalVehicleShow').modal('hide');
                $('#vehicleFilterClicked').trigger('click');
                if (document.getElementById('hiddenVehicleSelector').value == 'vehicle') {
                    $('#showVehicleList').trigger('click');
                } else {
                    $('#getClient').trigger('change');
                    var newID = parseInt(data.replace('success', ''), 10);
                    showCustomers(newID);
                }
            } else {
                $('#editVehicleErrorBox').html(data);
            }
        },
        error: function () {

        }
    });
}

function showVehicleNotes(rowNumber) {
    if (rowNumber.includes("customer")) {
        document.getElementById('hiddenVehicleNotesSelector').value = 'customer';
        rowNumber = rowNumber.replace("customer", '');
    } else {
        document.getElementById('hiddenVehicleNotesSelector').value = 'vehicle';
        rowNumber = rowNumber.replace("vehicle", '');
    }
    var dataToPost = {};
    dataToPost.vehicleID = rowNumber;

    $.ajax({
        url: "getCurrentVehicleNotes.php",
        timeout: 30000,
        data: dataToPost,
        datatype: "json",
        type: "POST",
        success: function (data) {
            data = $.parseJSON(data);
            document.getElementById('editVehicleNotesText').value = data['vehicleNotes'];
            document.getElementById('hiddenVehicleNotesID').value = rowNumber;
            $('#modalEditVehicleNotes').modal('show');
        },
        error: function () {

        }
    });
}

function editCurrentVehicleNotes() {
    var dataToPost = {};
    dataToPost.vehicleID = document.getElementById('hiddenVehicleNotesID').value;
    dataToPost.vehicleNote = document.getElementById('editVehicleNotesText').value;

    $.ajax({
        url: 'updateEditVehicleNotes.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes("success")) {
                $('#editVehicleNotesMessage').html('');
                $('#modalEditVehicleNotes').modal('hide');

                if (document.getElementById('hiddenVehicleNotesSelector').value == 'vehicle') {
                    $('#showVehicleList').trigger('click');
                } else {
                    $('#getClient').trigger('change');
                    var newID = parseInt(data.replace('success', ''), 10);
                    showCustomers(newID);
                }


            } else {
                $('#editVehicleMessage').html(data);
            }
        },
        error: function () {

        }
    });
}


function deleteVehicle() {
    var dataToPost = {};
    // var e = document.getElementById('editDeviceDescription');
    // if (e.selectedIndex==-1) {
    //     return;
    // }
    dataToPost.vehicleNumber = document.getElementById('hiddenVehicleID').value;

    $.ajax({
        url: "deleteVehicle.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes('success')) {
                $('#editVehicleMessage').html('');
                $('#modalVehicleShow').modal('hide');
                if (document.getElementById('hiddenVehicleSelector').value == 'vehicle') {
                    $('#showVehicleList').trigger('click');
                } else {
                    $('#getClient').trigger('change');
                    var newID = parseInt(data.replace('success', ''), 10);
                    showCustomers(newID);
                }
            } else {
                $('#editVehicleMessage').html(data);
            }
        }
    })
}

$(document).on('show.bs.modal', '#modalAddVehicle', function (event) {
    $(this).find('form').trigger('reset');
    $('#addVehicleErrorBox').html('');
    // if (document.getElementById('vehicleStatusInstalled').checked == true || document.getElementById('vehicleStatusPending').checked == true) {
    //     let thisDay = new Date();
    //     thisDay = thisDay.toISOString().substring(0, 10);
    //     document.getElementById('vehicleInstalldate').value = thisDay;
    // };

});

$(document).on('hide.bs.modal', '#modalVehicleShow', function (event) {
    $(this).find('form').trigger('reset');
    $('#editVehicleErrorBox').html('');
});


$(document).on('click', '#vehicleListTable tbody td', function () {
    let dt = $('#vehicleListTable').DataTable();
    let vIndex = $(this).index();
    let colIndex = dt.column.index('fromVisible', vIndex);
    let clip = dt.column(colIndex).data();
    copyArrayToClipboard(clip);
});

