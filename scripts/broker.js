/**
 * Add a new broker to database
 * @returns success or failure message in #brokerMessage element
 *
 */
function addNewBroker() {
  /**
   * Get the Broker name and address from the Add New Broker modal dialog
   */
  var dataToPost = {};
  dataToPost.BrokerName = document.querySelector("#addBrokerName").value;
  dataToPost.BrokerAddress1 =
    document.querySelector("#addBrokerAddress1").value;
  dataToPost.BrokerAddress2 =
    document.querySelector("#addBrokerAddress2").value;
  dataToPost.BrokerAddress3 =
    document.querySelector("#addBrokerAddress3").value;
  dataToPost.BrokerAddress4 =
    document.querySelector("#addBrokerAddress4").value;
  dataToPost.BrokerAddress5 =
    document.querySelector("#addBrokerAddress5").value;
  /**
   * addNewBroker.php checks broker name is included and postcode is valid
   * and then adds the broker to the tblBroker table
   */
  $.ajax({
    url: "addNewBroker.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      if (data.includes("success")) {
        /**
         * If successful update and, if called from Customer screen refresh
         * Customer record; if called from Admin>Partners>Broker menu refresh
         * the broker list
         */
        var getIDs = data.replace("success", "");
        var getID = getIDs.split("/");
        var newID = getID[0];
        var newBrokerID = getID[1];

        $("#brokerMessage").show();

        if ($("#addBrokerCaller").val() == "customer") {
          $("#getClient").trigger("change");
          showCustomers(newID);
          $("#modalAddNewBroker").modal("hide");
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
          $.ajax({
            url: "brokerList.php",
            type: "POST",
            success: function (data) {
              $("#devicesList").html(data);
              $("#modalAddNewBroker").modal("hide");
              $("#brokerNameSelection").val(newBrokerID);
              $("#brokerNameSelection").trigger("change");
            },
            error: function () {},
          });
        }
      } else {
        /**
         * If call to addNewBroker is not successful then return
         * an error message
         */
        $("#brokerMessage").html(data);
        $("#brokerMessage").show();
      }
    },
    error: function (errorObj) {
      console.log(errorObj);
    },
  });
}

/**
 * Update broker in database after editing
 * @returns success or failure message in #editBrokerMessage element
 */
function updateEditBroker() {
  // Get name and address values from Modal dialog
  var dataToPost = {};
  dataToPost.brokerName = document.querySelector("#editBrokerName").value;
  dataToPost.brokerAddress1 = document.querySelector(
    "#editBrokerAddress1"
  ).value;
  dataToPost.brokerAddress2 = document.querySelector(
    "#editBrokerAddress2"
  ).value;
  dataToPost.brokerAddress3 = document.querySelector(
    "#editBrokerAddress3"
  ).value;
  dataToPost.brokerAddress4 = document.querySelector(
    "#editBrokerAddress4"
  ).value;
  dataToPost.brokerAddress5 = document.querySelector(
    "#editBrokerAddress5"
  ).value;
  dataToPost.brokerID = document.querySelector("#editBrokerHide").value;
  if (!dataToPost.brokerID) {
    return;
  }
  // Update broker record in database
  $.ajax({
    url: "updateBroker.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      $("#editBrokerMessage").css("display", "block");

      if (data.includes("success")) {
        $("#editBrokerMessage").html("");
        $("#getClient").trigger("change");
        $("#brokerNameSelection").trigger("change");
        $("#editBrokerMessage").html(
          "<div class='alert alert-success'>Updated successfully</div>"
        );
        $("#editBrokerMessage").delay(3000).hide(0);
      } else {
        $("#editBrokerMessage").html(data);
        $("#editBrokerMessage").delay(3000).hide(0);
      }
    },
    error: function () {},
  });
}

/**
 * Populate edit broker modal dialog from database.
 * Triggered when the blue 'More' button in the Broker
 * section of the Customer screen.
 *
 * @returns An array with selected broker details which
 * is used to populate Broker Modal dialog
 */

function editBroker() {
  var dataToPost = {};
  var e = document.querySelector("#getBrokerSelect");
  dataToPost.brokerNumber = e.options[e.selectedIndex].value;
  if (dataToPost.brokerNumber == 0) {
    return;
  }

  $.ajax({
    url: "editBroker.php",
    timeout: 30000,
    data: dataToPost,
    type: "POST",
    success: function (data) {
      data = $.parseJSON(data);
      document.querySelector("#editBrokerName").value = data["brokerName"];
      document.querySelector("#editBrokerAddress1").value =
        data["addressLine1"];
      document.querySelector("#editBrokerAddress2").value =
        data["addressLine2"];
      document.querySelector("#editBrokerAddress3").value =
        data["addressLine3"];
      document.querySelector("#editBrokerAddress4").value =
        data["addressLine4"];
      document.querySelector("#editBrokerAddress5").value =
        data["addressLine5"];
      document.querySelector("#editBrokerHide").value = data["ID"];
      $("#modalEditBroker").modal("show");
    },
    error: function () {},
  });
}

