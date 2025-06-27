var prevScrollpos = window.pageYOffset;
window.onscroll = function () {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.querySelector("#navbar-wrapper").style.top = "0";
  } else {
    document.querySelector("#navbar-wrapper").style.top = "-60px";
  }
  prevScrollpos = currentScrollPos;
};

// INVITE NEW USER

$(document).on("click", "#inviteNewUser", function (event) {
  event.preventDefault();
  $("#modalGetNewUserEmail").modal("show");
});

$(document).on("click", "#inviteNewUserEmail", function (event) {
  event.preventDefault();
  dataToPost = {};
  dataToPost.newUserEmail = $("#newUserEmailAddress").val();
  dataToPost.userTypeStandard = $("#userLogInStandard:checked").val();
  dataToPost.userTypeAdmin = $("#userLogInAdmin:checked").val();
  dataToPost.userTypeInstaller = $("#userLogInInstaller:checked").val();
  dataToPost.userTypeEngineer = $("#userLogInEngineer:checked").val();

  $.ajax({
    url: "inviteNewUser.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      if (data.includes("An invitation email has been sent to")) {
        $("#modalGetNewUserEmail").modal("hide");
        $("#userErrorBox").html(data);
        $("#userErrorBox").delay(2500).hide(0);
      } else {
        $("#newUserEmailMessage").html(data);
      }
    },
    error: function () {},
  });
});

// SET UP AN HISTORIC USER
$(document).on("click", "#addHistoricUser", function (event) {
  event.preventDefault();
  dataToPost = {};
  // dataToPost.userName = window.prompt('Enter User Name');
  new swal({
    text: "Enter name for historic user",
    input: "text",
    confirmButtonText: "Add user",
  }).then((result) => {
    if (result.isConfirmed) {
      dataToPost.userName = result.value;
      $.ajax({
        url: "addOldUser.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          $("#showGlobalSettings").trigger("click");
        },
      });
    }
  });
});

// TOGGLE DARK MODE

$(document).on("click", "#companyLogo", function () {
  $.ajax({
    url: "toggleDarkMode.php",
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        var DM = data.replace("success", "");
        setDarkMode(DM);
      }
    },
  });
});

var expanded = false;

function showCheckboxes() {
  var checkboxes = document.querySelector("#checkboxes");

  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}

// function showEditCheckboxes() {
//     var checkboxes = document.querySelector("#editCheckboxes");

//     if (!expanded) {
//         checkboxes.style.display = "block";
//         expanded = true;
//     } else {
//         checkboxes.style.display = "none";
//         expanded = false;
//     }
// }

function togglePassword() {
  var pwIn = document.querySelector("#password");
  var btn = document.querySelector("#pwButton");
  if (pwIn.type === "password") {
    pwIn.type = "text";
    btn.innerHTML = '<i class="bi bi-eye-slash"></i>';
  } else {
    pwIn.type = "password";
    btn.innerHTML = '<i class="bi bi-eye"></i>';
  }
}

$(document).on("click", "#lookupVRNByAPI", function (event) {
  // prevent default PHP processing
  "use strict";
  var dataToPost = {};
  dataToPost.VRN = document
    .querySelector("#VRNToFind")
    .value.replaceAll(" ", "");
  dataToPost.VRN = dataToPost.VRN.replaceAll(".", "");
  dataToPost.VRN = dataToPost.VRN.replaceAll("-", "");
  dataToPost.VRN = dataToPost.VRN.replaceAll("/", "");
  dataToPost.VRN = dataToPost.VRN.replaceAll("'", "");

  event.preventDefault();
  $.ajax({
    url: "VRNLookup.php",
    data: dataToPost,
    datatype: "json",
    type: "POST",
    success: function (data) {
      var output = $.parseJSON(data);
      if (output["Response"]["StatusCode"] != "Success") {
        $("#VRNToFindMessage").html(
          "<div class='alert alert-danger'>No information found</div>"
        );
        $("#VehicleLookupInfo").html("");
      } else {
        var postData = {};
        postData.APIData = output;
        $.ajax({
          url: "getVehicleFromAPI.php",
          data: postData,
          type: "POST",
          success: function (data) {
            $("#VRNToFindMessage").html("");
            $("#VehicleLookupInfo").html(data);
          },
        });
      }
    },
    error: function () {},
  });
});

//   $(document).on('click','#toggleCompletedIssues', function() {
//       var currentFilter = $('#issueFilter').html();
//       if (currentFilter == 5) {
//           currentFilter = 0;
//       } else {
//           currentFilter = 5;
//       }
//       $('#issueFilter').html(currentFilter);
//       $('#showIssueLog').trigger('click');
//   });

