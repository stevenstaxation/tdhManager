var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar-wrapper").style.top = "0";
  } else {
    document.getElementById("navbar-wrapper").style.top = "-60px";
  }
  prevScrollpos = currentScrollPos;
}


// INVITE NEW USER

$(document).on('click', '#inviteNewUser', function (event) {
    event.preventDefault();
    $('#modalGetNewUserEmail').modal('show');
});


$(document).on('click', '#inviteNewUserEmail', function (event) {
    event.preventDefault();
    dataToPost = {};
    dataToPost.newUserEmail = $('#newUserEmailAddress').val();
    dataToPost.userTypeStandard = $('#userLogInStandard:checked').val();
    dataToPost.userTypeAdmin = $('#userLogInAdmin:checked').val();
    dataToPost.userTypeInstaller = $('#userLogInInstaller:checked').val();
    dataToPost.userTypeEngineer = $('#userLogInEngineer:checked').val();
    
    
    $.ajax({
        url: 'inviteNewUser.php',
        type: 'POST',
        data: dataToPost,
        success: function (data) {
            if (data.includes('An invitation email has been sent to')) {
                $('#modalGetNewUserEmail').modal('hide');
                $('#userErrorBox').html(data);
                $('#userErrorBox').delay(2500).hide(0);
            } else {
                $('#newUserEmailMessage').html(data);
            }
        },
        error: function () {

        }
    });
});

// SET UP AN HISTORIC USER
$(document).on('click', '#addHistoricUser', function (event) {
    event.preventDefault();
    dataToPost = {};
    // dataToPost.userName = window.prompt('Enter User Name');
    swal ({
        text: 'Enter name for historic user',
        content: 'input',
        button: {
            text: 'Add user',
            closeModal: true,
        },
    })
    .then(name => {
        dataToPost.userName = name;
        $.ajax ({
            url: "addOldUser.php",
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                $('#showGlobalSettings').trigger('click');
            }
        });
    })


      

});

// TOGGLE DARK MODE

    $(document).on('click', '#companyLogo', function () {
        $.ajax({
            url: 'toggleDarkMode.php',
            type: 'POST',
            success: function (data) {
                if (data.includes('success')) {
                    var DM = data.replace("success","");
                    setDarkMode(DM);
                } 
            }
        });
    });


var expanded = false;

function showCheckboxes() {
    var checkboxes = document.getElementById("checkboxes");
  
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
}

// function showEditCheckboxes() {
//     var checkboxes = document.getElementById("editCheckboxes");
  
//     if (!expanded) {
//         checkboxes.style.display = "block";
//         expanded = true;
//     } else {
//         checkboxes.style.display = "none";
//         expanded = false;
//     }
// }

function togglePassword() {
    var x = document.getElementById('password');

    if (x.type === 'password') {
        x.type = 'text';
    } else {
        x.type= 'password';
    }
    
}



$(document).on('click', '#cancelUpdateStatus', function(event) {
    event.preventDefault();
   $('#showGlobalSettings').trigger('click');
});

$(document).on('click', '#cancelUpdateSIMStatus', function(event) {
    event.preventDefault();
   $('#showGlobalSettings').trigger('click');
});

$(document).on('click', '#cancelUpdateFootageStatus', function(event) {
    event.preventDefault();
   $('#showGlobalSettings').trigger('click');
});

$(document).on('click', '#cancelUpdateRenewalType', function(event) {
    event.preventDefault();
   $('#showGlobalSettings').trigger('click');
});
$(document).on('click', '#cancelUpdateJobType', function(event) {
    event.preventDefault();
   $('#showGlobalSettings').trigger('click');
});
$(document).on('click', '#cancelUpdateHealthcheckType', function(event) {
    event.preventDefault();
   $('#showGlobalSettings').trigger('click');
});


