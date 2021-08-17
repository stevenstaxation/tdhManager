function showFullDevice(rowNumber) {
    // get device data using AJAX call
    // fill in modal dialog
    // update SQL
  
    if (rowNumber.includes("customer")) {
        document.getElementById('hiddenDeviceSelector').value = 'customer';
        rowNumber = rowNumber.replace("customer", '');
    } else {
        document.getElementById('hiddenDeviceSelector').value = 'device';
        rowNumber = rowNumber.replace("device", '');
    }
  
    var dataToPost = {};
    dataToPost.deviceID = rowNumber;
    $.ajax({
        url: "getCurrentDevice.php",
        timeout: 30000,
        data: dataToPost,
        datatype: "json",
        type: "POST",
        success: function (data) {
            data = $.parseJSON(data);

            document.getElementById('editTDHNumber').value = data['TDHNumber'];
            document.getElementById('editSerial').value = data['serialNumber'];
            document.getElementById('editIMEI').value = data['IMEI'];
            document.getElementById('editDRIDNumber').value = data['DRIDNumber'];
            document.getElementById('editSIMNumber').value = data['SIMNumber'];
            document.getElementById('editSIMPhone').value = data['SIMPhone'];
            document.getElementById('editSIMStatus').value = data['SIMStatus'];

            document.getElementById('editConfigFile').value = data['config'];
            document.getElementById('editDeviceInstallReference').value = data['assocOrderNumber'];
            document.getElementById('editDeviceSupplierInvoice').value = data['supplierInvoice'];
            document.getElementById('editSIMDate').value = data['SIMDeactivationDate'];
            document.getElementById('editDeviceInstallDate').value = data['installDate'];
            document.getElementById('editDeviceNoteText').value = data['deviceNote'];
            document.getElementById('editDeviceInstaller').value = data['installerID'];
            document.getElementById('editDeviceSupplier').value = data['supplierID'];
            document.getElementById('editDeviceDescription').value = data['deviceDescriptionID'];
            document.getElementById('editDeviceStatus').value = data['status'];
            document.getElementById('editVRN').value = data['regNumber'];
            // document.getElementById('editVehicleDescription').value = data['make'] + data['model'] + data['addDescription'];
            document.getElementById('editOwnerID').value = data['ID'];
            document.getElementById('editDevicePurchaseDate').value = data['purchaseDate'];
            document.getElementById('hiddenDeviceID').value = rowNumber;

            $('#modalEditDevice').modal('show');
        },
        error: function () {

        }
    });

}


function addNewDevice() {
    var dataToPost = {};
    dataToPost.deviceID = document.getElementById('addDeviceDescription').value;
    dataToPost.TDHNumber = document.getElementById('addTDHNumber').value;
    dataToPost.serialNumber = document.getElementById('addSerial').value;
    dataToPost.IMEI = document.getElementById('addIMEI').value;
    dataToPost.DRID = document.getElementById('addDRIDNumber').value;
    dataToPost.SIMNumber = document.getElementById('addSIMNumber').value;
    dataToPost.SIMPhone = document.getElementById('addSIMPhone').value;
    dataToPost.SIMStatus = document.getElementById('addSIMStatus').value;
    dataToPost.SIMDeactDate = document.getElementById('addSIMDate').value;
    dataToPost.ownerID = document.getElementById('addOwnerID').value;
    dataToPost.VRN = document.getElementById('addVRN').value;
    dataToPost.configFile = document.getElementById('addConfigFile').value;
    dataToPost.currentStatus = document.getElementById('addDeviceStatus').value;
    dataToPost.installerID = document.getElementById('addDeviceInstaller').value;
    dataToPost.installDate = document.getElementById('addDeviceInstallDate').value;
    dataToPost.installerRef = document.getElementById('addDeviceInstallReference').value;
    dataToPost.supplierID = document.getElementById('addDeviceSupplierList').value;
    dataToPost.supplierRef = document.getElementById('addDeviceSupplierInvoice').value;
    dataToPost.purchaseDate = document.getElementById('addDevicePurchaseDate').value;
    dataToPost.notesText = document.getElementById('addDeviceNoteText').value;

    $.ajax({
        url: 'addNewDevice.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            if (data.includes('success')) {
                var newID = parseInt(data.replace('success', ''), 10);
                $('#getClient').trigger('change');
                showCustomers(newID);
                $('#modalAddNewDevice').modal('hide');

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

                $.ajax({
                    url: 'getAlerts.php',
                    type: 'GET',
                    success: function (data) {
                        var arr = data.split('^^^');

                        if ((arr[0] + arr[1]) != 0) {
                            $('#renewalTotal').html(+arr[0] + +arr[1]);
                            $('#renewalTotalWrapper').show();
                        } else {
                            $('#renewalTotalWrapper').hide();
                        }
                        if (arr[3] != 0) {
                            $('#installTotal').html(arr[3]);
                            $('#installTotalWrapper').show();
                        } else {
                            $('#installTotalWrapper').hide();
                        }
                        if (arr[2] != 0) {
                            $('#alertTotal').html(arr[2]);
                            $('#alertTotalWrapper').show();
                        } else {
                            $('#alertTotalWrapper').hide();
                        }
                    }
                });

            } else {
                $('#addDeviceMessage').html(data);
                $('#addDeviceMessage').show();
            }
        },
        error: function () {}
    })
}