$(document).on("click", "#toggleAllJobs", function () {
  var currentFilter = $("#jobFilter").html();
  // clear bits 0 - 6 (switch off other buttons)
  // set bit 7 to signify Show All selected
  // and disable 'Show All button'
  currentFilter = currentFilter & 65280;
  currentFilter = 128;
  $("#jobFilter").html(currentFilter);
  $("#showJobList").trigger("click");
});

$(document).on("click", "#toggleCompletedJobs", function () {
  var currentFilter = $("#jobFilter").html();
  if ((currentFilter & 16) == 16) {
    currentFilter = currentFilter & 65519;
  } else {
    currentFilter = currentFilter | 16;
    // switch off bit 7 (show all)
    currentFilter = currentFilter & 65407;
  }

  $("#jobFilter").html(currentFilter);
  $("#showJobList").trigger("click");
});

$(document).on("click", "#toggleCancelledJobs", function () {
  var currentFilter = $("#jobFilter").html();
  if ((currentFilter & 32) == 32) {
    currentFilter = currentFilter & 65503;
  } else {
    currentFilter = currentFilter | 32;
    // switch off bit 7 (show all)
    currentFilter = currentFilter & 65407;
  }
  $("#jobFilter").html(currentFilter);
  $("#showJobList").trigger("click");
});

$(document).on("click", "#togglePendingJobs", function () {
  var currentFilter = $("#jobFilter").html();
  if ((currentFilter & 1) == 1) {
    currentFilter = currentFilter & 65534;
  } else {
    currentFilter = currentFilter | 1;
    // switch off bit 7 (show all)
    currentFilter = currentFilter & 65407;
  }
  $("#jobFilter").html(currentFilter);
  $("#showJobList").trigger("click");
});

$(document).on("click", "#toggleDatePassedJobs", function () {
  var currentFilter = $("#jobFilter").html();
  if ((currentFilter & 4) == 4) {
    currentFilter = currentFilter & 65531;
  } else {
    currentFilter = currentFilter | 4;
    // switch off bit 7 (show all)
    currentFilter = currentFilter & 65407;
  }
  $("#jobFilter").html(currentFilter);
  $("#showJobList").trigger("click");
});

$(document).on("click", "#toggleBookedJobs", function () {
  var currentFilter = $("#jobFilter").html();
  if ((currentFilter & 2) == 2) {
    currentFilter = currentFilter & 65533;
  } else {
    currentFilter = currentFilter | 2;
    // switch off bit 7 (show all)
    currentFilter = currentFilter & 65407;
  }
  $("#jobFilter").html(currentFilter);
  $("#showJobList").trigger("click");
});

$(document).on("click", "#toggleArchivedJobs", function () {
  var currentFilter = $("#jobFilter").html();
  if ((currentFilter & 64) == 64) {
    currentFilter = currentFilter & 65471;
  } else {
    currentFilter = currentFilter | 64;
    // switch off bit 7 (show all)
    currentFilter = currentFilter & 65407;
  }
  $("#jobFilter").html(currentFilter);
  $("#showJobList").trigger("click");
});

//   $(document).on("click", '#showIssueLog', function () {
//       var dataToPost = {};
//       dataToPost.filteredStatus = $('#issueFilter').html();
//       if (!dataToPost.filteredStatus) {
//           dataToPost.filteredStatus='5';
//       }

//       $.ajax({
//       url: "issueList.php",
//       data: dataToPost,
//       type: "POST",
//       success: function (data) {
//           $('#accountInfo').html('');
//           $('#customerSelect').html('');
//           $('#customerInfo').html('');
//           $('#overlay').html('');
//           $('#homeScreen').hide();
//           $('#eventLog').html('');
//           $('#bulkUploadsPage').html('');
//           $('#devicesList').html(data);
//           $('#vehicleList').html('');
//       },
//       error: function () {
//           $('#issueRequestMessage').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
//       }
//   });
// });

$(document).on("click", "#updateDefaults", function (event) {
  event.preventDefault();
  var dataToPost = {};
  dataToPost.defaultInstaller = document.getElementById(
    "selectDefaultInstaller"
  ).value;
  dataToPost.defaultSupplier = document.getElementById(
    "selectDefaultSupplier"
  ).value;
  $.ajax({
    url: "updateDefaultValues.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function () {},
  });
});

$(document).on("click", "#statusList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.querySelector("#textAddOrUpdateStatus").value =
      event.target.innerText;
    $("#addOrUpdateStatus").text("Update");
    document.querySelector("#addOrUpdateStatus").disabled = false;
    document.querySelector("#deleteStatus").disabled = false;
    document.querySelector("#cancelUpdateStatus").style.display = "block";
    document.querySelector("#cancelUpdateStatus").disabled = false;
  }
});

