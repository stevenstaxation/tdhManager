// Reset the Add New Job Modal fields when form is closed
$("#modalAddNewJobRequest").on("hidden.bs.modal", function () {
  $(this).find("form").trigger("reset");
  $("#jobRequestMessage").html("");
});

// When adding a job and the customer name is changed then this routine will
// change the customer's vehicle list and get the customer's default contact
$(document).on("change", "#jobCustomerName", function () {
  dataToPost = {};
  dataToPost.customerSelected = $("#jobCustomerName").val();
  $.ajax({
    url: "getVehiclesByCustomer.php",
    timeout: 30000,
    async: false,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      var old = `<option value='0' disabled>select VRN</option>${data}`;
      $(".addJobTypeOldVRN").html(old);
      data = `<option value='0' disabled>select VRN</option>${data}`;
      $(".addJobTypeVRN").html(data);

      if (
        $(".addVRNButton").hasClass("disabled") &&
        $("#jobCustomerName").val() != null
      ) {
        $(".addVRNButton").removeClass("disabled");
      } else {
        $(".addVRNButton").addClass("disabled");
      }
      let regNumber = $("#editJobVRN option:selected").text();
      regNumber = regNumber.substr(0, 4) + " " + regNumber.substr(4);
      $(".jobRegistrationPlate").html(
        "<b style='padding: 0 5px'>" + regNumber + "<b>"
      );
    },
    error: function () {},
  });

  $.ajax({
    url: "getContactByCustomer.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      data = $.parseJSON(data);
      if (!data) {
        $("#jobContactName").val("");
        $("#jobContactEmail").val("");
        $("#jobContactPhone").val("");
        return;
      }

      if (data.firstName && data.lastName) {
        $("#jobContactName").val(data.firstName + " " + data.lastName);
      } else if (data.firstName && !data.lastName) {
        $("#jobContactName").val(data.firstName);
      } else if (!data.firstName && data.lastName) {
        $("#jobContactName").val(data.lastName);
      } else {
        $("#jobContactName").val("");
      }

      if (data.email) {
        $("#jobContactEmail").val(data.email);
      } else {
        $("#jobContactEmail").val("");
      }

      if (data.telephone && data.mobileNo) {
        $("#jobContactPhone").val(data.telephone + "/" + data.mobileNo);
      } else if (data.telephone && !data.mobileNo) {
        $("#jobContactPhone").val(data.telephone);
      } else if (!data.telephone && data.mobileNo) {
        $("#jobContactPhone").val(data.mobileNo);
      } else {
        $("#jobContactPhone").val("");
      }
    },
    error: function () {},
  });
});

$(document).on("change", "#editJobVRN", function () {
  let regNumber = $("#editJobVRN option:selected").text();
  regNumber = regNumber.substr(0, 4) + " " + regNumber.substr(4);
  $(".jobRegistrationPlate").html(
    "<b style='padding: 0 5px'>" + regNumber + "<b>"
  );
});

// When editing a job a change in the dropdown of customer names runs this routine
// to get the customer's vehicles and change the vehicle dropdown list
$(document).on("change", "#editJobCustomerName", function () {
  dataToPost = {};
  dataToPost.customerSelected = $("#editJobCustomerName").val();
  $.ajax({
    url: "getVehiclesByCustomer.php",
    timeout: 30000,
    async: false,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      var old =
        "<option value='0' disabled selected>Not Applicable</option>" + data;
      $(".addJobTypeOldVRN").html(old);
      $("#editJobVRN").html(data);
      let regNumber = $("#editJobVRN option:selected").text();
      regNumber = regNumber.substr(0, 4) + " " + regNumber.substr(4);
      $(".jobRegistrationPlate").html(
        "<b style='padding: 0 5px'>" + regNumber + "<b>"
      );
    },
    error: function () {},
  });
});

// If selected job type does not include either 'deinstall' or 'de-install'
// then disable the Old VRM dropdown
$(document).on("change", "#jobJobType", function () {
  var selectedType = $("#jobJobType option:selected").text().toUpperCase();

  if (
    selectedType.includes("DEINSTALL") ||
    selectedType.includes("DE-INSTALL")
  ) {
    $(".addJobTypeOldVRN").prop("disabled", false);
    // $('.addJobTypeVRN').prop('disabled', true);
  } else {
    $(".addJobTypeOldVRN").prop("disabled", true);
    // $('.addJobTypeVRN').prop('disabled', false);
  }

  if ($("#jobCameraType").val() != null) {
    updateJobRate();
  }
});

$(document).on("change", "#jobCameraType", function () {
  if ($("#jobJobType").val() != null) {
    updateJobRate();
  }
});

$(document).on("change", "#editJobType", function () {
  var selectedType = $("#editJobType option:selected").text().toUpperCase();

  if (
    selectedType.includes("DEINSTALL") ||
    selectedType.includes("DE-INSTALL")
  ) {
    $("#editJobOldVRN").prop("disabled", false);
    $("#editJobVRN").prop("disabled", true);
  } else {
    $("#editJobOldVRN").prop("disabled", true);
    $("#editJobVRN").prop("disabled", false);
  }
});

// When adding a job, if the job quantity is changed then
$(document).on("change", "#jobQuantity", function () {
  // Maximum quantity is 50
  if ($("#jobQuantity").val() > 50) {
    $("#jobQuantity").val("50");
  }
  // Get empty template for old VRN dropdown list, VRN dropdown list and new button for the quantity selected
  var dataToPost = {};
  dataToPost.Quantity = $("#jobQuantity").val();
  $.ajax({
    url: "getVRNControlList.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      $("#VRNListForJob").html(data);
      $("#jobCustomerName").trigger("change");
    },
    error: function () {},
  });
});

// When job rate field loses focus, then format it as currency
$(document).on("blur", "#jobRate", function () {
  $("#jobRate").val(formatAsCurrency($("#jobRate").val()));
});
$(document).on("blur", "#customerJobRate", function () {
  $("#customerJobRate").val(formatAsCurrency($("#customerJobRate").val()));
});
$(document).on("blur", "#editJobRate", function () {
  $("#editJobRate").val(formatAsCurrency($("#editJobRate").val()));
});
$(document).on("blur", "#editCustomerJobRate", function () {
  $("#editCustomerJobRate").val(
    formatAsCurrency($("#editCustomerJobRate").val())
  );
});

