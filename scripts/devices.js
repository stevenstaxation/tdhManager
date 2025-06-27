function showFullDevice(rowNumber) {
  // get device data using AJAX call
  // fill in modal dialog
  // update SQL

  if (rowNumber.includes("customer")) {
    document.querySelector("#hiddenDeviceSelector").value = "customer";
    rowNumber = rowNumber.replace("customer", "");
  } else if (rowNumber.includes("device")) {
    document.querySelector("#hiddenDeviceSelector").value = "device";
    rowNumber = rowNumber.replace("device", "");
  } else if (rowNumber.includes("DHI")) {
    document.querySelector("#hiddenDeviceSelector").value = "DHI";
    rowNumber = rowNumber.replace("DHI", "");
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

      if ($("#editTDHNumber").length > 0) {
        document.querySelector("#editTDHNumber").value = data["TDHNumber"];
      }
      document.querySelector("#editSerial").value = data["serialNumber"];
      document.querySelector("#editIMEI").value = data["IMEI"];
      document.querySelector("#editDRIDNumber").value = data["DRIDNumber"];
      document.querySelector("#editSIMNumber").value = data["SIMNumber"];
      document.querySelector("#editSIMPhone").value = data["SIMPhone"];
      document.querySelector("#editSIMStatus").value = data["SIMStatus"];

      document.querySelector("#editConfigFile").value = data["config"];
      // document.getElementById('editDeviceInstallReference').value = data['assocOrderNumber'];
      // document.getElementById('editDeviceSupplierInvoice').value = data['supplierInvoice'];
      document.querySelector("#editSIMScheduleDate").value =
        data["scheduledDate"];
      if (data["VCOReference"] != null) {
        document.getElementById(
          "labelVCOReference"
        ).innerHTML = `<strong>VCO Reference: ${data["VCOReference"]}</strong>`;
      } else {
        document.querySelector("#labelVCOReference").innerHTML =
          "<strong>VCO Reference: none</strong>";
      }
      document.querySelector("#editSIMSuspensionDate").value =
        data["SIMDeactivationDate"];
      document.querySelector("#editDeviceInstallDate").value =
        data["installDate"];
      document.querySelector("#editDeviceNoteText").value = data["deviceNote"];
      document.querySelector("#editDeviceInstaller").value =
        data["installerID"];
      document.querySelector("#editDeviceSupplier").value = data["supplierID"];
      document.querySelector("#editDeviceDescription").value =
        data["deviceDescriptionID"];
      document.querySelector("#editDeviceStatus").value = data["status"];
      document.querySelector("#editVRN").value = data["regNumber"];
      // document.getElementById('editVehicleDescription').value = data['make'] + data['model'] + data['addDescription'];
      document.querySelector("#editOwnerID").value = data["ID"];
      document.querySelector("#editDevicePurchaseDate").value =
        data["purchaseDate"];
      document.querySelector("#editDeviceBuyer").value = data["buyer"];
      document.querySelector("#hiddenDeviceID").value = rowNumber;

      vco = document.querySelector("#vcoUpdated");
      platform = document.querySelector("#platformUpdated");
      config = document.querySelector("#configUpdated");

      if (data["vcoUpdated"] == 1) {
        vco.checked = true;
      } else {
        vco.checked = false;
      }
      if (data["configUpdated"] == 1) {
        config.checked = true;
      } else {
        config.checked = false;
      }
      if (data["platformUpdated"] == 1) {
        platform.checked = true;
      } else {
        platform.checked = false;
      }

      $("#modalEditDevice").modal("show");
    },
    error: function () {},
  });
}

