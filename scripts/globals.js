$(document).on("focusin", "#textAddOrUpdateDevice", function (event) {
  event.preventDefault();
  document.querySelector("#addOrUpdateDevice").disabled = false;
  $("#deviceErrorBox").html("");
});

$(document).on("focusin", "#textAddOrUpdateStatus", function (event) {
  event.preventDefault();
  document.querySelector("#addOrUpdateStatus").disabled = false;
  $("#statusErrorBox").html("");
});

$(document).on("focusin", "#textAddOrUpdateSIMStatus", function (event) {
  event.preventDefault();
  document.querySelector("#addOrUpdateSIMStatus").disabled = false;
  $("#SIMStatusErrorBox").html("");
});

$(document).on("focusin", "#textAddOrUpdateFootageStatus", function (event) {
  event.preventDefault();
  document.querySelector("#addOrUpdateFootageStatus").disabled = false;
  $("#footageStatusErrorBox").html("");
});
$(document).on("focusin", "#textAddOrUpdateRenewalType", function (event) {
  event.preventDefault();
  document.querySelector("#addOrUpdateRenewalType").disabled = false;
  $("#renewalTypeErrorBox").html("");
});
$(document).on("focusin", "#textAddOrUpdateJobType", function (event) {
  event.preventDefault();
  document.querySelector("#addOrUpdateJobType").disabled = false;
  $("#jobTypeErrorBox").html("");
});
$(document).on("focusin", "#textAddOrUpdateHealthcheckType", function (event) {
  event.preventDefault();
  document.querySelector("#addOrUpdateHealthcheckType").disabled = false;
  $("#healthcheckTypeErrorBox").html("");
});
$(document).on("focusin", "#textAddOrUpdatePlatform", function (event) {
  event.preventDefault();
  document.querySelector("#addOrUpdatePlatform").disabled = false;
  $("#platformErrorBox").html("");
});

$(document).on("click", "#cancelUpdateDevice", function (event) {
  event.preventDefault();
  $("#showGlobalSettings").trigger("click");
});

$(document).on("click", "#cancelUpdateStatus", function (event) {
  event.preventDefault();
  $("#showGlobalSettings").trigger("click");
});

$(document).on("click", "#cancelUpdateSIMStatus", function (event) {
  event.preventDefault();
  $("#showGlobalSettings").trigger("click");
});

$(document).on("click", "#cancelUpdateFootageStatus", function (event) {
  event.preventDefault();
  $("#showGlobalSettings").trigger("click");
});

$(document).on("click", "#cancelUpdateRenewalType", function (event) {
  event.preventDefault();
  $("#showGlobalSettings").trigger("click");
});
$(document).on("click", "#cancelUpdateJobType", function (event) {
  event.preventDefault();
  $("#showGlobalSettings").trigger("click");
});
$(document).on("click", "#cancelUpdateHealthcheckType", function (event) {
  event.preventDefault();
  $("#showGlobalSettings").trigger("click");
});

$(document).on("click", "#deleteDevice", function (event) {
  event.preventDefault();

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      var dataToPost = {};
      dataToPost.deviceIDToDelete = $("#deviceList option:selected").val();

      $.ajax({
        url: "deleteDevice.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#showGlobalSettings").trigger("click");
            $("#addOrUpdateDevice").text("Add");
          } else {
            $("#deviceErrorBox").html(data);
            setTimeout(function () {
              $("#deviceErrorBox").html("");
            }, 3000);
          }
        },
        error: function () {},
      });
    }
  });
});

$(document).on("click", "#deleteStatus", function (event) {
  event.preventDefault();

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      var dataToPost = {};
      dataToPost.statusIDToDelete = $("#statusList option:selected").val();

      $.ajax({
        url: "deleteStatus.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#showGlobalSettings").trigger("click");
            $("#addOrUpdateStatus").text("Add");
          } else {
            $("#statusErrorBox").html(data);
            setTimeout(function () {
              $("#statusErrorBox").html("");
            }, 3000);
          }
        },
        error: function () {},
      });
    }
  });
});

