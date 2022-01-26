// Home menu click - go back to home screen
$('#homeMenu').on('click', function() {
    $('#accountInfo').html('');
    $('#eventLog').html('');
    $('#vehicleList').html('');
    $('#devicesList').html('');
    $('#overlay').html('');
    $('#customerInfo').html('');
    $('#customerSelect').html('');
    $('#bulkUploadsPage').html('');

    var dataToPost = {};
    $.ajax({
        url: 'getHomeScreen.php',
        type: 'POST',
        data: dataToPost,
        success: function(data) {
            $('#homeScreen').html(data);
        }
    });

    $('#homeScreen').show();

});

// Customer menu click - show customer screen
$('#customerMenu').on('click', function() {
    showCustomers();
    var dataToPost = {};
    dataToPost.selectedValue = "<?php echo $_SESSION['firstCustomer']; ?>";
    $.ajax({
        url: 'customers.php',
        type: 'POST',
        data: dataToPost,
        success: function(data) {
            $('#accountInfo').html('');
            $('#eventLog').html('');
            $('#homeScreen').hide();
            $('#vehicleList').html('');
            $('#devicesList').html('');
            $('#overlay').html('');
            $('#bulkUploadsPage').html('');
            $('#customerInfo').html(data);
            $('#getRenewalTypeSelect').trigger('change');
        },
        error: function() {}
    });

});

// Device menu - show device list

