$(document).on("change", "#getClient", function () {
  var dataToPost = {};
  //  $('#getClient').find(":selected").val();
  dataToPost.selectedValue = this.value;
  $("#hiddenCustomerID").html(this.value);

  $.ajax({
    url: "customers.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      $("#customerInfo").html(data);
      // var thisClientName = $('#hiddenCustomerName').text();
      // if (thisClientName=='DHD') {
      //     $('.dhd').show();
      // } else {
      //     $('.dhd').hide();
      // }

      // $('#brokerEditNumber').val ($('#brokerHiddenInfo').val());

      if ($("#DeviceStats").text() == "Total Devices:  0") {
        $("#addFootageRequest").prop("disabled", true);
      } else {
        $("#addFootageRequest").prop("disabled", false);
      }
    },
    error: function () {},
  });
});

$(document).on("keypress", "#VCOReference", function (e) {
  if (e.charCode == 32) {
    e.preventDefault();
  }
});

$(document).on("blur", "#VCOReference", function () {
  $("#VCOReference").val($("#VCOReference").val().replace(/\s/g, ""));
  $("#VCOReference").val($("#VCOReference").val().toUpperCase());
});

$("#modalAddNewCustomer").on("hidden.bs.modal", function (event) {
  $(this).find("form").trigger("reset");
  $("#customerMessage").html("");
});

function showCustomers(customer = 0) {
  var dataToPost = {};
  dataToPost.customerID = customer;
  $.ajax({
    url: "selectCustomer.php",
    data: dataToPost,
    timeout: 30000,
    type: "POST",
    success: function (data) {
      $("#accountInfo").html("");
      $("#fleetList").html("");
      $("#customerSelect").html(data);
      $("#getClient").trigger("change");
    },
    error: function () {},
  });
}

function addCustomer() {
  var dataToPost = {};
  dataToPost.customerName = document.querySelector("#newCustomerName").value;
  dataToPost.customerAddress1 =
    document.querySelector("#customerAddress1").value;
  dataToPost.customerAddress2 =
    document.querySelector("#customerAddress2").value;
  dataToPost.customerAddress3 =
    document.querySelector("#customerAddress3").value;
  dataToPost.customerAddress4 =
    document.querySelector("#customerAddress4").value;
  dataToPost.customerAddress5 =
    document.querySelector("#customerAddress5").value;
  dataToPost.customerTelephone = document.querySelector("#customerPhone").value;
  dataToPost.customerEmail = document.querySelector("#customerEmail").value;
  // dataToPost.customerCoRegNo = document.getElementById('customerRegNo').value;
  // dataToPost.customerVATRegNo = document.getElementById('customerVATNo').value;
  dataToPost.customerInsurerID = document.querySelector("#getInsurer").value;
  dataToPost.customerBrokerID = document.querySelector("#getBroker").value;

  $.ajax({
    url: "addNewCustomer.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        var newID = parseInt(data.replace("success", ""), 10);

        showCustomers(newID);
        $("#customerMessage").show();
        $("#getClient").trigger("change");
        $("#modalAddNewCustomer").modal("hide");
        $(".modal-backdrop").hide();

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
      } else {
        $("#customerMessage").html(data);
        $("#customerMessage").show();
      }
    },
    error: function () {},
  });
  // update add new job customer list modal
  $.ajax({
    url: "updateCustomerModalList.php",
    timeout: 30000,
    type: "POST",
    success: function (data) {
      $("#jobCustomerName").html(data);
    },
  });
}