function editCurrentDevice() {
    var dataToPost = {};
    dataToPost.deviceID = document.getElementById('hiddenDeviceID').value;
    dataToPost.ownerID = document.getElementById('editOwnerID').value;
    dataToPost.deviceDescriptionID = document.getElementById('editDeviceDescription').value;
    dataToPost.TDHNumber = document.getElementById('editTDHNumber').value;
    dataToPost.serialNumber = document.getElementById('editSerial').value;
    dataToPost.IMEI = document.getElementById('editIMEI').value;
    dataToPost.DRIDNumber = document.getElementById('editDRIDNumber').value;
    dataToPost.SIMNumber = document.getElementById('editSIMNumber').value;
    dataToPost.SIMPhone = document.getElementById('editSIMPhone').value;
    dataToPost.SIMStatus = document.getElementById('editSIMStatus').value;
    dataToPost.SIMDeactivationDate = document.getElementById('editSIMDate').value;
    dataToPost.config = document.getElementById('editConfigFile').value;
    dataToPost.regNumber = document.getElementById('editVRN').value;
    dataToPost.status = document.getElementById('editDeviceStatus').value;
    dataToPost.installerID = document.getElementById('editDeviceInstaller').value;
    dataToPost.installDate = document.getElementById('editDeviceInstallDate').value;
    dataToPost.assocOrderNumber = document.getElementById('editDeviceInstallReference').value;
    dataToPost.supplierID = document.getElementById('editDeviceSupplier').value;
    dataToPost.supplierInvoice = document.getElementById('editDeviceSupplierInvoice').value;
    dataToPost.purchaseDate = document.getElementById('editDevicePurchaseDate').value;
    dataToPost.deviceNote = document.getElementById('editDeviceNoteText').value;

    $.ajax({
        url: 'updateEditDevice.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes("success")) {
                $('#editDeviceMessage').html('');
                $('#getClient').trigger('change');
                $('#modalEditDevice').modal('hide');
                if (document.getElementById('hiddenDeviceSelector').value == 'device') {
                    $('#showDeviceList').trigger('click');
                }
                $.ajax({
                    url: 'getAlerts.php',
                    type: 'GET',
                    success: function (data) {
                        var arr = data.split('^^^');

                        if ((arr[0] + arr[1]) != 0) {
                            $('#renewalTotal').html(+arr[0] + +arr[1]);
                            $('#renewalTotalWrapper').show();
                        } else {
                            $('#renewalTotalWrapper').hide();
                        }
                        if (arr[3] != 0) {
                            $('#installTotal').html(arr[3]);
                            $('#installTotalWrapper').show();
                        } else {
                            $('#installTotalWrapper').hide();
                        }
                        if (arr[2] != 0) {
                            $('#alertTotal').html(arr[2]);
                            $('#alertTotalWrapper').show();
                        } else {
                            $('#alertTotalWrapper').hide();
                        }
                    }
                });
            } else {
                $('#editDeviceMessage').html(data);
            }
        },
        error: function () {

        }
    });

}


function showDeviceNotes(rowNumber) {

    if (rowNumber.includes("customer")) {
        document.getElementById('hiddenDeviceNotesSelector').value = 'customer';
        rowNumber = rowNumber.replace("customer", '');
    } else {
        document.getElementById('hiddenDeviceNotesSelector').value = 'device';
        rowNumber = rowNumber.replace("device", '');
    }
    var dataToPost = {};
    dataToPost.deviceID = rowNumber;
    $.ajax({
        url: "getCurrentDeviceNotes.php",
        timeout: 30000,
        data: dataToPost,
        datatype: "json",
        type: "POST",
        success: function (data) {
            data = $.parseJSON(data);
            document.getElementById('editDeviceNotesText').value = data['deviceNote'];
            document.getElementById('hiddenDeviceNotesID').value = rowNumber;
            $('#modalEditDeviceNotes').modal('show');
        },
        error: function () {

        }
    });

}


function editCurrentDeviceNotes() {
    var dataToPost = {};
    dataToPost.deviceID = document.getElementById('hiddenDeviceNotesID').value;
    dataToPost.deviceNote = document.getElementById('editDeviceNotesText').value;

    $.ajax({
        url: 'updateEditDeviceNotes.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes("success")) {
                $('#editDeviceNotesMessage').html('');
                $('#modalEditDeviceNotes').modal('hide');
                
                $('#showDeviceList').trigger('click');
                

            } else {
                $('#editDeviceMessage').html(data);
            }
        },
        error: function () {

        }
    });
}