$(document).on("click", "#deleteSIMStatus", function (event) {
  event.preventDefault();

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      var dataToPost = {};
      dataToPost.SIMStatusIDToDelete = $(
        "#SIMStatusList option:selected"
      ).val();

      $.ajax({
        url: "deleteSIMStatus.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#showGlobalSettings").trigger("click");
            $("#addOrUpdateSIMStatus").text("Add");
          } else {
            $("#SIMStatusErrorBox").html(data);
            setTimeout(function () {
              $("#SIMStatusErrorBox").html("");
            }, 3000);
          }
        },
        error: function () {},
      });
    }
  });
});

$(document).on("click", "#deleteFootageStatus", function (event) {
  event.preventDefault();

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      var dataToPost = {};
      dataToPost.FootageStatusIDToDelete = $(
        "#footageStatusList option:selected"
      ).val();

      $.ajax({
        url: "deleteFootageStatus.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#showGlobalSettings").trigger("click");
            $("#addOrUpdateFootageStatus").text("Add");
          } else {
            $("#footageStatusErrorBox").html(data);
            setTimeout(function () {
              $("#footageStatusErrorBox").html("");
            }, 3000);
          }
        },
        error: function () {},
      });
    }
  });
});

$(document).on("click", "#deleteRenewalType", function (event) {
  event.preventDefault();

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      var dataToPost = {};
      dataToPost.RenewalTypeIDToDelete = $(
        "#renewalTypeList option:selected"
      ).val();

      $.ajax({
        url: "deleteRenewalType.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#showGlobalSettings").trigger("click");
            $("#addOrUpdateRenewalType").text("Add");
          } else {
            $("#renewalTypeErrorBox").html(data);
            setTimeout(function () {
              $("#renewalTypeErrorBox").html("");
            }, 3000);
          }
        },
        error: function () {},
      });
    }
  });
});

$(document).on("click", "#deleteJobType", function (event) {
  event.preventDefault();

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      var dataToPost = {};
      dataToPost.JobTypeIDToDelete = $("#jobTypeList option:selected").val();

      $.ajax({
        url: "../php/jobs/deleteJobType.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#showGlobalSettings").trigger("click");
            $("#addOrUpdateJobType").text("Add");
          } else {
            $("#jobTypeErrorBox").html(data);
            setTimeout(function () {
              $("#jobTypeErrorBox").html("");
            }, 3000);
          }
        },
        error: function () {},
      });
    }
  });
});

$(document).on("click", "#deleteHealthcheckType", function (event) {
  event.preventDefault();

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      var dataToPost = {};
      dataToPost.HealthcheckTypeIDToDelete = $(
        "#healthStatusList option:selected"
      ).val();

      $.ajax({
        url: "deleteHealthcheckType.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#showGlobalSettings").trigger("click");
            $("#addOrUpdateHealthcheckType").text("Add");
          } else {
            $("#healthcheckErrorBox").html(data);
            setTimeout(function () {
              $("#healthcheckTypeErrorBox").html("");
            }, 3000);
          }
        },
        error: function () {},
      });
    }
  });
});

$(document).on("click", "#deletePlatform", function (event) {
  event.preventDefault();

  new swal({
    title: "Confirm delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showDenyButton: true,
    confirmButtonText: "Yes - Delete",
    denyButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      var dataToPost = {};
      dataToPost.PlatformIDToDelete = $("#platformList option:selected").val();

      $.ajax({
        url: "deletePlatform.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function (data) {
          if (data.includes("success")) {
            $("#showGlobalSettings").trigger("click");
            $("#addOrUpdatePlatformType").text("Add");
          } else {
            $("#platformErrorBox").html(data);
            setTimeout(function () {
              $("#platformErrorBox").html("");
            }, 3000);
          }
        },
        error: function () {},
      });
    }
  });
});

