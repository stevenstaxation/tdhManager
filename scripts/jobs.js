// Reset the Add New Job Modal fields when form is closed
$('#modalAddNewJobRequest').on('hidden.bs.modal', function() {
    $(this).find('form').trigger('reset');
    $('#jobRequestMessage').html('');
});


// When adding a job and the customer name is changed then this routine will
// change the customer's vehicle list and get the customer's default contact
$(document).on("change", '#jobCustomerName', function () {
    dataToPost = {}
    dataToPost.customerSelected = $('#jobCustomerName').val();
    $.ajax({
        url: 'getVehiclesByCustomer.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            var old = "<option value='0' disabled selected>select VRN</option>" + data;
            $('.addJobTypeOldVRN').html(old);           
            data = "<option value='0' disabled selected>select VRN</option>" + data;
            $('.addJobTypeVRN').html(data);
            if ($('.addVRNButton').hasClass('disabled') && $('#jobCustomerName').val()!=null) {
                $('.addVRNButton').removeClass('disabled');
            }
        },
        error: function() {
        }
    });

    $.ajax({
        url: 'getContactByCustomer.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            data = $.parseJSON(data);
            if (!data) {
                $('#jobContactName').val ('');
                $('#jobContactEmail').val ('');
                $('#jobContactPhone').val ('');
                return
            };

            if (data.firstName && data.lastName) {
                $('#jobContactName').val (data.firstName + " " + data.lastName);
            } else if (data.firstName && !data.lastName) {
                $('#jobContactName').val (data.firstName);
            } else if(!data.firstName && data.lastName) {
                $('#jobContactName').val (data.lastName);
            } else {
                $('#jobContactName').val ('');
            }

            if (data.email) {
                $('#jobContactEmail').val (data.email);
            } else {
                $('#jobContactEmail').val ('');
            }

            if (data.telephone && data.mobileNo) {
                $('#jobContactPhone').val (data.telephone + "/" + data.mobileNo);
            } else if (data.telephone && !data.mobileNo) {
                $('#jobContactPhone').val (data.telephone);
            } else if (!data.telephone && data.mobileNo) {
                $('#jobContactPhone').val (data.mobileNo);
            } else {
                $('#jobContactPhone').val ('');
            }           
        },
        error: function() {
        }
    });

});

// When editing a job a change in the dropdown of customer names runs this routine 
// to get the customer's vehicles and change the vehicle dropdown list 
$(document).on("change", '#editJobCustomerName', function () {
    dataToPost = {}
    dataToPost.customerSelected = $('#editJobCustomerName').val();
    $.ajax({
        url: 'getVehiclesByCustomer.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            var old = "<option value='0' disabled selected>Not Applicable</option>" + data;
            $('.addJobTypeOldVRN').html(old);                   
            $('#editJobVRN').html(data);
        },
        error: function() {
        }
    });
})

// If selected job type does not include either 'deinstall' or 'de-install' 
// then disable the Old VRM dropdown
$(document).on("change", '#jobJobType', function() {
    var selectedType = $('#jobJobType option:selected').text().toUpperCase();
    
    if (selectedType.includes('DEINSTALL') || selectedType.includes('DE-INSTALL')) {
        $('.addJobTypeOldVRN').prop('disabled', false);
        $('.addJobTypeVRN').prop('disabled', true);       
    } else {
        $('.addJobTypeOldVRN').prop('disabled', true);
        $('.addJobTypeVRN').prop('disabled', false);
    }
});
$(document).on("change", '#editJobType', function() {
    var selectedType = $('#editJobType option:selected').text().toUpperCase();

    if (selectedType.includes('DEINSTALL') || selectedType.includes('DE-INSTALL')) {
        $('#editJobOldVRN').prop('disabled', false);
        $('#editJobVRN').prop('disabled', true);       
    } else {
        $('#editJobOldVRN').prop('disabled', true);
        $('#editJobVRN').prop('disabled', false);
    }
});