// When editing a job, if the booking date changes/when focus is lost
// set the job status, e.g. Pending, Booked date passed.
$(document).on("blur", "#editJobDateBooked", function () {
  var today = new Date().getTime();
  var jobWhen = new Date(
    document.getElementById("editJobDateBooked").value
  ).getTime();

  if ($("#editHubCompleted").prop("checked") == true) {
    $("#jobCurrentStatus").html(
      "<h6>STATUS: <span style='color: #198754;'>COMPLETE</span></h6>"
    );
  } else if ($("#editJobCompleted").prop("checked") == true) {
    $("#jobCurrentStatus").html(
      "<h6>STATUS: <span style='color: #FFAA00;'>AWAITING APPROVAL</span></h6>"
    );
  } else if (isNaN(jobWhen)) {
    $("#jobCurrentStatus").html(
      "<h6>STATUS: <span style='color: #FFAA00;'>PENDING</span></h6>"
    );
  } else if (today > jobWhen) {
    $("#jobCurrentStatus").html(
      "<h6>STATUS: <span style='color: #b60000;'>BOOKED - DATE PASSED</span></h6>"
    );
  } else if (jobWhen > today) {
    $("#jobCurrentStatus").html(
      "<h6>STATUS: <span style='color: #FFAA00;'>BOOKED</span></h6>"
    );
  } else {
    $("#jobCurrentStatus").html(
      "<h6>STATUS: <span style='color: #FFAA00;'>NEW JOB SETUP</span></h6>"
    );
  }
});

$(document).on("click", "#editMultipleJobs", function () {
  // $('#multipleJobs')
  $("#modalEditMultipleJobs").modal("show");
});

$(document).on("click", "#jobInvoicedSwitch", function () {
  if ($("#jobInvoicedSwitch").is(":checked") == true) {
    $("#jobIsInvoiced").html(
      "<div style='color: #77FF77; margin-top:13px;'><b>YES</b></div>"
    );
  } else {
    $("#jobIsInvoiced").html(
      "<div style='color: #FF7777; margin-top:13px;'><b>NO</b></div>"
    );
  }
});
$(document).on("click", "#monthlyInvoiceSwitch", function () {
  if ($("#monthlyInvoiceSwitch").is(":checked") == true) {
    $("#monthlyUpdated").html(
      "<div style='color: #77FF77; margin-top:13px;'><b>YES</b></div>"
    );
  } else {
    $("#monthlyUpdated").html(
      "<div style='color: #FF7777; margin-top:13px;'><b>NO</b></div>"
    );
  }
});
$(document).on("click", "#approvedSwitch", function () {
  if ($("#approvedSwitch").is(":checked") == true) {
    $("#approvedPayment").html(
      "<div style='color: #77FF77; margin-top:13px;'><b>YES</b></div>"
    );
  } else {
    $("#approvedPayment").html(
      "<div style='color: #FF7777; margin-top:13px;'><b>NO</b></div>"
    );
  }
});

function addNewJob() {
  var dataToPost = {};

  // dataToPost = $('#getAddJob').serializeArray();

  dataToPost.jobCustomerName = $("#jobCustomerName").val();
  dataToPost.jobJobType = $("#jobJobType").val();
  dataToPost.jobTypeString = $("#jobJobType option:selected").text();
  dataToPost.jobCameraType = $("#jobCameraType").val();
  dataToPost.jobQuantity = $("#jobQuantity").val();

  if ($("#LT").is(":checked")) {
    dataToPost.jobLT = "on";
  } else {
    dataToPost.jobLT = "off";
  }
  if ($("#SS").is(":checked")) {
    dataToPost.jobSS = "on";
  } else {
    dataToPost.jobSS = "off";
  }

  dataToPost.jobPriority = $("#jobPriority").val();
  dataToPost.jobRate = $("#jobRate").val();
  dataToPost.jobCustomerRate = $("#customerJobRate").val();
  dataToPost.jobNotes = $("#jobNotes").val();
  dataToPost.jobContactName = $("#jobContactName").val();
  dataToPost.jobContactEmail = $("#jobContactEmail").val();
  dataToPost.jobContactPhone = $("#jobContactPhone").val();
  dataToPost.jobInstallAddress = $("#jobInstallAddress").val();

  // VRN's
  var vehicles = document.getElementsByClassName("addJobTypeVRN");
  dataToPost.VRN = {};
  for (var ix = 0; ix < vehicles.length - 1; ix++) {
    dataToPost.VRN[ix] = vehicles[ix].value;
  }

  dataToPost.bookingLocation = $("#bookingLocation").val();
  dataToPost.engineerAssigned = $("#engineerAssigned").val();
  dataToPost.jobDateBooked = $("#jobDateBooked").val();
  dataToPost.jobTimeBooked = $("#jobTimeBooked").val();
  radios = $("input[name=jobTimeBooked]");
  radio = radios.filter(":checked");
  if (radio.length) {
    dataToPost.timePeriod = radio[0]["id"];
  } else {
    dataToPost.timePeriod = "";
  }

  dataToPost.jobStatus = 0; // new job setup
  dataToPost.VRNError = $("#jobVRNErrorCount").val();
  $.ajax({
    url: "../php/jobs/addNewJob.php",
    timeout: 30000,
    type: "POST",
    data: dataToPost,
    success: function (data) {
      if (data.includes("success")) {
        var newID = parseInt(data.replace("success", ""), 10);

        if (document.getElementById("hiddenJobSelector").value == "job") {
          $("#showJobList").trigger("click");
        } else {
          $("#getClient").trigger("change");
          showCustomers(newID);

          var dataToPost = {};
          dataToPost.selectedValue = newID;

          $.ajax({
            url: "customers.php",
            type: "POST",
            data: dataToPost,
            success: function (data) {
              $("#customerInfo").html(data);
            },
            error: function () {},
          });
        }
        $("#modalAddNewJobRequest").modal("hide");
        $("#modalAddNewJobRequest").trigger("reset");
      } else {
        document.getElementById("jobRequestMessage").innerHTML = data;
      }
    },
  });
}

