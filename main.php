<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE HTML>
<HTML>

<HEAD>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" description content="TDH Manager">

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://use.fontawesome.com/887b334360.js"></script>

    <link href="http://fonts.cdnfonts.com/css/uk-number-plate" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <link rel="stylesheet" type="text/css" href="styles/custombootstrap.css">
    <link rel="stylesheet" type="text/css" href="styles/navbar.css">

    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">


    <title>TDH Manager</title>

    <?php

    $_SESSION['firstCustomer'] = 0;

if ($_SESSION['darkMode'] != 1) {
    // NORMAL MODE
    $_SESSION['navbarImage'] = "images/logo_swirl.png";
    $_SESSION['textColor'] = '#222222';
    $_SESSION['renewalColor'] = '#ffffff';
} else {
    $_SESSION['navbarImage'] = "images/logo_swirl_black.png";
    $_SESSION['textColor'] = '#dddddd';
    $_SESSION['renewalColor'] = '#545454';
}
$notRenewable = $_SESSION['renewalColor'];
?>

<script>
function setDarkMode() {
        IsDarkMode = "<?php echo $_SESSION['darkMode'] ?>";

        if (IsDarkMode == 1) {
            if ($("body").hasClass("dark")) {
                $("body").removeClass("dark");
            } else {
                $("body").addClass("dark");
            }
        }   
    }

function purgeEventLog() {
    var dataToPost={};
    dataToPost.daysToAdd = 90;
    $.ajax({
        url: 'purgeEventLog.php',
        type: 'POST',
        data: dataToPost,
        success: function(data) {
        }
    });
}    
</script>

</HEAD>

<BODY onload='setDarkMode();purgeEventLog();'>
   <div class='container-fluid'>
        <?php
include 'navbar.php';
?>
    </div>
    <div id='IsDarkMode' style='visible: none'></div>
    <div id='accountInfo' class='container'></div>
    <div id='customerSelect' class='container'></div>
    <div id='customerInfo' class='container-fluid'></div>
    <div id='eventLog' class='container'></div>
    <div id='overlay' class='container-fluid'></div>
    <div id='vehicleList' class='container'></div>
    <div id='devicesList' class='container-fluid'></div>
    <div id='hiddenDeviceSelector' style='display: none;'></div>
    <div id='hiddenDeviceNotesSelector' style='display: none;'></div>
    

    <div id='homeScreen' class='container'></div>
  
 
</BODY>

<script src='scripts/index.js'></script>
<script src='scripts/clickEvents.js'></script>
<script src='scripts/insurer.js'></script>
<script src='scripts/insurerContact.js'></script>
<script src='scripts/installer.js'></script>
<script src='scripts/installerContact.js'></script>
<script src='scripts/supplier.js'></script>
<script src='scripts/supplierContact.js'></script>
<script src='scripts/broker.js'></script>
<script src='scripts/brokerContact.js'></script>
<script src='scripts/others.js'></script>
<script src='scripts/othersContact.js'></script>
<script src='scripts/devices.js'></script>
<script src='scripts/footage.js'></script>
<script src='scripts/vehicles.js'></script>


