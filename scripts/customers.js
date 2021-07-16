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

$('#modalAddNewCustomer').on('hidden.bs.modal', function(event) {
    $(this).find('form').trigger('reset');
    $('#customerMessage').html('');
});

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
    // dataToPost.customerCoRegNo = document.getElementById('customerRegNo').value;
    // dataToPost.customerVATRegNo = document.getElementById('customerVATNo').value;
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

function updateCustomerRenewal() {
    var dataToPost = {};
    dataToPost.customerRenewalType = document.getElementById('getRenewalTypeSelect').value;
    dataToPost.customerRenewalDate = document.getElementById('renewalDate').value;
    $.ajax({
        url: "updateCustomerRenewal.php",
        timeout: 30000,
        data: dataToPost,
        type: "POST",
        success: function() {
        },
        error: function() {    
        }
    })

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
    // dataToPost.customerRenewalType = document.getElementById('getRenewalTypeSelect').value;
    // dataToPost.customerRenewalDate = document.getElementById('renewalDate').value;
    // // dataToPost.customerRegNo = document.getElementById('custRegNumber').value;
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
        dataToPost.healthCheck = document.getElementById('contactHealthCheck').checked;

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