$(document).on("click", "#addOrUpdateDevice", function (event) {
  event.preventDefault();
  if ($("#addOrUpdateDevice").text() == "Add") {
    var dataToPost = {};
    dataToPost.deviceNameToAdd = document.getElementById(
      "textAddOrUpdateDevice"
    ).value;
    $.ajax({
      url: "addDevice.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
        } else {
          $("#deviceErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
  if ($("#addOrUpdateDevice").text() == "Update") {
    var dataToPost = {};
    dataToPost.deviceIDToUpdate = $("#deviceList option:selected").val();
    dataToPost.deviceNameToUpdate = document.getElementById(
      "textAddOrUpdateDevice"
    ).value;

    $.ajax({
      url: "updateDevice.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
          $("#addOrUpdateDevice").text("Add");
        } else {
          $("#deviceErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
});

$(document).on("click", "#addOrUpdateStatus", function (event) {
  event.preventDefault();
  if ($("#addOrUpdateStatus").text() == "Add") {
    var dataToPost = {};
    dataToPost.statusNameToAdd = document.getElementById(
      "textAddOrUpdateStatus"
    ).value;
    $.ajax({
      url: "addStatus.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
        } else {
          $("#statusErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
  if ($("#addOrUpdateStatus").text() == "Update") {
    var dataToPost = {};
    dataToPost.statusIDToUpdate = $("#statusList option:selected").val();
    dataToPost.statusNameToUpdate = document.getElementById(
      "textAddOrUpdateStatus"
    ).value;

    $.ajax({
      url: "updateStatus.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
          $("#addOrUpdateStatus").text("Add");
        } else {
          $("#statusErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
});

$(document).on("click", "#addOrUpdateSIMStatus", function (event) {
  event.preventDefault();
  if ($("#addOrUpdateSIMStatus").text() == "Add") {
    var dataToPost = {};
    dataToPost.SIMStatusNameToAdd = document.getElementById(
      "textAddOrUpdateSIMStatus"
    ).value;
    $.ajax({
      url: "addSIMStatus.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
        } else {
          $("#SIMStatusErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
  if ($("#addOrUpdateSIMStatus").text() == "Update") {
    var dataToPost = {};
    dataToPost.SIMStatusIDToUpdate = $("#SIMStatusList option:selected").val();
    dataToPost.SIMStatusNameToUpdate = document.getElementById(
      "textAddOrUpdateSIMStatus"
    ).value;

    $.ajax({
      url: "updateSIMStatus.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
          $("#addOrUpdateSIMStatus").text("Add");
        } else {
          $("#SIMStatusErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
});

$(document).on("click", "#addOrUpdateFootageStatus", function (event) {
  event.preventDefault();
  if ($("#addOrUpdateFootageStatus").text() == "Add") {
    var dataToPost = {};
    dataToPost.FootageStatusNameToAdd = document.getElementById(
      "textAddOrUpdateFootageStatus"
    ).value;
    $.ajax({
      url: "addFootageStatus.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
        } else {
          $("#footageStatusErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
  if ($("#addOrUpdateFootageStatus").text() == "Update") {
    var dataToPost = {};
    dataToPost.FootageStatusIDToUpdate = $(
      "#footageStatusList option:selected"
    ).val();
    dataToPost.FootageStatusNameToUpdate = document.getElementById(
      "textAddOrUpdateFootageStatus"
    ).value;

    $.ajax({
      url: "updateFootageStatus.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
          $("#addOrUpdateFootageStatus").text("Add");
        } else {
          $("#footageStatusErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
});

$(document).on("click", "#addOrUpdateRenewalType", function (event) {
  event.preventDefault();
  if ($("#addOrUpdateRenewalType").text() == "Add") {
    var dataToPost = {};
    dataToPost.RenewalTypeNameToAdd = document.getElementById(
      "textAddOrUpdateRenewalType"
    ).value;
    $.ajax({
      url: "addRenewalType.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
        } else {
          $("#renewalTypeErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
  if ($("#addOrUpdateRenewalType").text() == "Update") {
    var dataToPost = {};
    dataToPost.RenewalTypeIDToUpdate = $(
      "#renewalTypeList option:selected"
    ).val();
    dataToPost.RenewalTypeNameToUpdate = document.getElementById(
      "textAddOrUpdateRenewalType"
    ).value;

    $.ajax({
      url: "updateRenewalType.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
          $("#addOrUpdateRenewalType").text("Add");
        } else {
          $("#renewalTypeErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
});

$(document).on("click", "#addOrUpdateJobType", function (event) {
  event.preventDefault();
  if ($("#addOrUpdateJobType").text() == "Add") {
    var dataToPost = {};
    dataToPost.JobTypeNameToAdd = document.getElementById(
      "textAddOrUpdateJobType"
    ).value;
    $.ajax({
      url: "../php/jobs/addJobType.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
        } else {
          $("#jobTypeErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
  if ($("#addOrUpdateJobType").text() == "Update") {
    var dataToPost = {};
    dataToPost.JobTypeIDToUpdate = $("#jobTypeList option:selected").val();
    dataToPost.JobTypeNameToUpdate = document.getElementById(
      "textAddOrUpdateJobType"
    ).value;

    $.ajax({
      url: "updateJobType.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
          $("#addOrUpdateJobType").text("Add");
        } else {
          $("#jobTypeErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
});

$(document).on("click", "#addOrUpdateHealthcheckType", function (event) {
  event.preventDefault();
  if ($("#addOrUpdateHealthcheckType").text() == "Add") {
    var dataToPost = {};
    dataToPost.HealthcheckTypeNameToAdd = document.getElementById(
      "textAddOrUpdateHealthcheckType"
    ).value;
    $.ajax({
      url: "addHealthcheckType.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
        } else {
          $("#healthcheckTypeErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
  if ($("#addOrUpdateHealthcheckType").text() == "Update") {
    var dataToPost = {};
    dataToPost.HealthcheckTypeIDToUpdate = $(
      "#healthStatusList option:selected"
    ).val();
    dataToPost.HealthcheckTypeNameToUpdate = document.getElementById(
      "textAddOrUpdateHealthcheckType"
    ).value;

    $.ajax({
      url: "updateHealthcheckType.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
          $("#addOrUpdateHealthcheckType").text("Add");
        } else {
          $("#healthcheckTypeErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
});

$(document).on("click", "#addOrUpdatePlatform", function (event) {
  event.preventDefault();
  if ($("#addOrUpdatePlatform").text() == "Add") {
    var dataToPost = {};
    dataToPost.PlatformNameToAdd = document.getElementById(
      "textAddOrUpdatePlatform"
    ).value;
    $.ajax({
      url: "addPlatform.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
        } else {
          $("#platformErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
  if ($("#addOrUpdatePlatform").text() == "Update") {
    var dataToPost = {};
    dataToPost.PlatformIDToUpdate = $("#platformList option:selected").val();
    dataToPost.PlatformNameToUpdate = document.getElementById(
      "textAddOrUpdatePlatform"
    ).value;

    $.ajax({
      url: "updatePlatform.php",
      timeout: 30000,
      data: dataToPost,
      type: "POST",
      success: function (data) {
        if (data.includes("success")) {
          $("#showGlobalSettings").trigger("click");
          $("#addOrUpdatePlatformType").text("Add");
        } else {
          $("#platformTypeErrorBox").html(data);
        }
      },
      error: function () {},
    });
  }
});

function copyTextToClipboard(textToCopy) {
  let dummy = document.createElement("textarea");
  document.body.appendChild(dummy);
  dummy.value = textToCopy;
  dummy.select();
  document.execCommand("copy");
  document.body.removeChild(dummy);
}

function copyArrayToClipboard(arrayToCopy) {
  textToCopy = "";
  for (ix = 0; ix < arrayToCopy.length; ix++) {
    textToCopy += `${arrayToCopy[ix]}
            `;
  }
  textToCopy = textToCopy.replaceAll("&amp;", "&");

  let dummy = document.createElement("textarea");
  document.body.appendChild(dummy);
  dummy.value = textToCopy;
  dummy.select();
  document.execCommand("copy");
  document.body.removeChild(dummy);
}