function updateCustomerRenewal() {
  var dataToPost = {};
  dataToPost.customerRenewalType = document.getElementById(
    "getRenewalTypeSelect"
  ).value;
  dataToPost.customerRenewalDate = document.querySelector("#renewalDate").value;
  $.ajax({
    url: "updateCustomerRenewal.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function () {},
    error: function () {},
  });
}
function updateCustomer() {
  var dataToPost = {};
  dataToPost.customerName = document.querySelector("#customerName").value;
  dataToPost.customerAddr1 = document.querySelector("#custAddressLine1").value;
  dataToPost.customerAddr2 = document.querySelector("#custAddressLine2").value;
  dataToPost.customerAddr3 = document.querySelector("#custAddressLine3").value;
  dataToPost.customerAddr4 = document.querySelector("#custAddressLine4").value;
  dataToPost.customerAddr5 = document.querySelector("#custAddressLine5").value;
  dataToPost.VCOReference = document.querySelector("#VCOReference").value;
  dataToPost.policynumber = document.querySelector("#policyNumber").value;
  console.log(policynumber);
  // dataToPost.customerPhone = document.getElementById('custPhone').value;
  // dataToPost.customerEmail = document.getElementById('custEmail').value;
  // dataToPost.customerRenewalType = document.getElementById('getRenewalTypeSelect').value;
  // dataToPost.customerRenewalDate = document.getElementById('renewalDate').value;
  // // dataToPost.customerRegNo = document.getElementById('custRegNumber').value;
  // dataToPost.customerVATNo = document.getElementById('custVATNumber').value;

  $.ajax({
    url: "updateCustomerInfo.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        var customerNumber = parseInt(data.replace("success", ""), 10);

        $("#customerUpdateMessage").html(
          '<div class="alert alert-success">Updated successfully</div>'
        );
        $("#customerUpdateMessage").delay(3500).hide(0);
        $("#customerUpdateMessage").show();
        $(".enabler").css("border-color", "#CED4DA");
        $("#getClient").trigger("change");
        showCustomers(customerNumber);
      } else {
        console.log(data);
        $("#customerUpdateMessage").html(data);
        $("#customerUpdateMessage").show();
      }
      $("#getRenewalTypeSelect").trigger("change");
    },
    error: function () {},
  });
}

function deleteCustomer() {
  $.ajax({
    url: "deleteCustomer.php",
    timeout: 30000,
    type: "POST",
    success: function (data) {},
    error: function () {},
  });
}

// CUSTOMER CONTACT SCRIPTS
// Update new
$(document).on("click", "#updateCustomerContact", function (event) {
  // prevent default PHP processing
  "use strict";
  event.preventDefault();
  // collect user inputs
  var dataToPost = {};
  dataToPost.firstName = document.querySelector("#contactFirstName").value;
  dataToPost.lastName = document.querySelector("#contactLastName").value;
  dataToPost.mobileNumber = document.querySelector("#contactMobile").value;
  dataToPost.telephone = document.querySelector("#contactTelephone").value;
  dataToPost.email = document.querySelector("#contactEmail").value;
  dataToPost.jobTitle = document.querySelector("#contactJobTitle").value;
  dataToPost.footageRec = document.getElementById(
    "contactFootageRequest"
  ).checked;
  dataToPost.healthCheck = document.querySelector(
    "#contactHealthCheck"
  ).checked;
  dataToPost.reporting = document.querySelector("#contactReports").checked;

  $.ajax({
    url: "addCustomerContact.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      if (data.includes("success")) {
        $("#getClient").trigger("change");
        $("#modalAddNewContact").modal("hide");
      } else {
        $("#contactMessage").html(data);
      }
    },
    error: function () {
      $("#contactMessage").html(
        "<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>"
      );
    },
  });
});

// ADD CUSTOMER NOTE
$(document).on("click", "#updateCustomerNote", function (event) {
  // prevent default PHP processing
  "use strict";
  event.preventDefault();
  // collect user inputs
  var dataToPost = {};
  dataToPost.noteDate = document.querySelector("#noteDate").value;
  dataToPost.noteText = document.querySelector("#noteText").value;
  dataToPost.isImportant = document.querySelector("#isImportantNote").checked;
  dataToPost.isAlertable = document.querySelector("#createAlert").checked;

  $.ajax({
    url: "addCustomerNote.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      if (data.includes("success")) {
        $("#getClient").trigger("change");
        $("#modalAddNewNote").modal("hide");
        //update Alerts
        $.ajax({
          url: "getAlerts.php",
          type: "GET",
          success: function (data) {
            var arr = data.split("^^^");
            if (arr[0] + arr[1] != 0) {
              $("#renewalTotal").html(+arr[0] + +arr[1]);
              $("#renewalTotalWrapper").show();
            } else {
              $("#renewalTotalWrapper").hide();
            }
            if (arr[3] != 0) {
              $("#installTotal").html(arr[3]);
              $("#installTotalWrapper").show();
            } else {
              $("#installTotalWrapper").hide();
            }
            if (arr[2] != 0) {
              $("#alertTotal").html(arr[2]);
              $("#alertTotalWrapper").show();
            } else {
              $("#alertTotalWrapper").hide();
            }
          },
        });
      } else {
        $("#noteMessage").html(data);
      }
    },
    error: function () {
      $("#contactMessage").html(
        "<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>"
      );
      $("#contactMessage").html(
        "<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>"
      );
    },
  });
});