<script>

    var pickedUp;

    
    $(document).ready(function() {

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

        //update alert number
        $.ajax({
            url: 'getAlerts.php',
            type: 'GET',
            success: function(data) {
                var arr = data.split('^^^');

                if ((arr[0] + arr[1]) != 0) {
                    $('#renewalTotal').html(+arr[0] + +arr[1]);
                    $('#renewalTotalWrapper').show();
                } else {
                    $('#renewalTotalWrapper').hide();
                }
                if (arr[3] != 0) {
                    $('#installTotal').html(arr[3]);
                    $('#installTotalWrapper').show();
                } else {
                    $('#installTotalWrapper').hide();
                }
                if (arr[2] != 0) {
                    $('#alertTotal').html(arr[2]);
                    $('#alertTotalWrapper').show();
                } else {
                    $('#alertTotalWrapper').hide();
                }
            }
        });

        $(document).on('change', '#getClient', function() {

            var dataToPost = {}
            //  $('#getClient').find(":selected").val();
            dataToPost.selectedValue = this.value;
            $.ajax({
                url: 'customers.php',
                type: 'POST',
                data: dataToPost,
                success: function(data) {
                $('#customerInfo').html(data);
                if ($('#DeviceStats').text()=="Total Devices:  0") {
                   $('#addFootageRequest').prop('disabled', true);
                } else {
                    $('#addFootageRequest').prop('disabled', false);
                }
            },
                error: function() {
                }
            });
        });


      

        $('body').on('change', '#getRenewalTypeSelect', function() {
            var dataToPost = {};
            dataToPost.renewalTypeID = this.value;
       
            $.ajax({
                url: "updateRenewalTypeSelect.php",
                type: "GET",
                data: dataToPost,
                success: function(data) {
                    var renewalText = $('#getRenewalTypeSelect :selected').text();
                    if (renewalText.includes('Financed') || renewalText.includes('Yearly') || renewalText.includes('Annual')) {
                        document.getElementById('renewalDate').style.visibility = "visible";
                        document.getElementById('renewalDateLabel').style.visibility = "visible";
                    } else {
                        document.getElementById('renewalDate').style.visibility = "hidden";
                        document.getElementById('renewalDateLabel').style.visibility = "hidden";
                    }
                }
            });
        })


        $('#homeMenu').on('click', function() {
            $('#accountInfo').html('');
            $('#eventLog').html('');
            $('#vehicleList').html('');
            $('#devicesList').html('');
            $('#overlay').html('');
            $('#customerInfo').html('');
            $('#customerSelect').html('');

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
                   
                    $('#customerInfo').html(data);
                    $('#getRenewalTypeSelect').trigger('change');
                },
                error: function() {}
            });

        });


        $(document).ready(function() {
          $('.willCollapse').click(function(event) {
             $('.navbar-collapse').collapse('hide');
            });
        });

        $(document).on('click', '.isAdministrator', function() {
          if ($(this).val() != 1) {
            $(this).prop("value", 1);
          } else {
            $(this).prop("value", 0);
        }
        });

        $(document).on('click', '.isActivated', function() {
          if ($(this).val() != 1) {
            $(this).prop("value", 1);
          } else {
            $(this).prop("value", 0);
        }
        });

        $(document).on('click', '#updateUserList', function(event) {
            "use strict";
            event.preventDefault();
            var dataListToPost = [];
            var dataToPost = {};
            $('tr').each(function() {
              dataToPost = {};
              dataToPost.userID = $(this).find('.userUpdateID').text();
              dataToPost.isAnAdmin = $(this).find('.isAdministrator').val();
              dataToPost.isActive = $(this).find('.isActivated').val();
              dataListToPost.push(dataToPost);
            });
            dataListToPost = dataListToPost.splice(1,1000); // this will break if there are more than 999 Users

            $.ajax({
              url: 'updateUsers.php',
              data: {dataListToPost},
              type: 'POST',
              success: function(data) {
                if (data.includes('success')) {
                  $('#userErrorBox').html('<div class="alert alert-success">Updated successfully</div>');
                  $('#userErrorBox').delay(2500).hide(0);
                  // $('#userErrorBox').show();
              } else {
                  $('#userErrorBox').html(data);
                  // $('#userErrorBox').show();
              }
            },
              error: function() {}

          });

        });



       


      
        $('#footageInfo').on('click', function() {
            window.alert ('Footage information not implemented yet');
        });
        $('#footageRemove').on('click', function() {
            window.alert ('Footage removal not implemented yet');
        });

        $('#modalAddNewCustomer').on('hidden.bs.modal', function(event) {
             $(this).find('form').trigger('reset');
             $('#customerMessage').html('');
        });

        $('#modalAddNewNote').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            document.getElementById('noteDate').defaultValue = (new Date()).toISOString().slice(0, 16).replace(/-/g, "-").replace("T", "T");
            $('#noteMessage').html('');
        });

        $('#modalAddNewContact').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            $('#contactMessage').html('');
        });

        $('#modalAddNewFootage').on('hidden.bs.modal', function() {
            $('#footageFileTableBodyBlock').html('');
            $(this).find('form').trigger('reset');
        });

        $('#modalEditFootage').on('hidden.bs.modal', function() {
             $('#footageEditFileTableBodyBlock').html('');
            $(this).find('form').trigger('reset');
        }); 

        $('#modalGetVRNLookup').on('hidden.bs.modal', function(event) {
            $('#VRNToFindMessage').html('');
            $('#VehicleLookupInfo').html('');
             $(this).find('form').trigger('reset');
        });    

    


        $('#modalAddNewDevice').on('shown.bs.modal', function() {
            document.getElementById('addOwnerID').value = document.getElementById('customerName').value;
        });

        $('#modalShowAlerts').on('shown.bs.modal', function() {
            $.ajax({
                url: "alertModal.php",
                type: "POST",
                success: function(data) {
                    $('.rowAlert').html(data);
                },
                error: function() {}
            });
        });
    });

    // enable/disable relevant buttons in user profile form
    $('#accountInfo').keyup(function() {
        $('#updateUser').prop('disabled', false);
        $('#discardUser').prop('disabled', false);
        $('#closeUser').prop('disabled', true);
    });

    $(document).on("click", '.gender_radio', function() {
        $('#updateUser').prop('disabled', false);
        $('#discardUser').prop('disabled', false);
        $('#closeUser').prop('disabled', true);
    });

    $(document).on("click", '.form-check-input', function() {
        $('#updateUser').prop('disabled', false);
        $('#discardUser').prop('disabled', false);
        $('#closeUser').prop('disabled', true);
    });

    $(document).on("click", '.date-type', function() {
        $('#updateUser').prop('disabled', false);
        $('#discardUser').prop('disabled', false);
        $('#closeUser').prop('disabled', true);
    });
    //

    // AJAX call to update user profile form
    $(document).on("click", '#updateUser', function() {
        var dataToPost = $('#profileForm').serializeArray();
        darkMode = $('#darkMode').val();
        gender = $('#genderHidden').val();
        dataToPost.push({
            name: 'darkMode',
            value: darkMode
        });
        dataToPost.push({
            name: 'gender',
            value: gender
        });
       
        // send to profile.php using AJAX
        // to check input and update
        $.ajax({
            url: "profile.php",
            type: "POST",
            data: dataToPost,
            success: function(data) {
                if (data.includes('success')) {
                    showMyAccount();
                } else {
                    $('#errorBox').html(data);
                }
            },
            error: function() {
                $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
            }
        });
    });

    function lookupAddress() {
        var dataToPost = {};
        dataToPost.building = document.getElementById('addressLookup').value;
        dataToPost.postcode = document.getElementById('addressLookup2').value;
        dataToPost.postcode = dataToPost.postcode.toUpperCase();
        dataToPost.postcode = dataToPost.postcode.replace(" ","");

        $.ajax({
            url: 'addressLookup.php',
            data: dataToPost,
            type: 'POST',
            success: function(data) {
                data = $.parseJSON(data);
                if (data!=null) {
                    document.getElementById('custAddressLine1').value = dataToPost.building + ' ' + data['route'];
                    document.getElementById('custAddressLine1').style.borderColor = 'red';
                    document.getElementById('custAddressLine2').value = ''
                    document.getElementById('custAddressLine2').style.borderColor = 'red';
                    document.getElementById('custAddressLine3').value = data['postal_town'];
                    document.getElementById('custAddressLine3').style.borderColor = 'red';
                    document.getElementById('custAddressLine4').value = data['administrative_area_level_2'];
                    document.getElementById('custAddressLine4').style.borderColor = 'red';
                    document.getElementById('custAddressLine5').value = data['postal_code'];
                    document.getElementById('custAddressLine5').style.borderColor = 'red';
                    document.getElementById('addressLookup').value = '';
                    document.getElementById('addressLookup2').value = '';
                } else {
                    window.alert('Address not found for postcode ' + dataToPost.postcode);
                }
            },
            error: function() {
            }
          });

    }

   


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
            $('#devicesList').html(data);
            $('#vehicleList').html('');
        },
        error: function () {
            $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
        }
    });
});