/**
 * Delete broker from database
 *
 * @returns Delete broker from database when delete is requested.
 * If broker is assigned to any devices, do not allow deletion
 */
function deleteBroker() {
  var dataToPost = {};
  var e = document.querySelector("#brokerNameSelection");
  if (e.selectedIndex == -1) {
    return;
  }

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      dataToPost.brokerNumber = e.options[e.selectedIndex].value;
      $.ajax({
        url: "checkBrokerDeletion.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("deleted")) {
            $("#currentBrokerMessageBox").html(data);

            $.ajax({
              url: "brokerList.php",
              type: "POST",
              success: function (data) {
                setTimeout(function () {
                  $("#devicesList").html(data);
                  $("#brokerNameSelection option:first").attr(
                    "selected",
                    "selected"
                  );
                  $("#brokerNameSelection").trigger("change");
                }, 3000);
              },
              error: function () {},
            });
          } else {
            $("#currentBrokerMessageBox").html(data);
          }
        },
        error: function () {},
      });
    }
  });
}

/**
 * @param {jquery}
 * Event handler fires when Add New Broker dialog is shown
 * Function: Stores the callerID in #addBrokerCaller then
 * resets all form fields before showing the dialog.
 */
$(document).on("show.bs.modal", "#modalAddNewBroker", function (event) {
  var callerID = $(event.relatedTarget).data("caller");
  $("#addBrokerCaller").val(callerID);
  $(this).find("form").trigger("reset");
});

/**
 * @param {jquery}
 * Populate broker details on change of selected broker
 * on Partners >> Brokers page.
 */
$(document).on("change", "#brokerNameSelection", function (event) {
  var dataToPost = {};
  var e = document.querySelector("#brokerNameSelection");

  if (e.selectedIndex != -1) {
    dataToPost.brokerNumber = e.options[e.selectedIndex].value;
    document.querySelector("#editBrokerHide").value = dataToPost.brokerNumber;
    document.querySelector("#brokerEditNumberC").innerHTML =
      dataToPost.brokerNumber;

    $("#btnAddNewBroker").show();
    $.ajax({
      url: "getBrokerDetails.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        data = $.parseJSON(data);
        document.querySelector("#editBrokerName").value = data["brokerName"];
        document.querySelector("#editBrokerAddress1").value =
          data["brokerAddress1"];
        document.querySelector("#editBrokerAddress2").value =
          data["brokerAddress2"];
        document.querySelector("#editBrokerAddress3").value =
          data["brokerAddress3"];
        document.querySelector("#editBrokerAddress4").value =
          data["brokerAddress4"];
        document.querySelector("#editBrokerAddress5").value =
          data["brokerAddress5"];
        document.querySelector("#brokerEditNumberC").value = data["ID"];
        $("#brokerContactListHolder").html(data["brokerContactTable"]);
      },
      error: function () {},
    });
  } else {
    $("#btnAddNewBroker").hide();
  }
});

/**
 * @param {jquery}
 * Delete broker after checking the broker is not assigned
 * to any customers
 */
$(document).on("click", "#queryDeleteBroker", function () {
  var queryDelete = document.querySelector("#goAheadDeleteBroker").checked;
  if (queryDelete == false) {
    $("#currentBrokerMessageBox").html("");
  } else {
    var dataToPost = {};
    dataToPost.brokerID = $("#hiddenIDToDelete").text();
    $.ajax({
      url: "deleteBroker.php",
      data: dataToPost,
      type: "POST",
      timeout: 30000,
      success: function (data) {
        if (data.includes("success")) {
          $("#currentBrokerMessageBox").html(
            "<div class='alert alert-success'>Broker deleted successfully</div>"
          );

          $.ajax({
            url: "brokerList.php",
            type: "POST",
            success: function (data) {
              setTimeout(function () {
                $("#devicesList").html(data);
                $("#brokerNameSelection option:first").attr(
                  "selected",
                  "selected"
                );
                $("#brokerNameSelection").trigger("change");
              }, 3000);
            },
            error: function () {},
          });
        } else {
          $("#currentBrokerMessageBox").html(data);
          $("#currentBrokerMessageBox").delay(3000).hide(0);
        }
      },
      error: function () {},
    });
  }
});

/**
 * @param {jquery}
 * Select broker for viewing
 */
$("body").on("change", "#getBrokerSelect", function () {
  var dataToPost = {};
  dataToPost.brokerID = this.value;
  $("#brokerEditNumber").val(this.value);
  $("#brokerEditNumberC").val(this.value);
  $.ajax({
    url: "updateBrokerSelect.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {},
  });

  $("#getClient").trigger("change");
});