$(document).on("click", '#showDeviceList', function () {
    var dataToPost = {};
    dataToPost.SQLFilter = '';
    $.ajax({
        url: "deviceList.php",
        type: "POST",
        timeout: 60000,
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

// Vehicle menu - show vehicle list

$(document).on("click", '#showVehicleList', function() {
    var dataToPost = {};
    dataToPost.SQLFilter='';
    $.ajax({
        url: "vehicleList.php",
        type: "POST",
        data: dataToPost,
        success: function(data) {
          $('#accountInfo').html('');
          $('#customerSelect').html('');
          $('#customerInfo').html('');
          $('#overlay').html('');
          $('#homeScreen').hide();
          $('#eventLog').html('');
          $('#devicesList').html('');
          $('#bulkUploadsPage').html('');
          $('#vehicleList').html(data);
        },
        error: function() {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
        }
    });
  });

  //Footage menu - show footage request list

  $(document).on("click", '#showFootageList', function () {
    var dataToPost = {};
    dataToPost.SQLFilter = '';
    $.ajax({
        url: "footageList.php",
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

// Renewals menu - show renewals list

$(document).on("click", '#showRenewalList', function() {
    var dataToPost = {};
    dataToPost.SQLFilter='';
    $.ajax({
        url: "renewalsList.php",
        type: "POST",
        data: dataToPost,
        success: function(data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#homeScreen').hide();
            $('#eventLog').html('');
            $('#devicesList').html('');
            $('#bulkUploadsPage').html('');
            $('#vehicleList').html(data);
        },
        error: function() {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
        }
    });
});

// Jobs menu - show jobs list
$(document).on("click", '#showJobList', function () {
    var dataToPost = {};
    dataToPost.SQLFilter = $('#jobFilter').html();
    if (!dataToPost.SQLFilter) {
        dataToPost.SQLFilter = -1;
    }
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
            $('#errorBox').html("<div class='alert alert-warning'>There was an error retrieving the jobs list, try again later or contact TDHManager administrator.</div>");
        }
    });
});

// Alerts menu - alert list is a modal dialog shown directly from navbar.php

// Admin menu -> Partners menu ->Insurer Menu
$(document).on('click', '#showInsurers', function () {
    $.ajax({
        url: "insurerList.php",
        type: "POST",
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#eventLog').html('');
            $('#homeScreen').html('');
            $('#bulkUploadsPage').html('');
            $('#devicesList').html(data);
            $('#insurerNameSelection option:first').attr('selected', 'selected');
            $('#insurerNameSelection').trigger('change');
            $('#vehicleList').html('');
        },
        error: function () {

        }
    });
});

// Admin menu -> Partners menu ->Insurer Menu
$(document).on('click', '#showInstallers', function() {
    $.ajax({
        url: "installerList.php",
        type: "POST",
        success: function(data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#eventLog').html('');
            $('#homeScreen').html('');
            $('#bulkUploadsPage').html('');
            $('#devicesList').html(data);
            $('#installerNameSelection option:first').attr('selected', 'selected');
            $('#installerNameSelection').trigger('change');
            $('#vehicleList').html('');
        },
        error: function() {

        }
    })
});

// Admin menu -> Partners menu ->Supplier Menu
$(document).on('click', '#showSuppliers', function () {
    $.ajax({
        url: "supplierList.php",
        type: "POST",
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#eventLog').html('');
            $('#homeScreen').html('');
            $('#bulkUploadsPage').html('');
            $('#devicesList').html(data);
            $('#supplierNameSelection option:first').attr('selected', 'selected');
            $('#supplierNameSelection').trigger('change');
            $('#vehicleList').html('');
        },
        error: function () {

        }
    })
});

// Admin menu -> Partners menu ->Broker Menu
$(document).on('click', '#showBrokers', function () {
    $.ajax({
        url: "brokerList.php",
        type: "POST",
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#eventLog').html('');
            $('#homeScreen').html('');
            $('#bulkUploadsPage').html('');
            $('#devicesList').html(data);
            $('#brokerNameSelection option:first').attr('selected', 'selected');
            $('#brokerNameSelection').trigger('change');
            $('#vehicleList').html('');
        },
        error: function () {

        }
    })
});

// Admin menu -> Partners menu ->Other Menu
$(document).on('click', '#showOthers', function () {
    $.ajax({
        url: "otherList.php",
        type: "POST",
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#eventLog').html('');
            $('#homeScreen').html('');
            $('#bulkUploadsPage').html('');
            $('#devicesList').html(data);
            $('#otherNameSelection option:first').attr('selected', 'selected');
            $('#otherNameSelection').trigger('change');
            $('#vehicleList').html('');
        },
        error: function () {

        }
    })
});

// Admin menu -> Settings
$(document).on('click', '#showGlobalSettings', function(event) {
    // prevent default PHP processing
    "use strict";
    event.preventDefault();
    $.ajax({
        url: "globalSettings.php",
        type: "POST",
        success: function(data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#eventLog').html('');
            $('#devicesList').html('');
            $('#vehicleList').html('');
            $('#homeScreen').hide();
            $('#bulkUploadsPage').html('');
            $('#overlay').html(data);  
        },
        error: function() {
            $('#brokerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
        }
    });
});

// Admin menu - Import Healthchecks
$(document).on("click", '#importHealthChecks', function() {
    var dataToPost = {};
    dataToPost.SQLFilter='';
    $.ajax({
        url: "healthcheckList.php",
        type: "POST",
        data: dataToPost,
        success: function(data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#homeScreen').hide();
            $('#eventLog').html('');
            $('#devicesList').html('');
            $('#bulkUploadsPage').html('');
            $('#vehicleList').html(data);
        },
        error: function() {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
        }
    });
});

// Admin menu - Event Log
$(document).on('click', '#showEventLog', function(event) {
    // prevent default PHP processing
    "use strict";
    event.preventDefault();
    $.ajax({
        url: "eventLogOptions.php",
        type: "POST",
        success: function(data) {
            // $('#getClient').trigger('change');
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#overlay').html('');
            $('#vehicleList').html('');
            $('#devicesList').html('');
            $('#homeScreen').hide();
            $('#bulkUploadsPage').html('');
            $('#eventLog').html(data);
        },
        error: function() {
            $('#brokerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
        }
    });
});

//Admin menu - Bulk uploads
$(document).on('click', '#bulkUpload', function () {
    $.ajax({
        url: 'showBulkUpload.php',
        type: 'POST',
        success: function (data) {
            $('#accountInfo').html('');
            $('#customerSelect').html('');
            $('#customerInfo').html('');
            $('#eventLog').html('');
            $('#overlay').html('');
            $('#vehicleList').html('');
            $('#devicesList').html('');
            $('#homeScreen').html('');
            $('#bulkUploadsPage').html(data);
        }
    });
});

// Admin menu - Show issues log
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

// My Account 
$('#myAccount').on('click', function () {
    showMyAccount();
});


// Log out
$('#logOut').on('click', function () {
    $.ajax({
        url: "logOut.php",
        type: "GET",
        success: function () {
            window.location.href = "index.php";
        },
        error: function () {
            window.location.href = "index.php";
        }
    });
});


// This ensures dropdown sub-menus show properly
$('.dropdown-menu a.dropdown-toggle').on('mouseover', function (e) {
    if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
    }
    var $subMenu = $(this).next(".dropdown-menu");
    $subMenu.toggleClass('show');


    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
        $('.dropdown-submenu .show').removeClass("show");
    });

    return false;
});