function addNewDevice() {
  var dataToPost = {};
  dataToPost.deviceID = document.querySelector("#addDeviceDescription").value;
  dataToPost.TDHNumber = document.querySelector("#addTDHNumber").value;
  dataToPost.serialNumber = document.querySelector("#addSerial").value;
  dataToPost.IMEI = document.querySelector("#addIMEI").value;
  dataToPost.DRID = document.querySelector("#addDRIDNumber").value;
  dataToPost.SIMNumber = document.querySelector("#addSIMNumber").value;
  dataToPost.SIMPhone = document.querySelector("#addSIMPhone").value;
  dataToPost.SIMStatus = document.querySelector("#addSIMStatus").value;
  dataToPost.SIMDeactDate = document.querySelector("#addSIMDate").value;
  dataToPost.ownerID = document.querySelector("#addOwnerID").value;
  dataToPost.VRN = document.querySelector("#addVRN").value;
  dataToPost.configFile = document.querySelector("#addConfigFile").value;
  dataToPost.currentStatus = document.querySelector("#addDeviceStatus").value;
  dataToPost.installerID = document.querySelector("#addDeviceInstaller").value;
  dataToPost.installDate = document.getElementById(
    "addDeviceInstallDate"
  ).value;
  // dataToPost.installerRef = document.getElementById('addDeviceInstallReference').value;
  dataToPost.supplierID = document.getElementById(
    "addDeviceSupplierList"
  ).value;
  dataToPost.buyerID = document.querySelector("#addDeviceBuyer").value;
  dataToPost.purchaseDate = document.getElementById(
    "addDevicePurchaseDate"
  ).value;
  dataToPost.notesText = document.querySelector("#addDeviceNoteText").value;

  $.ajax({
    url: "addNewDevice.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        var newID = parseInt(data.replace("success", ""), 10);
        $("#getClient").trigger("change");
        showCustomers(newID);
        $("#modalAddNewDevice").modal("hide");

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
        $("#addDeviceMessage").html(data);
        $("#addDeviceMessage").show();
      }
    },
    error: function () {},
  });
}

function editCurrentDevice() {
  var dataToPost = {};
  dataToPost.deviceID = document.querySelector("#hiddenDeviceID").value;
  dataToPost.ownerID = document.querySelector("#editOwnerID").value;
  dataToPost.deviceDescriptionID = document.getElementById(
    "editDeviceDescription"
  ).value;
  dataToPost.TDHNumber = document.querySelector("#editTDHNumber").value;
  dataToPost.serialNumber = document.querySelector("#editSerial").value;
  dataToPost.IMEI = document.querySelector("#editIMEI").value;
  dataToPost.DRIDNumber = document.querySelector("#editDRIDNumber").value;
  dataToPost.SIMNumber = document.querySelector("#editSIMNumber").value;
  dataToPost.SIMPhone = document.querySelector("#editSIMPhone").value;
  dataToPost.SIMStatus = document.querySelector("#editSIMStatus").value;
  dataToPost.SIMScheduleDate = document.getElementById(
    "editSIMScheduleDate"
  ).value;
  dataToPost.SIMDeactivationDate = document.getElementById(
    "editSIMSuspensionDate"
  ).value;
  dataToPost.config = document.querySelector("#editConfigFile").value;
  dataToPost.regNumber = document.querySelector("#editVRN").value;
  dataToPost.status = document.querySelector("#editDeviceStatus").value;
  dataToPost.installerID = document.querySelector("#editDeviceInstaller").value;
  dataToPost.installDate = document.getElementById(
    "editDeviceInstallDate"
  ).value;
  // dataToPost.assocOrderNumber = document.getElementById('editDeviceInstallReference').value;
  dataToPost.supplierID = document.querySelector("#editDeviceSupplier").value;
  // dataToPost.supplierInvoice = document.getElementById('editDeviceSupplierInvoice').value;
  dataToPost.purchaseDate = document.getElementById(
    "editDevicePurchaseDate"
  ).value;
  dataToPost.buyer = document.querySelector("#editDeviceBuyer").value;
  dataToPost.deviceNote = document.querySelector("#editDeviceNoteText").value;
  dataToPost.vcoUpdated = $("#vcoUpdated").is(":checked");
  dataToPost.configUpdated = $("#configUpdated").is(":checked");
  dataToPost.platformUpdated = $("#platformUpdated").is(":checked");

  $.ajax({
    url: "updateEditDevice.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        $("#editDeviceMessage").html("");
        $("#getClient").trigger("change");
        $("#modalEditDevice").modal("hide");
        if (document.querySelector("#hiddenDeviceSelector").value == "device") {
          $("#showDeviceList").trigger("click");
        }
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
        $("#editDeviceMessage").html(data);
      }
    },
    error: function () {},
  });
}

