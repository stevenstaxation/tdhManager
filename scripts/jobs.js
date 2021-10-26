// Reset the Add New Job Modal fields when form is closed
$('#modalAddNewJobRequest').on('hidden.bs.modal', function() {
    $(this).find('form').trigger('reset');
    $('#jobRequestMessage').html('');
});


// Show the jobs list page when the Navbar button 'Jobs' is clicked
// and clear the other panels
$(document).on("click", '#showJobList', function () {
    var dataToPost = {};
    dataToPost.SQLFilter = '';
    $.ajax({
        url: "jobList.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#homeScreen').hide();
            $('#eventLog').html('');
            $('#bulkUploadsPage').html('');
            $('#devicesList').html(data);
            $('#vehicleList').html('');
        },
        error: function () {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
        }
    });
});

// Obsolete code for filtering jobs - now implemented using datatables library
// $(document).on('click', '#jobsFilterClicked', function (event) {
//     "use strict";
//     event.preventDefault();
//     var dataToPost = {};
//     dataToPost.FilterCustomer = document.getElementById('getCustomerSelect').value;
//     dataToPost.FilterType = document.getElementById('byDeviceType').value;
//     dataToPost.FilterOtherTerm = document.getElementById('byOther').value;
//     dataToPost.SQLFilter = '';
//     $.ajax({
//         url: 'filterJobs.php',
//         data: dataToPost,
//         type: 'POST',
//         success: function (data) {
//             dataToPost.SQLFilter = data;
//             $.ajax({
//                 url: "jobList.php",
//                 type: "POST",
//                 data: dataToPost,
//                 success: function (data) {
//                     $('#devicesList').html(data);
//                 },
//                 error: function () {
//                     $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
//                 }
//             });
//         },
//         error: function () {

//         }
//     });
// });

function addNewJob() {
  
    var dataToPost = {};
   
    // dataToPost = $('#getAddJob').serializeArray();

    dataToPost.jobCustomerName = $('#jobCustomerName').val();
    dataToPost.jobJobType = $('#jobJobType').val();
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
    for(var ix=0;ix < vehicles.length;ix++){
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
                    $('#editJobDateBooked').val(data['date']);
                    $('#editJobCompleted').val(data['jobCompleteFlag']);
                    $('#editHubCompleted').val(data['TDHSignOff']);
               
                    $(function() { 
                        document.getElementById('editJobVRN').value = data['VRN'];
                        document.getElementById('editJobOldVRN').value = data['oldVRN'];
                        
                        // $('#editJobVRN').val(data['VRN']);
                        // $('#editJobOldVRN').val(data['oldVRN']);
                    });
                
            
                // ***********

               
        
                


                document.getElementById('regPicContent').innerHTML = '';
                document.getElementById('devicePicContent').innerHTML = ''; 
                if (data['regPicFilename']) {
                    document.getElementById('regPicContent').innerHTML = "<img src = '" + data['regPicFilename'] +"' width='160'>";
                }
                if (data['regPicDeviceDetails']) {
                    document.getElementById('devicePicContent').innerHTML = "<img src = '" + data ['regPicDeviceDetails'] +"' width='160'>";
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
                } else if (data['jobCompleteFlag'] ==1) {
                    $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #ffaa00;'>AWAITING APPROVAL</span></h6>"); 
                }
                else if (jobWhen == 0) {
                    $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #ffaa00;'>PENDING</span></h6>");
                } else if (today > jobWhen) {
                    $('#editJobDateBooked').prop('color','red');
                    $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: red;'>BOOKED - DATE PASSED</span></h6>");
                } else if (jobWhen > today) {
                    $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #ffaa00;'>BOOKED</span></h6>");
                }

            

                $('#modalEditNewJobRequest').modal('show');
               
           
        },
        error: function() {

        }
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

// if ($("body").hasClass("dark")) {
//     $("body").removeClass("dark");
//     document.getElementById('companyLogo').src = "images/logo_swirl.png";
// } else {
//     $("body").addClass("dark");
//     document.getElementById('companyLogo').src = "images/logo_swirl_black.png";
// }

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
    })
    // dataToPost = {}
    // dataToPost.customerSelected = $('#jobCustomerName').val();
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
    })

});

$(document).on("change", '#jobJobType', function() {

var selectedType = $('#jobJobType option:selected').text().toLowerCase();

if (selectedType.includes('deinstall') || selectedType.includes('de-install')) {
    $('.addJobTypeOldVRN').prop('disabled', false);
} else {
    $('.addJobTypeOldVRN').prop('disabled', true);
}

});


$(document).on("change", '#jobQuantity', function() {
    var dataToPost = {};
    if ($('#jobQuantity').val() > 9) {
        $('#jobQuantity').val('9'); 
    }

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

$(document).on("blur", '#jobRate', function() {
    $('#jobRate').val(formatAsCurrency($('#jobRate').val()));
});



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
    dataToPost.jobRate = document.getElementById('editJobRate').value;
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
        dataToPost.jobStatus = 5; //complete
    } else if (dataToPost.jobCompleted == true) {
        dataToPost.jobStatus = 4; // Awaiting Approval
    }
    else if (isNaN(jobWhen)) {
        dataToPost.jobStatus = 1; // Pending
    } else if (today > jobWhen) {
        dataToPost.jobStatus = 3; // Booked - date passed
    } else if (jobWhen > today) {
        dataToPost.jobStatus = 2; // booked
    } else {
        dataToPost.jobStatus = 0; // new job??
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
                console.log(data);
            }
        },
        error: function () {

        }
    })
   

}




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
        $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: red;'>BOOKED - DATE PASSED</span></h6>")
    } else if (jobWhen > today) {
        $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #FFAA00;'>BOOKED</span></h6>")
    } else {
        $('#jobCurrentStatus').html("<h6>STATUS: <span style='color: #FFAA00;'>NEW JOB SETUP</span></h6>")
    }


});

$(document).on("change", "#editJobCompleted", function() {
    // switch off TDH sign off if Job Completed is switched off
    if ($('#editJobCompleted').prop('checked')==false) {
        $('#editHubCompleted').prop('checked', false);
    }

    // have both pics been uploaded?


    $('#editJobDateBooked').trigger('blur');
});

$(document).on("change", "#editHubCompleted", function() {

    
    if ($('#editJobCompleted').prop('checked')==false && $('#editHubCompleted').prop('checked')==true) {
         alert ("Cannot sign off until job is completed");
         $('#editHubCompleted').prop('checked', false);
         return;
     }

    $('#editJobDateBooked').trigger('blur');
});


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