function showFullJob(rowNumber) {
  var dataToPost = {};
  dataToPost.jobCustomer = "";
  var editMode = "";
  if (rowNumber.includes("edit")) {
    rowNumber = rowNumber.replace("edit", "");
    editMode = "edit";
  } else {
    rowNumber = rowNumber.replace("view", "");
    editMode = "view";
  }

  if (rowNumber.includes("j")) {
    rowNumber = rowNumber.replace("j", "");
    $("#hiddenJobSelector").val("job");
    var dtp = {};
    dtp.jobID = rowNumber;
    $.ajax({
      url: "getJobCustomer.php",
      data: dtp,
      type: "POST",
      success: function (data) {
        $("#hiddenCustomerID").text(data);
      },
    });
  }

  dataToPost.jobCustomer = $("#hiddenCustomerID").text();
  dataToPost.jobID = rowNumber;
  document.getElementById("hiddenJobID").text = rowNumber;
  var currentVRN;
  var oldVRN;

  $.when(
    $.ajax({
      url: "getJobDropDowns.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        data = $.parseJSON(data);
        $("#editJobCustomerName").val(data["ownerID"]);
        $("#editJobCustomerName").trigger("change");
        $("#editJobType").val(data["jobType"]);
        $("#editJobCameraType").val(data["cameraTypeID"]);
        $("#editJobPriority").val(data["priorityIsUrgent"]);
        $("#editJobRate").val(formatAsCurrency(data["JobRate"]));
        $("#editCustomerJobRate").val(formatAsCurrency(data["customerRate"]));
        $("#editJobNotes").val(data["notes"]);
        $("#editJobContactName").val(data["bookingContact"]);
        $("#editJobContactEmail").val(data["bookingEmail"]);
        $("#editJobContactPhone").val(data["BookingTelephone"]);
        $("#editJobInstallAddress").val(data["bookingAddress"]);
        $("#editBookingLocation").val(data["equipmentLocationID"]);
        $("#editEngineerAssigned").val(data["engineerID"]);

        const timePeriod = data["timePeriod"];

        if (data["date"]) {
          bookedDate = data["date"].substring(0, 10);
        } else {
          bookedDate = "";
        }

        switch (timePeriod) {
          case "1":
            $("#editJobTimeBooked").val(null);
            $("#editJobTimeAllDay").prop("checked", true);
            break;
          case "2":
            $("#editJobTimeBooked").val(null);
            $("#editJobTimeAM").prop("checked", true);
            break;
          case "3":
            $("#editJobTimeBooked").val(null);
            $("#editJobTimePM").prop("checked", true);
            break;
          default:
            if (data["date"]) {
              $("#editJobTimeBooked").val(data["date"].substring(11));
              $("#editJobTimePM").prop("checked", false);
              $("#editJobTimeAM").prop("checked", false);
              $("#editJobTimeAllDay").prop("checked", false);
            } else {
              bookedDate = "TBD";
            }
        }

        if (data["jobInvoiced"] == 2) {
          $("#jobInvoicedSwitch").attr("disabled", true);
          $("#jobIsInvoiced").html(
            "<div style='color: #7F7F7F; margin-top:13px;'><b>N/A</b></div>"
          );
        } else if (data["jobInvoiced"] == 0) {
          $("#jobInvoicedSwitch").attr("disabled", false);
          $("#jobInvoicedSwitch").attr("checked", true);
          $("#jobInvoicedSwitch").trigger("click");
        } else if (data["jobInvoiced"] == 1) {
          $("#jobInvoicedSwitch").attr("disabled", false);
          $("#jobInvoicedSwitch").attr("checked", false);
          $("#jobInvoicedSwitch").trigger("click");
        }

        if (data["monthlyInvoice"] == 2) {
          $("#monthlyInvoiceSwitch").attr("disabled", true);
          $("#monthlyUpdated").html(
            "<div style='color: #7F7F7F; margin-top:13px;'><b>N/A</b></div>"
          );
        } else if (data["monthlyInvoice"] == 0) {
          $("#monthlyInvoiceSwitch").attr("disabled", false);
          $("#monthlyInvoiceSwitch").attr("checked", true);
          $("#monthlyInvoiceSwitch").trigger("click");
        } else if (data["monthlyInvoice"] == 1) {
          $("#monthlyInvoiceSwitch").attr("disabled", false);
          $("#monthlyInvoiceSwitch").attr("checked", false);
          $("#monthlyInvoiceSwitch").trigger("click");
        }

        if (data["approvedPayment"] == 2) {
          $("#approvedSwitch").attr("disabled", true);
          $("#approvedPayment").html(
            "<div style='color: #7F7F7F; margin-top:13px;'><b>N/A</b></div>"
          );
        } else if (data["approvedPayment"] == 0) {
          $("#approvedSwitch").attr("disabled", false);
          $("#approvedSwitch").attr("checked", true);
          $("#approvedSwitch").trigger("click");
        } else if (data["approvedPayment"] == 1) {
          $("#approvedSwitch").attr("disabled", false);
          $("#approvedSwitch").attr("checked", false);
          $("#approvedSwitch").trigger("click");
        }

        $("#editJobDateBooked").val(bookedDate);
        $("#editJobCompleted").val(data["jobCompleteFlag"]);
        $("#editHubCompleted").val(data["TDHSignOff"]);
        currentVRN = data["VRN"];
        oldVRN = data["oldVRN"];

        if ($("#regPicContent").length > 0) {
          document.getElementById("regPicContent").innerHTML = "";
        }

        if ($("#devicePicContent").length > 0) {
          document.getElementById("devicePicContent").innerHTML = "";
        }

        $("#regPicContent").removeClass("imageLoaded");
        $("#devicePicContent").removeClass("imageLoaded");

        if (data["regPicFilename"] && $("#regPicContent").length > 0) {
          document.getElementById("regPicContent").innerHTML =
            "<img src = '" + data["regPicFilename"] + "' width='160'>";
          $("#regPicContent").addClass("imageLoaded");
          $("#downloadImages").css("display", "inline");
        }

        if (data["regPicDeviceDetails"] && $("#devicePicContent").length > 0) {
          document.getElementById("devicePicContent").innerHTML =
            "<img src = '" + data["regPicDeviceDetails"] + "' width='160'>";
          $("#devicePicContent").addClass("imageLoaded");
          $("#downloadImages").css("display", "inline");
        }

        if ((data["otherKitFlag"] & 1) == 1) {
          $("#editLT").prop("checked", true);
        } else {
          $("#editLT").prop("checked", false);
        }
        if ((data["otherKitFlag"] & 2) == 2) {
          $("#editSS").prop("checked", true);
        } else {
          $("#editSS").prop("checked", false);
        }
        if (data["jobCompleteFlag"] == 1) {
          $("#editJobCompleted").prop("checked", true);
        } else {
          $("#editJobCompleted").prop("checked", false);
        }
        if (data["TDHSignOff"] == 1) {
          $("#editHubCompleted").prop("checked", true);
        } else {
          $("#editHubCompleted").prop("checked", false);
        }

        var today = new Date().getTime();
        var jobWhen = new Date(data["date"]).getTime();

        if (data["status"] == "32") {
          $("#jobCurrentStatus").html(
            "<h6>STATUS: <span style='color: #ff00ff;'>CANCELLED</span></h6>"
          );
          $("#engineerInvoice").val(data["engineerInvoiceNo"]);
        } else if (data["status"] == "64") {
          $("#jobCurrentStatus").html(
            "<h6>STATUS: <span style='color: #888888;'>ARCHIVED</span></h6>"
          );
          $("#engineerInvoice").val(data["engineerInvoiceNo"]);
        } else if (data["TDHSignOff"] == 1) {
          $("#jobCurrentStatus").html(
            "<h6>STATUS: <span style='color: #198754;'>COMPLETE</span></h6>"
          );
          $("#engineerInvoice").val(data["engineerInvoiceNo"]);
        } else if (data["jobCompleteFlag"] == 1) {
          $("#jobCurrentStatus").html(
            "<h6>STATUS: <span style='color: #ffaa00;'>AWAITING APPROVAL</span></h6>"
          );
          $("#engineerInvoice").val(data["engineerInvoiceNo"]);
        } else if (jobWhen == 0) {
          $("#jobCurrentStatus").html(
            "<h6>STATUS: <span style='color: #ffaa00;'>PENDING</span></h6>"
          );
        } else if (today > jobWhen) {
          $("#editJobDateBooked").prop("color", "red");
          $("#jobCurrentStatus").html(
            "<h6>STATUS: <span style='color: #b60000;'>BOOKED - DATE PASSED</span></h6>"
          );
        } else if (jobWhen > today) {
          $("#jobCurrentStatus").html(
            "<h6>STATUS: <span style='color: #ffaa00;'>BOOKED</span></h6>"
          );
        }
        $("#modalEditNewJobRequest").modal("show");
        // disable controls not avasilable to job admin users
        if (userType.isInstaller == "1") {
          $("*[id*=editJob]").each(function () {
            console.log($(this)[0].type);
            if (
              $(this)[0].type === "text" ||
              $(this)[0].type === "textarea" ||
              $(this)[0].type === "select-one" ||
              $(this)[0].type === "date"
            ) {
              $(this).attr("disabled", true);
            }
            $("#editBookingLocation").attr("disabled", true);
            // $("#editEngineerAssigned").attr("disabled", true);
            $("#editLT").attr("disabled", true);
            $("#editSS").attr("disabled", true);
            $("#jobInvoicedSwitch").attr("disabled", true);
            $("#monthlyInvoiceSwitch").attr("disabled", true);
            $("#approvedSwitch").attr("disabled", true);
            $("#editJobNotes").attr("disabled", false);
          });
        } else {
          $("*[id*=editJob]").each(function () {
            $(this).attr("disabled", false);
          });
        }
      },
      error: function () {},
    })
  ).done(function () {
    if (currentVRN == null) {
      currentVRN = 0;
    }
    if (oldVRN == null) {
      oldVRN = 0;
    }

    if (currentVRN != 0) {
      var $cs = $("#editJobVRN");
      $cs.val(currentVRN.toString());
      $cs.trigger("change");
      let regNumber = $("#editJobVRN option:selected").text();
      regNumber = regNumber.substr(0, 4) + " " + regNumber.substr(4);
      $(".jobRegistrationPlate").html(
        "<b style='padding: 0 5px'>" + regNumber + "<b>"
      );
    }
    if (oldVRN != 0) {
      var $os = $("#editJobOldVRN");
      $os.val(oldVRN.toString());
      $os.trigger("change");
    }
  });
}