function updateCustomerContact() {
  var dataToPost = {};
  dataToPost.contactFirstName = document.getElementById(
    "editContactFirstName"
  ).value;
  dataToPost.contactLastName = document.getElementById(
    "editContactLastName"
  ).value;
  dataToPost.contactMobile = document.querySelector("#editContactMobile").value;
  dataToPost.contactTelephone = document.getElementById(
    "editContactTelephone"
  ).value;
  dataToPost.contactEmail = document.querySelector("#editContactEmail").value;
  dataToPost.contactJobTitle = document.getElementById(
    "editContactJobTitle"
  ).value;
  dataToPost.contactFootageRecipient = document.getElementById(
    "editContactFootageRequest"
  ).checked;
  dataToPost.contactHealthCheck = document.getElementById(
    "editContactHealthCheck"
  ).checked;
  dataToPost.contactReporting = document.querySelector(
    "#editContactReports"
  ).checked;

  dataToPost.customerNumber = document.getElementById(
    "customerContactEditNumber"
  ).value;
  dataToPost.contactNumber = document.querySelector("#contactEditNumber").value;

  $.ajax({
    url: "updateCustomerContact.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        $("#editContactMessage").html("");
        $("#getClient").trigger("change");
        $("#modalEditContact").modal("hide");
      } else {
        $("#editContactMessage").html(data);
      }
    },
    error: function () {},
  });
}

function deleteCustomerContact() {
  var dataToPost = {};
  dataToPost.contactFirstName = document.getElementById(
    "editContactFirstName"
  ).value;
  dataToPost.contactLastName = document.getElementById(
    "editContactLastName"
  ).value;
  dataToPost.contactNumber = document.querySelector("#contactEditNumber").value;

  // var proceed = confirm(`Are you sure you want to delete the contact ${dataToPost.contactFirstName} ${dataToPost.contactLastName}?  This cannot be undone once you click OK`);
  new swal({
    text: "Are you sure you want to delete this contact?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "No Don't",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "deleteCustomerContact.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#editContactMessage").html("");
            $("#getClient").trigger("change");
            $("#modalEditContact").modal("hide");
          } else {
            $("#editContactMessage").html(data);
          }
        },
        error: function () {},
      });
    }
  });
}

$(document).on("change", "#selectCustomer", function () {
  var dataToPost = {};
  dataToPost.selectedCustomer = this.value;

  $.ajax({
    url: "customerSelectSimple.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      $("#optionalVRN").html(data);
    },
  });
});

function allocateDeviceToCustomer() {
  var dataToPost = {};
  dataToPost.allocateCustomer = document.querySelector("#selectCustomer").value;
  dataToPost.allocateVRN = document.querySelector("#selectVRN").value;
  dataToPost.allocateDevice =
    document.querySelector("#hiddenAllocateID").innerHTML;
  dataToPost.allocateDevice = dataToPost.allocateDevice.replace("DHI", "");

  $.ajax({
    url: "allocateDeviceToCustomer.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        $("#modalGetCustomerAndVRN").modal("hide");
        $("#getClient").trigger("change");
      } else {
        // swal ("Error", data, "warning");
      }
    },
  });
}

$(document).on("click", "#goToDHInstall", function () {
  // find ID of DHInstall
  // Select customer
  $.ajax({
    url: "getDHInstallID.php",
    timeout: 30000,
    success: function (data) {
      var dataToPost = {};
      dataToPost.customerID = data;
      $.ajax({
        url: "selectCustomer.php",
        data: dataToPost,
        timeout: 30000,
        type: "POST",
        success: function (data) {
          $("#accountInfo").html("");
          $("#customerSelect").html(data);
          $("#getClient").trigger("change");
        },
        error: function () {},
      });
    },
  });
});

$(document).on("click", "#addToDHInstall", function () {
  $("#modalAddNewDevice").modal("show");
  document.querySelector("#addOwnerID").value = "DHInstall";
  $("#addOwnerID").val("DHINSTALL");
});

$(document).on("click", "#goToDHD", function () {
  // find ID of DHD
  // Select customer
  $.ajax({
    url: "getDHDID.php",
    timeout: 30000,
    success: function (data) {
      var dataToPost = {};
      dataToPost.customerID = data;
      $.ajax({
        url: "selectCustomer.php",
        data: dataToPost,
        timeout: 30000,
        type: "POST",
        success: function (data) {
          $("#accountInfo").html("");
          $("#customerSelect").html(data);
          $("#getClient").trigger("change");
        },
        error: function () {},
      });
    },
  });
});

$(document).on("click", "#addToDHD", function () {
  $("#modalAddNewDevice").modal("show");
  document.querySelector("#addOwnerID").value = "DHD";
  $("#addOwnerID").val("DHD");
});
