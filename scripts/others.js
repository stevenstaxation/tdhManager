

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

function updateEditOther() {
    var dataToPost = {};
    dataToPost.otherName = document.getElementById('editOtherName').value;
    dataToPost.otherAddress1 = document.getElementById('editOtherAddress1').value;
    dataToPost.otherAddress2 = document.getElementById('editOtherAddress2').value;
    dataToPost.otherAddress3 = document.getElementById('editOtherAddress3').value;
    dataToPost.otherAddress4 = document.getElementById('editOtherAddress4').value;
    dataToPost.otherAddress5 = document.getElementById('editOtherAddress5').value;
    dataToPost.otherService = document.getElementById('editOtherService').value;
    dataToPost.otherID = document.getElementById('editOtherHide').value;
    if (!dataToPost.otherID) {
        return
    }
    $.ajax({
        url: 'updateOther.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            $('#editOtherMessage').css("display", "block");

            if (data.includes('success')) {
                $('#editOtherMessage').html('');
                $('#getClient').trigger('change');
                $('#otherNameSelection').trigger('change');
                $('#editOtherMessage').html("<div class='alert alert-success'>Updated successfully</div>");
                $('#editOtherMessage').delay(3000).hide(0);
            } else {
                $('#editOtherMessage').html(data);
                $('#editOtherMessage').delay(3000).hide(0);
            }
        },
        error: function () {

        }
    });
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
                document.getElementById('editOtherService').value = data['otherService'];
                
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


    new swal ({
        title: "Confirm delete",
        text: "Are you sure you want to delete?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: 'Yes - Delete',
        denyButtonText: 'Cancel',
    }).then ((result) =>{
  
    if (result.isConfirmed) {
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

function readURL(input) {
    console.log('read');
    
    if (input.files && input.files[0]) {
  
      var reader = new FileReader();
  
      reader.onload = function(e) {
        $('.image-upload-wrap').hide();
  
        $('.file-upload-image').attr('src', e.target.result);
        $('.file-upload-content').show();
  
        $('.image-title').html(input.files[0].name);
      };
  
    
    //    reader.readAsDataURL(input.files[0]);
     
  
    } else {
      removeUpload();
    }
  }
   
  function readURL2(input) {
    if (input.files && input.files[0]) {
  
      var reader = new FileReader();
  
      reader.onload = function(e) {
        $('.image-upload-wrap2').hide();
  
        $('.file-upload-image2').attr('src', e.target.result);
        $('.file-upload-content2').show();
  
        $('.image-title').html(input.files[0].name);
      };
  
    //   reader.readAsDataURL(input.files[0]);
  
    } else {
      removeUpload();
    }
  }

  function formatAsCurrency(number) {
    if (number==='') {return};
    
    if (number.indexOf('.') >=0) {
        var decimal_position = number.indexOf('.');
        var pounds = number.substring(0,decimal_position);
        var pence = number.substring(decimal_position);
        pence = pence.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "");
        pence +="00";
        pence = pence.substring(0,2);
        number = `${pounds}.${pence}`;
    } else {
        number = number.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "");
        number +=".00";
    }

    return number;

  }

var fileObject;

function uploadFile(e) {
    e.preventDefault();
    fileObject = e.dataTransfer.files[0];
    ajaxFileUpload(fileObject);
}

$(document).on('click', '#uploadButton', function (event) {
    document.getElementById('selectFile').click();
    document.getElementById('selectFile').onchange = function() {
        fileObject = document.getElementById('selectFile').files[0];
        ajaxFileUpload(fileObject);
    }
})

$(document).on('click', '#uploadRegPic', function(event) {
    document.getElementById('uploadRegPic').click();
    document.getElementById('uploadRegPic').onchange = function() {
        fileObject = document.getElementById('uploadRegPic').files[0];
        var regPicContent = document.querySelector('#regPicContent');
        ajaxFileGetUpload(fileObject, regPicContent);
        $('#regPicContent').addClass('imageLoaded');
    }
})

$(document).on('click', '#uploadDevicePic', function(event) {
    document.getElementById('uploadDevicePic').click();
    document.getElementById('uploadDevicePic').onchange = function() {
        fileObject = document.getElementById('uploadDevicePic').files[0];
        var regDeviceContent = document.querySelector('#devicePicContent');
        ajaxFileGetUpload(fileObject, regDeviceContent);
        regDeviceContent.className = 'imageLoaded';
        $('#devicePicContent').addClass('imageLoaded');
    }
})


function ajaxFileGetUpload(fileObj, picSelector) {

    if (fileObj !=undefined) {
        var formData = new FormData();
        formData.append('file', fileObj);
        
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "uploadImage.php", true);
        
        xhttp.onload = function(event) {
            oOutput = picSelector;

            if (xhttp.status == 200) {
                oOutput.innerHTML = `<img src='${this.responseText}' width='200'>`;
            } else {
                oOutput.innerHTML = `Error ${xhttp.status} occurred when trying to upload your file.`;
                oOutput.removeClass('imageLoaded');
            }
        }

        xhttp.send(formData);
    }
}

function ajaxFileUpload(fileObj) {

    if (fileObj !=undefined) {
        var formData = new FormData();
        formData.append('file', fileObj);
        formData.append('selector', $('#hiddenUploadTypeSelector').val());
        
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "upload.php", true);
        
        xhttp.onload = function(event) {
            oOutput = document.querySelector('.imageContent');

            if (xhttp.status == 200) {
                oOutput.innerHTML = this.responseText;
            } else {
                oOutput.innerHTML = `Error ${xhttp.status} occurred when trying to upload your file.`;
            }
        }

        xhttp.send(formData);
    }
}

$(document).on('click', '#downloadDeviceTemplate', function (event) {
    var csv = "Model, Platform, Serial, IMEI, DeviceStatus, DRIDNumber, SimSerialNo, SimPhone, Customer\n";
    var hiddenElement = document.createElement('a');
    hiddenElement.href = `data:text/csv;charset=utf-8,${encodeURI(csv)}`;
    hiddenElement.target = '_blank';
    hiddenElement.download = 'bulkUploadDevices.csv';
    hiddenElement.click();

})

$(document).on('click', '#downloadVehicleTemplate', function (event) {
    var csv = "RegNumber, CameraRequired, Status, InstallDate, Customer\n";
    var hiddenElement = document.createElement('a');
    hiddenElement.href = `data:text/csv;charset=utf-8,${encodeURI(csv)}`;
    hiddenElement.target = '_blank';
    hiddenElement.download = 'bulkUploadVehicles.csv';
    hiddenElement.click();

})

function printPDFJobsList() {
    
    $.post("PDFJobsAll.php",
    {
        engineerID: $('#getEngineer').val(),
        dateBookedFrom: $('#dateBookedFrom').val(),
        dateBookedTo: $('#dateBookedTo').val(),
        dateAddedFrom: $('#dateAddedFrom').val(),
        dateAddedTo: $('#dateAddedTo').val(),
        statusComplete: $('#includeComplete').is(':checked'),
        statusPending: $('#includePending').is(':checked'),
        statusBooked: $('#includeBooked').is(':checked'),
        statusOverdue: $('#includeOverdue').is(':checked'),
        statusApproval: $('#includeApproval').is(':checked')
    }, function (response) {
          window.open ('PDFJobsAll.php');
    }
    );
   
}