function editJobComplete(buttonClicked) {
  var updateType = $("#editJobComplete").text();
  if (buttonClicked == 2) {
    updateType = "Update";
  }

  var dataToPost = {};
  dataToPost.jobID = document.getElementById("hiddenJobID").text;

  if (updateType == "Mark as Outstanding") {
    dataToPost.jobStatus = "allowUpdate";
  } else if (updateType == "Mark as Complete") {
    dataToPost.jobStatus = "allowEdit";
    dataToPost.jobDate = document.getElementById("editJobDate").value;
    dataToPost.jobType = document.getElementById("editJobTypeType").value;
    dataToPost.jobVRN = document.getElementById("editJobTypeVRN").value;
    dataToPost.jobNotes = document.getElementById("editJobNotes").value;
  } else if (updateType == "Update") {
    dataToPost.jobStatus = "updateOnly";
    dataToPost.jobDate = document.getElementById("editJobDate").value;
    dataToPost.jobType = document.getElementById("editJobTypeType").value;
    dataToPost.jobVRN = document.getElementById("editJobTypeVRN").value;
    dataToPost.jobNotes = document.getElementById("editJobNotes").value;
  }

  $.ajax({
    url: "updateJobRequest.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      alert(data);
      $("#getClient").trigger("change");
      $("#showJobList").trigger("change");
      $("#modalEditNewJobRequest").modal("hide");
    },
    error: function () {},
  });
}

function ShowJobRequests() {
  $.ajax({
    url: "getOSJobRequests",
    type: "POST",
    success: function (data) {
      document.getElementById("alertScreen").innerHTML = data;
    },
  });
}

function showJobNotes(rowNumber) {
  if (rowNumber.includes("customer")) {
    document.getElementById("hiddenJobNotesSelector").value = "customer";
    rowNumber = rowNumber.replace("customer", "");
  } else if (rowNumber.includes("job")) {
    document.getElementById("hiddenJobNotesSelector").value = "job";
    rowNumber = rowNumber.replace("job", "");
  } else if (rowNumber.includes("DHI")) {
    document.getElementById("hiddenJobNotesSelector").value = "DHI";
    rowNumber = rowNumber.replace("DHI", "");
  }

  var dataToPost = {};
  dataToPost.jobID = rowNumber;
  $.ajax({
    url: "../php/jobs/getCurrentJobNotes.php",
    timeout: 30000,
    data: dataToPost,
    datatype: "json",
    type: "POST",
    success: function (data) {
      data = $.parseJSON(data);
      document.getElementById("editJobNotesText").value = data["notes"];
      document.getElementById("hiddenJobNotesID").value = rowNumber;
      $("#modalEditJobNotes").modal("show");
    },
    error: function () {},
  });
}

function editCurrentJobNotes() {
  var dataToPost = {};
  dataToPost.jobID = document.getElementById("hiddenJobNotesID").value;
  dataToPost.jobNote = document.getElementById("editJobNotesText").value;

  $.ajax({
    url: "updateEditJobNotes.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        $("#editJobNotesMessage").html("");
        $("#modalEditJobNotes").modal("hide");

        if (document.getElementById("hiddenJobNotesSelector").value == "job") {
          $("#showJobList").trigger("change");
        } else {
          $("#getClient").trigger("change");
        }
      } else {
        $("#editJobMessage").html(data);
      }
    },
    error: function () {},
  });
}