function showDeviceEvents(rowNumber) {
  if (rowNumber.includes("customer")) {
    // document.querySelector("#hiddenDeviceNotesSelector").value = "customer";
    rowNumber = rowNumber.replace("customer", "");
  } else if (rowNumber.includes("device")) {
    // document.querySelector("#hiddenDeviceNotesSelector").value = "device";
    rowNumber = rowNumber.replace("device", "");
  } else if (rowNumber.includes("DHI")) {
    // document.querySelector("#hiddenDeviceNotesSelector").value = "DHI";
    rowNumber = rowNumber.replace("DHI", "");
  }
  // need to get IMEI for device
  var dataToPost = {};
  dataToPost.deviceID = rowNumber;
  $.ajax({
    url: "getIMEI.php",
    timeout: 30000,
    data: dataToPost,
    datatype: "json",
    type: "POST",
    success: async function (data) {
      const imei = $.parseJSON(data).imei;
      $("#events31Modal").html(
        `Events in the last 31 days for ${$.parseJSON(data).regNumber}`
      );
      
      let toEvents = new Date();
      let fromEvents = new Date();
      fromEvents.setDate(toEvents.getDate() - 31);
      fromEvents = fromEvents.toISOString();
      toEvents = toEvents.toISOString();
      let lastEvents = await getEventList(
        imei,
        fromEvents,
        toEvents
        // numEvents
      );

      lastEvents = JSON.parse(lastEvents);
      document.querySelector("#eventListBody").innerHTML = "";
      Object.entries(lastEvents.data).forEach((entry) => {
        const [key, value] = entry;
        let eventArray = {};
        eventArray.date = `${value["time"].substring(8, 10)}/${value[
          "time"
        ].substring(5, 7)}/${value["time"].substring(0, 4)}`;
        eventArray.time = value["time"].substring(11, 19);

        if (value["eventType"] == "button") {
          eventArray.event = "<div class='btn btn-danger btn-sm'>Button</div>";
        } else if (value["eventType"] == "accOn") {
          eventArray.event =
            "<div class='btn btn-success btn-sm'>Power On</div>";
        } else if (value["eventType"] == "accOff") {
          eventArray.event =
            "<div class='btn btn-warning btn-sm'>Power Off</div>";
        }

        eventArray.severity = value["severity"];

        const eventLocation = getAddressByCoords(
          value["lat"],
          value["lon"],
          eventArray
        )
          .then((result) => {
            document
              .querySelector("#eventListBody")
              .insertAdjacentHTML(
                "beforeend",
                `<tr><td>${result.date}</td><td>${result.time}</td><td>${result.event}</td><td>${result.location}</td><td>${result.severity}</td></tr>`
              );
          })
          .catch((error) => {
           
          });
      });

      $("#modalDeviceEvents").modal("show");
    },
    error: function () {},
  });
}

function showDeviceNotes(rowNumber) {
  if (rowNumber.includes("customer")) {
    document.querySelector("#hiddenDeviceNotesSelector").value = "customer";
    rowNumber = rowNumber.replace("customer", "");
  } else if (rowNumber.includes("device")) {
    document.querySelector("#hiddenDeviceNotesSelector").value = "device";
    rowNumber = rowNumber.replace("device", "");
  } else if (rowNumber.includes("DHI")) {
    document.querySelector("#hiddenDeviceNotesSelector").value = "DHI";
    rowNumber = rowNumber.replace("DHI", "");
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
      document.querySelector("#editDeviceNotesText").value = data["deviceNote"];
      document.querySelector("#hiddenDeviceNotesID").value = rowNumber;
      $("#modalEditDeviceNotes").modal("show");
    },
    error: function () {},
  });
}

function editCurrentDeviceNotes() {
  var dataToPost = {};
  dataToPost.deviceID = document.querySelector("#hiddenDeviceNotesID").value;
  dataToPost.deviceNote = document.querySelector("#editDeviceNotesText").value;

  $.ajax({
    url: "updateEditDeviceNotes.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        $("#editDeviceNotesMessage").html("");
        $("#modalEditDeviceNotes").modal("hide");

        if (
          document.querySelector("#hiddenDeviceNotesSelector").value == "device"
        ) {
          $("#showDeviceList").trigger("click");
        } else {
          $("#getClient").trigger("click");
        }
      } else {
        $("#editDeviceMessage").html(data);
      }
    },
    error: function () {},
  });
}