// When adding a job, if the job quantity is changed then
$(document).on("change", '#jobQuantity', function() {
    // Maximum quantity is 50
    if ($('#jobQuantity').val() > 50) {
        $('#jobQuantity').val('50'); 
    }
    // Get empty template for old VRN dropdown list, VRN dropdown list and new button for the quantity selected
    var dataToPost = {};
    dataToPost.Quantity = $('#jobQuantity').val();
    $.ajax({
        url: 'getVRNControlList.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            $('#VRNListForJob').html(data);
            $('#jobCustomerName').trigger('change');
        },
        error: function() {
        }
    })
});

// When job rate field loses focus, then format it as currency
$(document).on("blur", '#jobRate', function() {
    $('#jobRate').val(formatAsCurrency($('#jobRate').val()));
});

// When editing a job, if the booking date changes/when focus is lost
// set the job status, e.g. Pending, Booked date passed.
$(document).on("blur", '#editJobDateBooked', function() {
    var today = new Date().getTime();
    var jobWhen = new Date(document.getElementById('editJobDateBooked').value).getTime();

    if ($('#editHubCompleted').prop('checked') == true) {
        $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #198754;'>COMPLETE</span></h6>")
    } else if ($('#editJobCompleted').prop('checked') == true) {
        $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #FFAA00;'>AWAITING APPROVAL</span></h6>")
    }
    else if (isNaN(jobWhen)) {
        $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #FFAA00;'>PENDING</span></h6>")
    } else if (today > jobWhen) {
        $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #b60000;'>BOOKED - DATE PASSED</span></h6>")
    } else if (jobWhen > today) {
        $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #FFAA00;'>BOOKED</span></h6>")
    } else {
        $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #FFAA00;'>NEW JOB SETUP</span></h6>")
    }
});



function addNewJob() {
  
    var dataToPost = {};
   
    // dataToPost = $('#getAddJob').serializeArray();

    dataToPost.jobCustomerName = $('#jobCustomerName').val();
    dataToPost.jobJobType = $('#jobJobType').val();
    dataToPost.jobTypeString = $('#jobJobType option:selected').text();
    dataToPost.jobCameraType = $('#jobCameraType').val();
    dataToPost.jobQuantity = $('#jobQuantity').val();

 
    if ($('#LT').is(":checked")) {dataToPost.jobLT = 'on' } else { dataToPost.jobLT = 'off' }
    if ($('#SS').is(":checked")) {dataToPost.jobSS = 'on' } else { dataToPost.jobSS = 'off' }


    dataToPost.jobPriority = $('#jobPriority').val();
    dataToPost.jobRate = $('#jobRate').val();
    dataToPost.jobNotes = $('#jobNotes').val();
    dataToPost.jobContactName = $('#jobContactName').val();
    dataToPost.jobContactEmail = $('#jobContactEmail').val();
    dataToPost.jobContactPhone = $('#jobContactPhone').val();
    dataToPost.jobInstallAddress = $('#jobInstallAddress').val();


    // VRN's
    var vehicles = document.getElementsByClassName('addJobTypeVRN')
    dataToPost.VRN = {};
    for(var ix=0;ix < vehicles.length-1;ix++){
        dataToPost.VRN[ix] = vehicles[ix].value;
    }

    var vehicles = document.getElementsByClassName('addJobTypeOldVRN') 
    dataToPost.OldVRN = {};
    for(var ix=0;ix < vehicles.length-1;ix++){
        dataToPost.OldVRN[ix] = vehicles[ix].value;
    }
       
        
    dataToPost.bookingLocation = $('#bookingLocation').val();
    dataToPost.engineerAssigned = $('#engineerAssigned').val();
    dataToPost.jobDateBooked = $('#jobDateBooked').val();
    dataToPost.jobStatus = 0; // new job setup
      
    $.ajax({
        url: "addNewJob.php",
        timeout: 30000,
        type: "POST",
        data: dataToPost,
        success: function(data) {
            if (data.includes('success')) {
                var newID = parseInt(data.replace("success",''),10);

                if (document.getElementById('hiddenJobSelector').value=='job') {
                    $('#showJobList').trigger('click');
                } else {
                    $('#getClient').trigger('change');
                    showCustomers(newID);

                    var dataToPost = {};
                    dataToPost.selectedValue = newID;

                    $.ajax({
                        url: 'customers.php',
                        type: 'POST',
                        data: dataToPost,
                        success: function(data) {
                            $('#customerInfo').html(data);
                        },
                        error: function() {}
                    });
                    } 
                $('#modalAddNewJobRequest').modal('hide');
                $('#modalAddNewJobRequest').trigger('reset');      
            } else {
                document.getElementById('jobRequestMessage').innerHTML = data;
            }
   
        }
        
    });

}