function editCurrentJob() {
  var dataToPost = {};
  dataToPost.jobID = document.getElementById("hiddenJobID").text;
  dataToPost.customerID = document.getElementById("editJobCustomerName").value;
  dataToPost.jobType = document.getElementById("editJobType").value;
  dataToPost.cameraType = document.getElementById("editJobCameraType").value;
  dataToPost.jobPriority = 1;
  dataToPost.LTAlarm = $("#editLT").prop("checked");
  dataToPost.SideSensor = $("#editSS").prop("checked");
  var jR = document.getElementById("editJobRate");
  if (jR != null && jR.value != "") {
    dataToPost.jobRate = jR.value;
  } else {
    dataToPost.jobRate = 0;
  }
  var cjR = document.getElementById("editCustomerJobRate");
  if (cjR != null && cjR.value != "") {
    dataToPost.jobCustomerRate = cjR.value;
  } else {
    dataToPost.jobCustomerRate = 0;
  }

  dataToPost.jobNotes = document.getElementById("editJobNotes").value;
  dataToPost.jobContact = document.getElementById("editJobContactName").value;
  dataToPost.jobEmail = document.getElementById("editJobContactEmail").value;
  dataToPost.jobPhone = document.getElementById("editJobContactPhone").value;
  dataToPost.jobVRN = document.getElementById("editJobVRN").value;
  // dataToPost.oldVRN = document.getElementById('editJobOldVRN').value;
  dataToPost.jobInstallAddress = document.getElementById(
    "editJobInstallAddress"
  ).value;
  dataToPost.jobLocation = document.getElementById("editBookingLocation").value;
  dataToPost.jobEngineer = document.getElementById(
    "editEngineerAssigned"
  ).value;
  dataToPost.jobDateBooked = document.getElementById("editJobDateBooked").value;
  dataToPost.jobTimeBooked = document.getElementById("editJobTimeBooked").value;
  radios = $("input[name=editJobTimeBooked]");
  radio = radios.filter(":checked");
  if (radio.length) {
    timePeriod = radio[0]["id"];
  } else {
    timePeriod = "";
  }

  switch (timePeriod) {
    case "editJobTimeAllDay":
      dataToPost.timePeriod = 1;
      break;
    case "editJobTimeAM":
      dataToPost.timePeriod = 2;
      break;
    case "editJobTimePM":
      dataToPost.timePeriod = 3;
      break;
    default:
      dataToPost.timePeriod = 0;
  }

  dataToPost.jobCompleted = $("#editJobCompleted").prop("checked");
  dataToPost.TDHSignOff = $("#editHubCompleted").prop("checked");
  dataToPost.picReg = $("#regPicContent img").attr("src");
  dataToPost.picDevice = $("#devicePicContent img").attr("src");
  dataToPost.jobInvoiced = $("#jobIsInvoiced").text();
  dataToPost.monthlyInvoice = $("#monthlyUpdated").text();
  dataToPost.invoiceApproved = $("#approvedPayment").text();

  var today = new Date().getTime();
  var jobWhen = new Date(
    document.getElementById("editJobDateBooked").value
  ).getTime();

  // if (dataToPost.TDHSignOff == true) {
  //     dataToPost.jobStatus = 4; //complete
  // } else if (dataToPost.jobCompleted == true) {
  //     dataToPost.jobStatus = 8; // Awaiting Approval
  // } else if (isNaN(jobWhen)) {
  //     dataToPost.jobStatus = 32; // Pending
  // } else if (today > jobWhen) {
  //     dataToPost.jobStatus = 16; // Booked - date passed
  // } else if (jobWhen > today) {
  //     dataToPost.jobStatus = 8; // booked
  // } else {
  //     dataToPost.jobStatus = 32; // pending
  // }

  if (dataToPost.TDHSignOff == true) {
    dataToPost.jobStatus = 16; //complete
  } else if (dataToPost.jobCompleted == true) {
    dataToPost.jobStatus = 8; // Awaiting Approval
  } else if (isNaN(jobWhen)) {
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
    url: "updateJobRequest.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        $("#editJobMessage").html("");
        $("#modalEditNewJobRequest").modal("hide");

        if (document.getElementById("hiddenJobSelector").value == "job") {
          $("#showJobList").trigger("click");
        } else {
          $("#getClient").trigger("change");
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
        $("#editJobMessage").html(data);
      }
    },
    error: function () {},
  });
}

function deleteCurrentJob() {
  var dataToPost = {};
  dataToPost.jobID = document.getElementById("hiddenJobID").text;

  new swal({
    text: "Are you sure you want to delete this job?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "No Don't",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../php/jobs/deleteJob.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#modalEditNewJobRequest").modal("hide");
            if (document.getElementById("hiddenJobSelector").value == "job") {
              $("#showJobList").trigger("click");
            } else {
              $("#getClient").trigger("change");
              showCustomers(newID);

              var dataToPost = {};
              dataToPost.selectedValue = newID;

              $.ajax({
                url: "customers.php",
                type: "POST",
                data: dataToPost,
                success: function (data) {
                  $("#customerInfo").html(data);
                },
                error: function () {},
              });
            }
          } else {
          }
        },
        error: function () {},
      });
    }
  });
}

$(document).on("change", "#editJobCompleted", function () {
  // switch off TDH sign off if Job Completed is switched off
  if ($("#editJobCompleted").prop("checked") == false) {
    $("#editHubCompleted").prop("checked", false);
  }

  // have both pics been uploaded?
  var RegUploaded = $("#regPicContent").hasClass("imageLoaded");
  var DeviceUploaded = $("#devicePicContent").hasClass("imageLoaded");

  var errorString = "";
  if (RegUploaded == false) {
    errorString = "the vehicle registration plate";
  }
  if (DeviceUploaded == false) {
    if (errorString == "") {
      errorString += "the device details";
    } else {
      errorString += " and a picture of the device details";
    }
  }
  if (
    (RegUploaded == false || DeviceUploaded == false) &&
    $("#editJobCompleted").prop("checked") == true
  ) {
    new swal(
      "Cannot update",
      "A picture of " +
        errorString +
        " must be uploaded before the job can be marked as complete.",
      "error"
    );
    $("#editJobCompleted").prop("checked", false);
    return;
  }

  $("#editJobDateBooked").trigger("blur");
});

$(document).on("change", "#editHubCompleted", function () {
  if (
    $("#editJobCompleted").prop("checked") == false &&
    $("#editHubCompleted").prop("checked") == true
  ) {
    new swal(
      "Cannot update",
      "The job cannot be signed off until it is completed",
      "error"
    );

    $("#editHubCompleted").prop("checked", false);
    return;
  }

  $("#editJobDateBooked").trigger("blur");
});

function cancelCurrentJob() {
  var dataToPost = {};
  dataToPost.jobID = document.getElementById("hiddenJobID").text;

  new swal({
    text: "Are you sure you want to cancel this job?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - cancel",
    denyButtonText: "No Don't",
  }).then((result) => {
    if (result.isConfirmed) {
      new swal({
        showDenyButton: true,
        denyButtonText: "Just archive",
        confirmButtonText: "Cancellation fee",
        title: "Confirm cancellation",
        icon: "info",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "../php/jobs/cancelJob.php",
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function (data) {
              if (data.includes("complete8")) {
                new swal({
                  text: "Cannot cancel job, it is just awaiting approval.",
                  icon: "info",
                  showCloseButton: true,
                });
              }
              if (data.includes("complete16")) {
                new swal({
                  text: "Cannot cancel job, it has already been completed.",
                  icon: "info",
                  showCloseButton: true,
                });
              }
              if (data.includes("complete32")) {
                new swal({
                  text: "Job is already cancelled.",
                  icon: "info",
                  showCloseButton: true,
                });
              }
              if (data.includes("complete64")) {
                new swal({
                  text: "Job is already archived.",
                  icon: "info",
                  showCloseButton: true,
                });
              }

              $("#modalEditNewJobRequest").modal("hide");
              $("#showJobList").trigger("click");
            },
          });
        } else {
          $.ajax({
            //archive job
            url: "../php/jobs/archiveJob.php",
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function () {
              $("#modalEditNewJobRequest").modal("hide");
              $("#showJobList").trigger("click");
            },
          });
        }
      });
    }
  });
}

$(document).on("click", ".addVRNButton", function (event) {
  if ($("#jobCustomerName").val() == null) {
    return;
  }
  $("#modalGetNewVRN").modal("show");

  $("#addVRNforCustomer").val($("#jobCustomerName").find(":selected").val());

  $("#newVRN").val("");
  $("#newVRNMessage").html("");
});