$(document).on('click', '#deleteStatus', function(event) {
    event.preventDefault();
     var dataToPost = {};
         dataToPost.statusIDToDelete = $("#statusList option:selected").val();

         $.ajax({
             url: "deleteStatus.php",
             timeout: 30000,
             data: dataToPost,
             type: "POST",
             success: function(data) {
                 if (data.includes('success')) {
                     $('#showGlobalSettings').trigger('click');
                     $('#addOrUpdateStatus').text('Add');
                 } else {
                     $('#statusErrorBox').html(data);
                 }
             },
             error: function() {
             }
         });
 });

 $(document).on('click', '#deleteSIMStatus', function(event) {
    event.preventDefault();
     var dataToPost = {};
         dataToPost.SIMStatusIDToDelete = $("#SIMStatusList option:selected").val();

         $.ajax({
             url: "deleteSIMStatus.php",
             timeout: 30000,
             data: dataToPost,
             type: "POST",
             success: function(data) {
                 if (data.includes('success')) {
                     $('#showGlobalSettings').trigger('click');
                     $('#addOrUpdateSIMStatus').text('Add');
                 } else {
                     $('#SIMStatusErrorBox').html(data);
                 }
             },
             error: function() {
             }
         });
 });

 $(document).on('click', '#deleteFootageStatus', function(event) {
    event.preventDefault();
      var dataToPost = {};
          dataToPost.FootageStatusIDToDelete = $("#footageStatusList option:selected").val();

          $.ajax({
              url: "deleteFootageStatus.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateFootageStatus').text('Add');
                  } else {
                      $('#footageStatusErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
  });

  $(document).on('click', '#deleteRenewalType', function(event) {
    event.preventDefault();
      var dataToPost = {};
          dataToPost.RenewalTypeIDToDelete = $("#renewalTypeList option:selected").val();

          $.ajax({
              url: "deleteRenewalType.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateRenewalType').text('Add');
                  } else {
                      $('#renewalTypeErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
  });

  $(document).on('click', '#deleteJobType', function(event) {
    event.preventDefault();
      var dataToPost = {};
          dataToPost.JobTypeIDToDelete = $("#jobTypeList option:selected").val();

          $.ajax({
              url: "deleteJobType.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateJobType').text('Add');
                  } else {
                      $('#jobTypeErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
  });

  $(document).on('click', '#deleteHealthcheckType', function(event) {
    event.preventDefault();
      var dataToPost = {};
          dataToPost.HealthcheckTypeIDToDelete = $("#healthStatusList option:selected").val();

          $.ajax({
              url: "deleteHealthcheckType.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateHealthcheckType').text('Add');
                  } else {
                      $('#jobTypeErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
  });



      $(document).on('click', '#addOrUpdateStatus', function(event) {
     event.preventDefault();
      if ($('#addOrUpdateStatus').text() == 'Add') {
          var dataToPost = {};
          dataToPost.statusNameToAdd = document.getElementById('textAddOrUpdateStatus').value;
          $.ajax({
              url: "addStatus.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                  } else {
                      $('#statusErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
      if ($('#addOrUpdateStatus').text() == 'Update') {
          var dataToPost = {};
          dataToPost.statusIDToUpdate = $("#statusList option:selected").val();
          dataToPost.statusNameToUpdate = document.getElementById('textAddOrUpdateStatus').value;

          $.ajax({
              url: "updateStatus.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateStatus').text('Add');
                  } else {
                      $('#statusErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
      });

   $(document).on('click', '#addOrUpdateSIMStatus', function(event) {
     event.preventDefault();
      if ($('#addOrUpdateSIMStatus').text() == 'Add') {
          var dataToPost = {};
          dataToPost.SIMStatusNameToAdd = document.getElementById('textAddOrUpdateSIMStatus').value;
          $.ajax({
              url: "addSIMStatus.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                  } else {
                      $('#SIMStatusErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
      if ($('#addOrUpdateSIMStatus').text() == 'Update') {
          var dataToPost = {};
          dataToPost.SIMStatusIDToUpdate = $("#SIMStatusList option:selected").val();
          dataToPost.SIMStatusNameToUpdate = document.getElementById('textAddOrUpdateSIMStatus').value;

          $.ajax({
              url: "updateSIMStatus.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateSIMStatus').text('Add');
                  } else {
                      $('#SIMStatusErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
      });

  $(document).on('click', '#addOrUpdateFootageStatus', function(event) {
     event.preventDefault();
      if ($('#addOrUpdateFootageStatus').text() == 'Add') {
          var dataToPost = {};
          dataToPost.FootageStatusNameToAdd = document.getElementById('textAddOrUpdateFootageStatus').value;
          $.ajax({
              url: "addFootageStatus.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                  } else {
                      $('#footageStatusErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
      if ($('#addOrUpdateFootageStatus').text() == 'Update') {
          var dataToPost = {};
          dataToPost.FootageStatusIDToUpdate = $("#footageStatusList option:selected").val();
          dataToPost.FootageStatusNameToUpdate = document.getElementById('textAddOrUpdateFootageStatus').value;

          $.ajax({
              url: "updateFootageStatus.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateFootageStatus').text('Add');
                  } else {
                      $('#footageStatusErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
  });

  $(document).on('click', '#addOrUpdateRenewalType', function(event) {
     event.preventDefault();
      if ($('#addOrUpdateRenewalType').text() == 'Add') {
          var dataToPost = {};
          dataToPost.RenewalTypeNameToAdd = document.getElementById('textAddOrUpdateRenewalType').value;
          $.ajax({
              url: "addRenewalType.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                  } else {
                      $('#renewalTypeErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
      if ($('#addOrUpdateRenewalType').text() == 'Update') {
          var dataToPost = {};
          dataToPost.RenewalTypeIDToUpdate = $("#renewalTypeList option:selected").val();
          dataToPost.RenewalTypeNameToUpdate = document.getElementById('textAddOrUpdateRenewalType').value;

          $.ajax({
              url: "updateRenewalType.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateRenewalType').text('Add');
                  } else {
                      $('#renewalTypeErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
  });


  $(document).on('click', '#addOrUpdateJobType', function(event) {
     event.preventDefault();
      if ($('#addOrUpdateJobType').text() == 'Add') {
          var dataToPost = {};
          dataToPost.JobTypeNameToAdd = document.getElementById('textAddOrUpdateJobType').value;
          $.ajax({
              url: "addJobType.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                  } else {
                      $('#jobTypeErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
      if ($('#addOrUpdateJobType').text() == 'Update') {
          var dataToPost = {};
          dataToPost.JobTypeIDToUpdate = $("#jobTypeList option:selected").val();
          dataToPost.JobTypeNameToUpdate = document.getElementById('textAddOrUpdateJobType').value;

          $.ajax({
              url: "updateJobType.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateJobType').text('Add');
                  } else {
                      $('#jobTypeErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
  });

  $(document).on('click', '#addOrUpdateHealthcheckType', function(event) {
     event.preventDefault();
      if ($('#addOrUpdateHealthcheckType').text() == 'Add') {
          var dataToPost = {};
          dataToPost.HealthcheckTypeNameToAdd = document.getElementById('textAddOrUpdateHealthcheckType').value;
          $.ajax({
              url: "addHealthcheckType.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                  } else {
                      $('#healthcheckTypeErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
      if ($('#addOrUpdateHealthcheckType').text() == 'Update') {
          var dataToPost = {};
          dataToPost.HealthcheckTypeIDToUpdate = $("#healthStatusList option:selected").val();
          dataToPost.HealthcheckTypeNameToUpdate = document.getElementById('textAddOrUpdateHealthcheckType').value;

          $.ajax({
              url: "updateHealthcheckType.php",
              timeout: 30000,
              data: dataToPost,
              type: "POST",
              success: function(data) {
                  if (data.includes('success')) {
                      $('#showGlobalSettings').trigger('click');
                      $('#addOrUpdateHealthcheckType').text('Add');
                  } else {
                      $('#healthcheckTypeErrorBox').html(data);
                  }
              },
              error: function() {
              }
          });
      }
  });

  $(document).on('click', '#lookupVRNByAPI', function(event) {
      // prevent default PHP processing
      "use strict";
      var dataToPost = {};
      dataToPost.VRN = document.getElementById('VRNToFind').value.replaceAll(" ","");
      dataToPost.VRN = dataToPost.VRN.replaceAll(".","");
      dataToPost.VRN = dataToPost.VRN.replaceAll("-","");
      dataToPost.VRN = dataToPost.VRN.replaceAll("/","");
      dataToPost.VRN = dataToPost.VRN.replaceAll("'","");

      event.preventDefault();
      $.ajax({
          url: "VRNLookup.php",
          data: dataToPost,
          datatype: "json",
          type: "POST",
          success: function(data) {
              var output = $.parseJSON(data);
              if (output['Response']['StatusCode']!='Success') {
                  $('#VRNToFindMessage').html("<div class='alert alert-danger'>No information found</div>");
                  $('#VehicleLookupInfo').html('')
              } else {
                  var postData = {};
                  postData.APIData = output;
                  $.ajax({
                      url: "getVehicleFromAPI.php",
                      data: postData,
                      type: "POST",
                      success: function(data) {
                          $('#VRNToFindMessage').html('');
                          $('#VehicleLookupInfo').html(data);
                      }
                  });
                            
              }
          },
          error: function() {
          }
      });
  });

     
  

  $(document).on('click','#toggleCompletedIssues', function() {
      var currentFilter = $('#issueFilter').html();
      if (currentFilter==5) {
          currentFilter = 0;
      } else {
          currentFilter = 5;    
      }
      $('#issueFilter').html(currentFilter);
      $('#showIssueLog').trigger('click');
  });


  $(document).on('click','#toggleCompletedJobs', function() {
    var currentFilter = $('#jobFilter').html();
    if ((currentFilter & 16)==16) {
        currentFilter = (currentFilter & 65519);
    } else {
        currentFilter = (currentFilter | 16);    
    }
    $('#jobFilter').html(currentFilter);
    $('#showJobList').trigger('click');
  });

  $(document).on('click','#toggleCancelledJobs', function() {
    var currentFilter = $('#jobFilter').html();
    if ((currentFilter & 32)==32) {
        currentFilter = (currentFilter & 65503);
    } else {
        currentFilter = (currentFilter | 32);    
    }
    $('#jobFilter').html(currentFilter);
    $('#showJobList').trigger('click');
  });

  $(document).on('click','#togglePendingJobs', function() {
    var currentFilter = $('#jobFilter').html();
    if ((currentFilter & 1)==1) {
        currentFilter = (currentFilter & 65534);
    } else {
        currentFilter = (currentFilter | 1);    
    }
    $('#jobFilter').html(currentFilter);
    $('#showJobList').trigger('click');
  });

  $(document).on('click','#toggleDatePassedJobs', function() {
    var currentFilter = $('#jobFilter').html();
    if ((currentFilter & 4)==4) {
        currentFilter = (currentFilter & 65531);
    } else {
        currentFilter = (currentFilter | 4);    
    }
    $('#jobFilter').html(currentFilter);
    $('#showJobList').trigger('click');
  });

  $(document).on('click','#toggleBookedJobs', function() {
    var currentFilter = $('#jobFilter').html();
    if ((currentFilter & 8)==8) {
        currentFilter = (currentFilter & 65527);
    } else {
        currentFilter = (currentFilter | 8);    
    }
    $('#jobFilter').html(currentFilter);
    $('#showJobList').trigger('click');
  });

  $(document).on('click','#toggleArchivedJobs', function() {
    var currentFilter = $('#jobFilter').html();
    if ((currentFilter & 64)==64) {
        currentFilter = (currentFilter & 65471);
    } else {
        currentFilter = (currentFilter | 64);    
    }
    $('#jobFilter').html(currentFilter);
    $('#showJobList').trigger('click');
  });

  $(document).on("click", '#showIssueLog', function () {
      var dataToPost = {};
      dataToPost.filteredStatus = $('#issueFilter').html();
      if (!dataToPost.filteredStatus) {
          dataToPost.filteredStatus='5';
      }
        
      $.ajax({
      url: "issueList.php",
      data: dataToPost,
      type: "POST",
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
          $('#issueRequestMessage').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
      }
  });
});


  $(document).on('click', '#updateDefaults', function(event) {
      event.preventDefault();
      var dataToPost = {};
      dataToPost.defaultInstaller = document.getElementById('selectDefaultInstaller').value;
      dataToPost.defaultSupplier = document.getElementById('selectDefaultSupplier').value;
      $.ajax({
          url:"updateDefaultValues.php",
          timeout: 30000,
          data: dataToPost,
          type: "POST",
          success: function() {
              
          }
      })
  })


  $(document).on('click', '#statusList', function(event) {
    event.preventDefault();
    if (!event.target.options) {
        document.getElementById('textAddOrUpdateStatus').value = event.target.innerText;
        $('#addOrUpdateStatus').text('Update');
        document.getElementById('addOrUpdateStatus').disabled = false;
        document.getElementById('deleteStatus').disabled = false;
        document.getElementById('cancelUpdateStatus').style.display = "block";
        document.getElementById('cancelUpdateStatus').disabled = false;
    }
});

    $(document).on('click', '#SIMStatusList', function(event) {
    event.preventDefault();
    if (!event.target.options) {
        document.getElementById('textAddOrUpdateSIMStatus').value = event.target.innerText;
        $('#addOrUpdateSIMStatus').text('Update');
        document.getElementById('addOrUpdateSIMStatus').disabled = false;
        document.getElementById('deleteSIMStatus').disabled = false;
        document.getElementById('cancelUpdateSIMStatus').style.display = "block";
        document.getElementById('cancelUpdateSIMStatus').disabled = false;
    }
});

$(document).on('click', '#footageStatusList', function(event) {
    event.preventDefault();
    if (!event.target.options) {
        document.getElementById('textAddOrUpdateFootageStatus').value = event.target.innerText;
        $('#addOrUpdateFootageStatus').text('Update');
        document.getElementById('addOrUpdateFootageStatus').disabled = false;
        document.getElementById('deleteFootageStatus').disabled = false;
        document.getElementById('cancelUpdateFootageStatus').style.display = "block";
        document.getElementById('cancelUpdateFootageStatus').disabled = false;
    }
});

$(document).on('click', '#renewalTypeList', function(event) {
    event.preventDefault();
    if (!event.target.options) {
        document.getElementById('textAddOrUpdateRenewalType').value = event.target.innerText;
        $('#addOrUpdateRenewalType').text('Update');
        document.getElementById('addOrUpdateRenewalType').disabled = false;
        document.getElementById('deleteRenewalType').disabled = false;
        document.getElementById('cancelUpdateRenewalType').style.display = "block";
        document.getElementById('cancelUpdateRenewalType').disabled = false;
    }
});

$(document).on('click', '#jobTypeList', function(event) {
    event.preventDefault();
    if (!event.target.options) {
        document.getElementById('textAddOrUpdateJobType').value = event.target.innerText;
        $('#addOrUpdateJobType').text('Update');
        document.getElementById('addOrUpdateJobType').disabled = false;
        document.getElementById('deleteJobType').disabled = false;
        document.getElementById('cancelUpdateJobType').style.display = "block";
        document.getElementById('cancelUpdateJobType').disabled = false;
    }
});

$(document).on('click', '#healthStatusList', function(event) {
    event.preventDefault();
    if (!event.target.options) {
        document.getElementById('textAddOrUpdateHealthcheckType').value = event.target.innerText;
        $('#addOrUpdateHealthcheckType').text('Update');
        document.getElementById('addOrUpdateHealthcheckType').disabled = false;
        document.getElementById('deleteHealthcheckType').disabled = false;
        document.getElementById('cancelUpdateHealthcheckType').style.display = "block";
        document.getElementById('cancelUpdateHealthcheckType').disabled = false;
    }
});

$(document).on('show.bs.modal', '#modalAddNewJobRequest', function (event) {
    $(this).find('form').trigger('reset');
    $('#jobRequestMessage').html('');
});

$(document).on('click', '#bulkUploadDevices', function() {
    document.getElementById('uploadDeviceFormatDetails').style.display = 'block';
    document.getElementById('uploadHealthcheckFormatDetails').style.display = 'none';
    document.getElementById('uploadVehicleFormatDetails').style.display = 'none';
    document.getElementById('dropZone').style.display = 'block';
    $('#hiddenUploadTypeSelector').val('devices');
    $('.imageContent').html('');
});
$(document).on('click', '#bulkUploadHealthChecks', function() {
    document.getElementById('uploadDeviceFormatDetails').style.display = 'none';
    document.getElementById('uploadHealthcheckFormatDetails').style.display = 'block';
    document.getElementById('uploadVehicleFormatDetails').style.display = 'none';
    document.getElementById('dropZone').style.display = 'block';
    $('#hiddenUploadTypeSelector').val('healthchecks');
    $('.imageContent').html('');
});
$(document).on('click', '#bulkUploadVehicles', function() {
    document.getElementById('uploadDeviceFormatDetails').style.display = 'none';
    document.getElementById('uploadHealthcheckFormatDetails').style.display = 'none';
    document.getElementById('uploadVehicleFormatDetails').style.display = 'block';
    document.getElementById('dropZone').style.display = 'block';
    $('#hiddenUploadTypeSelector').val('vehicles');
    $('.imageContent').html('');
});