$(document).on("click", "#SIMStatusList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.querySelector("#textAddOrUpdateSIMStatus").value =
      event.target.innerText;
    $("#addOrUpdateSIMStatus").text("Update");
    document.querySelector("#addOrUpdateSIMStatus").disabled = false;
    document.querySelector("#deleteSIMStatus").disabled = false;
    document.querySelector("#cancelUpdateSIMStatus").style.display = "block";
    document.querySelector("#cancelUpdateSIMStatus").disabled = false;
  }
});

$(document).on("click", "#footageStatusList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.querySelector("#textAddOrUpdateFootageStatus").value =
      event.target.innerText;
    $("#addOrUpdateFootageStatus").text("Update");
    document.querySelector("#addOrUpdateFootageStatus").disabled = false;
    document.querySelector("#deleteFootageStatus").disabled = false;
    document.querySelector("#cancelUpdateFootageStatus").style.display =
      "block";
    document.querySelector("#cancelUpdateFootageStatus").disabled = false;
  }
});

$(document).on("click", "#renewalTypeList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.querySelector("#textAddOrUpdateRenewalType").value =
      event.target.innerText;
    $("#addOrUpdateRenewalType").text("Update");
    document.querySelector("#addOrUpdateRenewalType").disabled = false;
    document.querySelector("#deleteRenewalType").disabled = false;
    document.querySelector("#cancelUpdateRenewalType").style.display = "block";
    document.querySelector("#cancelUpdateRenewalType").disabled = false;
  }
});

$(document).on("click", "#jobTypeList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.querySelector("#textAddOrUpdateJobType").value =
      event.target.innerText;
    $("#addOrUpdateJobType").text("Update");
    document.querySelector("#addOrUpdateJobType").disabled = false;
    document.querySelector("#deleteJobType").disabled = false;
    document.querySelector("#cancelUpdateJobType").style.display = "block";
    document.querySelector("#cancelUpdateJobType").disabled = false;
  }
});

$(document).on("click", "#healthStatusList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.querySelector("#textAddOrUpdateHealthcheckType").value =
      event.target.innerText;
    $("#addOrUpdateHealthcheckType").text("Update");
    document.querySelector("#addOrUpdateHealthcheckType").disabled = false;
    document.querySelector("#deleteHealthcheckType").disabled = false;
    document.querySelector("#cancelUpdateHealthcheckType").style.display =
      "block";
    document.querySelector("#cancelUpdateHealthcheckType").disabled = false;
  }
});

$(document).on("click", "#platformNameList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.querySelector("#textAddOrUpdatePlatform").value =
      event.target.innerText;
    $("#addOrUpdatePlatformType").text("Update");
    document.querySelector("#addOrUpdatePlatformType").disabled = false;
    document.querySelector("#deletePlatform").disabled = false;
    document.querySelector("#cancelUpdatePlatform").style.display = "block";
    document.querySelector("#cancelUpdatePlatform").disabled = false;
  }
});

$(document).on("show.bs.modal", "#modalAddNewJobRequest", function (event) {
  $(this).find("form").trigger("reset");
  $("#jobRequestMessage").html("");
});

$(document).on("click", "#bulkUploadDevices", function () {
  document.querySelector("#uploadDeviceFormatDetails").style.display = "block";
  document.querySelector("#uploadHealthcheckFormatDetails").style.display =
    "none";
  document.querySelector("#uploadVehicleFormatDetails").style.display = "none";
  document.querySelector("#dropZone").style.display = "block";
  $("#hiddenUploadTypeSelector").val("devices");
  $(".imageContent").html("");
});
$(document).on("click", "#bulkUploadHealthChecks", function () {
  document.querySelector("#uploadDeviceFormatDetails").style.display = "none";
  document.querySelector("#uploadHealthcheckFormatDetails").style.display =
    "block";
  document.querySelector("#uploadVehicleFormatDetails").style.display = "none";
  document.querySelector("#dropZone").style.display = "block";
  $("#hiddenUploadTypeSelector").val("healthchecks");
  $(".imageContent").html("");
});
$(document).on("click", "#bulkUploadVehicles", function () {
  document.querySelector("#uploadDeviceFormatDetails").style.display = "none";
  document.querySelector("#uploadHealthcheckFormatDetails").style.display =
    "none";
  document.querySelector("#uploadVehicleFormatDetails").style.display = "block";
  document.querySelector("#dropZone").style.display = "block";
  $("#hiddenUploadTypeSelector").val("vehicles");
  $(".imageContent").html("");
});

function GETMYLOCATION() {
  console.log(navigator.geolocation.getCurrentPosition(success, error));

  function success(position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;
    console.log(latitude);
    console.log(longitude);
  }

  function error() {
    console.log("Unable to retrieve your location");
  }
}