$(document).on("click", "#addNewVRNToCustomer", function () {
  // make sure any spaces are stripped from the Vehicle Registration and it is all uppercase
  dataToPost = {};
  dataToPost.NewVRN = $("#newVRN").val().toUpperCase().split(" ").join("");
  dataToPost.customerID = $("#addVRNforCustomer").val();

  $.ajax({
    url: "addNewRegistration.php",
    timeout: 30000,
    data: dataToPost,
    async: false,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        var newVehicleID = parseInt(data.replace("success", ""));
        $("#jobCustomerName").trigger("change");
        $("#modalGetNewVRN").modal("hide");
        $(".addJobTypeVRN").val(newVehicleID).change();
      } else {
        $("#newVRNMessage").html(data);
      }
    },
    error: function () {},
  });

  if (document.getElementById("hiddenJobSelector").value == "job") {
    $("#showJobList").trigger("click");
  } else {
    $("#getClient").trigger("change");
  }
});

function addJobRequest(selector, customerID) {
  $("#hiddenJobSelector").val(selector);

  if (selector == "customer") {
    $(function () {
      $("#modalAddNewJobRequest").modal("show");
      $("#jobCustomerName").val($("#hiddenCustomerID").text());
      $("#jobCustomerName").trigger("change");
      $("#jobCustomerName").prop("disabled", "disabled");
      $("#jobQuantity").trigger("change");
    });
  } else {
    $(function () {
      $("#modalAddNewJobRequest").modal("show");
      $("#jobCustomerName").prop("disabled", false);
      $("#jobQuantity").trigger("change");
    });
  }
}

function showJobMap() {
  window.open("googleMap.php", "_newtab");
}

$(document).on("click", "#updateMapView", function () {
  var dataToPost = {};
  var map;
  dataToPost.startDate = document.getElementById("startReportDate").value;
  dataToPost.endDate = document.getElementById("endReportDate").value;
  dataToPost.engineerID = document.getElementById("engineerSelector").value;

  var jobs = [];

  $.ajax({
    url: "getJobCoordinates.php",
    data: dataToPost,
    type: "POST",
    success: function (data) {
      data = $.parseJSON(data);

      $.each(data, function (index, element) {
        if (jobs.length > 0) {
          var matched = false;
          for (ix = 0; ix < jobs.length; ix++) {
            if (
              jobs[ix]["latitude"] == data[index]["latitude"] &&
              jobs[ix]["longitude"] == data[index]["longitude"]
            ) {
              if (
                data[index]["latitude"] == 0 &&
                data[index]["longitude"] == 0
              ) {
                data[index]["bookingAddress"] =
                  "No Postcode entered, so set to Westbourne Road";
              }
              jobs[ix]["notes"] +=
                "<b style=background-color: #DDFF00>" +
                data[index]["userName"] +
                " has a job at " +
                data[index]["businessName"] +
                "</b><br>Address: " +
                data[index]["bookingAddress"] +
                "<br><br>" +
                data[index]["description"] +
                " at <b>" +
                data[index]["date"].substr(11, 5) +
                " (" +
                data[index]["date"].substr(8, 2) +
                "/" +
                data[index]["date"].substr(5, 2) +
                "/" +
                data[index]["date"].substr(0, 4) +
                ")</b><br>" +
                data[index]["notes"] +
                "<br>VRM: " +
                data[index]["regNumber"];
              jobs[ix]["notes"] += "<br>Status: ";

              switch (parseInt(data[index]["status"])) {
                case 1:
                  jobs[ix]["notes"] += "Pending";
                  break;
                case 2:
                  jobs[ix]["notes"] += "Booked";
                  break;
                case 4:
                  jobs[ix]["notes"] += "Booked - date passed";
                  break;
                case 8:
                  jobs[ix]["notes"] += "Awaiting approval";
                  break;
                case 16:
                  jobs[ix]["notes"] += "Completed";
                  break;
                case 32:
                  jobs[ix]["notes"] += "Cancelled";
                  break;
              }
              jobs[ix]["notes"] += "<hr>";
              jobs[ix]["status"] = data[index]["status"];
              matched = true;
            }
          }
          if (!matched) {
            if (data[index]["latitude"] == 0 && data[index]["longitude"] == 0) {
              data[index]["bookingAddress"] =
                "No Postcode entered, so set to Westbourne Road";
            }
            newnote =
              "<b style=background-color: #DDFF00>" +
              data[index]["userName"] +
              " has a job at " +
              data[index]["businessName"] +
              "</b><br>Address: " +
              data[index]["bookingAddress"] +
              "<br><br>" +
              data[index]["description"] +
              " at <b>" +
              data[index]["date"].substr(11, 5) +
              " (" +
              data[index]["date"].substr(8, 2) +
              "/" +
              data[index]["date"].substr(5, 2) +
              "/" +
              data[index]["date"].substr(0, 4) +
              ")</b><br>" +
              data[index]["notes"] +
              "<br>VRM: " +
              data[index]["regNumber"];
            newnote += "<br>Status: ";
            switch (parseInt(data[index]["status"])) {
              case 1:
                newnote += "Pending";
                break;
              case 2:
                newnote += "Booked";
                break;
              case 4:
                newnote += "Booked - date passed";
                break;
              case 8:
                newnote += "Awaiting approval";
                break;
              case 16:
                newnote += "Completed";
                break;
              case 32:
                newnote += "Cancelled";
                break;
            }
            newnote += "<hr>";

            newjob = {
              userName: data[index]["userName"],
              latitude: data[index]["latitude"],
              longitude: data[index]["longitude"],
              notes: newnote,
              status: data[index]["status"],
              count: 0,
            };
            jobs.push(newjob);
          }
        } else {
          if (data[index]["latitude"] == 0 && data[index]["longitude"] == 0) {
            data[index]["bookingAddress"] =
              "No Postcode entered, so set to Westbourne Road";
          }
          newnote =
            "<b style=background-color: #DDFF00>" +
            data[index]["userName"] +
            " has a job at " +
            data[index]["businessName"] +
            "</b><br>Address:" +
            data[index]["bookingAddress"] +
            "<br><br>" +
            data[index]["description"] +
            " at <b>" +
            data[index]["date"].substr(11, 5) +
            " (" +
            data[index]["date"].substr(8, 2) +
            "/" +
            data[index]["date"].substr(5, 2) +
            "/" +
            data[index]["date"].substr(0, 4) +
            ")</b><br>" +
            data[index]["notes"] +
            "<br>VRM: " +
            data[index]["regNumber"];
          newnote += "<br>Status: ";
          switch (parseInt(data[index]["status"])) {
            case 1:
              newnote += "Pending";
              break;
            case 2:
              newnote += "Booked";
              break;
            case 4:
              newnote += "Booked - date passed";
              break;
            case 8:
              newnote += "Awaiting approval";
              break;
            case 16:
              newnote += "Completed";
              break;
            case 32:
              newnote += "Cancelled";
              break;
          }
          newnote += "<hr>";

          newjob = {
            userName: data[index]["userName"],
            latitude: data[index]["latitude"],
            longitude: data[index]["longitude"],
            notes: newnote,
            status: data[index]["status"],
            count: 0,
          };
          jobs.push(newjob);
        }

        // jobs[index] = new Array( data[index]['userName'] + " job at <b>" + data[index]['businessName'] + "</b><br>" + data[index]['bookingAddress'] + "<br><br>" + data[index]['description'] + " at <b>" + data[index]['date'].substr(11,5) +" (" + data[index]['date'].substr(8,2) +"/" +  data[index]['date'].substr(5,2) +"/" +  data[index]['date'].substr(0,4)  +")</b><br><br>" + data[index]['notes'] + "<br><br>VRM: " + data[index]['regNumber'], parseFloat(data[index]['latitude']), parseFloat(data[index]['longitude']), data[index]['userName'], data[index]['status']);
      });

      // remove any duplicates (i.e. 3 jobs in one location)

      redrawJobs(jobs);
    },
    error: function () {},
  });

  function redrawJobs(jobs) {
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 7,
      center: {
        lat: 54.00366,
        lng: -2.547855,
      },
    });

    var infowindow = new google.maps.InfoWindow();
    var marker, i;

    for (var i = 0; i < jobs.length; i++) {
      var job = jobs[i];
      let user = String(job["userName"]);
      user = user.slice(0, 1);

      switch (parseInt(job["status"])) {
        case 1:
          if (user == "C" || user == "J") {
            iconString = `assets/map_pins/pendingPin${user}.png`;
          } else {
            iconString = "assets/map_pins/pendingPin.png";
          }
          break;
        case 2:
          if (user == "C" || user == "J") {
            iconString = `assets/map_pins/bookedPin${user}.png`;
          } else {
            iconString = "assets/map_pins/bookedPin.png";
          }
          break;
        case 4:
          if (user == "C" || user == "J") {
            iconString = `assets/map_pins/bookedPassedPin${user}.png`;
          } else {
            iconString = "assets/map_pins/bookedPassedPin.png";
          }
          break;
        case 8:
          if (user == "C" || user == "J") {
            iconString = `assets/map_pins/approvalPin${user}.png`;
          } else {
            iconString = "assets/map_pins/approvalPin.png";
          }
          break;
        case 16:
          if (user == "C" || user == "J") {
            iconString = `assets/map_pins/completePin${user}.png`;
          } else {
            iconString = "assets/map_pins/completePin.png";
          }
          break;
        case 32:
          if (user == "C" || user == "J") {
            iconString = `assets/map_pins/cancelPin${user}.png`;
          } else {
            iconString = "assets/map_pins/cancelPin.png";
          }
          break;
        default:
          iconString = "images/red_warning_24.png";
          break;
      }

      marker = new google.maps.Marker({
        animation: google.maps.Animation.DROP,
        position: {
          lat: parseFloat(job["latitude"]),
          lng: parseFloat(job["longitude"]),
        },
        map: map,
        icon: iconString,
      });

      google.maps.event.addListener(
        marker,
        "click",
        (function (marker, i) {
          return function () {
            infowindow.setContent(jobs[i]["notes"]);
            infowindow.open(map, marker);
          };
        })(marker, i)
      );
    }
  }
});