function showFullJob(rowNumber) {
   
    var dataToPost = {};
    // dataToPost.jobCustomer = '';
    var editMode = '';
    if (rowNumber.includes('edit')) {
        rowNumber = rowNumber.replace('edit','');
        editMode = 'edit';
    } else {
        rowNumber = rowNumber.replace('view','');
        editMode = 'view';
    }

    if (rowNumber.includes('j')) {
        rowNumber = rowNumber.replace('j','');
        $('#hiddenJobSelector').val('job');
        var dtp = {};
        dtp.jobID = rowNumber;
        $.ajax ({
            url: 'getJobCustomer.php',
            data: dtp,
            type: "POST",
            success: function(data) {
                $('#hiddenCustomerID').text(data);
             
                }
            })
    } 

    dataToPost.jobCustomer = $('#hiddenCustomerID').text();  
    dataToPost.jobID = rowNumber;
    document.getElementById('hiddenJobID').text = rowNumber;
    var currentVRN;
    var oldVRN;

    $.when(
        $.ajax({
            url: 'getJobDropDowns.php',
            timeout: 30000,
            data: dataToPost,
            type: 'POST',
            success: function(data) {
                data = $.parseJSON(data);  
                $("#editJobCustomerName").val(data['ownerID']);
                $('#editJobCustomerName').trigger('change');
                $('#editJobType').val(data['jobType']);
                $('#editJobCameraType').val(data['cameraTypeID']);
                $('#editJobPriority').val(data['priorityIsUrgent']);
                $('#editJobRate').val(formatAsCurrency(data['JobRate']));
                $('#editJobNotes').val(data['notes']);
                $('#editJobContactName').val(data['bookingContact']);
                $('#editJobContactEmail').val(data['bookingEmail']);
                $('#editJobContactPhone').val(data['BookingTelephone']);
                $('#editJobInstallAddress').val(data['bookingAddress']);
                $('#editBookingLocation').val(data['equipmentLocationID']);
                $('#editEngineerAssigned').val(data['engineerID']);
                if ((data['date'])!=null) {
                    $bookedDate = data['date'].substring(0,10)  + "T" + data['date'].substring(11);
                } else {
                    $bookedDate='';
                }
                $('#editJobDateBooked').val($bookedDate);
                $('#editJobCompleted').val(data['jobCompleteFlag']);
                $('#editHubCompleted').val(data['TDHSignOff']);
                currentVRN =  data['VRN'];
                oldVRN = data['oldVRN'];
                document.getElementById('regPicContent').innerHTML = '';
                document.getElementById('devicePicContent').innerHTML = ''; 
                $("#regPicContent").removeClass('imageLoaded');
                $("#devicePicContent").removeClass('imageLoaded');

                if (data['regPicFilename']) {
                    document.getElementById('regPicContent').innerHTML = "<img src = '" + data['regPicFilename'] +"' width='160'>";
                    $("#regPicContent").addClass('imageLoaded');
                }
                if (data['regPicDeviceDetails']) {
                    document.getElementById('devicePicContent').innerHTML = "<img src = '" + data ['regPicDeviceDetails'] +"' width='160'>";
                    $("#devicePicContent").addClass('imageLoaded');
                }
                if ((data['otherKitFlag'] & 1) ==1) {
                    $('#editLT').prop('checked',true);
                } else {
                    $('#editLT').prop('checked',false);    
                }
                if ((data['otherKitFlag'] & 2) ==2) {
                    $('#editSS').prop('checked',true);
                } else {
                    $('#editSS').prop('checked',false);    
                }
                if (data['jobCompleteFlag'] == 1) {
                    $('#editJobCompleted').prop('checked', true);
                } else {
                    $('#editJobCompleted').prop('checked', false); 
                }
                if (data['TDHSignOff'] == 1) {
                    $('#editHubCompleted').prop('checked', true);
                } else {
                    $('#editHubCompleted').prop('checked', false); 
                }
             
                var today = new Date().getTime();
                var jobWhen = new Date(data['date']).getTime();

                if (data['TDHSignOff'] == 1) {
                    $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #198754;'>COMPLETE</span></h6>");
                    $('#engineerInvoice').val(data['engineerInvoiceNo']);
                } else if (data['jobCompleteFlag'] ==1) {
                    $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #ffaa00;'>AWAITING APPROVAL</span></h6>"); 
                    $('#engineerInvoice').val(data['engineerInvoiceNo']);
                }
                else if (jobWhen == 0) {
                    $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #ffaa00;'>PENDING</span></h6>");
                } else if (today > jobWhen) {
                    $('#editJobDateBooked').prop('color','red');
                    $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #b60000;'>BOOKED - DATE PASSED</span></h6>");
                } else if (jobWhen > today) {
                    $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #ffaa00;'>BOOKED</span></h6>");
                }

                $('#modalEditNewJobRequest').modal('show'); 

                
        },
        error: function() {

        }
    })
).done (function () {
    if (currentVRN == null) {
        currentVRN=0;
    }
    if (oldVRN == null) {
        console ('twas nil')
        oldVRN=0;
    }
    console.log($('#editJobVRN').val());
    console.log($('#editJobOldVRN').val());
    
    $('#editJobVRN').val(parseInt(currentVRN)).change();
    $('#editJobOldVRN').val(parseInt(oldVRN)).change();
    
    console.log(parseInt(currentVRN));
    console.log(parseInt(oldVRN));
    console.log($('#editJobVRN').val());
    console.log($('#editJobOldVRN').val());
    
    });
}