function deletePhysicalDevice() {
        var dataToPost = {};
        // var e = document.getElementById('editDeviceDescription');
        // if (e.selectedIndex==-1) {
        //     return;
        // }
        dataToPost.deviceNumber = document.getElementById('hiddenDeviceID').value;
        
        $.ajax({
            url: "deletePhysicalDevice.php",
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if (data.includes("success")) {
                    $('#editDeviceMessage').html('');
                    $('#modalEditDevice').modal('hide');
                    if (document.getElementById('hiddenDeviceSelector').value == 'device') {
                        $('#showDeviceList').trigger('click');
                    } else {
                        $('#getClient').trigger('change');
                        var newID = parseInt(data.replace('success', ''), 10);
                        showCustomers(newID);
                    }
    
                } else {
                    $('#editDeviceMessage').html(data);
                }

            }

        })


}

$(document).on('click', '#deviceFilterClicked', function (event) {
    "use strict";
    event.preventDefault();
    var dataToPost = {};
    dataToPost.FilterCustomer = document.getElementById('getCustomerSelect').value;
    dataToPost.FilterType = document.getElementById('byDeviceType').value;
    dataToPost.FilterOtherTerm = document.getElementById('byOther').value;
    dataToPost.SQLFilter = '';

    $.ajax({
        url: 'filterDevices.php',
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            dataToPost.SQLFilter = data;
            $.ajax({
                url: "deviceList.php",
                type: "POST",
                data: dataToPost,
                success: function (data) {
                    $('#devicesList').html(data);
                },
                error: function () {
                    $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
                }
            });
        },
        error: function () {

        }
    });
});

$(document).on("click", '#showDeviceList', function () {
    var dataToPost = {};
    dataToPost.SQLFilter = '';
    $.ajax({
        url: "deviceList.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#homeScreen').hide();
            $('#eventLog').html('');
            $('#devicesList').html(data);
            $('#vehicleList').html('');
        },
        error: function () {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
        }
    });
});

$(document).on('focusin', '#textAddOrUpdateDevice', function (event) {
    event.preventDefault();
    document.getElementById('addOrUpdateDevice').disabled = false;
    $('#deviceErrorBox').html('')
});

$(document).on('click', '#deviceList', function (event) {
    event.preventDefault();
    if (!event.target.options) {
        document.getElementById('textAddOrUpdateDevice').value = event.target.innerText;
        $('#addOrUpdateDevice').text('Update');
        document.getElementById('addOrUpdateDevice').disabled = false;
        document.getElementById('deleteDevice').disabled = false;
        document.getElementById('cancelUpdateDevice').style.display = "block";
        document.getElementById('cancelUpdateDevice').disabled = false;
    }
});

$(document).on('click', '#cancelUpdateDevice', function (event) {
    event.preventDefault();
    $('#showGlobalSettings').trigger('click');
});

$(document).on('click', '#addOrUpdateDevice', function (event) {
    event.preventDefault();
    if ($('#addOrUpdateDevice').text() == 'Add') {
        var dataToPost = {};
        dataToPost.deviceNameToAdd = document.getElementById('textAddOrUpdateDevice').value;
        $.ajax({
            url: "addDevice.php",
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                if (data.includes('success')) {
                    $('#showGlobalSettings').trigger('click');
                } else {
                    $('#deviceErrorBox').html(data);
                }
            },
            error: function () {}
        });
    }
    if ($('#addOrUpdateDevice').text() == 'Update') {
        var dataToPost = {};
        dataToPost.deviceIDToUpdate = $("#deviceList option:selected").val();
        dataToPost.deviceNameToUpdate = document.getElementById('textAddOrUpdateDevice').value;

        $.ajax({
            url: "updateDevice.php",
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                if (data.includes('success')) {
                    $('#showGlobalSettings').trigger('click');
                    $('#addOrUpdateDevice').text('Add');
                } else {
                    $('#deviceErrorBox').html(data);
                }
            },
            error: function () {}
        });
    }
});

$(document).on('click', '#deleteDevice', function (event) {
    event.preventDefault();
    var dataToPost = {};
    dataToPost.deviceIDToDelete = $("#deviceList option:selected").val();

    $.ajax({
        url: "deleteDevice.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes('success')) {
                $('#showGlobalSettings').trigger('click');
                $('#addOrUpdateDevice').text('Add');
            } else {
                $('#deviceErrorBox').html(data);
            }
        },
        error: function () {}
    });
});

     $(document).on('show.bs.modal', '#modalAddNewDevice', function (event) {
         $(this).find('form').trigger('reset');
         $('#addDeviceMessage').html('');
     });

     $(document).on('show.bs.modal', '#modalEditDevice', function (event) {
    //     // $(this).find('form').trigger('reset');
         $('#editDeviceMessage').html('');
     });

function allocateDevice(deviceToAllocate) {
    $('#modalGetCustomerAndVRN').modal('show');
    document.getElementById('hiddenAllocateID').innerHTML = deviceToAllocate;

    }