$(document).on("click", "#showJobRates", function () {
  $("#modalShowJobRates").modal("show");
});

$(document).on("focusout", ".number2decimal", function (e) {
  if (isNaN(e.currentTarget.value)) {
    e.currentTarget.value = "0.00";
    return;
  }
  if (e.currentTarget.value == 0) {
    e.currentTarget.value = "0.00";
    return;
  }

  e.currentTarget.value = parseFloat(e.currentTarget.value).toFixed(2);
});

$(document).on("change", "#jobRateDefault", function () {
  $checkState = document.getElementById("jobRateDefault").checked;

  if ($checkState) {
    updateJobRate();
    $("#jobRate").prop("disabled", true);
  } else {
    $("#jobRate").prop("disabled", false);
  }
});

function updateJobRates() {
  var dataToPost = new Map();
  var table = document.getElementsByClassName("number2decimal");

  for (var i = 0; i < table.length; i++) {
    dataToPost.set(table.item(i).id, table.item(i).value);
  }

  dataToPost.tableRates = JSON.stringify([...dataToPost]);

  $.ajax({
    url: "updateJobRates.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        $("#modalShowJobRates").modal("hide");
      } else {
        $("#jobRatesMessage").html(data);
      }
    },
    error: function () {},
  });
}

function updateJobRate() {
  var dataToPost = {};
  dataToPost.camera = $("#jobCameraType").val();
  dataToPost.jobType = $("#jobJobType").val();

  $.ajax({
    url: "getDefaultJobRate.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (document.getElementById("jobRateDefault").checked) {
        $("#jobRate").val(parseFloat(data).toFixed(2));
      }
    },
    error: function () {},
  });
}

$(document).on("change", ".selectCheckBox", function () {
  var checkState = document.getElementsByClassName("selectCheckBox");

  var count = 0;
  for (var i = 0; i < checkState.length; i++) {
    if (checkState[i].checked) {
      count++;
    } else {
    }
  }

  if (count != 1) {
    $("#multipleJobsMessage").html(count + " jobs selected");
  } else {
    $("#multipleJobsMessage").html(count + " job selected");
  }

  if (
    count == 0 ||
    ($("#changeJobType").val() == "0" &&
      $("#changeDeviceType").val() == "0" &&
      $("#newBookedDate").val() == "" &&
      $("#bulkJobTimeBooked").val() == "" &&
      $("#multipleUpdateDeviceAddress").val() == "" &&
      $("#multipleUpdateDeviceNote").val() == "" &&
      $("#changeEngineerType").val() == "")
  ) {
    $("#updateMultipleJobs").prop("disabled", true);
  } else {
    $("#updateMultipleJobs").prop("disabled", false);
  }
});

$(document).on("change", "#newBookedDate", function () {
  if (
    $("#changeJobType").val() == "0" &&
    $("#changeDeviceType").val() == "0" &&
    $("#newBookedDate").val() == "" &&
    $("#bulkJobTimeBooked").val() == "" &&
    $("#multipleUpdateDeviceAddress").val() == "" &&
    $("#multipleUpdateDeviceNote").val() == "" &&
    $("#changeEngineerType").val() == ""
  ) {
    $("#updateMultipleJobs").prop("disabled", true);
  } else {
    $("#updateMultipleJobs").prop("disabled", false);
  }
});

$(document).on("change", "#bulkJobTimeBooked", function () {
  if (
    $("#changeJobType").val() == "0" &&
    $("#changeDeviceType").val() == "0" &&
    $("#newBookedDate").val() == "" &&
    $("#bulkJobTimeBooked").val() == "" &&
    $("#multipleUpdateDeviceAddress").val() == "" &&
    $("#multipleUpdateDeviceNote").val() == "" &&
    $("#changeEngineerType").val() == ""
  ) {
    $("#updateMultipleJobs").prop("disabled", true);
  } else {
    $("#updateMultipleJobs").prop("disabled", false);
  }
});

