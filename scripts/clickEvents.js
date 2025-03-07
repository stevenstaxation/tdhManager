var prevScrollpos = window.pageYOffset;
window.onscroll = function () {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar-wrapper").style.top = "0";
  } else {
    document.getElementById("navbar-wrapper").style.top = "-60px";
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
  var pwIn = document.getElementById("password");
  var btn = document.getElementById("pwButton");
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
    .getElementById("VRNToFind")
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
    document.getElementById("textAddOrUpdateStatus").value =
      event.target.innerText;
    $("#addOrUpdateStatus").text("Update");
    document.getElementById("addOrUpdateStatus").disabled = false;
    document.getElementById("deleteStatus").disabled = false;
    document.getElementById("cancelUpdateStatus").style.display = "block";
    document.getElementById("cancelUpdateStatus").disabled = false;
  }
});

$(document).on("click", "#SIMStatusList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.getElementById("textAddOrUpdateSIMStatus").value =
      event.target.innerText;
    $("#addOrUpdateSIMStatus").text("Update");
    document.getElementById("addOrUpdateSIMStatus").disabled = false;
    document.getElementById("deleteSIMStatus").disabled = false;
    document.getElementById("cancelUpdateSIMStatus").style.display = "block";
    document.getElementById("cancelUpdateSIMStatus").disabled = false;
  }
});

$(document).on("click", "#footageStatusList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.getElementById("textAddOrUpdateFootageStatus").value =
      event.target.innerText;
    $("#addOrUpdateFootageStatus").text("Update");
    document.getElementById("addOrUpdateFootageStatus").disabled = false;
    document.getElementById("deleteFootageStatus").disabled = false;
    document.getElementById("cancelUpdateFootageStatus").style.display =
      "block";
    document.getElementById("cancelUpdateFootageStatus").disabled = false;
  }
});

$(document).on("click", "#renewalTypeList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.getElementById("textAddOrUpdateRenewalType").value =
      event.target.innerText;
    $("#addOrUpdateRenewalType").text("Update");
    document.getElementById("addOrUpdateRenewalType").disabled = false;
    document.getElementById("deleteRenewalType").disabled = false;
    document.getElementById("cancelUpdateRenewalType").style.display = "block";
    document.getElementById("cancelUpdateRenewalType").disabled = false;
  }
});

$(document).on("click", "#jobTypeList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.getElementById("textAddOrUpdateJobType").value =
      event.target.innerText;
    $("#addOrUpdateJobType").text("Update");
    document.getElementById("addOrUpdateJobType").disabled = false;
    document.getElementById("deleteJobType").disabled = false;
    document.getElementById("cancelUpdateJobType").style.display = "block";
    document.getElementById("cancelUpdateJobType").disabled = false;
  }
});

$(document).on("click", "#healthStatusList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.getElementById("textAddOrUpdateHealthcheckType").value =
      event.target.innerText;
    $("#addOrUpdateHealthcheckType").text("Update");
    document.getElementById("addOrUpdateHealthcheckType").disabled = false;
    document.getElementById("deleteHealthcheckType").disabled = false;
    document.getElementById("cancelUpdateHealthcheckType").style.display =
      "block";
    document.getElementById("cancelUpdateHealthcheckType").disabled = false;
  }
});

$(document).on("click", "#platformNameList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.getElementById("textAddOrUpdatePlatform").value =
      event.target.innerText;
    $("#addOrUpdatePlatformType").text("Update");
    document.getElementById("addOrUpdatePlatformType").disabled = false;
    document.getElementById("deletePlatform").disabled = false;
    document.getElementById("cancelUpdatePlatform").style.display = "block";
    document.getElementById("cancelUpdatePlatform").disabled = false;
  }
});

$(document).on("show.bs.modal", "#modalAddNewJobRequest", function (event) {
  $(this).find("form").trigger("reset");
  $("#jobRequestMessage").html("");
});

$(document).on("click", "#bulkUploadDevices", function () {
  document.getElementById("uploadDeviceFormatDetails").style.display = "block";
  document.getElementById("uploadHealthcheckFormatDetails").style.display =
    "none";
  document.getElementById("uploadVehicleFormatDetails").style.display = "none";
  document.getElementById("dropZone").style.display = "block";
  $("#hiddenUploadTypeSelector").val("devices");
  $(".imageContent").html("");
});
$(document).on("click", "#bulkUploadHealthChecks", function () {
  document.getElementById("uploadDeviceFormatDetails").style.display = "none";
  document.getElementById("uploadHealthcheckFormatDetails").style.display =
    "block";
  document.getElementById("uploadVehicleFormatDetails").style.display = "none";
  document.getElementById("dropZone").style.display = "block";
  $("#hiddenUploadTypeSelector").val("healthchecks");
  $(".imageContent").html("");
});
$(document).on("click", "#bulkUploadVehicles", function () {
  document.getElementById("uploadDeviceFormatDetails").style.display = "none";
  document.getElementById("uploadHealthcheckFormatDetails").style.display =
    "none";
  document.getElementById("uploadVehicleFormatDetails").style.display = "block";
  document.getElementById("dropZone").style.display = "block";
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
