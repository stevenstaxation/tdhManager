$(document).on('click', '#vehicleFilterClicked', function(event) {
    "use strict";
    event.preventDefault();
    var dataToPost = {};
    dataToPost.FilterVRN = document.getElementById('VRNToLookup').value;
  //   dataToPost.FilterVRN = dataToPost.FilterVRN.replace(/ /g,'').toUpperCase();
  //   dataToPost.FilterTDHNumber = document.getElementById('TDHToLookup').value;
    dataToPost.FilterCustomer = document.getElementById('getCustomerSelect').value;
    dataToPost.FilterInsurer = document.getElementById('getInsurerSelect').value;

    $.ajax({
        url: 'filterVehicles.php',
        data: dataToPost,
        type: "POST",
        success: function(data) {
          dataToPost.SQLFilter = data;

          $.ajax({
              url: "vehicleList.php",
              type: "POST",
              data: dataToPost,
              success: function(data) { 
                  $('#vehicleList').html(data);
              },
              error: function() {
                  $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
              }
          });
        },
        error: function() {

        }
    });
  });


  $('#modalAddVehicle').on('hidden.bs.modal', function(event) {
    $(this).find('form').trigger('reset');
    $('#addVehicleErrorBox').html('');
});



$(document).on("click", '#showVehicleList', function() {
    var dataToPost = {};
    dataToPost.SQLFilter='';
    $.ajax({
        url: "vehicleList.php",
        type: "POST",
        data: dataToPost,
        success: function(data) {
          $('#accountInfo').html('');
          $('#customerSelect').html('');
          $('#customerInfo').html('');
          $('#overlay').html('');
          $('#homeScreen').hide();
          $('#eventLog').html('');
          $('#devicesList').html('');
          $('#vehicleList').html(data);
        },
        error: function() {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
        }
    });
  });

  $(document).on('blur', '#editVRN', function(event) {
    // prevent default PHP processing
    document.getElementById('editVehicleDescription').value = 'searching...';
    var dataToPost = {};
    dataToPost.VRN = $('#editVRN').val();
    $.ajax({
        url: 'scrapeVRN.php',
        timeout: 30000,
        dataType: 'json',
        data: dataToPost,
        type: "POST",
        success: function(data) {
            var parseableData = (data);

            document.getElementById('editVehicleDescription').value = parseableData['Make'] + parseableData['Model'] + parseableData['other'];
        },
        error: function() {

        }
    });
});

$(document).on('click', '#findVehicleRegNumber', function(event) {
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
        success: function(data) {
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
             document.getElementById('addVehicleMake').value = arr[1];
             document.getElementById('addVehicleModel').value = arr[2];
             document.getElementById('addVehicleAddDescription').value = arr[3];
             document.getElementById('addVehicleAllocateTo').value = arr[4];
             document.getElementById('hiddenVehicleID').value = arr[5];
             document.getElementById('lookUpProgress').style.visibility = "hidden";
        },
        error: function() {

        }
    });
});

function addNewVehicle() {
    var dataToPost = {};
    dataToPost.regNumber = document.getElementById('addVehicleRegNumber').value;
    dataToPost.make = document.getElementById('addVehicleMake').value;
    dataToPost.model = document.getElementById('addVehicleModel').value;
    dataToPost.addDescription = document.getElementById('addVehicleAddDescription').value;
    dataToPost.allocateTo = document.getElementById('hiddenVehicleID').value;
    $.ajax ({
        url: 'addNewVehicle.php',
        type: "POST",
        data: dataToPost,
        success: function(data) {
            if (data=='success') {
                $('#modalAddVehicle').modal('hide');
                $('#getClient').trigger('change');
            } else {
                $('#addVehicleErrorBox').html(data);
            }
        },
        error: function() {

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
      success: function(data) {
           data = $.parseJSON(data);
       
           document.getElementById('editVehicleRegNumber').value = data['regNumber'];
           document.getElementById('editVehicleMake').value = data['make'];
           document.getElementById('editVehicleModel').value = data['model'];
           document.getElementById('editVehicleAddDescription').value = data['addDescription'];
           document.getElementById('vehicleAllocateTo').value = data['businessName'];
          //  document.getElementById('vehicleTDHNumber').value = data['TDHNumber'];
          //  document.getElementById('vehicleSerialNumber').value = data['serialNumber'];
          //  document.getElementById('vehicleIMEI').value = data['IMEI'];
           document.getElementById('hiddenVehicleID').value = rowNumber;


           $('#modalVehicleShow').modal('show');
      },
      error: function() {

      }
  });
}

function editCurrentVehicle() {
  var dataToPost = {};
  dataToPost.regNumber = document.getElementById('editVehicleRegNumber').value;
  dataToPost.make = document.getElementById('editVehicleMake').value;
  dataToPost.model = document.getElementById('editVehicleModel').value;
  dataToPost.addDescription = document.getElementById('editVehicleAddDescription').value;
  dataToPost.vehicleID = document.getElementById('hiddenVehicleID').value;

  $.ajax({
    url: 'updateCurrentVehicle.php',
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function(data) {
      $('#modalVehicleShow').modal('hide');
      $('#vehicleFilterClicked').trigger('click');
    },
    error: function() {

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
        success: function(data) {
            if (data.includes("success")) {
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