$(document).on('click', '#jobsFilterClicked', function (event) {
    "use strict";
    event.preventDefault();
    var dataToPost = {};
    dataToPost.FilterCustomer = document.getElementById('getCustomerSelect').value;
    dataToPost.FilterType = document.getElementById('byDeviceType').value;
    dataToPost.FilterOtherTerm = document.getElementById('byOther').value;
    dataToPost.SQLFilter = '';
    $.ajax({
        url: 'filterJobs.php',
        data: dataToPost,
        type: 'POST',
        success: function (data) {
            dataToPost.SQLFilter = data;
            $.ajax({
                url: "jobList.php",
                type: "POST",
                data: dataToPost,
                success: function (data) {
                    $('#devicesList').html(data);
                },
                error: function () {
                    $('#errorBox').html("<div class='alert alert-warning'>There was an error updating, try again later or contact the author.</div>");
                }
            });
        },
        error: function () {

        }
    });
});




    $(document).on("click", '#closeUser', function() {
        location.reload(true);
    });

    $(document).on("click", '#savePassword', function() {
        xxx;
    });



    function updateStartDate(e) {
        var dataToPost = {};
        dataToPost.startDate = e.target.value;
        dataToPost.endDate = document.getElementById('filterToDate').value;
        if (!dataToPost.endDate) {
            dataToPost.endDate = new Date().toISOString().slice(0, 10);
        }
        $.ajax({
            url: "eventLogOptions.php",
            type: "POST",
            data: dataToPost,
            success: function(data) {
                $('#eventLog').html(data);
            }
        });
    }

    function updateEndDate(e) {
        var dataToPost = {};
        dataToPost.endDate = e.target.value;
        dataToPost.startDate = document.getElementById('filterStartDate').value;
        if (dataToPost.startDate > dataToPost.endDate) {
            dataToPost.startDate = dataToPost.endDate;
        }
        $.ajax({
            url: "eventLogOptions.php",
            type: "POST",
            data: dataToPost,
            success: function(data) {
                $('#eventLog').html(data);
            }
        });
    }


    // CUSTOMER CONTACT SCRIPTS
    // Update new
    $(document).on('click', '#updateCustomerContact', function(event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.firstName = document.getElementById('contactFirstName').value;
        dataToPost.lastName = document.getElementById('contactLastName').value;
        dataToPost.mobileNumber = document.getElementById('contactMobile').value;
        dataToPost.telephone = document.getElementById('contactTelephone').value;
        dataToPost.email = document.getElementById('contactEmail').value;
        dataToPost.jobTitle = document.getElementById('contactJobTitle').value;
        dataToPost.footageRec = document.getElementById('contactFootageRequest').checked;
        dataToPost.heathCheck = document.getElementById('contactHealthCheck').checked;

        $.ajax({
            url: "addCustomerContact.php",
            type: "POST",
            data: dataToPost,
            success: function(data) {
                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#modalAddNewContact').modal('hide')
                } else {
                    $('#contactMessage').html(data);
                }
            },
            error: function() {
                $('#contactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });

    // ADD CUSTOMER NOTE
    $(document).on('click', '#updateCustomerNote', function(event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        // collect user inputs
        var dataToPost = {};
        dataToPost.noteDate = document.getElementById('noteDate').value;
        dataToPost.noteText = document.getElementById('noteText').value;
        dataToPost.isImportant = document.getElementById('isImportantNote').checked;
        dataToPost.isAlertable = document.getElementById('createAlert').checked;

        $.ajax({
            url: "addCustomerNote.php",
            type: "POST",
            data: dataToPost,
            success: function(data) {
                if (data.includes('success')) {
                    $('#getClient').trigger('change');
                    $('#modalAddNewNote').modal('hide');
                    //update Alerts
                    $.ajax({
                        url: 'getAlerts.php',
                        type: 'GET',
                        success: function(data) {
                            var arr = data.split('^^^');

                            if ((arr[0] + arr[1]) != 0) {
                                $('#renewalTotal').html(+arr[0] + +arr[1]);
                                $('#renewalTotalWrapper').show();
                            } else {
                                $('#renewalTotalWrapper').hide();
                            }
                            if (arr[3] != 0) {
                                $('#installTotal').html(arr[3]);
                                $('#installTotalWrapper').show();
                            } else {
                                $('#installTotalWrapper').hide();
                            }
                            if (arr[2] != 0) {
                                $('#alertTotal').html(arr[2]);
                                $('#alertTotalWrapper').show();
                            } else {
                                $('#alertTotalWrapper').hide();
                            }
                        }
                    });


                } else {
                    $('#noteMessage').html(data);
                }
            },
            error: function() {
                $('#contactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
                $('#contactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });


    $(document).on('focusin', '#textAddOrUpdateStatus', function(event) {
        event.preventDefault();
        document.getElementById('addOrUpdateStatus').disabled = false;
        $('#statusErrorBox').html('')
    });

    $(document).on('focusin', '#textAddOrUpdateSIMStatus', function(event) {
        event.preventDefault();
        document.getElementById('addOrUpdateSIMStatus').disabled = false;
        $('#SIMStatusErrorBox').html('')
    });

    $(document).on('focusin', '#textAddOrUpdateFootageStatus', function(event) {
        event.preventDefault();
        document.getElementById('addOrUpdateFootageStatus').disabled = false;
        $('#footageStatusErrorBox').html('')
    });
    $(document).on('focusin', '#textAddOrUpdateRenewalType', function(event) {
        event.preventDefault();
        document.getElementById('addOrUpdateRenewalType').disabled = false;
        $('#renewalTypeErrorBox').html('')
    });
    $(document).on('focusin', '#textAddOrUpdateJobType', function(event) {
        event.preventDefault();
        document.getElementById('addOrUpdateJobType').disabled = false;
        $('#jobTypeErrorBox').html('')
    });




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

    // $(document).on('click', '#hideNavbar', function() {
    //         $('.navbar').animate({'height':'24px'}, 'fast');
    //         $('#hideNavbar').css('display', 'none');
    //         $('#showNavbar').css('display', 'block');
    // });

    // $(document).on('click', '#showNavbar', function() {
    //         $('.navbar').animate({'height':'96px'}, 'fast');
    //         $('#showNavbar').css('display', 'none');
    //         $('#hideNavbar').css('display', 'block');
    // });


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

    $(document).on('click', '#lookupVRNByAPI', function(event) {
        // prevent default PHP processing
        "use strict";
        var dataToPost = {};
        dataToPost.VRN = document.getElementById('VRNToFind').value.replaceAll(" ","");
        dataToPost.VRN = dataToPost.VRN.replaceAll(".","");
        dataToPost.VRN = dataToPost.VRN.replaceAll("-","");
        dataToPost.VRN = dataToPost.VRN.replaceAll("/","");
        dataToPost.VRN = dataToPost.VRN.replaceAll("'","");
        console.log(dataToPost.VRN);

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
                $('#eventLog').html(data);
            },
            error: function() {
                $('#brokerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });

    $(document).on('click', '#showGlobalSettings', function(event) {
        // prevent default PHP processing
        "use strict";
        event.preventDefault();
        $.ajax({
            url: "globalSettings.php",
            type: "POST",
            success: function(data) {
                // $('#getClient').trigger('change');
                $('#accountInfo').html('');
                $('#customerSelect').html('');
                $('#customerInfo').html('');
                $('#eventLog').html('');
                $('#devicesList').html('');
                $('#vehicleList').html('');
                $('#homeScreen').hide();
                $('#overlay').html(data);
                
            },
            error: function() {
                $('#brokerContactMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
            }
        });
    });

    

function printDiv() {
    var divToPrint = document.getElementById('filteredEventList');
    var popupWin = window.open('', '_blank', 'status=1,width=600,height=600');
    popupWin.document.open();
    popupWin.document.write('<html><body onload="window.print()" onafterprint="self.close()">' + "<div style='margin:50px; font-family: sans-serif'><h3><strong>TDHManager - Event Log print as at " + new Date() +"</strong></H3> " + divToPrint.innerHTML + '</div></html>');
    popupWin.document.close();    
}

function printVRNLookup() {
    var divToPrint = document.getElementById('VehicleLookupInfo');
    var popupWin = window.open('', '_blank', 'status=1,width=600,height=600');
    popupWin.document.open();
    popupWin.document.write('<html><head></head><body onload="window.print()" onafterprint="self.close()">' + "<div style='margin: 50px;font-family: sans-serif'>" + divToPrint.innerHTML + '</div></html>');
    popupWin.document.close();    
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



  


    function toggleGender(gender) {
            if (gender == 'male') {
            $('#gender_radio').html("<a class='btn btn-primary' style='background-color: #3276B1; color: white' onclick=toggleGender('male')>Male</a><a class='btn btn-primary' style='background-color: white; color: #3276B1' onclick=toggleGender('female')>Female</a>");
            $('#genderHidden').val('male');
        } else {
            $('#gender_radio').html("<a class='btn btn-primary' style='background-color: white; color: #3276B1' onclick=toggleGender('male')>Male</a><a class='btn btn-primary' style='background-color: #3276B1; color: white' onclick=toggleGender('female')>Female</a>");
            $('#genderHidden').val('female');
        }
    }

    function showMyAccount() {
        var dataToPost = {};
        dataToPost.userID = <?php echo $_SESSION['userID'] ?>;
        $.ajax({
            url: 'accountInfo.php',
            timeout: 30000,
            type: 'POST',
            data: dataToPost,
            success: function(data) {
                $('#customerInfo').html('');
                $('#customerSelect').html('');
                $('#overlay').html('');
                $('#homeScreen').hide();
                $('#eventLog').html('');
                $('#vehicleList').html('');
                $('#devicesList').html('');
                $('#accountInfo').html(data);
            },
            error: function() {

            }

        });
    }

    function updateRenewalDate(e) {
        var todaysDate = new Date();
        var renewalDate = new Date(e.target.value);
        var daysDiff = (renewalDate - todaysDate) / 86400000;

        if (daysDiff <= 30) {
            document.getElementById('renewalDate').style.backgroundColor = 'red';
        } else if (daysDiff <= 60) {
            document.getElementById('renewalDate').style.backgroundColor = 'orange';
        } else {
            document.getElementById('renewalDate').style.backgroundColor = '<?php echo $notRenewable; ?>';
        }

        $.ajax({
            url: 'getAlerts.php',
            type: 'GET',
            success: function(data) {
                var arr = data.split('^^^');

                if ((arr[0] + arr[1]) != 0) {
                    $('#renewalTotal').html(+arr[0] + +arr[1]);
                    $('#renewalTotalWrapper').show();
                } else {
                    $('#renewalTotalWrapper').hide();
                }
                if (arr[3] != 0) {
                    $('#installTotal').html(arr[3]);
                    $('#installTotalWrapper').show();
                } else {
                    $('#installTotalWrapper').hide();
                }
                if (arr[2] != 0) {
                    $('#alertTotal').html(arr[2]);
                    $('#alertTotalWrapper').show();
                } else {
                    $('#alertTotalWrapper').hide();
                }
            }
        });
    }

    // function updateRenewal() {
    //     var dataToPost = {};
    //     dataToPost.renewalType = document.getElementById('renewalType').value;
    //     dataToPost.renewalDate = document.getElementById('renewalDate').value;

    //     $.ajax({
    //         url: 'updateRenewal.php',
    //         data: dataToPost,
    //         timeout: 30000,
    //         type: "POST",
    //         success: function(data) {
    //             if (data.includes('success')) {
    //                 $('#renewalUpdateMessage').html('<div class="alert alert-success">Updated successfully</div>');
    //                 $('#renewalUpdateMessage').delay(2500).hide(0);
    //                 $('#renewalUpdateMessage').show();

    //                 $.ajax({
    //                     url: 'getAlerts.php',
    //                     type: 'GET',
    //                      success: function(data) {
    //                         var arr = data.split('^^^');

    //                          if ((arr[0] + arr[1]) != 0) {
    //                             $('#renewalTotal').html(+arr[0] + +arr[1]);
    //                             $('#renewalTotalWrapper').show();
    //                         } else {
    //                             $('#renewalTotalWrapper').hide();
    //                         }
    //                         if (arr[3] != 0) {
    //                             $('#installTotal').html(arr[3]);
    //                             $('#installTotalWrapper').show();
    //                         } else {
    //                             $('#installTotalWrapper').hide();
    //                         }
    //                         if (arr[2] != 0) {
    //                             $('#alertTotal').html(arr[2]);
    //                             $('#alertTotalWrapper').show();
    //                         } else {
    //                             $('#alertTotalWrapper').hide();
    //                         }
    //                     }
    //                 });
    //             } else {
    //                 $('#renewalUpdateMessage').html(data);
    //                 $('#renewalUpdateMessage').show();
    //             }
    //         },
    //         error: function() {
    //         }
    //     });
    // }

    function populateFootageBox() {
        var dataToPost = {};
        dataToPost.customerID = $('#hiddenCustomerID').text();
        $.ajax({
            url: 'getFootageInfo.php',
            timeout: 30000,
            data: dataToPost,
            // datatype: "json",
            type: "POST",
            success: function(data) {
                data = $.parseJSON(data);


                if (data=='nodevices') {
                    window.alert("There are no devices registered for this client, so you cannot add a footage request.")
                } else {

                $('#footageCustomerID').val(data['customerName']);
                var VRNHTML= "<select id='getFootageVRN' name='getFootageVRN' class='custom-select getFootageVRN'>";
                for (var x=0; x < data['VRN'].length; x++) {
                    VRNHTML += "<option value = '" + data['VRNID'][x] + "'>" + data['VRN'][x] + "</option>";
                }
                    VRNHTML += "</select>";
                $('#footageVRNList').html(VRNHTML);

                var contactsHTML = "<table class='table table-sm table-scrollable'><thead><tr><th>Contact Name</th><th>Email Address</th><th>Type</th><th>Sent</th></tr></thead><tbody>";

                for (var x=0; x < data['customerContactsEmail'].length; x++) {
                    contactsHTML += "<tr>";
                    contactsHTML += "<td>" + data['customerContactsFullName'][x] + "</td>";
                    contactsHTML += "<td>" + data['customerContactsEmail'][x] + "</td>";
                    contactsHTML += "<td>Customer</td>";
                    contactsHTML += "<td><input type='checkbox'></td>";
                    contactsHTML += "</tr>";
                }
                for (var x=0; x < data['insurerContactsEmail'].length; x++) {
                    contactsHTML += "<tr>";
                    contactsHTML += "<td>" + data['insurerContactsFullName'][x] + "</td>";
                    contactsHTML += "<td>" + data['insurerContactsEmail'][x] + "</td>";
                    contactsHTML += "<td>Insurer</td>";
                    contactsHTML += "<td><input type='checkbox'></td>";
                    contactsHTML += "</tr>";
                }
                for (var x=0; x < data['brokerContactsEmail'].length; x++) {
                    contactsHTML += "<tr>";
                    contactsHTML += "<td>" + data['brokerContactsFullName'][x] + "</td>";
                    contactsHTML += "<td>" + data['brokerContactsEmail'][x] + "</td>";
                    contactsHTML += "<td>Broker</td>";
                    contactsHTML += "<td><input type='checkbox'></td>";
                    contactsHTML += "</tr>";
                }

                    contactsHTML += "</tbody></table>"


                $('#footageRecipientsList').html(contactsHTML);

                $('#modalAddNewFootage').modal('show');
                }
            },
            error: function() {
            }
        });
    }



    function showCustomers(customer = 0) {
        var dataToPost = {};
        dataToPost.customerID = customer;

        $.ajax({
            url: 'selectCustomer.php',
            data: dataToPost,
            timeout: 30000,
            type: 'POST',
            success: function(data) {
                $('#accountInfo').html('');
                $('#customerSelect').html(data);
                $('#getClient').trigger('change');
            },
            error: function() {

            }

        });

    }

    function addCustomer() {
        var dataToPost = {};
        dataToPost.customerName = document.getElementById('newCustomerName').value;
        dataToPost.customerAddress1 = document.getElementById('customerAddress1').value;
        dataToPost.customerAddress2 = document.getElementById('customerAddress2').value;
        dataToPost.customerAddress3 = document.getElementById('customerAddress3').value;
        dataToPost.customerAddress4 = document.getElementById('customerAddress4').value;
        dataToPost.customerAddress5 = document.getElementById('customerAddress5').value;
        dataToPost.customerTelephone = document.getElementById('customerPhone').value;
        dataToPost.customerEmail = document.getElementById('customerEmail').value;
        dataToPost.customerCoRegNo = document.getElementById('customerRegNo').value;
        dataToPost.customerVATRegNo = document.getElementById('customerVATNo').value;
        dataToPost.customerInsurerID = document.getElementById('getInsurer').value;
        dataToPost.customerBrokerID = document.getElementById('getBroker').value;

        $.ajax({
            url: 'addNewCustomer.php',
            timeout: 30000,
            data: dataToPost,
            type: 'POST',
            success: function(data) {
                if (data.includes('success')) {
                    var newID = parseInt(data.replace('success', ''), 10);
                    showCustomers(newID);
                    $('#customerMessage').show();
                    $('#getClient').trigger('change');
                    $('#modalAddNewCustomer').modal('hide');
                    $('.modal-backdrop').hide();

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
                } else {
                    $('#customerMessage').html(data);
                    $('#customerMessage').show();
                }
            },
            error: function() {
            }
        })
    }




    

    function addNewFootage() {
        var dataToPost = {};
        dataToPost = $('#getAddNewFootage').serializeArray();

        var FileList = [];
        $('#footageFileTableBody tr').each(function() {
            $(this).find('td').each(function () {
                FileList.push($(this).text());
            });
        });
        var ContactList = [];
        $('#footageRecipientsList tr').each(function() {
            $(this).find('td').each(function () {
                if ($(this).find('input[type="checkbox"]').is(':checked')) {
                    ContactList.push("checked");
                } else {
                    ContactList.push($(this).text());
                }
            });
        });

        dataToPost.push({
            name: 'fileList',
            value: FileList
        });
        dataToPost.push({
            name: 'contactList',
            value: ContactList
        });

        $.ajax ({
            url: "addNewFootageRequest.php",
            timeout: 30000,
            type: "POST",
            data: dataToPost,
            success: function(data) {
                if (data.includes('success')) {
                    var newID = parseInt(data.replace("success",''),10);
                    $('#getClient').trigger('change');
                    showCustomers(newID);
                    $('#modalAddNewFootage').modal('hide');
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
                } else {
                    $('#addFootageMessage').html(data);
                }
            },
            error: function() {

            }
        });

    }

    function addNewJob() {
        var dataToPost = {};
        dataToPost.jobDate = document.getElementById('addJobDate').value;
        dataToPost.jobType = document.getElementById('addJobTypeType').value;
        dataToPost.jobVRN = document.getElementById('addJobTypeVRN').value;
        dataToPost.jobDetails = document.getElementById('addJobNotes').value;
        $.ajax({
            url: "addNewJob.php",
            timeout: 30000,
            type: "POST",
            data: dataToPost,
            success: function(data) {
                if (data.includes('success')) {
                    var newID = parseInt(data.replace("success",''),10);
                    $('#getClient').trigger('change');
                    showCustomers(newID);
                    $('#modalAddNewJobRequest').modal('hide');
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
            },
            error: function() {

            }
        });



   }

    


    function updateCustomer() {
        var dataToPost = {};
        dataToPost.customerName = document.getElementById('customerName').value;
        dataToPost.customerAddr1 = document.getElementById('custAddressLine1').value;
        dataToPost.customerAddr2 = document.getElementById('custAddressLine2').value;
        dataToPost.customerAddr3 = document.getElementById('custAddressLine3').value;
        dataToPost.customerAddr4 = document.getElementById('custAddressLine4').value;
        dataToPost.customerAddr5 = document.getElementById('custAddressLine5').value;
        dataToPost.customerPhone = document.getElementById('custPhone').value;
        dataToPost.customerEmail = document.getElementById('custEmail').value;
        dataToPost.customerRenewalType = document.getElementById('getRenewalTypeSelect').value;
        dataToPost.customerRenewalDate = document.getElementById('renewalDate').value;
        // dataToPost.customerRegNo = document.getElementById('custRegNumber').value;
        // dataToPost.customerVATNo = document.getElementById('custVATNumber').value;

        $.ajax({
            url: 'updateCustomerInfo.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if (data.includes('success')) {
                    var customerNumber = parseInt(data.replace('success', ''), 10);

                    $('#customerUpdateMessage').html('<div class="alert alert-success">Updated successfully</div>');
                    $('#customerUpdateMessage').delay(3500).hide(0);
                    $('#customerUpdateMessage').show();
                    $('.enabler').css('border-color', '#CED4DA');
                    $('#getClient').trigger('change');
                     showCustomers(customerNumber);
                } else {
                    $('#customerUpdateMessage').html(data);
                    $('#customerUpdateMessage').show();
                }
                $('#getRenewalTypeSelect').trigger('change');
            },
            error: function() {
            }
        });
    }

    function deleteCustomer() {
        $.ajax ({
            url: 'deleteCustomer.php',
            timeout: 30000,
            type: "POST",
            success: function(data) {
              },
            error: function() {

            }
        });
    }




  

    function editContact(rowNumber) {
        var dataToPost = {};
        dataToPost.contactID = rowNumber;
        $.ajax({
            url: 'editCustomerContact.php',
            timeout: 30000,
            data: dataToPost,
            type: 'POST',
            success: function(data) {
                var arr = data.split("^^^");

                document.getElementById('editContactFirstName').value = arr[1];
                document.getElementById('editContactLastName').value = arr[2];
                document.getElementById('editContactMobile').value = arr[3];
                document.getElementById('editContactTelephone').value = arr[4];
                document.getElementById('editContactEmail').value = arr[5];
                document.getElementById('editContactJobTitle').value = arr[6];
                if (arr[7] == 1) {
                    document.getElementById('editContactFootageRequest').checked = true;
                } else {
                    document.getElementById('editContactFootageRequest').checked = false;
                }
                if (arr[8] == 1) {
                    document.getElementById('editContactHealthCheck').checked = true;
                } else {
                    document.getElementById('editContactHealthCheck').checked = false;
                }

                document.getElementById('customerContactEditNumber').value = arr[0];
                document.getElementById('contactEditNumber').value = arr[9];


                $('#modalEditContact').modal('show');
            },
            error: function() {

            }
        });
    }





  
    

   

    function editCurrentFootage() {
        var dataToPost = {};
        dataToPost.footageID = document.getElementById('hiddenFootageID').value;
        dataToPost.ownerID = document.getElementById('editFootageOwnerID').value;
        dataToPost.incidentDate = document.getElementById('footageEditIncidentDate').value;
        dataToPost.vehicleID = document.getElementById('getFootageVRN').value;
        dataToPost.claimReference = document.getElementById('footageEditClaimReference').value;
        dataToPost.requestDate = document.getElementById('footageEditRequestDate').value;
        dataToPost.requestNotes = document.getElementById('footageEditRequestNotes').value;
        dataToPost.responseDate = document.getElementById('footageEditResponseDate').value;
        dataToPost.allocatedTo = document.getElementById('footageEditTDHEmployee').value;
        dataToPost.responseNotes = document.getElementById('footageEditResponseNotes').value;
        dataToPost.requestStatus = document.getElementById('footageEditCurrentStatusList').value;

        $.ajax({
            url: 'updateEditFootage.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if (data.includes("success")) {
                    $('#editFootageMessage').html('');
                    $('#getClient').trigger('change');
                    $('#modalEditFootage').modal('hide');

                    $.ajax({
                        url: 'getAlerts.php',
                        type: 'GET',
                        success: function(data) {
                            var arr = data.split('^^^');

                            if ((arr[0] + arr[1]) != 0) {
                                $('#renewalTotal').html(+arr[0] + +arr[1]);
                                $('#renewalTotalWrapper').show();
                            } else {
                                $('#renewalTotalWrapper').hide();
                            }
                            if (arr[3] != 0) {
                                $('#installTotal').html(arr[3]);
                                $('#installTotalWrapper').show();
                            } else {
                                $('#installTotalWrapper').hide();
                            }
                            if (arr[2] != 0) {
                                $('#alertTotal').html(arr[2]);
                                $('#alertTotalWrapper').show();
                            } else {
                                $('#alertTotalWrapper').hide();
                            }
                        }
                    });
                } else {
                    $('#editFootageMessage').html(data);
                }
            },
            error: function() {

            }
        });

        // get file names from table, then pass them to PHP to add to table
        var fileNames = [];
        var table = $("#footageEditFileTableBodyBlock");
        table.find('tr').each(function(i) {
            var tds = $(this).find('td');
            fileName = tds.eq(0).text();
            fileNames.push(fileName);
        })

        var dataToPost = {};
        dataToPost.fileNames = fileNames;
        dataToPost.requestID = document.getElementById('hiddenFootageID').value;
        $.ajax ({
            url: "updateUploads.php",
            type: "POST",
            data: dataToPost,
            success: function(data) {
                console.log(data);
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
            var dtp = {};
            dtp.jobID = rowNumber;
            $.ajax ({
                url: 'getJobCustomer.php',
                data: dtp,
                type: "POST",
                success: function(data) {
                    $('#hiddenCustomerID').text(data);
                    console.log('A' + data);
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
  
                var VRNHTML= "<select id='getJobVRN' name='getJobVRN' class='custom-select getJobVRN'>";
                for (var x=0; x < data['VRN'].length; x++) {
                    if (data['selectedVehicle'] == data['VRNID'][x]) {
                        VRNHTML += "<option value = '" + data['VRNID'][x] + "' selected>" + data['VRN'][x] + "</option>";
                    } else {
                        VRNHTML += "<option value = '" + data['VRNID'][x] + "'>" + data['VRN'][x] + "</option>";
                    }
                }
                    VRNHTML += "</select>";
                $('#editJobTypeVRN').html(VRNHTML);

                $('#editJobTypeType').val(data['jobType']);
                $('#editJobDate').val(data['date']);
                $('#editJobNotes').text(data['notes']);

                if (editMode == 'view') {
                    document.getElementById('editJobDate').disabled = true;
                    document.getElementById('editJobTypeType').disabled = true;
                    document.getElementById('editJobTypeVRN').disabled = true;
                    document.getElementById('editJobNotes').disabled = true;
                    $('#editJobComplete').text("Mark as Outstanding");
                    document.getElementById('editJobUpdate').style.display = "none";
                    document.getElementById('editJobCancel').style.display = "none";
                 } else {
                    document.getElementById('editJobDate').disabled = false;
                    document.getElementById('editJobTypeType').disabled = false;
                    document.getElementById('editJobTypeVRN').disabled = false;
                    document.getElementById('editJobNotes').disabled = false;
                    $('#editJobComplete').text("Mark as Complete");
                    document.getElementById('editJobUpdate').style.display = "block";
                    document.getElementById('editJobCancel').style.display = "block";
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


    function showFullFootage(rowNumber) {
        var dataToPost = {};
        dataToPost.footageCustomer = $('#hiddenCustomerID').text();
        dataToPost.footageID = rowNumber;
        $.ajax({
            url: "getFootageDropDowns.php",
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                data = $.parseJSON(data);

                var VRNHTML= "<select id='getFootageVRN' name='getFootageVRN' class='custom-select getFootageVRN'>";
                for (var x=0; x < data['VRN'].length; x++) {
                    if (data['selectedVehicle'] == data['VRNID'][x]) {
                        VRNHTML += "<option value = '" + data['VRNID'][x] + "' selected>" + data['VRN'][x] + "</option>";
                    } else {
                        VRNHTML += "<option value = '" + data['VRNID'][x] + "'>" + data['VRN'][x] + "</option>";
                    }
                }
                    VRNHTML += "</select>";
                $('#footageEditVRNList').html(VRNHTML);

                var filePathHTML = '';''
                for (x = 0; x < data['filePath'].length; x++) {
                    filePathHTML += "<tr>";
                    filePathHTML += "<td>" + data['filePath'][x] + "</td>";
                    filePathHTML += "<td><btn class= 'btn btn-success btn-sm' id='footageInfo'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info' viewBox='0 0 16 16'><path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg></btn></td>";
                    filePathHTML += "<td><btn class= 'btn btn-danger btn-sm' id='footageRemove'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/></svg></btn></td>";
                    filePathHTML += "</tr>";
                }
                $('#footageEditFileTableBody').append(filePathHTML);

                var contactsHTML = "<table class='table table-sm table-scrollable'><thead><tr><th>Contact Name</th><th>Email Address</th><th>Type</th><th>Sent</th></tr></thead><tbody>";

                for (var x=0; x < data['footageContactEmail'].length; x++) {
                    contactsHTML += "<tr>";
                    contactsHTML += "<td>" + data['footageContactName'][x] + "</td>";
                    contactsHTML += "<td>" + data['footageContactEmail'][x] + "</td>";
                    contactsHTML += "<td>" + data['footageContactType'][x] + "</td>";
                if (data['footageContactSent'][x] == 1) {
                    contactsHTML += "<td><input type='checkbox' checked></td>";
                } else {
                    contactsHTML += "<td><input type='checkbox'></td>";
                }
                    contactsHTML += "</tr>";
                }
               contactsHTML += "</tbody></table>"


            $('#footageEditRecipientsList').html(contactsHTML);

            },
            error: function() {

            }
        });

        dataToPost.footageID = rowNumber;
        $.ajax({
            url: "getCurrentFootage.php",
            timeout: 30000,
            data: dataToPost,
            datatype: "json",
            type: "POST",
            success: function(data) {
               data = $.parseJSON(data);
                document.getElementById('footageEditIncidentDate').value = data['incidentDate'].replace(' ','T');
                document.getElementById('footageEditCustomerID').value = data['businessName'];
                document.getElementById('footageEditClaimReference').value = data['claimRef'];
                document.getElementById('footageEditRequestDate').value = data['requestDateTime'].replace(' ','T');
                document.getElementById('footageEditRequestNotes').value = data['requestNotes'];
                if (data['responseDateTime']!=null) {
                    data['responseDateTime'] = data['responseDateTime'].replace(' ','T');
                }
                document.getElementById('footageEditResponseDate').value = data['responseDateTime'];
                document.getElementById('footageEditTDHEmployee').value = data['userID'];
                document.getElementById('footageEditResponseNotes').value = data['responseText'];
                document.getElementById('footageEditCurrentStatusList').value = data['statusID'];
                document.getElementById('hiddenFootageID').value = rowNumber;
                document.getElementById('editFootageOwnerID').value = data['ID'];

                $('#modalEditFootage').modal('show');
            },
            error: function() {

            }
        })

    }

    

    function updateCustomerContact() {
        var dataToPost = {};
        dataToPost.contactFirstName = document.getElementById('editContactFirstName').value;
        dataToPost.contactLastName = document.getElementById('editContactLastName').value;
        dataToPost.contactMobile = document.getElementById('editContactMobile').value;
        dataToPost.contactTelephone = document.getElementById('editContactTelephone').value;
        dataToPost.contactEmail = document.getElementById('editContactEmail').value;
        dataToPost.contactJobTitle = document.getElementById('editContactJobTitle').value;
        dataToPost.contactFootageRecipient = document.getElementById('editContactFootageRequest').checked;
        dataToPost.contactHealthCheck = document.getElementById('editContactHealthCheck').checked;
        dataToPost.customerNumber = document.getElementById('customerContactEditNumber').value;
        dataToPost.contactNumber = document.getElementById('contactEditNumber').value;

        $.ajax({
            url: 'updateCustomerContact.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if (data.includes('success')) {
                    $('#editContactMessage').html('');
                    $('#getClient').trigger('change');
                    $('#modalEditContact').modal('hide');
                } else {
                    $('#editContactMessage').html(data);
                }
            },
            error: function() {

            }
        });

    }

    function deleteCustomerContact() {
        var dataToPost = {};
        dataToPost.contactFirstName = document.getElementById('editContactFirstName').value;
        dataToPost.contactLastName = document.getElementById('editContactLastName').value;
        dataToPost.contactNumber = document.getElementById('contactEditNumber').value;

        var proceed = confirm("Are you sure you want to delete the contact " + dataToPost.contactFirstName + " " + dataToPost.contactLastName + "?  This cannot be undone once you click OK");
        if (proceed) {
            $.ajax({
                url: 'deleteCustomerContact.php',
                timeout: 30000,
                data: dataToPost,
                type: "POST",
                success: function(data) {
                    if (data.includes('success')) {
                        $('#editContactMessage').html('');
                        $('#getClient').trigger('change');
                        $('#modalEditContact').modal('hide');
                    } else {
                        $('#editContactMessage').html(data);
                    }
                },
                error: function() {}
            });
        }
    }





    function editNote(rowNumber) {
        var dataToPost = {};
        dataToPost.noteID = rowNumber;

        $.ajax({
            url: 'editCustomerNote.php',
            timeout: 30000,
            data: dataToPost,
            type: 'POST',
            success: function(data) {
                var arr = data.split("^^^");

                document.getElementById('noteEditDate').value = arr[0].substring(0, arr[0].length - 3);
                document.getElementById('noteEditText').value = arr[1];
                if (arr[2] == 1) {
                    document.getElementById('isImportantEditNote').checked = true;
                } else {
                    document.getElementById('isImportantEditNote').checked = false;
                }
                if (arr[3] == 1) {
                    document.getElementById('createEditAlert').checked = true;
                } else {
                    document.getElementById('createEditAlert').checked = false;
                }

                document.getElementById('customerEditNumber').value = arr[4];
                document.getElementById('noteEditNumber').value = arr[5];
                document.getElementById('noteEditUser').value = arr[6];

                if (arr[6] == <?php echo $_SESSION['userID']; ?>) {
                    $('#modalEditCustomerNote').modal('show');
                }
            },
            error: function() {}
        });
    }

    function updateNote() {
        var dataToPost = {};
        dataToPost.noteDateEdited = document.getElementById('noteEditDate').value;
        dataToPost.noteTextEdited = document.getElementById('noteEditText').value;
        dataToPost.noteIsImportantEdited = document.getElementById('isImportantEditNote').checked;
        dataToPost.noteIsAlertEdited = document.getElementById('createEditAlert').checked;
        dataToPost.customerNumber = document.getElementById('customerEditNumber').value;
        dataToPost.noteNumber = document.getElementById('noteEditNumber').value;
        dataToPost.noteUser = document.getElementById('noteEditUser').value;
        $.ajax({
            url: 'updateCustomerNote.php',
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if (data.includes('success')) {
                    $('#noteEditMessage').html('');
                    $('#getClient').trigger('change');
                    $('#modalEditCustomerNote').modal('hide');
                    $.ajax({
                        url: 'getAlerts.php',
                        type: 'GET',
                        success: function(data) {
                            var arr = data.split('^^^');

                            if ((arr[0] + arr[1]) != 0) {
                                $('#renewalTotal').html(+arr[0] + +arr[1]);
                                $('#renewalTotalWrapper').show();
                            } else {
                                $('#renewalTotalWrapper').hide();
                            }
                            if (arr[3] != 0) {
                                $('#installTotal').html(arr[3]);
                                $('#installTotalWrapper').show();
                            } else {
                                $('#installTotalWrapper').hide();
                            }
                            if (arr[2] != 0) {
                                $('#alertTotal').html(arr[2]);
                                $('#alertTotalWrapper').show();
                            } else {
                                $('#alertTotalWrapper').hide();
                            }
                        }
                    });
                } else {
                    $('#noteEditMessage').html(data);
                }
            },
            error: function() {

            }
        });

    }

    function VRNLookup() {
        var dataToPost = {};
        dataToPost.VRN = document.getElementById('addVRN').value;
        dataToPost.VRN = dataToPost.VRN.trim();
        dataToPost.VRN = dataToPost.VRN.replace(' ', '');

        $.ajax({
            url: "checkVRN.php",
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function() {

            },
            error: function() {

            }
        });
    }

    function makeDirty(elementID) {
        document.getElementById(elementID).style.borderColor = 'red';
    }

    function onlyNumberKey(evt) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

    function fileExplorer(editOrAdd) {
        if (editOrAdd == 'Add') {
            document.getElementById('footageFileName').onchange = function() {
                fileObj = document.getElementById('footageFileName').files[0];
                uploadFileToServer(fileObj, editOrAdd);
            }
        } else if (editOrAdd == 'Edit') {
            document.getElementById('footageEditFileName').onchange = function() {
                fileObj = document.getElementById('footageEditFileName').files[0];
                uploadFileToServer(fileObj, editOrAdd);
            }
        }
    }

    function uploadFileToServer(file_obj, editOrAdd) {
        if (file_obj !=undefined) {
            var form_data = new FormData();
            form_data.append('file', file_obj);
            $.ajax ({
                type: "POST",
                url: "uploads.php",
                contentType: false,
                processData: false,
                data: form_data,
                success: function(response) {
                    // add filename to table/
                    if (response.includes('success')) {
                        var fileName = {};
                        fileName = response.replace('success', '');
                        var data = '';
                        if (editOrAdd== 'Add') {
                            // data = '<tr><td>' + fileName + '</td></tr>'
                            // $('#footageFileTableBody').append(data);
                            data = '<tr><td>' + fileName + "</td><td><btn class= 'btn btn-success btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='12px' height='12px' fill='currentColor' class='bi bi-info' viewBox='0 0 16 16'><path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg></btn></td></td>";
                            data = data + "<td class='text-center align-middle'><btn class= 'btn btn-danger btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='12px' height='12px' fill='currentColor' class='bi bi-x-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/></svg></btn></td></tr>'";
                            $('#footageFileTableBody').append(data);
                        } else if (editOrAdd == 'Edit') {
                            data = '<tr><td>' + fileName + "</td><td><btn class= 'btn btn-success btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='12px' height='12px' fill='currentColor' class='bi bi-info' viewBox='0 0 16 16'><path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg></btn></td></td>";
                            data = data + "<td class='text-center align-middle'><btn class= 'btn btn-danger btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='12px' height='12px' fill='currentColor' class='bi bi-x-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/></svg></btn></td></tr>'";
                            $('#footageEditFileTableBody').append(data);
                        }
                    } else {
                        window.alert(response);
                    }
                },
                error: function() {

                }
            });
        }
    }



</script>


<?php

function getAlerts($link)
{
    $sql = 'SELECT * FROM tblCustomer';
    $result = mysqli_query($link, $sql);
    $alerts = [];
    $dateNow = new dateTime();

    while ($alertRows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        if (!$alertRows['renewalDate']) {
            $daysToRenewal = -1;
        } else {
            $renewalDate = new DateTime($alertRows['renewalDate']);
            $daysToRenewal = $dateNow->diff($renewalDate)->format('%r%a');
        }
        // renewals due within 30 or fewer days
        if ($daysToRenewal <= 30 && $daysToRenewal >= 0) {
            $alert['date'] = $renewalDate->format('Y-m-d H:i');
            $alert['alertType'] = 1;
            $alert['days'] = $daysToRenewal;
            $alert['customerID'] = $alertRows['ID'];
            $alert['text'] = $alertRows['businessName'] . " is due ";
            switch (intval($alert['days'])) {
                case 0:
                    $alert['text'] .= "today";
                    break;
                case 1:
                    $alert['text'] .= "tomorrow";
                    break;
                default:
                    $alert['text'] .= "in " . $alert['days'] . " days";
            }
            $alert['owner'] = '-';
            $alert['userID'] = 0;
            $alert['noteID'] = 0;
            array_push($alerts, $alert);
        }
        // renewals due within 31-60 days
        if ($daysToRenewal <= 60 && $daysToRenewal > 30) {
            $alert['date'] = $renewalDate->format('Y-m-d H:i');
            $alert['alertType'] = 2;
            $alert['days'] = $daysToRenewal;
            $alert['customerID'] = $alertRows['ID'];
            $alert['text'] = $alertRows['businessName'] . " is due in " . $alert['days'] . " days";
            $alert['owner'] = '-';
            $alert['userID'] = 0;
            $alert['noteID'] = 0;
            array_push($alerts, $alert);
        }
    }

    $interval = new DateInterval('P30D');
    $dateNow->add($interval);

    $sql = "SELECT * FROM tblCustomerNote INNER JOIN tblUsers ON tblCustomerNote.userID = tblUsers.userID INNER JOIN tblCustomer ON tblCustomerNote.customerID = tblCustomer.ID WHERE (noteDate <= '" . $dateNow->format('Y-m-d H:i') . "' AND isAnAlert='1')";

    $result = mysqli_query($link, $sql);
    while ($noteRows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $alert['date'] = $noteRows['noteDate'];
        $alert['alertType'] = 3;
        $alertDate = new DateTime($noteRows['noteDate']);
        $alert['days'] = $dateNow->diff($alertDate)->format('%r%a');
        $alert['customerID'] = $noteRows['customerID'];
        $alert['customername'] = $noteRows['businessName'];
        $alert['text'] = $noteRows['noteText'];
        $alert['owner'] = $noteRows['userName'];
        $alert['userID'] = $noteRows['userID'];
        $alert['noteID'] = $noteRows['cnID'];
        array_push($alerts, $alert);
    }

    $dateNow = new dateTime();

    $sql = "SELECT * FROM tblDevice INNER JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID INNER JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID WHERE (installDate >= '" . $dateNow->format('Y-m-d') . "')";

    $result = mysqli_query($link, $sql);

    while ($noteRows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $alert['date'] = $noteRows['installDate'];
        $alert['alertType'] = 4;
        $alert['text'] = "Install for " . $noteRows['businessName'] . "(" . $noteRows['regNumber'] . " ) is booked for " . date('d/m/Y', strtotime($noteRows['installDate']));
        $alert['owner'] = "-";
        $alert['userID'] = 0;
        $alert['noteID'] = 0;
        array_push($alerts, $alert);
    }

    sort($alerts);
    return $alerts;
}

require_once 'modals.php';

?>

</HTML>
