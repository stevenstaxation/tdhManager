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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script> -->
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <script src="https://use.fontawesome.com/887b334360.js"></script>
    <link href="https://fonts.cdnfonts.com/css/uk-number-plate" rel="stylesheet">


   

    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">


    <script src='scripts/bootstrap-combobox.js'></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script> -->
 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>



    <!-- Select2 plugin -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <link rel="stylesheet" type="text/css" href="styles/custombootstrap.css">
    <link rel="stylesheet" type="text/css" href="styles/navbar.css">
    <link rel='stylesheet' type='text/css' href='styles/bootstrap-combobox.css'>
    <link rel="stylesheet" type="text/css" href="styles/datatables.css">
    <link rel="stylesheet" type="text/css" href="styles/select2.css">
    
 
    <title>TDH Manager</title>

    <?php
        $_SESSION['firstCustomer'] = 0;
        $_SESSION['textColor'] = '#222222';
        $_SESSION['renewalColor'] = '#ffffff';
        $notRenewable = $_SESSION['renewalColor'];
    ?>

<script>

function setDarkMode(colMode) {
    if (colMode==1) {
        $("body").removeClass("dark");
        document.getElementById('companyLogo').src = "images/logo_swirl.png";
    } else if (colMode==0) {
        $("body").addClass("dark");
        document.getElementById('companyLogo').src = "images/logo_swirl_black.png";
    } else {
        if ($("body").hasClass("dark")) {
            $("body").removeClass("dark");
            document.getElementById('companyLogo').src = "images/logo_swirl.png";
        } else {
            $("body").addClass("dark");
            document.getElementById('companyLogo').src = "images/logo_swirl_black.png";
        }
    }

    $("#deviceListTable").DataTable().draw();
    $("#footageListTable").DataTable().draw();
    $("#jobListTable").DataTable().draw();
    $("#renewalsListTable").DataTable().draw();
    $("#vehicleListTable").DataTable().draw();
    $("#vehiclesTable").DataTable().draw();
    $("#devicesTable").DataTable().draw();


}

function purgeEventLog() {
    var dataToPost={};
    dataToPost.daysToAdd = 42;
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



<BODY onload='setDarkMode(<?php echo $_SESSION['darkMode'];?>);purgeEventLog();'>
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
    <div id='bulkUploadsPage' class='container'></div>
    <div id='hiddenDeviceSelector' style='display: none;'></div>
    <div id='hiddenVehicleSelector' style='display: none;'></div>
    <div id='hiddenDeviceNotesSelector' style='display: none;'></div>
    <div id='hiddenJobNotesSelector' style='display: none;'></div>
    <div id='hiddenJobSelector' style='display: none;'></div>
    <div id='hiddenVehicleNotesSelector' style='display: none;'></div>
    <div id='homeScreen' class='container'></div>
    
</BODY>

<script src='scripts/index.js'></script>
<script src='scripts/clickEvents.js'></script>
<script src='scripts/customers.js'></script>
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
<script src='scripts/jobs.js'></script>
<script src='scripts/uploads.js'></script>
<script src='scripts/menus.js'></script>





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
        $(document).on('click', '.isInstaller', function() {
          if ($(this).val() != 1) {
            $(this).prop("value", 1);
          } else {
            $(this).prop("value", 0);
        }
        });
        $(document).on('click', '.isEngineer', function() {
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
              dataToPost.isInstaller = $(this).find('.isInstaller').val();
              dataToPost.isEngineer = $(this).find('.isEngineer').val();
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
            swal ('Footage information not implemented yet','coming soon', 'info');
        });
        $('#footageRemove').on('click', function() {
            swal ('Footage removal not implemented yet','coming soon', 'info');
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

        $('#modalAddIssue').on('hidden.bs.modal', function() {
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
            var ele = document.getElementById('customerName');
            if (ele) {
                document.getElementById('addOwnerID').value = ele.value;
            }
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
    $(document).on('focusin', '#textAddOrUpdateHealthcheckType', function(event) {
        event.preventDefault();
        document.getElementById('addOrUpdateHealthcheckType').disabled = false;
        $('#healthcheckTypeErrorBox').html('')
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
                $('#bulkUploadsPage').html('');
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
            $('.showRenewalStatus').html("<img style='margin-left: 10px;width: 90%; height: 90%' src='images/red_warning_24.png'/>");     
        } else if (daysDiff <= 60) {
            $('.showRenewalStatus').html("<img style='margin-left: 10px;width: 90%; height: 90%' src='images/yellow_warning_24.png'/>");
        } else {
            $('.showRenewalStatus').html('');
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

  

    function addNewIssue() {
        var dataToPost = {};
        dataToPost.issueDate = document.getElementById('addIssueDate').value;
        dataToPost.issueDescription = document.getElementById('addIssueDescription').value;
        dataToPost.issuePriority = document.getElementById('addIssuePriority').value;
        dataToPost.issueFilename = $('#uploadScreenshot').attr('src');

        if (!dataToPost.issueFilename) {
            dataToPost.issueFilename='';
        }
        $.ajax ({
            url: "addNewIssue.php",
            timeout: 30000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if(!data){
                $('#uploaded_image').html('');
                $('#uploadScreenshot').removeAttr('src');
                $('#modalAddIssue').modal('hide');     
                $('#showIssueLog').trigger('click');           
                } else {
                    $('#issueRequestMessage').html(data);
                }
            }
        });
    }

    function showIssueForEdit(sender) {
        var dataToPost = {};
        dataToPost.issueID = sender;
        $.ajax ({
            url: "getCurrentIssue.php",
            timeout: 30000,
            data: dataToPost,
            datatype: "json",
            type: "POST",
            success: function(data) {
                data = $.parseJSON(data);
                document.getElementById('editIssueDate').value = data['reportDate'];
                document.getElementById('editIssuePriority').value = data['priority'];
                document.getElementById('editIssueStatus').value = data['status'];
                document.getElementById('editIssueDescription').value = data['description'];
                document.getElementById('editIssueHide').value = sender;

                $('#modalEditIssue').modal('show');
            },
            error: function() {

            }
        });
    }

    function editIssue () {
        var dataToPost = {};
        dataToPost.issueIDToUpdate = document.getElementById('editIssueHide').value;
        dataToPost.issueDate = document.getElementById('editIssueDate').value;
        dataToPost.issuePriority = document.getElementById('editIssuePriority').value;
        dataToPost.issueStatus = document.getElementById('editIssueStatus').value;
        dataToPost.issueDescription = document.getElementById('editIssueDescription').value;
        
        $.ajax ({
            url: "updateIssue.php",
            timeout: 3000,
            data: dataToPost,
            type: "POST",
            success: function(data) {
                if (data.includes('success')) {
                $('#modalEditIssue').modal('hide');
                $('#showIssueLog').trigger('click');  
                } else {
                    $('#issueRequestMessage').html(data);
                }
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