function editJobComplete(buttonClicked) {
    var updateType = $('#editJobComplete').text();
    if (buttonClicked == 2) {
        updateType='Update';
    }

    var dataToPost = {};
    dataToPost.jobID = document.getElementById('hiddenJobID').text;


    if (updateType=='Mark as Outstanding') {
        dataToPost.jobStatus = 'allowUpdate';
    } else if (updateType=='Mark as Complete') {
        dataToPost.jobStatus = 'allowEdit';
        dataToPost.jobDate = document.getElementById('editJobDate').value;
        dataToPost.jobType = document.getElementById('editJobTypeType').value;
        dataToPost.jobVRN = document.getElementById('editJobTypeVRN').value;
        dataToPost.jobNotes = document.getElementById('editJobNotes').value;
    } else if (updateType=='Update') {
        dataToPost.jobStatus = 'updateOnly';
        dataToPost.jobDate = document.getElementById('editJobDate').value;
        dataToPost.jobType = document.getElementById('editJobTypeType').value;
        dataToPost.jobVRN = document.getElementById('editJobTypeVRN').value;
        dataToPost.jobNotes = document.getElementById('editJobNotes').value;
    }

    $.ajax ({
        url: 'updateJobRequest.php',
        timeout: 30000,
        data: dataToPost,
        type: 'POST',
        success: function(data) {
            $('#getClient').trigger('change');
            $('#showJobList').trigger('change')
            $('#modalEditNewJobRequest').modal('hide');
    
        },
        error: function() {

        }
    });
}

function ShowJobRequests() {
    $.ajax({
        url: 'getOSJobRequests',
        type: 'POST',
        success: function(data) {
            document.getElementById('alertScreen').innerHTML = data;
        }
    });
}