function deletePhysicalDevice() {
  var dataToPost = {};
  // var e = document.getElementById('editDeviceDescription');
  // if (e.selectedIndex==-1) {
  //     return;
  // }
  dataToPost.deviceNumber = document.querySelector("#hiddenDeviceID").value;

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "deletePhysicalDevice.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#editDeviceMessage").html("");
            $("#modalEditDevice").modal("hide");
            if (
              document.querySelector("#hiddenDeviceSelector").value == "device"
            ) {
              $("#showDeviceList").trigger("click");
            } else {
              $("#getClient").trigger("change");
              var newID = parseInt(data.replace("success", ""), 10);
              showCustomers(newID);
            }
          } else {
            $("#editDeviceMessage").html(data);
          }
        },
      });
    }
  });

  return;
}

$(document).on("change", "#editOwnerID", function () {
  var dataToPost = {};
  dataToPost.ownerID = $("#editOwnerID").val();
  $.ajax({
    url: "getVCOReference.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      $("#labelVCOReference").html(`<strong>VCO Reference: ${data}</strong>`);
    },
  });
});

$(document).on("click", "#deviceFilterClicked", function (event) {
  "use strict";
  event.preventDefault();
  var dataToPost = {};
  dataToPost.FilterCustomer =
    document.querySelector("#getCustomerSelect").value;
  dataToPost.FilterType = document.querySelector("#byDeviceType").value;
  dataToPost.FilterOtherTerm = document.querySelector("#byOther").value;
  dataToPost.SQLFilter = "";

  $.ajax({
    url: "filterDevices.php",
    data: dataToPost,
    type: "POST",
    success: function (data) {
      dataToPost.SQLFilter = data;
      $.ajax({
        url: "deviceList.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
          $("#devicesList").html(data);
        },
        error: function () {
          $("#errorBox").html(
            "<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>"
          );
        },
      });
    },
    error: function () {},
  });
});

$(document).on("click", "#platformList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.querySelector("#textAddOrUpdatePlatform").value =
      event.target.innerText;
    $("#addOrUpdatePlatform").text("Update");
    document.querySelector("#addOrUpdatePlatform").disabled = false;
    document.querySelector("#deletePlatform").disabled = false;
    document.querySelector("#cancelUpdatePlatform").style.display = "block";
    document.querySelector("#cancelUpdatePlatform").disabled = false;
  }
});

$(document).on("click", "#deviceList", function (event) {
  event.preventDefault();
  if (!event.target.options) {
    document.querySelector("#textAddOrUpdateDevice").value =
      event.target.innerText;
    $("#addOrUpdateDevice").text("Update");
    document.querySelector("#addOrUpdateDevice").disabled = false;
    document.querySelector("#deleteDevice").disabled = false;
    document.querySelector("#cancelUpdateDevice").style.display = "block";
    document.querySelector("#cancelUpdateDevice").disabled = false;
  }
});

$(document).on("show.bs.modal", "#modalAddNewDevice", function (event) {
  $(this).find("form").trigger("reset");
  $("#addDeviceMessage").html("");
});

$(document).on("show.bs.modal", "#modalEditDevice", function (event) {
  //     // $(this).find('form').trigger('reset');
  $("#editDeviceMessage").html("");
});

function allocateDevice(deviceToAllocate) {
  $("#modalGetCustomerAndVRN").modal("show");
  document.querySelector("#hiddenAllocateID").innerHTML = deviceToAllocate;
}

$(document).on("click", "#editSIMScheduleDate", function () {
  if (document.querySelector("#editSIMScheduleDate").valueAsDate == null) {
    var schDate = new Date();
    schDate.setDate(schDate.getDate() + 31);
    document.querySelector("#editSIMScheduleDate").valueAsDate = schDate;
  }
});

$(document).on("click", "#editSIMSuspensionDate", function () {
  if (document.querySelector("#editSIMSuspensionDate").valueAsDate == null) {
    var schDate = new Date();
    schDate.setDate(schDate.getDate());
    document.querySelector("#editSIMSuspensionDate").valueAsDate = schDate;
  }
});

$(document).on("click", "#editDeviceInstallDate", function () {
  if (document.querySelector("#editDeviceInstallDate").valueAsDate == null) {
    var schDate = new Date();
    schDate.setDate(schDate.getDate());
    document.querySelector("#editDeviceInstallDate").valueAsDate = schDate;
  }
});