$(document).on("change", "#changeJobType", function () {
  if (
    $("#changeJobType").val() == "0" &&
    $("#changeDeviceType").val() == "0" &&
    $("#newBookedDate").val() == "" &&
    $("#bulkJobTimeBooked").val() == "" &&
    $("#multipleUpdateDeviceAddress").val() == "" &&
    $("#multipleUpdateDeviceNote").val() == "" &&
    $("#changeEngineerType").val() == ""
  ) {
    $("#updateMultipleJobs").prop("disabled", true);
  } else {
    $("#updateMultipleJobs").prop("disabled", false);
  }
});

$(document).on("change", "#changeDeviceType", function () {
  if (
    $("#changeJobType").val() == "0" &&
    $("#changeDeviceType").val() == "0" &&
    $("#newBookedDate").val() == "" &&
    $("#bulkJobTimeBooked").val() == "" &&
    $("#multipleUpdateDeviceAddress").val() == "" &&
    $("#multipleUpdateDeviceNote").val() == "" &&
    $("#changeEngineerType").val() == ""
  ) {
    $("#updateMultipleJobs").prop("disabled", true);
  } else {
    $("#updateMultipleJobs").prop("disabled", false);
  }
});

$(document).on("change", "#changeEngineerType", function () {
  if (
    $("#changeJobType").val() == "0" &&
    $("#changeDeviceType").val() == "0" &&
    $("#newBookedDate").val() == "" &&
    $("#bulkJobTimeBooked").val() == "" &&
    $("#multipleUpdateDeviceAddress").val() == "" &&
    $("#multipleUpdateDeviceNote").val() == "" &&
    $("#changeEngineerType").val() == ""
  ) {
    $("#updateMultipleJobs").prop("disabled", true);
  } else {
    $("#updateMultipleJobs").prop("disabled", false);
  }
});

$(document).on("change", "#multipleUpdateDeviceAddress", function () {
  if (
    $("#changeJobType").val() == "0" &&
    $("#changeDeviceType").val() == "0" &&
    $("#newBookedDate").val() == "" &&
    $("#bulkJobTimeBooked").val() == "" &&
    $("#multipleUpdateDeviceAddress").val() == "" &&
    $("#multipleUpdateDeviceNote").val() == "" &&
    $("#changeEngineerType").val() == ""
  ) {
    $("#updateMultipleJobs").prop("disabled", true);
  } else {
    $("#updateMultipleJobs").prop("disabled", false);
  }
});

$(document).on("change", "#multipleUpdateDeviceNote", function () {
  if (
    $("#changeJobType").val() == "0" &&
    $("#changeDeviceType").val() == "0" &&
    $("#newBookedDate").val() == "" &&
    $("#bulkJobTimeBooked").val() == "" &&
    $("#multipleUpdateDeviceAddress").val() == "" &&
    $("#multipleUpdateDeviceNote").val() == "" &&
    $("#changeEngineerType").val() == ""
  ) {
    $("#updateMultipleJobs").prop("disabled", true);
  } else {
    $("#updateMultipleJobs").prop("disabled", false);
  }
});

function updateMultipleJobs() {
  var jobID = [];

  $("#multipleJobs")
    .find("tr")
    .each(function () {
      let checkedRow = $(this).find("input").is(":checked");

      if (checkedRow) {
        jobID.push($(this).attr("value"));
      }
    });

  var dataToPost = {};
  dataToPost.jobs = jobID;
  dataToPost.jobTypeID = $("#changeJobType").val();
  dataToPost.cameraTypeID = $("#changeDeviceType").val();
  dataToPost.bookedDate = $("#newBookedDate").val();
  dataToPost.bookedTime = $("#bulkJobTimeBooked").val();
  radios = $("input[name=bulkJobTimeBooked]");
  radio = radios.filter(":checked");
  if (radio.length) {
    dataToPost.timePeriod = radio[0]["id"];
  } else {
    dataToPost.timePeriod = "";
  }
  switch (dataToPost.timePeriod) {
    case "bulkJobTimeAllDay":
      dataToPost.timePeriod = 1;
      break;
    case "bulkJobTimeAM":
      dataToPost.timePeriod = 2;
      break;
    case "bulkJobTimePM":
      dataToPost.timePeriod = 3;
      break;
    default:
      dataToPost.timePeriod = 0;
  }
  dataToPost.changeAddress = $("#multipleUpdateDeviceAddress").val();
  dataToPost.appendNote = $("#multipleUpdateDeviceNote").val();
  dataToPost.jobEngineerID = $("#changeEngineerType").val();

  $.ajax({
    url: "updateMultipleJobs.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      $("#modalEditMultipleJobs").modal("hide");
      $("#showJobList").trigger("click");
    },
    error: function () {},
  });
}

// Reset the Edit Multiple Jobs Modal fields when form is closed
$(document).on("hidden.bs.modal", "#modalEditMultipleJobs", function () {
  $(this).find("form").trigger("reset");
  $("#multipleJobsMessage").html("");
});

$(document).on("click", "#jobListTable tbody td", function () {
  let dt = $("#jobListTable").DataTable();
  let vIndex = $(this).index();
  if (vIndex == 9) {
    return;
  }
  let colIndex = dt.column.index("fromData", vIndex);
  let clip = dt.column(colIndex).data();
  copyArrayToClipboard(clip);
});

$(document).on("click", "#downloadImages", function () {
  var regPic = $("#regPicContent").find("img");
  var imgName = regPic.first().attr("src");
  var regPic2 = $("#devicePicContent").find("img");
  var imgName2 = regPic2.first().attr("src");

  var imageName = imgName.split("/").pop();
  var el = document.createElement(`a`);
  el.setAttribute("href", imgName);
  el.setAttribute("download", imageName);
  document.body.appendChild(el);
  el.click();
  el.remove();

  imageName = imgName2.split("/").pop();
  el = document.createElement(`a`);
  el.setAttribute("href", imgName2);
  el.setAttribute("download", imageName);
  document.body.appendChild(el);
  el.click();
  el.remove();
});

$(document).on("click", "#engineerTable tr", function () {
  alert($(this).find("td:first").text());
});

$(document).on("blur", "#jobTimeBooked", function () {
  $("#jobTimeAllDay").prop("checked", false);
  $("#jobTimeAM").prop("checked", false);
  $("#jobTimePM").prop("checked", false);
});

$(document).on("change", "[name='jobTimeBooked']", function (e) {
  $("#jobTimeBooked").val("");
});

$(document).on("blur", "#editJobTimeBooked", function () {
  $("#editJobTimeAllDay").prop("checked", false);
  $("#editJobTimeAM").prop("checked", false);
  $("#editJobTimePM").prop("checked", false);
});

$(document).on("change", "[name='editJobTimeBooked']", function (e) {
  $("#editJobTimeBooked").val("");
});

$(document).on("blur", "#bulkJobTimeBooked", function () {
  $("#bulkJobTimeAllDay").prop("checked", false);
  $("#bulkJobTimeAM").prop("checked", false);
  $("#bulkJobTimePM").prop("checked", false);
});

$(document).on("change", "[name='bulkJobTimeBooked']", function (e) {
  $("#bulkJobTimeBooked").val("");
});