function showJobNotes(rowNumber) {

    if (rowNumber.includes("customer")) {
        document.getElementById('hiddenJobNotesSelector').value = 'customer';
        rowNumber = rowNumber.replace("customer", '');
    } else if (rowNumber.includes("job")) {
        document.getElementById('hiddenJobNotesSelector').value = 'job';
        rowNumber = rowNumber.replace("job", '');
    } else if (rowNumber.includes("DHI")) {
        document.getElementById('hiddenJobNotesSelector').value = 'DHI';
        rowNumber = rowNumber.replace("DHI", '');
    }

    var dataToPost = {};
    dataToPost.jobID = rowNumber;
    $.ajax({
        url: "getCurrentJobNotes.php",
        timeout: 30000,
        data: dataToPost,
        datatype: "json",
        type: "POST",
        success: function (data) {
            data = $.parseJSON(data);
            document.getElementById('editJobNotesText').value = data['notes'];
            document.getElementById('hiddenJobNotesID').value = rowNumber;
            $('#modalEditJobNotes').modal('show');
        },
        error: function () {

        }
    });
}

function editCurrentJobNotes() {
    var dataToPost = {};
    dataToPost.jobID = document.getElementById('hiddenJobNotesID').value;
    dataToPost.jobNote = document.getElementById('editJobNotesText').value;


    $.ajax({
        url: 'updateEditJobNotes.php',
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
            if (data.includes("success")) {
                $('#editJobNotesMessage').html('');
                $('#modalEditJobNotes').modal('hide');

                if (document.getElementById('hiddenJobNotesSelector').value=='job') {
                    $('#showJobList').trigger('change');
                } else {
                    $('#getClient').trigger('change');
                }

            } else {
                $('#editJobMessage').html(data);
            }
        },
        error: function () {

        }
    });
}

function editCurrentJob() {
    var dataToPost = {};
    dataToPost.jobID = document.getElementById('hiddenJobID').text;
    dataToPost.customerID = document.getElementById('editJobCustomerName').value;
    dataToPost.jobType = document.getElementById('editJobType').value;
    dataToPost.cameraType = document.getElementById('editJobCameraType').value;
    dataToPost.jobPriority = document.getElementById('editJobPriority').value;
    dataToPost.LTAlarm = $('#editLT').prop('checked');
    dataToPost.SideSensor = $('#editSS').prop('checked');
    var jR = document.getElementById('editJobRate');
    if (jR != null) {
        dataToPost.jobRate = jR.value;
    } else {
        dataToPost.jobRate = 0;
    }
    dataToPost.jobNotes = document.getElementById('editJobNotes').value;
    dataToPost.jobContact = document.getElementById('editJobContactName').value;
    dataToPost.jobEmail = document.getElementById('editJobContactEmail').value;
    dataToPost.jobPhone = document.getElementById('editJobContactPhone').value;
    dataToPost.jobVRN = document.getElementById('editJobVRN').value; 
    dataToPost.oldVRN = document.getElementById('editJobOldVRN').value; 
    dataToPost.jobInstallAddress = document.getElementById('editJobInstallAddress').value; 
    dataToPost.jobLocation = document.getElementById('editBookingLocation').value; 
    dataToPost.jobEngineer = document.getElementById('editEngineerAssigned').value; 
    dataToPost.jobDateBooked = document.getElementById('editJobDateBooked').value;
    dataToPost.jobCompleted = $('#editJobCompleted').prop('checked');
    dataToPost.TDHSignOff = $('#editHubCompleted').prop('checked');
    dataToPost.picReg = $('#regPicContent img').attr('src');
    dataToPost.picDevice = $('#devicePicContent img').attr('src');

    var today = new Date().getTime();
    var jobWhen = new Date(document.getElementById('editJobDateBooked').value).getTime();

    if (dataToPost.TDHSignOff == true) {
        dataToPost.jobStatus = 16; //complete
    } else if (dataToPost.jobCompleted == true) {
        dataToPost.jobStatus = 8; // Awaiting Approval
    }
    else if (isNaN(jobWhen)) {
        dataToPost.jobStatus = 1; // Pending
    } else if (today > jobWhen) {
        dataToPost.jobStatus = 4; // Booked - date passed
    } else if (jobWhen > today) {
        dataToPost.jobStatus = 2; // booked
    } else {
        dataToPost.jobStatus = 1; // new job??
    }

    
  
   // check data entered and save (or not)
   $.ajax({
    url: 'updateJobRequest.php',
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
        if (data.includes("success")) {
            $('#editJobMessage').html('');
            $('#modalEditNewJobRequest').modal('hide');

            if (document.getElementById('hiddenJobSelector').value=='job') {
                $('#showJobList').trigger('click');
            } else {
                $('#getClient').trigger('change');
                // showCustomers(newID);

                // var dataToPost = {};
                // dataToPost.selectedValue = newID;

                // $.ajax({
                //     url: 'customers.php',
                //     type: 'POST',
                //     data: dataToPost,
                //     success: function(data) {
                //         $('#customerInfo').html(data);
                //     },
                //     error: function() {}
                // });
                } 

        } else {
            $('#editJobMessage').html(data);
        }
    },
    error: function () {

    }
});

}

function deleteCurrentJob() {
    var dataToPost = {};
    dataToPost.jobID = document.getElementById('hiddenJobID').text;

   
    $.ajax ({
        url: "deleteJob.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function(data) {
            if (data.includes('success')) {
                $('#modalEditNewJobRequest').modal('hide');
                if (document.getElementById('hiddenJobSelector').value=='job') {
                    $('#showJobList').trigger('click');
                } else {
                    $('#getClient').trigger('change');
                    showCustomers(newID);

                    var dataToPost = {};
                    dataToPost.selectedValue = newID;

                    $.ajax({
                        url: 'customers.php',
                        type: 'POST',
                        data: dataToPost,
                        success: function(data) {
                            $('#customerInfo').html(data);
                        },
                        error: function() {}
                    });
                    } 
            } else {
   
            }
        },
        error: function () {

        }
    })
   

}


$(document).on("change", "#editJobCompleted", function() {
    // switch off TDH sign off if Job Completed is switched off
    if ($('#editJobCompleted').prop('checked')==false) {
        $('#editHubCompleted').prop('checked', false);
    }

    // have both pics been uploaded?
    var RegUploaded = $("#regPicContent").hasClass('imageLoaded');
    var DeviceUploaded = $("#devicePicContent").hasClass('imageLoaded');

    var errorString = '';
    if (RegUploaded == false) {
        errorString = "the vehicle registration plate";
    }
    if (DeviceUploaded==false) {
        if (errorString=='') {
            errorString += "the device details";
        } else {
            errorString += " and a picture of the device details";
        }
    }
    if ((RegUploaded == false || DeviceUploaded==false) && $('#editJobCompleted').prop('checked')==true) {
        swal ("Cannot update", "A picture of " + errorString + " must be uploaded before the job can be marked as complete.", "error");
        $('#editJobCompleted').prop('checked', false);
        return;
    }

    $('#editJobDateBooked').trigger('blur');
});



$(document).on("change", "#editHubCompleted", function() {

    if ($('#editJobCompleted').prop('checked')==false && $('#editHubCompleted').prop('checked')==true) {
        swal ("Cannot update", "The job cannot be signed off until it is completed", "error");

         $('#editHubCompleted').prop('checked', false);
         return;
     }

    $('#editJobDateBooked').trigger('blur');
});

function cancelCurrentJob() {
    var dataToPost = {};
    dataToPost.jobID = document.getElementById('hiddenJobID').text;
    console.log (dataToPost);

    swal ({
        title: "Confirm cancellation",
        text: "Are you sure you want to cancel this job?",
        icon: "warning",
        buttons: ['No Don\'t', 'Yes - Cancel'],
        dangerMode: true,
    }).then (function(isConfirm){
        if (isConfirm) {
            $.ajax({
                url: "cancelJob.php",
                timeout: 30000,
                data: dataToPost,
                type: "POST",
                success: function(data) {
                    if (data.includes('complete8')) {
                        swal ({
                            text: 'Cannot cancel job, it is just awaiting approval.',
                            icon: "info",
                            showCloseButton: true
                        })
                    }
                   if (data.includes('complete16')) {
                        swal ({
                            text: 'Cannot cancel job, it has already been completed.',
                            icon: "info",
                            showCloseButton: true
                        })
                    }
                    if (data.includes('complete32')) {
                        swal ({
                            text: 'Job is already cancelled.',
                            icon: "info",                            
                            showCloseButton: true
                        })
                    }
                
                    $('#modalEditNewJobRequest').modal('hide');
                    $('#showJobList').trigger('click');

                }
            })
        }
    });
   
}


$(document).on('click', '.addVRNButton', function (event) {
   
    $('#modalGetNewVRN').modal('show');
    $('#newVRN').val('');
    $('#newVRNMessage').html('');

})

$(document).on("click", '#addNewVRNToCustomer', function () {
    // make sure any spaces are stripped from the Vehicle Registration and it is all uppercase
    dataToPost = {};
    dataToPost.NewVRN = ($('#newVRN').val()).toUpperCase().split(' ').join('');
    dataToPost.customerID = $('#jobCustomerName').val();

           $.ajax({
            url: 'addNewRegistration.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
                if (data.includes('success')) {
                    $('#jobCustomerName').trigger('change');
                    $('#modalGetNewVRN').modal('hide');
                    
                } else {
                    $('#newVRNMessage').html(data);
                }
            }, 
            error: function () {

            }

        });

        if (document.getElementById('hiddenJobSelector').value=='job') {
            $('#showJobList').trigger('click');
        } else {
            $('#getClient').trigger('change');
        }

});

function addJobRequest(selector, customerID) {

    $('#hiddenJobSelector').val(selector);
        
    if (selector=='customer') {
        $(function() { 
            $('#jobCustomerName').val($('#hiddenCustomerID').text()).change();
            $('#jobCustomerName').prop('disabled', 'disabled');    
        });
    }   
     $('#modalAddNewJobRequest').modal('show');
}


function showJobMap() {
    window.open('googleMap.php', '_newtab');
}

$(document).on("click", '#updateMapView', function () {

var dataToPost = {};
var map;
dataToPost.startDate = document.getElementById('startReportDate').value;
dataToPost.endDate = document.getElementById('endReportDate').value;
dataToPost.engineerID = document.getElementById('engineerSelector').value;

var jobs = [];

$.ajax({
url: 'getJobCoordinates.php',
data: dataToPost,
type: "POST",
success: function(data) {
    data = $.parseJSON(data);
    console.log(data);
    $.each(data, function(index, element) {
        jobs[index] = new Array( data[index]['userName'] + " job at <b>" + data[index]['businessName'] + "</b><br>" + data[index]['bookingAddress'] + "<br><br>" + data[index]['description'] + " at <b>" + data[index]['date'].substr(11,5) +" (" + data[index]['date'].substr(8,2) +"/" +  data[index]['date'].substr(5,2) +"/" +  data[index]['date'].substr(0,4)  +")</b><br><br>" + data[index]['notes'] + "<br><br>VRM: " + data[index]['regNumber'], parseFloat(data[index]['latitude']), parseFloat(data[index]['longitude']), data[index]['userName'], data[index]['status']); 
    });
    redrawJobs(jobs);
},
error: function() {

}
});


function redrawJobs(jobs) {

map = new google.maps.Map(document.getElementById('map'), {
    zoom: 8,
    center: {lat: 52.4322625, lng: -1.7960350},
});

var infowindow = new google.maps.InfoWindow();
var marker, i


for (var i = 0; i < jobs.length; i++) {
       
    var job = jobs[i];
console.log(job[4]);

var job = jobs[i];
switch (parseInt(job[4])) {
    case 1:
        iconString = "images/pendingPin.png";
        break;
    case 2:
        iconString = "images/bookedPin.png";
        break;
    case 4:
        iconString = "images/bookedPassedPin.png";
        break;
    case 8:
        iconString = "images/approvalPin.png";
        break;
    case 16:
        iconString = "images/completePin.png";
        break;
    case 32:
        iconString = "images/cancelPin.png";
        break;
    default:
        iconString = "images/red_warning_24.png";
        break;
}
    // iconString = "images/" + job[3].charAt(0) + "_Icon.png";
console.log('icon: ' + iconString);

    marker = new google.maps.Marker({
        animation: google.maps.Animation.DROP,
        position: {lat: job[1], lng: job[2]},
        map: map,
        icon: iconString
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
    return function() {
      infowindow.setContent(jobs[i][0]);
      infowindow.open(map, marker);
    }
  })(marker, i));
}
}

});

